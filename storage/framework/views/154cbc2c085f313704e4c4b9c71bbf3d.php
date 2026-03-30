<?php $__env->startSection('title', 'Profil du club'); ?>
<?php $__env->startSection('page-title', 'Profil du club'); ?>
<?php $__env->startSection('content'); ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="table-card">
            <?php if(session('success')): ?>
                <div class="alert alert-success"><i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?></div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="alert alert-danger"><ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('admin.profil.update')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

                <?php if($club->photo): ?>
                    <div class="mb-4 text-center">
                        <img src="<?php echo e(asset('storage/'.$club->photo)); ?>" height="120" style="border-radius:12px;object-fit:cover;" alt="<?php echo e($club->nom); ?>">
                    </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nom du club</label>
                    <input type="text" name="nom" class="form-control" value="<?php echo e(old('nom', $club->nom)); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Adresse</label>
                    <input type="text" name="adresse" class="form-control" value="<?php echo e(old('adresse', $club->adresse)); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Téléphone</label>
                    <input type="text" name="telephone" class="form-control" value="<?php echo e(old('telephone', $club->telephone)); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" class="form-control" rows="4"><?php echo e(old('description', $club->description)); ?></textarea>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Photo du club</label>
                    <input type="file" name="photo" class="form-control" accept="image/*">
                </div>

                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-2"></i>Enregistrer
                </button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xamppp\htdocs\PF\resources\views/EspaceAdmin/PrifileClub.blade.php ENDPATH**/ ?>