<?php
$variant ??= 'full';
$delay   ??= 0;
$isRecruiting = $trial['status'] === 'recruiting';
$sourceLabel  = $trial['source'] === 'doctor'
    ? 'Added by ' . ($trial['doctor_name'] ?? 'a doctor')
    : 'Source: ClinicalTrials.gov';
$contact = $trial['contact'] ?? [];
?>
<article class="trial-card trial-card--<?= e($variant) ?>" id="trial-<?= e($trial['public_id']) ?>"
         data-aos="fade-up" data-aos-delay="<?= (int) $delay ?>">
    <header class="trial-card__meta">
        <span class="trial-type"><span class="sq" aria-hidden="true"></span><?= e($trial['cancer_type']) ?></span>
        <span class="trial-status <?= $isRecruiting ? 'is-recruiting' : 'is-pending' ?>">
            <span class="dot" aria-hidden="true"></span><?= e(TrialService::statusLabel($trial['status'])) ?>
        </span>
        <span class="trial-phase">Phase <?= e($trial['phase']) ?></span>
        <?php if ($variant === 'full'): ?>
            <span class="trial-id ms-auto"><?= e($trial['registry_id']) ?></span>
        <?php endif; ?>
    </header>

    <h3 class="trial-card__title"><?= e($trial['title']) ?></h3>

    <?php if ($variant === 'full'): ?>
        <dl class="trial-card__facts">
            <div><dt>Medicines</dt><dd><?= e($trial['medicines']) ?></dd></div>
            <div><dt>Hospital</dt><dd><?= e($trial['hospital']) ?></dd></div>
            <div><dt>City</dt><dd><?= e($trial['city']) ?></dd></div>
        </dl>
    <?php else: ?>
        <dl class="trial-card__facts trial-card__facts--stack">
            <div><dt>Medicines</dt><dd><?= e($trial['medicines']) ?></dd></div>
            <div><dt>Where</dt><dd><?= e($trial['hospital']) ?>, <?= e($trial['city']) ?></dd></div>
        </dl>
    <?php endif; ?>

    <footer class="trial-card__foot">
        <span class="trial-source">
            <i class="bi <?= $trial['source'] === 'doctor' ? 'bi-person-badge' : 'bi-globe2' ?>" aria-hidden="true"></i>
            <?= e($sourceLabel) ?>
        </span>
        <?php if ($variant === 'full'): ?>
            <button type="button" class="btn btn-orange btn-sm-md js-enrolment"
                    data-title="<?= e($trial['title']) ?>"
                    data-cancer="<?= e($trial['cancer_type']) ?>"
                    data-name="<?= e($contact['name'] ?? '') ?>"
                    data-email="<?= e($contact['email'] ?? '') ?>"
                    data-phone="<?= e($contact['phone'] ?? '') ?>"
                    data-hospital="<?= e($trial['hospital'] . ', ' . $trial['city']) ?>"
                    data-registry="<?= e($trial['registry_id']) ?>">
                View enrolment contact
            </button>
        <?php else: ?>
            <a class="link-arrow" href="<?= e(url('explore-trials.php')) ?>#trial-<?= e($trial['public_id']) ?>">Details <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
        <?php endif; ?>
    </footer>
</article>
