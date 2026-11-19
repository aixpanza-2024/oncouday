# OncoUday — Software Requirements Specification (SRS)

| | |
|---|---|
| **Product** | OncoUday — India's Gateway to Cancer Clinical Trials and Patient Support |
| **Prepared by** | AIXPANZA Private Limited |
| **Prepared for** | OncoUday |
| **Document version** | 1.16 |
| **Date** | 18 November 2026 |
| **Status** | Phase 1 (website design build) complete. Phases 2–3 (database integration, APIs, admin panel, WhatsApp) planned. |
| **Design reference** | OncoUday Website Design v2.3 (All Pages), 10 November 2026 |

> **Maintenance rule:** This SRS is a living document. Every feature, page, table, API or configuration added to the project must be recorded here, both in the relevant section and in the **Change Log** (Section 13), in the same change.

---

## 1. Introduction

### 1.1 Purpose
This document specifies the functional and non-functional requirements of the OncoUday website and its supporting platform. It is the reference for design, development, testing and acceptance, and it is updated whenever the project changes.

### 1.2 Scope
OncoUday helps cancer patients, caregivers and doctors in India find cancer clinical trials:

* **Patients and caregivers** register once with their city and cancer type and receive WhatsApp alerts when a matching trial opens.
* **Doctors running trials** register once and then add, update and close trials in a guided WhatsApp chat, confirming each listing with a one-tap weekly check.
* **Doctors following trials** receive WhatsApp alerts when a trial opens in their city or specialty.
* **Everyone** can browse active trials, which doctors add or which are imported every night from ClinicalTrials.gov. Visitors can also read plain-language guidance and their rights as trial participants.

OncoUday shares trial information only. It does not give medical advice and does not enrol anyone in a trial.

### 1.3 Delivery phases
| Phase | Content | Status |
|---|---|---|
| 1 | Responsive, animated website (all pages) on the 3-tier PHP structure, sample data layer, MySQL schema with indexes, security baseline | **Complete** |
| 2 | MySQL integration (switch data source), form processing (registration, contact), REST/JSON APIs, admin panel (trials, medicines, FAQs, guides, team, partners, messages) | Planned |
| 3 | WhatsApp Business integration (verification, alerts, weekly checks, trial chat), nightly ClinicalTrials.gov import, Hindi and Malayalam translations | Planned |

### 1.4 Definitions
| Term | Meaning |
|---|---|
| NCT ID | Trial identifier on ClinicalTrials.gov (e.g. NCT0XXXXXXX) |
| CTRI | Clinical Trials Registry – India |
| DPDP Act | Digital Personal Data Protection Act, 2023 (India) |
| Data Fiduciary | The entity deciding how personal data is processed (OncoUday) |
| Weekly check | One-tap WhatsApp message asking a doctor whether a trial is still active |
| Sample data source | The design-stage repository that serves placeholder data from PHP arrays |

---

## 2. Overall Description

### 2.1 User classes
| User | Description | Main goals |
|---|---|---|
| Patient / caregiver | Adult patient, or parent / guardian / family member | Find and be alerted about matching trials; understand trials and rights |
| Doctor running trials | Investigator or trial team member | List trials, keep them current, reach matching patients |
| Doctor following trials | Oncologist or physician not running trials | Stay informed about new trials for their patients |
| Visitor | Anyone | Browse trials, read guides, contact OncoUday |
| Administrator (Phase 2) | OncoUday staff | Manage trials, medicines, content, messages and grievances |

### 2.2 Operating environment
* **Server:** Apache 2.4 with PHP 8.2+ (developed on XAMPP), MySQL 8.0+ / MariaDB 10.6+.
* **Client:** current Chrome, Edge, Firefox and Safari on desktop, tablet and mobile (Android and iOS), from 320 px width upwards.
* **Front-end libraries (CDN, pinned versions):** Bootstrap 5.3.8 (CSS + JS bundle), Bootstrap Icons 1.13.1, AOS 2.3.4, Google Fonts (Bricolage Grotesque, Figtree).

### 2.3 Design and implementation constraints
* Tech stack: HTML5, CSS3, JavaScript (vanilla), Bootstrap (latest 5.3), PHP (three-tier), MySQL.
* No inline `<script>` blocks; all JavaScript lives in `assets/js/main.js` (required by the Content-Security-Policy).
* Code comments are written only where a request is sent to a server (form posts, page requests for filters/sorting, database queries), in short plain language. No other comments are added to code or templates. `database/schema.sql` keeps its own documentation.
* Header, footer, navigation and repeated components are rendered from shared include files. Markup is not repeated across pages.
* No placeholder or "to be finalised" text is shown on the site, except the sample trial listings served by the sample data source until the database is connected.

### 2.4 Assumptions
* Copy, legal wording, team photos and contact details are final.
* WhatsApp messaging uses the official WhatsApp Business Platform (Phase 3).

---

## 3. System Architecture

### 3.1 Three-tier structure
| Tier | Location | Responsibility |
|---|---|---|
| Presentation | `/*.php` pages, `/includes/header.php`, `/includes/footer.php`, `/includes/partials/*`, `/includes/illustrations/*`, `/assets/*` | Markup, layout, animations, client-side validation. All dynamic output escaped with `e()`. |
| Business logic | `/app/services/TrialService.php`, `/app/services/ContentService.php` | Validates and whitelists input, applies filtering rules and paging, and calls the repositories |
| Data access | `/app/repositories/*`, `/app/core/Database.php` | Reads and writes data through PDO prepared statements only |

The data source is switched in `app/config/config.php` (`app.data_source`: `sample` or `mysql`), or with the `APP_DATA_SOURCE` environment variable. Both repositories implement `TrialRepositoryInterface`, so the pages and services do not change when the database is connected.

### 3.2 Directory structure
```
oncouday/
├── index.php, about.php, what-is-a-clinical-trial.php, explore-trials.php,
│   doctor-registration.php, patient-registration.php, faq.php,
│   advocacy-centre.php, contact.php, privacy-policy.php,
│   terms-of-use.php, medical-disclaimer.php, 404.php
├── .htaccess                     Access rules, compression, caching, 404
├── app/
│   ├── bootstrap.php             Loads config, autoloader, helpers, headers, session
│   ├── config/config.php         App, DB, contact and social settings (env overrides)
│   ├── core/                     Database (PDO), Security, Request, helpers
│   ├── repositories/             TrialRepositoryInterface, Sample/Mysql repositories, ContentRepository
│   ├── services/                 TrialService, ContentService
│   └── data/                     Sample trials and content (design stage)
├── includes/
│   ├── header.php, footer.php    Shared layout
│   ├── partials/                 brand, language-switcher, trial-card, cta-band, legal-document, modals
│   └── illustrations/            sunrise, orbit, dna, radar, heartbeat, match, cells, shield, rings
├── assets/css/style.css          Design system and animations
├── assets/js/main.js             Behaviour and interactions
├── assets/img/                  logo.png (192 px), logo-512.png (share image), favicon.png, apple-touch-icon.png
├── database/schema.sql           Full MySQL schema, indexes and seed data
└── docs/SRS.md                   This document
```

### 3.3 Shared layout and reuse
* `includes/header.php` renders `<head>`, top bar, language switcher and main navigation. The active nav item comes from `$page['active']`.
* `includes/footer.php` renders the optional disclaimer strip, the footer, shared modals and the scripts.
* The navigation and footer links come from one source (`app/data/content.php` → `navigation`, `footerColumns`). The main navigation has 5 links (Home, About Us, Explore Trials, What is a Clinical Trial, Contact Us) and 2 buttons (*I'm a doctor*, *I'm a patient*). FAQ and Advocacy Centre are linked from the footer. On desktop the footer is one row: the brand block (4 of 12 columns) and the four link columns Explore, Register, OncoUday and Legal (2 each). On tablets the link columns sit four across under the brand block, and on phones two across.
* The top bar reads "Data refreshed daily. Real-time updates directly from researchers and trial teams." (on phones: "Data refreshed daily. Real-time trial updates.").
* A round, icon-only WhatsApp button floats on every page (bottom right, below the back-to-top button), and a green WhatsApp icon leads the social icons in the footer (both labelled *WhatsApp us* for screen readers). Both open a WhatsApp chat with "Hi" typed in, so people who find forms difficult can register in the chat. The number is `config('contact.whatsapp_chat')`: +91 80505 19549 by default, which the `WHATSAPP_CHAT_NUMBER` environment variable can override.
* A shared State → City component (`partials/state-city`) renders a State select and a City select. The City select carries the cities grouped by state in `data-cities`. In `main.js`, `citiesFor(select, state)` returns a Promise of the cities for a state, and `fillCities()` rebuilds the City options when the state changes. On forms the City select stays disabled until a state is chosen. When the backend is connected, only `citiesFor()` changes, to fetch the list from the database over AJAX.
* Information pages show "Information last reviewed on [date]" (partial `reviewed`, dates in `content.php` → `reviewed`): About, What is a Clinical Trial, Explore Trials, FAQ and Advocacy Centre.
* Reusable components are rendered with `partial('name', [...])` and illustrations with `illustration('name')`. Both functions isolate variables and apply `basename()` to the name, which blocks path traversal.
* Assets are linked through `asset()`, which appends a file-modification version for cache-busting.

---

## 4. Functional Requirements — Pages

Every page has the shared header (top bar, navigation, *I'm a doctor* / *I'm a patient* buttons), the shared footer, scroll-triggered (AOS) animations and its own animated illustration.

### 4.1 Home (`index.php`) — illustration: rising sun with rotating rays
* FR-H1 Hero with headline, intro, *Register as a patient* / *Register as a doctor* buttons (the data-refresh line appears only in the top bar). The rising sun fills the right side (turning ray ring, breathing halo, peach core) with the OncoUday logo placed in its core and 24 soft, thin light rays (sun-orange fading to transparent, alternating long and short) radiating from behind the logo to the halo, gently pulsing. On tablets and phones the logo and its rays are hidden, because the sun sits behind the heading there.
* FR-H2 *Alerts arrive on WhatsApp* section (moved out of the hero): the animated WhatsApp chat mock (messages appear one by one with a typing indicator) beside a *Prefer WhatsApp to forms?* box with a *WhatsApp us* button.
* FR-H3 Quick search (cancer type, state, city, recruitment start month, medicine or keyword) that submits to Explore Trials as GET parameters. State and City use the shared State → City component (see 3.3).
* FR-H4 *Explore all open trials* banner.
* FR-H5 *Recently updated trials*: the 3 latest trials from `TrialService::recent()`, each with a *Details* link to the trial card on Explore Trials (highlighted on arrival).
* FR-H6 *Three ways to use OncoUday*: patient, doctor running trials and doctor following trials, each with 3 steps and a CTA. The doctor CTAs preselect the registration mode.
* FR-H7 Navy band for doctors with an animated weekly-check chat.
* FR-H8 Four benefits of trials.
* FR-H9 *Know your rights* band linking to the Advocacy Centre.
* FR-H10 FAQ preview (3 questions) and the medical disclaimer strip.

### 4.2 About Us (`about.php`) — illustration: orbit
* *Why OncoUday?* story (after the hero): the problem doctors face finding trials, the founder's personal reason (his father's multiple myeloma), trial teams updating their own listings on WhatsApp, and a highlighted quote: OncoUday means "the dawn of oncology", and access to a trial should depend on a patient's needs, not on whom their doctor knows.
* *What OncoUday aims to offer* (after *Who OncoUday serves*): six cards: free oncology-specific search (not a copy of a registry), plain-language explanations, multilingual access, referrals and alerts, information for investigators, WhatsApp-based updates.
* A disclaimer box above the join band: no medical advice or guaranteed participation, information comes from research teams, eligibility is decided by the trial team, and patient data is shared only with consent.
* Mission and vision cards (the mission mentions real-time updates directly from researchers and trial teams), *Who OncoUday serves* (3 cards), *Built for how India communicates* (4 numbered pillars with count-up) and a join CTA band. The *Hospitals and partners* logo section is removed for now (its styles are kept for when logos are supplied).
* *The people behind OncoUday*, grouped from `content.php` → `team`: Founders (Dr Uddiptya Goswami, Founder; Dr Subhadarsini Mohapatra, Co-Founder), Medical advisor (Dr Boben Thomas) and Contributors, in this order: Dipanjan Narayan Chaudhary (Senior Data & AI Engineer), Uddipan Goswami (Data Engineer), Sayantika Sengupta (Data & AI Engineer), Mohammed Hashim (Freelancer). Cards are the same size in every group (4 across on desktop, 2 on tablets, 1 on phones). A member with a `photo` key shows a full-width head-and-shoulders portrait from `assets/img/team/` (480×600 JPEG, 4:5, rounded corners); the others show their initials in a box of the same size. Photos are in place for all seven members.

### 4.3 What is a Clinical Trial (`what-is-a-clinical-trial.php`) — illustration: DNA wave of dots
* *On this page* anchor navigation.
* Four phases shown as rising steps, with people icons that grow by phase.
* *How participants are protected* (4), possible benefits vs things to think about, and a *Why doctors join* band.
* Six *Questions to ask your doctor* and the disclaimer strip.

### 4.4 Explore Clinical Trials (`explore-trials.php`) — illustration: radar sweep
* FR-E1 Cancer-type chips: All + the top 5 cancers (Breast, Lung, Head and neck, Cervical, Blood cancers) on one line. On narrow screens the row scrolls sideways instead of wrapping. The other types stay in the Cancer type filter.
* FR-E1a Full-width search bar above the results ("Search by medicine, keyword, hospital or trial ID…" with a *Search* button; matches title, medicines, trial ID, cancer type, hospital and city). It keeps all other filters, runs on Enter or the button, and clearing it with its × reloads without the keyword.
* FR-E1b Active filter pills above the results, one per chosen filter (keyword, cancer type, state, city, start month, each phase, status and source), each with × to remove just that filter (removing the state also removes the city), plus *Clear all*.
* FR-E2 Filter panel: cancer type, state and city (shared State → City component; the server lists only the cities of the chosen state), recruitment start month (6 months back to 12 months ahead), phase (I–IV), status (Recruiting, Not yet recruiting) and *Listed by* (Doctors on OncoUday (verified), ClinicalTrials.gov). It is a sidebar on desktop and an off-canvas panel on mobile. Below *Clear filters* a *Get WhatsApp alerts for new trials* box links to Patient Registration.
* FR-E3 Panel filters apply automatically on change, and the page returns to the same scroll position after reloading (it no longer jumps to the top). Changing the state clears the city.
* FR-E3a Checkboxes left unticked mean "no limit": with no status, phase or source ticked, all open trials are shown. *Clear filters* leaves every field blank and shows all trials.
* FR-E4 Result count with range ("7 trials found · showing 1 to 7"), results per page (*Show 10 | 20 | 50 per page*, `per` parameter, default 10) and sorting: Recently updated, Title (A–Z) and City (A–Z, then most recently updated). No location or GPS data is used.
* FR-E5 Each trial card shows its result number (1, 2, 3… continuing across pages), cancer type, status, phase, registry ID (NCT numbers link to the study on ClinicalTrials.gov and CTRI numbers to the CTRI search, in a new tab; other IDs are plain text), a source badge (green *Verified · Added by Dr X* for doctor listings, blue *From ClinicalTrials.gov* for imported ones), title, medicines, hospital, city and state, the recruitment start ("Recruiting since Mar 2026" / "Recruitment starts Jan 2027") and "Last confirmed [date]".
* FR-E6 *I'm interested* opens a modal with the trial title, hospital and trial ID, and two links: *I'm a patient or caregiver* (patient registration) and *I'm a doctor* (doctor registration). Trial coordinator contacts are not shown on the website. Values are written with `textContent`.
* FR-E7 Empty state with *Clear filters* and *Get trial alerts*. Pagination follows the chosen page size.
* FR-E8 Server-side validation: every GET value is checked against a whitelist (cancer, state and city values, phases, statuses, sources, sorts, page sizes 10/20/50). The month must match `YYYY-MM` and the location must fall inside India's bounds. Free text is trimmed, stripped of control characters and limited to 80 characters.

### 4.5 Doctor Registration (`doctor-registration.php`) — illustration: heartbeat line
* FR-D1 Mode selection: *I run clinical trials* / *I don't run trials — I want to follow them*. It can be preselected with `?mode=running|following` (whitelisted).
* FR-D2 The *After you register* panel, the consent wording and the optional cancer-types multi-select change with the chosen mode.
* FR-D3 Fields: full name, email, WhatsApp number (+91, 10 digits, starting 6–9), hospital or clinic, state and city (State → City component), specialty, and the cancer types to get alerts for (following mode only, optional). The consent checkbox links to the Terms for Doctors, Terms of Use, Privacy Policy and Consent Notice.
* FR-D4 Consents: Terms for Doctors + Privacy Policy, and WhatsApp messages (both required).
* FR-D5 Client-side validation with inline messages, a loading state and a success modal. Phase 2 will add server processing with CSRF verification. The CSRF token is already rendered.

### 4.6 Patient Registration (`patient-registration.php`) — illustration: matching lines
* FR-P1 *Patient's age* (required, 0–120 years) sits next to *Cancer type*. An age under 18 shows the guardian notice and a required guardian-name field just below that row.
* FR-P2 Fields in order: full name, email, WhatsApp number, state and city (State → City component; never an address), cancer type, then age. The consent checkboxes link to the Consent Notice and Privacy Policy, and a note links to the Terms of Use and Medical Disclaimer. The short consent notice (v1.1) in all three languages lists age among the collected details.
* FR-P3 Consent notice v1.0 with English / हिन्दी / മലയാളം tabs, including the Grievance Officer details.
* FR-P4 Separate consents for platform data use and WhatsApp alerts (both required). The notice version is submitted with the form.
* FR-P5 Assurance cards (private, discreet, stop any time), a *Find the form difficult?* box with a *WhatsApp us* button, and a note that registering is not enrolment.
* FR-P6 The matching illustration shows two trials: *Trial A — Not a match* (grey) and *Trial B — ✓ Matched* (highlighted).

### 4.7 FAQ (`faq.php`) — illustration: floating cells
* The search bar sits in the centre of the hero, above the category tabs (Patients & caregivers, Doctors, Privacy, About the listings), which are also centred. The questions are accordions.
* Live search across all categories with an empty-state message.
* New patient questions: *The trial I like is not yet recruiting. What should I do next?* (register and we notify you on WhatsApp when the trial reaches its start date and begins recruiting) and *I find the form difficult. Can I register on WhatsApp instead?*. *How often are listings updated?* now says data is refreshed daily with real-time updates from doctors and trial teams.
* *Ask the OncoUday team directly* CTA.

### 4.8 Advocacy Centre (`advocacy-centre.php`) — illustration: turning rings
* Orange hero with 4 pillars (Awareness, Access, Rights, Support).
* Six participant rights, three *Help more patients* cards and a registration CTA. (The guide cards were removed because their content was not ready.)

### 4.9 Contact Us (`contact.php`) — illustration: rings
* Contact form: name, email, phone (optional), *I am a* (patient, caregiver, doctor, hospital/partner, volunteer, other), and message (10–2000 characters with a counter). It includes a honeypot field and a CSRF token.
* *Reach us directly* box (email info@oncouday.com and working hours 9 am to 5 pm, Monday to Saturday; no office address or WhatsApp number shown), Grievance Officer box (anchor `#grievance`, 90-day resolution) and a medical-emergency note.

### 4.10 Legal pages
All legal pages share `partials/legal-hero` (eyebrow, title, summary, effective date and version, and chips linking every legal page) and `partials/legal-document` (sticky numbered contents with scroll-spy and numbered sections). Section text uses tokens that `legal_html()` fills from config: `{grievance_name|email|phone}`, `{contact_email}`, `{notice_version}` and `{link:page.php}`. The effective date is set in `config.php` → `legal.effective`. The documents name the operator as OncoUday, the courts as the courts in India, and the hosting provider generically; no postal address is given.

| Page | File | Covers |
|---|---|---|
| Privacy Policy (v1.1) | `privacy-policy.php` | DPDP Act 2023 and DPDP Rules 2025: Data Fiduciary and processors, itemised data per user type, purposes and lawful basis (s.6 consent, s.7 legitimate uses), consent withdrawal and Consent Managers, WhatsApp/Meta processing, sharing, cross-border transfer (s.16), security safeguards (s.8(5)), retention periods, rights (s.11–14), duties (s.15, ₹10,000 penalty), children and guardians (s.9), breach notification, Grievance Officer (90 days), changes. No location data is collected. |
| Consent Notice (v1.1) | `consent-notice.php` | Standalone s.5 notice: itemised data and purposes for patients and for doctors, the two consents, how to withdraw, rights, complaint to the Data Protection Board, Eighth Schedule languages on request. |
| Terms of Use | `terms-of-use.php` | User agreement under the IT Act 2000 and IT (Intermediary Guidelines) Rules 2021: what OncoUday is and is not, eligibility (18+, guardians), WhatsApp service, listings, prohibited content (Rule 3(1)(b) list plus cancer-cure claims under the Drugs and Magic Remedies Act 1954, inducements, scraping), IP and ClinicalTrials.gov attribution, no warranties, liability cap (₹1,000, statutory rights preserved), indemnity, termination, grievance (24 h / 15 days, Grievance Appellate Committee), governing law and courts, general terms. |
| Terms for Doctors | `doctor-terms.php` | Eligibility (NMC / State Medical Council registration or authorised trial team), verification, warranties before listing (NDCT Rules 2019 / CDSCO permission, registered Ethics Committee, CTRI), permitted and prohibited listing content, weekly-check duties (7 days; hidden after 3 weeks), meaning of *Verified*, handling of patient enquiries (DPDP, EC-approved consent, ICMR 2017, GCP), following doctors, licence, removal, fees (30 days' notice), indemnity. |
| Medical Disclaimer | `medical-disclaimer.php` | Not medical advice and no doctor–patient relationship, talk to your doctor, registering is not enrolment, risks of trials, accuracy, no endorsement (including the NLM / ClinicalTrials.gov disclaimer), translations, emergencies (112 / 108). |
| Listing Policy | `listing-policy.php` | Sources and de-duplication, meaning of *Verified*, how listings stay current, what is and is not published (no cure claims, inducements, patient data or coordinator contacts), ordering with no paid placement, ClinicalTrials.gov attribution, reporting mistakes. |
| Cookie Policy | `cookie-policy.php` | Table of `ou_sid`, `ou_lang`, `googtrans`, `ou_explore_y`; third-party files (Google Fonts, jsDelivr, Google Translate); no advertising or analytics cookies, so no cookie banner; how to control cookies. |
| Grievance Redressal | `grievance-redressal.php` | Grievance Officer details, what can be raised, how to make a request and verification, response times (24 h acknowledgement, 24 h for private-information or impersonation content, 15 days for content, about 30 days for rights requests, 90 days maximum for data grievances), escalation to the Data Protection Board and the Grievance Appellate Committee. |

The footer has a *Legal* column listing all eight pages, and *Grievance Officer* links point to Grievance Redressal. The contact form notes that details are used only to reply, with a link to the Privacy Policy.

### 4.11 Legal review
The documents are drafted for Indian law as it stands in November 2026 and are final. Contact details: general contact info@oncouday.com and +91 80505 19549 (`contact.email`, `contact.whatsapp`); Grievance Officer Dr Uddiptya Goswami (Founder), grievance@oncouday.com, +91 87777 34849 (`contact.grievance`). Working hours are 9 am to 5 pm, Monday to Saturday (`contact.hours`). No office address is shown.

### 4.12 Error page (`404.php`)
* A friendly *page not found* page with links to Home and Explore Trials. It is configured in `.htaccess`.

### 4.13 Language switcher
* English, हिन्दी and മലയാളം buttons in the top bar (and in the mobile menu). The choice is stored in the browser. Translated pages come in Phase 3. Until then a notice explains this.

---

## 5. Data Requirements

### 5.1 Database
`database/schema.sql` creates the `oncouday` database (InnoDB, utf8mb4_unicode_ci) with 23 tables and seed data for languages, cancer types, cities (with state), specialties and FAQ categories. `cities.state` (indexed) supports the State filter, `trials.start_date` the recruitment-month filter, and `patients.age` the patient's age. Colorectal cancer is no longer a featured chip.

| Group | Tables |
|---|---|
| Lookups | `languages`, `cities`, `cancer_types`, `specialties`, `hospitals`, `medicines` |
| People | `doctors`, `doctor_alert_cancer_types`, `patients`, `consents` |
| Trials | `trials`, `trial_medicines`, `trial_weekly_checks`, `ctgov_import_runs` |
| Messaging | `alerts` |
| Content | `faq_categories`, `faqs`, `guides`, `team_members`, `partners`, `contact_messages` |
| Admin & security | `admin_users`, `audit_logs` |

### 5.2 Indexing strategy (performance)
| Index | Serves |
|---|---|
| `trials.idx_trials_listing (is_published, status, updated_at)` | Default listing and *recently updated trials* |
| `trials.idx_trials_cancer_city (is_published, cancer_type_id, city_id, status)` | Filtering by cancer type and city |
| `trials.ft_trials_search FULLTEXT (title, medicines_text)` | Medicine and keyword search |
| `trials.idx_trials_start (start_date)` | Recruitment start month filter |
| `cities.idx_cities_state (state)` | State filter |
| `trials.idx_trials_confirm (source, status, last_confirmed_at)` | Weekly-check queue |
| `patients.idx_patients_match (status, cancer_type_id, city_id)` | Matching a new trial to patients |
| `doctors.idx_doctors_alerts (status, usage_mode, city_id, specialty_id)` | Alerts to following doctors |
| `alerts.uq_alerts_dedupe` / `idx_alerts_queue (status, created_at)` | No duplicate alerts; send queue |
| `consents.idx_consents_subject` | Consent history per person |
| `contact_messages.idx_contact_ip_time` | Rate limiting |
| Unique slugs, hashes and registry IDs | Exact lookups |

Every foreign-key column is indexed. The listing query was checked with `EXPLAIN`: it uses unique and indexed lookups, with no full table scans.

### 5.3 Personal data storage
* Patient name, email and WhatsApp number, and doctor email and WhatsApp number, are stored encrypted (`*_enc` VARBINARY columns). A keyed HMAC-SHA256 hash (`*_hash`) supports indexed exact-match lookups and uniqueness (`Security::lookupHash()`).
* Only the city is collected, never the address.
* Every consent is recorded with the notice version, language and time.

---

## 6. Security Requirements

| ID | Requirement | Implementation |
|---|---|---|
| SEC-1 | No SQL injection | PDO with native prepared statements (`ATTR_EMULATE_PREPARES=false`). All values are bound parameters. IN() lists use generated placeholders. ORDER BY comes from a fixed map. LIKE wildcards are escaped. FULLTEXT terms are sanitised. utf8mb4 is set in the DSN. Strict SQL mode. |
| SEC-2 | No XSS | All dynamic output goes through `e()` (`htmlspecialchars`, ENT_QUOTES, UTF-8). JavaScript writes dynamic text with `textContent` only. The Content-Security-Policy blocks inline and third-party scripts. |
| SEC-3 | Input validation | `Request` helper: type checks, trimming, control-character removal, length limits and whitelists. Client-side HTML5 and Bootstrap validation for usability. |
| SEC-4 | CSRF | A session token is rendered in every form (`csrf_field()`) and checked with `hash_equals` (`Security::verifyCsrf()`). Server-side checking is enforced from Phase 2. |
| SEC-5 | Security headers | CSP, X-Content-Type-Options, X-Frame-Options DENY, Referrer-Policy, Permissions-Policy, COOP, HSTS on HTTPS. `X-Powered-By` is removed. |
| SEC-6 | Session hardening | Strict mode, cookies only, HttpOnly, SameSite=Lax, Secure on HTTPS, custom session name |
| SEC-7 | File access | `.htaccess` denies web access to `app/`, `includes/`, `database/`, `docs/`, dotfiles and `.sql/.md/.env` files. Directory listing is off. |
| SEC-8 | Spam | A honeypot field on the contact form. Rate limiting by IP hash in Phase 2. |
| SEC-9 | Errors | Errors are not displayed when `APP_ENV=production`. They are logged instead. |
| SEC-10 | Admin (Phase 2) | Argon2id passwords, account lockout, optional MFA, role-based access, audit log |

---

## 7. Non-Functional Requirements

### 7.1 Responsiveness
* 100% responsive from 320 px to large desktops, using the Bootstrap grid and custom breakpoints at 1400, 1200, 992, 768 and 576 px.
* One shared content container for every page body section: `.container` = max-width 1200px, centred, side padding `clamp(20px, 5vw, 72px)`. Section backgrounds run full width; only content sits in the container. No section or inner element adds its own side indent, so all body content shares one left edge. The top bar, navigation and footer keep their own `container-xxl` layout.
* Below 1200 px the navigation becomes an off-canvas menu with staggered link animation. Below 992 px the Explore filters become an off-canvas panel.
* No horizontal scrolling, touch-friendly targets, and phone fields that open the numeric keyboard. The page body and footer clip side overflow (`overflow-x: clip`), so side-sliding AOS animations and wide decorative illustrations never widen the page. The header blur sits on a `::before` layer, so the off-canvas menu is fixed to the screen and opens full height.

### 7.2 Animation and interaction
* AOS scroll animations on all sections (fade, zoom and flip, with staggered delays). They run once.
* A CSS-animated illustration on every page (see Section 4), shown at every screen size, including phones. Below 992 px: the Home and 404 sun is resized into the top-right corner of the hero with its floating dots beside the buttons, the Explore radar (190 px) and Privacy shield (160 px) appear centred under the hero text, and the Doctor Registration heartbeat keeps its natural scale with extra space above the title.
* Hover transitions on cards, buttons (lift and shine), chips, links and icons. A sticky header shrinks on scroll. There is a scroll progress bar, a back-to-top button, mouse parallax on hero illustrations, count-up numbers, sequenced chat messages, modal and toast transitions, and form shake on errors.
* `prefers-reduced-motion` is respected: animations are disabled and content shows at once.

### 7.3 Performance
* Pinned CDN libraries with `preconnect`. Scripts load with `defer`. Fonts use `display=swap`.
* Static assets are versioned and cached for 1 year. Gzip (deflate) is enabled through `.htaccess`.
* Illustrations are CSS/SVG (no images to download). Animations use `transform` and `opacity`, and scroll handlers use `requestAnimationFrame`.
* Database: the indexes in Section 5.2, LIMIT/OFFSET paging with a 100-row cap, and a single shared PDO connection per request.

### 7.4 Accessibility
* Semantic landmarks, a skip link, `aria-current` on the active page, labelled form controls, `aria-*` on tabs, accordions, modals and the menu, visible focus outlines, `lang` attributes on Hindi and Malayalam text, and decorative illustrations hidden from screen readers.

### 7.5 Localisation
* UTF-8 throughout. The consent notice is already in English, Hindi and Malayalam. Full page translations are planned for Phase 3, and the `languages` table and `lang` columns are ready for them.

### 7.6 Privacy and compliance
* Built around the DPDP Act, 2023: purpose limitation, separate consents, recorded notice versions, withdrawal (STOP), deletion requests, a Grievance Officer and breach notification. Patients under 18 are registered by a guardian.

---

## 8. External Interfaces (planned)
| Interface | Phase | Purpose |
|---|---|---|
| WhatsApp Business Platform API | 3 | Verification, alerts, weekly checks, trial-adding chat, STOP handling |
| ClinicalTrials.gov API | 3 | Nightly import and NCT auto-fill |
| Internal REST/JSON API | 2 | Registration, contact, trial search and admin operations |

## 9. Admin Panel (Phase 2 — planned scope)
* Manage trials (add, edit, publish, close), medicines, hospitals, cities, cancer types and specialties.
* Manage FAQs, guides, team members and partners.
* Contact messages and grievances inbox. Consent and deletion requests.
* View doctors and patients (masked contact data), alert queue and import runs.
* Admin users, roles and the audit log.

## 10. Configuration
| Setting | Location | Default |
|---|---|---|
| Environment | `APP_ENV` | development |
| Data source | `APP_DATA_SOURCE` / `app.data_source` | sample |
| Database | `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS` | 127.0.0.1, 3306, oncouday, root, (empty) |
| Lookup hash pepper | `APP_HASH_PEPPER` | must be set in production |
| Contact and grievance details | `app/config/config.php` → `contact` | set |

## 11. Installation (development)
1. Copy the project to `xampp/htdocs/oncouday`.
2. Start Apache (and MySQL from Phase 2).
3. Optional for now: import `database/schema.sql` in phpMyAdmin or with `mysql -u root < database/schema.sql`.
4. Open `http://localhost/oncouday/`.

## 12. Acceptance Criteria (Phase 1)
* All 10 pages from design v2.3 (plus Terms of Use, Medical Disclaimer and 404) render without PHP errors or warnings. **Verified.**
* Header and footer come only from the shared includes. **Verified.**
* Explore filters reject non-whitelisted values, and script input is shown as escaped text. **Verified.**
* The schema imports cleanly on MySQL, and the listing query uses indexes. **Verified** (23 tables, 134 index entries).
* Layout works from 320 px to desktop, and animations respect reduced motion.

---

## 13. Change Log
| Version | Date | Change |
|---|---|---|
| 1.0 | 10 Nov 2026 | Initial release of Phase 1. Three-tier PHP structure (`app/core`, `app/services`, `app/repositories`). Shared header, footer and partials. Pages: Home, About Us, What is a Clinical Trial, Explore Trials (server-side filters, sorting, paging, enrolment modal), Doctor Registration (running / following modes), Patient Registration (guardian flow, 3-language consent notice), FAQ (tabs + live search), Advocacy Centre, Contact Us, Privacy Policy, Terms of Use, Medical Disclaimer, 404. Design system stylesheet, per-page animated illustrations, AOS animations, `main.js` interactions. MySQL schema (23 tables, indexes, FULLTEXT, seed data). Security baseline (prepared statements, output escaping, CSP and security headers, CSRF tokens, hardened session, `.htaccess` access rules). SRS created. |
| 1.1 | 10 Nov 2026 | Top bar text (shared header) changed from "refreshed every night" to "refreshed every second". |
| 1.2 | 10 Nov 2026 | Horizontal layout fix for page body sections (heroes, all content sections, CTA bands, disclaimer strip): one shared `.container` (max-width 1200px, `margin-inline: auto`, `padding-inline: clamp(20px, 5vw, 72px)`), replacing `container-xxl` / `container-xl`. Section backgrounds stay full width. Body content shares one left edge, checked at 375, 768, 1242 (1366 at 110% zoom), 1366 and 1920px with no horizontal scroll. The top bar, navigation and footer are excluded and keep their original `container-xxl` layout. |
| 1.3 | 15 Nov 2026 | Code comment policy: all comments removed from PHP, HTML templates, CSS, JavaScript, SVG and `.htaccess`. Short plain-language comments kept only where a request is sent to a server: form submission and the Explore filter/sort requests in `assets/js/main.js`, and the query entry point `Database::run()`. `database/schema.sql` unchanged. |
| 1.4 | 15 Nov 2026 | Version control: Git repository initialised (branch `main`, remote `github.com/aixpanza-2024/oncouday`). `.gitignore` added for environment files and local config, logs, cache, uploads, backups and database dumps, dependency folders, and editor/OS files. |
| 1.6 | 16 Nov 2026 | Mobile fixes. Pages no longer scroll sideways on phones: the header blur moved to `.site-header::before` (it had made the hidden off-canvas menu widen every page to about 730 px, and limited the open menu to the header height), and `#main` and `.site-footer` clip side overflow from AOS fade-left/right and from footer gutters. Animated illustrations now show on phones on every page: Home and 404 sun moved into view, Explore radar and Privacy shield un-hidden, Doctor Registration heartbeat no longer squashed. Checked at 360, 390, 768 and 1400 px with no horizontal scroll, and the desktop layout is unchanged. |
| 1.7 | 18 Nov 2026 | Client review changes. Navigation cut to 5 links + 2 buttons (FAQ and Advocacy Centre moved to the footer). Top bar, home hero, Explore intro, About mission and FAQ now say data is refreshed daily with real-time updates directly from researchers and trial teams. "Information last reviewed" dates on About, What is a Clinical Trial, Explore, FAQ and Advocacy Centre. *WhatsApp us* (floating button, footer, home and patient registration) opens a WhatsApp chat with "Hi". Home: WhatsApp chat mock moved from the hero to its own section; quick search gains state, city filtered by state, recruitment start month and *Medicine or keyword*. Explore: top 5 cancer chips on one line; state, city and recruitment-month filters; unticked checkboxes show all trials and *Clear filters* leaves fields blank; scroll position kept after filtering; sort by Recently updated, Title or Distance (nearest, by location or selected city); verified-doctor vs ClinicalTrials.gov badges, recruitment start and last-confirmed date on every card; *I'm interested* links to patient or doctor registration instead of showing coordinator contacts. Patient registration asks the patient's age (under 18 shows the guardian step) and the matching illustration shows Trial A (no match) and Trial B (matched). FAQ search centred, plus two new questions. About lists the founders, medical advisors and contributors. Schema: `cities.latitude/longitude` and `idx_cities_state`, `trials.start_date` and `idx_trials_start`, `patients.age`. Geolocation allowed for the site itself in `Permissions-Policy`. |
| 1.8 | 18 Nov 2026 | New OncoUday logo (sun, three figures, cancer ribbon) from the client's file replaces the old `logo.svg` in the header, mobile menu, footer and home WhatsApp mock: `assets/img/logo.png` (192 px, transparent), `logo-512.png`, `favicon.png` (64 px) and `apple-touch-icon.png` (180 px). The favicon and Apple touch icon are linked in the shared header. Removed the line "Available in English, हिन्दी and മലയാളം. More languages coming soon." from the home hero. Navigation order: Home, About Us, Explore Trials, What is a Clinical Trial, Contact Us. |
| 1.9 | 18 Nov 2026 | Full legal set drafted for Indian law: Privacy Policy and Consent Notice (v1.1, DPDP Act 2023 / Rules 2025), Terms of Use (IT Act and IT Rules 2021), new Terms for Doctors (NDCT Rules 2019, Ethics Committee, CTRI, ICMR 2017, Drugs and Magic Remedies Act 1954), Medical Disclaimer, new Listing Policy, new Cookie Policy and new Grievance Redressal page. Shared legal hero with effective date, version, review note and links between documents; tokens filled from `config('legal')`; footer *Legal* column; registration and contact forms link the relevant documents. Explore sort *Distance (nearest)* replaced with *City (A–Z)*; all location code removed, `Permissions-Policy` blocks geolocation again, and city coordinates are removed from content and schema. New shared State → City component on the home search, Explore filters, and patient and doctor registration, ready to switch to AJAX. *Hospitals and partners* removed from About for now. Dr Krupa Sankar removed from Medical advisors. |
| 1.10 | 19 Nov 2026 | Footer fits on one row on desktop: brand block 4 columns, Explore, Register, OncoUday and Legal 2 columns each (offset removed). *Pending legal review* note hidden (`legal.review_pending` = `false`). Team photos added on About Us (`assets/img/team/`, 400×400 face crops) for Dr Subhadarsini Mohapatra, Dr Boben Thomas and the four contributors. Contact details set: general contact info@oncouday.com and +91 80505 19549 (also the default WhatsApp chat number); Grievance Officer Dr Uddiptya Goswami, grievance@oncouday.com, +91 87777 34849. |
| 1.11 | 19 Nov 2026 | Contact page *Reach us directly*: office address and WhatsApp number removed (`contact.address` dropped from config); working hours set to 9 am to 5 pm, Monday to Saturday. |
| 1.12 | 19 Nov 2026 | About Us team photos enlarged: full-width 4:5 head-and-shoulders portraits (480×600) instead of 84 px face circles, same card size in every group. WhatsApp buttons made icon-only: the floating button is a round green icon, and the footer *WhatsApp us* button became a green icon at the start of the social icons. |
| 1.13 | 19 Nov 2026 | Patient Registration: *Patient's age* moved from the top of the form to sit after *Cancer type* (same row on desktop); the under-18 guardian notice and guardian-name field follow directly below. |
| 1.14 | 19 Nov 2026 | Home hero sun (`includes/illustrations/sunrise.php`): OncoUday logo added at the centre on a white disc, with orange tapered rays shining out behind it (slow reverse spin and pulse). Logo hidden and rays softened below 992 px. |
| 1.15 | 19 Nov 2026 | Top bar text: the "·" separator replaced with a full stop: "Data refreshed daily. Real-time updates directly from researchers and trial teams." (phones: "Data refreshed daily. Real-time trial updates."). |
| 1.16 | 19 Nov 2026 | Home hero: the "Data refreshed daily" note removed (it stays in the top bar only). About Us: new *Why OncoUday?* story section with the "dawn of oncology" quote, new *What OncoUday aims to offer* section (six cards) and a disclaimer box, from the client's text. Mission, vision and all other About sections unchanged. |
| 1.16 | 19 Nov 2026 | Home hero sun reworked: the extra orange beams, white disc and glow from 1.14 removed. The original sun (ray ring, halo, core) is kept and the OncoUday logo simply sits in its core. Logo still hidden below 992 px. |
| 1.17 | 19 Nov 2026 | About Us contributors reordered: Dipanjan Narayan Chaudhary, Uddipan Goswami, Sayantika Sengupta, Mohammed Hashim. |
| 1.18 | 19 Nov 2026 | Home hero sun: soft light rays added radiating from behind the logo to the halo (24 thin tapered rays, fading orange, gentle 5 s pulse), keeping the existing sun design. Hidden below 992 px with the logo. |
| 1.19 | 19 Nov 2026 | About Us: photo added for Dr Uddiptya Goswami (Founder), `assets/img/team/uddiptya.jpg`. All seven team members now have photos. |
| 1.20 | 19 Nov 2026 | All "not finalised" content removed: the *[Final wording to be provided…]* line in all three consent-notice tabs; *(Design preview…)* notes in the patient, doctor and contact success messages; the FAQ *Is there a fee for doctors?* (answer was "to be confirmed"); the Advocacy Centre guide cards (no content yet; intro and volunteer text adjusted); the *Pending legal review* note code and `legal.review_pending`. Legal pages no longer use the entity, address, jurisdiction or hosting placeholders (operator named as OncoUday, courts in India, postal lines removed). Home chat mocks use example names (Anita, Dr. Rao) instead of [Name] placeholders. |
| 1.21 | 19 Nov 2026 | Explore Trials additions: search bar above the results (keyword moved out of the filter panel), removable active-filter pills with *Clear all*, "N trials found · showing X to Y", results per page (10 / 20 / 50), numbered result cards, registry IDs linked to ClinicalTrials.gov (NCT) or CTRI, and a *Get WhatsApp alerts for new trials* box in the filter panel. Status filters (Recruiting, Not yet recruiting) unchanged. |
| 1.22 | 19 Nov 2026 | About Us contributor roles: Dipanjan Narayan Chaudhary, Senior Data & AI Engineer; Uddipan Goswami, Data Engineer; Sayantika Sengupta, Data & AI Engineer; Mohammed Hashim, Freelancer (replacing "Contributor"). |
| 1.23 | 19 Nov 2026 | Explore Trials: the recruitment start month picker moved from the filter panel into the search bar (beside the keyword box; applies on pick). FAQ *The trial I like is not yet recruiting. What should I do next?* now says we notify you on WhatsApp when the trial reaches its start date and begins recruiting. |
| 1.24 | 19 Nov 2026 | Explore Trials: recruitment start month moved back into the filter panel (below City) so the search bar stays full width. |
