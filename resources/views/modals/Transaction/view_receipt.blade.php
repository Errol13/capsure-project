<!-- Modal -->
<div class="modal fade" id="receiptModal{{ $transactionId }}" tabindex="-1" aria-labelledby="receiptModalLabel{{ $transactionId }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="receiptModalLabel{{ $transactionId }}">Receipt Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                <!-- Loop through payment proofs -->
                @foreach($paymentProofs as $index => $proof)
                <div class="mb-4">
                    <!-- Payment Type -->
                    <span class="text-muted">Date uploaded: {{ $proof->created_at->format('M j Y, h:i A') }}</span>
                    <p><strong>Payment Type:</strong> {{ $proof->payment_type }}</p>
                    

                    <!-- Receipt Image with Fancybox integration -->
                    <a href="{{ Storage::url($proof->file_path) }}" data-fancybox="gallery" data-caption="Payment Type: {{ $proof->payment_type }}">
                        <img src="{{ Storage::url($proof->file_path) }}" class="img-fluid" alt="Receipt Image">
                    </a>
                </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
