<?php $reviewedOn = content()->reviewedOn($key ?? ''); ?>
<?php if ($reviewedOn): ?>
    <p class="reviewed-note" data-aos="fade-up" data-aos-delay="<?= (int) ($delay ?? 150) ?>">
        <i class="bi bi-calendar-check" aria-hidden="true"></i>
        Information last reviewed on <time datetime="<?= e($reviewedOn) ?>"><?= e(format_date($reviewedOn)) ?></time>
    </p>
<?php endif; ?>
