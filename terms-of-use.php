<?php
declare(strict_types=1);
require __DIR__ . '/app/bootstrap.php';

$page = [
    'title'       => 'Terms of Use',
    'active'      => 'terms',
    'description' => 'The terms that apply to everyone who uses the OncoUday website and WhatsApp service.',
];

$sections = [
    ['id' => 'agreement', 'title' => 'About these terms', 'html' => '
        <p>These Terms of Use (“Terms”) are an agreement between you and {entity}, {address} (“OncoUday”, “we”, “us”). They apply to the OncoUday website and our WhatsApp service (together, the “Platform”).</p>
        <p>By using the Platform or registering, you agree to these Terms, our <a href="{link:privacy-policy.php}">Privacy Policy</a> and our <a href="{link:medical-disclaimer.php}">Medical Disclaimer</a>. Doctors also agree to the <a href="{link:doctor-terms.php}">Terms for Doctors</a>. If you do not agree, please do not use the Platform.</p>
        <p>These Terms are an electronic record under the Information Technology Act, 2000 and the rules made under it, and are published as required by the Information Technology (Intermediary Guidelines and Digital Media Ethics Code) Rules, 2021. They do not need a physical or digital signature.</p>'],

    ['id' => 'service', 'title' => 'What OncoUday is, and what it is not', 'html' => '
        <p>OncoUday is a free information service. It lists cancer clinical trials in India and sends WhatsApp alerts to people who ask for them.</p>
        <p>OncoUday is <strong>not</strong> a hospital, a healthcare provider, a trial sponsor, an investigator or a contract research organisation. OncoUday does not:</p>
        <ul>
            <li>give medical advice, diagnose any condition or recommend any treatment, trial, doctor, hospital or medicine;</li>
            <li>decide whether you are eligible for a trial; or</li>
            <li>enrol anyone in a trial. Only the trial team can do that, through its own informed consent process.</li>
        </ul>'],

    ['id' => 'eligibility', 'title' => 'Who can use OncoUday', 'html' => '
        <ul>
            <li>You must be 18 or older to register. A parent or lawful guardian must register a patient who is under 18.</li>
            <li>If you register on behalf of someone else, you confirm that you have their permission, or that you are their parent or lawful guardian.</li>
            <li>The details you give must be true and up to date, and the WhatsApp number must be yours or one you are allowed to use.</li>
            <li>Doctors must also meet the eligibility rules in the <a href="{link:doctor-terms.php}">Terms for Doctors</a>.</li>
        </ul>'],

    ['id' => 'whatsapp', 'title' => 'The WhatsApp service', 'html' => '
        <ul>
            <li>We send WhatsApp messages only to people who opt in. Reply STOP at any time to stop them, and START to begin again.</li>
            <li>WhatsApp is a service of Meta Platforms, and its own terms apply to your use of it. We are not responsible for WhatsApp being unavailable or for delays in delivery.</li>
            <li>Your mobile operator may charge you for data. OncoUday does not charge for messages.</li>
        </ul>'],

    ['id' => 'listings', 'title' => 'Trial listings', 'html' => '
        <p>Listings come from two sources, and each is labelled:</p>
        <ul>
            <li><strong>Verified · Added by a doctor:</strong> added by a doctor whose WhatsApp number we have verified and who confirms the listing every week.</li>
            <li><strong>From ClinicalTrials.gov:</strong> imported every night from ClinicalTrials.gov, a service of the U.S. National Library of Medicine. We show only the Indian sites of trials that are recruiting or not yet recruiting.</li>
        </ul>
        <p>We work to keep listings accurate, but we cannot guarantee that every detail is complete, current or correct. Always confirm the details with the trial team and your doctor. See our <a href="{link:listing-policy.php}">Listing Policy</a>.</p>'],

    ['id' => 'acceptable-use', 'title' => 'Acceptable use', 'html' => '
        <p>You must not use the Platform to host, display, upload, share or send any information that:</p>
        <ul>
            <li>belongs to another person and that you have no right to share;</li>
            <li>is obscene, pornographic, paedophilic, invasive of another person’s privacy (including bodily privacy), insulting or harassing on the basis of gender, racially or ethnically objectionable, or that encourages money laundering or gambling;</li>
            <li>is harmful to children;</li>
            <li>infringes any patent, trademark, copyright or other proprietary right;</li>
            <li>deceives or misleads about where a message came from, or knowingly shares information that is patently false or misleading;</li>
            <li>impersonates another person;</li>
            <li>threatens the unity, integrity, defence, security or sovereignty of India, friendly relations with other countries or public order, or incites any offence;</li>
            <li>contains software viruses or any code designed to interfere with a computer resource; or</li>
            <li>breaks any law in force in India.</li>
        </ul>
        <p>In particular, because OncoUday deals with cancer, you must not:</p>
        <ul>
            <li>claim that any medicine, treatment or trial cures cancer or is certain to work. The Drugs and Magic Remedies (Objectionable Advertisements) Act, 1954 prohibits such claims.</li>
            <li>offer money or other inducements to join a trial, except compensation approved by an Ethics Committee;</li>
            <li>share another person’s medical information without their permission; or</li>
            <li>copy listings in bulk, scrape the Platform, send unwanted messages through our WhatsApp number, or try to break, test or get around our security.</li>
        </ul>
        <p>If you break these rules, we may remove the content and suspend or end your access. Where the law requires, we will report it to the authorities.</p>'],

    ['id' => 'ip', 'title' => 'Intellectual property', 'html' => '
        <p>The OncoUday name, logo, design, text and software belong to OncoUday or its licensors. You may view and share pages for your own non-commercial use. You may not copy, sell or republish them without our written permission.</p>
        <p>ClinicalTrials.gov information is public data of the U.S. National Library of Medicine. It is shown with its source and does not mean that the National Library of Medicine endorses OncoUday. Doctors keep ownership of the trial information they submit and give us a licence to show it, as set out in the <a href="{link:doctor-terms.php}">Terms for Doctors</a>.</p>'],

    ['id' => 'third-parties', 'title' => 'Third-party services and links', 'html' => '
        <p>The Platform links to and uses services we do not control, such as WhatsApp, ClinicalTrials.gov, CTRI and hospital websites. We are not responsible for their content, availability or privacy practices.</p>'],

    ['id' => 'disclaimer', 'title' => 'No warranties', 'html' => '
        <p>The Platform is provided “as is” and “as available”. To the extent the law allows, we make no promise that it will be error-free, uninterrupted or suitable for any particular purpose, or that any trial will be available, suitable or successful for you. Read our <a href="{link:medical-disclaimer.php}">Medical Disclaimer</a> before relying on any information.</p>'],

    ['id' => 'liability', 'title' => 'Limitation of liability', 'html' => '
        <p>To the extent the law allows:</p>
        <ul>
            <li>OncoUday is not liable for any decision about treatment or trial participation. Those decisions are made by you, your doctor and the trial team.</li>
            <li>OncoUday is not liable for any indirect, incidental, special or consequential loss, or for loss of data, opportunity or goodwill.</li>
            <li>OncoUday is not liable for the acts of trial teams, hospitals, sponsors, WhatsApp or other third parties.</li>
            <li>Because the Platform is free, our total liability to you for any claim is limited to ₹1,000.</li>
        </ul>
        <p>Nothing in these Terms limits any liability that cannot be limited under Indian law, including liability for fraud, or any right you have under the Consumer Protection Act, 2019 or the DPDP Act.</p>'],

    ['id' => 'indemnity', 'title' => 'Indemnity', 'html' => '
        <p>You agree to compensate OncoUday for any loss, claim or penalty caused by your breach of these Terms, your breach of law or false information you give us. Doctors have further obligations in the <a href="{link:doctor-terms.php}">Terms for Doctors</a>.</p>'],

    ['id' => 'termination', 'title' => 'Suspension and termination', 'html' => '
        <p>You may stop using the Platform at any time by replying STOP or asking us to delete your data. We may suspend or end your access, or remove content, if you break these Terms or the law, if a court or authority orders us to, or to protect other users. Where it is fair and lawful, we will tell you why.</p>'],

    ['id' => 'grievance', 'title' => 'Complaints and the Grievance Officer', 'html' => '
        <p>If you have a complaint about content on the Platform or about these Terms, contact our Grievance Officer, {grievance_name}, at {grievance_email} or {grievance_phone}. We acknowledge complaints within 24 hours and resolve them within 15 days, or sooner where the law requires. If you are not satisfied with a decision about content, you may appeal to the Grievance Appellate Committee within 30 days. See <a href="{link:grievance-redressal.php}">Grievance Redressal</a>.</p>'],

    ['id' => 'changes', 'title' => 'Changes to these Terms', 'html' => '
        <p>We may update these Terms. We will change the version and date at the top of this page and, for important changes, tell registered users on WhatsApp or by email before the changes take effect. If you continue to use the Platform after that, you accept the updated Terms.</p>'],

    ['id' => 'law', 'title' => 'Governing law and courts', 'html' => '
        <p>These Terms are governed by the laws of India. Subject to any right you have to go to a consumer forum, the courts at {jurisdiction} have exclusive jurisdiction over any dispute about these Terms or the Platform.</p>'],

    ['id' => 'general', 'title' => 'General', 'html' => '
        <ul>
            <li>If any part of these Terms is found to be invalid, the rest stays in force.</li>
            <li>If we do not enforce a right straight away, we have not given it up.</li>
            <li>We are not responsible for delays caused by events beyond our reasonable control.</li>
            <li>These Terms, together with the documents they refer to, are the whole agreement between you and OncoUday about the Platform.</li>
            <li>If a translation of these Terms differs from the English version, the English version applies.</li>
        </ul>'],
];

require __DIR__ . '/includes/header.php';

partial('legal-hero', [
    'title'      => 'Terms of Use',
    'summary'    => 'The rules for using the OncoUday website and WhatsApp service. Please read them with our Privacy Policy and Medical Disclaimer.',
    'docVersion' => '1.0',
    'current'    => 'terms',
]);
partial('legal-document', [
    'sections' => $sections,
    'cta'      => ['title' => 'Questions about these terms?', 'text' => 'Write to the OncoUday team.', 'label' => 'Contact us', 'href' => 'contact.php'],
]);

require __DIR__ . '/includes/footer.php';
