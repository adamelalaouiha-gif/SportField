<?php $__env->startSection('title', 'Mes réservations - SportsField'); ?>
<?php $__env->startSection('head'); ?>
<style>
    .page-header { background: linear-gradient(135deg, #2563eb, #1e40af); color: white; padding: 50px 0; margin-bottom: 40px; }
    .reservation-card { background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 20px; margin-bottom: 16px; border-left: 4px solid #e5e7eb; transition: all 0.2s; }
    .reservation-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.12); }
    .reservation-card.en_attente { border-left-color: #f59e0b; }
    .reservation-card.terminée { border-left-color: #10b981; }
    .reservation-card.annulée { border-left-color: #ef4444; }
    .reservation-card.non_venue { border-left-color: #6b7280; }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="container">
        <h1 class="fw-bold mb-2"><i class="bi bi-calendar-check me-2"></i>Mes réservations</h1>
        <p class="opacity-75 mb-0">Gérez toutes vos réservations de terrains</p>
    </div>
</div>

<div class="container mb-5">
    <?php if(session('success')): ?>
        <div class="alert alert-success"><i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?></div>
    <?php endif; ?>

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

    <?php $__empty_1 = true; $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="reservation-card <?php echo e($r->statut_reservation); ?>">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="fw-bold mb-1"><?php echo e($r->terrain->nom); ?></h5>
                <p class="text-muted small mb-1"><i class="bi bi-building me-1"></i><?php echo e($r->terrain->club->nom); ?></p>
                <p class="text-muted small mb-0">
                    <i class="bi bi-calendar me-1"></i><?php echo e(\Carbon\Carbon::parse($r->date_reservation)->format('d/m/Y')); ?>

                    &nbsp;|&nbsp;
                    <i class="bi bi-clock me-1"></i><?php echo e(substr($r->heure_debut, 0, 5)); ?> - <?php echo e(substr($r->heure_fin, 0, 5)); ?>

                </p>
            </div>
            <div class="col-md-3 text-md-center mt-3 mt-md-0">
                <div class="fw-bold fs-5"><?php echo e(number_format($r->montant, 0)); ?> DH</div>
                <small class="text-muted"><?php echo e($r->methode_paiement === 'sur_place' ? 'Sur place' : 'En ligne'); ?></small>
            </div>
            <div class="col-md-3 text-md-end mt-3 mt-md-0">
                <?php
                    $badges = ['en_attente' => 'warning', 'terminée' => 'success', 'annulée' => 'danger', 'non_venue' => 'secondary'];
                    $labels = ['en_attente' => 'En attente', 'terminée' => 'Terminée', 'annulée' => 'Annulée', 'non_venue' => 'Non venue'];
                ?>
                <span class="badge bg-<?php echo e($badges[$r->statut_reservation] ?? 'secondary'); ?> mb-2"><?php echo e($labels[$r->statut_reservation] ?? $r->statut_reservation); ?></span>
                <?php if($r->statut_reservation === 'en_attente'): ?>
                <form method="POST" action="<?php echo e(route('client.reservation.annuler', $r->id)); ?>" class="d-block">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Annuler cette réservation ?')">
                        <i class="bi bi-x-circle me-1"></i>Annuler
                    </button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="text-center py-5">
        <i class="bi bi-calendar-x fs-1 text-muted"></i>
        <h5 class="mt-3 text-muted">Aucune réservation trouvée</h5>
        <a href="<?php echo e(route('clubs.index')); ?>" class="btn btn-primary mt-3">Réserver un terrain</a>
    </div>
    <?php endif; ?>

    <div class="d-flex justify-content-center mt-4">
        <?php echo e($reservations->withQueryString()->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xamppp\htdocs\PF\resources\views/Client/MesReservations.blade.php ENDPATH**/ ?>