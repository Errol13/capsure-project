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
                <form id="uploadPaymentProofForm{{ $uniqueId }}" method="POST" action="{{route('payment.upload', ['id' => $uniqueId] ) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="transaction_id" value="{{ $uniqueId }}">

                    <!-- Payment Type -->
                    <div class="form-group mb-3 p-3 rounded" style="background-color: #E1C1D7;">
                        <label for="paymentType{{ $uniqueId }}">Payment Type</label>
                        <div class="form-check">
                            <input class="form-check-input " type="radio" name="payment_type" id="partialPayment{{ $uniqueId }}" value="Partial Payment" required>
                            <label class="form-check-label" for="partialPayment{{ $uniqueId }}">Partial Payment</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_type" id="fullPayment{{ $uniqueId }}" value="Full Payment" required>
                            <label class="form-check-label" for="fullPayment{{ $uniqueId }}">Full Payment</label>
                        </div>
                    </div>

                    <!-- File Upload (Only Single File Allowed) -->
                    <div class="form-group mb-2">
                        <label cass=for="uploadProof{{ $uniqueId }}">Upload Proof</label>
                        <input type="file" class="form-control-file" id="uploadProof{{ $uniqueId }}" name="proof_file" accept="image/*" required>
                    </div>
                    <small class="form-text text-muted">Only 1 picture is allowed.</small>

                    <!-- Preview -->
                    <div id="imagePreview{{ $uniqueId }}" class="d-flex flex-wrap mb-3"></div>

                    <!-- Form Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit Proof</button>
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
    });
</script>
