<?php $__env->startSection('title', 'Réservations'); ?>
<?php $__env->startSection('page-title', 'Réservations'); ?>
<?php $__env->startSection('page-subtitle', 'Toutes les réservations de votre club'); ?>
<?php $__env->startSection('content'); ?>

<div class="table-card">
    <div class="row g-3 mb-4">
        <form method="GET" class="d-flex gap-2 flex-wrap">
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
                <tr>
                    <th>Client</th>
                    <th>Terrain</th>
                    <th>Date</th>
                    <th>Horaire</th>
                    <th>Montant</th>
                    <th>Paiement</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
                        <span class="badge <?php echo e($r->statut_paiements === 'paye' ? 'bg-success' : 'bg-warning text-dark'); ?>">
                            <?php echo e($r->statut_paiements === 'paye' ? 'Payé' : 'En attente'); ?>

                        </span>
                    </td>
                    <td>
                        <?php $badges = ['en_attente'=>'warning','terminée'=>'success','annulée'=>'danger','non_venue'=>'secondary']; ?>
                        <span class="badge bg-<?php echo e($badges[$r->statut_reservation] ?? 'secondary'); ?>"><?php echo e(ucfirst(str_replace('_',' ',$r->statut_reservation))); ?></span>
                    </td>
                    <td>
                        <form method="POST" action="<?php echo e(route('admin.reservation.statut', $r->id)); ?>" class="d-flex gap-1">
                            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                            <select name="statut" class="form-select form-select-sm" style="width:auto;">
                                <option value="en_attente" <?php echo e($r->statut_reservation === 'en_attente' ? 'selected' : ''); ?>>En attente</option>
                                <option value="terminée" <?php echo e($r->statut_reservation === 'terminée' ? 'selected' : ''); ?>>Terminée</option>
                                <option value="non_venue" <?php echo e($r->statut_reservation === 'non_venue' ? 'selected' : ''); ?>>Non venue</option>
                                <option value="annulée" <?php echo e($r->statut_reservation === 'annulée' ? 'selected' : ''); ?>>Annulée</option>
                            </select>
                            <button class="btn btn-primary btn-sm"><i class="bi bi-check"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="8" class="text-center py-5 text-muted">Aucune réservation trouvée</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-3"><?php echo e($reservations->withQueryString()->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xamppp\htdocs\PF\resources\views/EspaceAdmin/Reservations.blade.php ENDPATH**/ ?>