<?php
$theme ??= 'orange';
$text  ??= '';
?>
<section class="cta-band cta-band--<?= e($theme) ?>">
    <div class="container">
        <div class="cta-band__inner" data-aos="fade-up">
            <div>
                <h2 class="cta-band__title"><?= e($title) ?></h2>
                <?php if ($text !== ''): ?><p class="mb-0"><?= e($text) ?></p><?php endif; ?>
            </div>
            <div class="cta-band__actions">
                <?php foreach ($buttons as $b): ?>
                    <a class="btn <?= e($b['class']) ?>" href="<?= e(url($b['href'])) ?>"><?= e($b['label']) ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
