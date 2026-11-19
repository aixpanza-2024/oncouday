-- =====================================================================
-- OncoUday — MySQL database schema (MySQL 8.0+ / MariaDB 10.6+)
-- Engine: InnoDB · Charset: utf8mb4 (full Unicode: Hindi, Malayalam)
--
-- Performance notes
--  * Every foreign key column is indexed.
--  * Composite indexes are ordered to match the WHERE / ORDER BY of the
--    main queries (trial listing, patient matching, alert queue).
--  * FULLTEXT index on trials(title, medicines_text) for medicine search.
--  * Personal contact data is stored encrypted (VARBINARY) with a separate
--    HMAC hash column for fast, indexed, exact-match lookups.
-- =====================================================================

CREATE DATABASE IF NOT EXISTS oncouday
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE oncouday;

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- Lookup tables
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS languages (
  code        VARCHAR(5)   NOT NULL,
  name        VARCHAR(40)  NOT NULL,
  native_name VARCHAR(40)  NOT NULL,
  is_active   TINYINT(1)   NOT NULL DEFAULT 1,
  sort_order  SMALLINT     NOT NULL DEFAULT 0,
  PRIMARY KEY (code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS cities (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name        VARCHAR(80)  NOT NULL,
  slug        VARCHAR(80)  NOT NULL,
  state       VARCHAR(80)  NULL,
  is_active   TINYINT(1)   NOT NULL DEFAULT 1,
  PRIMARY KEY (id),
  UNIQUE KEY uq_cities_slug (slug),
  KEY idx_cities_active_name (is_active, name),
  KEY idx_cities_state (state)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS cancer_types (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name        VARCHAR(80)  NOT NULL,
  slug        VARCHAR(80)  NOT NULL,
  chip_label  VARCHAR(40)  NOT NULL,
  is_featured TINYINT(1)   NOT NULL DEFAULT 0,
  is_active   TINYINT(1)   NOT NULL DEFAULT 1,
  sort_order  SMALLINT     NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  UNIQUE KEY uq_cancer_types_slug (slug),
  KEY idx_cancer_types_active_sort (is_active, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS specialties (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name        VARCHAR(80)  NOT NULL,
  slug        VARCHAR(80)  NOT NULL,
  is_active   TINYINT(1)   NOT NULL DEFAULT 1,
  sort_order  SMALLINT     NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  UNIQUE KEY uq_specialties_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS hospitals (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name        VARCHAR(160) NOT NULL,
  city_id     INT UNSIGNED NOT NULL,
  is_verified TINYINT(1)   NOT NULL DEFAULT 0,
  created_at  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_hospitals_name_city (name, city_id),
  KEY idx_hospitals_city (city_id),
  CONSTRAINT fk_hospitals_city FOREIGN KEY (city_id) REFERENCES cities (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS medicines (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name        VARCHAR(120) NOT NULL,
  slug        VARCHAR(120) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_medicines_slug (slug),
  KEY idx_medicines_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- People
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS doctors (
  id               INT UNSIGNED NOT NULL AUTO_INCREMENT,
  full_name        VARCHAR(120)    NOT NULL,
  email_enc        VARBINARY(512)  NOT NULL,
  email_hash       CHAR(64)        NOT NULL,
  whatsapp_enc     VARBINARY(255)  NOT NULL,
  whatsapp_hash    CHAR(64)        NOT NULL,
  hospital_name    VARCHAR(160)    NOT NULL,
  hospital_id      INT UNSIGNED    NULL,
  city_id          INT UNSIGNED    NOT NULL,
  specialty_id     INT UNSIGNED    NOT NULL,
  usage_mode       ENUM('running','following') NOT NULL,
  status           ENUM('pending','active','suspended','deleted') NOT NULL DEFAULT 'pending',
  is_verified      TINYINT(1)      NOT NULL DEFAULT 0,
  verified_at      DATETIME        NULL,
  preferred_lang   VARCHAR(5)      NOT NULL DEFAULT 'en',
  created_at       DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at       DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_doctors_whatsapp (whatsapp_hash),
  UNIQUE KEY uq_doctors_email (email_hash),
  KEY idx_doctors_mode_status (usage_mode, status),
  KEY idx_doctors_alerts (status, usage_mode, city_id, specialty_id),
  KEY idx_doctors_hospital (hospital_id),
  KEY idx_doctors_city (city_id),
  KEY idx_doctors_specialty (specialty_id),
  CONSTRAINT fk_doctors_hospital  FOREIGN KEY (hospital_id)  REFERENCES hospitals (id) ON DELETE SET NULL,
  CONSTRAINT fk_doctors_city      FOREIGN KEY (city_id)      REFERENCES cities (id),
  CONSTRAINT fk_doctors_specialty FOREIGN KEY (specialty_id) REFERENCES specialties (id),
  CONSTRAINT fk_doctors_lang      FOREIGN KEY (preferred_lang) REFERENCES languages (code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Cancer types a "following" doctor wants alerts for (none = all types).
CREATE TABLE IF NOT EXISTS doctor_alert_cancer_types (
  doctor_id       INT UNSIGNED NOT NULL,
  cancer_type_id  INT UNSIGNED NOT NULL,
  PRIMARY KEY (doctor_id, cancer_type_id),
  KEY idx_dact_cancer (cancer_type_id),
  CONSTRAINT fk_dact_doctor FOREIGN KEY (doctor_id)      REFERENCES doctors (id) ON DELETE CASCADE,
  CONSTRAINT fk_dact_cancer FOREIGN KEY (cancer_type_id) REFERENCES cancer_types (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS patients (
  id                INT UNSIGNED NOT NULL AUTO_INCREMENT,
  full_name_enc     VARBINARY(512) NOT NULL,
  guardian_name_enc VARBINARY(512) NULL,
  email_enc         VARBINARY(512) NOT NULL,
  email_hash        CHAR(64)       NOT NULL,
  whatsapp_enc      VARBINARY(255) NOT NULL,
  whatsapp_hash     CHAR(64)       NOT NULL,
  city_id           INT UNSIGNED   NOT NULL,
  cancer_type_id    INT UNSIGNED   NOT NULL,
  age               TINYINT UNSIGNED NULL,
  is_adult          TINYINT(1)     NOT NULL DEFAULT 1,
  preferred_lang    VARCHAR(5)     NOT NULL DEFAULT 'en',
  status            ENUM('pending','active','stopped','deleted') NOT NULL DEFAULT 'pending',
  verified_at       DATETIME       NULL,
  stopped_at        DATETIME       NULL,
  created_at        DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at        DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_patients_whatsapp_cancer (whatsapp_hash, cancer_type_id),
  KEY idx_patients_match (status, cancer_type_id, city_id),   -- trial -> patient matching
  KEY idx_patients_email (email_hash),
  KEY idx_patients_city (city_id),
  KEY idx_patients_cancer (cancer_type_id),
  CONSTRAINT fk_patients_city   FOREIGN KEY (city_id)        REFERENCES cities (id),
  CONSTRAINT fk_patients_cancer FOREIGN KEY (cancer_type_id) REFERENCES cancer_types (id),
  CONSTRAINT fk_patients_lang   FOREIGN KEY (preferred_lang) REFERENCES languages (code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- DPDP Act consent records: one row per consent given or withdrawn.
CREATE TABLE IF NOT EXISTS consents (
  id              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  subject_type    ENUM('patient','doctor') NOT NULL,
  subject_id      INT UNSIGNED    NOT NULL,
  consent_type    ENUM('platform','whatsapp','terms') NOT NULL,
  notice_version  VARCHAR(10)     NOT NULL,
  lang            VARCHAR(5)      NOT NULL DEFAULT 'en',
  granted         TINYINT(1)      NOT NULL,
  ip_hash         CHAR(64)        NULL,
  user_agent      VARCHAR(255)    NULL,
  created_at      DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  withdrawn_at    DATETIME        NULL,
  PRIMARY KEY (id),
  KEY idx_consents_subject (subject_type, subject_id, consent_type, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Trials
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS trials (
  id                      INT UNSIGNED NOT NULL AUTO_INCREMENT,
  public_id               VARCHAR(16)  NOT NULL,               -- used in oncouday.in/t/{public_id}
  registry_id             VARCHAR(40)  NOT NULL,               -- display ID (NCT or CTRI)
  nct_id                  VARCHAR(20)  NULL,
  ctri_id                 VARCHAR(40)  NULL,
  title                   VARCHAR(300) NOT NULL,
  summary                 TEXT         NULL,
  cancer_type_id          INT UNSIGNED NOT NULL,
  phase                   ENUM('I','II','III','IV') NOT NULL,
  status                  ENUM('recruiting','not_yet_recruiting','active_not_recruiting','completed','closed','withdrawn') NOT NULL,
  source                  ENUM('doctor','ctgov') NOT NULL,
  added_by_doctor_id      INT UNSIGNED NULL,
  hospital_id             INT UNSIGNED NULL,
  city_id                 INT UNSIGNED NOT NULL,
  medicines_text          VARCHAR(500) NOT NULL DEFAULT '',    -- denormalised for display + FULLTEXT search
  enrolment_contact_name  VARCHAR(120) NULL,
  enrolment_contact_email VARCHAR(160) NULL,
  enrolment_contact_phone VARCHAR(30)  NULL,
  start_date              DATE         NULL,                   -- recruitment start, used by the month filter
  is_published            TINYINT(1)   NOT NULL DEFAULT 1,
  last_confirmed_at       DATETIME     NULL,                   -- weekly WhatsApp check
  ctgov_synced_at         DATETIME     NULL,                   -- nightly import
  created_at              DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at              DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_trials_public (public_id),
  UNIQUE KEY uq_trials_nct (nct_id),
  UNIQUE KEY uq_trials_ctri (ctri_id),
  KEY idx_trials_listing (is_published, status, updated_at),            -- default listing / recent trials
  KEY idx_trials_cancer_city (is_published, cancer_type_id, city_id, status),
  KEY idx_trials_city (city_id, status),
  KEY idx_trials_phase (phase),
  KEY idx_trials_start (start_date),
  KEY idx_trials_source (source),
  KEY idx_trials_registry (registry_id),
  KEY idx_trials_doctor (added_by_doctor_id),
  KEY idx_trials_hospital (hospital_id),
  KEY idx_trials_confirm (source, status, last_confirmed_at),           -- weekly check queue
  FULLTEXT KEY ft_trials_search (title, medicines_text),
  CONSTRAINT fk_trials_cancer   FOREIGN KEY (cancer_type_id)     REFERENCES cancer_types (id),
  CONSTRAINT fk_trials_city     FOREIGN KEY (city_id)            REFERENCES cities (id),
  CONSTRAINT fk_trials_hospital FOREIGN KEY (hospital_id)        REFERENCES hospitals (id) ON DELETE SET NULL,
  CONSTRAINT fk_trials_doctor   FOREIGN KEY (added_by_doctor_id) REFERENCES doctors (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS trial_medicines (
  trial_id     INT UNSIGNED NOT NULL,
  medicine_id  INT UNSIGNED NOT NULL,
  arm_label    VARCHAR(60)  NULL,
  PRIMARY KEY (trial_id, medicine_id),
  KEY idx_tm_medicine (medicine_id),
  CONSTRAINT fk_tm_trial    FOREIGN KEY (trial_id)    REFERENCES trials (id) ON DELETE CASCADE,
  CONSTRAINT fk_tm_medicine FOREIGN KEY (medicine_id) REFERENCES medicines (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS trial_weekly_checks (
  id            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  trial_id      INT UNSIGNED    NOT NULL,
  doctor_id     INT UNSIGNED    NOT NULL,
  sent_at       DATETIME        NOT NULL,
  responded_at  DATETIME        NULL,
  response      ENUM('no_change','update','closed') NULL,
  PRIMARY KEY (id),
  KEY idx_twc_trial_sent (trial_id, sent_at),
  KEY idx_twc_pending (responded_at, sent_at),
  KEY idx_twc_doctor (doctor_id),
  CONSTRAINT fk_twc_trial  FOREIGN KEY (trial_id)  REFERENCES trials (id) ON DELETE CASCADE,
  CONSTRAINT fk_twc_doctor FOREIGN KEY (doctor_id) REFERENCES doctors (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS ctgov_import_runs (
  id            INT UNSIGNED NOT NULL AUTO_INCREMENT,
  started_at    DATETIME     NOT NULL,
  finished_at   DATETIME     NULL,
  status        ENUM('running','success','failed') NOT NULL DEFAULT 'running',
  added_count   INT UNSIGNED NOT NULL DEFAULT 0,
  updated_count INT UNSIGNED NOT NULL DEFAULT 0,
  closed_count  INT UNSIGNED NOT NULL DEFAULT 0,
  error_message VARCHAR(500) NULL,
  PRIMARY KEY (id),
  KEY idx_ctgov_started (started_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- WhatsApp alerts (queue + delivery log)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS alerts (
  id              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  recipient_type  ENUM('patient','doctor') NOT NULL,
  recipient_id    INT UNSIGNED    NOT NULL,
  trial_id        INT UNSIGNED    NULL,
  template        VARCHAR(60)     NOT NULL,
  lang            VARCHAR(5)      NOT NULL DEFAULT 'en',
  status          ENUM('queued','sent','delivered','read','failed') NOT NULL DEFAULT 'queued',
  wa_message_id   VARCHAR(100)    NULL,
  attempts        TINYINT UNSIGNED NOT NULL DEFAULT 0,
  error_code      VARCHAR(40)     NULL,
  created_at      DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  sent_at         DATETIME        NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_alerts_dedupe (recipient_type, recipient_id, trial_id, template),  -- never alert twice
  KEY idx_alerts_queue (status, created_at),
  KEY idx_alerts_trial (trial_id),
  KEY idx_alerts_wa (wa_message_id),
  CONSTRAINT fk_alerts_trial FOREIGN KEY (trial_id) REFERENCES trials (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Website content (managed from the admin panel)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS faq_categories (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  slug        VARCHAR(40)  NOT NULL,
  name        VARCHAR(80)  NOT NULL,
  sort_order  SMALLINT     NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  UNIQUE KEY uq_faq_cat_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS faqs (
  id            INT UNSIGNED NOT NULL AUTO_INCREMENT,
  category_id   INT UNSIGNED NOT NULL,
  lang          VARCHAR(5)   NOT NULL DEFAULT 'en',
  question      VARCHAR(300) NOT NULL,
  answer        TEXT         NOT NULL,
  is_published  TINYINT(1)   NOT NULL DEFAULT 1,
  show_on_home  TINYINT(1)   NOT NULL DEFAULT 0,
  sort_order    SMALLINT     NOT NULL DEFAULT 0,
  updated_at    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_faqs_list (category_id, lang, is_published, sort_order),
  KEY idx_faqs_home (show_on_home, lang, is_published),
  CONSTRAINT fk_faqs_category FOREIGN KEY (category_id) REFERENCES faq_categories (id) ON DELETE CASCADE,
  CONSTRAINT fk_faqs_lang     FOREIGN KEY (lang)        REFERENCES languages (code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS guides (
  id            INT UNSIGNED NOT NULL AUTO_INCREMENT,
  slug          VARCHAR(120) NOT NULL,
  lang          VARCHAR(5)   NOT NULL DEFAULT 'en',
  tag           VARCHAR(40)  NOT NULL,
  title         VARCHAR(200) NOT NULL,
  summary       VARCHAR(400) NOT NULL,
  body          MEDIUMTEXT   NULL,
  image_path    VARCHAR(255) NULL,
  is_published  TINYINT(1)   NOT NULL DEFAULT 0,
  sort_order    SMALLINT     NOT NULL DEFAULT 0,
  published_at  DATETIME     NULL,
  updated_at    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_guides_slug_lang (slug, lang),
  KEY idx_guides_list (lang, is_published, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS team_members (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name        VARCHAR(120) NOT NULL,
  role        VARCHAR(160) NOT NULL,
  photo_path  VARCHAR(255) NULL,
  is_active   TINYINT(1)   NOT NULL DEFAULT 1,
  sort_order  SMALLINT     NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  KEY idx_team_active_sort (is_active, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS partners (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name        VARCHAR(160) NOT NULL,
  logo_path   VARCHAR(255) NULL,
  website_url VARCHAR(255) NULL,
  is_active   TINYINT(1)   NOT NULL DEFAULT 1,
  sort_order  SMALLINT     NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  KEY idx_partners_active_sort (is_active, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS contact_messages (
  id          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  name        VARCHAR(120)  NOT NULL,
  email       VARCHAR(160)  NOT NULL,
  phone       VARCHAR(15)   NULL,
  role        ENUM('patient','caregiver','doctor','hospital','volunteer','other') NOT NULL,
  message     TEXT          NOT NULL,
  is_grievance TINYINT(1)   NOT NULL DEFAULT 0,
  status      ENUM('new','in_progress','closed','spam') NOT NULL DEFAULT 'new',
  ip_hash     CHAR(64)      NULL,
  created_at  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  resolved_at DATETIME      NULL,
  PRIMARY KEY (id),
  KEY idx_contact_status (status, created_at),
  KEY idx_contact_grievance (is_grievance, status),
  KEY idx_contact_ip_time (ip_hash, created_at)          -- rate limiting
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------
-- Admin panel & security
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS admin_users (
  id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name            VARCHAR(120) NOT NULL,
  email           VARCHAR(160) NOT NULL,
  password_hash   VARCHAR(255) NOT NULL,                 -- password_hash() / Argon2id
  role            ENUM('super_admin','editor','support','viewer') NOT NULL DEFAULT 'viewer',
  mfa_secret_enc  VARBINARY(255) NULL,
  is_active       TINYINT(1)   NOT NULL DEFAULT 1,
  failed_logins   TINYINT UNSIGNED NOT NULL DEFAULT 0,
  locked_until    DATETIME     NULL,
  last_login_at   DATETIME     NULL,
  created_at      DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_admin_email (email),
  KEY idx_admin_active_role (is_active, role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS audit_logs (
  id          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  actor_type  ENUM('admin','doctor','patient','system') NOT NULL,
  actor_id    INT UNSIGNED  NULL,
  action      VARCHAR(60)   NOT NULL,
  entity      VARCHAR(40)   NOT NULL,
  entity_id   BIGINT UNSIGNED NULL,
  ip_hash     CHAR(64)      NULL,
  details     JSON          NULL,
  created_at  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_audit_entity (entity, entity_id),
  KEY idx_audit_actor (actor_type, actor_id, created_at),
  KEY idx_audit_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- =====================================================================
-- Seed data (lookups)
-- =====================================================================
INSERT IGNORE INTO languages (code, name, native_name, sort_order) VALUES
  ('en', 'English', 'English', 1), ('hi', 'Hindi', 'हिन्दी', 2), ('ml', 'Malayalam', 'മലയാളം', 3);

INSERT IGNORE INTO cancer_types (name, slug, chip_label, is_featured, sort_order) VALUES
  ('Breast cancer', 'breast', 'Breast', 1, 1),
  ('Lung cancer', 'lung', 'Lung', 1, 2),
  ('Head and neck cancer', 'head-and-neck', 'Head and neck', 1, 3),
  ('Cervical cancer', 'cervical', 'Cervical', 1, 4),
  ('Blood cancers', 'blood', 'Blood cancers', 1, 5),
  ('Colorectal cancer', 'colorectal', 'Colorectal', 0, 6),
  ('Ovarian cancer', 'ovarian', 'Ovarian', 0, 7),
  ('Prostate cancer', 'prostate', 'Prostate', 0, 8),
  ('Stomach cancer', 'stomach', 'Stomach', 0, 9),
  ('Liver cancer', 'liver', 'Liver', 0, 10),
  ('Brain tumours', 'brain', 'Brain', 0, 11),
  ('Childhood cancers', 'childhood', 'Childhood', 0, 12),
  ('Other cancers', 'other', 'Other', 0, 13);

INSERT IGNORE INTO cities (name, slug, state) VALUES
  ('Ahmedabad', 'ahmedabad', 'Gujarat'), ('Bengaluru', 'bengaluru', 'Karnataka'),
  ('Chandigarh', 'chandigarh', 'Chandigarh'), ('Chennai', 'chennai', 'Tamil Nadu'),
  ('Hyderabad', 'hyderabad', 'Telangana'), ('Jaipur', 'jaipur', 'Rajasthan'),
  ('Kochi', 'kochi', 'Kerala'), ('Kolkata', 'kolkata', 'West Bengal'),
  ('Kozhikode', 'kozhikode', 'Kerala'), ('Lucknow', 'lucknow', 'Uttar Pradesh'),
  ('Mumbai', 'mumbai', 'Maharashtra'), ('New Delhi', 'new-delhi', 'Delhi'),
  ('Pune', 'pune', 'Maharashtra'), ('Thiruvananthapuram', 'thiruvananthapuram', 'Kerala'),
  ('Vellore', 'vellore', 'Tamil Nadu');

INSERT IGNORE INTO specialties (name, slug, sort_order) VALUES
  ('Medical oncology', 'medical-oncology', 1), ('Radiation oncology', 'radiation-oncology', 2),
  ('Surgical oncology', 'surgical-oncology', 3), ('Haemato-oncology', 'haemato-oncology', 4),
  ('Paediatric oncology', 'paediatric-oncology', 5), ('Gynaecologic oncology', 'gynaec-oncology', 6),
  ('Head and neck oncology', 'head-neck-oncology', 7), ('Pathology', 'pathology', 8),
  ('General medicine', 'general-medicine', 9), ('Other specialty', 'other', 10);

INSERT IGNORE INTO faq_categories (slug, name, sort_order) VALUES
  ('patients', 'Patients & caregivers', 1), ('doctors', 'Doctors', 2),
  ('privacy', 'Privacy', 3), ('listings', 'About the listings', 4);
