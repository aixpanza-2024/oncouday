<?php
$cta ??= null;
?>
<section class="section legal-section">
    <div class="container">
        <div class="row g-4 g-lg-5">
            <aside class="col-lg-3">
                <nav class="legal-toc" id="legalToc" aria-label="Contents" data-aos="fade-right">
                    <h2 class="legal-toc__title">Contents</h2>
                    <ol class="list-unstyled mb-0">
                        <?php foreach ($sections as $i => $s): ?>
                            <li><a class="nav-link" href="#<?= e($s['id']) ?>"><span><?= $i + 1 ?></span><?= e($s['title']) ?></a></li>
                        <?php endforeach; ?>
                    </ol>
                </nav>
            </aside>
            <div class="col-lg-9 col-xl-8">
                <div class="legal-body" data-bs-spy="scroll" data-bs-target="#legalToc" data-bs-smooth-scroll="true">
                    <?php foreach ($sections as $i => $s): ?>
                        <section class="legal-item" id="<?= e($s['id']) ?>" data-aos="fade-up">
                            <h2><span><?= $i + 1 ?>.</span> <?= e($s['title']) ?></h2>
                            <?= legal_html($s['html']) ?>
                        </section>
                    <?php endforeach; ?>

                    <?php if ($cta): ?>
                        <div class="legal-cta" data-aos="zoom-in">
                            <div>
                                <h2 class="h6 mb-1"><?= e($cta['title']) ?></h2>
                                <p class="mb-0"><?= e($cta['text']) ?></p>
                            </div>
                            <a class="btn btn-orange" href="<?= e(url($cta['href'])) ?>"><?= e($cta['label']) ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
