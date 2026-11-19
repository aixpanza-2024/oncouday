<div class="modal fade ou-modal" id="enrolmentModal" tabindex="-1" aria-labelledby="enrolmentModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <p class="eyebrow mb-1" data-fill="cancer"></p>
                    <h2 class="modal-title h5" id="enrolmentModalTitle" data-fill="title"></h2>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <dl class="contact-list mb-3">
                    <div><dt><i class="bi bi-hospital" aria-hidden="true"></i> Hospital</dt><dd data-fill="hospital"></dd></div>
                    <div><dt><i class="bi bi-upc" aria-hidden="true"></i> Trial ID</dt><dd data-fill="registry"></dd></div>
                </dl>
                <p class="mb-3">To take this further, register with OncoUday. We will connect you with the trial team on WhatsApp.</p>
                <div class="interest-choices">
                    <a class="interest-choice interest-choice--patient" href="<?= e(url('patient-registration.php')) ?>">
                        <i class="bi bi-person-heart" aria-hidden="true"></i>
                        <span><strong>I'm a patient or caregiver</strong><small>Register for free</small></span>
                        <i class="bi bi-arrow-right ms-auto" aria-hidden="true"></i>
                    </a>
                    <a class="interest-choice interest-choice--doctor" href="<?= e(url('doctor-registration.php')) ?>">
                        <i class="bi bi-clipboard2-pulse" aria-hidden="true"></i>
                        <span><strong>I'm a doctor</strong><small>Register as a doctor</small></span>
                        <i class="bi bi-arrow-right ms-auto" aria-hidden="true"></i>
                    </a>
                </div>
                <p class="small text-muted-ou mt-3 mb-0">Please talk to your doctor before deciding to join a trial.</p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade ou-modal" id="successModal" tabindex="-1" aria-labelledby="successModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-body p-4 p-md-5">
                <div class="success-check" aria-hidden="true">
                    <svg viewBox="0 0 52 52"><circle cx="26" cy="26" r="24"/><path d="M15 27l7 7 15-16"/></svg>
                </div>
                <h2 class="h4 mt-3" id="successModalTitle" data-fill="title">Thank you!</h2>
                <p class="mb-4" data-fill="text"></p>
                <button type="button" class="btn btn-navy px-4" data-bs-dismiss="modal">Done</button>
            </div>
        </div>
    </div>
</div>

<div class="toast-container position-fixed bottom-0 start-50 translate-middle-x p-3">
    <div class="toast ou-toast align-items-center" id="ouToast" role="status" aria-live="polite" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
