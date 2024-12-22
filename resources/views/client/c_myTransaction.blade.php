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

        <!-- ON-GOING Tab ----------------------------------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="tab-pane show active" id="ongoing">
            @if($transactionsByEvent['ongoing']->isNotEmpty())

            <!-- Responsive Card Layout for Ongoing Transactions -->
            <div class="row g-4 my-2 pb-4 d-block">
                <!-- Loop through the on-going events -->
                @foreach($transactionsByEvent['ongoing'] as $eventGroup)
                @php
                $event = $eventGroup['event'];
                $hasOngoingTransaction = $eventGroup['transactions']->contains(fn($transaction) => $transaction->transaction_status === 'Ongoing');
                $unsettledPayment = $eventGroup['transactions']->contains(fn($transaction) => $transaction->payment_status !== 'Fully Paid');
                $noReview = $eventGroup['transactions']->contains(fn($transaction) =>
                !$transaction->reviews()->whereIn('reviewee_role', ['freelancer', 'team'])->exists()
                );
                $isDue = $event->end_date < \Carbon\Carbon::now() && $hasOngoingTransaction;
                    @endphp

                    <!-- Card for Each Event Group -->
                    <div class="col">
                        <div class="card rounded-4 h-100" style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                            <div class="card-header d-flex align-items-center rounded-top-4" style="background-color: #FCF2F9;">
                                <div class="row align-items-center w-100">
                                    <!-- Title and Date Column -->
                                    <div class="col">
                                        <span class="fs-5 me-2 poppins-medium">{{ $event->title }}</span>

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

                                        <small class="text-muted d-block mt-1">{{ $event->start_date_formatted }} - {{ $event->end_date_formatted }}</small>
                                    </div>
                                    <div class="col-auto ms-auto">
                                        <a href="{{ route('client-viewpost', ['id' => $event->event_id]) }}" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration: none;">
                                            View Post
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                @foreach($eventGroup['transactions'] as $transaction)
                                <div class="mb-3">

                                    @if($transaction->team_code)
                                    <!--for team-->
                                    <div class="d-lg-flex">
                                        <!-- Team Information Section -->
                                        <div class="d-flex me-2 align-items-center w-100">
                                            <a href="{{route('team-profile-view', ['id' => $transaction->team->team_id])}}"><img src="{{ asset('storage/' . $transaction->team->team_profilepic) }}" class="rounded-circle mx-2" alt="Team Image" width="50" height="50"></a>
                                            <div>
                                                <div class="row">
                                                    <span class="mb-0">{{ $transaction->team->team_name }} (Team)</span>
                                                    <span><small class="text-muted">Members: {{$transaction->team->membersAtTransactionTime($transaction->created_at)->count()}}</small></span>
                                                </div>
                                                <div class="row">
                                                    <span class="text-muted ">{{ $transaction->team->package_service }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Payment Information Section -->
                                        <div class="col-lg-9 col-15 mt-3 mt-lg-0 me-lg-2 d-lg-flex">
                                            <table class="table table-borderless my-2 w-lg-100 me-lg-4">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th class="note" style="white-space: nowrap;">Amount</th>
                                                        <th class="note" style="white-space: nowrap;">Status</th>
                                                        <th class="note" style="white-space: nowrap;">Payment Proof</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="text-center">
                                                        <td>₱ {{ $transaction->payment_amount }}</td>

                                                        @php
                                                        $amountpaidTotal = $transaction->payment_proofs->sum('amount_paid');
                                                        $latestPaymentProof = $transaction->payment_proofs->sortByDesc('created_at')->first();
                                                        if ($transaction->team_code) {
                                                        // Check if a review exists for the team
                                                        $madeaReview = $transaction->reviews()->where('reviewee_role', 'team')->exists();
                                                        } else {
                                                        // Check if a review exists for the freelancer
                                                        $madeaReview = $transaction->reviews()->where('reviewee_role', 'freelancer')->exists();
                                                        }
                                                        @endphp

                                                        <td>{!! getPaymentStatus($transaction) !!}</td>

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

                                            <!-- Review and Upload buttons-->
                                            <div class="d-flex mt-2 justify-content-center align-items-center">
                                                <button class="confirm btn-sm me-2" style="white-space: nowrap; background-color: white; border: 1px solid darkgray; color:#000;" data-bs-toggle="modal" data-bs-target="#uploadPaymentProofModal{{ $transaction->transaction_id }}" @if($transaction->payment_status === 'Fully Paid') disabled @endif>
                                                    <i class="fas fa-upload me-2"></i>Upload Proof
                                                </button>

                                                @if($transaction->transaction_status !== 'Done' && $madeaReview === false)
                                                <button type="button" class="btn-round btn-sm" style="background-color: white; border: 1px solid darkgray;"
                                                    data-bs-toggle="modal" data-bs-target="#writeReviewModal_{{$transaction->transaction_id}}"
                                                    @if($transaction->payment_status !== 'Fully Paid') disabled @endif>Write a Review</button>
                                                @elseif($madeaReview || $transaction->transaction_status === 'Done' )
                                                <button type="button" class="btn-round btn-sm" style="background-color: white; border: 1px solid darkgray;"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#reviewModal_{{$transaction->transaction_id}}">View Review</button>
                                                @endif
                                            </div>
                                        </div>

                                    </div>

                                    @elseif($transaction->freelancer_id)
                                    <!--for solo-->
                                    <div class="flex-grow-1 d-lg-flex">
                                        <!-- Solo Freelancer Information Section -->
                                        <div class="d-flex me-2 align-items-center w-100">
                                            <a href="{{route('view-freelancer-profile', ['id' => $transaction->freelancer->user_id])}}">
                                                <img src="{{ asset($transaction->freelancer->user->profile_image_url) }}" class="rounded-circle mx-2" alt="Freelancer Image" width="50" height="50">
                                            </a>
                                            <div>
                                                <div class="row">
                                                    <span>{{ $transaction->freelancer->user->first_name }} {{ $transaction->freelancer->user->last_name }}</span>
                                                </div>
                                                <div class="row">
                                                    <span class="text-muted">{{ $transaction->Hiring_request->serviceDetails()->job_title }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Payment Information Section -->
                                        <div class="col-lg-9 col-15 mt-3 mt-lg-0 me-lg-2 d-lg-flex">
                                            <table class="table table-borderless my-2 w-lg-100 me-lg-4">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th class="note" style="white-space: nowrap;">Amount</th>
                                                        <th class="note" style="white-space: nowrap;">Status</th>
                                                        <th class="note" style="white-space: nowrap;">Payment Proof</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="text-center">
                                                        <td>₱ {{ $transaction->payment_amount }}</td>

                                                        @php
                                                        $amountpaidTotal = $transaction->payment_proofs->sum('amount_paid');
                                                        $latestPaymentProof = $transaction->payment_proofs->sortByDesc('created_at')->first();
                                                        $madeaReview = $transaction->reviews()->where('reviewee_role', 'freelancer')->exists();
                                                        @endphp

                                                        <td>{!! getPaymentStatus($transaction) !!}</td>

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

                                            <!-- Review and Upload buttons-->
                                            <div class="d-flex mt-2 justify-content-center align-items-center">
                                                <button class="confirm btn-sm me-2" style="white-space: nowrap; background-color: white; border: 1px solid darkgray; color:#000;" data-bs-toggle="modal" data-bs-target="#uploadPaymentProofModal{{ $transaction->transaction_id }}" @if($transaction->payment_status === 'Fully Paid') disabled @endif>
                                                    <i class="fas fa-upload me-2"></i>Upload Proof
                                                </button>

                                                @if($transaction->transaction_status !== 'Done' && $madeaReview === false)
                                                <button type="button" class="btn-round btn-sm" style="background-color: white; border: 1px solid darkgray;"
                                                    data-bs-toggle="modal" data-bs-target="#writeReviewModal_{{$transaction->transaction_id}}"
                                                    @if($transaction->payment_status !== 'Fully Paid') disabled @endif>Write a Review</button>
                                                @elseif($madeaReview || $transaction->transaction_status === 'Done' )
                                                <button type="button" class="btn-round btn-sm" style="background-color: white; border: 1px solid darkgray;"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#reviewModal_{{$transaction->transaction_id}}">View Review</button>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                    @endif


                                    <div class="m-3">
                                        <!-- For members -->
                                        @if($transaction->members->isNotEmpty())
                                        <p>Members:</p>
                                        <!-- Container for members that will be grid-based -->
                                        <div class="row">
                                            <!-- Loop through each member -->
                                            @foreach($transaction->members as $member)
                                            <div class="m-1 col-lg-3 col-md-5 rounded-4 p-2">
                                                <div class=" member-info d-flex justify-content-start align-items-start ms-1">
                                                    <a href="{{route('view-freelancer-profile', ['id' => $member->freelancer->user_id])}}">
                                                        <img src="{{$member->freelancer->user->profile_image_url}}" alt="Member" style="margin-right: 10px; max-width: 30px; max-height: 30px; object-fit: cover;">
                                                    </a>
                                                    <div>
                                                        <div class="col" style="white-space: nowrap;">
                                                            <span class="mb-0 fs-small">{{$member->freelancer->user->fullname()}}</span>

                                                        </div>
                                                        <div class="col-auto gap-1 ms-0">
                                                            @foreach($member->freelancer->offeredTeamServices() as $service)
                                                            <span class="badge rounded-pill my-1" style="background-color:#91216c;">{{$service->job_title}}</span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Modals for receipts, payment proof, and reviews -->
                                    @include('modals.Transaction.view_receipt', ['transactionId' => $transaction->transaction_id, 'paymentProofs' => $transaction->payment_proofs])
                                    @include('modals.Transaction.upload_payment_proof', ['uniqueId' => $transaction->transaction_id])


                                    <!--write review -->
                                    @php
                                    if ($transaction->team_code) {
                                    // Team transaction
                                    $reviewee_role = 'team';
                                    $reviewee = $transaction->team;
                                    $review = $transaction->reviews()->where('reviewee_role', 'team')->first();
                                    } else {
                                    // Solo freelancer transaction
                                    $reviewee_role = 'freelancer';
                                    $reviewee = $transaction->freelancer; // Assuming $transaction has a relationship to Freelancer
                                    $review = $transaction->reviews()->where('reviewee_role', 'freelancer')->first();
                                    }
                                    @endphp

                                    <!-- Write review modal -->
                                    @include('modals.Transaction.write_review', [
                                    'transaction_id' => $transaction->transaction_id,
                                    'reviewee_role' => $reviewee_role,
                                    'reviewee' => $reviewee
                                    ])

                                    @include('modals.Transaction.write_review', ['transaction_id' => $transaction->transaction_id,
                                    'reviewee_role' => $reviewee_role, 'reviewee' => $reviewee])

                                    <!--view review -->
                                    @if($madeaReview)
                                    @include('modals.Transaction.view_review', ['transaction_id' => $transaction->transaction_id,
                                    'reviewee_role' => $reviewee_role, 'reviewee' => $reviewee, 'review' => $review])
                                    @endif
                                    @if (!$loop->last)
                                    <hr class="my-3" style="margin-bottom: 0; border: 1px solid #ddd;">
                                    @endif

                                </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                    @endforeach
            </div>
            @else
            <p>No ongoing transactions.</p>
            @endif
        </div>

        <!-- UPCOMING Tab ---------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="tab-pane" id="upcoming">
            @if($transactionsByEvent['upcoming']->isNotEmpty())
            <!-- Responsive Card Layout for Upcoming Transactions -->
            <div class="row g-4 my-2 pb-4 d-block">
                <!-- Loop through the upcoming events -->
                @foreach($transactionsByEvent['upcoming'] as $eventGroup)
                @php
                $event = $eventGroup['event'];
                $hasUpcomingTransaction = $eventGroup['transactions']->contains(fn($transaction) => $transaction->transaction_status === 'Upcoming');
                $unsettledPayment = $eventGroup['transactions']->contains(fn($transaction) => $transaction->payment_status !== 'Fully Paid');
                $noReview = $eventGroup['transactions']->contains(fn($transaction) =>
                !$transaction->reviews()->whereIn('reviewee_role', ['freelancer', 'team'])->exists()
                );
                $isDue = $event->end_date < \Carbon\Carbon::now() && $hasUpcomingTransaction;
                    @endphp

                    <!-- Card for Each Event Group -->
                    <div class="col">
                        <div class="card rounded-4 h-100" style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                            <div class="card-header d-flex align-items-center rounded-top-4" style="background-color: #FCF2F9;">
                                <div class="row align-items-center w-100">
                                    <!-- Title and Date Column -->
                                    <div class="col">
                                        <span class="fs-5 me-2 poppins-medium">{{ $event->title }}</span>
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

                                        <small class="text-muted d-block mt-1">{{ $event->start_date_formatted }} - {{ $event->end_date_formatted }}</small>
                                    </div>
                                    <div class="col-auto ms-auto">
                                        <a href="{{ route('client-viewpost', ['id' => $event->event_id]) }}" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration: none;">
                                            View Post
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                @foreach($eventGroup['transactions'] as $transaction)
                                <div class="mb-3">

                                    @if($transaction->team_code)
                                    <!--for team-->
                                    <div class="flex-grow-1 d-lg-flex">
                                        <!-- Team Information Section -->
                                        <div class="d-flex me-2 align-items-center w-100">
                                            <a href="{{route('team-profile-view', ['id' => $transaction->team->team_id])}}"><img src="{{ asset('storage/' . $transaction->team->team_profilepic) }}" class="rounded-circle mx-2" alt="Team Image" width="50" height="50"></a>
                                            <div>

                                                <div class="row">
                                                    <span class="mb-0">{{ $transaction->team->team_name }} (Team)</span>
                                                    <span><small class="text-muted">Members: {{$transaction->team->membersAtTransactionTime($transaction->created_at)->count()}}</small></span>
                                                </div>
                                                <div class="row">
                                                    <span class="text-muted ">{{ $transaction->team->package_service }}</span>
                                                </div>
                                                <hr class="my-2">
                                            </div>
                                        </div>

                                        <!-- Payment Information Section -->
                                        <div class="col-lg-9 col mt-3 mt-lg-0 me-lg-2 d-lg-flex">
                                            <table class="table table-borderless">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th class="note" style="white-space: nowrap;">Amount</th>
                                                        <th class="note" style="white-space: nowrap;">Status</th>
                                                        <th class="note" style="white-space: nowrap;">Payment Proof</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="text-center">
                                                        <td>₱ {{ $transaction->payment_amount }}</td>

                                                        @php
                                                        $amountpaidTotal = $transaction->payment_proofs->sum('amount_paid');
                                                        $latestPaymentProof = $transaction->payment_proofs->sortByDesc('created_at')->first();
                                                        if ($transaction->team_code) {
                                                        // Check if a review exists for the team
                                                        $madeaReview = $transaction->reviews()->where('reviewee_role', 'team')->exists();
                                                        } else {
                                                        // Check if a review exists for the freelancer
                                                        $madeaReview = $transaction->reviews()->where('reviewee_role', 'freelancer')->exists();
                                                        }
                                                        @endphp

                                                        <td>{!! getPaymentStatus($transaction) !!}</td>

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

                                            <!-- Review and Upload buttons-->
                                            <div class="d-flex mt-2 justify-content-center align-items-center">
                                                <button class="confirm btn-sm me-2" style="white-space: nowrap; background-color: white; border: 1px solid darkgray; color:#000;" data-bs-toggle="modal" data-bs-target="#uploadPaymentProofModal{{ $transaction->transaction_id }}" @if($transaction->payment_status === 'Fully Paid') disabled @endif>
                                                    <i class="fas fa-upload me-2"></i>Upload Proof
                                                </button>

                                                @if($transaction->transaction_status !== 'Done' && $madeaReview === false)
                                                <button type="button" class="btn-round btn-sm" style="background-color: white; border: 1px solid darkgray;"
                                                    data-bs-toggle="modal" data-bs-target="#writeReviewModal_{{$transaction->transaction_id}}"
                                                    @if($transaction->payment_status !== 'Fully Paid') disabled @endif>Write a Review</button>
                                                @elseif($madeaReview || $transaction->transaction_status === 'Done' )
                                                <button type="button" class="btn-round btn-sm" style="background-color: white; border: 1px solid darkgray;"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#reviewModal_{{$transaction->transaction_id}}">View Review</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>



                                    @elseif($transaction->freelancer_id)
                                    <!--for solo-->
                                    <div class="flex-grow-1 d-lg-flex">
                                        <!-- Solo Freelancer Information Section -->
                                        <div class="d-flex me-2 align-items-center w-100">
                                            <a href="{{route('view-freelancer-profile', ['id' => $transaction->freelancer->user_id])}}">
                                                <img src="{{ asset($transaction->freelancer->user->profile_image_url) }}" class="rounded-circle mx-2" alt="Freelancer Image" width="50" height="50">
                                            </a>
                                            <div>
                                                <div class="row">
                                                    <span>{{ $transaction->freelancer->user->first_name }} {{ $transaction->freelancer->user->last_name }}</span>
                                                </div>
                                                <div class="row">
                                                    <span class="text-muted">{{ $transaction->Hiring_request->serviceDetails()->job_title }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Payment Information Section -->
                                        <div class="col-lg-9 col-15 mt-3 mt-lg-0 me-lg-2 d-lg-flex">
                                            <table class="table table-borderless my-2 w-lg-100 me-lg-4">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th class="note" style="white-space: nowrap;">Amount</th>
                                                        <th class="note" style="white-space: nowrap;">Status</th>
                                                        <th class="note" style="white-space: nowrap;">Payment Proof</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="text-center">
                                                        <td>₱ {{ $transaction->payment_amount }}</td>

                                                        @php
                                                        $amountpaidTotal = $transaction->payment_proofs->sum('amount_paid');
                                                        $latestPaymentProof = $transaction->payment_proofs->sortByDesc('created_at')->first();
                                                        $madeaReview = $transaction->reviews()->where('reviewee_role', 'freelancer')->exists();
                                                        @endphp

                                                        <td>{!! getPaymentStatus($transaction) !!}</td>

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

                                            <!-- Review and Upload buttons-->
                                            <div class="d-flex mt-2 justify-content-center align-items-center">
                                                <button class="confirm btn-sm me-2" style="white-space: nowrap; background-color: white; border: 1px solid darkgray; color:#000;" data-bs-toggle="modal" data-bs-target="#uploadPaymentProofModal{{ $transaction->transaction_id }}" @if($transaction->payment_status === 'Fully Paid') disabled @endif>
                                                    <i class="fas fa-upload me-2"></i>Upload Proof
                                                </button>

                                                @if($transaction->transaction_status !== 'Done' && $madeaReview === false)
                                                <button type="button" class="btn-round btn-sm" style="background-color: white; border: 1px solid darkgray;"
                                                    data-bs-toggle="modal" data-bs-target="#writeReviewModal_{{$transaction->transaction_id}}"
                                                    @if($transaction->payment_status !== 'Fully Paid') disabled @endif>Write a Review</button>
                                                @elseif($madeaReview || $transaction->transaction_status === 'Done' )
                                                <button type="button" class="btn-round btn-sm" style="background-color: white; border: 1px solid darkgray;"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#reviewModal_{{$transaction->transaction_id}}">View Review</button>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                    @endif


                                    <div class="m-3">
                                        <!-- For members -->
                                        @if($transaction->members->isNotEmpty())
                                        <p>Members:</p>
                                        <!-- Container for members that will be grid-based -->
                                        <div class="row">
                                            <!-- Loop through each member -->
                                            @foreach($transaction->members as $member)
                                            <div class="m-1 col-lg-3 col-md-5 rounded-4 p-2">
                                                <div class=" member-info d-flex justify-content-start align-items-start ms-1">

                                                    <a href="{{route('view-freelancer-profile', ['id' => $member->freelancer->user_id])}}">
                                                        <img src="{{$member->freelancer->user->profile_image_url}}" alt="Member" style="margin-right: 10px; max-width: 30px; max-height: 30px; object-fit: cover;">
                                                    </a>
                                                    <div>
                                                        <div class="col" style="white-space: nowrap;">
                                                            <span class="mb-0 fs-small">{{$member->freelancer->user->fullname()}}</span>

                                                        </div>
                                                        <div class="col-auto gap-1 ms-0">
                                                            @foreach($member->freelancer->offeredTeamServices() as $service)
                                                            <span class="badge rounded-pill my-1" style="background-color:#91216c;">{{$service->job_title}}</span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>


                                    <!-- Modals for receipts, payment proof, and reviews -->
                                    @include('modals.Transaction.view_receipt', ['transactionId' => $transaction->transaction_id, 'paymentProofs' => $transaction->payment_proofs])
                                    @include('modals.Transaction.upload_payment_proof', ['uniqueId' => $transaction->transaction_id])


                                    <!--write review -->
                                    @php
                                    if ($transaction->team_code) {
                                    // Team transaction
                                    $reviewee_role = 'team';
                                    $reviewee = $transaction->team;
                                    $review = $transaction->reviews()->where('reviewee_role', 'team')->first();
                                    } else {
                                    // Solo freelancer transaction
                                    $reviewee_role = 'freelancer';
                                    $reviewee = $transaction->freelancer; // Assuming $transaction has a relationship to Freelancer
                                    $review = $transaction->reviews()->where('reviewee_role', 'freelancer')->first();
                                    }
                                    @endphp

                                    <!-- Write review modal -->
                                    @include('modals.Transaction.write_review', [
                                    'transaction_id' => $transaction->transaction_id,
                                    'reviewee_role' => $reviewee_role,
                                    'reviewee' => $reviewee
                                    ])

                                    @include('modals.Transaction.write_review', ['transaction_id' => $transaction->transaction_id,
                                    'reviewee_role' => $reviewee_role, 'reviewee' => $reviewee])

                                    <!--view review -->
                                    @if($madeaReview)
                                    @include('modals.Transaction.view_review', ['transaction_id' => $transaction->transaction_id,
                                    'reviewee_role' => $reviewee_role, 'reviewee' => $reviewee, 'review' => $review])
                                    @endif
                                    @if (!$loop->last)
                                    <hr class="my-3" style="margin-bottom: 0; border: 1px solid #ddd;">
                                    @endif

                                </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                    @endforeach
            </div>
            @else
            <p>No upcoming transactions.</p>
            @endif
        </div>

        <!-- HISTORY Tab ----------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="tab-pane" id="history">
            @if($transactionsByEvent['previous']->isNotEmpty())

            <!-- Responsive Card Layout for Previous Transactions -->
            <div class="row g-4 my-2 pb-4 d-block">
                <!-- Loop through previous events -->
                @foreach($transactionsByEvent['previous'] as $eventGroup)
                @php
                $event = $eventGroup['event'];
                @endphp

                <!-- Card for Each Event Group -->
                <div class="col">
                    <div class="card rounded-4 h-100" style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                        <div class="card-header d-flex align-items-center round-top-4" style="background-color: #FCF2F9;">
                            <div class="row align-items-center w-100">
                                <!-- Title and Date Column -->
                                <div class="col">
                                    <span class="fs-5 me-2 poppins-medium">{{ $event->title }}</span>
                                    <!-- Date below Title -->
                                    <small class="text-muted d-block mt-1">{{ $event->start_date_formatted }} - {{ $event->end_date_formatted }}</small>
                                </div>

                                <!-- "View Post" link aligned to the far right -->
                                <div class="col-auto ms-auto">
                                    <a href="{{ route('client-viewpost', ['id' => $event->event_id]) }}" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration: none;">
                                        View Post
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            @foreach($eventGroup['transactions'] as $transaction)
                            <div class="d-flex align-items-start mb-3">
                                <div class="flex-grow-1 d-lg-flex">
                                    <!-- Freelancer Information Section -->
                                    <div class="d-flex me-2 align-items-center w-100">
                                        @if($transaction->freelancer)
                                        <a href="{{route('view-freelancer-profile', ['id' => $transaction->freelancer->user_id])}}">
                                            <img src="{{ asset($transaction->freelancer->user->profile_image_url) }}" class="rounded-circle mx-2" alt="Freelancer Image" width="50" height="50">
                                        </a>
                                        @elseif($transaction->team)
                                        <img src="{{ asset('storage/' . $transaction->team->team_profilepic) }}" class="rounded-circle mx-2" alt="Freelancer Image" width="50" height="50">
                                        @endif
                                        <div>
                                            @if($transaction->freelancer)
                                            <div class="row">
                                                <span>{{ $transaction->freelancer->user->fullName()}}</span>
                                            </div>
                                            <div class="row">
                                                <span class="text-muted">{{ $transaction->Hiring_request->serviceDetails()->job_title }}</span>
                                            </div>
                                            @elseif($transaction->team)
                                            <div class="row">
                                                <span>{{ $transaction->team->team_name }}</span>
                                            </div>
                                            <div class="row">
                                                <span class="text-muted">{{ $transaction->team->package_service }}</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Payment Information Section -->
                                    <div class="col-lg-9 col-15 mt-3 mt-lg-0 me-lg-2 d-lg-flex">
                                        <table class="table table-borderless my-2 w-lg-100 me-lg-4">
                                            <thead>
                                                <tr class="text-center">
                                                    <th class="note" style="white-space: nowrap;">Amount</th>
                                                    <th class="note" style="white-space: nowrap;">Status</th>
                                                    <th class="note" style="white-space: nowrap;">Payment Proof</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <td>₱ {{ $transaction->payment_amount }}</td>

                                                    @php
                                                    $amountpaidTotal = $transaction->payment_proofs->sum('amount_paid');
                                                    $latestPaymentProof = $transaction->payment_proofs->sortByDesc('created_at')->first();
                                                    @endphp

                                                    <td>{!! getPaymentStatus($transaction) !!}</td>

                                                    <td>
                                                        @if($transaction->payment_proofs->isNotEmpty())
                                                        <a style="color: #91216C;" data-bs-toggle="modal" data-bs-target="#receiptModal{{ $transaction->transaction_id }}">
                                                            <i class="fas fa-receipt me-2"></i><u>Receipt/Proof</u>
                                                        </a>
                                                        @else
                                                        <small class=" text-center note text-nowrap">No receipt yet</small>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <!-- Review Button -->
                                        <div class="d-flex mt-2 justify-content-center align-items-center">
                                            <button class="confirm btn-sm" style="white-space: nowrap; background-color: white; border: 1px solid darkgray; color: black;" data-bs-toggle="modal" data-bs-target="#reviewModal_{{ $transaction->transaction_id }}">
                                                View Review
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="m-3">
                                <!-- For members -->
                                @if($transaction->members->isNotEmpty())
                                <p>Members:</p>
                                <!-- Container for members that will be grid-based -->
                                <div class="row">
                                    <!-- Loop through each member -->
                                    @foreach($transaction->members as $member)
                                    <div class="m-1 col-lg-3 col-md-5 rounded-4 p-2">
                                        <div class=" member-info d-flex justify-content-start align-items-start ms-1">
                                            <a href="{{route('view-freelancer-profile', ['id' => $member->freelancer->user_id])}}">
                                                <img src="{{$member->freelancer->user->profile_image_url}}" alt="Member" style="margin-right: 10px; max-width: 30px; max-height: 30px; object-fit: cover;">
                                            </a>
                                            <div>
                                                <div class="col" style="white-space: nowrap;">
                                                    <span class="mb-0 fs-small">{{$member->freelancer->user->fullname()}}</span>

                                                </div>
                                                <div class="col-auto gap-1 ms-0">
                                                    @foreach($member->freelancer->offeredTeamServices() as $service)
                                                    <span class="badge rounded-pill my-1" style="background-color:#91216c;">{{$service->job_title}}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>

                            <!--include modal for viewing receipt-->
                            @include('modals.Transaction.view_receipt',
                            ['transactionId' => $transaction->transaction_id,
                            'paymentProofs' => $transaction->payment_proofs])

                            <!--view review -->

                            @php
                            if ($transaction->team_code) {
                            // Team transaction
                            $reviewee_role = 'team';
                            $reviewee = $transaction->team;
                            $review = $transaction->reviews()->where('reviewee_role', 'team')->first();
                            } else {
                            // Solo freelancer transaction
                            $reviewee_role = 'freelancer';
                            $reviewee = $transaction->freelancer; // Assuming $transaction has a relationship to Freelancer
                            $review = $transaction->reviews()->where('reviewee_role', 'freelancer')->first();
                            }
                            @endphp

                            @include('modals.Transaction.view_review', ['transaction_id' => $transaction->transaction_id,
                            'reviewee_role' => $reviewee_role, 'reviewee' => $reviewee, 'review' => $review])
                            @if (!$loop->last)
                            <hr class="my-3" style="margin-bottom: 0; border: 1px solid #ddd;">
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p>No previous transactions.</p>
            @endif
        </div>

        <!-- Review Modal -->
        @include('modals.c_review')

    </div>
</div>

@endsection