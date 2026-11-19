<?php
declare(strict_types=1);
require __DIR__ . '/app/bootstrap.php';

$page = [
    'title'       => 'Patient Registration',
    'active'      => 'patient',
    'description' => 'Register for free WhatsApp alerts when a cancer clinical trial matching your city and cancer type opens in India.',
];
$noticeVersion = config('app.notice_version');
$grievance     = config('contact.grievance');

require __DIR__ . '/includes/header.php';
?>

<section class="reg-section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5">
                <h1 class="page-title" data-aos="fade-up">Get WhatsApp alerts for matching trials</h1>
                <p class="lead-ou" data-aos="fade-up" data-aos-delay="100">Tell us your city and cancer type. When a trial that matches opens or changes, we'll send you a WhatsApp message. It's free.</p>

                <?php
                $assurances = [
                    ['bi-lock', 'Private and secure.', 'Your details are encrypted and never shown on the website.'],
                    ['bi-chat', 'Discreet messages.', 'Alerts never mention your diagnosis in the text.'],
                    ['bi-x-lg', 'Stop any time.', 'Reply STOP on WhatsApp, or ask us to delete your data.'],
                ];
                foreach ($assurances as $i => [$icon, $t, $d]): ?>
                    <div class="assure" data-aos="fade-up" data-aos-delay="<?= 150 + $i * 80 ?>">
                        <i class="bi <?= e($icon) ?>" aria-hidden="true"></i>
                        <p class="mb-0"><strong><?= e($t) ?></strong> <?= e($d) ?></p>
                    </div>
                <?php endforeach; ?>

                <div class="match-card" data-aos="zoom-in" data-aos-delay="200">
                    <?php illustration('match'); ?>
                    <p class="small mb-0">Every new trial is checked against your city and cancer type — the moment it matches, you get a WhatsApp alert.</p>
                </div>
                <div class="wa-cta wa-cta--compact mt-3" data-aos="fade-up" data-aos-delay="250">
                    <i class="bi bi-whatsapp wa-cta__icon" aria-hidden="true"></i>
                    <div>
                        <strong>Find the form difficult?</strong>
                        <p class="mb-2">Send us “Hi” on WhatsApp and register in the chat instead.</p>
                        <a class="btn btn-whatsapp btn-sm" href="<?= e(whatsapp_chat_url()) ?>" target="_blank" rel="noopener"><i class="bi bi-whatsapp me-1" aria-hidden="true"></i> WhatsApp us</a>
                    </div>
                </div>
                <p class="small text-muted-ou mt-3">Registering does not enrol you in a trial. Always talk to your doctor before deciding.</p>
            </div>

            <div class="col-lg-7">
                <form class="form-card needs-validation js-demo-form" action="<?= e(url('patient-registration.php')) ?>" method="post" novalidate
                      data-success-title="You're registered"
                      data-success-text="We'll send a welcome message to your WhatsApp number and alert you when a matching trial opens. (Design preview: alerts are connected in the next stage.)"
                      data-aos="fade-left" data-aos-delay="100">
                    <?= csrf_field() ?>
                    <input type="hidden" name="notice_version" value="<?= e($noticeVersion) ?>">
                    <h2 class="form-card__title">Patient registration</h2>

                    <div class="mb-3">
                        <label class="form-label" for="pName"><span class="js-name-label">Full name</span></label>
                        <input class="form-control" id="pName" name="full_name" type="text" maxlength="120" autocomplete="name" required>
                        <div class="invalid-feedback">Please enter the name.</div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label" for="pEmail">Email</label>
                            <input class="form-control" id="pEmail" name="email" type="email" maxlength="160" autocomplete="email" required>
                            <div class="invalid-feedback">Please enter a valid email address.</div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="pPhone">WhatsApp number</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text">+91</span>
                                <input class="form-control js-phone" id="pPhone" name="whatsapp" type="tel" inputmode="numeric" maxlength="10" pattern="[6-9][0-9]{9}" autocomplete="tel-national" required>
                                <div class="invalid-feedback">Enter a valid 10-digit mobile number.</div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mb-1">
                        <?php partial('state-city', ['mode' => 'form', 'prefix' => 'p', 'wrap' => 'col-sm-6']); ?>
                        <div class="col-sm-6">
                            <label class="form-label" for="pCancer">Cancer type</label>
                            <select class="form-select" id="pCancer" name="cancer_type" required>
                                <option value="">Select cancer type</option>
                                <?php foreach (content()->cancerTypes() as $c): ?>
                                    <option value="<?= e($c['slug']) ?>"><?= e($c['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Please select a cancer type.</div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="pAge">Patient's age</label>
                            <div class="input-group has-validation">
                                <input class="form-control js-age" id="pAge" name="age" type="number" inputmode="numeric" min="0" max="120" step="1" required>
                                <span class="input-group-text">years</span>
                                <div class="invalid-feedback">Please enter the patient's age (0 to 120).</div>
                            </div>
                        </div>
                    </div>
                    <p class="form-text mb-3">State and city only — we never ask for your address.</p>

                    <div class="alert-guardian js-guardian" hidden>
                        <i class="bi bi-info-circle" aria-hidden="true"></i>
                        <span>For patients under 18, a parent or legal guardian must register and give consent on their behalf.</span>
                    </div>
                    <div class="mb-3 js-guardian" hidden>
                        <label class="form-label" for="pGuardian">Parent or guardian's full name</label>
                        <input class="form-control" id="pGuardian" name="guardian_name" type="text" maxlength="120" autocomplete="name">
                        <div class="invalid-feedback">Please enter the parent or guardian's name.</div>
                    </div>

                    <div class="consent-notice">
                        <div class="consent-notice__head">
                            <strong>Consent notice (v<?= e($noticeVersion) ?>)</strong>
                            <div class="nav consent-tabs" role="tablist">
                                <button class="nav-link active" type="button" data-bs-toggle="tab" data-bs-target="#notice-en" role="tab" aria-controls="notice-en" aria-selected="true">English</button>
                                <button class="nav-link" type="button" data-bs-toggle="tab" data-bs-target="#notice-hi" role="tab" aria-controls="notice-hi" aria-selected="false" lang="hi">हिन्दी</button>
                                <button class="nav-link" type="button" data-bs-toggle="tab" data-bs-target="#notice-ml" role="tab" aria-controls="notice-ml" aria-selected="false" lang="ml">മലയാളം</button>
                            </div>
                        </div>
                        <div class="tab-content consent-notice__body" tabindex="0">
                            <div class="tab-pane fade show active" id="notice-en" role="tabpanel">
                                <p>OncoUday (the Data Fiduciary) collects your name, age, email, WhatsApp number, city and cancer type.</p>
                                <p>We use them only to tell you about clinical trials that match your city and cancer type.</p>
                                <p>Your details are stored securely and are never shown on the website or sold.</p>
                                <p>You can withdraw consent, stop alerts (reply STOP) or ask us to delete your data at any time.</p>
                                <p>Grievance Officer: <?= e($grievance['name']) ?> · <?= e($grievance['email']) ?> · <?= e($grievance['phone']) ?></p>
                                <p class="text-muted-ou">[Final wording to be provided by OncoUday's legal advisor]</p>
                            </div>
                            <div class="tab-pane fade" id="notice-hi" role="tabpanel" lang="hi">
                                <p>OncoUday (डेटा फ़िड्यूशियरी) आपका नाम, आयु, ईमेल, व्हाट्सऐप नंबर, शहर और कैंसर का प्रकार एकत्र करता है।</p>
                                <p>हम इनका उपयोग केवल आपको उन क्लिनिकल ट्रायल के बारे में बताने के लिए करते हैं जो आपके शहर और कैंसर के प्रकार से मेल खाते हैं।</p>
                                <p>आपकी जानकारी सुरक्षित रूप से रखी जाती है और कभी भी वेबसाइट पर नहीं दिखाई जाती या बेची नहीं जाती।</p>
                                <p>आप किसी भी समय सहमति वापस ले सकते हैं, अलर्ट बंद कर सकते हैं (STOP लिखकर भेजें) या अपना डेटा हटाने का अनुरोध कर सकते हैं।</p>
                                <p>शिकायत अधिकारी: <?= e($grievance['name']) ?> · <?= e($grievance['email']) ?> · <?= e($grievance['phone']) ?></p>
                                <p class="text-muted-ou">[अंतिम शब्दावली OncoUday के कानूनी सलाहकार द्वारा दी जाएगी]</p>
                            </div>
                            <div class="tab-pane fade" id="notice-ml" role="tabpanel" lang="ml">
                                <p>OncoUday (ഡാറ്റ ഫിഡ്യൂഷ്യറി) നിങ്ങളുടെ പേര്, പ്രായം, ഇമെയിൽ, വാട്ട്സ്ആപ്പ് നമ്പർ, നഗരം, കാൻസർ തരം എന്നിവ ശേഖരിക്കുന്നു.</p>
                                <p>നിങ്ങളുടെ നഗരത്തിനും കാൻസർ തരത്തിനും യോജിക്കുന്ന ക്ലിനിക്കൽ ട്രയലുകളെക്കുറിച്ച് അറിയിക്കാൻ മാത്രമാണ് ഞങ്ങൾ ഇവ ഉപയോഗിക്കുന്നത്.</p>
                                <p>നിങ്ങളുടെ വിവരങ്ങൾ സുരക്ഷിതമായി സൂക്ഷിക്കുന്നു; അവ ഒരിക്കലും വെബ്സൈറ്റിൽ കാണിക്കുകയോ വിൽക്കുകയോ ചെയ്യില്ല.</p>
                                <p>എപ്പോൾ വേണമെങ്കിലും സമ്മതം പിൻവലിക്കാനും അലേർട്ടുകൾ നിർത്താനും (STOP എന്ന് മറുപടി നൽകുക) ഡാറ്റ നീക്കം ചെയ്യാൻ ആവശ്യപ്പെടാനും നിങ്ങൾക്ക് കഴിയും.</p>
                                <p>പരാതി പരിഹാര ഓഫീസർ: <?= e($grievance['name']) ?> · <?= e($grievance['email']) ?> · <?= e($grievance['phone']) ?></p>
                                <p class="text-muted-ou">[അന്തിമ വാചകം OncoUday-യുടെ നിയമ ഉപദേഷ്ടാവ് നൽകും]</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" id="pConsent" name="consent_platform" value="1" required>
                        <label class="form-check-label" for="pConsent">I have read the <a href="<?= e(url('consent-notice.php')) ?>#patients" target="_blank" rel="noopener">Consent Notice</a> and agree that OncoUday may store and use these details to match me with clinical trials, as set out in the <a href="<?= e(url('privacy-policy.php')) ?>" target="_blank" rel="noopener">Privacy Policy</a>.</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="pWa" name="consent_whatsapp" value="1" required>
                        <label class="form-check-label" for="pWa">I agree to receive trial alerts on WhatsApp. I can reply STOP at any time.</label>
                    </div>
                    <p class="form-text mb-4">By registering you also accept the <a href="<?= e(url('terms-of-use.php')) ?>" target="_blank" rel="noopener">Terms of Use</a> and the <a href="<?= e(url('medical-disclaimer.php')) ?>" target="_blank" rel="noopener">Medical Disclaimer</a>. Registering does not enrol you in a trial.</p>

                    <button class="btn btn-magenta w-100 btn-submit" type="submit">Register for trial alerts</button>
                    <p class="text-center small mt-3 mb-0">Are you a doctor? <a href="<?= e(url('doctor-registration.php')) ?>">Register here</a></p>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
