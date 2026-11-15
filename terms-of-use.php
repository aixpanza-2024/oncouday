<?php
declare(strict_types=1);
require __DIR__ . '/app/bootstrap.php';

$page = [
    'title'       => 'Terms of Use',
    'active'      => 'terms',
    'description' => 'Terms of use for the OncoUday website and WhatsApp service, including terms for doctors listing trials.',
];

$sections = [
    ['id' => 'about', 'title' => 'About these terms', 'html' => '<p>These terms apply to everyone who uses the OncoUday website and WhatsApp service. By registering, you agree to them. [Final wording to be provided by OncoUday\'s legal advisor.]</p>'],
    ['id' => 'service', 'title' => 'What OncoUday provides', 'html' => '<p>OncoUday shares information about cancer clinical trials in India and sends WhatsApp alerts to people who ask for them. OncoUday does not give medical advice, does not recommend any treatment and does not enrol anyone in a trial.</p>'],
    ['id' => 'patients', 'title' => 'Using OncoUday as a patient or caregiver', 'html' => '<p>Please give accurate details so that we can match you with the right trials. If you register on behalf of someone else, you confirm that you have their permission, or that you are their parent or legal guardian.</p>'],
    ['id' => 'doctors', 'title' => 'Terms for doctors', 'html' => '<p>Doctors who list a trial confirm that they are part of the trial team or authorised by it, that the trial has the required approvals, and that the details they share are accurate. Doctors agree to answer the weekly check so that listings stay current. [Further terms to be confirmed.]</p>'],
    ['id' => 'listings', 'title' => 'Trial listings', 'html' => '<p>Some listings come from ClinicalTrials.gov and are labelled with their source. We work to keep listings accurate but cannot guarantee that every detail is complete or up to date.</p>'],
    ['id' => 'acceptable-use', 'title' => 'Acceptable use', 'html' => '<p>Do not misuse the service, send false information, try to access data that is not yours or interfere with the security of the platform.</p>'],
    ['id' => 'liability', 'title' => 'Limitation of liability', 'html' => '<p>[To be provided by OncoUday\'s legal advisor.]</p>'],
    ['id' => 'law', 'title' => 'Governing law', 'html' => '<p>These terms are governed by the laws of India. [Jurisdiction to be confirmed.]</p>'],
];

require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <h1 class="page-title" data-aos="fade-up">Terms of Use</h1>
        <p class="mb-3" data-aos="fade-up" data-aos-delay="80">Last updated: [Date]</p>
        <div class="draft-note" data-aos="fade-up" data-aos-delay="160"><strong>Draft for layout.</strong> Final wording will be provided by OncoUday's legal advisor.</div>
    </div>
</section>

<?php partial('legal-document', [
    'sections' => $sections,
    'cta'      => ['title' => 'Questions about these terms?', 'text' => 'Write to the OncoUday team.', 'label' => 'Contact us', 'href' => 'contact.php'],
]); ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
