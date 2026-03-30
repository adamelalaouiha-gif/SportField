<?php $__env->startSection('title', 'Gestion clubs'); ?>
<?php $__env->startSection('page-title', 'Gestion des clubs'); ?>
<?php $__env->startSection('content'); ?>

<div class="table-card">
    <div class="mb-4">
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="q" class="form-control w-auto" placeholder="Rechercher un club..." value="<?php echo e(request('q')); ?>">
            <button class="btn btn-primary">Rechercher</button>
            <?php if(request('q')): ?><a href="<?php echo e(route('superadmin.clubs')); ?>" class="btn btn-outline-secondary">Réinitialiser</a><?php endif; ?>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr><th>Club</th><th>Admin</th><th>Sports</th><th>Terrains</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $clubs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $club): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <?php if($club->photo): ?>
                                <img src="<?php echo e(asset('storage/'.$club->photo)); ?>" width="45" height="45" style="object-fit:cover;border-radius:8px;">
                            <?php else: ?>
                                <div style="width:45px;height:45px;background:#e5e7eb;border-radius:8px;display:flex;align-items:center;justify-content:center;"><i class="bi bi-building text-muted"></i></div>
                            <?php endif; ?>
                            <div>
                                <div class="fw-medium"><?php echo e($club->nom); ?></div>
                                <small class="text-muted"><?php echo e($club->adresse); ?></small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <?php if($club->admin): ?>
                            <div><?php echo e($club->admin->prenom); ?> <?php echo e($club->admin->nom); ?></div>
                            <small class="text-muted"><?php echo e($club->admin->email); ?></small>
                        <?php else: ?>
                            <span class="text-muted">—</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php $__currentLoopData = is_array($club->sports) ? $club->sports : json_decode($club->sports, true) ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="badge bg-light text-dark border me-1"><?php echo e($s); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                    <td><span class="badge bg-primary"><?php echo e($club->terrains->count()); ?></span></td>
                    <td>
                        <form method="POST" action="<?php echo e(route('superadmin.club.delete', $club->id)); ?>" onsubmit="return confirm('Supprimer ce club et tous ses terrains ?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" class="text-center py-5 text-muted">Aucun club trouvé</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-3"><?php echo e($clubs->withQueryString()->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.superadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xamppp\htdocs\PF\resources\views/EspaceSuperAdmin/GestionClubs.blade.php ENDPATH**/ ?>