<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe - SportsField</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --primary-color: #2563eb; --primary-dark: #1e40af; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .card-box { background: white; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); padding: 40px; max-width: 480px; width: 100%; }
        .logo-box { width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.5rem; margin: 0 auto 20px; }
        .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); padding: 12px; font-weight: 600; }
        .btn-primary:hover { background-color: var(--primary-dark); border-color: var(--primary-dark); }
        .code-input { letter-spacing: 8px; font-size: 1.5rem; font-weight: bold; text-align: center; }
        .form-control:focus { border-color: var(--primary-color); box-shadow: 0 0 0 0.2rem rgba(37,99,235,0.25); }
        .password-toggle { cursor: pointer; color: #6b7280; }
        .icon-circle { width: 80px; height: 80px; background: rgba(37,99,235,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 2.5rem; color: var(--primary-color); }
    </style>
</head>
<body>
<div class="card-box">
    <div class="text-center">
        <div class="logo-box">SF</div>
        <div class="icon-circle"><i class="bi bi-shield-lock"></i></div>
        <h3 class="fw-bold mb-2">Nouveau mot de passe</h3>
        <p class="text-muted mb-4">Entrez le code reçu par email et choisissez un nouveau mot de passe.</p>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('password.reset')); ?>">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="email" value="<?php echo e($email); ?>">

        <div class="mb-3">
            <label class="form-label fw-semibold">Code reçu par email</label>
            <input type="text" name="code" class="form-control code-input"
                   placeholder="______" maxlength="6" value="<?php echo e(old('code')); ?>" required autocomplete="off">
            <div class="form-text">Code valable 15 minutes.</div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Nouveau mot de passe</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" id="pwd1" class="form-control border-start-0 border-end-0"
                       placeholder="" required minlength="8">
                <span class="input-group-text bg-light border-start-0 password-toggle" onclick="togglePwd('pwd1','ic1')">
                    <i class="bi bi-eye" id="ic1"></i>
                </span>
            </div>
            <div class="form-text">8 caractères minimum.</div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Confirmer le mot de passe</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-shield-lock"></i></span>
                <input type="password" name="password_confirmation" id="pwd2"
                       class="form-control border-start-0 border-end-0" placeholder="" required>
                <span class="input-group-text bg-light border-start-0 password-toggle" onclick="togglePwd('pwd2','ic2')">
                    <i class="bi bi-eye" id="ic2"></i>
                </span>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3">
            <i class="bi bi-check-circle me-2"></i>Réinitialiser le mot de passe
        </button>
    </form>

    <div class="text-center mt-2">
        <a href="<?php echo e(route('password.forgot')); ?>" class="text-decoration-none text-muted small me-3">
            <i class="bi bi-arrow-clockwise me-1"></i>Nouveau code
        </a>
        <a href="<?php echo e(route('login')); ?>" class="text-decoration-none text-muted small">
            <i class="bi bi-arrow-left me-1"></i>Connexion
        </a>
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
document.querySelector('.code-input').addEventListener('input', function() {
    this.value = this.value.replace(/[^0-9]/g, '');
});
</script>
</body>
</html>
<?php /**PATH D:\xamppp\htdocs\PF\resources\views/auth/reset-password.blade.php ENDPATH**/ ?>