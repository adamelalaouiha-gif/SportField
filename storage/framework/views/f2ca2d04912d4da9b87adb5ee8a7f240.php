<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié - SportsField</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --primary-color: #2563eb; --primary-dark: #1e40af; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .card-box { background: white; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); padding: 40px; max-width: 480px; width: 100%; }
        .logo-box { width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.5rem; margin: 0 auto 20px; }
        .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); padding: 12px; font-weight: 600; }
        .btn-primary:hover { background-color: var(--primary-dark); border-color: var(--primary-dark); }
        .icon-circle { width: 80px; height: 80px; background: rgba(37,99,235,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 2.5rem; color: var(--primary-color); }
        .form-control:focus { border-color: var(--primary-color); box-shadow: 0 0 0 0.2rem rgba(37,99,235,0.25); }
    </style>
</head>
<body>
<div class="card-box text-center">
    <div class="logo-box">SF</div>
    <div class="icon-circle"><i class="bi bi-lock"></i></div>
    <h3 class="fw-bold mb-2">Mot de passe oublié ?</h3>
    <p class="text-muted mb-4">Entrez votre adresse email et nous vous enverrons un code pour réinitialiser votre mot de passe.</p>

    <?php if(session('success')): ?>
        <div class="alert alert-success text-start"><i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if($errors->any()): ?>
        <div class="alert alert-danger text-start">
            <ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('password.forgot.send')); ?>" class="text-start">
        <?php echo csrf_field(); ?>
        <div class="mb-4">
            <label class="form-label fw-semibold">Adresse email</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" class="form-control border-start-0"
                       placeholder="votre@email.com" value="<?php echo e(old('email')); ?>" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100 mb-3">
            <i class="bi bi-send me-2"></i>Envoyer le code
        </button>
    </form>

    <div class="text-center mt-3">
        <a href="<?php echo e(route('login')); ?>" class="text-decoration-none text-muted small">
            <i class="bi bi-arrow-left me-1"></i>Retour à la connexion
        </a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH D:\xamppp\htdocs\PF\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>