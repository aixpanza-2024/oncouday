<?php
declare(strict_types=1);
require __DIR__ . '/app/bootstrap.php';

$page = [
    'title'       => 'About Us',
    'active'      => 'about',
    'description' => 'Why we built OncoUday: connecting patients, caregivers and doctors to cancer clinical trials in India through WhatsApp, in the languages people speak.',
];
require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <h1 class="page-title" data-aos="fade-up">Why we built OncoUday</h1>
                <p class="lead-ou" data-aos="fade-up" data-aos-delay="100">OncoUday brings patients, caregivers and doctors together on the app India already uses every day — WhatsApp — in the languages people actually speak.</p>
                <?php partial('reviewed', ['key' => 'about']); ?>
            </div>
            <div class="col-lg-5 d-flex justify-content-center justify-content-lg-end">
                <?php illustration('orbit'); ?>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="mv-card mv-card--orange" data-aos="fade-right">
                    <i class="bi bi-bullseye mv-card__icon" aria-hidden="true"></i>
                    <h2>Our mission</h2>
                    <p>To make sure no cancer patient or doctor in India misses a clinical trial simply because they have never heard about it, with real-time updates directly from researchers and trial teams.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mv-card mv-card--navy" data-aos="fade-left">
                    <i class="bi bi-eye mv-card__icon" aria-hidden="true"></i>
                    <h2>Our vision</h2>
                    <p>A simple database to search for trials and other patient services, as simple as a text message, for every patient, in every language and in every city.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section bg-peach">
    <div class="container">
        <h2 class="section-title section-head" data-aos="fade-up">Who OncoUday serves</h2>
        <?php
        $serves = [
            ['bi-person-heart', 'Connect patients to trials', 'Patients register once and receive WhatsApp alerts when a trial matching their city and cancer type opens.'],
            ['bi-clipboard2-pulse', 'Support doctors', "Doctors running trials list and update them in a guided WhatsApp chat. Doctors who don't run trials get alerts so they stay informed about new trials."],
            ['bi-megaphone', 'Advocate for patients', 'Our Advocacy Centre helps patients and families understand trials and their rights before they decide.'],
        ];
 ?>
        <div class="row g-4">
            <?php foreach ($serves as $i => [$icon, $t, $d]): ?>
                <div class="col-md-4">
                    <div class="info-card h-100" data-aos="fade-up" data-aos-delay="<?= $i * 120 ?>">
                        <span class="icon-badge"><i class="bi <?= e($icon) ?>" aria-hidden="true"></i></span>
                        <h3><?= e($t) ?></h3>
                        <p class="mb-0"><?= e($d) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section bg-navy text-white">
    <div class="container">
        <h2 class="section-title text-white section-head maxw-480" data-aos="fade-up">Built for how India communicates</h2>
        <?php
        $pillars = [
            ['WhatsApp-first', 'Alerts arrive in the app people already open many times a day.'],
            ['Regional languages', 'The website is available in English, Hindi and Malayalam. More languages coming soon.'],
            ['Doctors manage from chat', 'Trials are added, updated and closed in a few taps on WhatsApp.'],
            ['Always current', 'Data refreshed daily, with real-time updates directly from researchers and trial teams, weekly checks with doctors and a nightly import from ClinicalTrials.gov.'],
        ];
 ?>
        <div class="row g-4">
            <?php foreach ($pillars as $i => [$t, $d]): ?>
                <div class="col-sm-6 col-lg-3">
                    <div class="pillar" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                        <span class="pillar__num" data-count="<?= $i + 1 ?>" data-pad="2">0<?= $i + 1 ?></span>
                        <h3><?= e($t) ?></h3>
                        <p><?= e($d) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <h2 class="section-title section-head" data-aos="fade-up">The people behind OncoUday</h2>
        <?php foreach (content()->team() as $group => $members): ?>
            <h3 class="team-group" data-aos="fade-up"><?= e($group) ?></h3>
            <div class="row g-4 mb-4">
                <?php foreach ($members as $i => $m):
                    $initials = implode('', array_map(static fn ($w) => mb_substr($w, 0, 1), array_slice(array_values(array_filter(explode(' ', $m['name']), static fn ($w) => $w !== 'Dr')), 0, 2)));
                ?>
                    <div class="col-sm-6 col-lg-3">
                        <div class="team-card" data-aos="flip-left" data-aos-delay="<?= $i * 100 ?>">
                            <?php if (!empty($m['photo'])): ?>
                                <img class="team-card__photo" src="<?= e(asset($m['photo'])) ?>" alt="<?= e($m['name']) ?>" width="480" height="600" loading="lazy">
                            <?php else: ?>
                                <div class="team-card__photo" aria-hidden="true"><?= e($initials) ?></div>
                            <?php endif; ?>
                            <h4><?= e($m['name']) ?></h4>
                            <p class="mb-0"><?= e($m['role']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php partial('cta-band', [
    'title'   => 'Join OncoUday as a patient or a doctor',
    'buttons' => [
        ['label' => "I'm a patient", 'href' => 'patient-registration.php', 'class' => 'btn-magenta'],
        ['label' => "I'm a doctor",  'href' => 'doctor-registration.php',  'class' => 'btn-navy'],
    ],
]); ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
