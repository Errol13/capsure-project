<!-- Modal Structure -->
<div class="modal" id="reportProfileModal" tabindex="-1" aria-labelledby="reportProfileLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header pt-0">
                <h5 class="modal-title" id="reportProfileLabel">Report Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Reason/s <span class="note">(Check all that applies)</span></label>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-check d-flex align-items-start">
                                    <input class="form-check-input me-2" type="checkbox" id="unprofessionalBehavior">
                                    <label class="form-check-label" for="unprofessionalBehavior">Unprofessional Behavior</label>
                                </div>
                                <div class="form-check d-flex align-items-start">
                                    <input class="form-check-input me-2" type="checkbox" id="poorQualityWork">
                                    <label class="form-check-label" for="poorQualityWork">Poor Quality Work</label>
                                </div>
                                <div class="form-check d-flex align-items-start">
                                    <input class="form-check-input me-2" type="checkbox" id="missedEvents">
                                    <label class="form-check-label" for="missedEvents">Missed Scheduled Event/s</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check d-flex align-items-start">
                                    <input class="form-check-input me-2" type="checkbox" id="inadequateCommunication">
                                    <label class="form-check-label" for="inadequateCommunication">Inadequate Communication</label>
                                </div>
                                <div class="form-check d-flex align-items-start">
                                    <input class="form-check-input me-2" type="checkbox" id="overcharging">
                                    <label class="form-check-label" for="overcharging">Overcharging</label>
                                </div>
                                <div class="form-check d-flex align-items-start">
                                    <input class="form-check-input me-2" type="checkbox" id="others">
                                    <label class="form-check-label" for="others">Others</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="otherDetails" class="form-label">Other details:</label>
                        <textarea class="form-control" id="otherDetails" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="attachProof" class="form-label">Attach Proof <span class="note">(Optional)</span></label>
                        <div class="file-upload">
                            <input type="file" class="form-control" id="attachProof" accept=".jpg,.png">
                            <small class="form-text text-muted">Upload (.jpg or .png format)</small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="confirm" data-bs-dismiss="modal">Submit</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Modal Background */
    .modal-content {
        border-radius: 20px;
        padding: 20px;
    }

    /* Title Styling */
    .modal-title {
        font-size: 24px;
    }

    /* Button Styling */
    .btn-done {
        background-color: #A12E70;
        /* Magenta color */
        color: white;
        padding: 10px 30px;
        border-radius: 10px;
        border: none;
    }

    .btn-done:hover {
        background-color: #821f56;
    }

    .form-check-label {
        font-weight: normal;
    }

    .form-check-input {
        margin-right: 10px;
        border-color: gray;
    }

    .modal-footer {
        border-top: none;
        display: flex;
        justify-content: center;
    }

    .file-upload input {
        border-radius: 10px;
        background-color: #e9ecef;
        padding: 10px;
    }
</style>