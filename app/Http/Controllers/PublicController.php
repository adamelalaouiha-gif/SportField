<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Demande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PublicController extends Controller
{
    public function accueil()
    {
        $clubs = Club::latest()->take(6)->get();
        return view('Visiteur.accueil', compact('clubs'));
    }

    public function clubs(Request $request)
    {
        $query = Club::query();
        if ($request->filled('q')) $query->where('nom', 'like', '%' . $request->q . '%');
        if ($request->filled('ville')) $query->where('adresse', 'like', '%' . $request->ville . '%');
        if ($request->filled('sport')) $query->whereJsonContains('sports', $request->sport);
        $clubs = $query->latest()->paginate(9);
        return view('Visiteur.listesClubs', compact('clubs'));
    }

    public function clubShow($id)
    {
        $club = Club::with('terrains')->findOrFail($id);
        return view('Visiteur.profileClub', compact('club'));
    }

    public function apropos() { return view('Visiteur.Apropos'); }
    public function contact() { return view('Visiteur.contact'); }
    public function demandeForm() { return view('Visiteur.EnvoiDemande'); }

    public function demandePost(Request $request)
    {
        $request->validate([
            'prenom_responsable'       => 'required|string|max:255',
            'nom_responsable'          => 'required|string|max:255',
            'email_responsable'        => [
                'required',
                'email',
                'unique:demandes,email_responsable',
                'unique:utilisateurs,email',
            ],
            'mot_de_passe_responsable' => 'required|min:8',
            'nom_club'                 => 'required|string|max:255',
            'description'              => 'required|string|min:20',
            'telephone_club'           => [
                'required',
                'string',
                'regex:/^(\+212|0)([ \-]?[0-9]){9}$/',
            ],
            'adresse'                  => 'required|string|max:255',
            'sports'                   => 'required|array|min:1',
            'photo'                    => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'prenom_responsable.required'        => 'Le prénom est obligatoire.',
            'nom_responsable.required'           => 'Le nom est obligatoire.',
            'email_responsable.required'         => "L'email est obligatoire.",
            'email_responsable.email'            => "L'adresse email n'est pas valide.",
            'email_responsable.unique'           => 'Cet email est déjà utilisé. Utilisez un autre email.',
            'mot_de_passe_responsable.required'  => 'Le mot de passe est obligatoire.',
            'mot_de_passe_responsable.min'       => 'Le mot de passe doit contenir au moins 8 caractères.',
            'nom_club.required'                  => 'Le nom du club est obligatoire.',
            'description.required'               => 'La description est obligatoire.',
            'description.min'                    => 'La description doit contenir au moins 20 caractères.',
            'telephone_club.required'            => 'Le numéro de téléphone est obligatoire.',
            'telephone_club.regex'               => 'Le numéro doit être un numéro marocain valide (ex: 0612345678 ou +212612345678).',
            'adresse.required'                   => "L'adresse est obligatoire.",
            'sports.required'                    => 'Sélectionnez au moins un sport.',
            'photo.required'                     => 'La photo du club est obligatoire.',
            'photo.image'                        => 'Le fichier doit être une image.',
            'photo.mimes'                        => 'Format accepté : JPG, PNG.',
            'photo.max'                          => 'La photo ne doit pas dépasser 2 Mo.',
        ]);

        // Validation des horaires : si ouverture remplie, fermeture obligatoire (et vice versa)
        $errorsHoraires = [];
        if ($request->horaires) {
            foreach ($request->horaires as $jour => $heures) {
                $ouv = !empty($heures['ouverture']);
                $fer = !empty($heures['fermeture']);
                if ($ouv && !$fer) {
                    $errorsHoraires["horaires.$jour.fermeture"] = "Veuillez indiquer l'heure de fermeture pour $jour.";
                } elseif (!$ouv && $fer) {
                    $errorsHoraires["horaires.$jour.ouverture"] = "Veuillez indiquer l'heure d'ouverture pour $jour.";
                } elseif ($ouv && $fer) {
                    // 00:00 fermeture = minuit fin de journée → toujours valide
                    $tOuv = strtotime($heures['ouverture']);
                    $tFer = ($heures['fermeture'] === '00:00') ? strtotime('+1 day', strtotime('00:00')) : strtotime($heures['fermeture']);
                    if ($tOuv >= $tFer) {
                        $errorsHoraires["horaires.$jour.fermeture"] = "L'heure de fermeture de $jour doit être après l'heure d'ouverture.";
                    }
                }
            }
        }
        if (!empty($errorsHoraires)) {
            return back()->withErrors($errorsHoraires)->withInput();
        }

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('demandes', 'public');
        }

        // Traitement des horaires
        $horaires = [];
        if ($request->horaires) {
            foreach ($request->horaires as $jour => $heures) {
                if (!empty($heures['ouverture']) && !empty($heures['fermeture'])) {
                    $horaires[$jour] = ['ouverture' => $heures['ouverture'], 'fermeture' => $heures['fermeture']];
                }
            }
        }

        Demande::create([
            'prenom_responsable'       => $request->prenom_responsable,
            'nom_responsable'          => $request->nom_responsable,
            'email_responsable'        => $request->email_responsable,
            'mot_de_passe_responsable' => Hash::make($request->mot_de_passe_responsable),
            'nom_club'                 => $request->nom_club,
            'description'              => $request->description,
            'telephone_club'           => $request->telephone_club,
            'adresse'                  => $request->adresse,
            'sports'                   => $request->sports,
            'horaires'                 => $horaires,
            'photos'                   => $photoPath,
            'statut_demande'           => 'en_attente',
        ]);

        return redirect()->route('accueil')
            ->with('success', 'Votre demande a été envoyée ! Nous vous contacterons sous 24-48h.');
    }
}
