<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'SportsField'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --primary-color: #2563eb; --primary-dark: #1e40af; --bg-color: #f8fafc; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: var(--bg-color); }
        .navbar { box-shadow: 0 1px 3px rgba(0,0,0,0.1); background: white; }
        .logo-box { width: 40px; height: 40px; background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.25rem; }
        .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); }
        .btn-primary:hover { background-color: var(--primary-dark); border-color: var(--primary-dark); }
        .user-avatar { width: 38px; height: 38px; background-color: #e2e8f0; color: var(--primary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
        footer { background-color: #0f172a; color: #cbd5e1; margin-top: 60px; }
        footer h5 { color: #fff; font-weight: 600; }
        footer a { color: #cbd5e1; text-decoration: none; transition: color 0.3s; }
        footer a:hover { color: var(--primary-color); }
        <?php echo $__env->yieldContent('styles'); ?>
    </style>
    <?php echo $__env->yieldContent('head'); ?>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?php echo e(route('accueil')); ?>">
            <div class="logo-box">SF</div>
            <span class="fw-bold fs-5">SportsField</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link <?php echo e(request()->routeIs('accueil') ? 'active fw-semibold text-primary' : ''); ?>" href="<?php echo e(route('accueil')); ?>">Accueil</a></li>
                <li class="nav-item"><a class="nav-link <?php echo e(request()->routeIs('clubs.*') ? 'active fw-semibold text-primary' : ''); ?>" href="<?php echo e(route('clubs.index')); ?>">Parcourir les clubs</a></li>
                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->user()->role === 'client'): ?>
                        <li class="nav-item"><a class="nav-link <?php echo e(request()->routeIs('client.reservations') ? 'active fw-semibold text-primary' : ''); ?>" href="<?php echo e(route('client.reservations')); ?>">Mes réservations</a></li>
                    <?php endif; ?>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link <?php echo e(request()->routeIs('apropos') ? 'active fw-semibold text-primary' : ''); ?>" href="<?php echo e(route('apropos')); ?>">À propos</a></li>
                <li class="nav-item"><a class="nav-link <?php echo e(request()->routeIs('contact') ? 'active fw-semibold text-primary' : ''); ?>" href="<?php echo e(route('contact')); ?>">Contact</a></li>
            </ul>
            <div class="d-flex gap-2 align-items-center">
                <?php if(auth()->guard()->check()): ?>
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none text-dark dropdown-toggle" data-bs-toggle="dropdown">
                            <div class="user-avatar"><i class="bi bi-person-fill"></i></div>
                            <span class="ms-2 fw-medium d-none d-md-inline"><?php echo e(auth()->user()->prenom); ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                            <?php if(auth()->user()->role === 'client'): ?>
                                <li><a class="dropdown-item py-2" href="<?php echo e(route('client.profil')); ?>"><i class="bi bi-person me-2"></i>Mon profil</a></li>
                                <li><a class="dropdown-item py-2" href="<?php echo e(route('client.reservations')); ?>"><i class="bi bi-calendar-check me-2"></i>Mes réservations</a></li>
                            <?php elseif(auth()->user()->role === 'admin'): ?>
                                <li><a class="dropdown-item py-2" href="<?php echo e(route('admin.accueil')); ?>"><i class="bi bi-speedometer2 me-2"></i>Mon espace club</a></li>
                            <?php elseif(auth()->user()->role === 'super_admin'): ?>
                                <li><a class="dropdown-item py-2" href="<?php echo e(route('superadmin.accueil')); ?>"><i class="bi bi-shield-check me-2"></i>Administration</a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="<?php echo e(route('logout')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button class="dropdown-item py-2 text-danger"><i class="bi bi-box-arrow-right me-2"></i>Déconnexion</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="<?php echo e(route('visiteur.demande')); ?>" class="btn btn-light border fw-semibold d-none d-lg-inline-flex align-items-center gap-2 me-2">
                        <i class="bi bi-building-add text-primary"></i> Ajouter mon club
                    </a>
                    <div class="vr d-none d-lg-block text-secondary mx-1"></div>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-primary d-none d-md-inline">Connexion</a>
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-primary">Inscription</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
        <i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
        <i class="bi bi-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php echo $__env->yieldContent('content'); ?>

<footer class="py-5">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-md-6 mb-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="logo-box">SF</div>
                    <span class="fw-bold fs-5 text-white">SportsField</span>
                </div>
                <p class="small w-75">Votre plateforme de confiance pour réserver des terrains de clubs sportifs dans toute Kénitra.</p>
            </div>
            <div class="col-md-4 mb-4 text-md-end">
                <h5 class="mb-3">Navigation</h5>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="<?php echo e(route('accueil')); ?>">Accueil</a></li>
                    <li class="mb-2"><a href="<?php echo e(route('clubs.index')); ?>">Parcourir les clubs</a></li>
                    <li class="mb-2"><a href="<?php echo e(route('apropos')); ?>">À propos</a></li>
                    <li class="mb-2"><a href="<?php echo e(route('contact')); ?>">Contact</a></li>
                </ul>
            </div>
        </div>
        <hr class="my-4 border-secondary opacity-25">
        <div class="text-center small">
            <p class="mb-0">&copy; <?php echo e(date('Y')); ?> SportsField. Tous droits réservés.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\xamppp\htdocs\PF\resources\views/layouts/app.blade.php ENDPATH**/ ?>