<?php

namespace App\Http\Controllers;

use App\Models\PasswordResetCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function loginForm()
    {
        if (Auth::check()) return $this->redirectByRole();
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => "L'adresse email est obligatoire.",
            'email.email'       => "L'adresse email n'est pas valide.",
            'password.required' => 'Le mot de passe est obligatoire.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Aucun compte trouvé avec cet email.'])->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Mot de passe incorrect.'])->withInput();
        }

        if (is_null($user->email_verified_at)) {
            $this->sendVerificationCode($user);
            return redirect()->route('verification.notice', ['email' => $user->email])
                ->with('info', "Votre email n'est pas encore vérifié. Un code vous a été envoyé.");
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();
        return $this->redirectByRole();
    }

    public function registerForm()
    {
        if (Auth::check()) return $this->redirectByRole();
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'prenom'   => 'required|string|max:255',
            'nom'      => 'required|string|max:255',
            'email'    => 'required|email|unique:utilisateurs,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'prenom.required'    => 'Le prénom est obligatoire.',
            'nom.required'       => 'Le nom est obligatoire.',
            'email.required'     => "L'adresse email est obligatoire.",
            'email.email'        => "L'adresse email n'est pas valide.",
            'email.unique'       => 'Cet email est déjà utilisé.',
            'password.required'  => 'Le mot de passe est obligatoire.',
            'password.min'       => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
        ]);

        $user = User::create([
            'prenom'   => $request->prenom,
            'nom'      => $request->nom,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'client',
        ]);

        $this->sendVerificationCode($user);

        return redirect()->route('verification.notice', ['email' => $user->email])
            ->with('success', 'Compte créé ! Vérifiez votre email pour activer votre compte.');
    }

    public function verificationNotice(Request $request)
    {
        $email = $request->query('email');
        return view('auth.verify-email', compact('email'));
    }

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code'  => 'required|string|size:6',
        ], [
            'code.required' => 'Le code de vérification est obligatoire.',
            'code.size'     => 'Le code doit contenir 6 chiffres.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email introuvable.']);
        }

        if ($user->verification_code !== $request->code) {
            return back()->withErrors(['code' => 'Code incorrect.'])->withInput();
        }

        if (now()->isAfter($user->verification_code_expires_at)) {
            return back()->withErrors(['code' => 'Ce code a expiré. Demandez-en un nouveau.'])->withInput();
        }

        $user->update([
            'email_verified_at'            => now(),
            'verification_code'            => null,
            'verification_code_expires_at' => null,
        ]);

        Auth::login($user);
        return redirect()->route('client.accueil')->with('success', 'Email vérifié ! Bienvenue sur SportsField !');
    }

    public function resendVerificationCode(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if (!$user) return back()->withErrors(['email' => 'Email introuvable.']);
        if (!is_null($user->email_verified_at)) return redirect()->route('login')->with('info', 'Votre email est déjà vérifié.');

        $this->sendVerificationCode($user);
        return back()->with('success', 'Un nouveau code a été envoyé.');
    }

    public function forgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function forgotPasswordSend(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:utilisateurs,email',
        ], [
            'email.required' => "L'adresse email est obligatoire.",
            'email.email'    => "L'adresse email n'est pas valide.",
            'email.exists'   => 'Aucun compte trouvé avec cet email.',
        ]);

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        PasswordResetCode::where('email', $request->email)->delete();
        PasswordResetCode::create([
            'email'      => $request->email,
            'code'       => $code,
            'expires_at' => now()->addMinutes(15),
        ]);

        $this->sendResetCode($request->email, $code);

        return redirect()->route('password.reset.form', ['email' => $request->email])
            ->with('success', 'Un code de réinitialisation a été envoyé à votre email.');
    }

    public function resetPasswordForm(Request $request)
    {
        $email = $request->query('email');
        return view('auth.reset-password', compact('email'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|exists:utilisateurs,email',
            'code'     => 'required|string|size:6',
            'password' => 'required|min:8|confirmed',
        ], [
            'code.required'      => 'Le code est obligatoire.',
            'code.size'          => 'Le code doit contenir 6 chiffres.',
            'password.required'  => 'Le mot de passe est obligatoire.',
            'password.min'       => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
        ]);

        $resetCode = PasswordResetCode::where('email', $request->email)
            ->where('code', $request->code)->first();

        if (!$resetCode) return back()->withErrors(['code' => 'Code incorrect.'])->withInput();
        if ($resetCode->isExpired()) {
            $resetCode->delete();
            return back()->withErrors(['code' => 'Ce code a expiré. Demandez-en un nouveau.'])->withInput();
        }

        User::where('email', $request->email)->first()->update(['password' => Hash::make($request->password)]);
        $resetCode->delete();

        return redirect()->route('login')->with('success', 'Mot de passe réinitialisé ! Connectez-vous.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('accueil');
    }

    private function redirectByRole()
    {
        return match (Auth::user()->role) {
            'super_admin' => redirect()->route('superadmin.accueil'),
            'admin'       => redirect()->route('admin.accueil'),
            default       => redirect()->route('client.accueil'),
        };
    }

    private function sendVerificationCode(User $user): void
    {
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->update([
            'verification_code'            => $code,
            'verification_code_expires_at' => now()->addMinutes(15),
        ]);
        Mail::raw(
            "Bonjour {$user->prenom},\n\nVotre code de vérification SportsField est : {$code}\n\nCe code expire dans 15 minutes.",
            fn($m) => $m->to($user->email)->subject("SportsField - Code : {$code}")
        );
    }

    private function sendResetCode(string $email, string $code): void
    {
        Mail::raw(
            "Votre code de réinitialisation SportsField est : {$code}\n\nCe code expire dans 15 minutes.",
            fn($m) => $m->to($email)->subject("SportsField - Réinitialisation : {$code}")
        );
    }
}
