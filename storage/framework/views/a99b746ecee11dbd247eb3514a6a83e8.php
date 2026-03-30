<?php $__env->startSection('title', 'Utilisateurs'); ?>
<?php $__env->startSection('page-title', 'Gestion des utilisateurs'); ?>
<?php $__env->startSection('content'); ?>

<div class="table-card">
    <div class="mb-4">
        <form method="GET" class="d-flex gap-2 flex-wrap">
            <input type="text" name="q" class="form-control w-auto" placeholder="Nom ou email..." value="<?php echo e(request('q')); ?>">
            <select name="role" class="form-select w-auto" onchange="this.form.submit()">
                <option value="">Tous les rôles</option>
                <option value="client" <?php echo e(request('role') === 'client' ? 'selected' : ''); ?>>Clients</option>
                <option value="admin" <?php echo e(request('role') === 'admin' ? 'selected' : ''); ?>>Admins clubs</option>
                <option value="super_admin" <?php echo e(request('role') === 'super_admin' ? 'selected' : ''); ?>>Super Admins</option>
            </select>
            <button class="btn btn-primary">Rechercher</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr><th>Utilisateur</th><th>Email</th><th>Rôle</th><th>Inscription</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $utilisateurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="fw-medium"><?php echo e($u->prenom); ?> <?php echo e($u->nom); ?></td>
                    <td><?php echo e($u->email); ?></td>
                    <td>
                        <?php $roleColors = ['client'=>'primary','admin'=>'warning','super_admin'=>'danger']; ?>
                        <span class="badge bg-<?php echo e($roleColors[$u->role] ?? 'secondary'); ?>"><?php echo e(ucfirst(str_replace('_',' ',$u->role))); ?></span>
                    </td>
                    <td><small><?php echo e($u->created_at->format('d/m/Y')); ?></small></td>
                    <td>
                        <?php if($u->role !== 'super_admin'): ?>
                        <form method="POST" action="<?php echo e(route('superadmin.utilisateur.delete', $u->id)); ?>" onsubmit="return confirm('Supprimer cet utilisateur ?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                        <?php else: ?>
                            <span class="text-muted small">—</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" class="text-center py-5 text-muted">Aucun utilisateur trouvé</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-3"><?php echo e($utilisateurs->withQueryString()->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.superadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xamppp\htdocs\PF\resources\views/EspaceSuperAdmin/GestionUtilisateurs.blade.php ENDPATH**/ ?>