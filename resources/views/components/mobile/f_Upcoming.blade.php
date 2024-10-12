<div class="d-block d-md-none">
    <!-- Loop on-going transactions -->
    @foreach($upcoming as $transaction)

        <div class="card mb-4 rounded-4 p-0" style="background-color: white;box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <div class="card-header justify-content-center align-items-center" style="background-color:#FCF2F9;">
                <h5 class="poppins-medium ">{{$event->title}}
                    @if ($isDue)
                    @php
                    // Generate a unique id for modal warning due
                    $dueId = 'Modal-' . $transaction->transaction_id . '-freelancer-' . auth()->user()->id;
                    @endphp
                    <span class="text-danger fs-6 fw-bold due-container" data-bs-toggle="modal"
                        data-bs-target="#due{{$dueId}}">
                        <i class="fas fa-solid fa-circle-exclamation"></i>
                    </span>
                    @include('modals.Transaction.due_modal', [
                    'id' => $dueId,
                    'eventTitle' => $transaction->event->title,
                    'unsettledPayment' => $unsettledPayment,
                    'noReview' => $noReview
                    ])
                    @endif
                </h5>
                <small class="text-muted d-block" style="line-height: 0.5;">
                    {{$event->start_date->format('M j Y, h:i A')}} - {{$event->end_date->format('M j Y, h:i A')}}
                </small>
                <a href="{{route('client-viewpost', ['id' => $transaction->event->event_id])}}"
                    class="btn btn-link fw-medium ps-0"
                    style="white-space:nowrap; text-decoration:none; color:#91216C;">View Post</a>
            </div>
            <div class="card-body">
                @php
                // Find the latest payment proof
                $amountpaidTotal = $transaction->payment_proofs->sum('amount_paid');
                $latestPaymentProof = $transaction->payment_proofs->sortByDesc('created_at')->first();
                $madeaReview = $transaction->reviews()->where('reviewee_role', 'client')->exists() ?? false;
                @endphp
                <div class="col-auto d-flex mb-2">
                    <img src="{{asset($transaction->client->user->profile_image)}}" class="img-fluid rounded-circle me-2">
                    <div class="d-flex align-items-center">
                        <div class="ms-2">
                            <strong>{{$transaction->client->user->first_name}} {{$transaction->client->user->last_name}}</strong>
                        </div>
                    </div>
                </div>
                <p class="mb-0">Payment Amount:<span class="fw-bold"> ₱ {{$transaction->payment_amount}}</span></p>

                <p class="mb-0">Payment Status:
                    @if($transaction->payment_status === 'Unpaid')
                    <span class="text-danger fw-bold">Unpaid</span>
                    @elseif($latestPaymentProof && $latestPaymentProof->payment_type === 'Partial Payment' && $transaction->payment_status === 'Pending')
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <span class="text-muted fw-bold">Partially Paid - ₱{{$amountpaidTotal}}</span>
                    <small class="text-muted">(pending)</small>
                </div>
                @elseif($transaction->payment_status === 'Partially Paid')
                <span class="text-primary fw-bold">Partially Paid - ₱{{$amountpaidTotal}}</span>
                @elseif($latestPaymentProof && $latestPaymentProof->payment_type === 'Full Payment' && $transaction->payment_status === 'Pending')
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <span class="text-muted fw-bold">Fully Paid - ₱{{$amountpaidTotal}}</span>
                    <small class="text-muted">(pending)</small>
                </div>
                @elseif($transaction->payment_status === 'Fully Paid')
                <span class="text-success fw-bold">Fully Paid</span>
                @endif
                </p>

                <p>Confirmation:
                    @if($transaction->payment_status === 'Unpaid')
                    <span class="text-danger fw-bold">Unpaid</span>
                    @elseif($transaction->payment_status === 'Partially Paid' || $latestPaymentProof)
                    <button type="button" data-bs-toggle="modal"
                        data-bs-target="#confirmpaymentmodal-{{ $transaction->transaction_id }}"
                        data-paymentproof="{{ $latestPaymentProof->proof_id ?? '' }}"
                        class="btn-verify btn btn-sm btn-outline-primary">
                        Confirm
                    </button>
                    @endif
                </p>

                @if($transaction->payment_proofs->isNotEmpty())
                <div class="col d-flex justify-content-center mb-2">
                    <a href="#" data-bs-toggle="modal"
                        data-bs-target="#receiptModal{{ $transaction->transaction_id }}"
                        class="btn btn-outline-secondary btn-sm position-relative" style="white-space: nowrap;">
                        <i class="fas fa-receipt me-2"></i>Receipt
                    </a>
                </div>
                @else
                <div class="col text-center mb-2">
                    <small class="text-muted text-nowrap">No receipt</small>
                </div>
                @endif

                <div class="col d-flex justify-content-end">
                    @if($transaction->transaction_status !== 'Done')
                    <button type="button"
                        class="btn btn-outline-secondary btn-sm w-100"
                        data-bs-toggle="modal" data-bs-target="#writeReviewModal_{{$transaction->transaction_id}}"
                        @if($transaction->payment_status !== 'Fully Paid') disabled @endif>
                        Write Review
                    </button>
                    @elseif($transaction->transaction_status === 'Done' || $madeaReview)
                    <button type="button" class="btn btn-outline-secondary btn-sm w-100"
                        data-bs-toggle="modal"
                        data-bs-target="#reviewModal_{{$transaction->transaction_id}}">
                        View Review
                    </button>
                    @endif
                </div>

            </div>
        </div>
        @endforeach
</div>