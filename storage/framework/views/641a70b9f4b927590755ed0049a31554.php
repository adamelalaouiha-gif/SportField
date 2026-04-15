<?php $__env->startSection('title', 'Détail demande'); ?>
<?php $__env->startSection('page-title', 'Détail de la demande'); ?>
<?php $__env->startSection('content'); ?>

    <div class="mb-4">
        <a href="<?php echo e(route('superadmin.demandes')); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-2"></i>Retour aux demandes
        </a>
    </div>

    <div class="row g-4">
        
        <div class="col-lg-4">
            <div class="table-card text-center">
                <?php if($demande->photos): ?>
                    <img src="<?php echo e(asset('storage/'.$demande->photos)); ?>"
                         class="img-fluid rounded-3 mb-3"
                         style="max-height:250px;object-fit:cover;width:100%;"
                         alt="<?php echo e($demande->nom_club); ?>">
                <?php else: ?>
                    <div style="height:180px;background:#f1f5f9;border-radius:12px;display:flex;align-items:center;justify-content:center;" class="mb-3">
                        <i class="bi bi-building text-muted" style="font-size:4rem;"></i>
                    </div>
                <?php endif; ?>

                <h4 class="fw-bold mb-1"><?php echo e($demande->nom_club); ?></h4>
                <p class="text-muted mb-3"><i class="bi bi-geo-alt me-1"></i><?php echo e($demande->adresse); ?></p>

                <?php $colors = ['en_attente'=>'warning','approuvee'=>'success','rejetee'=>'danger']; ?>
                <span class="badge bg-<?php echo e($colors[$demande->statut_demande] ?? 'secondary'); ?> px-3 py-2 fs-6 mb-4">
                <?php echo e(ucfirst(str_replace('_',' ',$demande->statut_demande))); ?>

            </span>

                <?php if($demande->statut_demande === 'en_attente'): ?>
                    <div class="d-grid gap-2">
                        <form method="POST" action="<?php echo e(route('superadmin.demande.approuver', $demande->id)); ?>">
                            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                            <button class="btn btn-success w-100">
                                <i class="bi bi-check-circle me-2"></i>Approuver ce club
                            </button>
                        </form>
                        <form method="POST" action="<?php echo e(route('superadmin.demande.rejeter', $demande->id)); ?>">
                            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                            <button class="btn btn-danger w-100">
                                <i class="bi bi-x-circle me-2"></i>Rejeter la demande
                            </button>
                        </form>
                    </div>
                <?php endif; ?>

                <p class="text-muted small mt-3">
                    <i class="bi bi-calendar me-1"></i>Soumis le <?php echo e($demande->created_at->format('d/m/Y à H:i')); ?>

                </p>
            </div>
        </div>

        
        <div class="col-lg-8">

            
            <div class="table-card mb-4">
                <h5 class="fw-bold mb-4 pb-2 border-bottom">
                    <i class="bi bi-person-badge me-2 text-primary"></i>Informations du responsable
                </h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="text-muted small">Prénom</label>
                        <div class="fw-medium"><?php echo e($demande->prenom_responsable); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Nom</label>
                        <div class="fw-medium"><?php echo e($demande->nom_responsable); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Email</label>
                        <div class="fw-medium">
                            <a href="mailto:<?php echo e($demande->email_responsable); ?>" class="text-decoration-none">
                                <?php echo e($demande->email_responsable); ?>

                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Téléphone</label>
                        <div class="fw-medium"><?php echo e($demande->telephone_club); ?></div>
                    </div>
                </div>
            </div>

            
            <div class="table-card mb-4">
                <h5 class="fw-bold mb-4 pb-2 border-bottom">
                    <i class="bi bi-building me-2 text-primary"></i>Informations du club
                </h5>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="text-muted small">Nom du club</label>
                        <div class="fw-medium"><?php echo e($demande->nom_club); ?></div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Adresse</label>
                        <div class="fw-medium"><?php echo e($demande->adresse); ?></div>
                    </div>
                    <div class="col-12">
                        <label class="text-muted small">Description</label>
                        <div class="fw-medium"><?php echo e($demande->description); ?></div>
                    </div>
                </div>

                <label class="text-muted small d-block mb-2">Sports proposés</label>
                <div class="d-flex flex-wrap gap-2">
                    <?php $sportsLabels = ['foot'=>'Football','basketball'=>'Basketball','tennis'=>'Tennis','padel'=>'Padel','volleyball'=>'Volleyball']; ?>
                    <?php $__currentLoopData = is_array($demande->sports) ? $demande->sports : json_decode($demande->sports, true) ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="badge px-3 py-2" style="background:#dbeafe;color:#1e40af;font-size:0.85rem;">
                        <?php echo e($sportsLabels[$sport] ?? ucfirst($sport)); ?>

                    </span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            
            <div class="table-card">
                <h5 class="fw-bold mb-4 pb-2 border-bottom">
                    <i class="bi bi-clock me-2 text-primary"></i>Horaires d'ouverture
                </h5>
                <?php
                    $horaires = is_array($demande->horaires) ? $demande->horaires : json_decode($demande->horaires, true) ?? [];
                ?>

                <?php if(!empty($horaires)): ?>
                    <div class="row g-2">
                        <?php $__currentLoopData = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center p-2 rounded-2"
                                     style="background:#f8fafc;border:1px solid #e5e7eb;">
                                    <span class="fw-medium"><?php echo e($jour); ?></span>
                                    <?php if(isset($horaires[$jour])): ?>
                                        <?php
                                            $h = $horaires[$jour];
                                            $horStr = is_array($h) ? ($h['ouverture'] ?? '') . ' - ' . ($h['fermeture'] ?? '') : $h;
                                        ?>
                                        <span class="badge bg-success"><?php echo e($horStr); ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-light text-muted border">Fermé</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted mb-0"><i class="bi bi-info-circle me-2"></i>Aucun horaire renseigné.</p>
                <?php endif; ?>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.superadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xamppp\htdocs\PF\resources\views/EspaceSuperAdmin/demande-detail.blade.php ENDPATH**/ ?>