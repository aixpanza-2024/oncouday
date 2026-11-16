<?php
declare(strict_types=1);
require __DIR__ . '/app/bootstrap.php';

$page = [
    'title'       => 'Privacy Policy',
    'active'      => 'privacy',
    'description' => 'How OncoUday collects, uses and protects personal data under the Digital Personal Data Protection Act, 2023.',
];
$g = config('contact.grievance');

$sections = [
    ['id' => 'who-we-are', 'title' => 'Who we are', 'html' => '<p>OncoUday ("we") runs this website and its WhatsApp service. Under the Digital Personal Data Protection Act, 2023, OncoUday is the Data Fiduciary for the personal data you share with us. We use a technology partner to run the platform on our behalf as a Data Processor.</p>'],
    ['id' => 'what-we-collect', 'title' => 'What we collect', 'html' => '<p><strong>Patients:</strong> name, email, WhatsApp number, city, cancer type and your consent choices.<br><strong>Doctors:</strong> name, email, WhatsApp number and hospital name, and the trial details you share.<br>We collect only your city, never your full address.</p>'],
    ['id' => 'how-we-use', 'title' => 'How we use your data', 'html' => '<p>To match patients with clinical trials by city and cancer type, to send WhatsApp alerts you have opted in to, to let doctors manage their trial listings, and to keep the service secure. We do not sell your data.</p>'],
    ['id' => 'consent', 'title' => 'Your consent', 'html' => '<p>We ask for separate consent to use the platform and to receive WhatsApp alerts. We record when you gave consent and which version of this notice you saw. You can withdraw consent at any time.</p>'],
    ['id' => 'whatsapp', 'title' => 'WhatsApp messages', 'html' => '<p>Messages are sent through the official WhatsApp Business platform. Alerts are written in general terms and never mention your diagnosis. Reply STOP at any time to stop alerts.</p>'],
    ['id' => 'sharing', 'title' => 'Who we share data with', 'html' => '<p>Your personal details are never shown publicly. We share data only with service providers who help us run the platform, under contract, and where the law requires it.</p>'],
    ['id' => 'protection', 'title' => 'How we protect your data', 'html' => '<p>Contact details are encrypted, access is limited to authorised staff with individual accounts, access is logged, the site runs only over HTTPS and backups are encrypted.</p>'],
    ['id' => 'retention', 'title' => 'How long we keep data', 'html' => '<p>[Retention periods to be confirmed by legal advisor]. Security logs are kept for at least one year, as required by law.</p>'],
    ['id' => 'rights', 'title' => 'Your rights', 'html' => '<p>You can ask to see, correct or delete your personal data, withdraw consent, and nominate someone to act for you. Contact our Grievance Officer to make a request.</p>'],
    ['id' => 'children', 'title' => 'Children', 'html' => '<p>For patients under 18, a parent or legal guardian must register and give consent on their behalf.</p>'],
    ['id' => 'breach', 'title' => 'If something goes wrong', 'html' => '<p>If a personal data breach happens, we will inform the Data Protection Board of India and the people affected, as the law requires.</p>'],
    ['id' => 'grievance-officer', 'title' => 'Grievance Officer', 'html' => '<p>Name: ' . e($g['name']) . ' · Email: ' . e($g['email']) . ' · Phone: ' . e($g['phone']) . '<br>We aim to resolve grievances within 90 days.</p>'],
    ['id' => 'changes', 'title' => 'Changes to this policy', 'html' => '<p>If we change this policy, we will update the date and version above and, where needed, ask for your consent again.</p>'],
];

require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <h1 class="page-title" data-aos="fade-up">Privacy Policy</h1>
                <p class="mb-3" data-aos="fade-up" data-aos-delay="80">Last updated: [Date] · Notice version <?= e(config('app.notice_version')) ?></p>
                <div class="draft-note" data-aos="fade-up" data-aos-delay="160"><strong>Draft for layout.</strong> Final wording will be provided by OncoUday's legal advisor under the Digital Personal Data Protection Act, 2023.</div>
            </div>
            <div class="col-lg-4 d-flex justify-content-center justify-content-lg-end">
                <?php illustration('shield'); ?>
            </div>
        </div>
    </div>
</section>

<?php partial('legal-document', [
    'sections' => $sections,
    'cta'      => ['title' => 'Questions about your data?', 'text' => 'Contact our Grievance Officer.', 'label' => 'Contact details', 'href' => 'contact.php#grievance'],
]); ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
