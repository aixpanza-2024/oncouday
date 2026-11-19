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

<section class="section section--story">
    <div class="container">
        <div class="row g-4 g-lg-5">
            <div class="col-lg-4">
                <h2 class="section-title" data-aos="fade-up">Why OncoUday?</h2>
                <blockquote class="story-quote" data-aos="fade-up" data-aos-delay="100">
                    <p>OncoUday, meaning <em>“the dawn of oncology”</em>, is built on a simple belief: access to a clinical trial should depend on a patient’s needs, not on whom their doctor happens to know.</p>
                </blockquote>
            </div>
            <div class="col-lg-8 story">
                <p class="story-lead" data-aos="fade-up">Every oncologist knows the moment: a patient has run out of standard options, or can’t afford a particular medicine, and the question becomes, “Is there a trial for this?”</p>
                <p data-aos="fade-up" data-aos-delay="60">For years, search engines and portals have existed in India and abroad, yet finding the right trial is still very difficult, for doctors and patients alike. Physicians still search for trials through WhatsApp groups or by asking colleagues, desperate to help patients in need. A message goes out, replies trickle in, and the right trial is found through goodwill rather than a system.</p>
                <p data-aos="fade-up" data-aos-delay="60">For our founder, this was personal. When his father was living with multiple myeloma, he searched for a clinical trial as a son, while still a junior doctor, and could not find one when it was needed most. If it was this hard for someone with a medical background, he realised how much harder it must be for families without one. That experience stayed with him through his training as an oncologist.</p>
                <p data-aos="fade-up" data-aos-delay="60">He saw that the time was right for a trial search database fed directly by trial teams through WhatsApp updates. Instead of waiting for registry entries to be updated, the people running the trials share updates themselves, so the information stays current and reaches the people who need it.</p>
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

<section class="section">
    <div class="container">
        <div class="section-head">
            <h2 class="section-title" data-aos="fade-up">What OncoUday aims to offer</h2>
            <p class="section-lead" data-aos="fade-up" data-aos-delay="80">OncoUday is designed to serve the whole oncology community: patients, treating doctors and investigators.</p>
        </div>
        <?php
        $offers = [
            ['bi-search-heart', 'Free, oncology-specific search', 'A simple search for cancer trials running in India, free for everyone. Not a copy of a registry.'],
            ['bi-chat-heart', 'Plain-language explanations', 'Information written so that patients and families can follow it.'],
            ['bi-translate', 'Multilingual access', 'Available in several languages, so language is not a barrier.'],
            ['bi-bell', 'Referrals and alerts', 'Doctors can refer a patient, and people are told when a relevant trial opens.'],
            ['bi-clipboard2-pulse', 'For investigators', 'Research teams share and update their own trial details.'],
            ['bi-whatsapp', 'WhatsApp-based updates', 'Updates that fit how Indian doctors already work.'],
        ];
 ?>
        <div class="row g-4">
            <?php foreach ($offers as $i => [$icon, $t, $d]): ?>
                <div class="col-sm-6 col-lg-4">
                    <div class="info-card info-card--offer h-100" data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 100 ?>">
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

<section class="section section--tight">
    <div class="container">
        <div class="about-disclaimer" data-aos="fade-up">
            <i class="bi bi-info-circle" aria-hidden="true"></i>
            <p class="mb-0"><strong>Disclaimer:</strong> OncoUday does not provide medical advice or guarantee trial participation. Trial information is shared by research teams and should be confirmed with them. Eligibility is decided by the trial team. Patient information is handled with consent and is not shared without permission.</p>
        </div>
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
