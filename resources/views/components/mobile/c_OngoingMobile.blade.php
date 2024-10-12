<div class="d-block d-md-none">
    @foreach($transactionsByEvent['ongoing'] as $eventGroup)
    @php
    $event = $eventGroup['event'];
    $hasOngoingTransaction = $eventGroup['transactions']->contains(function ($transaction) {
    return $transaction->transaction_status === 'Ongoing';
    });
    $unsettledPayment = $eventGroup['transactions']->contains(function ($transaction) {
    return $transaction->payment_status !== 'Fully Paid';
    });
    $noReview = $eventGroup['transactions']->contains(function ($transaction) {
    return !$transaction->reviews()->where('reviewee_role', 'freelancer')->exists();
    });
    $isDue = $event->end_date < \Carbon\Carbon::now() && $hasOngoingTransaction;
        @endphp

        <div class="card mb-4 rounded-4 p-0" style="background-color: white;box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
        <div class="card-header" style="background-color:#FCF2F9;">
            <h5 class="poppins-medium">{{$eventGroup['event']->title}}
                @if ($isDue)
                @php
                $dueId = 'Modal-' . $eventGroup['event']->event_id . '-user-' . auth()->user()->id;
                @endphp
                <span class="text-danger fs-6 fw-bold due-container" data-bs-toggle="modal"
                    data-bs-target="#due{{$dueId}}">
                    <i class="fas fa-solid fa-circle-exclamation"></i>
                </span>
                @include('modals.Transaction.due_modal', ['id' => $dueId ,'eventTitle' =>
                $eventGroup['event']->title, 'unsettledPayment' => $unsettledPayment, 'noReview' =>
                $noReview])
                @endif
            </h5>
            <small class="text-muted" style="line-height: 0.5;">{{$eventGroup['event']->start_date_formatted}} - {{$eventGroup['event']->end_date_formatted}}</small>
            <a href="{{route('client-viewpost', [ 'id' => $eventGroup['event']->event_id] )}}"
                class="btn btn-link fw-medium ps-0" style="white-space:nowrap; text-decoration:none; color:#91216C;">View Post</a>
        </div>
        <div class="card-body">
            @foreach($eventGroup['transactions'] as $transaction)

            <div class="col-auto d-flex ">
                <img src="{{asset($transaction->freelancer->user->profile_image_url)}}"
                    class="rounded-circle me-2" style="width: 50px; height: 50px;">
                <div class="d-flex align-items-center">
                    <div class="ms-2">
                        <span>{{$transaction->freelancer->user->first_name}} {{$transaction->freelancer->user->last_name}}</span>
                        <small class="text-muted d-block">{{$transaction->Hiring_request->serviceDetails()->job_title}}</small>
                    </div>
                </div>
            </div>
            <p class="mb-0">Payment Amount:<span class="fw-bold"> ₱ {{$transaction->payment_amount}}</span></p>
            <p>Payment Status: @php
                $amountpaidTotal = $transaction->payment_proofs->sum('amount_paid');
                $latestPaymentProof = $transaction->payment_proofs->sortByDesc('created_at')->first();
                $madeaReview = $transaction->reviews()->where('reviewee_role',
                'freelancer')->exists();
                @endphp
                @if($transaction->payment_status === 'Unpaid')
                <span class="text-danger fw-bold">{{$transaction->payment_status}}</span>
                @elseif($latestPaymentProof->payment_type === 'Partial Payment' &&
                $transaction->payment_status === 'Pending' )
            <div class="d-flex flex-column justify-content-center align-items-center">
                <span class="text-muted fw-bold">Partially Paid - ₱{{$amountpaidTotal}}</span>
                <small class="text-muted">(pending)</small>
            </div>
            @elseif($transaction->payment_status === 'Partially Paid')
            <span class="text-primary fw-bold">{{$transaction->payment_status}} -
                ₱{{$amountpaidTotal}} </span>
            @elseif($latestPaymentProof->payment_type === 'Full Payment' &&
            $transaction->payment_status === 'Pending')
            <div class="d-flex flex-column justify-content-center align-items-center">
                <span class="text-muted fw-bold">Fully Paid - ₱{{$amountpaidTotal}}</span>
                <small class="text-muted">(pending)</small>
            </div>
            @elseif($transaction->payment_status === 'Fully Paid')
            <span class="text-success fw-bold">{{$transaction->payment_status}}</span>
            @endif
            </p>
            
            <div class="col d-flex justify-content-center align-items-center mb-2">
                <button class="btn btn-outline-secondary btn-sm position-relative"
                    style="white-space: nowrap;border-bottom-right-radius: 0; border-top-right-radius: 0;"
                    data-bs-toggle="modal"
                    data-bs-target="#receiptModal{{ $transaction->transaction_id }}">
                    <i class="fas fa-receipt me-2"></i>View Receipts
                </button>
                <span class="upload-icon"
                    style="background-color: none; padding: 1rem 0.9rem 1rem 0.9rem; border-bottom-right-radius: 4px; border-top-right-radius: 4px; z-index: 2; position: relative;">
                    <button type="button" class="btn p-0 m-0" data-bs-toggle="modal"
                        data-bs-target="#uploadPaymentProofModal{{ $transaction->transaction_id }}"
                        @if($transaction->payment_status === 'Fully Paid') disabled @endif
                        style="z-index: 2; position: relative; height: 100%; display: flex; align-items: center;">
                        <i class="fas fa-upload" style="color: #000;"></i>
                    </button>
                </span>
            </div>

            <div class="col d-flex justify-content-end mb-2">
                @if($transaction->transaction_status !== 'Done' && $madeaReview === false)
                <button type="button" class="btn btn-outline-secondary btn-sm btn-fit-width"
                    data-bs-toggle="modal"
                    data-bs-target="#writeReviewModal_{{$transaction->transaction_id}}"
                    @if($transaction->payment_status !== 'Fully Paid') disabled @endif>Write a
                    Review</button>
                @elseif($madeaReview || $transaction->transaction_status === 'Done' )
                <button type="button" class="btn btn-outline-secondary btn-sm btn-fit-width"
                    data-bs-toggle="modal"
                    data-bs-target="#reviewModal_{{$transaction->transaction_id}}">View Review</button>
                @endif
            </div>
            @if (!$loop->last)
            <hr class="my-3" style="margin-bottom: 0; border: 1px solid #ddd;">
            @endif
            @endforeach
        </div>
</div>
@endforeach