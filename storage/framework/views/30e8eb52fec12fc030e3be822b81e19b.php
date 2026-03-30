<?php $__env->startSection('title', 'Réservations'); ?>
<?php $__env->startSection('page-title', 'Toutes les réservations'); ?>
<?php $__env->startSection('content'); ?>

<div class="table-card">
    <div class="mb-4">
        <form method="GET" class="d-flex gap-2">
            <select name="statut" class="form-select w-auto" onchange="this.form.submit()">
                <option value="">Tous les statuts</option>
                <option value="en_attente" <?php echo e(request('statut') === 'en_attente' ? 'selected' : ''); ?>>En attente</option>
                <option value="terminée" <?php echo e(request('statut') === 'terminée' ? 'selected' : ''); ?>>Terminée</option>
                <option value="annulée" <?php echo e(request('statut') === 'annulée' ? 'selected' : ''); ?>>Annulée</option>
                <option value="non_venue" <?php echo e(request('statut') === 'non_venue' ? 'selected' : ''); ?>>Non venue</option>
            </select>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr><th>Client</th><th>Club / Terrain</th><th>Date</th><th>Horaire</th><th>Montant</th><th>Statut</th></tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="fw-medium"><?php echo e($r->visiteur->prenom); ?> <?php echo e($r->visiteur->nom); ?></div>
                        <small class="text-muted"><?php echo e($r->visiteur->email); ?></small>
                    </td>
                    <td>
                        <div><?php echo e($r->terrain->club->nom); ?></div>
                        <small class="text-muted"><?php echo e($r->terrain->nom); ?></small>
                    </td>
                    <td><?php echo e(\Carbon\Carbon::parse($r->date_reservation)->format('d/m/Y')); ?></td>
                    <td><?php echo e(substr($r->heure_debut,0,5)); ?> - <?php echo e(substr($r->heure_fin,0,5)); ?></td>
                    <td class="fw-bold"><?php echo e(number_format($r->montant,0)); ?> DH</td>
                    <td>
                        <?php $badges = ['en_attente'=>'warning','terminée'=>'success','annulée'=>'danger','non_venue'=>'secondary']; ?>
                        <span class="badge bg-<?php echo e($badges[$r->statut_reservation] ?? 'secondary'); ?>"><?php echo e(ucfirst(str_replace('_',' ',$r->statut_reservation))); ?></span>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="text-center py-5 text-muted">Aucune réservation trouvée</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-3"><?php echo e($reservations->withQueryString()->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.superadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xamppp\htdocs\PF\resources\views/EspaceSuperAdmin/reservations.blade.php ENDPATH**/ ?>