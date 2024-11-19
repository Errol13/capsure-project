@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Tabs -->
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link active" style="color:black;" href="#ongoing" data-bs-toggle="tab">ON-GOING</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" style="color:black;" href="#upcoming" data-bs-toggle="tab">UPCOMING</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" style="color:black;" href="#history" data-bs-toggle="tab">HISTORY</a>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content">

        <!-- ON-GOING Tab ------------------------------------------------------------------------------------------------------------------------------>
        <div class="tab-pane show active" id="ongoing">
            @if($ongoing->isNotEmpty())

            <!-- Responsive Card Layout for Ongoing Transactions -->
            <div class="row g-4 my-2 pb-4 d-block">
                <!-- Loop through the on-going events -->
                @foreach($ongoing as $transaction)
                @php
                $event = $transaction->event;
                $today = \Carbon\Carbon::now('Asia/Manila');
                $unsettledPayment = $transaction->payment_status !== 'Fully Paid';
                $noReview = !$transaction->reviews()->where('reviewee_role', 'client')->exists();
                $isDue = $event->end_date < $today && $transaction->transaction_status === 'Ongoing';
                    @endphp

                    <!-- Card for Each Event Group -->
                    <div class="col">
                        <div class="card rounded-4 h-100" style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                            <div class="card-header d-flex align-items-center rounded-top-4" style="background-color: #FCF2F9; border-bottom: none;">
                                <div class="row align-items-center w-100">
                                    <!-- Title and Date Column -->
                                    <div class="col">
                                        <span class="fs-5 me-2 poppins-medium">{{ $transaction->event->title }}</span>

                                        @if ($isDue)
                                        @php
                                        $dueId = 'Modal-' . $event->event_id . '-user-' . auth()->user()->id;
                                        @endphp
                                        <span class="text-danger fs-6 fw-bold" data-bs-toggle="modal" data-bs-target="#due{{$dueId}}">
                                            <i class="fas fa-solid fa-circle-exclamation"></i>
                                        </span>
                                        @include('modals.Transaction.due_modal', [
                                        'id' => $dueId,
                                        'eventTitle' => $event->title,
                                        'unsettledPayment' => $unsettledPayment,
                                        'noReview' => $noReview
                                        ])
                                        @endif

                                        <small class="text-muted d-block mt-1">{{$transaction->event->start_date->format('M j Y, h:i A')}} - {{$transaction->event->end_date->format('M j Y, h:i A')}}</small>
                                    </div>
                                    <div class="col-auto ms-auto">
                                        <a href="{{route('client-viewpost', [ 'id' => $transaction->event->event_id] )}}" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration: none;">
                                            View Post
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-0">
                                @php
                                // Find the latest payment proof
                                $amountpaidTotal = $transaction->payment_proofs->sum('amount_paid');
                                $latestPaymentProof = $transaction->payment_proofs->sortByDesc('created_at')->first();
                                $madeaReview = $transaction->reviews()->where('reviewee_role', 'client')->exists() ?? false;
                                @endphp

                                <div class="d-flex align-items-start">

                                    <div class="flex-grow-1 d-lg-flex">
                                        <!-- Freelancer Information Section -->
                                        <div class="d-flex m-2 align-items-center w-100">
                                            <img src="{{asset($transaction->client->user->profile_image_url)}}" class="rounded-circle mx-2" alt="Freelancer Image" width="50" height="50">
                                            <div>
                                                <div class="row">
                                                    <span>{{$transaction->client->user->first_name}} {{$transaction->client->user->last_name}}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Payment Information Section -->
                                        <div class="col-lg-9 col-15 mt-3 mt-lg-0 me-lg-2 d-lg-flex">
                                            <table class="table table-borderless w-lg-100 mb-0 me-lg-2">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th class="note" style="white-space: nowrap;">Amount</th>
                                                        <th class="note" style="white-space: nowrap;">Status</th>
                                                        <th class="note" style="white-space: nowrap;">Payment Proof</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="text-center">
                                                        <td>₱ {{$transaction->payment_amount}}</td>

                                                        @php
                                                        $amountpaidTotal = $transaction->payment_proofs->sum('amount_paid');
                                                        $latestPaymentProof = $transaction->payment_proofs->sortByDesc('created_at')->first();
                                                        $madeaReview = $transaction->reviews()->where('reviewee_role', 'client')->exists();
                                                        @endphp

                                                        <td>
                                                            <!--confirm button to confirm payment-->
                                                            @if($transaction->payment_status === 'Unpaid')
                                                            <span class="text-danger fw-bold">Unpaid</span>

                                                            @elseif($transaction->payment_status === 'Partially Paid')
                                                            <span class="text-primary fw-bold">Partially Paid</span>

                                                            @elseif($latestPaymentProof->payment_type === 'Partial Payment')
                                                            <button type="button" data-bs-toggle="modal" data-bs-target="#confirmpaymentmodal-{{ $transaction->transaction_id }}"
                                                                data-paymentproof="{{ $latestPaymentProof->proof_id }}"
                                                                class="btn-verify rounded-4 py-1 px-3 ">Confirm</button>

                                                            @elseif($transaction->payment_status === 'Fully Paid')
                                                            <span class="text-success fw-bold">Fully Paid</span>

                                                            @elseif($latestPaymentProof->payment_type === 'Full Payment')
                                                            <button type="button" data-bs-toggle="modal" data-bs-target="#confirmpaymentmodal-{{ $transaction->transaction_id }}"
                                                                data-paymentproof="{{ $latestPaymentProof->proof_id }}"
                                                                class="btn-verify rounded-4 py-1 px-3 ">Confirm</button>
                                                            @endif
                                                        </td>

                                                        <td>
                                                            @if($transaction->payment_proofs->isNotEmpty())
                                                            <a style="color: #91216C;" data-bs-toggle="modal" data-bs-target="#receiptModal{{ $transaction->transaction_id }}">
                                                                <i class="fas fa-receipt me-2"></i><u>Receipt/Proof</u>
                                                            </a>
                                                            @else
                                                            <small class=" text-center text-muted text-nowrap">No receipt yet</small>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <!-- Review and Confirm buttons-->
                                            <div class="d-flex mt-2 justify-content-center align-items-center">
                                                @if($transaction->transaction_status !== 'Done' && $madeaReview === false)
                                                <button type="button" class="btn-round btn-sm m-3" style="background-color: white; border: 1px solid darkgray;"
                                                    data-bs-toggle="modal" data-bs-target="#writeReviewModal_{{$transaction->transaction_id}}"
                                                    @if($transaction->payment_status !== 'Fully Paid') disabled @endif>Write a Review</button>
                                                @elseif($madeaReview || $transaction->transaction_status === 'Done' )
                                                <button type="button" class="btn-round btn-sm m-3" style="background-color: white; border: 1px solid darkgray;"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#reviewModal_{{$transaction->transaction_id}}">View Review</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($transaction->payment_proofs->isNotEmpty())
                                <!--include here the modal for viewing receipt-->
                                @include('modals.Transaction.view_receipt',
                                ['transactionId' => $transaction->transaction_id,
                                'paymentProofs' => $transaction->payment_proofs])

                                <!--confirmation modal-->

                                @include('modals.Transaction.confirm_payment',
                                ['transaction_id' => $transaction->transaction_id,
                                'payment_proof_id' => $latestPaymentProof->proof_id])
                                @endif

                                <!--write review -->
                                @php
                                $reviewee_role = 'client';
                                $reviewee = $transaction->client;
                                $review = $transaction->reviews()->where('reviewee_role', 'client')->first(); //the freelancer's review
                                @endphp

                                @include('modals.Transaction.write_review', ['transaction_id' => $transaction->transaction_id,
                                'reviewee_role' => $reviewee_role, 'reviewee' => $reviewee])

                                <!--view review -->
                                @if($madeaReview)
                                @include('modals.Transaction.view_review', ['transaction_id' => $transaction->transaction_id,
                                'reviewee_role' => $reviewee_role, 'reviewee' => $reviewee, 'review' => $review])
                                @endif


                                @endforeach
                            </div>
                        </div>
                    </div>
            </div>
            @else
            <p>No on-going transactions.</p>
            @endif


        </div>

        <!-- UPCOMING Tab --------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="tab-pane" id="upcoming">
            @if($upcoming->isNotEmpty())

            <!-- Responsive Card Layout for Ongoing Transactions -->
            <div class="row g-4 my-2 pb-4 d-block">
                <!-- Loop through the on-going events -->
                @foreach($upcoming as $transaction)
                <!-- Card for Each Event Group -->
                <div class="col">
                    <div class="card rounded-4 h-100" style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                        <div class="card-header d-flex align-items-center rounded-top-4" style="background-color: #FCF2F9;border-bottom: none;">
                            <div class="row align-items-center w-100">
                                <!-- Title and Date Column -->
                                <div class="col">
                                    <span class="fs-5 me-2 poppins-medium">{{ $transaction->event->title }}</span>

                                    <small class="text-muted d-block mt-1">{{$transaction->event->start_date->format('M j Y, h:i A')}} - {{$transaction->event->end_date->format('M j Y, h:i A')}}</small>
                                </div>
                                <div class="col-auto ms-auto">
                                    <a href="{{route('client-viewpost', [ 'id' => $transaction->event->event_id] )}}" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration: none;">
                                        View Post
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="d-flex align-items-start">

                                <div class="flex-grow-1 d-lg-flex">
                                    <!-- Freelancer Information Section -->
                                    <div class="d-flex m-2 align-items-center w-100">
                                        <img src="{{asset($transaction->client->user->profile_image_url)}}" class="rounded-circle mx-2" alt="Freelancer Image" width="50" height="50">
                                        <div>
                                            <div class="row">
                                                <span>{{$transaction->client->user->first_name}} {{$transaction->client->user->last_name}}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Payment Information Section -->
                                    <div class="col-lg-9 col-15 mt-3 mt-lg-0 me-lg-2 d-lg-flex">
                                        <table class="table table-borderless w-lg-100 mb-0 me-lg-2">
                                            <thead>
                                                <tr class="text-center">
                                                    <th class="note" style="white-space: nowrap;">Amount</th>
                                                    <th class="note" style="white-space: nowrap;">Status</th>
                                                    <th class="note" style="white-space: nowrap;">Payment Proof</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <td>₱ {{$transaction->payment_amount}}</td>

                                                    @php
                                                    $amountpaidTotal = $transaction->payment_proofs->sum('amount_paid');
                                                    $latestPaymentProof = $transaction->payment_proofs->sortByDesc('created_at')->first();
                                                    $madeaReview = $transaction->reviews()->where('reviewee_role', 'client')->exists();
                                                    @endphp

                                                    <td>
                                                        <!--confirm button to confirm payment-->
                                                        @if($transaction->payment_status === 'Unpaid')
                                                        <span class="text-danger fw-bold">Unpaid</span>

                                                        @elseif($transaction->payment_status === 'Partially Paid')
                                                        <span class="text-primary fw-bold">Partially Paid</span>

                                                        @elseif($latestPaymentProof->payment_type === 'Partial Payment')
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#confirmpaymentmodal-{{ $transaction->transaction_id }}"
                                                            data-paymentproof="{{ $latestPaymentProof->proof_id }}"
                                                            class="btn-verify rounded-4 py-1 px-3 ">Confirm</button>

                                                        @elseif($transaction->payment_status === 'Fully Paid')
                                                        <span class="text-success fw-bold">Fully Paid</span>

                                                        @elseif($latestPaymentProof->payment_type === 'Full Payment')
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#confirmpaymentmodal-{{ $transaction->transaction_id }}"
                                                            data-paymentproof="{{ $latestPaymentProof->proof_id }}"
                                                            class="btn-verify rounded-4 py-1 px-3 ">Confirm</button>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if($transaction->payment_proofs->isNotEmpty())
                                                        <a style="color: #91216C;" data-bs-toggle="modal" data-bs-target="#receiptModal{{ $transaction->transaction_id }}">
                                                            <i class="fas fa-receipt me-2"></i><u>Receipt/Proof</u>
                                                        </a>
                                                        @else
                                                        <small class=" text-center text-muted text-nowrap">No receipt yet</small>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <!-- Review and Confirm buttons-->
                                        <div class="d-flex mt-2 justify-content-center align-items-center">
                                            @if($transaction->transaction_status !== 'Done' && $madeaReview === false)
                                            <button type="button" class="btn-round btn-sm m-3" style="background-color: white; border: 1px solid darkgray;"
                                                data-bs-toggle="modal" data-bs-target="#writeReviewModal_{{$transaction->transaction_id}}"
                                                @if($transaction->payment_status !== 'Fully Paid') disabled @endif>Write a Review</button>
                                            @elseif($madeaReview || $transaction->transaction_status === 'Done' )
                                            <button type="button" class="btn-round btn-sm m-3" style="background-color: white; border: 1px solid darkgray;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#reviewModal_{{$transaction->transaction_id}}">View Review</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modals for receipts, payment proof, and reviews -->
                            @include('modals.Transaction.view_receipt', ['transactionId' => $transaction->transaction_id, 'paymentProofs' => $transaction->payment_proofs])
                            @include('modals.Transaction.write_review', ['transaction_id' => $transaction->transaction_id, 'reviewee_role' => 'client', 'reviewee' => $transaction->client])


                            @if($transaction->payment_proofs->isNotEmpty())
                            <!--include here the modal for viewing receipt-->
                            @include('modals.Transaction.view_receipt',
                            ['transactionId' => $transaction->transaction_id,
                            'paymentProofs' => $transaction->payment_proofs])

                            <!--confirmation modal-->

                            @include('modals.Transaction.confirm_payment',
                            ['transaction_id' => $transaction->transaction_id,
                            'payment_proof_id' => $latestPaymentProof->proof_id])
                            @endif

                            <!--write review -->
                            @php
                            $reviewee_role = 'client';
                            $reviewee = $transaction->client;
                            $review = $transaction->reviews()->where('reviewee_role', 'cleint')->first(); //the client's review
                            @endphp

                            @include('modals.Transaction.write_review', ['transaction_id' => $transaction->transaction_id,
                            'reviewee_role' => $reviewee_role, 'reviewee' => $reviewee])

                            <!--view review -->
                            @if($madeaReview)
                            @include('modals.Transaction.view_review', ['transaction_id' => $transaction->transaction_id,
                            'reviewee_role' => $reviewee_role, 'reviewee' => $reviewee, 'review' => $review])
                            @endif

                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @else
            <p>No upcoming transactions.</p>
            @endif
        </div>

        <!-- HISTORY Tab ----------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="tab-pane" id="history">
            @if($previous->isNotEmpty())
            <!-- Responsive Card Layout for Ongoing Transactions -->
            <div class="row g-4 my-2 pb-4 d-block">
                <!-- Loop through the on-going events -->
                @foreach($previous as $transaction)
                <!-- Card for Each Event Group -->
                <div class="col">
                    <div class="card rounded-4 h-100" style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                        <div class="card-header d-flex align-items-center rounded-top-4" style="background-color: #FCF2F9; border-bottom: none;">
                            <div class="row align-items-center w-100">
                                <!-- Title and Date Column -->
                                <div class="col">
                                    <span class="fs-5 me-2 poppins-medium">{{ $transaction->event->title }}</span>

                                    <small class="text-muted d-block mt-1">{{$transaction->event->start_date->format('M j Y, h:i A')}} - {{$transaction->event->end_date->format('M j Y, h:i A')}}</small>
                                </div>
                                <div class="col-auto ms-auto">
                                    <a href="{{route('client-viewpost', [ 'id' => $transaction->event->event_id] )}}" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration: none;">
                                        View Post
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="d-flex align-items-start">

                                <div class="flex-grow-1 d-lg-flex">
                                    <!-- Freelancer Information Section -->
                                    <div class="d-flex m-2 align-items-center w-100">
                                        <img src="{{asset($transaction->client->user->profile_image_url)}}" class="rounded-circle mx-2" alt="Freelancer Image" width="50" height="50">
                                        <div>
                                            <div class="row">
                                                <span>{{$transaction->client->user->first_name}} {{$transaction->client->user->last_name}}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Payment Information Section -->
                                    <div class="col-lg-9 col-15 mt-3 mt-lg-0 me-lg-2 d-lg-flex">
                                        <table class="table table-borderless w-lg-100 mb-0 me-lg-2">
                                            <thead>
                                                <tr class="text-center">
                                                    <th class="note" style="white-space: nowrap;">Amount</th>
                                                    <th class="note" style="white-space: nowrap;">Status</th>
                                                    <th class="note" style="white-space: nowrap;">Payment Proof</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <td>₱ {{$transaction->payment_amount}}</td>

                                                    @php
                                                    $amountpaidTotal = $transaction->payment_proofs->sum('amount_paid');
                                                    $latestPaymentProof = $transaction->payment_proofs->sortByDesc('created_at')->first();
                                                    $madeaReview = $transaction->reviews()->where('reviewee_role', 'client')->exists();
                                                    @endphp

                                                    <td>
                                                        <!--confirm button to confirm payment-->
                                                        @if($transaction->payment_status === 'Unpaid')
                                                        <span class="text-danger fw-bold">Unpaid</span>

                                                        @elseif($transaction->payment_status === 'Partially Paid')
                                                        <span class="text-primary fw-bold">Partially Paid</span>

                                                        @elseif($latestPaymentProof->payment_type === 'Partial Payment')
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#confirmpaymentmodal-{{ $transaction->transaction_id }}"
                                                            data-paymentproof="{{ $latestPaymentProof->proof_id }}"
                                                            class="btn-verify rounded-4 py-1 px-3 ">Confirm</button>

                                                        @elseif($transaction->payment_status === 'Fully Paid')
                                                        <span class="text-success fw-bold">Fully Paid</span>

                                                        @elseif($latestPaymentProof->payment_type === 'Full Payment')
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#confirmpaymentmodal-{{ $transaction->transaction_id }}"
                                                            data-paymentproof="{{ $latestPaymentProof->proof_id }}"
                                                            class="btn-verify rounded-4 py-1 px-3 ">Confirm</button>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if($transaction->payment_proofs->isNotEmpty())
                                                        <a style="color: #91216C;" data-bs-toggle="modal" data-bs-target="#receiptModal{{ $transaction->transaction_id }}">
                                                            <i class="fas fa-receipt me-2"></i><u>Receipt/Proof</u>
                                                        </a>
                                                        @else
                                                        <small class=" text-center text-muted text-nowrap">No receipt yet</small>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <!-- Review and Confirm buttons-->
                                        <div class="d-flex mt-2 justify-content-center align-items-center">
                                            @if($transaction->transaction_status !== 'Done' && $madeaReview === false)
                                            <button type="button" class="btn-round btn-sm m-3" style="background-color: white; border: 1px solid darkgray;"
                                                data-bs-toggle="modal" data-bs-target="#writeReviewModal_{{$transaction->transaction_id}}"
                                                @if($transaction->payment_status !== 'Fully Paid') disabled @endif>Write a Review</button>
                                            @elseif($madeaReview || $transaction->transaction_status === 'Done' )
                                            <button type="button" class="btn-round btn-sm m-3" style="background-color: white; border: 1px solid darkgray;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#reviewModal_{{$transaction->transaction_id}}">View Review</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($transaction->payment_proofs->isNotEmpty())
                            <!--include here the modal for viewing receipt-->
                            @include('modals.Transaction.view_receipt',
                            ['transactionId' => $transaction->transaction_id,
                            'paymentProofs' => $transaction->payment_proofs])

                            <!--confirmation modal-->

                            @include('modals.Transaction.confirm_payment',
                            ['transaction_id' => $transaction->transaction_id,
                            'payment_proof_id' => $latestPaymentProof->proof_id])
                            @endif

                            <!--write review -->
                            @php
                            $reviewee_role = 'client';
                            $reviewee = $transaction->client;
                            $review = $transaction->reviews()->where('reviewee_role', 'client')->first(); //the client's review
                            @endphp

                            @include('modals.Transaction.write_review', ['transaction_id' => $transaction->transaction_id,
                            'reviewee_role' => $reviewee_role, 'reviewee' => $reviewee])

                            <!--view review -->
                            @if($madeaReview)
                            @include('modals.Transaction.view_review', ['transaction_id' => $transaction->transaction_id,
                            'reviewee_role' => $reviewee_role, 'reviewee' => $reviewee, 'review' => $review])
                            @endif

                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @else
            <p>No previous transactions.</p>
            @endif


        </div>
        @include('modals.f_review')
    </div>
</div>

@endsection