<?php
declare(strict_types=1);
require __DIR__ . '/app/bootstrap.php';

$page = [
    'title'       => 'Contact Us',
    'active'      => 'contact',
    'description' => 'Write to the OncoUday team about listing a trial, your data or anything else. Grievance Officer details for personal-data requests.',
];
$contact   = config('contact');
$grievance = $contact['grievance'];
$roles     = ['patient' => 'Patient', 'caregiver' => 'Caregiver / family member', 'doctor' => 'Doctor', 'hospital' => 'Hospital or partner organisation', 'volunteer' => 'Volunteer', 'other' => 'Other'];

require __DIR__ . '/includes/header.php';
?>

<section class="reg-section reg-section--contact">
    <?php illustration('rings', ['variant' => 'contact']); ?>
    <div class="container position-relative">
        <div class="maxw-680 mb-4 mb-lg-5">
            <h1 class="page-title" data-aos="fade-up">Write to the OncoUday team</h1>
            <p class="lead-ou" data-aos="fade-up" data-aos-delay="100">Questions about OncoUday, listing a trial or your data — send us a message. We can't give medical advice, so please speak to your doctor about treatment.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-7">
                <form class="form-card needs-validation js-demo-form" action="<?= e(url('contact.php')) ?>" method="post" novalidate
                      data-success-title="Message sent"
                      data-success-text="Thank you for writing to us. Our team will get back to you soon. (Design preview: messages are connected in the next stage.)"
                      data-aos="fade-up">
                    <?= csrf_field() ?>
                    <div class="hp-field" aria-hidden="true"><label for="website">Website</label><input type="text" id="website" name="website" tabindex="-1" autocomplete="off"></div>

                    <h2 class="form-card__title">Your message</h2>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label" for="cName">Name</label>
                            <input class="form-control" id="cName" name="name" type="text" maxlength="120" autocomplete="name" required>
                            <div class="invalid-feedback">Please enter your name.</div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="cEmail">Email</label>
                            <input class="form-control" id="cEmail" name="email" type="email" maxlength="160" autocomplete="email" required>
                            <div class="invalid-feedback">Please enter a valid email address.</div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="cPhone">Phone <span class="fw-normal text-muted-ou">(optional)</span></label>
                            <input class="form-control js-phone" id="cPhone" name="phone" type="tel" inputmode="numeric" maxlength="10" pattern="[6-9][0-9]{9}" autocomplete="tel-national">
                            <div class="invalid-feedback">Enter a valid 10-digit mobile number, or leave blank.</div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="cRole">I am a</label>
                            <select class="form-select" id="cRole" name="role" required>
                                <?php foreach ($roles as $value => $label): ?>
                                    <option value="<?= e($value) ?>"><?= e($label) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="cMessage">Message</label>
                            <textarea class="form-control js-counter" id="cMessage" name="message" rows="6" minlength="10" maxlength="2000" required></textarea>
                            <div class="d-flex justify-content-between gap-2">
                                <div class="form-text">Please don't include medical reports or details of your diagnosis.</div>
                                <div class="form-text text-nowrap"><span class="js-counter-out">0</span>/2000</div>
                            </div>
                            <div class="invalid-feedback">Please write a message (at least 10 characters).</div>
                        </div>
                    </div>
                    <p class="form-text mt-3 mb-0">We use your details only to reply to you. See our <a href="<?= e(url('privacy-policy.php')) ?>">Privacy Policy</a>.</p>
                    <button class="btn btn-navy mt-4 px-4 btn-submit" type="submit"><i class="bi bi-send me-2" aria-hidden="true"></i>Send message</button>
                </form>
            </div>

            <div class="col-lg-5">
                <div class="contact-box contact-box--orange" data-aos="fade-left">
                    <h2>Reach us directly</h2>
                    <ul class="list-unstyled mb-0">
                        <li><i class="bi bi-envelope" aria-hidden="true"></i><?= e($contact['email']) ?></li>
                        <li><i class="bi bi-whatsapp" aria-hidden="true"></i>WhatsApp: <?= e($contact['whatsapp']) ?></li>
                        <li><i class="bi bi-geo-alt" aria-hidden="true"></i><?= e($contact['address']) ?></li>
                        <li><i class="bi bi-clock" aria-hidden="true"></i><?= e($contact['hours']) ?></li>
                    </ul>
                </div>

                <div class="contact-box contact-box--navy" id="grievance" data-aos="fade-left" data-aos-delay="100">
                    <h2>Grievance Officer</h2>
                    <p>For concerns about how your personal data is handled, or to request correction or deletion.</p>
                    <dl class="grievance-list">
                        <div><dt>Name</dt><dd><?= e($grievance['name']) ?></dd></div>
                        <div><dt>Email</dt><dd><?= e($grievance['email']) ?></dd></div>
                        <div><dt>Phone</dt><dd><?= e($grievance['phone']) ?></dd></div>
                    </dl>
                    <p class="small mb-0">We acknowledge complaints within 24 hours and resolve data grievances within 90 days at most. <a class="text-white" href="<?= e(url('grievance-redressal.php')) ?>">How grievances are handled</a></p>
                </div>

                <div class="emergency-note" data-aos="fade-left" data-aos-delay="200">
                    <i class="bi bi-exclamation-circle" aria-hidden="true"></i>
                    <p class="mb-0">In a medical emergency, contact your doctor or the nearest hospital straight away.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
