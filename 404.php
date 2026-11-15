<?php
declare(strict_types=1);
require __DIR__ . '/app/bootstrap.php';

http_response_code(404);
$page = ['title' => 'Page not found', 'active' => ''];
require __DIR__ . '/includes/header.php';
?>

<section class="page-hero text-center">
    <?php illustration('sunrise'); ?>
    <div class="container position-relative py-5">
        <p class="eyebrow" data-aos="fade-up">Error 404</p>
        <h1 class="page-title" data-aos="fade-up" data-aos-delay="80">We couldn't find that page</h1>
        <p class="lead-ou mx-auto" data-aos="fade-up" data-aos-delay="160">The link may be old or mistyped. You can search for trials or go back to the home page.</p>
        <div class="d-flex flex-wrap gap-3 justify-content-center mt-4" data-aos="fade-up" data-aos-delay="240">
            <a class="btn btn-navy" href="<?= e(url('index.php')) ?>">Go to home</a>
            <a class="btn btn-orange" href="<?= e(url('explore-trials.php')) ?>">Explore trials</a>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
