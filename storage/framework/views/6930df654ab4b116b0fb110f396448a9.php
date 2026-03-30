<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Super Admin'); ?> - SportsField</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --primary: #2563eb; --sidebar-bg: #1e1b4b; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f8fafc; }
        .sidebar { width: 260px; min-height: 100vh; background: var(--sidebar-bg); position: fixed; top: 0; left: 0; z-index: 100; }
        .sidebar-logo { padding: 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .logo-box { width: 38px; height: 38px; background: linear-gradient(135deg, #7c3aed, #4f46e5); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; }
        .sidebar-nav { padding: 16px 0; }
        .nav-link-item { display: flex; align-items: center; gap: 12px; padding: 12px 20px; color: #a5b4fc; text-decoration: none; transition: all 0.2s; border-radius: 8px; margin: 2px 12px; font-size: 0.9rem; }
        .nav-link-item:hover { background: rgba(255,255,255,0.08); color: white; }
        .nav-link-item.active { background: #4f46e5; color: white; }
        .nav-link-item i { font-size: 1.1rem; width: 20px; }
        .nav-section-title { padding: 16px 20px 8px; font-size: 0.7rem; text-transform: uppercase; color: #6366f1; letter-spacing: 1px; font-weight: 600; }
        .main-content { margin-left: 260px; min-height: 100vh; }
        .topbar { background: white; padding: 16px 30px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 99; }
        .page-content { padding: 30px; }
        .stat-card { background: white; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border: 1px solid #e5e7eb; }
        .stat-icon { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; }
        .table-card { background: white; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border: 1px solid #e5e7eb; }
    </style>
    <?php echo $__env->yieldContent('head'); ?>
</head>
<body>
<div class="sidebar">
    <div class="sidebar-logo d-flex align-items-center gap-2">
        <div class="logo-box">SA</div>
        <div>
            <span class="fw-bold text-white">SportsField</span>
            <div style="font-size:0.7rem;color:#a5b4fc;">Super Administrateur</div>
        </div>
    </div>
    <div class="sidebar-nav">
        <div class="nav-section-title">Administration</div>
        <a href="<?php echo e(route('superadmin.accueil')); ?>" class="nav-link-item <?php echo e(request()->routeIs('superadmin.accueil') ? 'active' : ''); ?>">
            <i class="bi bi-speedometer2"></i> Tableau de bord
        </a>
        <a href="<?php echo e(route('superadmin.demandes')); ?>" class="nav-link-item <?php echo e(request()->routeIs('superadmin.demandes') ? 'active' : ''); ?>">
            <i class="bi bi-inbox"></i> Demandes clubs
            <?php if(isset($nb_demandes) && $nb_demandes > 0): ?>
                <span class="badge bg-danger ms-auto"><?php echo e($nb_demandes); ?></span>
            <?php endif; ?>
        </a>
        <a href="<?php echo e(route('superadmin.clubs')); ?>" class="nav-link-item <?php echo e(request()->routeIs('superadmin.clubs') ? 'active' : ''); ?>">
            <i class="bi bi-building"></i> Gestion clubs
        </a>
        <a href="<?php echo e(route('superadmin.utilisateurs')); ?>" class="nav-link-item <?php echo e(request()->routeIs('superadmin.utilisateurs') ? 'active' : ''); ?>">
            <i class="bi bi-people"></i> Utilisateurs
        </a>
        <a href="<?php echo e(route('superadmin.reservations')); ?>" class="nav-link-item <?php echo e(request()->routeIs('superadmin.reservations') ? 'active' : ''); ?>">
            <i class="bi bi-calendar-check"></i> Réservations
        </a>
        <div class="nav-section-title mt-2">Compte</div>
        <form action="<?php echo e(route('logout')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="nav-link-item border-0 bg-transparent w-100 text-start" style="color:#f87171;">
                <i class="bi bi-box-arrow-right"></i> Déconnexion
            </button>
        </form>
    </div>
</div>

<div class="main-content">
    <div class="topbar">
        <h6 class="mb-0 fw-bold"><?php echo $__env->yieldContent('page-title', 'Tableau de bord'); ?></h6>
        <div class="d-flex align-items-center gap-2">
            <?php if(session('success')): ?>
                <span class="badge bg-success"><?php echo e(session('success')); ?></span>
            <?php endif; ?>
            <span class="fw-medium small"><?php echo e(auth()->user()->prenom); ?> <?php echo e(auth()->user()->nom); ?></span>
            <span class="badge bg-purple" style="background:#7c3aed!important;">Super Admin</span>
        </div>
    </div>

    <?php if(session('error')): ?>
        <div class="alert alert-danger m-3"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <div class="page-content">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\xamppp\htdocs\PF\resources\views/layouts/superadmin.blade.php ENDPATH**/ ?>