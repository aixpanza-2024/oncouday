<?php
declare(strict_types=1);
require __DIR__ . '/app/bootstrap.php';

$page = [
    'title'       => 'FAQ',
    'active'      => 'faq',
    'description' => 'Answers for patients, caregivers and doctors about OncoUday, WhatsApp trial alerts, privacy and how trial listings work.',
];
$categories = content()->faqCategories();
$faqs       = content()->faqs();

require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <?php illustration('cells'); ?>
    <div class="container position-relative">
        <h1 class="page-title" data-aos="fade-up">What patients and doctors ask us</h1>
        <p class="lead-ou" data-aos="fade-up" data-aos-delay="100">Answers for patients, caregivers and doctors. Can't find what you need? <a href="<?= e(url('contact.php')) ?>">Contact us</a>.</p>

        <div class="faq-tools" data-aos="fade-up" data-aos-delay="200">
            <div class="chip-row nav" role="tablist">
                <?php foreach ($categories as $i => $cat): ?>
                    <button class="chip<?= $i === 0 ? ' active' : '' ?>" type="button" data-bs-toggle="pill" data-bs-target="#faq-<?= e($cat['slug']) ?>"
                            role="tab" aria-controls="faq-<?= e($cat['slug']) ?>" aria-selected="<?= $i === 0 ? 'true' : 'false' ?>"><?= e($cat['name']) ?></button>
                <?php endforeach; ?>
            </div>
            <div class="faq-search">
                <i class="bi bi-search" aria-hidden="true"></i>
                <label class="visually-hidden" for="faqSearch">Search questions</label>
                <input class="form-control js-faq-search" type="search" id="faqSearch" maxlength="60" placeholder="Search questions">
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="tab-content">
            <?php foreach ($categories as $i => $cat): ?>
                <div class="tab-pane fade<?= $i === 0 ? ' show active' : '' ?>" id="faq-<?= e($cat['slug']) ?>" role="tabpanel">
                    <div class="accordion faq-accordion" id="acc-<?= e($cat['slug']) ?>">
                        <?php foreach ($faqs[$cat['slug']] ?? [] as $n => $faq): $id = $cat['slug'] . '-' . $n; ?>
                            <div class="accordion-item js-faq-item" data-aos="fade-up" data-aos-delay="<?= min($n, 5) * 60 ?>">
                                <h2 class="accordion-header">
                                    <button class="accordion-button<?= ($i === 0 && $n === 0) ? '' : ' collapsed' ?>" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#q-<?= e($id) ?>" aria-expanded="<?= ($i === 0 && $n === 0) ? 'true' : 'false' ?>" aria-controls="q-<?= e($id) ?>">
                                        <?= e($faq['q']) ?>
                                    </button>
                                </h2>
                                <div id="q-<?= e($id) ?>" class="accordion-collapse collapse<?= ($i === 0 && $n === 0) ? ' show' : '' ?>" data-bs-parent="#acc-<?= e($cat['slug']) ?>">
                                    <div class="accordion-body"><?= e($faq['a']) ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <p class="faq-empty text-center text-muted-ou mt-4 js-faq-empty" hidden>No questions match your search. Try another word, or <a href="<?= e(url('contact.php')) ?>">ask us directly</a>.</p>

        <div class="ask-card" data-aos="zoom-in">
            <div>
                <h2>Ask the OncoUday team directly</h2>
                <p class="mb-0">Our team will get back to you. For medical questions, please speak to your doctor.</p>
            </div>
            <a class="btn btn-orange" href="<?= e(url('contact.php')) ?>">Contact us</a>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
