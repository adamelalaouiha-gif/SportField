<?php $__env->startSection('title', 'Mes terrains'); ?>
<?php $__env->startSection('page-title', 'Mes terrains'); ?>
<?php $__env->startSection('page-subtitle', 'Gérez les terrains de votre club'); ?>
<?php $__env->startSection('content'); ?>

<div class="d-flex justify-content-end mb-4">
    <a href="<?php echo e(route('admin.terrains.create')); ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Ajouter un terrain
    </a>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Photo</th>
                    <th>Nom</th>
                    <th>Sport</th>
                    <th>Prix/heure</th>
                    <th>Réservations</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $terrains; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <?php if($t->photo): ?>
                            <img src="<?php echo e(asset('storage/'.$t->photo)); ?>" width="60" height="45" style="object-fit:cover;border-radius:6px;" alt="<?php echo e($t->nom); ?>">
                        <?php else: ?>
                            <div style="width:60px;height:45px;background:#e5e7eb;border-radius:6px;display:flex;align-items:center;justify-content:center;"><i class="bi bi-image text-muted"></i></div>
                        <?php endif; ?>
                    </td>
                    <td><span class="fw-medium"><?php echo e($t->nom); ?></span></td>
                    <td><span class="badge bg-light text-dark border"><?php echo e(ucfirst($t->type_sport)); ?></span></td>
                    <td class="fw-bold"><?php echo e(number_format($t->prix_heure, 0)); ?> DH</td>
                    <td><span class="badge bg-primary"><?php echo e($t->reservations->count()); ?></span></td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="<?php echo e(route('admin.terrains.edit', $t->id)); ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="<?php echo e(route('admin.terrains.delete', $t->id)); ?>" onsubmit="return confirm('Supprimer ce terrain ?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="text-center py-5">
                    <i class="bi bi-geo fs-1 text-muted"></i>
                    <p class="text-muted mt-2">Aucun terrain ajouté</p>
                    <a href="<?php echo e(route('admin.terrains.create')); ?>" class="btn btn-primary btn-sm">Ajouter votre premier terrain</a>
                </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xamppp\htdocs\PF\resources\views/EspaceAdmin/MesTerrains.blade.php ENDPATH**/ ?>