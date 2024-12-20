<!-- Modal Structure -->
<div class="modal" id="reportProfileModal" tabindex="-1" aria-labelledby="reportProfileLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header pt-0">
                <h5 class="modal-title" id="reportProfileLabel">Report Profile</h5>
                <button type="button" id="close-report-form" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="report-id" method="POST" action="{{route('report.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Reason/s
                            <span class="note">(Check all that apply)</span>
                            <span class="text-danger">*</span>
                        </label>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-check d-flex align-items-start">
                                    <input name="reason[]" class="form-check-input me-2" type="checkbox" id="unprofessionalBehavior" value="Unprofessional Behavior">
                                    <label class="form-check-label" for="unprofessionalBehavior">Unprofessional Behavior</label>
                                </div>
                                <div class="form-check d-flex align-items-start">
                                    <input name="reason[]" class="form-check-input me-2" type="checkbox" id="poorQualityWork" value="Poor Quality Work">
                                    <label class="form-check-label" for="poorQualityWork">Poor Quality Work</label>
                                </div>
                                <div class="form-check d-flex align-items-start">
                                    <input name="reason[]" class="form-check-input me-2" type="checkbox" id="missedEvents" value="Missed Scheduled Event/s">
                                    <label class="form-check-label" for="missedEvents">Missed Scheduled Event/s</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check d-flex align-items-start">
                                    <input name="reason[]" class="form-check-input me-2" type="checkbox" id="inadequateCommunication" value="Inadequate Communication">
                                    <label class="form-check-label" for="inadequateCommunication">Inadequate Communication</label>
                                </div>
                                <div class="form-check d-flex align-items-start">
                                    <input name="reason[]" class="form-check-input me-2" type="checkbox" id="overcharging" value="Overcharging">
                                    <label class="form-check-label" for="overcharging">Overcharging</label>
                                </div>
                                <div class="form-check d-flex align-items-start">
                                    <input name="reason[]" class="form-check-input me-2" type="checkbox" id="others" value="Others">
                                    <label class="form-check-label" for="others">Others</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="otherDetails" class="form-label">Other details: <span class="text-danger">*</span></label>
                        <textarea name="details" class="form-control" id="otherDetails" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="attachProof" class="form-label">Attach Proof <span class="text-danger">*</span></label>
                        <div class="file-upload">
                            <input type="file" name="proof_image[]" class="form-control" id="attachProof" accept=".jpg,.jpeg,.png" multiple required>
                            <small class="form-text text-muted">Upload (.jpg or .png format)</small>
                        </div>
                    </div>
                    <input type="hidden" name="reported_user_id" value="{{ $reportee->id }}"></input>
                    <input type="hidden" name="reporter_id" value="{{ auth()->user()->id }}"></input>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="report-button" class="btn btn-secondary" disabled> <span id="loading-spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        Submit</button>
                </div>
            </form>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to check if at least one reason is selected
        function checkTheFields() {
            const reasons = document.querySelectorAll('input[name="reason[]"]:checked');
            const attachProof = document.querySelector('input[name="proof_image[]"]');
            const details = document.getElementById('otherDetails');
            const reportButton = document.getElementById('report-button');

            // Check if 'proof_image[]' has files selected
            const hasProofImage = attachProof && attachProof.files && attachProof.files.length > 0;

            if (details.value && reasons.length > 0 && hasProofImage) {
                reportButton.disabled = false;
                reportButton.classList.remove('btn-secondary', 'btn');
                reportButton.classList.add('confirm');
            } else {
                reportButton.disabled = true;
                reportButton.classList.add('btn-secondary', 'btn');
                reportButton.classList.remove('confirm');
            }
        }

        document.querySelectorAll('input[name="reason[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', checkTheFields);
        });

        document.getElementById('attachProof').addEventListener('change', checkTheFields);

        document.getElementById('otherDetails').addEventListener('change', checkTheFields);

        // Reset the form when the modal is closed
        const closeButton = document.getElementById('close-report-form');

        closeButton.addEventListener('click', function() {
            document.getElementById('report-id').reset();
            checkTheFields();
        });

        // Handle the form submission via AJAX
        document.getElementById('report-id').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            const formData = new FormData(this);

            // Show loading spinner and disable the submit button during submission
            const reportButton = document.getElementById('report-button');
            const spinner = document.getElementById('loading-spinner');
            reportButton.disabled = true; // Disable the button
            spinner.classList.remove('d-none'); // Show the spinner

            fetch('/report', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    // Check if the submission was successful
                    if (data.success) {

                        //hide the spinner
                        spinner.classList.add('d-none'); 

                        // Reset the form
                        document.getElementById('report-id').reset();
                        checkTheFields();


                        // Get the modal element
                        var myModal = new bootstrap.Modal(document.getElementById('reportProfileModal'));

                        // Close the modal
                        myModal.hide();

                        // Show the success alert
                        setTimeout(function() {
                            // Show the success alert
                            alert('Report Submitted');
                            location.reload();
                        }, 300);
                    } else {
                         //hide the spinner
                         spinner.classList.add('d-none');

                        alert('There was an issue with your submission. Please try again.');
                       
                    }
                })
                .catch(error => {
                    //hide the spinner
                    spinner.classList.add('d-none');
                    
                    alert('An error occurred. Please try again later.' + error);
                    
                });
        });

        // Initial check for button state
        checkTheFields();
    });
</script>