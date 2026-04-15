<?php $__env->startSection('title', 'Réserver - ' . $terrain->nom); ?>
<?php $__env->startSection('head'); ?>
    <style>
        .page-header { background: linear-gradient(135deg, #2563eb, #1e40af); color: white; padding: 50px 0; margin-bottom: 40px; }
        .form-card { background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 35px; }
        .terrain-info-card { background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden; }
        .terrain-info-card img { width: 100%; height: 200px; object-fit: cover; }
        .price-highlight { font-size: 2rem; font-weight: bold; color: #2563eb; }
        select:disabled { background-color: #f3f4f6; cursor: not-allowed; }
        #closed-alert { display: none; }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    
    <?php
        $horairesJson = json_encode($terrain->club->horaires);
        $joursMap = [0=>'Dimanche',1=>'Lundi',2=>'Mardi',3=>'Mercredi',4=>'Jeudi',5=>'Vendredi',6=>'Samedi'];
        $joursMapJson = json_encode($joursMap);

        // Jours fermés (ouverture ou fermeture vide)
        $joursFermes = [];
        foreach ($terrain->club->horaires as $jour => $h) {
            if (empty($h['ouverture']) || empty($h['fermeture'])) {
                $joursFermes[] = $jour;
            }
        }
    ?>

    <div class="page-header text-center">
        <div class="container">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('accueil')); ?>" class="text-white-50 text-decoration-none">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('clubs.show', $terrain->club->id)); ?>" class="text-white-50 text-decoration-none"><?php echo e($terrain->club->nom); ?></a></li>
                    <li class="breadcrumb-item active text-white">Réserver</li>
                </ol>
            </nav>
            <h1 class="fw-bold mb-2">Réserver <?php echo e($terrain->nom); ?></h1>
            <p class="opacity-75"><?php echo e($terrain->club->nom); ?> — <?php echo e(ucfirst($terrain->type_sport)); ?></p>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="terrain-info-card">
                    <?php if($terrain->photo): ?>
                        <img src="<?php echo e(asset('storage/'.$terrain->photo)); ?>" alt="<?php echo e($terrain->nom); ?>">
                    <?php else: ?>
                        <img src="https://images.unsplash.com/photo-1551958219-acbc608c6377?w=400" alt="<?php echo e($terrain->nom); ?>">
                    <?php endif; ?>
                    <div class="p-4">
                        <h5 class="fw-bold"><?php echo e($terrain->nom); ?></h5>
                        <p class="text-muted small mb-2"><i class="bi bi-trophy me-1"></i><?php echo e(ucfirst($terrain->type_sport)); ?></p>
                        <p class="text-muted small mb-3"><i class="bi bi-geo-alt me-1"></i><?php echo e($terrain->club->adresse); ?></p>
                        <div class="text-center py-3 border-top">
                            <div class="price-highlight"><?php echo e(number_format($terrain->prix_heure, 0)); ?> DH</div>
                            <small class="text-muted">par heure</small>
                        </div>
                        
                        <div class="border-top pt-3 mt-2">
                            <p class="fw-semibold small mb-2"><i class="bi bi-clock me-1"></i>Horaires du club :</p>
                            <?php $__currentLoopData = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $h = $terrain->club->horaires[$jour] ?? null;
                                    if (is_array($h) && !empty($h['ouverture']) && !empty($h['fermeture'])) {
                                        $horStr = $h['ouverture'] . ' – ' . $h['fermeture'];
                                    } elseif (is_string($h) && str_contains($h, ' - ')) {
                                        $horStr = str_replace(' - ', ' – ', $h);
                                    } else {
                                        $horStr = null;
                                    }
                                ?>
                                <div class="d-flex justify-content-between small mb-1">
                                    <span class="text-muted"><?php echo e($jour); ?></span>
                                    <?php if($horStr): ?>
                                        <span class="fw-medium"><?php echo e($horStr); ?></span>
                                    <?php else: ?>
                                        <span class="text-danger">Fermé</span>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="form-card">
                    <h4 class="fw-bold mb-4">Détails de la réservation</h4>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('client.reserver.post', $terrain->id)); ?>">
                        <?php echo csrf_field(); ?>

                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Date de réservation <span class="text-danger">*</span></label>
                            <input type="date" name="date_reservation" id="date_reservation"
                                   class="form-control"
                                   min="<?php echo e(date('Y-m-d', strtotime('+1 day'))); ?>"
                                   value="<?php echo e(old('date_reservation')); ?>" required>
                            <div id="closed-alert" class="alert alert-warning mt-2 py-2 px-3 small">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                Le club est <strong>fermé</strong> ce jour. Veuillez choisir une autre date.
                            </div>
                        </div>

                        
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-semibold">Heure de début <span class="text-danger">*</span></label>
                                <select name="heure_debut" id="heure_debut" class="form-select" required disabled>
                                    <option value="">-- Choisir d'abord une date --</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Heure de fin <span class="text-danger">*</span></label>
                                <select name="heure_fin" id="heure_fin" class="form-select" required disabled>
                                    <option value="">-- Choisir d'abord une date --</option>
                                </select>
                            </div>
                        </div>

                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Méthode de paiement <span class="text-danger">*</span></label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="methode_paiement" value="sur_place" id="sur_place" <?php echo e(old('methode_paiement', 'sur_place') === 'sur_place' ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="sur_place"><i class="bi bi-cash me-1"></i>Sur place</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="methode_paiement" value="en_ligne" id="en_ligne" <?php echo e(old('methode_paiement') === 'en_ligne' ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="en_ligne"><i class="bi bi-credit-card me-1"></i>En ligne</label>
                                </div>
                            </div>
                        </div>

                        
                        <div id="carte-form" style="display:none;">
                            <div class="border rounded-3 p-4 mb-3" style="background:#f8fafc;">
                                <h6 class="fw-bold mb-3"><i class="bi bi-credit-card me-2 text-primary"></i>Informations de la carte</h6>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Titulaire de la carte</label>
                                    <input type="text" id="carte_nom" name="carte_nom" class="form-control"
                                           placeholder="NOM PRÉNOM" style="text-transform:uppercase;"
                                           oninput="this.value=this.value.toUpperCase()">
                                    <div class="invalid-feedback" id="err_nom"></div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Numéro de carte</label>
                                    <div class="input-group">
                                        <input type="text" id="carte_numero" name="carte_numero" class="form-control"
                                               placeholder="0000 0000 0000 0000" maxlength="19">
                                        <span class="input-group-text bg-white" id="card-icon">
                                        <i class="bi bi-credit-card text-muted" id="card-brand-icon"></i>
                                    </span>
                                    </div>
                                    <div class="invalid-feedback" id="err_numero"></div>
                                </div>

                                <div class="row">
                                    <div class="col-7 mb-3">
                                        <label class="form-label fw-semibold small">Date d'expiration</label>
                                        <input type="text" id="carte_expiry" name="carte_expiry" class="form-control"
                                               placeholder="MM/AA" maxlength="5">
                                        <div class="invalid-feedback" id="err_expiry"></div>
                                    </div>
                                    <div class="col-5 mb-3">
                                        <label class="form-label fw-semibold small">CVV</label>
                                        <input type="text" id="carte_cvv" name="carte_cvv" class="form-control"
                                               placeholder="123" maxlength="3">
                                        <div class="invalid-feedback" id="err_cvv"></div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center gap-2 mt-1">
                                    <i class="bi bi-shield-lock text-success"></i>
                                    <small class="text-muted">Paiement sécurisé — vos données sont protégées</small>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info d-flex align-items-center gap-2">
                            <i class="bi bi-calculator"></i>
                            <span>Le montant sera calculé automatiquement selon vos horaires. Prix : <strong><?php echo e($terrain->prix_heure); ?> DH/h</strong></span>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg" id="btn-submit" disabled>
                                <i class="bi bi-calendar-check me-2"></i>Confirmer la réservation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startSection('scripts'); ?>
        <script>
            const horairesRaw = <?php echo $horairesJson; ?>;
            const joursMap    = <?php echo $joursMapJson; ?>;
            const oldDate     = "<?php echo e(old('date_reservation')); ?>";
            const oldDebut    = "<?php echo e(old('heure_debut')); ?>";
            const oldFin      = "<?php echo e(old('heure_fin')); ?>";

            // Normaliser les horaires : gérer les deux formats (array et string "HH:MM - HH:MM")
            const horaires = {};
            for (const [jour, val] of Object.entries(horairesRaw)) {
                if (!val) { horaires[jour] = null; continue; }
                if (typeof val === 'object' && val.ouverture && val.fermeture) {
                    horaires[jour] = val; // nouveau format
                } else if (typeof val === 'string' && val.includes(' - ')) {
                    const [ouv, fer] = val.split(' - ');
                    horaires[jour] = { ouverture: ouv.trim(), fermeture: fer.trim() };
                } else {
                    horaires[jour] = null;
                }
            }

            const dateInput  = document.getElementById('date_reservation');
            const selectDebut= document.getElementById('heure_debut');
            const selectFin  = document.getElementById('heure_fin');
            const closedAlert= document.getElementById('closed-alert');
            const btnSubmit  = document.getElementById('btn-submit');

            function getJourNom(dateStr) {
                const d = new Date(dateStr + 'T00:00:00');
                return joursMap[d.getDay()];
            }

            function buildOptions(select, heureMin, heureMax, oldVal) {
                select.innerHTML = '';
                const def = document.createElement('option');
                def.value = '';
                def.textContent = '-- Choisir --';
                select.appendChild(def);

                const [hMin] = heureMin.split(':').map(Number);
                // 00:00 = minuit = fin de journée → traiter comme 24
                const hMaxRaw = heureMax.split(':').map(Number)[0];
                const [hMax] = [hMaxRaw === 0 ? 24 : hMaxRaw];

                for (let h = hMin; h <= hMax; h++) {
                    const val = h === 24 ? '00:00' : String(h).padStart(2, '0') + ':00';
                    const opt = document.createElement('option');
                    opt.value = val;
                    opt.textContent = val;
                    if (val === oldVal) opt.selected = true;
                    select.appendChild(opt);
                }
            }

            function updateHeures(dateStr) {
                const jour = getJourNom(dateStr);
                const h = horaires[jour];

                if (!h || !h.ouverture || !h.fermeture) {
                    // Jour fermé
                    closedAlert.style.display = 'block';
                    selectDebut.innerHTML = '<option value="">Club fermé ce jour</option>';
                    selectFin.innerHTML   = '<option value="">Club fermé ce jour</option>';
                    selectDebut.disabled  = true;
                    selectFin.disabled    = true;
                    btnSubmit.disabled    = true;
                    return;
                }

                closedAlert.style.display = 'none';

                // heure_debut : de ouverture à fermeture-1 (00:00 = 24h)
                const [hOuv] = h.ouverture.split(':').map(Number);
                const hFerRaw = h.fermeture.split(':').map(Number)[0];
                const hFer = hFerRaw === 0 ? 24 : hFerRaw;

                buildOptions(selectDebut, h.ouverture, String(hFer - 1).padStart(2,'0') + ':00', oldDebut);
                buildOptions(selectFin,   String(hOuv + 1).padStart(2,'0') + ':00', h.fermeture, oldFin);

                selectDebut.disabled = false;
                selectFin.disabled   = false;
                btnSubmit.disabled   = false;

                // Quand début change, recalculer fin (min = début+1)
                selectDebut.onchange = function() {
                    const hD = this.value === '00:00' ? 24 : parseInt(this.value);
                    buildOptions(selectFin, String(hD + 1 === 25 ? 0 : hD + 1).padStart(2,'0') + ':00', h.fermeture, '');
                };
            }

            // ── Afficher/cacher le formulaire carte ──────────────────────────────
            document.querySelectorAll('input[name="methode_paiement"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    const carteForm = document.getElementById('carte-form');
                    carteForm.style.display = this.value === 'en_ligne' ? 'block' : 'none';
                });
            });

            // Si old() = en_ligne (après erreur validation), afficher le formulaire
            if (document.getElementById('en_ligne').checked) {
                document.getElementById('carte-form').style.display = 'block';
            }

            // ── Formatage numéro carte (XXXX XXXX XXXX XXXX) ─────────────────────
            document.getElementById('carte_numero').addEventListener('input', function() {
                let val = this.value.replace(/\D/g, '').substring(0, 16);
                this.value = val.replace(/(.{4})/g, '$1 ').trim();
                // Détection type carte
                const icon = document.getElementById('card-brand-icon');
                if (/^4/.test(val)) {
                    icon.className = 'bi bi-credit-card text-primary'; // Visa
                } else if (/^5[1-5]/.test(val)) {
                    icon.className = 'bi bi-credit-card-2-front text-danger'; // Mastercard
                } else {
                    icon.className = 'bi bi-credit-card text-muted';
                }
            });

            // ── Formatage date expiration (MM/AA) ────────────────────────────────
            document.getElementById('carte_expiry').addEventListener('input', function() {
                let val = this.value.replace(/\D/g, '').substring(0, 4);
                if (val.length >= 3) val = val.substring(0,2) + '/' + val.substring(2);
                this.value = val;
            });

            // ── CVV : chiffres uniquement ────────────────────────────────────────
            document.getElementById('carte_cvv').addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, '').substring(0, 3);
            });

            // ── Validation carte avant soumission ───────────────────────────────
            document.querySelector('form').addEventListener('submit', function(e) {
                const methodePaiement = document.querySelector('input[name="methode_paiement"]:checked')?.value;
                if (methodePaiement !== 'en_ligne') return; // Pas besoin de valider

                let valid = true;

                const nom    = document.getElementById('carte_nom').value.trim();
                const numero = document.getElementById('carte_numero').value.replace(/\s/g, '');
                const expiry = document.getElementById('carte_expiry').value;
                const cvv    = document.getElementById('carte_cvv').value;

                // Nom
                if (nom.length < 3) {
                    showError('carte_nom', 'err_nom', 'Veuillez saisir le nom du titulaire.');
                    valid = false;
                } else clearError('carte_nom', 'err_nom');

                // Numéro (16 chiffres)
                if (!/^\d{16}$/.test(numero)) {
                    showError('carte_numero', 'err_numero', 'Numéro de carte invalide (16 chiffres requis).');
                    valid = false;
                } else clearError('carte_numero', 'err_numero');

                // Expiry MM/AA
                if (!/^\d{2}\/\d{2}$/.test(expiry)) {
                    showError('carte_expiry', 'err_expiry', 'Format invalide. Exemple : 08/27');
                    valid = false;
                } else {
                    const [mm, aa] = expiry.split('/').map(Number);
                    const now = new Date();
                    const expDate = new Date(2000 + aa, mm - 1);
                    if (mm < 1 || mm > 12 || expDate < now) {
                        showError('carte_expiry', 'err_expiry', 'Carte expirée ou date invalide.');
                        valid = false;
                    } else clearError('carte_expiry', 'err_expiry');
                }

                // CVV
                if (!/^\d{3}$/.test(cvv)) {
                    showError('carte_cvv', 'err_cvv', 'CVV invalide (3 chiffres).');
                    valid = false;
                } else clearError('carte_cvv', 'err_cvv');

                if (!valid) e.preventDefault();
            });

            function showError(inputId, errId, msg) {
                const input = document.getElementById(inputId);
                input.classList.add('is-invalid');
                const err = document.getElementById(errId);
                err.textContent = msg;
                err.style.display = 'block';
            }
            function clearError(inputId, errId) {
                document.getElementById(inputId).classList.remove('is-invalid');
                document.getElementById(errId).style.display = 'none';
            }

            // ── Date input ───────────────────────────────────────────────────────
            dateInput.addEventListener('change', function() {
                if (this.value) updateHeures(this.value);
            });

            // Restaurer si old() existe (après erreur de validation)
            if (oldDate) updateHeures(oldDate);
        </script>
    <?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xamppp\htdocs\PF\resources\views/Client/reserver.blade.php ENDPATH**/ ?>