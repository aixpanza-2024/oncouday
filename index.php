<?php
declare(strict_types=1);
require __DIR__ . '/app/bootstrap.php';

$page = [
    'title'  => '',
    'active' => 'home',
];
$recentTrials   = trials()->recent(3);
$showDisclaimer = true;

require __DIR__ . '/includes/header.php';
?>

<section class="hero hero-home">
    <?php illustration('sunrise'); ?>
    <div class="container position-relative">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <h1 class="display-hero" data-aos="fade-up">India's gateway to <span class="text-gradient">cancer clinical trials</span> and patient support</h1>
                <p class="lead-ou" data-aos="fade-up" data-aos-delay="100">Register once with your city and cancer type. When a matching trial opens, we tell you on WhatsApp, the app you already use every day.</p>
                <div class="d-flex flex-wrap gap-3 mt-4" data-aos="fade-up" data-aos-delay="200">
                    <a class="btn btn-magenta btn-lg-ou" href="<?= e(url('patient-registration.php')) ?>">Register as a patient</a>
                    <a class="btn btn-navy btn-lg-ou" href="<?= e(url('doctor-registration.php')) ?>">Register as a doctor</a>
                </div>
                <p class="small-note mt-3" data-aos="fade-up" data-aos-delay="300">Available in English, <span lang="hi">हिन्दी</span> and <span lang="ml">മലയാളം</span>. More languages coming soon.</p>
            </div>

            <div class="col-lg-5">
                <div class="phone-chat" data-aos="zoom-in-left" data-aos-delay="150">
                    <div class="phone-chat__head">
                        <span class="avatar"><img src="<?= e(asset('img/logo.svg')) ?>" alt="" width="28" height="28"></span>
                        <span><strong>OncoUday</strong><small>WhatsApp alerts</small></span>
                        <i class="bi bi-patch-check-fill ms-auto" aria-hidden="true"></i>
                    </div>
                    <div class="phone-chat__body js-chat">
                        <div class="chat-msg in">Hello [Name], thank you for registering with OncoUday. We'll message you when a trial matches your registered preferences.</div>
                        <div class="chat-msg in"><strong>Update on your preferences</strong><br>A new trial is now open in Thiruvananthapuram.<br><span class="chat-link">oncouday.in/t/[id]</span></div>
                        <div class="chat-msg out">Thank you! <i class="bi bi-check2-all" aria-hidden="true"></i></div>
                        <div class="chat-typing" aria-hidden="true"><span></span><span></span><span></span></div>
                        <p class="chat-note">Reply STOP any time to stop alerts.</p>
                    </div>
                    <div class="phone-chat__foot"><i class="bi bi-lock" aria-hidden="true"></i> Alerts never mention your diagnosis.</div>
                </div>
            </div>
        </div>

        <form class="search-card" action="<?= e(url('explore-trials.php')) ?>" method="get" role="search" data-aos="fade-up" data-aos-delay="100">
            <div class="row g-3 align-items-end">
                <div class="col-md-6 col-lg-3">
                    <label class="form-label" for="hsCancer">Cancer type</label>
                    <select class="form-select" id="hsCancer" name="cancer">
                        <option value="">All cancer types</option>
                        <?php foreach (content()->cancerTypes() as $c): ?>
                            <option value="<?= e($c['slug']) ?>"><?= e($c['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 col-lg-3">
                    <label class="form-label" for="hsCity">City</label>
                    <select class="form-select" id="hsCity" name="city">
                        <option value="">All cities</option>
                        <?php foreach (content()->cities() as $c): ?>
                            <option value="<?= e($c['slug']) ?>"><?= e($c['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-8 col-lg-4">
                    <label class="form-label" for="hsMedicine">Medicine (optional)</label>
                    <input class="form-control" id="hsMedicine" name="q" type="search" maxlength="80" placeholder="e.g. a drug name" autocomplete="off">
                </div>
                <div class="col-md-4 col-lg-2">
                    <button class="btn btn-orange w-100" type="submit"><i class="bi bi-search me-1" aria-hidden="true"></i> Search trials</button>
                </div>
            </div>
        </form>

        <a class="explore-banner" href="<?= e(url('explore-trials.php')) ?>" data-aos="fade-up" data-aos-delay="150">
            <span class="explore-banner__icon" aria-hidden="true"><i class="bi bi-radar"></i></span>
            <span class="flex-grow-1">
                <strong>Explore all open trials</strong>
                <small>Browse every cancer trial in India by type, city, medicine and phase</small>
            </span>
            <span class="explore-banner__arrow" aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
        </a>
    </div>
</section>

<section class="section bg-peach">
    <div class="container">
        <div class="section-head d-flex flex-wrap justify-content-between align-items-end gap-3">
            <h2 class="section-title mb-0" data-aos="fade-right">Recently updated trials</h2>
            <a class="link-arrow" href="<?= e(url('explore-trials.php')) ?>" data-aos="fade-left">See all active trials <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
        </div>
        <div class="row g-4">
            <?php foreach ($recentTrials as $i => $trial): ?>
                <div class="col-md-6 col-lg-4">
                    <?php partial('trial-card', ['trial' => $trial, 'variant' => 'compact', 'delay' => $i * 100]); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <h2 class="section-title" data-aos="fade-up">Three ways to use OncoUday</h2>
            <p class="section-lead" data-aos="fade-up" data-aos-delay="80">Patients, doctors running trials and doctors following trials all start on this website. After that, everything happens on WhatsApp.</p>
        </div>
        <?php
        $ways = [
            ['title' => 'For patients and caregivers', 'theme' => 'orange', 'cta' => ['Register as a patient', 'patient-registration.php', 'btn-magenta'], 'steps' => [
                ['Register on the website', 'Your name, WhatsApp number, city and cancer type. It takes about two minutes.'],
                ['We match you to trials', 'Every new or updated trial is checked against your city and cancer type.'],
                ['Get an alert on WhatsApp', 'Then talk to your doctor and the trial team. Reply STOP any time.'],
            ]],
            ['title' => 'For doctors running trials', 'theme' => 'navy', 'cta' => ['List your trial', 'doctor-registration.php?mode=running', 'btn-navy'], 'steps' => [
                ['Register once', 'Your name, email, WhatsApp number and hospital. That is all we need.'],
                ['Add a trial in chat', 'Share the NCT or CTRI ID. NCT trials fill in automatically — just confirm.'],
                ['Confirm with one tap each week', 'Still active, closed or needs an update — the website changes instantly.'],
            ]],
            ['title' => 'For doctors following trials', 'theme' => 'outline', 'cta' => ['Follow trials', 'doctor-registration.php?mode=following', 'btn-outline-navy'], 'steps' => [
                ['Register once', 'Name, WhatsApp number, hospital or clinic, city and specialty.'],
                ['Get trial alerts', 'A short WhatsApp summary when a trial opens in your city or specialty.'],
                ['View trial details', 'Open the link in the alert to see the full trial details on the website.'],
            ]],
        ];
 ?>
        <div class="row g-4">
            <?php foreach ($ways as $i => $w): ?>
                <div class="col-lg-4">
                    <div class="way-card way-card--<?= e($w['theme']) ?>" data-aos="fade-up" data-aos-delay="<?= $i * 120 ?>">
                        <h3 class="way-card__title"><?= e($w['title']) ?></h3>
                        <ol class="step-list">
                            <?php foreach ($w['steps'] as $n => [$t, $d]): ?>
                                <li><span class="step-num"><?= $n + 1 ?></span><div><strong><?= e($t) ?></strong><p><?= e($d) ?></p></div></li>
                            <?php endforeach; ?>
                        </ol>
                        <a class="btn <?= e($w['cta'][2]) ?> mt-auto align-self-start" href="<?= e(url($w['cta'][1])) ?>"><?= e($w['cta'][0]) ?></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section bg-navy text-white overflow-hidden">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h2 class="section-title text-white" data-aos="fade-up">Running a cancer trial? Manage it from WhatsApp.</h2>
                <p class="section-lead text-white-80" data-aos="fade-up" data-aos-delay="80">Adding a trial takes about three minutes, or under a minute with an NCT number. Your listing stays accurate because you confirm it every week — and registered patients nearby hear about it straight away.</p>
                <a class="btn btn-orange mt-2" href="<?= e(url('doctor-registration.php?mode=running')) ?>" data-aos="fade-up" data-aos-delay="160">List your trial</a>
            </div>
            <div class="col-lg-5 offset-lg-1">
                <div class="weekly-chat js-chat" data-aos="fade-left">
                    <div class="chat-msg in">Weekly check, Dr. [Name]: is <strong>NCT0[XXXXXXX]</strong> still recruiting?</div>
                    <div class="chat-options">
                        <span class="chat-option is-picked">Yes, no change</span>
                        <span class="chat-option">Update details</span>
                        <span class="chat-option">Trial closed</span>
                    </div>
                    <div class="chat-msg out">Yes, no change</div>
                    <div class="chat-msg in">Thank you. Your listing is confirmed for this week. <i class="bi bi-check-circle-fill text-success" aria-hidden="true"></i></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head d-flex flex-wrap justify-content-between align-items-end gap-3">
            <h2 class="section-title mb-0 maxw-680" data-aos="fade-right">Trials provide you the most modern cancer treatment at no extra cost</h2>
            <a class="link-arrow" href="<?= e(url('what-is-a-clinical-trial.php')) ?>" data-aos="fade-left">What is a clinical trial? <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
        </div>
        <?php
        $benefits = [
            ['bi-capsule', 'Access to treatments under study', 'Some trials offer medicines that are not available in India but are approved in the USA or in European countries.'],
            ['bi-heart-pulse', 'Close medical attention', 'Participants are usually monitored carefully by the trial team.'],
            ['bi-hand-thumbs-up', 'Your choice, always', 'Joining is voluntary, and you can leave a trial at any time.'],
            ['bi-shield-check', 'Receive standard of care treatment', 'Most trials have the standard treatment regimen as their control arm (check the details of each trial).'],
        ];
 ?>
        <div class="row g-4">
            <?php foreach ($benefits as $i => [$icon, $t, $d]): ?>
                <div class="col-sm-6 col-lg-3">
                    <div class="benefit" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                        <i class="bi <?= e($icon) ?> benefit__icon" aria-hidden="true"></i>
                        <h3><?= e($t) ?></h3>
                        <p><?= e($d) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php partial('cta-band', [
    'title'   => 'Know your rights as a trial participant',
    'text'    => 'Guides, questions to ask your doctor and support for patients and caregivers in the Advocacy Centre.',
    'buttons' => [['label' => 'Visit the Advocacy Centre', 'href' => 'advocacy-centre.php', 'class' => 'btn-navy']],
    'theme'   => 'orange',
]); ?>

<section class="section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4">
                <h2 class="section-title" data-aos="fade-up">What people ask us first</h2>
                <a class="link-arrow" href="<?= e(url('faq.php')) ?>" data-aos="fade-up" data-aos-delay="80">Read all FAQs <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
            </div>
            <div class="col-lg-8">
                <?php
                $preview = [
                    ['Is OncoUday free for patients?', 'Yes. Registering and receiving WhatsApp alerts costs you nothing.'],
                    ['Does registering enrol me in a trial?', 'No. We only tell you about matching trials. Joining is a decision you make with your doctor and the trial team.'],
                    ['Who can see my details?', 'Your details are never shown on the website. They are stored securely and used only to send you matching alerts.'],
                ];
                foreach ($preview as $i => [$q, $a]): ?>
                    <div class="qa-card" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                        <h3><?= e($q) ?></h3>
                        <p class="mb-0"><?= e($a) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
