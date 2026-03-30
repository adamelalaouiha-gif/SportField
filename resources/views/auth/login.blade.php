<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - SportsField</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --primary-color: #2563eb; --primary-dark: #1e40af; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .login-card { background: white; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); overflow: hidden; max-width: 1000px; width: 100%; }
        .login-left { background: linear-gradient(135deg, rgba(37,99,235,0.95), rgba(30,64,175,0.95)), url('https://images.unsplash.com/photo-1545255678-30015d3842b0?w=1080') center/cover; color: white; padding: 3rem; display: flex; flex-direction: column; justify-content: center; }
        .login-right { padding: 3rem; }
        .logo-box { width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.75rem; margin: 0 auto 1rem; }
        .form-control:focus { border-color: var(--primary-color); box-shadow: 0 0 0 0.2rem rgba(37,99,235,0.25); }
        .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); padding: 12px; font-weight: 600; }
        .btn-primary:hover { background-color: var(--primary-dark); border-color: var(--primary-dark); }
        .feature-item { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; }
        .feature-icon { width: 48px; height: 48px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
        .password-toggle { cursor: pointer; color: #6b7280; }
        @media (max-width: 768px) { .login-left { display: none; } .login-right { padding: 2rem; } }
    </style>
</head>
<body>
<div class="login-card">
    <div class="row g-0">
        <div class="col-md-5 login-left">
            <div>
                <div class="logo-box">SF</div>
                <h2 class="text-center fw-bold mb-4">Bienvenue sur SportsField</h2>
                <p class="text-center mb-5 opacity-75">Réservez facilement vos terrains de sport préférés</p>
                <div class="feature-item">
                    <div class="feature-icon"><i class="bi bi-search"></i></div>
                    <div><h5 class="mb-1">Recherche facile</h5><p class="mb-0 small opacity-75">Trouvez le terrain parfait près de chez vous</p></div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="bi bi-calendar-check"></i></div>
                    <div><h5 class="mb-1">Réservation instantanée</h5><p class="mb-0 small opacity-75">Réservez en quelques clics seulement</p></div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                    <div><h5 class="mb-1">Paiement sécurisé</h5><p class="mb-0 small opacity-75">Vos données sont protégées</p></div>
                </div>
            </div>
        </div>
        <div class="col-md-7 login-right">
            <h2 class="fw-bold mb-2">Connexion</h2>
            <p class="text-muted mb-4">Connectez-vous pour accéder à votre compte</p>

            @if(session('success'))
                <div class="alert alert-success"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
            @endif
            @if(session('info'))
                <div class="alert alert-info"><i class="bi bi-info-circle me-2"></i>{{ session('info') }}</div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" novalidate>
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Adresse email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email"
                               class="form-control border-start-0 @error('email') is-invalid @enderror"
                               placeholder="votre@email.com" value="{{ old('email') }}" required>
                    </div>
                    @error('email')<div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" id="password"
                               class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror"
                               placeholder="••••••••" required>
                        <span class="input-group-text bg-light border-start-0 password-toggle" onclick="togglePwd()">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </span>
                    </div>
                    @error('password')<div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>@enderror
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label small" for="remember">Se souvenir de moi</label>
                    </div>
                    <a href="{{ route('password.forgot') }}" class="text-decoration-none small text-primary">
                        <i class="bi bi-question-circle me-1"></i>Mot de passe oublié ?
                    </a>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-3">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                </button>
                <p class="text-center text-muted small mb-0">
                    Pas encore de compte ? <a href="{{ route('register') }}" class="text-decoration-none fw-semibold text-primary">Créer un compte</a>
                </p>
            </form>
            <hr class="my-4">
            <div class="text-center">
                <a href="{{ route('accueil') }}" class="text-decoration-none text-muted small">
                    <i class="bi bi-arrow-left"></i> Retour à l'accueil
                </a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePwd() {
    const p = document.getElementById('password');
    const i = document.getElementById('toggleIcon');
    p.type = p.type === 'password' ? 'text' : 'password';
    i.className = p.type === 'text' ? 'bi bi-eye-slash' : 'bi bi-eye';
}
</script>
</body>
</html>
