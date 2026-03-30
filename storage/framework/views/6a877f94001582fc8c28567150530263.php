<?php $__env->startSection('title', isset($terrain) ? 'Modifier terrain' : 'Ajouter terrain'); ?>
<?php $__env->startSection('page-title', isset($terrain) ? 'Modifier le terrain' : 'Ajouter un terrain'); ?>
<?php $__env->startSection('content'); ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="table-card">
            <?php if($errors->any()): ?>
                <div class="alert alert-danger"><ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(isset($terrain) ? route('admin.terrains.update', $terrain->id) : route('admin.terrains.store')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php if(isset($terrain)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nom du terrain <span class="text-danger">*</span></label>
                    <input type="text" name="nom" class="form-control" value="<?php echo e(old('nom', $terrain->nom ?? '')); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control" rows="3"><?php echo e(old('description', $terrain->description ?? '')); ?></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label class="form-label fw-semibold">Type de sport <span class="text-danger">*</span></label>
                        <select name="type_sport" class="form-select" required>
                            <?php $__currentLoopData = ['foot' => 'Football', 'basketball' => 'Basketball', 'tennis' => 'Tennis', 'padel' => 'Padel', 'volleyball' => 'Volleyball']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($val); ?>" <?php echo e(old('type_sport', $terrain->type_sport ?? '') === $val ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Prix par heure (DH) <span class="text-danger">*</span></label>
                        <input type="number" name="prix_heure" class="form-control" min="0" step="0.01" value="<?php echo e(old('prix_heure', $terrain->prix_heure ?? '')); ?>" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Photo</label>
                    <?php if(isset($terrain) && $terrain->photo): ?>
                        <div class="mb-2">
                            <img src="<?php echo e(asset('storage/'.$terrain->photo)); ?>" height="80" style="border-radius:8px;" alt="Photo actuelle">
                            <small class="text-muted ms-2">Photo actuelle</small>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="photo" class="form-control" accept="image/*">
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-lg me-2"></i><?php echo e(isset($terrain) ? 'Mettre à jour' : 'Ajouter le terrain'); ?>

                    </button>
                    <a href="<?php echo e(route('admin.terrains')); ?>" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xamppp\htdocs\PF\resources\views/EspaceAdmin/ajouterTerrain.blade.php ENDPATH**/ ?>