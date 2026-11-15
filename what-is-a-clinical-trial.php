<?php
declare(strict_types=1);
require __DIR__ . '/app/bootstrap.php';

$page = [
    'title'       => 'What is a Clinical Trial',
    'active'      => 'what-is',
    'description' => 'A plain-language guide to cancer clinical trials: the four phases, how participants are protected, benefits and things to think about, and questions to ask your doctor.',
];
$showDisclaimer = true;
require __DIR__ . '/includes/header.php';
?>

<section class="page-hero page-hero--dna">
    <div class="container position-relative">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <h1 class="page-title" data-aos="fade-up">What is a clinical trial?</h1>
                <p class="lead-ou" data-aos="fade-up" data-aos-delay="100">A clinical trial is a carefully planned research study in people. It tests whether a new medicine, combination or approach is safe and works better than the treatment available today.</p>
            </div>
            <div class="col-lg-5">
                <nav class="on-this-page" aria-label="On this page" data-aos="fade-left" data-aos-delay="150">
                    <h2>On this page</h2>
                    <ul class="list-unstyled mb-0">
                        <li><a href="#phases">The four phases of a trial</a></li>
                        <li><a href="#protection">How participants are protected</a></li>
                        <li><a href="#why-patients">Why patients take part</a></li>
                        <li><a href="#why-doctors">Why doctors should list their trials</a></li>
                        <li><a href="#questions">Questions to ask your doctor</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <?php illustration('dna'); ?>
</section>

<section class="section" id="phases">
    <div class="container">
        <div class="section-head">
            <h2 class="section-title" data-aos="fade-up">The four phases of a trial</h2>
            <p class="section-lead" data-aos="fade-up" data-aos-delay="80">A new treatment moves through phases, each one involving more people and answering a bigger question.</p>
        </div>
        <?php
        $phases = [
            ['Phase I', 'Is it safe?', 'A small group. Finds a safe dose and studies side effects.'],
            ['Phase II', 'Does it work?', 'A larger group with a specific cancer. Looks for signs the treatment helps.'],
            ['Phase III', 'Is it better?', "Hundreds or thousands of people. Compares the new treatment with today's standard."],
            ['Phase IV', 'What happens long term?', 'After approval. Follows safety and benefits in everyday use.'],
        ];
 ?>
        <div class="phase-steps">
            <?php foreach ($phases as $i => [$p, $q, $d]): ?>
                <div class="phase-card phase-<?= $i + 1 ?>" data-aos="fade-up" data-aos-delay="<?= $i * 150 ?>">
                    <span class="phase-card__label"><?= e($p) ?></span>
                    <h3><?= e($q) ?></h3>
                    <p class="mb-0"><?= e($d) ?></p>
                    <span class="phase-card__people" aria-hidden="true">
                        <?php for ($k = 0; $k < ($i + 1) * 2; $k++): ?><i class="bi bi-person-fill"></i><?php endfor; ?>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section bg-peach" id="protection">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-4">
                <h2 class="section-title" data-aos="fade-up">How participants are protected</h2>
                <p class="section-lead" data-aos="fade-up" data-aos-delay="80">Clinical trials in India follow national rules and ethical guidelines designed to put participants' safety first.</p>
            </div>
            <div class="col-lg-8">
                <?php
                $protect = [
                    ['bi-people', 'Ethics Committee approval', 'An independent committee reviews each trial before it starts and while it runs.'],
                    ['bi-journal-check', 'Public registration', 'Trials in India are registered with the Clinical Trials Registry – India (CTRI).'],
                    ['bi-chat-square-text', 'Informed consent', 'The trial team explains the study, its risks and benefits before you agree to anything.'],
                    ['bi-door-open', 'Free to leave', 'You can withdraw at any time, for any reason, without losing your regular care.'],
                ];
 ?>
                <div class="row g-3">
                    <?php foreach ($protect as $i => [$icon, $t, $d]): ?>
                        <div class="col-sm-6">
                            <div class="info-card info-card--sm h-100" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                                <span class="icon-badge icon-badge--sm"><i class="bi <?= e($icon) ?>" aria-hidden="true"></i></span>
                                <h3><?= e($t) ?></h3>
                                <p class="mb-0"><?= e($d) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section" id="why-patients">
    <div class="container">
        <h2 class="section-title section-head" data-aos="fade-up">Why patients take part</h2>
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="list-card list-card--peach h-100" data-aos="fade-right">
                    <h3><i class="bi bi-plus-circle" aria-hidden="true"></i> Possible benefits</h3>
                    <ul>
                        <li>Access to a new treatment before it is widely available</li>
                        <li>Regular check-ups and close monitoring by specialists</li>
                        <li>Some trial-related costs may be covered by the sponsor</li>
                        <li>Helping doctors find better treatments for future patients</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="list-card list-card--outline h-100" data-aos="fade-left">
                    <h3><i class="bi bi-lightbulb" aria-hidden="true"></i> Things to think about</h3>
                    <ul>
                        <li>A new treatment may cause side effects that are not yet known</li>
                        <li>It may not work better than the current treatment</li>
                        <li>You may receive the standard treatment instead of the new one</li>
                        <li>There may be extra hospital visits and tests</li>
                    </ul>
                </div>
            </div>
        </div>
        <a class="btn btn-magenta mt-4" href="<?= e(url('patient-registration.php')) ?>" data-aos="fade-up">Register for trial alerts</a>
    </div>
</section>

<section class="section bg-navy text-white" id="why-doctors">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5">
                <h2 class="section-title text-white" data-aos="fade-up">Why doctors join OncoUday</h2>
                <p class="text-white-80" data-aos="fade-up" data-aos-delay="80">Doctors running trials list them here. Doctors who don't run trials can follow new trials as they open.</p>
                <a class="btn btn-orange mt-2" href="<?= e(url('doctor-registration.php')) ?>" data-aos="fade-up" data-aos-delay="160">Register as a doctor</a>
            </div>
            <div class="col-lg-7">
                <ul class="check-list">
                    <li data-aos="fade-left"><strong>Reach registered patients</strong> who match your trial's cancer type and city, the moment you add it.</li>
                    <li data-aos="fade-left" data-aos-delay="100"><strong>Manage everything in WhatsApp.</strong> Add, update and close trials in a WhatsApp chat.</li>
                    <li data-aos="fade-left" data-aos-delay="200"><strong>Under a minute with an NCT number</strong> — details fill in from ClinicalTrials.gov.</li>
                    <li data-aos="fade-left" data-aos-delay="300"><strong>Always accurate.</strong> A one-tap weekly check keeps your listing current.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="section" id="questions">
    <div class="container">
        <h2 class="section-title section-head" data-aos="fade-up">Questions to ask your doctor</h2>
        <?php
        $questions = [
            'What is this trial trying to find out?',
            'What treatment will I receive, and how is it given?',
            'What side effects might I have?',
            'How often will I need to visit the hospital?',
            'Will the trial cost me anything?',
            'What happens if I decide to leave the trial?',
        ];
 ?>
        <div class="row g-3">
            <?php foreach ($questions as $i => $q): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="question-chip" data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 100 ?>">
                        <span class="step-num"><?= $i + 1 ?></span>
                        <span><?= e($q) ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
