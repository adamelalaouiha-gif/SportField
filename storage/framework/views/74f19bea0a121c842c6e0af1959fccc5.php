<?php $__env->startSection('title', 'Tableau de bord'); ?>
<?php $__env->startSection('page-title', 'Tableau de bord'); ?>
<?php $__env->startSection('page-subtitle', 'Bienvenue, ' . auth()->user()->prenom); ?>
<?php $__env->startSection('content'); ?>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted small mb-1">Total terrains</p>
                    <h3 class="fw-bold mb-0"><?php echo e($stats['terrains']); ?></h3>
                </div>
                <div class="stat-icon" style="background:#dbeafe;color:#2563eb;"><i class="bi bi-geo"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted small mb-1">Réservations totales</p>
                    <h3 class="fw-bold mb-0"><?php echo e($stats['reservations']); ?></h3>
                </div>
                <div class="stat-icon" style="background:#dcfce7;color:#16a34a;"><i class="bi bi-calendar-check"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted small mb-1">En attente</p>
                    <h3 class="fw-bold mb-0"><?php echo e($stats['en_attente']); ?></h3>
                </div>
                <div class="stat-icon" style="background:#fef9c3;color:#ca8a04;"><i class="bi bi-hourglass-split"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="text-muted small mb-1">Revenus (DH)</p>
                    <h3 class="fw-bold mb-0"><?php echo e(number_format($stats['revenus'], 0)); ?></h3>
                </div>
                <div class="stat-icon" style="background:#fce7f3;color:#db2777;"><i class="bi bi-cash-stack"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">Réservations récentes</h5>
        <a href="<?php echo e(route('admin.reservations')); ?>" class="btn btn-outline-primary btn-sm">Voir tout</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Client</th>
                    <th>Terrain</th>
                    <th>Date</th>
                    <th>Horaire</th>
                    <th>Montant</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $reservations_recentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="fw-medium"><?php echo e($r->visiteur->prenom); ?> <?php echo e($r->visiteur->nom); ?></div>
                        <small class="text-muted"><?php echo e($r->visiteur->email); ?></small>
                    </td>
                    <td><?php echo e($r->terrain->nom); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($r->date_reservation)->format('d/m/Y')); ?></td>
                    <td><?php echo e(substr($r->heure_debut,0,5)); ?> - <?php echo e(substr($r->heure_fin,0,5)); ?></td>
                    <td class="fw-bold"><?php echo e(number_format($r->montant,0)); ?> DH</td>
                    <td>
                        <?php $badges = ['en_attente'=>'warning','terminée'=>'success','annulée'=>'danger','non_venue'=>'secondary']; ?>
                        <span class="badge bg-<?php echo e($badges[$r->statut_reservation] ?? 'secondary'); ?>"><?php echo e(ucfirst(str_replace('_',' ',$r->statut_reservation))); ?></span>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">Aucune réservation</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xamppp\htdocs\PF\resources\views/EspaceAdmin/acceuil.blade.php ENDPATH**/ ?>