<?php
declare(strict_types=1);
require __DIR__ . '/app/bootstrap.php';

$page = [
    'title'       => 'Grievance Redressal',
    'active'      => 'grievance',
    'description' => 'How to contact the OncoUday Grievance Officer, use your data rights or complain about content, and how quickly we respond.',
];

$sections = [
    ['id' => 'officer', 'title' => 'Our Grievance Officer', 'html' => '
        <ul>
            <li>Name: {grievance_name}</li>
            <li>Email: {grievance_email}</li>
            <li>Phone: {grievance_phone}</li>
        </ul>
        <p>The Grievance Officer handles questions and complaints under the Digital Personal Data Protection Act, 2023 and the Information Technology (Intermediary Guidelines and Digital Media Ethics Code) Rules, 2021.</p>'],

    ['id' => 'what', 'title' => 'What you can contact us about', 'html' => '
        <ul>
            <li><strong>Your data rights:</strong> to see a summary of your data, correct or update it, delete it, withdraw consent, or nominate someone to act for you.</li>
            <li><strong>A trial listing:</strong> a mistake, an outdated listing or a listing you believe is not authorised.</li>
            <li><strong>Content:</strong> anything on the Platform that you believe breaks our <a href="{link:terms-of-use.php}">Terms of Use</a> or the law.</li>
            <li><strong>WhatsApp messages:</strong> messages you did not ask for, or problems stopping them. Replying STOP always works straight away.</li>
        </ul>'],

    ['id' => 'how', 'title' => 'How to make a request', 'html' => '
        <p>Email or write to the Grievance Officer with:</p>
        <ul>
            <li>your name and the WhatsApp number you registered with;</li>
            <li>what you would like us to do, or what your complaint is about; and</li>
            <li>for a listing, the trial ID or a link to it.</li>
        </ul>
        <p>Please do not send medical reports or other health records. To protect your data, we may confirm your identity first, usually by sending a message to your registered WhatsApp number. If you are acting for someone else, we may ask for proof that you are allowed to.</p>'],

    ['id' => 'timelines', 'title' => 'How quickly we respond', 'html' => '
        <div class="table-responsive">
            <table class="legal-table">
                <thead><tr><th>Type of request</th><th>Our response time</th></tr></thead>
                <tbody>
                    <tr><td>Acknowledging any complaint</td><td>Within 24 hours</td></tr>
                    <tr><td>Stopping WhatsApp messages (reply STOP)</td><td>Straight away</td></tr>
                    <tr><td>Content that exposes someone’s private information or impersonates a person</td><td>Removal within 24 hours</td></tr>
                    <tr><td>Other complaints about content or listings</td><td>Resolved within 15 days</td></tr>
                    <tr><td>Data rights requests (access, correction, erasure, nomination)</td><td>Usually within 30 days</td></tr>
                    <tr><td>Grievances about personal data</td><td>Resolved within 90 days at most, as the DPDP Rules require</td></tr>
                </tbody>
            </table>
        </div>'],

    ['id' => 'escalate', 'title' => 'If you are not satisfied', 'html' => '
        <ul>
            <li><strong>Personal data:</strong> after using our grievance process, you can complain to the <strong>Data Protection Board of India</strong>, under section 13 of the DPDP Act.</li>
            <li><strong>Content decisions:</strong> you can appeal to the <strong>Grievance Appellate Committee</strong> set up under the IT Rules, 2021, within 30 days of our decision.</li>
        </ul>'],

    ['id' => 'duties', 'title' => 'A note on false complaints', 'html' => '
        <p>Please give accurate information. Under section 15 of the DPDP Act, filing a false or frivolous complaint, or pretending to be someone else, can lead to a penalty of up to ₹10,000 from the Data Protection Board.</p>'],
];

require __DIR__ . '/includes/header.php';

partial('legal-hero', [
    'title'      => 'Grievance Redressal',
    'summary'    => 'How to reach our Grievance Officer, use your data rights or report a problem, and how quickly we respond.',
    'docVersion' => '1.0',
    'current'    => 'grievance',
]);
partial('legal-document', [
    'sections' => $sections,
    'cta'      => ['title' => 'Prefer to write to us?', 'text' => 'Use the contact form and choose your topic.', 'label' => 'Contact us', 'href' => 'contact.php#grievance'],
]);

require __DIR__ . '/includes/footer.php';
