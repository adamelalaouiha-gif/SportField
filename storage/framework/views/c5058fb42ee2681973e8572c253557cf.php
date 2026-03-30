<?php $__env->startSection('title', $club->nom . ' - SportsField'); ?>
<?php $__env->startSection('head'); ?>
<style>
    .club-hero { background: linear-gradient(135deg, #2563eb, #1e40af); color: white; padding: 60px 0; }
    .club-hero-img { width: 100%; height: 300px; object-fit: cover; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
    .terrain-card { border: none; border-radius: 12px; overflow: hidden; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
    .terrain-card:hover { box-shadow: 0 8px 25px rgba(0,0,0,0.15); transform: translateY(-3px); }
    .terrain-img { height: 180px; object-fit: cover; width: 100%; }
    .sport-badge { display: inline-block; padding: 5px 14px; border: 1px solid rgba(255,255,255,0.4); border-radius: 20px; font-size: 0.8rem; margin: 3px; color: white; }
    .info-card { background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 24px; margin-bottom: 20px; }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="club-hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('accueil')); ?>" class="text-white-50 text-decoration-none">Accueil</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('clubs.index')); ?>" class="text-white-50 text-decoration-none">Clubs</a></li>
                        <li class="breadcrumb-item active text-white"><?php echo e($club->nom); ?></li>
                    </ol>
                </nav>
                <h1 class="fw-bold mb-3"><?php echo e($club->nom); ?></h1>
                <p class="mb-3 opacity-75"><i class="bi bi-geo-alt me-2"></i><?php echo e($club->adresse); ?></p>
                <?php if($club->telephone): ?>
                    <p class="mb-3 opacity-75"><i class="bi bi-telephone me-2"></i><?php echo e($club->telephone); ?></p>
                <?php endif; ?>
                <div class="mb-3">
                    <?php $__currentLoopData = is_array($club->sports) ? $club->sports : json_decode($club->sports, true) ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="sport-badge"><?php echo e(ucfirst($sport)); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php if($club->description): ?>
                    <p class="opacity-90"><?php echo e($club->description); ?></p>
                <?php endif; ?>
            </div>
            <div class="col-lg-5">
                <?php if($club->photo): ?>
                    <img src="<?php echo e(asset('storage/'.$club->photo)); ?>" class="club-hero-img" alt="<?php echo e($club->nom); ?>">
                <?php else: ?>
                    <img src="https://images.unsplash.com/photo-1545255678-30015d3842b0?w=600" class="club-hero-img" alt="<?php echo e($club->nom); ?>">
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <h2 class="fw-bold mb-4">Terrains disponibles <span class="badge bg-primary ms-2"><?php echo e($club->terrains->count()); ?></span></h2>
            <div class="row g-4">
                <?php $__empty_1 = true; $__currentLoopData = $club->terrains; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $terrain): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-md-6">
                    <div class="card terrain-card h-100">
                        <?php if($terrain->photo): ?>
                            <img src="<?php echo e(asset('storage/'.$terrain->photo)); ?>" class="terrain-img" alt="<?php echo e($terrain->nom); ?>">
                        <?php else: ?>
                            <img src="https://images.unsplash.com/photo-1551958219-acbc608c6377?w=400" class="terrain-img" alt="<?php echo e($terrain->nom); ?>">
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title fw-bold mb-0"><?php echo e($terrain->nom); ?></h5>
                                <span class="badge bg-primary"><?php echo e(number_format($terrain->prix_heure, 0)); ?> DH/h</span>
                            </div>
                            <p class="text-muted small mb-2"><i class="bi bi-trophy me-1"></i><?php echo e(ucfirst($terrain->type_sport)); ?></p>
                            <?php if($terrain->description): ?>
                                <p class="text-muted small mb-3"><?php echo e(Str::limit($terrain->description, 80)); ?></p>
                            <?php endif; ?>
                            <?php if(auth()->guard()->check()): ?>
                                <?php if(auth()->user()->role === 'client'): ?>
                                    <a href="<?php echo e(route('client.reserver', $terrain->id)); ?>" class="btn btn-primary mt-auto">Réserver ce terrain</a>
                                <?php else: ?>
                                    <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-primary mt-auto">Réserver</a>
                                <?php endif; ?>
                            <?php else: ?>
                                <a href="<?php echo e(route('login')); ?>" class="btn btn-primary mt-auto">Se connecter pour réserver</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-12 text-center py-4">
                    <i class="bi bi-geo fs-1 text-muted"></i>
                    <p class="text-muted mt-2">Aucun terrain disponible pour ce club.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-4">
            <?php if($club->horaires): ?>
            <div class="info-card">
                <h5 class="fw-bold mb-3"><i class="bi bi-clock me-2 text-primary"></i>Horaires d'ouverture</h5>
                <?php $horaires = is_array($club->horaires) ? $club->horaires : json_decode($club->horaires, true) ?? []; ?>
                <?php $__currentLoopData = $horaires; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jour => $heure): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="fw-medium"><?php echo e(ucfirst($jour)); ?></span>
                    <span class="text-muted"><?php echo e($heure); ?></span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>

            <div class="info-card">
                <h5 class="fw-bold mb-3"><i class="bi bi-info-circle me-2 text-primary"></i>Informations</h5>
                <p class="text-muted small mb-2"><i class="bi bi-geo-alt me-2"></i><?php echo e($club->adresse); ?></p>
                <?php if($club->telephone): ?>
                    <p class="text-muted small mb-0"><i class="bi bi-telephone me-2"></i><?php echo e($club->telephone); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xamppp\htdocs\PF\resources\views/Visiteur/profileClub.blade.php ENDPATH**/ ?>