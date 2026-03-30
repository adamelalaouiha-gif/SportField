<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - SportsField</title>
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
                <h2 class="text-center fw-bold mb-4">Rejoignez SportsField</h2>
                <p class="text-center mb-5 opacity-75">Créez votre compte et commencez à réserver dès aujourd'hui</p>
                <div class="feature-item">
                    <div class="feature-icon"><i class="bi bi-search"></i></div>
                    <div><h5 class="mb-1">Recherche facile</h5><p class="mb-0 small opacity-75">Trouvez le terrain parfait près de chez vous</p></div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="bi bi-calendar-check"></i></div>
                    <div><h5 class="mb-1">Réservation instantanée</h5><p class="mb-0 small opacity-75">Réservez en quelques clics seulement</p></div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="bi bi-envelope-check"></i></div>
                    <div><h5 class="mb-1">Email vérifié</h5><p class="mb-0 small opacity-75">Votre compte est sécurisé par vérification email</p></div>
                </div>
            </div>
        </div>
        <div class="col-md-7 login-right">
            <h2 class="fw-bold mb-2">Créer un compte</h2>
            <p class="text-muted mb-4">Remplissez les informations ci-dessous pour vous inscrire</p>

            <form method="POST" action="<?php echo e(route('register.post')); ?>" novalidate>
                <?php echo csrf_field(); ?>
                <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label class="form-label fw-semibold">Prénom</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-person"></i></span>
                            <input type="text" name="prenom"
                                   class="form-control border-start-0 <?php $__errorArgs = ['prenom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="Jean" value="<?php echo e(old('prenom')); ?>" required>
                        </div>
                        <?php $__errorArgs = ['prenom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nom</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-person"></i></span>
                            <input type="text" name="nom"
                                   class="form-control border-start-0 <?php $__errorArgs = ['nom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="Dupont" value="<?php echo e(old('nom')); ?>" required>
                        </div>
                        <?php $__errorArgs = ['nom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Adresse email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email"
                               class="form-control border-start-0 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="votre@email.com" value="<?php echo e(old('email')); ?>" required>
                    </div>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" id="pwd1"
                               class="form-control border-start-0 border-end-0 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="••••••••" required minlength="8">
                        <span class="input-group-text bg-light border-start-0 password-toggle" onclick="togglePwd('pwd1','ic1')">
                            <i class="bi bi-eye" id="ic1"></i>
                        </span>
                    </div>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="form-text">8 caractères minimum.</div>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Confirmer le mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-shield-lock"></i></span>
                        <input type="password" name="password_confirmation" id="pwd2"
                               class="form-control border-start-0 border-end-0"
                               placeholder="••••••••" required>
                        <span class="input-group-text bg-light border-start-0 password-toggle" onclick="togglePwd('pwd2','ic2')">
                            <i class="bi bi-eye" id="ic2"></i>
                        </span>
                    </div>
                </div>
                <div class="alert alert-info py-2 small">
                    <i class="bi bi-envelope-check me-2"></i>Un code de vérification sera envoyé à votre email après l'inscription.
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-3 mt-2">
                    <i class="bi bi-person-plus me-2"></i>Créer mon compte
                </button>
                <p class="text-center text-muted small mb-0">
                    Déjà un compte ? <a href="<?php echo e(route('login')); ?>" class="text-decoration-none fw-semibold text-primary">Se connecter</a>
                </p>
            </form>
            <hr class="my-4">
            <div class="text-center">
                <a href="<?php echo e(route('accueil')); ?>" class="text-decoration-none text-muted small">
                    <i class="bi bi-arrow-left"></i> Retour à l'accueil
                </a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePwd(id, iconId) {
    const p = document.getElementById(id);
    const i = document.getElementById(iconId);
    p.type = p.type === 'password' ? 'text' : 'password';
    i.className = p.type === 'text' ? 'bi bi-eye-slash' : 'bi bi-eye';
}
</script>
</body>
</html>
<?php /**PATH D:\xamppp\htdocs\PF\resources\views/auth/register.blade.php ENDPATH**/ ?>