<?php
declare(strict_types=1);
require __DIR__ . '/app/bootstrap.php';

$page = [
    'title'       => 'Advocacy Centre',
    'active'      => 'advocacy',
    'description' => 'Your rights as a clinical trial participant and ways to get support — for patients, caregivers and families in India.',
];
require __DIR__ . '/includes/header.php';
?>

<section class="page-hero page-hero--orange">
    <?php illustration('rings', ['variant' => 'advocacy']); ?>
    <div class="container position-relative">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <h1 class="page-title" data-aos="fade-up">Informed patients make confident choices</h1>
                <p class="lead-ou" data-aos="fade-up" data-aos-delay="100">Your rights as a trial participant and ways to get support — for patients, caregivers and families.</p>
                <?php partial('reviewed', ['key' => 'advocacy']); ?>
            </div>
            <div class="col-lg-6">
                <div class="row g-3 pillar-cards">
                    <?php
                    $pillars = [
                        ['bi-lightbulb', 'Awareness', 'What trials are and how they work'],
                        ['bi-geo', 'Access', 'Finding trials beyond the big cities'],
                        ['bi-shield-check', 'Rights', 'Consent, safety and privacy'],
                        ['bi-people', 'Support', 'Help for patients and families'],
                    ];
                    foreach ($pillars as $i => [$icon, $t, $d]): ?>
                        <div class="col-6">
                            <div class="pillar-card" data-aos="zoom-in" data-aos-delay="<?= 100 + $i * 100 ?>">
                                <i class="bi <?= e($icon) ?>" aria-hidden="true"></i>
                                <h2><?= e($t) ?></h2>
                                <p class="mb-0"><?= e($d) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4">
                <h2 class="section-title" data-aos="fade-up">Your rights as a trial participant</h2>
                <p class="section-lead" data-aos="fade-up" data-aos-delay="80">These protections apply to every clinical trial, whichever hospital runs it.</p>
            </div>
            <div class="col-lg-8">
                <div class="row g-3">
                    <?php foreach (content()->rights() as $i => $r): ?>
                        <div class="col-sm-6">
                            <div class="right-item h-100" data-aos="fade-up" data-aos-delay="<?= ($i % 2) * 100 + intdiv($i, 2) * 60 ?>">
                                <i class="bi bi-check2" aria-hidden="true"></i>
                                <div>
                                    <h3><?= e($r['title']) ?></h3>
                                    <p class="mb-0"><?= e($r['text']) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section bg-navy text-white">
    <div class="container">
        <h2 class="section-title text-white section-head maxw-480" data-aos="fade-up">Help more patients find their options</h2>
        <?php
        $help = [
            ['Patient groups', 'Partner with us to share trial awareness with your community.', 'Partner with us', 'contact.php'],
            ['Hospitals and doctors', 'List your trials so the right patients hear about them.', 'Register as a doctor', 'doctor-registration.php'],
            ['Volunteers', 'Help translate information and support awareness events.', 'Volunteer', 'contact.php'],
        ];
 ?>
        <div class="row g-4">
            <?php foreach ($help as $i => [$t, $d, $l, $h]): ?>
                <div class="col-md-4">
                    <div class="help-card h-100" data-aos="fade-up" data-aos-delay="<?= $i * 120 ?>">
                        <h3><?= e($t) ?></h3>
                        <p><?= e($d) ?></p>
                        <a class="link-arrow link-arrow--orange" href="<?= e(url($h)) ?>"><?= e($l) ?> <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php partial('cta-band', [
    'title'   => 'Find the trial meant for you',
    'text'    => "Register once and we'll alert you on WhatsApp when a matching trial opens.",
    'buttons' => [['label' => 'Register for trial alerts', 'href' => 'patient-registration.php', 'class' => 'btn-magenta']],
    'theme'   => 'cream',
]); ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
