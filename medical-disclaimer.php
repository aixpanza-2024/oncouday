<?php
declare(strict_types=1);
require __DIR__ . '/app/bootstrap.php';

$page = [
    'title'       => 'Medical Disclaimer',
    'active'      => 'disclaimer',
    'description' => 'OncoUday shares clinical trial information only. It does not give medical advice, recommend treatment or enrol anyone in a trial.',
];

$sections = [
    ['id' => 'not-advice', 'title' => 'Information only, not medical advice', 'html' => '
        <p>Everything on the OncoUday website and in our WhatsApp messages is general information about clinical trials. It is <strong>not</strong> medical advice, a diagnosis or a recommendation of any treatment, medicine, trial, doctor or hospital. Using OncoUday does not create a doctor–patient relationship with OncoUday or anyone working with us.</p>'],

    ['id' => 'talk-to-doctor', 'title' => 'Always talk to your doctor', 'html' => '
        <p>Talk to your own doctor before you decide to join a trial, stop a treatment or change your treatment. Do not delay or ignore medical advice because of something you read on OncoUday. Only your doctor and the trial team can tell you whether a trial may be right for you.</p>'],

    ['id' => 'no-enrolment', 'title' => 'Registering is not enrolment', 'html' => '
        <p>Registering on OncoUday, receiving an alert or tapping “I’m interested” does not enrol you in a trial and does not reserve a place. Every trial has its own eligibility rules. The trial team decides who can take part, and only after explaining the trial and taking your written informed consent.</p>'],

    ['id' => 'about-trials', 'title' => 'What to know about clinical trials', 'html' => '
        <ul>
            <li>A trial tests whether a treatment is safe and works. The treatment may not help you, and it may cause side effects, some of them unknown.</li>
            <li>In some trials you may receive the standard treatment or a placebo instead of the new treatment, and you may not be told which.</li>
            <li>Costs, travel and other practical arrangements differ from trial to trial. Ask the trial team what is covered before you decide.</li>
            <li>Taking part is always voluntary. You can leave a trial at any time without losing your regular care.</li>
        </ul>
        <p>Read <a href="{link:what-is-a-clinical-trial.php}">What is a Clinical Trial</a> and the <a href="{link:advocacy-centre.php}">Advocacy Centre</a> for questions to ask before you decide.</p>'],

    ['id' => 'accuracy', 'title' => 'Accuracy of listings', 'html' => '
        <p>Listings are added by doctors or imported from ClinicalTrials.gov, and each is labelled with its source. Trial details can change at any time, and a listing may be incomplete, out of date or wrong. Please confirm every detail with the trial team. See our <a href="{link:listing-policy.php}">Listing Policy</a>.</p>'],

    ['id' => 'no-endorsement', 'title' => 'No endorsement', 'html' => '
        <p>Listing a trial on OncoUday does not mean that OncoUday, any regulator or any medical body recommends or approves the trial, the sponsor, the hospital, the doctor or the medicine. The “Verified” badge only means that a doctor has verified their WhatsApp number and confirms the listing every week.</p>
        <p>Information from ClinicalTrials.gov is provided by trial sponsors and investigators. ClinicalTrials.gov is a service of the U.S. National Library of Medicine, which does not review the scientific validity of the trials listed and does not endorse OncoUday.</p>'],

    ['id' => 'translations', 'title' => 'Translations', 'html' => '
        <p>Pages shown in Hindi or Malayalam may be translated automatically and may contain mistakes. If a translation differs from the English text, the English text applies. If anything is unclear, please ask your doctor or contact us.</p>'],

    ['id' => 'emergency', 'title' => 'In an emergency', 'html' => '
        <p>OncoUday cannot respond to medical emergencies. In an emergency, call <strong>112</strong> (national emergency number) or <strong>108</strong> (ambulance), or go to the nearest hospital straight away.</p>'],
];

require __DIR__ . '/includes/header.php';

partial('legal-hero', [
    'title'      => 'Medical Disclaimer',
    'summary'    => 'OncoUday shares clinical trial information only. Please read this before relying on anything you see on the website or in our messages.',
    'docVersion' => '1.0',
    'current'    => 'disclaimer',
]);
partial('legal-document', ['sections' => $sections]);

require __DIR__ . '/includes/footer.php';
