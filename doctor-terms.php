<?php
declare(strict_types=1);
require __DIR__ . '/app/bootstrap.php';

$page = [
    'title'       => 'Terms for Doctors',
    'active'      => 'doctor-terms',
    'description' => 'The terms that apply to doctors and trial teams who list, update or follow cancer clinical trials on OncoUday.',
];

$sections = [
    ['id' => 'scope', 'title' => 'Who these terms apply to', 'html' => '
        <p>These Terms for Doctors apply to every doctor and trial team member who registers on OncoUday, whether to list and manage trials (“running trials”) or to receive trial alerts (“following trials”). They apply in addition to our <a href="{link:terms-of-use.php}">Terms of Use</a> and <a href="{link:privacy-policy.php}">Privacy Policy</a>. If these terms conflict with the Terms of Use, these terms apply to doctors.</p>'],

    ['id' => 'eligibility', 'title' => 'Eligibility and verification', 'html' => '
        <ul>
            <li>You must be a registered medical practitioner with valid registration with the National Medical Commission or a State Medical Council, or an authorised member of a trial team, such as a co-investigator or trial coordinator, acting under the principal investigator.</li>
            <li>We verify your WhatsApp number when you register. We may also ask for your medical registration number, your role in the trial or a letter of authority, and we may refuse or suspend an account that we cannot verify.</li>
            <li>You must keep your details accurate and tell us if your role or hospital changes.</li>
        </ul>'],

    ['id' => 'approvals', 'title' => 'Before you list a trial', 'html' => '
        <p>Each time you add or update a trial, you confirm that:</p>
        <ul>
            <li>you are the principal investigator, or you are authorised by the principal investigator or the sponsor to publicise the trial;</li>
            <li>the trial has every permission it needs under the New Drugs and Clinical Trials Rules, 2019, including permission from the Central Licensing Authority (CDSCO) where required;</li>
            <li>the trial is approved by an Ethics Committee registered under those Rules, and the approval is current;</li>
            <li>the trial is registered with the Clinical Trials Registry – India (CTRI) where registration is required;</li>
            <li>the information you share matches the approved protocol, the registry record and the recruitment material the Ethics Committee approved; and</li>
            <li>publicising the trial on OncoUday does not break any confidentiality duty you owe the sponsor.</li>
        </ul>'],

    ['id' => 'content', 'title' => 'What a listing may and may not say', 'html' => '
        <p>A listing should contain factual information only: the title, cancer type, phase, status, medicines, hospital, city, registry ID and recruitment start date.</p>
        <p>A listing must not:</p>
        <ul>
            <li>claim or suggest that a medicine or treatment cures cancer or is certain to work. This is prohibited by the Drugs and Magic Remedies (Objectionable Advertisements) Act, 1954;</li>
            <li>offer payment, gifts or other inducements to take part, except compensation approved by the Ethics Committee, in line with the ICMR National Ethical Guidelines for Biomedical and Health Research Involving Human Participants, 2017;</li>
            <li>include any information that could identify a patient or participant;</li>
            <li>promote your own practice, clinic or services in a way that breaks the National Medical Commission’s rules on professional conduct; or</li>
            <li>publish anyone’s personal contact details without their consent.</li>
        </ul>
        <p>We may edit a listing for clarity, format or translation. We will not change its meaning, and we may remove anything that breaks these rules.</p>'],

    ['id' => 'accuracy', 'title' => 'Keeping listings accurate', 'html' => '
        <ul>
            <li>Every week we send you a one-tap WhatsApp check for each of your active trials. Please answer it within 7 days.</li>
            <li>If we do not hear from you for 3 weeks in a row, we may mark the listing as awaiting confirmation or hide it until you confirm it.</li>
            <li>Tell us straight away when recruitment pauses or ends, or when important details change. Closed trials are removed from search.</li>
            <li>The date of your last confirmation is shown on the listing as “Last confirmed”.</li>
        </ul>'],

    ['id' => 'verified', 'title' => 'What the “Verified” badge means', 'html' => '
        <p>The “Verified · Added by Dr …” badge means that we have verified your WhatsApp number and that you are confirming the listing every week. It is not an approval by OncoUday or by any regulator, and it does not mean that the trial is suitable for any particular patient.</p>'],

    ['id' => 'patients', 'title' => 'Enquiries from patients', 'html' => '
        <p>When a patient or caregiver asks us to connect them with your trial, we may share with you, on WhatsApp, only the details they agreed to share. When you receive them, you:</p>
        <ul>
            <li>become responsible for that personal data under the Digital Personal Data Protection Act, 2023, and must keep it confidential and secure;</li>
            <li>may use it only to discuss whether the person may be eligible for the trial, and not for marketing or any other purpose;</li>
            <li>must screen and enrol participants only through the Ethics Committee-approved informed consent process, as required by the New Drugs and Clinical Trials Rules, 2019, Good Clinical Practice and the ICMR guidelines; and</li>
            <li>must delete the details when they are no longer needed for that purpose.</li>
        </ul>'],

    ['id' => 'following', 'title' => 'Doctors who follow trials', 'html' => '
        <p>If you register to follow trials, we send you WhatsApp alerts about trials in your city or specialty, for your information. Whether to refer a patient is your own professional decision. You can reply STOP at any time.</p>'],

    ['id' => 'licence', 'title' => 'Licence to show your listing', 'html' => '
        <p>You keep ownership of the trial information you submit. You give OncoUday a non-exclusive, royalty-free, worldwide licence to store, display, format, translate and send that information on the Platform and in WhatsApp alerts, for as long as the listing is active and for a reasonable time afterwards as a closed record.</p>'],

    ['id' => 'removal', 'title' => 'Removing listings and suspending accounts', 'html' => '
        <p>We may remove or hide a listing, or suspend your account, if a listing is inaccurate or out of date, if you do not answer the weekly check, if we receive a credible complaint or an order from a court or authority, or if you break these terms. Where it is fair and lawful, we will tell you why and give you a chance to correct the listing.</p>'],

    ['id' => 'fees', 'title' => 'Fees', 'html' => '
        <p>Registering and listing trials on OncoUday is free at present. If we ever plan to introduce a fee, we will tell you at least 30 days in advance, and you may close your account before it applies.</p>'],

    ['id' => 'indemnity', 'title' => 'Your responsibility', 'html' => '
        <p>You are responsible for the trial information you submit. You agree to compensate OncoUday for any loss, claim, penalty or regulatory action caused by an inaccurate or unauthorised listing, by your breach of these terms, or by your breach of any law, regulation or Ethics Committee condition.</p>'],

    ['id' => 'general', 'title' => 'Other terms', 'html' => '
        <p>The rest of the <a href="{link:terms-of-use.php}">Terms of Use</a> also applies to you, including the limits of liability, governing law and grievance process. Questions about these terms can be sent to {contact_email}.</p>'],
];

require __DIR__ . '/includes/header.php';

partial('legal-hero', [
    'title'      => 'Terms for Doctors',
    'summary'    => 'What we expect from doctors and trial teams who list, update or follow cancer clinical trials on OncoUday.',
    'docVersion' => '1.0',
    'current'    => 'doctor-terms',
]);
partial('legal-document', [
    'sections' => $sections,
    'cta'      => ['title' => 'Ready to list a trial?', 'text' => 'Register once, then manage your trials on WhatsApp.', 'label' => 'Register as a doctor', 'href' => 'doctor-registration.php'],
]);

require __DIR__ . '/includes/footer.php';
