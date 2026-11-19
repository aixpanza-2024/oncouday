<?php
declare(strict_types=1);
require __DIR__ . '/app/bootstrap.php';

$page = [
    'title'       => 'Listing Policy',
    'active'      => 'listing-policy',
    'description' => 'Where OncoUday trial listings come from, what the badges mean, how listings are kept current and how to report a mistake.',
];

$sections = [
    ['id' => 'sources', 'title' => 'Where listings come from', 'html' => '
        <ul>
            <li><strong>Doctors on OncoUday.</strong> Doctors and trial teams add and update their trials through a guided WhatsApp chat. These listings carry the green badge “Verified · Added by Dr …”.</li>
            <li><strong>ClinicalTrials.gov.</strong> Every night we import cancer trials that have sites in India and are recruiting or not yet recruiting. We show only the Indian sites. These listings carry the label “From ClinicalTrials.gov”.</li>
        </ul>
        <p>If the same trial comes from both sources, we show it once, as the doctor’s listing, and link the two records.</p>'],

    ['id' => 'verified', 'title' => 'What “Verified” means', 'html' => '
        <p>A “Verified” listing was added by a doctor whose WhatsApp number we have verified and who has accepted our <a href="{link:doctor-terms.php}">Terms for Doctors</a>, including the need for Ethics Committee approval and, where required, CTRI registration. The doctor confirms the listing every week.</p>
        <p>“Verified” does not mean that OncoUday or any regulator approves or recommends the trial, or that it is suitable for any particular patient.</p>'],

    ['id' => 'current', 'title' => 'How we keep listings current', 'html' => '
        <ul>
            <li>Data is refreshed daily: ClinicalTrials.gov listings every night, and doctors’ listings in real time whenever the doctor makes a change on WhatsApp.</li>
            <li>Each listing shows a “Last confirmed” date and when recruitment started or will start.</li>
            <li>Trials that stop recruiting are closed and removed from search.</li>
            <li>If a doctor does not answer the weekly check for 3 weeks, we may hide the listing until it is confirmed.</li>
        </ul>'],

    ['id' => 'content', 'title' => 'What we publish, and what we do not', 'html' => '
        <p>We publish factual details only: the title, cancer type, phase, status, medicines, hospital, city and state, registry ID and recruitment dates.</p>
        <p>We do not publish:</p>
        <ul>
            <li>claims that a treatment cures cancer or is certain to work, which the Drugs and Magic Remedies (Objectionable Advertisements) Act, 1954 prohibits;</li>
            <li>offers of payment or other inducements to take part;</li>
            <li>any information about patients or participants; or</li>
            <li>the personal contact details of trial coordinators. People who are interested register with us, and we connect them with the trial team.</li>
        </ul>'],

    ['id' => 'order', 'title' => 'How listings are ordered', 'html' => '
        <p>You can sort listings by most recently updated, by title or by city. Nobody can pay to have a trial placed higher, and we do not accept payment or advertising from trial sponsors for listings.</p>'],

    ['id' => 'ctgov', 'title' => 'About ClinicalTrials.gov', 'html' => '
        <p>ClinicalTrials.gov is a service of the U.S. National Library of Medicine (NLM). Its information is provided by trial sponsors and investigators. NLM does not review the scientific validity of the trials listed and does not endorse OncoUday or any trial shown here. We may shorten, reformat or translate imported information, and we show only the Indian sites of each trial.</p>'],

    ['id' => 'corrections', 'title' => 'Reporting a mistake', 'html' => '
        <p>If you find a mistake, an outdated listing or a listing you believe is not authorised, tell us through <a href="{link:grievance-redressal.php}">Grievance Redressal</a> and include the trial ID. We check every report with the trial team and correct, hide or remove the listing as needed, usually within 15 days.</p>'],
];

require __DIR__ . '/includes/header.php';

partial('legal-hero', [
    'title'      => 'Listing Policy',
    'summary'    => 'Where our trial listings come from, what the badges mean and how we keep them accurate.',
    'docVersion' => '1.0',
    'current'    => 'listing-policy',
]);
partial('legal-document', [
    'sections' => $sections,
    'cta'      => ['title' => 'Looking for a trial?', 'text' => 'Search open cancer trials across India.', 'label' => 'Explore trials', 'href' => 'explore-trials.php'],
]);

require __DIR__ . '/includes/footer.php';
