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
                <p class="small text-muted-ou mb-3">Contact the trial team to ask whether this trial is suitable for you. Please take your doctor's advice before deciding.</p>
                <dl class="contact-list">
                    <div><dt><i class="bi bi-person" aria-hidden="true"></i> Contact</dt><dd data-fill="name"></dd></div>
                    <div><dt><i class="bi bi-envelope" aria-hidden="true"></i> Email</dt><dd data-fill="email"></dd></div>
                    <div><dt><i class="bi bi-telephone" aria-hidden="true"></i> Phone</dt><dd data-fill="phone"></dd></div>
                    <div><dt><i class="bi bi-hospital" aria-hidden="true"></i> Hospital</dt><dd data-fill="hospital"></dd></div>
                    <div><dt><i class="bi bi-upc" aria-hidden="true"></i> Trial ID</dt><dd data-fill="registry"></dd></div>
                </dl>
            </div>
            <div class="modal-footer">
                <a class="btn btn-magenta" href="<?= e(url('patient-registration.php')) ?>">Get alerts for trials like this</a>
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
