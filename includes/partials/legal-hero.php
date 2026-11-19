<?php
$docVersion ??= '1.0';
$current    ??= '';
?>
<section class="page-hero">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="<?= !empty($art) ? 'col-lg-8' : 'col-lg-10' ?>">
                <p class="eyebrow mb-2" data-aos="fade-up">Legal</p>
                <h1 class="page-title" data-aos="fade-up"><?= e($title) ?></h1>
                <?php if (!empty($summary)): ?>
                    <p class="lead-ou" data-aos="fade-up" data-aos-delay="80"><?= e($summary) ?></p>
                <?php endif; ?>
                <p class="legal-meta" data-aos="fade-up" data-aos-delay="120">
                    <span><i class="bi bi-calendar-check" aria-hidden="true"></i> Effective from <?= e(format_date(config('legal.effective'))) ?></span>
                    <span><i class="bi bi-file-earmark-text" aria-hidden="true"></i> Version <?= e($docVersion) ?></span>
                </p>
            </div>
            <?php if (!empty($art)): ?>
                <div class="col-lg-4 d-flex justify-content-center justify-content-lg-end">
                    <?php illustration($art); ?>
                </div>
            <?php endif; ?>
        </div>
        <nav class="legal-links" aria-label="Legal documents" data-aos="fade-up" data-aos-delay="200">
            <?php foreach (content()->legalPages() as $doc): ?>
                <a class="chip<?= $doc['key'] === $current ? ' active' : '' ?>" href="<?= e(url($doc['href'])) ?>"<?= $doc['key'] === $current ? ' aria-current="page"' : '' ?>><?= e($doc['label']) ?></a>
            <?php endforeach; ?>
        </nav>
    </div>
</section>
