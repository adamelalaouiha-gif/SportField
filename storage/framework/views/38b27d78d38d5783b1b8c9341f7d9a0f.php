<?php $__env->startSection('title', 'Demandes clubs'); ?>
<?php $__env->startSection('page-title', "Demandes d'inscription clubs"); ?>
<?php $__env->startSection('content'); ?>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show mb-4">
        <i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show mb-4">
        <i class="bi bi-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="table-card">
    <div class="mb-4">
        <form method="GET" class="d-flex gap-2">
            <select name="statut" class="form-select w-auto" onchange="this.form.submit()">
                <option value="">Tous les statuts</option>
                <option value="en_attente" <?php echo e(request('statut') === 'en_attente' ? 'selected' : ''); ?>>En attente</option>
                <option value="approuvee" <?php echo e(request('statut') === 'approuvee' ? 'selected' : ''); ?>>Approuvées</option>
                <option value="rejetee" <?php echo e(request('statut') === 'rejetee' ? 'selected' : ''); ?>>Rejetées</option>
            </select>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Club</th>
                    <th>Responsable</th>
                    <th>Contact</th>
                    <th>Sports</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $demandes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <?php if($d->photos): ?>
                                <img src="<?php echo e(asset('storage/'.$d->photos)); ?>" width="40" height="40"
                                     style="object-fit:cover;border-radius:8px;" alt="<?php echo e($d->nom_club); ?>">
                            <?php else: ?>
                                <div style="width:40px;height:40px;background:#e5e7eb;border-radius:8px;display:flex;align-items:center;justify-content:center;">
                                    <i class="bi bi-building text-muted"></i>
                                </div>
                            <?php endif; ?>
                            <div>
                                <div class="fw-medium"><?php echo e($d->nom_club); ?></div>
                                <small class="text-muted"><?php echo e(Str::limit($d->adresse, 30)); ?></small>
                            </div>
                        </div>
                    </td>
                    <td><?php echo e($d->prenom_responsable); ?> <?php echo e($d->nom_responsable); ?></td>
                    <td>
                        <small><?php echo e($d->email_responsable); ?></small><br>
                        <small class="text-muted"><?php echo e($d->telephone_club); ?></small>
                    </td>
                    <td>
                        <?php $sportsLabels = ['foot'=>'Football','basketball'=>'Basketball','tennis'=>'Tennis','padel'=>'Padel','volleyball'=>'Volleyball']; ?>
                        <?php $__currentLoopData = is_array($d->sports) ? $d->sports : json_decode($d->sports, true) ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="badge bg-light text-dark border me-1"><?php echo e($sportsLabels[$s] ?? ucfirst($s)); ?></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                    <td><small><?php echo e($d->created_at->format('d/m/Y')); ?></small></td>
                    <td>
                        <?php $colors = ['en_attente'=>'warning','approuvee'=>'success','rejetee'=>'danger']; ?>
                        <span class="badge bg-<?php echo e($colors[$d->statut_demande] ?? 'secondary'); ?>">
                            <?php echo e(ucfirst(str_replace('_',' ',$d->statut_demande))); ?>

                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-2 align-items-center">
                            
                            <a href="<?php echo e(route('superadmin.demande.show', $d->id)); ?>"
                               class="btn btn-primary btn-sm" title="Voir les détails">
                                <i class="bi bi-eye me-1"></i>Voir
                            </a>

                            <?php if($d->statut_demande === 'en_attente'): ?>
                            
                            <form method="POST" action="<?php echo e(route('superadmin.demande.approuver', $d->id)); ?>">
                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                <button type="submit" class="btn btn-success btn-sm" title="Approuver"
                                        onclick="return confirm('Approuver le club <?php echo e($d->nom_club); ?> ?')">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </form>
                            
                            <form method="POST" action="<?php echo e(route('superadmin.demande.rejeter', $d->id)); ?>">
                                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                <button type="submit" class="btn btn-danger btn-sm" title="Rejeter"
                                        onclick="return confirm('Rejeter cette demande ?')">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </form>
                            <?php else: ?>
                                <span class="text-muted small">Traitée</span>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        Aucune demande trouvée
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-3"><?php echo e($demandes->withQueryString()->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.superadmin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xamppp\htdocs\PF\resources\views/EspaceSuperAdmin/demandes.blade.php ENDPATH**/ ?>