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
            @if($transactionsByEvent['ongoing']->isNotEmpty())
            <!-- Table for larger screens -->
            <table id="unique-payment-table" class="table table-borderless d-none d-md-table mt-3">
                <thead class="table-primary poppins-extralight">
                    <tr>
                        <th style="width: 10%;"></th>
                        <th style="width: 13%;"></th>
                        <th style="width: 17%;">Payment Fee</th>
                        <th style="width: 23%;">Payment Status</th>
                        <th style="width: 14%;">Payment Proof</th>
                        <th style="width: 15%;"></th>
                    </tr>
                </thead>
                <tbody>

                    <!-- loop through the on-going events -->
                    @foreach($transactionsByEvent['ongoing'] as $eventGroup)
                    <tr style="border:none;">
                        <td colspan="7" class="p-0">
                            <div class="card mb-1 mt-3">
                                <div class="card-header poppins-medium d-flex justify-content-between align-items-center">
                                    <span class="fs-5">{{$eventGroup['event']->title}}</span>
                                    <span class="ms-3 text-muted">{{$eventGroup['event']->start_date_formatted}} - {{$eventGroup['event']->end_date_formatted}}</span>
                                    <a href="{{route('client-viewpost', [ 'id' => $eventGroup['event']->event_id] )}}" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration:none;">View Post</a>
                                </div>
                                <div class="card-body">
                                    <!-- loop the transactions -->
                                    @foreach($eventGroup['transactions'] as $transaction)
                                    <div class="row align-items-center mb-2">
                                        <div class="col-auto pe-1">
                                            <img src="{{asset($transaction->freelancer->user->profile_image)}}" class="rounded-circle">
                                        </div>
                                        <div class="col-2 pe-4">
                                            <div class="d-flex flex-column align-items-start">
                                                <div>{{$transaction->freelancer->user->first_name}} {{$transaction->freelancer->user->last_name}}</div>
                                                <small class="text-muted">{{$transaction->Hiring_request->serviceDetails()->job_title}}</small>
                                            </div>
                                        </div>
                                        <div class="col-2 text-left">₱ {{$transaction->payment_amount}}</div>
                                        <div class="col-2 d-flex justify-content-center align-items-center">

                                            <!--color depending on the status -->
                                            @if($transaction->payment_status === 'Unpaid')
                                            <span class="text-danger fw-bold">{{$transaction->payment_status}}</span>
                                            @elseif($transaction->payment_status === 'Pending')
                                            <span class="text-muted fw-bold">{{$transaction->payment_status}}</span>
                                            @elseif($transaction->payment_status === 'Partially Paid')
                                            <span class="text-primary fw-bold">{{$transaction->payment_status}}</span>
                                            @elseif($transaction->payment_status === 'Fully Paid')
                                            <span class="text-success fw-bold">{{$transaction->payment_status}}</span>
                                            @endif

                                        </div>
                                        <div class="col-2"></div>
                                        <div class="col-1 d-flex justify-content-center">
                                            <a href="#" class="btn btn-outline-secondary btn-sm position-relative" style="white-space: nowrap; border-bottom-right-radius: 0px; border-top-right-radius: 0px;">
                                                <i class="fas fa-receipt me-2"></i>View Receipt
                                            </a>
                                            <span class="upload-icon" style="background-color:#E1C1D7; padding: 0.2rem 0.5rem; border-bottom-right-radius: 4px; border-top-right-radius: 4px; z-index: 1; position: relative;">
                                                <button type="button" class="btn p-0 m-0" data-bs-toggle="modal" data-bs-target="#uploadPaymentProofModal{{ $transaction->transaction_id }}" style="z-index: 2; position: relative;">
                                                    <i class="fas fa-upload" style="color: #000;"></i>
                                                </button>
                                            </span>
                                        </div>

                                        <div class="col-2 d-flex justify-content-end">
                                            <button type="button" class="btn btn-outline-secondary btn-sm btn-fit-width" data-bs-toggle="modal" data-bs-target="#reviewClientModal">Write a Review</button>
                                        </div>
                                    </div>

                                    <!--Upload Payment Proof -->
                                    @include('modals.Transaction.upload_payment_proof', ['uniqueId' => $transaction->transaction_id])

                                    <hr class="my-3" style="margin-bottom: 0; border: 1px solid #ddd;">
                                    @endforeach
                                </div>
                            </div>
                        </td>
                    </tr>

                    @endforeach


                    @else
                    <p class="fs-5">No on-going transactions.</p>
                    @endif


                </tbody>
            </table>
        </div>

        <!-- UPCOMING Tab --------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="tab-pane" id="upcoming">
            @if($transactionsByEvent['upcoming']->isNotEmpty())
            <!-- Table for larger screens -->
            <table id="unique-payment-table" class="table table-borderless d-none d-md-table mt-3">
                <thead class="table-primary poppins-extralight">
                    <tr>
                        <th style="width: 10%;"></th>
                        <th style="width: 13%;"></th>
                        <th style="width: 17%;">Payment Fee</th>
                        <th style="width: 23%;">Payment Status</th>
                        <th style="width: 14%;">Payment Proof</th>
                        <th style="width: 15%;"></th>
                    </tr>
                </thead>
                <tbody>

                    <!-- loop through the upcoming events -->
                    @foreach($transactionsByEvent['upcoming'] as $eventGroup)
                    <tr style="border:none;">
                        <td colspan="7" class="p-0">
                            <div class="card mb-1 mt-3">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <div class="me-auto">
                                        <small>{{$eventGroup['event']->start_date_formatted}} - {{$eventGroup['event']->end_date_formatted}}</small>
                                    </div>
                                    <div class="flex-grow-1 text-center poppins-medium">
                                        <span class="fs-5">{{$eventGroup['event']->title}}</span>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="{{route('client-viewpost', [ 'id' => $eventGroup['event']->event_id] )}}" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration:none;">View Post</a>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <!--Loop through the upcoming -->
                                    @foreach($eventGroup['transactions'] as $transaction)
                                    <div class="row align-items-center mb-2">
                                        <div class="col-auto pe-1">
                                            <img src="{{asset($transaction->freelancer->user->profile_image)}}" class="rounded-circle">
                                        </div>
                                        <div class="col-2 pe-4">
                                            <div class="d-flex flex-column align-items-start">
                                                <div>{{$transaction->freelancer->user->first_name}} {{$transaction->freelancer->user->last_name}}</div>
                                                <small class="text-muted">{{$transaction->Hiring_request->serviceDetails()->job_title}}</small>
                                            </div>
                                        </div>
                                        <div class="col-2 text-left">₱ {{$transaction->payment_amount}}</div>
                                        <div class="col-2 d-flex  justify-content-center align-items-center">
                                            <!--color depending on the status -->
                                            @if($transaction->payment_status === 'Unpaid')
                                            <span class="text-danger fw-bold">{{$transaction->payment_status}}</span>
                                            @elseif($transaction->payment_status === 'Pending')
                                            <span class="text-muted fw-bold">{{$transaction->payment_status}}</span>
                                            @elseif($transaction->payment_status === 'Partially Paid')
                                            <span class="text-primary fw-bold">{{$transaction->payment_status}}</span>
                                            @elseif($transaction->payment_status === 'Fully Paid')
                                            <span class="text-success fw-bold">{{$transaction->payment_status}}</span>
                                            @endif

                                        </div>
                                        <div class="col-2"></div>
                                        <div class="col-1 d-flex justify-content-center">
                                            <a href="#" class="btn btn-outline-secondary btn-sm" style="white-space: nowrap;">
                                                <i class="fas fa-upload me-2"></i>Upload Receipt
                                            </a>
                                        </div>
                                        <div class="col-2 d-flex justify-content-end">
                                            <button class="btn btn-outline-secondary btn-sm btn-fit-width">Write a review</button>
                                        </div>
                                    </div>
                                    <hr class="my-3" style="margin-bottom: 0; border: 1px solid #ddd;">
                                    @endforeach
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <p class="fs-5">No upcoming transactions.</p>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- HISTORY Tab ----------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="tab-pane" id="history">
            @if($transactionsByEvent['previous']->isNotEmpty())
            <!-- Table for larger screens -->
            <table id="unique-payment-table" class="table table-borderless d-none d-md-table mt-3">
                <thead class="table-primary poppins-extralight">
                    <tr>
                        <th style="width: 10%;"></th>
                        <th style="width: 13%;"></th>
                        <th style="width: 15%;">Payment Fee</th>
                        <th style="width: 23%;">Payment Status</th>
                        <th style="width: 12%; white-space:nowrap;">Payment Proof</th>
                        <th style="width: 15%;"></th>
                    </tr>
                </thead>
                <tbody>

                    <!-- loop through the previous events -->
                    @foreach($transactionsByEvent['previous'] as $eventGroup)
                    <tr style="border:none;">
                        <td colspan="7" class="p-0">
                            <div class="card mb-1 mt-3">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <div class="me-auto">
                                        <small>{{$eventGroup['event']->start_date_formatted}} - {{$eventGroup['event']->end_date_formatted}}</small>
                                    </div>
                                    <div class="text-center poppins-medium">
                                        <span>{{$eventGroup['event']->title}}</span>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="{{route('client-viewpost', [ 'id' => $eventGroup['event']->event_id] )}}" class="btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration:none;">View Post</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--Loop through the previous -->
                                    @foreach($eventGroup['transactions'] as $transaction)
                                    <div class="row align-items-center mb-2">
                                        <div class="col-auto pe-1">
                                            <img src="{{asset($transaction->freelancer->user->profile_image)}}" class="rounded-circle">
                                        </div>
                                        <div class="col-2 pe-4">
                                            <div class="d-flex flex-column justify-content-center align-items-start">
                                                <div>{{$transaction->freelancer->user->first_name}} {{$transaction->freelancer->user->last_name}}</div> <!-- Dynamic freelancer name -->
                                                <small class="text-muted">{{$transaction->Hiring_request->serviceDetails()->job_title}}</small> <!-- Static profession -->
                                            </div>
                                        </div>
                                        <div class="col-2 text-left">₱ {{$transaction->payment_amount}}</div> <!-- Static payment fee -->
                                        <div class="col-2 d-flex justify-content-center align-items-center">
                                            <!--color depending on the status -->
                                            @if($transaction->payment_status === 'Unpaid')
                                            <span class="text-danger fw-bold">{{$transaction->payment_status}}</span>
                                            @elseif($transaction->payment_status === 'Pending')
                                            <span class="text-muted fw-bold">{{$transaction->payment_status}}</span>
                                            @elseif($transaction->payment_status === 'Partially Paid')
                                            <span class="text-primary fw-bold">{{$transaction->payment_status}}</span>
                                            @elseif($transaction->payment_status === 'Fully Paid')
                                            <span class="text-success fw-bold">{{$transaction->payment_status}}</span>
                                            @endif
                                        </div>
                                        <div class="col-2"></div>
                                        <div class="col-1 d-flex justify-content-center">
                                            <a href="#" class="btn btn-outline-secondary btn-sm" style="white-space: nowrap;"><i class="fas fa-receipt me-2"></i>View Receipt</a>
                                        </div>
                                        <div class="col-2 d-flex justify-content-end">
                                            <button class="btn btn-outline-secondary btn-sm btn-fit-width">View Review</button>
                                        </div>
                                    </div>
                                    <hr class="my-3" style="margin-bottom: 0; border: 1px solid #ddd;">
                                    @endforeach
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                    @else
                    <p class="fs-5">No previous transactions.</p>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Review Modal -->
        @include('modals.c_review')

    </div>
</div>

@endsection