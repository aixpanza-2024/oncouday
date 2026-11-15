# OncoUday — Software Requirements Specification (SRS)

| | |
|---|---|
| **Product** | OncoUday — India's Gateway to Cancer Clinical Trials and Patient Support |
| **Prepared by** | AIXPANZA Private Limited |
| **Prepared for** | OncoUday |
| **Document version** | 1.0 |
| **Date** | 10 November 2026 |
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
* Text in `[brackets]` is placeholder content to be supplied by OncoUday.

### 2.4 Assumptions
* OncoUday supplies final copy, legal wording (privacy, terms, disclaimer, consent notice), team photos, partner logos and guide content.
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
├── assets/img/logo.svg           Logo and favicon
├── database/schema.sql           Full MySQL schema, indexes and seed data
└── docs/SRS.md                   This document
```

### 3.3 Shared layout and reuse
* `includes/header.php` renders `<head>`, top bar, language switcher and main navigation. The active nav item comes from `$page['active']`.
* `includes/footer.php` renders the optional disclaimer strip, the footer, shared modals and the scripts.
* The navigation and footer links come from one source (`app/data/content.php` → `navigation`, `footerColumns`).
* Reusable components are rendered with `partial('name', [...])` and illustrations with `illustration('name')`. Both functions isolate variables and apply `basename()` to the name, which blocks path traversal.
* Assets are linked through `asset()`, which appends a file-modification version for cache-busting.

---

## 4. Functional Requirements — Pages

Every page has the shared header (top bar, navigation, *I'm a doctor* / *I'm a patient* buttons), the shared footer, scroll-triggered (AOS) animations and its own animated illustration.

### 4.1 Home (`index.php`) — illustration: rising sun with rotating rays
* FR-H1 Hero with headline, intro, *Register as a patient* / *Register as a doctor* buttons and a language note.
* FR-H2 Animated WhatsApp chat mock: messages appear one by one with a typing indicator.
* FR-H3 Quick search (cancer type, city, medicine) that submits to Explore Trials as GET parameters.
* FR-H4 *Explore all open trials* banner.
* FR-H5 *Recently updated trials*: the 3 latest trials from `TrialService::recent()`, each with a *Details* link to the trial card on Explore Trials (highlighted on arrival).
* FR-H6 *Three ways to use OncoUday*: patient, doctor running trials and doctor following trials, each with 3 steps and a CTA. The doctor CTAs preselect the registration mode.
* FR-H7 Navy band for doctors with an animated weekly-check chat.
* FR-H8 Four benefits of trials.
* FR-H9 *Know your rights* band linking to the Advocacy Centre.
* FR-H10 FAQ preview (3 questions) and the medical disclaimer strip.

### 4.2 About Us (`about.php`) — illustration: orbit
* Mission and vision cards, *Who OncoUday serves* (3 cards), *Built for how India communicates* (4 numbered pillars with count-up), team placeholders (3), partner logo placeholders (5) and a join CTA band.

### 4.3 What is a Clinical Trial (`what-is-a-clinical-trial.php`) — illustration: DNA wave of dots
* *On this page* anchor navigation.
* Four phases shown as rising steps, with people icons that grow by phase.
* *How participants are protected* (4), possible benefits vs things to think about, and a *Why doctors join* band.
* Six *Questions to ask your doctor* and the disclaimer strip.

### 4.4 Explore Clinical Trials (`explore-trials.php`) — illustration: radar sweep
* FR-E1 Cancer-type chips (All + 6 featured types), keeping the other filters.
* FR-E2 Filter panel: medicine/keyword, cancer type, city, phase (I–IV), status (Recruiting, Not yet recruiting) and *Listed by* (Doctors on OncoUday, ClinicalTrials.gov). It is a sidebar on desktop and an off-canvas panel on mobile.
* FR-E3 Filters apply automatically on change. Keyword search waits until typing pauses. *Clear filters* resets everything.
* FR-E4 Result count and sorting (recently updated, title, phase).
* FR-E5 Each trial card shows cancer type, status, phase, registry ID, title, medicines, hospital, city and source.
* FR-E6 *View enrolment contact* opens a modal with the trial contact. Values are written with `textContent`.
* FR-E7 Empty state with *Clear filters* and *Get trial alerts*. Pagination at 10 per page.
* FR-E8 Server-side validation: every GET value is checked against a whitelist (cancer and city slugs, phases, statuses, sources, sorts). Free text is trimmed, stripped of control characters and limited to 80 characters.

### 4.5 Doctor Registration (`doctor-registration.php`) — illustration: heartbeat line
* FR-D1 Mode selection: *I run clinical trials* / *I don't run trials — I want to follow them*. It can be preselected with `?mode=running|following` (whitelisted).
* FR-D2 The *After you register* panel, the consent wording and the optional cancer-types multi-select change with the chosen mode.
* FR-D3 Fields: full name, email, WhatsApp number (+91, 10 digits, starting 6–9), hospital or clinic, city, specialty, and the cancer types to get alerts for (following mode only, optional).
* FR-D4 Consents: Terms for Doctors + Privacy Policy, and WhatsApp messages (both required).
* FR-D5 Client-side validation with inline messages, a loading state and a success modal. Phase 2 will add server processing with CSRF verification. The CSRF token is already rendered.

### 4.6 Patient Registration (`patient-registration.php`) — illustration: matching lines
* FR-P1 Age question. *No, under 18* shows the guardian notice and a required guardian-name field.
* FR-P2 Fields: full name, email, WhatsApp number, city and cancer type (city only, never address).
* FR-P3 Consent notice v1.0 with English / हिन्दी / മലയാളം tabs, including the Grievance Officer details.
* FR-P4 Separate consents for platform data use and WhatsApp alerts (both required). The notice version is submitted with the form.
* FR-P5 Assurance cards (private, discreet, stop any time) and a note that registering is not enrolment.

### 4.7 FAQ (`faq.php`) — illustration: floating cells
* Category tabs: Patients & caregivers, Doctors, Privacy, About the listings. The questions are accordions.
* Live search across all categories with an empty-state message.
* *Ask the OncoUday team directly* CTA.

### 4.8 Advocacy Centre (`advocacy-centre.php`) — illustration: turning rings
* Orange hero with 4 pillars (Awareness, Access, Rights, Support).
* Six participant rights, six guide cards (*Read guide* shows a "coming soon" notice until content is supplied), three *Help more patients* cards and a registration CTA.

### 4.9 Contact Us (`contact.php`) — illustration: rings
* Contact form: name, email, phone (optional), *I am a* (patient, caregiver, doctor, hospital/partner, volunteer, other), and message (10–2000 characters with a counter). It includes a honeypot field and a CSRF token.
* *Reach us directly* box, Grievance Officer box (anchor `#grievance`, 90-day resolution) and a medical-emergency note.

### 4.10 Privacy Policy (`privacy-policy.php`) — illustration: shield and check
* 13 numbered sections under the DPDP Act, 2023. A sticky contents list with scroll-spy, a *Draft for layout* notice, and a CTA to the Grievance Officer.

### 4.11 Terms of Use (`terms-of-use.php`) and Medical Disclaimer (`medical-disclaimer.php`)
* Draft legal pages that use the same legal layout, linked from the footer. Final wording to come from OncoUday's legal advisor.

### 4.12 Error page (`404.php`)
* A friendly *page not found* page with links to Home and Explore Trials. It is configured in `.htaccess`.

### 4.13 Language switcher
* English, हिन्दी and മലയാളം buttons in the top bar (and in the mobile menu). The choice is stored in the browser. Translated pages come in Phase 3. Until then a notice explains this.

---

## 5. Data Requirements

### 5.1 Database
`database/schema.sql` creates the `oncouday` database (InnoDB, utf8mb4_unicode_ci) with 23 tables and seed data for languages, cancer types, cities, specialties and FAQ categories.

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
* No horizontal scrolling, touch-friendly targets, and phone fields that open the numeric keyboard.

### 7.2 Animation and interaction
* AOS scroll animations on all sections (fade, zoom and flip, with staggered delays). They run once.
* A CSS-animated illustration on every page (see Section 4).
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
| Contact and grievance details | `app/config/config.php` → `contact` | placeholders |

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
