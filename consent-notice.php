<?php
declare(strict_types=1);
require __DIR__ . '/app/bootstrap.php';

$page = [
    'title'       => 'Consent Notice',
    'active'      => 'consent-notice',
    'description' => 'The notice OncoUday gives before asking for consent under section 5 of the Digital Personal Data Protection Act, 2023.',
];

$sections = [
    ['id' => 'about', 'title' => 'About this notice', 'html' => '
        <p>This is the notice that {entity} (“OncoUday”), the Data Fiduciary, gives you before asking for your consent, as section 5 of the Digital Personal Data Protection Act, 2023 and the DPDP Rules, 2025 require. A short version appears on each registration form. This page is the full version. The current version is <strong>{notice_version}</strong>, and we record the version you saw when you gave consent.</p>'],

    ['id' => 'patients', 'title' => 'For patients and caregivers', 'html' => '
        <h3>Personal data we will collect</h3>
        <ul>
            <li>Patient’s name and age</li>
            <li>Parent or guardian’s name, if the patient is under 18</li>
            <li>Email address and WhatsApp number</li>
            <li>City and state</li>
            <li>Broad cancer type</li>
            <li>Preferred language and your consent choices</li>
        </ul>
        <h3>Why we need it</h3>
        <ul>
            <li>To confirm your WhatsApp number and register you.</li>
            <li>To check every new or updated trial against your city and cancer type.</li>
            <li>To send you WhatsApp alerts about matching trials. Alerts never mention your diagnosis.</li>
            <li>To connect you with a trial team, only when you ask us to.</li>
        </ul>
        <h3>The consents we ask for</h3>
        <ul>
            <li><strong>Consent 1:</strong> to store and use these details to match you with clinical trials.</li>
            <li><strong>Consent 2:</strong> to receive trial alerts on WhatsApp.</li>
        </ul>
        <p>Both are needed for the alert service to work. You can withdraw either at any time.</p>'],

    ['id' => 'doctors', 'title' => 'For doctors', 'html' => '
        <h3>Personal data we will collect</h3>
        <ul>
            <li>Name, email address and WhatsApp number</li>
            <li>Hospital or clinic, city and specialty</li>
            <li>Whether you run or follow trials, and the cancer types you want alerts for</li>
            <li>The trial details you submit and your weekly-check answers</li>
        </ul>
        <h3>Why we need it</h3>
        <ul>
            <li>To verify you and your WhatsApp number.</li>
            <li>To let you add, update and close trial listings, and to show your name on the listings you add.</li>
            <li>To send the weekly check and trial alerts on WhatsApp.</li>
            <li>To pass on enquiries from patients who ask to be connected with your trial.</li>
        </ul>
        <p>Doctors also accept the <a href="{link:doctor-terms.php}">Terms for Doctors</a>.</p>'],

    ['id' => 'withdraw', 'title' => 'How to withdraw consent', 'html' => '
        <ul>
            <li>Reply <strong>STOP</strong> to any OncoUday WhatsApp message to stop all messages.</li>
            <li>Write to our Grievance Officer at {grievance_email} to withdraw consent or ask us to delete your data.</li>
        </ul>
        <p>Withdrawing is as easy as giving consent. After you withdraw, we stop using your data and delete it unless the law requires us to keep it.</p>'],

    ['id' => 'rights', 'title' => 'Your rights and how to complain', 'html' => '
        <p>You can ask to access a summary of your data, correct, update or erase it, and nominate someone to act for you. Contact our Grievance Officer, {grievance_name}, at {grievance_email} or {grievance_phone}. We respond within 90 days at most.</p>
        <p>If you are not satisfied with our response, you can complain to the <strong>Data Protection Board of India</strong>.</p>'],

    ['id' => 'languages', 'title' => 'Languages', 'html' => '
        <p>The short notice on our registration forms is available in English, हिन्दी and മലയാളം. You can ask for this notice in any language listed in the Eighth Schedule to the Constitution of India by writing to {grievance_email}.</p>'],

    ['id' => 'more', 'title' => 'Full details', 'html' => '
        <p>Our <a href="{link:privacy-policy.php}">Privacy Policy</a> explains how long we keep data, who we share it with and how we protect it.</p>'],
];

require __DIR__ . '/includes/header.php';

partial('legal-hero', [
    'title'      => 'Consent Notice',
    'summary'    => 'What personal data we ask for, why we need it, and how you can withdraw your consent at any time.',
    'docVersion' => config('app.notice_version'),
    'current'    => 'consent-notice',
]);
partial('legal-document', [
    'sections' => $sections,
    'cta'      => ['title' => 'Ready to register?', 'text' => 'Free WhatsApp alerts for trials that match your city and cancer type.', 'label' => 'Register as a patient', 'href' => 'patient-registration.php'],
]);

require __DIR__ . '/includes/footer.php';
