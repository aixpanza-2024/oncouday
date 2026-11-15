<?php
declare(strict_types=1);
require __DIR__ . '/app/bootstrap.php';

$page = [
    'title'       => 'Medical Disclaimer',
    'active'      => 'disclaimer',
    'description' => 'OncoUday shares clinical trial information only and does not give medical advice.',
];

$sections = [
    ['id' => 'not-advice', 'title' => 'Not medical advice', 'html' => '<p>OncoUday shares clinical trial information only. It is not medical advice and does not recommend any treatment, medicine, hospital or trial.</p>'],
    ['id' => 'talk-to-doctor', 'title' => 'Talk to your doctor', 'html' => '<p>Always talk to your doctor before deciding to join a trial or changing your treatment. Only your doctor and the trial team can tell you whether a trial is suitable for you.</p>'],
    ['id' => 'no-enrolment', 'title' => 'Registering is not enrolment', 'html' => '<p>Registering on OncoUday or receiving an alert does not enrol you in a trial. Each trial has its own eligibility rules and consent process.</p>'],
    ['id' => 'accuracy', 'title' => 'Accuracy of listings', 'html' => '<p>Listings are added by doctors or imported from ClinicalTrials.gov, a service of the U.S. National Library of Medicine, and are labelled with their source. Details may change; please confirm them with the trial team.</p>'],
    ['id' => 'emergency', 'title' => 'Emergencies', 'html' => '<p>In a medical emergency, contact your doctor or the nearest hospital straight away. OncoUday cannot respond to emergencies.</p>'],
];

require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <h1 class="page-title" data-aos="fade-up">Medical Disclaimer</h1>
        <p class="mb-3" data-aos="fade-up" data-aos-delay="80">Last updated: [Date]</p>
        <div class="draft-note" data-aos="fade-up" data-aos-delay="160"><strong>Draft for layout.</strong> Final wording will be provided by OncoUday's legal advisor.</div>
    </div>
</section>

<?php partial('legal-document', ['sections' => $sections]); ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
