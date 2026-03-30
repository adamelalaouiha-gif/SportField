<?php $__env->startSection('title', 'Inscrire mon club - SportsField'); ?>
<?php $__env->startSection('head'); ?>
<style>
    .page-header { background: linear-gradient(135deg, #2563eb, #1e40af); color: white; padding: 60px 0; margin-bottom: 40px; }
    .form-card { background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 40px; }
    .section-title { font-size: 1rem; font-weight: 700; color: #2563eb; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #e5e7eb; }
    .horaire-row { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
    .horaire-jour { min-width: 100px; font-weight: 600; }
    .field-valid { border-color: #10b981 !important; }
    .field-checking { border-color: #f59e0b !important; }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header text-center">
    <div class="container">
        <h1 class="fw-bold mb-2"><i class="bi bi-building-add me-2"></i>Inscrire mon club</h1>
        <p class="lead opacity-75">Rejoignez SportsField et gérez vos réservations en ligne</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <?php if($errors->any()): ?>
            <div class="alert alert-danger mb-4">
                <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle me-2"></i>Veuillez corriger les erreurs :</div>
                <ul class="mb-0 mt-1">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php endif; ?>

            <div class="form-card">
                <form method="POST" action="<?php echo e(route('visiteur.demande.post')); ?>" enctype="multipart/form-data" novalidate>
                    <?php echo csrf_field(); ?>

                    
                    <p class="section-title"><i class="bi bi-person me-2"></i>Informations du responsable</p>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold">Prénom <span class="text-danger">*</span></label>
                            <input type="text" name="prenom_responsable"
                                   class="form-control <?php $__errorArgs = ['prenom_responsable'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('prenom_responsable')); ?>" placeholder="Jean">
                            <?php $__errorArgs = ['prenom_responsable'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nom <span class="text-danger">*</span></label>
                            <input type="text" name="nom_responsable"
                                   class="form-control <?php $__errorArgs = ['nom_responsable'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('nom_responsable')); ?>" placeholder="Dupont">
                            <?php $__errorArgs = ['nom_responsable'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email_responsable" id="email_responsable"
                                       class="form-control border-start-0 <?php $__errorArgs = ['email_responsable'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('email_responsable')); ?>" placeholder="votre@email.com"
                                       oninput="validateEmail(this)">
                            </div>
                            <?php $__errorArgs = ['email_responsable'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></div>
                            <?php else: ?>
                                <div id="email_feedback" class="form-text"></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Mot de passe <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                                <input type="password" name="mot_de_passe_responsable" id="mdp_resp"
                                       class="form-control border-start-0 border-end-0 <?php $__errorArgs = ['mot_de_passe_responsable'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       placeholder="••••••••" minlength="8">
                                <span class="input-group-text bg-light border-start-0" style="cursor:pointer" onclick="togglePwd('mdp_resp','ic_mdp')">
                                    <i class="bi bi-eye" id="ic_mdp"></i>
                                </span>
                            </div>
                            <?php $__errorArgs = ['mot_de_passe_responsable'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <div class="form-text">8 caractères minimum.</div>
                        </div>
                    </div>

                    
                    <p class="section-title"><i class="bi bi-building me-2"></i>Informations du club</p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nom du club <span class="text-danger">*</span></label>
                        <input type="text" name="nom_club"
                               class="form-control <?php $__errorArgs = ['nom_club'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('nom_club')); ?>" placeholder="Mon Club Sportif">
                        <?php $__errorArgs = ['nom_club'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                        <textarea name="description" rows="3"
                                  class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  placeholder="Décrivez votre club (au moins 20 caractères)..."><?php echo e(old('description')); ?></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold">Téléphone <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-telephone"></i></span>
                                <input type="text" name="telephone_club" id="telephone_club"
                                       class="form-control border-start-0 <?php $__errorArgs = ['telephone_club'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('telephone_club')); ?>" placeholder="0612345678"
                                       oninput="validateTelephone(this)" maxlength="13">
                            </div>
                            <?php $__errorArgs = ['telephone_club'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></div>
                            <?php else: ?>
                                <div id="tel_feedback" class="form-text">Format : 0612345678 ou +212612345678</div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Adresse <span class="text-danger">*</span></label>
                            <input type="text" name="adresse"
                                   class="form-control <?php $__errorArgs = ['adresse'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('adresse')); ?>" placeholder="Rue, Ville">
                            <?php $__errorArgs = ['adresse'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Sports proposés <span class="text-danger">*</span></label>
                        <?php $__errorArgs = ['sports'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mb-2"><i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="d-flex flex-wrap gap-3">
                            <?php $__currentLoopData = ['foot' => 'Football', 'basketball' => 'Basketball', 'tennis' => 'Tennis', 'padel' => 'Padel', 'volleyball' => 'Volleyball']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sports[]"
                                       value="<?php echo e($val); ?>" id="sport_<?php echo e($val); ?>"
                                       <?php echo e(in_array($val, old('sports', [])) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="sport_<?php echo e($val); ?>"><?php echo e($label); ?></label>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold"><i class="bi bi-clock me-1"></i>Horaires d'ouverture</label>
                        <p class="text-muted small mb-3">Laissez vide pour les jours de fermeture.</p>
                        <?php $__currentLoopData = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="horaire-row">
                            <span class="horaire-jour"><?php echo e($jour); ?></span>
                            <input type="time" name="horaires[<?php echo e($jour); ?>][ouverture]"
                                   class="form-control form-control-sm"
                                   value="<?php echo e(old('horaires.'.$jour.'.ouverture')); ?>">
                            <span class="text-muted fw-bold">—</span>
                            <input type="time" name="horaires[<?php echo e($jour); ?>][fermeture]"
                                   class="form-control form-control-sm"
                                   value="<?php echo e(old('horaires.'.$jour.'.fermeture')); ?>">
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Photo du club</label>
                        <input type="file" name="photo"
                               class="form-control <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               accept="image/jpeg,image/png,image/jpg">
                        <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="form-text">Format JPG ou PNG. Taille max : 2 Mo.</div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-send me-2"></i>Envoyer ma demande
                        </button>
                    </div>
                    <p class="text-muted small text-center mt-3">
                        <i class="bi bi-info-circle me-1"></i>
                        Votre demande sera examinée par notre équipe sous 24-48h.
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->startSection('scripts'); ?>
<script>
function togglePwd(id, iconId) {
    const p = document.getElementById(id);
    const i = document.getElementById(iconId);
    p.type = p.type === 'password' ? 'text' : 'password';
    i.className = p.type === 'text' ? 'bi bi-eye-slash' : 'bi bi-eye';
}

function validateEmail(input) {
    const feedback = document.getElementById('email_feedback');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const val = input.value.trim();

    if (val === '') {
        input.classList.remove('field-valid', 'is-invalid');
        feedback.textContent = '';
        return;
    }

    if (!emailRegex.test(val)) {
        input.classList.add('is-invalid');
        input.classList.remove('field-valid');
        feedback.textContent = '';
        feedback.className = 'form-text';
        return;
    }

    input.classList.remove('is-invalid');
    input.classList.add('field-valid');
    feedback.innerHTML = '<i class="bi bi-check-circle text-success me-1"></i><span class="text-success">Format email valide</span>';
    feedback.className = 'form-text';
}

function validateTelephone(input) {
    const feedback = document.getElementById('tel_feedback');
    const telRegex = /^(\+212|0)([ \-]?[0-9]){9}$/;
    const val = input.value.trim();

    if (val === '') {
        input.classList.remove('field-valid', 'is-invalid');
        feedback.innerHTML = 'Format : 0612345678 ou +212612345678';
        return;
    }

    if (!telRegex.test(val)) {
        input.classList.add('is-invalid');
        input.classList.remove('field-valid');
        feedback.innerHTML = '<span class="text-danger"><i class="bi bi-exclamation-circle me-1"></i>Format invalide. Ex: 0612345678</span>';
    } else {
        input.classList.remove('is-invalid');
        input.classList.add('field-valid');
        feedback.innerHTML = '<span class="text-success"><i class="bi bi-check-circle me-1"></i>Numéro valide</span>';
    }
}
</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xamppp\htdocs\PF\resources\views/Visiteur/EnvoiDemande.blade.php ENDPATH**/ ?>