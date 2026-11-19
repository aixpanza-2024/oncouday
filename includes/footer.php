<?php
declare(strict_types=1);

$showDisclaimer ??= false;
?>
</main>

<?php if ($showDisclaimer): ?>
    <div class="disclaimer-strip">
        <div class="container">
            <p class="mb-0"><i class="bi bi-info-circle" aria-hidden="true"></i>
                OncoUday shares clinical trial information only. It is not medical advice and does not recommend any treatment. Always talk to your doctor before deciding to join a trial.</p>
        </div>
    </div>
<?php endif; ?>

<footer class="site-footer">
    <div class="container-xxl">
        <div class="row g-5">
            <div class="col-lg-4">
                <a class="footer-brand" href="<?= e(url('index.php')) ?>">
                    <span class="footer-logo"><img src="<?= e(asset('img/logo.png')) ?>" alt="" width="40" height="40"></span>
                    <span class="brand-name">Onco<span>Uday</span></span>
                </a>
                <p class="footer-tagline">India's gateway to cancer clinical trials and patient support.</p>
                <a class="btn btn-whatsapp btn-sm mb-3" href="<?= e(whatsapp_chat_url()) ?>" target="_blank" rel="noopener"><i class="bi bi-whatsapp me-1" aria-hidden="true"></i> WhatsApp us</a>
                <ul class="social-list list-unstyled d-flex gap-2 mb-0">
                    <?php foreach (config('social') as $s): ?>
                        <li><a href="<?= e($s['url']) ?>" aria-label="<?= e($s['label']) ?>"><i class="bi bi-<?= e($s['icon']) ?>" aria-hidden="true"></i></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php foreach (content()->footerColumns() as $heading => $links): ?>
                <div class="col-6 col-md-3 col-lg-2">
                    <h2 class="footer-heading"><?= e($heading) ?></h2>
                    <ul class="list-unstyled footer-links">
                        <?php foreach ($links as $link): ?>
                            <li><a href="<?= e(url($link['href'])) ?>"><?= e($link['label']) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="footer-bottom">
            <?php /* Old: source note moved to explore-trials.php (below the results)
            <p>OncoUday shares trial information only and does not give medical advice. Some listings come from ClinicalTrials.gov, a service of the U.S. National Library of Medicine, and are labelled with their source.</p>
            */ ?>
            <div class="d-flex flex-wrap justify-content-between gap-2">
                <span>&copy; <?= e(date('Y')) ?> OncoUday. All rights reserved.</span>
                <span>Designed &amp; developed by <strong class="text-white">AIXPANZA</strong>, technology partner</span>
                <a href="<?= e(url('grievance-redressal.php')) ?>">Grievance Officer</a>
            </div>
        </div>
    </div>
</footer>

<a href="<?= e(whatsapp_chat_url()) ?>" class="wa-float" target="_blank" rel="noopener" aria-label="WhatsApp us">
    <i class="bi bi-whatsapp" aria-hidden="true"></i><span>WhatsApp us</span>
</a>
<a href="#main" class="back-to-top" aria-label="Back to top"><i class="bi bi-arrow-up" aria-hidden="true"></i></a>

<?php partial('modals'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous" defer></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js" crossorigin="anonymous" defer></script>
<script src="<?= e(asset('js/main.js')) ?>" defer></script>
</body>
</html>
