<?php
declare(strict_types=1);
require __DIR__ . '/app/bootstrap.php';

$page = [
    'title'       => 'Doctor Registration',
    'active'      => 'doctor',
    'description' => 'Register as a doctor on OncoUday to list and manage your cancer trials on WhatsApp, or to get alerts when new trials open in your city and specialty.',
];
$mode = Request::queryEnum('mode', ['running', 'following'], 'running');

require __DIR__ . '/includes/header.php';
?>

<section class="reg-section">
    <?php illustration('heartbeat'); ?>
    <div class="container position-relative">
        <div class="row g-5">
            <div class="col-lg-6">
                <h1 class="page-title" data-aos="fade-up">Join OncoUday as a doctor</h1>
                <p class="lead-ou" data-aos="fade-up" data-aos-delay="100">Whether you run cancer trials or want to find trials for your patients, register once here. Everything after that happens in a WhatsApp chat.</p>

                <div class="row g-3 my-2">
                    <div class="col-sm-6">
                        <div class="mini-card h-100" data-aos="fade-up" data-aos-delay="150">
                            <h2>Doctors running trials</h2>
                            <p class="mb-0">List your trials, keep them up to date and reach matching patients.</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mini-card h-100" data-aos="fade-up" data-aos-delay="220">
                            <h2>Doctors following trials</h2>
                            <p class="mb-0">Get WhatsApp alerts when new trials open in your city and specialty.</p>
                        </div>
                    </div>
                </div>

                <div class="after-panel" data-aos="fade-up" data-aos-delay="250">
                    <div class="js-mode-panel" data-mode="running"<?= $mode === 'running' ? '' : ' hidden' ?>>
                        <h2>After you register <span>· running trials</span></h2>
                        <ol class="step-list step-list--dark">
                            <li><span class="step-num">1</span><div><p><strong>Verify your number.</strong> You'll get a verification and welcome message on WhatsApp.</p></div></li>
                            <li><span class="step-num">2</span><div><p><strong>Add a trial.</strong> Share the NCT or CTRI ID and answer a few questions with taps. NCT trials fill in automatically.</p></div></li>
                            <li><span class="step-num">3</span><div><p><strong>Confirm weekly.</strong> One tap each week tells us if the trial is still active, closed or needs an update.</p></div></li>
                        </ol>
                    </div>
                    <div class="js-mode-panel" data-mode="following"<?= $mode === 'following' ? '' : ' hidden' ?>>
                        <h2>After you register <span>· following trials</span></h2>
                        <ol class="step-list step-list--dark">
                            <li><span class="step-num">1</span><div><p><strong>Verify your number.</strong> You'll get a verification and welcome message on WhatsApp.</p></div></li>
                            <li><span class="step-num">2</span><div><p><strong>Get trial alerts.</strong> When a trial opens in your city or specialty, we send you a short WhatsApp summary.</p></div></li>
                            <li><span class="step-num">3</span><div><p><strong>View trial details.</strong> Open the link in the alert to see the full trial details on the website.</p></div></li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <form class="form-card needs-validation js-demo-form" action="<?= e(url('doctor-registration.php')) ?>" method="post" novalidate
                      data-success-title="Check your WhatsApp"
                      data-success-text="We'll send a verification and welcome message to your WhatsApp number. (Design preview: WhatsApp verification is connected in the next stage.)"
                      data-aos="fade-left" data-aos-delay="100">
                    <?= csrf_field() ?>
                    <h2 class="form-card__title">Doctor registration</h2>
                    <p class="small text-muted-ou">All fields are required unless marked optional.</p>

                    <fieldset class="mb-3">
                        <legend class="form-label">How will you use OncoUday?</legend>
                        <label class="radio-card">
                            <input type="radio" name="usage_mode" value="running" class="js-mode-input"<?= $mode === 'running' ? ' checked' : '' ?> required>
                            <span><strong>I run clinical trials</strong><small>List my trials and keep them updated through WhatsApp.</small></span>
                        </label>
                        <label class="radio-card">
                            <input type="radio" name="usage_mode" value="following" class="js-mode-input"<?= $mode === 'following' ? ' checked' : '' ?>>
                            <span><strong>I don't run trials — I want to follow them</strong><small>Get WhatsApp alerts when new trials open.</small></span>
                        </label>
                    </fieldset>

                    <div class="mb-3">
                        <label class="form-label" for="dName">Full name</label>
                        <input class="form-control" id="dName" name="full_name" type="text" maxlength="120" placeholder="Dr. Firstname Lastname" autocomplete="name" required>
                        <div class="invalid-feedback">Please enter your full name.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="dEmail">Email</label>
                        <input class="form-control" id="dEmail" name="email" type="email" maxlength="160" placeholder="name@hospital.org" autocomplete="email" required>
                        <div class="invalid-feedback">Please enter a valid email address.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="dPhone">WhatsApp number</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text">+91</span>
                            <input class="form-control js-phone" id="dPhone" name="whatsapp" type="tel" inputmode="numeric" maxlength="10" pattern="[6-9][0-9]{9}" placeholder="10-digit mobile number" autocomplete="tel-national" required>
                            <div class="invalid-feedback">Please enter a valid 10-digit Indian mobile number.</div>
                        </div>
                        <div class="form-text">We'll send a verification message to this number.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="dHospital">Hospital or clinic</label>
                        <input class="form-control" id="dHospital" name="hospital" type="text" maxlength="160" placeholder="Hospital, clinic or institution" autocomplete="organization" required>
                        <div class="invalid-feedback">Please enter your hospital or clinic.</div>
                    </div>
                    <div class="row g-3 mb-3">
                        <?php partial('state-city', ['mode' => 'form', 'prefix' => 'd', 'wrap' => 'col-sm-6']); ?>
                        <div class="col-sm-6">
                            <label class="form-label" for="dSpecialty">Specialty</label>
                            <select class="form-select" id="dSpecialty" name="specialty" required>
                                <option value="">Select specialty</option>
                                <?php foreach (content()->specialties() as $s): ?>
                                    <option value="<?= e($s['slug']) ?>"><?= e($s['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Please select your specialty.</div>
                        </div>
                    </div>

                    <div class="mb-3 js-mode-panel" data-mode="following"<?= $mode === 'following' ? '' : ' hidden' ?>>
                        <span class="form-label d-block" id="dCancerLabel">Cancer types you want alerts for <span class="fw-normal text-muted-ou">(optional)</span></span>
                        <div class="dropdown multi-select js-multi-select" data-placeholder="All cancer types">
                            <button class="form-select text-start" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" aria-labelledby="dCancerLabel">
                                <span class="js-multi-label">All cancer types</span>
                            </button>
                            <div class="dropdown-menu w-100 p-2">
                                <?php foreach (content()->cancerTypes() as $c): ?>
                                    <div class="form-check dropdown-item-text">
                                        <input class="form-check-input" type="checkbox" name="alert_cancer_types[]" value="<?= e($c['slug']) ?>" id="dct-<?= e($c['slug']) ?>">
                                        <label class="form-check-label" for="dct-<?= e($c['slug']) ?>"><?= e($c['name']) ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="consent-box">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="dTerms" name="consent_terms" value="1" required>
                            <label class="form-check-label" for="dTerms">I agree to the <a href="<?= e(url('doctor-terms.php')) ?>" target="_blank" rel="noopener">Terms for Doctors</a>, the <a href="<?= e(url('terms-of-use.php')) ?>" target="_blank" rel="noopener">Terms of Use</a> and the <a href="<?= e(url('privacy-policy.php')) ?>" target="_blank" rel="noopener">Privacy Policy</a>, and I have read the <a href="<?= e(url('consent-notice.php')) ?>#doctors" target="_blank" rel="noopener">Consent Notice</a>.</label>
                        </div>
                        <div class="form-check mb-0">
                            <input class="form-check-input" type="checkbox" id="dWa" name="consent_whatsapp" value="1" required>
                            <label class="form-check-label" for="dWa">
                                <span class="js-mode-panel" data-mode="running"<?= $mode === 'running' ? '' : ' hidden' ?>>I agree to receive WhatsApp messages from OncoUday to manage my trials.</span>
                                <span class="js-mode-panel" data-mode="following"<?= $mode === 'following' ? '' : ' hidden' ?>>I agree to receive WhatsApp trial alerts from OncoUday.</span>
                                I can reply STOP at any time.
                            </label>
                        </div>
                    </div>

                    <button class="btn btn-navy w-100 btn-submit" type="submit"><i class="bi bi-whatsapp me-2" aria-hidden="true"></i>Register &amp; verify on WhatsApp</button>
                    <p class="text-center small mt-3 mb-0">Are you a patient or caregiver? <a href="<?= e(url('patient-registration.php')) ?>">Register here</a></p>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
