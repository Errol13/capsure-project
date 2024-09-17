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
            <!-- Table for larger screens -->
            <table id="unique-payment-table" class="table table-borderless d-none d-md-table mt-3">
                <thead class="table-primary poppins-extralight">
                    <tr>
                        <th style="width: 10%;"></th>
                        <th style="width: 12%;"></th>
                        <th style="width: 17%;">Payment Amount</th>
                        <th style="width: 18%;">Payment Status</th>
                        <th style="width: 15%;">Confirmation</th>
                        <th style="width: 18%;">Payment Proof</th>
                        <th style="width: 11%;"></th>
                    </tr>
                </thead>
                <tbody>

                    <!--Loop on-going transactions-->
                    @foreach($ongoing as $transaction)

                    <!--Check if there are unpaid transactions or not fully paid or no review -->
                    @php
                    $event = $transaction->event;
                    $today = \Carbon\Carbon::now('Asia/Manila');
                    $unsettledPayment = $transaction->payment_status !== 'Fully Paid';
                    $noReview = !$transaction->reviews()->where('reviewee_role', 'client')->exists();
                    $isDue = $event->end_date < $today && $transaction->transaction_status === 'Ongoing';
                        @endphp

                        <tr style="border:none;">
                            <td colspan="7" class="p-0">
                                <div class="card mb-1 mt-3">
                                    <div class="card-header poppins-medium d-flex justify-content-between align-items-center">
                                        <span>{{$transaction->event->title}}
                                            @if ($isDue)

                                            @php
                                            //generate a unique id for modal warning due
                                            $dueId = 'Modal-' . $transaction->transaction_id . '-freelancer-' . auth()->user()->id;
                                            @endphp

                                            <span class="text-danger fs-6 fw-bold" data-bs-toggle="modal" data-bs-target="#due{{$dueId}}">
                                                <i class="fas fa-solid fa-circle-exclamation"></i>
                                            </span>
                                            
                                            @include('modals.Transaction.due_modal', ['id' => $dueId, 'eventTitle' => $transaction->event->title,
                                            'unsettledPayment' => $unsettledPayment, 'noReview' => $noReview])
                                           
                                            @endif</span>

                                           

                                        <small>{{$transaction->event->start_date->format('M j Y, h:i A')}} - {{$transaction->event->end_date->format('M j Y, h:i A')}}</small>
                                        <a href="{{route('client-viewpost', [ 'id' => $transaction->event->event_id] )}}" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration:none;">View Post</a>
                                    </div>
                                    <div class="card-body">

                                        @php
                                        // Find the latest payment proof
                                        $amountpaidTotal = $transaction->payment_proofs->sum('amount_paid');
                                        $latestPaymentProof = $transaction->payment_proofs->sortByDesc('created_at')->first();
                                        $madeaReview = $transaction->reviews()->where('reviewee_role', 'client')->exists() ?? false;
                                        @endphp

                                        <div class="row align-items-center mb-2">
                                            <div class="col-auto pe-1">
                                                <img src="{{asset($transaction->client->user->profile_image)}}" class="rounded-circle">
                                            </div>
                                            <div class="col-2 pe-4">
                                                <div class="d-flex flex-column align-items-start">
                                                    <div>{{$transaction->client->user->first_name}} {{$transaction->client->user->last_name}}</div>
                                                </div>
                                            </div>
                                            <div class="col-2 text-left">₱ {{$transaction->payment_amount}}</div>

                                            <div class="col-2 text-start">
                                                <!--color depending on the status -->
                                                @if($transaction->payment_status === 'Unpaid')
                                                <span class="text-danger fw-bold">Unpaid</span>
                                                @elseif($latestPaymentProof->payment_type === 'Partial Payment' && $transaction->payment_status === 'Pending' )

                                                <!-- Pending Partial Payment Confirmation -->
                                                <div class="d-flex flex-column justify-content-center align-items-center">
                                                    <span class="text-muted fw-bold">Partially Paid - ₱{{$amountpaidTotal}}</span>
                                                    <small class="text-muted">(pending)</small>
                                                </div>

                                                @elseif($transaction->payment_status === 'Partially Paid')
                                                <span class="text-primary fw-bold">Partially Paid - ₱{{$amountpaidTotal}}</span>

                                                <!-- Pending Full Payment Confirmation -->
                                                @elseif($latestPaymentProof->payment_type === 'Full Payment' && $transaction->payment_status === 'Pending')
                                                <div class="d-flex flex-column justify-content-center align-items-center">
                                                    <span class="text-muted fw-bold">Fully Paid - ₱{{$amountpaidTotal}}</span>
                                                    <small class="text-muted">(pending)</small>
                                                </div>
                                                @elseif($transaction->payment_status === 'Fully Paid')
                                                <span class="text-success fw-bold">Fully Paid</span>
                                                @endif
                                            </div>
                                            <div class="col-2 d-flex ms-2 align-items-center">
                                                <!--confirm button to confirm payment-->
                                                @if($transaction->payment_status === 'Unpaid')
                                                <span class="text-danger fw-bold">Unpaid</span>

                                                @elseif($transaction->payment_status === 'Partially Paid')
                                                <span class="text-primary fw-bold">Partially Paid</span>

                                                @elseif($latestPaymentProof->payment_type === 'Partial Payment')
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#confirmpaymentmodal-{{ $transaction->transaction_id }}"
                                                    data-paymentproof="{{ $latestPaymentProof->proof_id }}"
                                                    class="btn-verify rounded py-1 px-3 ">Confirm</button>

                                                @elseif($transaction->payment_status === 'Fully Paid')
                                                <span class="text-success fw-bold">Fully Paid</span>

                                                @elseif($latestPaymentProof->payment_type === 'Full Payment')
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#confirmpaymentmodal-{{ $transaction->transaction_id }}"
                                                    data-paymentproof="{{ $latestPaymentProof->proof_id }}"
                                                    class="btn-verify rounded py-1 px-3 ">Confirm</button>
                                                @endif
                                            </div>

                                            @if($transaction->payment_proofs->isNotEmpty())
                                            <div class="col-1 d-flex justify-content-center">
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#receiptModal{{ $transaction->transaction_id }}"
                                                    class="btn btn-outline-secondary btn-sm position-relative" style="white-space: nowrap;">
                                                    <i class="fas fa-receipt me-2"></i>View Receipt
                                                </a>
                                            </div>
                                            @else
                                            <div class="col-1">
                                                <small class=" text-center text-muted text-nowrap">No receipt yet</small>
                                            </div>
                                            @endif

                                            <div class="col-2 d-flex justify-content-end">
                                                @if($transaction->transaction_status !== 'Done')
                                                <button type="button"
                                                    class="btn btn-outline-secondary btn-sm btn-fit-width"
                                                    data-bs-toggle="modal" data-bs-target="#writeReviewModal_{{$transaction->transaction_id}}"
                                                    @if($transaction->payment_status !== 'Fully Paid') disabled @endif>
                                                    Write a Review
                                                </button>
                                                @elseif($transaction->transaction_status === 'Done' || $madeaReview)
                                                <button type="button" class="btn btn-outline-secondary btn-sm btn-fit-width"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#reviewModal_{{$transaction->transaction_id}}">View Review</button>
                                                @endif
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


                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                </tbody>
            </table>
            @else
            <p>No on-going transactions.</p>
            @endif
        </div>

        <!-- UPCOMING Tab --------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="tab-pane" id="upcoming">
            @if($upcoming->isNotEmpty())
            <!-- Table for larger screens -->
            <table id="unique-payment-table" class="table table-borderless d-none d-md-table mt-3">
                <thead class="table-primary poppins-extralight">
                    <tr>
                        <th style="width: 10%;"></th>
                        <th style="width: 12%;"></th>
                        <th style="width: 17%;">Payment Amount</th>
                        <th style="width: 17%;">Payment Status</th>
                        <th style="width: 15%;">Confirmation</th>
                        <th style="width: 18%;">Payment Proof</th>
                        <th style="width: 11%;"></th>
                    </tr>
                </thead>
                <tbody>

                    <!--Loop through each project-->
                    @foreach($upcoming as $transaction)

                    <tr style="border:none;">
                        <td colspan="7" class="p-0">
                            <div class="card mb-1 mt-3">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <div class="me-auto">
                                        <small>{{$transaction->event->start_date->format('M j Y, h:i A')}} - {{$transaction->event->end_date->format('M j Y, h:i A')}}</small>
                                    </div>
                                    <div class="flex-grow-1 text-center poppins-medium">
                                        <span>{{$transaction->event->title}}</span>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="{{route('client-viewpost', [ 'id' => $transaction->event->event_id] )}}" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration:none;">View Post</a>
                                    </div>
                                </div>
                                <div class="card-body">

                                    @if($transaction->payment_proofs->isNotEmpty())
                                    @php
                                    // Find the latest payment proof
                                    $amountpaidTotal = $transaction->payment_proofs->sum('amount_paid');
                                    $latestPaymentProof = $transaction->payment_proofs->sortByDesc('created_at')->first();
                                    @endphp
                                    @endif

                                    <div class="row align-items-center mb-2">
                                        <div class="col-auto pe-1">
                                            <img src="{{asset($transaction->client->user->profile_image)}}" class="rounded-circle">
                                        </div>
                                        <div class="col-2 pe-4">
                                            <div class="d-flex flex-column align-items-start">
                                                <div>{{$transaction->client->user->first_name}} {{$transaction->client->user->last_name}}</div>
                                            </div>
                                        </div>
                                        <div class="col-2 text-left">₱ {{$transaction->payment_amount}}</div>

                                        <div class="col-2 text-start">
                                            <!--color depending on the status -->
                                            @if($transaction->payment_status === 'Unpaid')
                                            <span class="text-danger fw-bold">Unpaid</span>
                                            @elseif($latestPaymentProof->payment_type === 'Partial Payment' && $transaction->payment_status === 'Pending' )
                                            <!-- Pending Partial Payment Confirmation -->
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <span class="text-muted fw-bold">Partially Paid - ₱{{$amountpaidTotal}}</span>
                                                <small class="text-muted">(pending)</small>
                                            </div>

                                            @elseif($transaction->payment_status === 'Partially Paid')
                                            <span class="text-primary fw-bold">Partially Paid - ₱{{$amountpaidTotal}}</span>

                                            <!-- Pending Full Payment Confirmation -->
                                            @elseif($latestPaymentProof->payment_type === 'Full Payment' && $transaction->payment_status === 'Pending')
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <span class="text-muted fw-bold">Fully Paid - ₱{{$amountpaidTotal}}</span>
                                                <small class="text-muted">(pending)</small>
                                            </div>
                                            @elseif($transaction->payment_status === 'Fully Paid')
                                            <span class="text-success fw-bold">Fully Paid</span>
                                            @endif
                                        </div>
                                        <div class="col-2 d-flex ms-2 align-items-center">
                                            <!--confirm button to confirm payment-->
                                            @if($transaction->payment_status === 'Unpaid')
                                            <span class="text-danger fw-bold">Unpaid</span>

                                            @elseif($transaction->payment_status === 'Partially Paid')
                                            <span class="text-primary fw-bold">Partially Paid</span>

                                            @elseif($latestPaymentProof->payment_type === 'Partial Payment')
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#confirmpaymentmodal-{{ $transaction->transaction_id }}"
                                                data-paymentproof="{{ $latestPaymentProof->proof_id }}"
                                                class="btn-verify rounded py-1 px-3 ">Confirm</button>

                                            @elseif($transaction->payment_status === 'Fully Paid')
                                            <span class="text-success fw-bold">Fully Paid</span>

                                            @elseif($latestPaymentProof->payment_type === 'Full Payment')
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#confirmpaymentmodal-{{ $transaction->transaction_id }}"
                                                data-paymentproof="{{ $latestPaymentProof->proof_id }}"
                                                class="btn-verify rounded py-1 px-3 ">Confirm</button>
                                            @endif
                                        </div>

                                        @if($transaction->payment_proofs->isNotEmpty())
                                        <div class="col-1 d-flex justify-content-center">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#receiptModal{{ $transaction->transaction_id }}"
                                                class="btn btn-outline-secondary btn-sm position-relative" style="white-space: nowrap;">
                                                <i class="fas fa-receipt me-2"></i>View Receipt
                                            </a>
                                        </div>
                                        @else
                                        <div class="col-1">
                                            <small class=" text-start text-muted text-nowrap">No receipt yet</small>
                                        </div>
                                        @endif

                                        @php
                                        $madeaReview = $transaction->reviews()->where('reviewee_role', 'client')->exists() ?? false;
                                        @endphp

                                        <div class="col-2 d-flex justify-content-end">
                                            @if($transaction->transaction_status !== 'Done')
                                            <button type="button"
                                                class="btn btn-outline-secondary btn-sm btn-fit-width"
                                                data-bs-toggle="modal" data-bs-target="#writeReviewModal_{{$transaction->transaction_id}}"
                                                @if($transaction->payment_status !== 'Fully Paid') disabled @endif>
                                                Write a Review
                                            </button>
                                            @elseif($transaction->transaction_status === 'Done' || $madeaReview)
                                            <button type="button" class="btn btn-outline-secondary btn-sm btn-fit-width"
                                                data-bs-toggle="modal"
                                                data-bs-target="#reviewModal_{{$transaction->transaction_id}}">View Review</button>
                                            @endif

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

                                    </div>

                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>No upcoming transactions.</p>
            @endif
        </div>

        <!-- HISTORY Tab ----------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="tab-pane" id="history">
            @if($previous->isNotEmpty())
            <!-- Table for larger screens -->
            <table id="unique-payment-table" class="table table-borderless d-none d-md-table mt-3">
                <thead class="table-primary poppins-extralight">
                    <tr>
                        <th style="width: 10%;"></th>
                        <th style="width: 12%;"></th>
                        <th style="width: 17%;">Payment Amount</th>
                        <th style="width: 15%;">Confirmation</th>
                        <th style="width: 18%;">Payment Status</th>
                        <th style="width: 17%;" class="text-wrap">Payment Proof</th>
                        <th style="width: 11%;"></th>
                    </tr>
                </thead>
                <tbody>

                    <!--Loop through each project-->
                    @foreach($previous as $transaction)



                    <tr style="border:none;">
                        <td colspan="7" class="p-0">
                            <div class="card mb-1 mt-3">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <div class="me-auto">
                                        <small>{{$transaction->event->start_date->format('M j Y, h:i A')}} - {{$transaction->event->end_date->format('M j Y, h:i A')}}</small>
                                    </div>
                                    <div class="flex-grow-1 text-center poppins-medium">
                                        <span>{{$transaction->event->title}}</span>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="{{route('client-viewpost', [ 'id' => $transaction->event->event_id] )}}" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration:none;">View Post</a>
                                    </div>
                                </div>
                                <div class="card-body">

                                    @php
                                    $madeaReview = $transaction->reviews()->where('reviewee_role', 'client')->exists() ?? false;
                                    @endphp

                                    <div class="row align-items-center mb-2">
                                        <div class="col-auto pe-1">
                                            <img src="{{asset($transaction->client->user->profile_image)}}" class="rounded-circle">
                                        </div>
                                        <div class="col-2 pe-4">
                                            <div class="d-flex flex-column align-items-start">
                                                <div>{{$transaction->client->user->first_name}} {{$transaction->client->user->last_name}}</div>
                                            </div>
                                        </div>
                                        <div class="col-2 text-left">₱ {{$transaction->payment_amount}}</div>

                                        <div class="col-2 d-flex align-items-center">
                                            <span class="text-success">{{$transaction->payment_status}}</span>
                                        </div>
                                        <div class="col-2 text-success">{{$transaction->payment_status}}</div>

                                        @if($transaction->payment_proofs->isNotEmpty())
                                        <div class="col-1 d-flex justify-content-center">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#receiptModal{{ $transaction->transaction_id }}"
                                                class="btn btn-outline-secondary btn-sm position-relative" style="white-space: nowrap;">
                                                <i class="fas fa-receipt me-2"></i>View Receipt
                                            </a>
                                        </div>

                                        <!-- modal for viewing receipt-->
                                        @include('modals.Transaction.view_receipt',
                                        ['transactionId' => $transaction->transaction_id,
                                        'paymentProofs' => $transaction->payment_proofs])

                                        @endif

                                        <div class="col-2 d-flex justify-content-end">
                                           @if($transaction->transaction_status === 'Done' || $madeaReview)
                                            <button type="button" class="btn btn-outline-secondary btn-sm btn-fit-width"
                                                data-bs-toggle="modal"
                                                data-bs-target="#reviewModal_{{$transaction->transaction_id}}">View Review</button>
                                            @endif

                                        </div>

                                        @php
                                        $reviewee_role = 'client';
                                        $reviewee = $transaction->client;
                                        $review = $transaction->reviews()->where('reviewee_role', 'client')->first(); //the freelancer's review
                                        @endphp

                                        <!--view review -->
                                        @if($madeaReview)
                                        @include('modals.Transaction.view_review', ['transaction_id' => $transaction->transaction_id,
                                        'reviewee_role' => $reviewee_role, 'reviewee' => $reviewee, 'review' => $review])
                                        @endif

                                    </div>

                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @else
            <p>No previous transactions.</p>
            @endif
        </div>
        @include('modals.f_review')
    </div>
</div>

@endsection