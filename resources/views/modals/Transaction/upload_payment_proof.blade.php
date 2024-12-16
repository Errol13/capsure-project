<!-- Upload Payment Proof Modal -->
<div class="modal fade" id="uploadPaymentProofModal{{ $uniqueId }}" tabindex="-1" role="dialog" aria-labelledby="uploadPaymentProofLabel{{ $uniqueId }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadPaymentProofLabel{{ $uniqueId }}">Upload Payment Proof</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body open-sans-reg">
                <!-- Modal Form -->
                <form id="uploadPaymentProofForm{{ $uniqueId }}" method="POST" action="{{ route('payment.upload', ['id' => $uniqueId]) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="transaction_id" value="{{ $uniqueId }}">

                    <!-- Payment Type -->
                    <div class="form-group mb-3 rounded pe-2">
                        <label for="paymentType{{ $uniqueId }}">Payment Type</label>
                        <select name="payment_type" id="paymentType{{ $uniqueId }}" class="form-select" style="border: #E1C1D7 solid 1px; " required>
                            <option class="text-muted" value="" disabled selected>Select</option>
                            <option value="Partial Payment">Partial Payment</option>
                            <option value="Full Payment">Full Payment</option>
                        </select>
                    </div>

                    <!-- Amount -->
                    <div class="form-group mb-2">
                        <label for="amountPaid{{ $uniqueId }}">Amount:</label>
                        <div class="input-group d-flex justify-content-start align-items-center">
                            <span class="bg-white me-2 fw-bold" style="color:#91216C;">₱</span>
                            <input type="number" class="form-control" id="amountPaid{{ $uniqueId }}"
                                style="border: #E1C1D7 solid 1px;" name="amount_paid" min="0" step="0.01" required>
                        </div>
                    </div>

                    <!-- File Upload (Only Single File Allowed) -->
                    <div class="form-group mb-2">
                        <label for="uploadProof{{ $uniqueId }}">Upload Proof</label>
                        <input type="file" class="form-control-file" id="uploadProof{{ $uniqueId }}" name="proof_file" accept="image/*" required>
                    </div>
                    <small class="form-text text-muted">Only 1 picture is allowed.</small>

                    <!-- Preview -->
                    <div id="imagePreview{{ $uniqueId }}" class="d-flex flex-wrap mb-3"></div>

                    <small class="text-danger">All fields required.</small>

                    <!-- Form Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="submitReviewButton_{{ $uniqueId }}">Submit Proof</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('uploadProof{{ $uniqueId }}');
        const previewContainer = document.getElementById('imagePreview{{ $uniqueId }}');

        fileInput.addEventListener('change', function() {
            // Clear previous previews
            previewContainer.innerHTML = '';

            const file = fileInput.files[0];

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = file.name;
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.style.objectFit = 'cover';
                    img.style.margin = '5px';
                    previewContainer.appendChild(img);
                }

                reader.readAsDataURL(file);
            }
        });

        // Disable the submit button when clicked
        document.getElementById('submitReviewButton_{{ $uniqueId }}').addEventListener('click', function(event) {
            event.preventDefault();

            // Disable the button
            var submitButton = document.getElementById('submitReviewButton_{{ $uniqueId }}');
            submitButton.disabled = true;
            submitButton.innerHTML = "Submitting...";

            //submit the form
            document.getElementById('uploadPaymentProofForm{{ $uniqueId }}').submit();
        });

    });
</script>