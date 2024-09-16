<div class="modal fade" id="confirmpaymentmodal-{{ $transaction_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Payment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ route('payment.confirm', ['id' => $transaction_id]) }}">
        @csrf
        @method('PATCH')
        <div class="modal-body">
        <p class="fs-5">
        Are you sure to confirm this payment?
        </p>

         <p class="mt-4 fw-bold"><small>Note: Check the receipts before confirming.</small></p>
          <input type="hidden" name="payment_proof_id" value="{{ $payment_proof_id }}">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Confirm</button>
        </div>
      </form>
    </div>
  </div>
</div>
