<?php
declare(strict_types=1);
require __DIR__ . '/app/bootstrap.php';

$page = [
    'title'       => 'Cookie Policy',
    'active'      => 'cookies',
    'description' => 'The cookies and browser storage the OncoUday website uses. No advertising or tracking cookies.',
];

$sections = [
    ['id' => 'summary', 'title' => 'The short version', 'html' => '
        <p>OncoUday uses only the small number of cookies and browser storage items needed for the website to work and to remember your choices. We do <strong>not</strong> use advertising, analytics or tracking cookies, and we do not let advertisers place cookies on our site.</p>'],

    ['id' => 'what', 'title' => 'What cookies and browser storage are', 'html' => '
        <p>A cookie is a small text file that a website saves in your browser. Browser storage (“local storage” and “session storage”) works in a similar way. Websites use them to keep you secure and to remember settings between pages.</p>'],

    ['id' => 'list', 'title' => 'What we use', 'html' => '
        <div class="table-responsive">
            <table class="legal-table">
                <thead><tr><th>Name</th><th>Type</th><th>Why we use it</th><th>How long it lasts</th></tr></thead>
                <tbody>
                    <tr><td><code>ou_sid</code></td><td>Cookie, strictly necessary</td><td>Keeps your visit secure and protects our forms from forged submissions (CSRF protection).</td><td>Until you close your browser</td></tr>
                    <tr><td><code>ou_lang</code></td><td>Local storage, preference</td><td>Remembers the language you chose (English, हिन्दी or മലയാളം).</td><td>Until you clear your browser data</td></tr>
                    <tr><td><code>googtrans</code></td><td>Cookie, preference</td><td>Set by the Google Translate service only when you choose Hindi or Malayalam, so that pages stay translated.</td><td>Until you switch back to English or clear your browser data</td></tr>
                    <tr><td><code>ou_explore_y</code></td><td>Session storage, functional</td><td>Keeps your place on the Explore Trials page when you change a filter.</td><td>Removed as soon as it is used, or when you close the tab</td></tr>
                </tbody>
            </table>
        </div>
        <p>None of these is used to identify you, to follow you to other websites or to show you advertisements.</p>'],

    ['id' => 'third-parties', 'title' => 'Third-party services', 'html' => '
        <p>To load quickly and reliably, our pages use some files from other services:</p>
        <ul>
            <li><strong>Google Fonts</strong>, for the fonts on our pages;</li>
            <li><strong>jsDelivr</strong>, a content delivery network that supplies standard website libraries (Bootstrap, Bootstrap Icons and AOS animations); and</li>
            <li><strong>Google Translate</strong>, only when you choose Hindi or Malayalam. Google receives the page text so that it can translate it.</li>
        </ul>
        <p>When your browser loads these files, the provider receives your IP address and basic browser information, as with any website. Their own privacy policies apply. We do not use them to track you.</p>'],

    ['id' => 'control', 'title' => 'How to control cookies', 'html' => '
        <p>You can block or delete cookies and browser storage in your browser settings. If you block the <code>ou_sid</code> cookie, our forms will not work, because it protects them. Blocking the other items only means that the website will not remember your choices.</p>'],

    ['id' => 'consent', 'title' => 'Why we do not show a cookie banner', 'html' => '
        <p>We use only items that are needed for the website to work or that remember a choice you made yourself, so we do not ask for separate cookie consent. If we ever add optional cookies, such as analytics, we will update this policy and ask for your consent before setting them.</p>'],

    ['id' => 'more', 'title' => 'More information', 'html' => '
        <p>For how we handle personal data, see our <a href="{link:privacy-policy.php}">Privacy Policy</a>. Questions can be sent to our Grievance Officer at {grievance_email}.</p>'],
];

require __DIR__ . '/includes/header.php';

partial('legal-hero', [
    'title'      => 'Cookie Policy',
    'summary'    => 'The few cookies and browser storage items our website uses, and how you can control them.',
    'docVersion' => '1.0',
    'current'    => 'cookies',
]);
partial('legal-document', ['sections' => $sections]);

require __DIR__ . '/includes/footer.php';
