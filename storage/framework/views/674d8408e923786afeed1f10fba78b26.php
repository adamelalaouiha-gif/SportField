<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Espace Admin'); ?> - SportsField</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --primary: #2563eb; --primary-dark: #1e40af; --sidebar-bg: #0f172a; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f8fafc; }
        .sidebar { width: 260px; min-height: 100vh; background: var(--sidebar-bg); position: fixed; top: 0; left: 0; z-index: 100; }
        .sidebar-logo { padding: 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .logo-box { width: 38px; height: 38px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; }
        .sidebar-nav { padding: 16px 0; }
        .nav-link-item { display: flex; align-items: center; gap: 12px; padding: 12px 20px; color: #94a3b8; text-decoration: none; transition: all 0.2s; border-radius: 8px; margin: 2px 12px; font-size: 0.9rem; }
        .nav-link-item:hover { background: rgba(255,255,255,0.08); color: white; }
        .nav-link-item.active { background: var(--primary); color: white; }
        .nav-link-item i { font-size: 1.1rem; width: 20px; }
        .nav-section-title { padding: 16px 20px 8px; font-size: 0.7rem; text-transform: uppercase; color: #475569; letter-spacing: 1px; font-weight: 600; }
        .main-content { margin-left: 260px; min-height: 100vh; }
        .topbar { background: white; padding: 16px 30px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 99; }
        .page-content { padding: 30px; }
        .stat-card { background: white; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border: 1px solid #e5e7eb; }
        .stat-icon { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; }
        .table-card { background: white; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border: 1px solid #e5e7eb; }
        @media (max-width: 768px) { .sidebar { transform: translateX(-100%); } .main-content { margin-left: 0; } }
    </style>
    <?php echo $__env->yieldContent('head'); ?>
</head>
<body>
<div class="sidebar">
    <div class="sidebar-logo d-flex align-items-center gap-2">
        <div class="logo-box">SF</div>
        <div>
            <span class="fw-bold text-white">SportsField</span>
            <div class="text-muted" style="font-size:0.7rem;">Espace Admin Club</div>
        </div>
    </div>
    <div class="sidebar-nav">
        <div class="nav-section-title">Menu principal</div>
        <a href="<?php echo e(route('admin.accueil')); ?>" class="nav-link-item <?php echo e(request()->routeIs('admin.accueil') ? 'active' : ''); ?>">
            <i class="bi bi-speedometer2"></i> Tableau de bord
        </a>
        <a href="<?php echo e(route('admin.terrains')); ?>" class="nav-link-item <?php echo e(request()->routeIs('admin.terrains*') ? 'active' : ''); ?>">
            <i class="bi bi-geo"></i> Mes terrains
        </a>
        <a href="<?php echo e(route('admin.reservations')); ?>" class="nav-link-item <?php echo e(request()->routeIs('admin.reservations') ? 'active' : ''); ?>">
            <i class="bi bi-calendar-check"></i> Réservations
        </a>
        <a href="<?php echo e(route('admin.profil')); ?>" class="nav-link-item <?php echo e(request()->routeIs('admin.profil') ? 'active' : ''); ?>">
            <i class="bi bi-building"></i> Profil du club
        </a>
        <div class="nav-section-title mt-2">Compte</div>
        <form action="<?php echo e(route('logout')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="nav-link-item border-0 bg-transparent w-100 text-start text-danger">
                <i class="bi bi-box-arrow-right"></i> Déconnexion
            </button>
        </form>
    </div>
</div>

<div class="main-content">
    <div class="topbar">
        <div>
            <h6 class="mb-0 fw-bold"><?php echo $__env->yieldContent('page-title', 'Tableau de bord'); ?></h6>
            <small class="text-muted"><?php echo $__env->yieldContent('page-subtitle', ''); ?></small>
        </div>
        <div class="d-flex align-items-center gap-3">
            <?php if(session('success')): ?>
                <span class="badge bg-success"><i class="bi bi-check me-1"></i><?php echo e(session('success')); ?></span>
            <?php endif; ?>
            <div class="d-flex align-items-center gap-2">
                <div style="width:32px;height:32px;background:#e2e8f0;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#2563eb;">
                    <i class="bi bi-person-fill"></i>
                </div>
                <span class="fw-medium small"><?php echo e(auth()->user()->prenom); ?> <?php echo e(auth()->user()->nom); ?></span>
            </div>
        </div>
    </div>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible m-3"><?php echo e(session('error')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    <?php endif; ?>

    <div class="page-content">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\xamppp\htdocs\PF\resources\views/layouts/admin.blade.php ENDPATH**/ ?>