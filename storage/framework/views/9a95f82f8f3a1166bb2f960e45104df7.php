<?php $__env->startSection('title', 'Super Admin'); ?>
<?php $__env->startSection('page-title', 'Tableau de bord Super Admin'); ?>
<?php $__env->startSection('content'); ?>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show mb-4">
        <i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show mb-4">
        <i class="bi bi-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div><p class="text-muted small mb-1">Utilisateurs</p><h3 class="fw-bold mb-0"><?php echo e($stats['utilisateurs']); ?></h3></div>
                <div class="stat-icon" style="background:#dbeafe;color:#2563eb;"><i class="bi bi-people"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div><p class="text-muted small mb-1">Clubs actifs</p><h3 class="fw-bold mb-0"><?php echo e($stats['clubs']); ?></h3></div>
                <div class="stat-icon" style="background:#dcfce7;color:#16a34a;"><i class="bi bi-building"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div><p class="text-muted small mb-1">Demandes en attente</p><h3 class="fw-bold mb-0"><?php echo e($stats['demandes']); ?></h3></div>
                <div class="stat-icon" style="background:#fef9c3;color:#ca8a04;"><i class="bi bi-inbox"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div><p class="text-muted small mb-1">Réservations</p><h3 class="fw-bold mb-0"><?php echo e($stats['reservations']); ?></h3></div>
                <div class="stat-icon" style="background:#fce7f3;color:#db2777;"><i class="bi bi-calendar-check"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0"><i class="bi bi-inbox me-2 text-warning"></i>Demandes en attente</h5>
        <a href="<?php echo e(route('superadmin.demandes')); ?>" class="btn btn-outline-primary btn-sm">Voir tout</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr><th>Club</th><th>Responsable</th><th>Sports</th><th>Date</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $demandes_recentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="fw-medium"><?php echo e($d->nom_club); ?></div>
                        <small class="text-muted"><?php echo e($d->adresse); ?></small>
                    </td>
                    <td>
                        <?php echo e($d->prenom_responsable); ?> <?php echo e($d->nom_responsable); ?><br>
                        <small class="text-muted"><?php echo e($d->email_responsable); ?></small>
                    </td>
                    <td>
                        <?php $__currentLoopData = is_array($d->sports) ? $d->sports : json_decode($d->sports, true) ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="badge bg-light text-dark border me-1"><?php echo e($s); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                    <td><?php echo e($d->created_at->format('d/m/Y')); ?></td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="<?php echo e(route('superadmin.demande.show', $d->id)); ?>" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye me-1"></i>Voir
                            </a>
                            <form method="POST" action="<?php echo e(route('superadmin.demande.approuver', $d->id)); ?>">
                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                <button type="submit" class="btn btn-success btn-sm"
                                        onclick="return confirm('Approuver ce club ?')">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </form>
                            <form method="POST" action="<?php echo e(route('superadmin.demande.rejeter', $d->id)); ?>">
                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Rejeter cette demande ?')">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" class="text-center py-4 text-muted">Aucune demande en attente</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.superadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xamppp\htdocs\PF\resources\views/EspaceSuperAdmin/acceuil.blade.php ENDPATH**/ ?>