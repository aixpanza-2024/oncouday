<?php
declare(strict_types=1);
require __DIR__ . '/app/bootstrap.php';

$page = [
    'title'       => 'Privacy Policy',
    'active'      => 'privacy',
    'description' => 'How OncoUday collects, uses, shares and protects personal data under the Digital Personal Data Protection Act, 2023 and the DPDP Rules, 2025.',
];

$sections = [
    ['id' => 'who-we-are', 'title' => 'Who we are', 'html' => '
        <p>OncoUday is operated by {entity}, {address} (“OncoUday”, “we”, “us”). This policy explains how we handle personal data on the OncoUday website and our WhatsApp service (together, the “Platform”).</p>
        <p>Under the Digital Personal Data Protection Act, 2023 (the “DPDP Act”) and the Digital Personal Data Protection Rules, 2025 (the “DPDP Rules”), OncoUday is the <strong>Data Fiduciary</strong> for the personal data you share with us. Companies that run parts of the Platform for us act as our <strong>Data Processors</strong>.</p>
        <p>Please read this policy together with our <a href="{link:consent-notice.php}">Consent Notice</a>, <a href="{link:terms-of-use.php}">Terms of Use</a> and <a href="{link:cookie-policy.php}">Cookie Policy</a>.</p>'],

    ['id' => 'summary', 'title' => 'The short version', 'html' => '
        <ul>
            <li>We collect only what we need to match you with cancer clinical trials: for patients, that is your city, never your address.</li>
            <li>We never sell your data, never show your details on the website and never use them for advertising.</li>
            <li>WhatsApp alerts never mention your diagnosis.</li>
            <li>You can stop alerts at any time by replying STOP, and you can ask us to delete your data at any time.</li>
            <li>OncoUday shares trial information only. It does not give medical advice.</li>
        </ul>'],

    ['id' => 'what-we-collect', 'title' => 'Personal data we collect', 'html' => '
        <h3>Patients and caregivers</h3>
        <ul>
            <li>Name and age of the patient, and the name of the parent or guardian if the patient is under 18.</li>
            <li>Email address and WhatsApp number.</li>
            <li>City (from which we know the state) and the broad type of cancer, for example “breast cancer”.</li>
            <li>Preferred language, and a record of each consent: when it was given or withdrawn, the notice version and the language shown.</li>
            <li>Messages you send to our WhatsApp number.</li>
        </ul>
        <h3>Doctors</h3>
        <ul>
            <li>Name, email address, WhatsApp number, hospital or clinic, city and specialty.</li>
            <li>Whether you run trials or follow them, and the cancer types you want alerts for.</li>
            <li>The trial details you submit and your answers to the weekly check.</li>
        </ul>
        <h3>Anyone who contacts us</h3>
        <ul><li>Name, email, phone number (optional), who you are (patient, caregiver, doctor and so on) and your message.</li></ul>
        <h3>Technical data</h3>
        <ul>
            <li>Your IP address, stored only as a one-way code (a “hash”), the date and time of your visit, and your browser type, used to keep the Platform secure and to stop misuse.</li>
        </ul>
        <p>We do not collect your precise location, home address or GPS position.</p>
        <h3>Health information</h3>
        <p>Cancer type is sensitive information, so we ask only for the broad type. Please do not send us medical reports, prescriptions or test results. If you do, we will delete them and will not use them.</p>'],

    ['id' => 'purposes', 'title' => 'Why we use your data', 'html' => '
        <p>We use personal data only for these purposes:</p>
        <ul>
            <li>To register you and confirm your WhatsApp number.</li>
            <li>To match patients with trials by city and cancer type, and send the WhatsApp alerts they asked for.</li>
            <li>To let doctors add, update and close trial listings, run the weekly check and send trial alerts to doctors who follow trials.</li>
            <li>To connect you with a trial team, only when you ask us to.</li>
            <li>To reply to your messages and complaints.</li>
            <li>To keep the Platform secure, prevent fraud and misuse, and keep the logs the law requires.</li>
            <li>To meet our legal obligations.</li>
        </ul>
        <p>We rely on your <strong>consent</strong> under section 6 of the DPDP Act for the Platform and for WhatsApp messages. We rely on the <strong>legitimate uses</strong> in section 7 of the DPDP Act only where the law allows, for example to comply with a legal duty or a court order.</p>
        <p>We do <strong>not</strong> sell or rent personal data, use it for advertising, build marketing profiles or make automated decisions that have legal or similar effects on you.</p>'],

    ['id' => 'consent', 'title' => 'Your consent and how to withdraw it', 'html' => '
        <p>We ask for two separate consents: one to use the Platform and one to receive WhatsApp messages. We keep a record of each consent so that we can show what you agreed to and when.</p>
        <p>You can withdraw consent at any time, as easily as you gave it:</p>
        <ul>
            <li>reply <strong>STOP</strong> to any OncoUday WhatsApp message to stop all messages; or</li>
            <li>write to our Grievance Officer at {grievance_email} to withdraw consent or ask us to delete your data.</li>
        </ul>
        <p>When you withdraw consent, we stop the processing and delete your personal data within a reasonable time, unless the law requires us to keep it. Withdrawal does not affect anything we did lawfully before it. Once a Consent Manager registered with the Data Protection Board of India is available, you may also give, manage and withdraw consent through it.</p>'],

    ['id' => 'whatsapp', 'title' => 'WhatsApp messages', 'html' => '
        <p>We send and receive messages through the official WhatsApp Business Platform, provided by Meta Platforms. To deliver messages, Meta processes your WhatsApp number and the message content under its own terms and privacy policy.</p>
        <ul>
            <li>We message you only after you opt in, and we honour STOP straight away. Reply START to begin again.</li>
            <li>Alert messages use templates approved by WhatsApp and are written in general terms. They never mention your diagnosis.</li>
            <li>We send only messages related to the service you signed up for. We do not send promotional messages.</li>
        </ul>'],

    ['id' => 'sharing', 'title' => 'Who we share data with', 'html' => '
        <p>Your personal details are never published on the website. We share personal data only with:</p>
        <ul>
            <li><strong>Our Data Processors</strong>, under written contracts that let them use the data only on our instructions: our hosting provider ({hosting}), the WhatsApp Business Platform (Meta) and our email service.</li>
            <li><strong>A trial team</strong>, only when you ask us to connect you with a specific trial, and only the details you agree to share at that time.</li>
            <li><strong>Government and law-enforcement authorities</strong>, when the law requires it, for example under a court order or a lawful request.</li>
            <li><strong>A successor organisation</strong>, if OncoUday is merged or transferred, which will remain bound by this policy. We will tell you before that happens.</li>
        </ul>'],

    ['id' => 'transfers', 'title' => 'Data stored outside India', 'html' => '
        <p>Our main database is hosted in India. Some service providers, such as Meta for WhatsApp, may process data on servers outside India. Section 16 of the DPDP Act allows this, except to countries the Government of India restricts. We do not transfer personal data to any restricted country.</p>'],

    ['id' => 'security', 'title' => 'How we protect your data', 'html' => '
        <p>We take reasonable security safeguards, as section 8(5) of the DPDP Act and the DPDP Rules require, including:</p>
        <ul>
            <li>encryption of names, email addresses and phone numbers in our database;</li>
            <li>HTTPS on every page;</li>
            <li>individual staff accounts, strong passwords and access limited to the people who need it;</li>
            <li>logging and monitoring of access to personal data;</li>
            <li>encrypted backups; and</li>
            <li>confidentiality and data-protection terms in our contracts with staff and processors.</li>
        </ul>
        <p>No system is completely secure, but we work to protect your data and to act quickly if something goes wrong.</p>'],

    ['id' => 'retention', 'title' => 'How long we keep data', 'html' => '
        <ul>
            <li><strong>Patients:</strong> while you are registered. If you stop alerts and do not restart them within 12 months, we delete your details.</li>
            <li><strong>Doctors:</strong> while your account is active. Within 90 days of closing it, we delete your personal details. A closed trial listing may remain as a record, without your contact details.</li>
            <li><strong>Contact messages:</strong> 12 months after we resolve them.</li>
            <li><strong>WhatsApp message logs:</strong> 12 months.</li>
            <li><strong>Consent records:</strong> up to 3 years after you withdraw consent, so that we can show we acted on your consent. We keep only the minimum needed.</li>
            <li><strong>Security logs:</strong> at least one year, as the DPDP Rules require.</li>
            <li><strong>Backups:</strong> overwritten within 30 days.</li>
        </ul>
        <p>After these periods we delete the data or make it anonymous so that it can no longer identify you.</p>'],

    ['id' => 'rights', 'title' => 'Your rights', 'html' => '
        <p>Under the DPDP Act you have the right to:</p>
        <ul>
            <li><strong>access</strong> a summary of the personal data we hold about you, how we use it and who we have shared it with (section 11);</li>
            <li><strong>correct, complete, update or erase</strong> your personal data (section 12);</li>
            <li><strong>have your grievances redressed</strong> (section 13);</li>
            <li><strong>nominate</strong> another person to exercise your rights if you die or become unable to do so (section 14); and</li>
            <li><strong>withdraw consent</strong> at any time (section 6).</li>
        </ul>
        <p>To use these rights, see <a href="{link:grievance-redressal.php}">Grievance Redressal</a>. We may need to confirm your identity first, usually by a message to your registered WhatsApp number. If you are not satisfied with our response, you can complain to the <strong>Data Protection Board of India</strong>.</p>'],

    ['id' => 'duties', 'title' => 'Your duties', 'html' => '
        <p>Section 15 of the DPDP Act also places duties on you. Please give accurate information, do not pretend to be someone else, do not hide relevant facts when you register for someone else, and do not file false or frivolous complaints. The Data Protection Board can impose a penalty of up to ₹10,000 for breaking these duties.</p>'],

    ['id' => 'children', 'title' => 'Children and persons with disability', 'html' => '
        <p>If a patient is under 18, a parent or lawful guardian must register and give verifiable consent on their behalf, as section 9 of the DPDP Act requires. We may contact the parent or guardian to confirm this. We do not track or monitor the behaviour of children and do not direct advertising at them.</p>
        <p>For a person with a disability who cannot decide for themselves, their lawful guardian may give consent on their behalf.</p>'],

    ['id' => 'cookies', 'title' => 'Cookies', 'html' => '
        <p>We use only the cookies and browser storage needed to run the Platform. We do not use advertising or tracking cookies. See our <a href="{link:cookie-policy.php}">Cookie Policy</a>.</p>'],

    ['id' => 'breach', 'title' => 'If a data breach happens', 'html' => '
        <p>If a personal data breach happens, we will, without delay, tell each person affected what happened, the likely consequences, what we are doing about it and what they can do to protect themselves. We will report the breach to the Data Protection Board of India within the time set by the DPDP Rules.</p>'],

    ['id' => 'grievance-officer', 'title' => 'Grievance Officer', 'html' => '
        <p>Our Grievance Officer answers questions and complaints about personal data:</p>
        <ul>
            <li>Name: {grievance_name}</li>
            <li>Email: {grievance_email}</li>
            <li>Phone: {grievance_phone}</li>
            <li>Post: {entity}, {address}</li>
        </ul>
        <p>We resolve every grievance as soon as we can, and in any case within 90 days, as the DPDP Rules require. See <a href="{link:grievance-redressal.php}">Grievance Redressal</a> for details.</p>'],

    ['id' => 'changes', 'title' => 'Changes to this policy', 'html' => '
        <p>If we change this policy, we will update the version and date at the top of this page. If a change affects how we use your data, we will tell you on WhatsApp or by email before it takes effect and, where the law requires, ask for your consent again.</p>'],
];

require __DIR__ . '/includes/header.php';

partial('legal-hero', [
    'title'      => 'Privacy Policy',
    'summary'    => 'How we collect, use, share and protect your personal data, and the rights you have under the Digital Personal Data Protection Act, 2023.',
    'docVersion' => '1.1',
    'current'    => 'privacy',
    'art'        => 'shield',
]);
partial('legal-document', [
    'sections' => $sections,
    'cta'      => ['title' => 'Questions about your data?', 'text' => 'Contact our Grievance Officer.', 'label' => 'Grievance Redressal', 'href' => 'grievance-redressal.php'],
]);

require __DIR__ . '/includes/footer.php';
