@extends('layouts.app')

@section('content')
<div class="container my-4 pb-2">
    <a href="#" onclick="window.history.go(-1); return false;" style="text-decoration:none; color:black;">
        <i class="fas fa-arrow-left me-2 mb-4"></i>Back
    </a>

    <!-- Event Details -->
    <div class="container row-md-4 d-lg-flex">
        <div class="col-md-8 pb-4" style="border-radius:12px;">
            <div class="d-flex justify-content-between align-items-center mb-0">
                <div class="d-flex justify-content-start align-items-center">
                    <h3 class="mt-2 pb-0 poppins-medium pt-2">{{$event->title}}</h3>
                    @if($eventPostCanBeDeleted)
                    <!-- Trigger button for the deleteEventmodal -->
                    <a href="#" data-bs-toggle="modal" data-bs-target="#deleteModal-{{$event->event_id}}" class="ms-2 mb-1 mt-1 fs-5">
                        <i class="fas fa-trash text-danger ms-2 mt-3"></i>
                    </a>
                    @include('modals.deleteEventModal', ['event_id' => $event->event_id])
                    @endif

                </div>
                <span class=" {{$event->status == 'Open'? 'text-success': 'text-danger' }} fs-6 fw-bold letter-spacing mt-2 text-uppercase">{{$event->status}}</span>
            </div>
            <small class="text-muted mb-1">{{ \Carbon\Carbon::parse($event->created_at)->diffForHumans() }}</small>

            <hr>
            <div class="row">
                <div class="col-md-4">
                    <div class="fw-bold open-sans-reg" style="color: #91216C;">DATE & TIME</div>
                </div>
                <div class="col-md-8">
                    <div class="details">on {{ $event->start_date_formatted }} - {{ $event->end_date_formatted }}</div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <div class="fw-bold open-sans-reg" style="color: #91216C;">LOCATION</div>
                </div>
                <div class="col-md-8">
                    <div class="details">{{$event->street}}, {{$event->barangay}}, {{$event->city}}</div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <div class="fw-bold open-sans-reg" style="color: #91216C;">BUDGET</div>
                </div>
                <div class="col-md-8">
                    <div class="details">₱{{$event->budget_min}} - ₱{{$event->budget_max}}</div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <div class="fw-bold open-sans-reg" style="color: #91216C;">PAYMENT METHOD</div>
                </div>
                <div class="col-md-8">
                    <div class="d-flex justify-content-start align-items-center">
                        @if($event->payment_method == 'Cash')
                        <i class="fas fa-solid fa-money-bills fs-5 text-success"></i>
                        @else
                        <i class="fas fa-solid fa-credit-card fs-5" style="color: blue;"></i>
                        @endif
                        <div class="details text-uppercase ms-2 open-sans-reg fw-bold">{{$event->payment_method}}</div>
                    </div>
                </div>
            </div>
            <hr>
            <p class="mt-3" style="word-wrap: break-word; white-space: pre-line;">
                {!! nl2br(e($event->description)) !!}
            </p>

        </div>


        <!-- Event Jobs -->
        <div class="card col-md-4 ms-lg-3" style="border-radius: 15px; background-color:white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); border:none;">
            <div class="card-body poppins-medium">
                <h4>Event Jobs</h4>
                <ul class="list-group">
                    @foreach($eventJobs as $eventJob)
                    <li class="list-group-item d-flex fs-for-mobile justify-content-between align-items-center" style="background-color: white;">
                        <span>{{$eventJob->number_of_people}}</span>
                        {{$eventJob->service_needed}}

                        @php
                        // Get the hired count for the current job, or default to 0 if not set
                        $completedHiredCount = $completedHiredCounts->get($eventJob->job_id, 0);
                        @endphp

                        <!-- Display badges based on the count -->
                        @if($completedHiredCount == 0)
                        <span class="badge bg-danger badge-custom rounded-pill">No Hired</span>
                        @elseif($eventJob->number_of_people == $completedHiredCount)
                        <span class="badge bg-success badge-custom rounded-pill">Complete</span>
                        @else
                        <span class="badge bg-primary badge-custom rounded-pill">{{ $completedHiredCount }} Hired</span>
                        @endif

                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="card my-4 p-0 rounded-4">
        <div class="container">
            <!-- Nav tabs -->
            <ul class="card-header nav border-bottom row row-cols-1 row-cols-md-3 justify-content-between px-0 poppins-medium mb-3 rounded-top-4" style="background-color:#fceef7;  position: sticky; top: 0; z-index: 10;">
                @foreach ($tabs as $tabId => $tabName)
                <li class="nav-item col text-start mb-2 mb-md-0">
                    <a wire:click="$set('activeTab', 'application')"
                        class="nav-link {{ $tabId === 'application' ? 'active' : '' }} rounded-top-3 px-4 letter-spacing text-uppercase d-flex justify-content-between align-items-center"
                        id="{{ $tabId }}-tab"
                        data-bs-toggle="tab"
                        href="#{{ $tabId }}"
                        role="tab"
                        aria-controls="{{ $tabId }}"
                        aria-selected="{{ $tabId === 'application' ? 'true' : 'false' }}"
                        style="background-color:white; position:relative;">
                        <small>{{ $tabName }}</small>
                        <span class="text-black note text-muted">
                            ({{ $badgeCounts[$tabId] }})
                        </span>
                    </a>
                </li>
                @endforeach
            </ul>

            <!-- Tab content -->
            <div class="tab-content">

                <!-- Application Tab -->
                <div class="px-2 tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                    <div class="row">

                        <!--for the team applicants -->
                        @if($teamApplicants->isNotEmpty())
                        @foreach($teamApplicants as $teamApplicant)
                        <div class="col-lg-6 col-xl-4 mb-4">
                            <div class="card h-100 rounded-4" style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                <!-- Upper Part -->
                                <div class="card-header rounded-top-4 d-flex justify-content-between align-items-center" style="border-bottom: none; line-height:1.2;">
                                    <div class="align-items-start">
                                        <small class="note">Service Offered </small><br>
                                        <span class="fs-6 poppins-medium text-uppercase ps-0 badge"
                                            style="color: #91216C;">{{ $teamApplicant['package_service'] }}</span>
                                    </div>
                                    <div class="text-end">
                                        <small class="mb-0">Service Fee:</small><br>
                                        @if(isset($teamApplicant['package_service']) && $teamApplicant['package_price'])
                                        <span class="fs-6 poppins-medium text-uppercase pe-0 badge" style="color:mediumseagreen;">{{ $teamApplicant['package_price'] }}</span>
                                        @endif
                                    </div>
                                </div>
                                <!-- Profile Info -->
                                <div class="card-body flex-grow-1">
                                    <div class=" d-flex align-items-start mb-3">
                                        <img src="{{ asset('storage/' . $teamApplicant['team_profilepic']) }}" alt="Profile Image" class="rounded-circle ms-2" style="width: 60px; height: 60px; object-fit: cover;">
                                        <div class="ms-4">
                                            <h6 class="mb-0">{{ $teamApplicant['team_name'] }} (Team)</h6>
                                            @if ($teamApplicant['number_of_projects'] > 0)
                                            <small class="text-success mb-0">{{ $teamApplicant['number_of_projects']}} Projects done</small>
                                            @else
                                            <small class="text-muted mb-0 fst-italic">No projects yet</small>
                                            @endif
                                        </div>
                                        <div class="ms-auto text-end">
                                            @if ( $teamApplicant['avg_rating'] > 0)
                                            <div class="d-flex justify-content-center align-items-center">
                                                <span class="fs-6 text-warning">⭐</span>
                                                <small class="badge text-black">{{ number_format($teamApplicant['avg_rating'], 1) }}</small>
                                            </div>
                                            @else
                                            <span class="badge text-black">No ratings yet</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="mt-auto">
                                        <a href="{{route('team-profile-view' , ['id' => $teamApplicant['team_id'] ] ) }}" class="btn-seeprof" style="border: 1px solid #8b206a; color:#8b206a;">See Profile</a>

                                        @if(($teamApplicant['status'] == 'Accepted'))
                                        <table class="table table-borderless mb-2 w-100">
                                            <thead>
                                                <tr class="text-center">
                                                    <th class="note" style="white-space: nowrap;">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <td>
                                                        <div class="text-success">
                                                            Accepted
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        @elseif($teamApplicant['status'] == 'Pending')
                                        <button class="confirm mb-2" data-bs-toggle="modal" data-bs-target="#hireTeamAppModal-{{$teamApplicant['team_code']}}" style="color:black; background-color:#8FE2ED; border:none; border-radius: 20px">Hire</button>

                                        @php
                                        //get the team to pass the data and not an array
                                        $teamJobApply = App\Models\Profile\Team::where('team_code', $teamApplicant['team_code'])->first();
                                        @endphp
                                        <!-- Hire Modal -->
                                        @include('modals.Hiring.team_app_hire', ['uniqueId' => $teamApplicant['team_code'],'team' => $teamJobApply,
                                        'durationInHours' => $durationInHours, 'eventId'=> $event->event_id, 'payment_method' => $event->payment_method,
                                        'job_id' => $teamApplicant['job_id']])

                                        <button type="button"
                                            class="btn-round mb-2"
                                            style="background-color: none; color:crimson" data-toggle="modal"
                                            data-target="#confirmRejectModal"
                                            data-url="{{ route('jobApplication.update', ['id' => $teamApplicant['job_id']]) }}?freelancer_id={{$teamApplicant['team_code']}}">
                                            Reject
                                        </button>
                                        @elseif(($teamApplicant['status'] == 'Rejected'))
                                        <table class="table table-borderless mb-2 w-100">
                                            <thead>
                                                <tr class="text-center">
                                                    <th class="note" style="white-space: nowrap;">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <td>
                                                        <div class="text-danger">
                                                            Rejected
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @endif

                                        <!--This is for the hire reject-->
                                        @include('modals.Hiring.reject_modal')
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif

                        <!--for solo freelancers -->
                        @if($applicants->isNotEmpty())
                        @foreach ($applicants as $applicant)
                        <div class="col-lg-6 col-xl-4 mb-4">
                            <div class="card h-100 rounded-4" style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                <!-- Upper Part -->
                                <div class="card-header rounded-top-4 d-flex justify-content-between align-items-center" style="border-bottom: none; line-height:1.2;">
                                    <div class="align-items-start">
                                        <small class="note">Applying as </small><br>
                                        <span class="fs-6 poppins-medium text-uppercase ps-0 badge"
                                            style="color: #91216C;">{{ $applicant['service_needed'] }}</span>
                                    </div>
                                    <div class="text-end">
                                        <small class="mb-0">Service Fee:</small><br>
                                        @if(isset($applicant['service']) && $applicant['service']->job_fee)
                                        <span class="fs-6 poppins-medium text-uppercase pe-0 badge" style="color:mediumseagreen;">Php {{ $applicant['service']->job_fee }}</span>
                                        @endif
                                    </div>
                                </div>
                                <!-- Profile Info -->
                                <div class="card-body flex-grow-1">
                                    <div class=" d-flex align-items-start mb-3">
                                        <img src="{{ asset($applicant['applicant']->user->profile_image_url) }}" alt="Profile Image" class="rounded-circle ms-2" style="width: 60px; height: 60px; object-fit: cover;">
                                        <div class="ms-4">
                                            <h6 class="mb-0">{{ $applicant['applicant']->user->first_name }} {{ $applicant['applicant']->user->last_name }}</h6>
                                            <p class="text-muted mb-0">{{ $applicant['applicant']->user->city }}</p>
                                            @if ($applicant['applicant']->number_of_projects > 0)
                                            <small class="text-success mb-0">{{ $applicant['applicant']->number_of_projects}} Projects done</small>
                                            @else
                                            <small class="text-muted mb-0 fst-italic">No projects yet</small>
                                            @endif
                                        </div>
                                        <div class="ms-auto text-end">
                                            @if ( $applicant['applicant']->avg_rating > 0)
                                            <div class="d-flex justify-content-center align-items-center">
                                                <span class="fs-6 text-warning">⭐</span>
                                                <small class="badge text-black">{{ number_format($applicant['applicant']->avg_rating, 1) }}</small>
                                            </div>
                                            @else
                                            <span class="badge text-black">No ratings yet</span>
                                            @endif

                                        </div>
                                    </div>
                                    <!-- Action Buttons -->
                                    <div class="mt-auto">
                                        @if(($applicant['status'] == 'Accepted'))
                                        <table class="table table-borderless mb-2 w-100">
                                            <thead>
                                                <tr class="text-center">
                                                    <th class="note" style="white-space: nowrap;">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <td>
                                                        <div class="text-success">
                                                            Accepted
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        @elseif($applicant['status'] == 'Pending')
                                        <button class="confirm mb-2" data-bs-toggle="modal" data-bs-target="#hireModal-{{ $applicant['applicant']->user_id }}"
                                            style="color:black; background-color:#8FE2ED; border:none; border-radius: 20px">
                                            Hire</button>

                                        <!-- Hire Modal -->
                                        @include('modals.Hiring.hire_modal', ['applicantId' => $applicant['applicant']->user_id,'freelancer' =>
                                        $applicant['applicant'], $durationInHours = $durationInHours, 'service' => $applicant['service'],
                                        'job_id' => $applicant['job_id'], 'payment_method' => $event->payment_method ])

                                        <button type="button"
                                            class="btn-round mb-2"
                                            style="background-color: none; color:crimson"
                                            data-toggle="modal"
                                            data-target="#confirmRejectModal"
                                            data-url="{{ route('jobApplication.update', ['id' => $applicant['job_id']]) }}?freelancer_id={{ $applicant['applicant']->user_id }}">
                                            Reject
                                        </button>
                                        @elseif(($applicant['status'] == 'Rejected'))
                                        <table class="table table-borderless mb-2 w-100">
                                            <thead>
                                                <tr class="text-center">
                                                    <th class="note" style="white-space: nowrap;">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <td>
                                                        <div class="text-danger">
                                                            Rejected
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @endif

                                        <a href="{{route('view-freelancer-profile' , ['id' => $applicant['applicant']->user_id ] ) }}" class="btn-seeprof" style="border: 1px solid #8b206a; color:#8b206a;">See Profile</a>

                                        @include('modals.Hiring.reject_modal')

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @elseif($applicants->isEmpty() && $teamApplicants->isEmpty())
                        <p class="text-center open-sans-reg my-3">No Applicants</p>
                        @endif
                    </div>
                </div>

                <!-- Hiring Requests Tab -->
                <div class="tab-pane fade px-2" id="hiring-requests" role="tabpanel" aria-labelledby="hiring-requests-tab">
                    <div class="row">

                        <!--for team freelancers -->
                        @if($teamHiringRequests->isNotEmpty())
                        @foreach($teamHiringRequests as $team)
                        <div class="col-lg-6 col-xl-4 mb-4">
                            <div class="card h-100 rounded-4" style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                <!-- Upper Part -->
                                <div class="card-header rounded-top-4 d-flex justify-content-between align-items-center" style="border-bottom: none; line-height:1.2;">
                                    @if(isset($team->details))
                                    <div class="align-items-start">
                                        <small class="note">Hiring as </small><br>
                                        <span class="fs-6 poppins-medium text-uppercase ps-0 badge"
                                            style="color: #91216C;">{{ $team->details['package_service'] }}</span>
                                    </div>
                                    <div class="text-end">
                                        <small class="mb-0">Service Fee:</small><br>
                                        <span class="fs-6 poppins-medium text-uppercase pe-0 badge" style="color:mediumseagreen;">Php {{ $team->details['package_price']}}</span>
                                    </div>
                                    @else
                                    <p>Service details not available.</p>
                                    @endif
                                </div>
                                <!-- Profile Info -->
                                <div class="p-3">
                                    <div class=" d-flex align-items-start mb-3">

                                        <img src="{{ asset('storage/' . $team->details['team_profilepic']) }}" alt="Profile Image" class="rounded-circle ms-2" style="width: 60px; height: 60px; object-fit: cover;">
                                        <div class="ms-4">
                                            <h6 class="mb-0">{{$team->details['team_name']}} </h6>
                                            @if($team->details['number_of_projects'] != 0)
                                            <small class="text-success mb-0">{{ $team->details['number_of_projects'] }} Projects done</small>
                                            @else
                                            <small class="text-muted mb-0">No projects yet</small>
                                            @endif
                                        </div>
                                        <div class="ms-auto text-end">
                                            @if($team->details['avg_rating'] > 0)
                                            <div class="d-flex justify-content-evenly align-items-center">
                                                <span class="fs-6 text-warning">⭐</span>
                                                <small class="badge text-black">{{ number_format($team->details['avg_rating'], 1) }}</small>
                                            </div>
                                            @else
                                            <span class="badge text-muted">No ratings yet</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Table Negotiation -->
                                    <div class="mt-auto">
                                        @if(isset($team->hiringRequestData))
                                        <table class="table table-borderless mb-2 w-100">
                                            <thead>
                                                <tr class="text-center">
                                                    <th class="note" style="white-space: nowrap;">Team's Offer</th>
                                                    <th class="note" style="white-space: nowrap;">Your Offer</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <td class="fw-bold" @if($freelancer->hiringRequestData->dealer_user_type === 'freelancer')style="color: mediumseagreen;" @endif>₱{{$team->hiringRequestData->freelancer_pricing}}</td>
                                                    <td class="fw-bold" @if($freelancer->hiringRequestData->dealer_user_type === 'client')style="color: mediumseagreen;" @endif>₱{{$team->hiringRequestData->client_pricing}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @else
                                        <p>No hiring request data.</p>
                                        @endif
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-flex justify-content-start">

                                        @if($team->hiringRequestData->status != 'Rejected')



                                        <!-- Negotiate Modal-->
                                        @livewire('negotiate-modal', ['hiringRequestId' => $team->hiringRequestData->hiring_request_id,
                                        'service' => $team->details])

                                        @if($team->hiringRequestData->dealer_user_type == 'client' && $team->hiringRequestData->status != 'Accepted')
                                        <button class="pending-color confirm me-2" disabled style="background-color: #D9D9D9;">Pending</button>
                                        @elseif($team->hiringRequestData->dealer_user_type == 'freelancer' && $team->hiringRequestData->status != 'Accepted')
                                        <button class="confirm me-2" data-bs-toggle="modal" data-bs-target="#modal-{{ $team->hiringRequestData->hiring_request_id }}"
                                            data-action="accept" data-hiringid="{{ $team->hiringRequestData->hiring_request_id }}" data-modal-type="confirm-modal">Accept Offer</button>
                                        @elseif($team->hiringRequestData->status == 'Accepted')
                                        <a href="{{route('client-transaction')}} " class="confirm">View Transaction</a>
                                        @endif

                                        <!--if accepted this will be gone-->
                                        @if($team->hiringRequestData->status != 'Accepted')
                                        <button class="confirm me-2" style="background-color: #8FE2ED; color: black;" data-bs-toggle="modal" data-bs-target="#negotiateModal-{{$team->hiringRequestData->hiring_request_id}}">Negotiate</button>
                                        @endif

                                        <!--if accepted this will be gone-->
                                        @if($team->hiringRequestData->status != 'Accepted')
                                        <button class="confirm" style="background-color:crimson;"
                                            data-bs-toggle="modal" data-bs-target="#modal-{{ $team->hiringRequestData->hiring_request_id }}"
                                            data-action="cancel" data-hiringid="{{ $team->hiringRequestData->hiring_request_id }}" data-modal-type="confirm-modal">Cancel</button>
                                        @endif

                                        @elseif($team->hiringRequestData->status == 'Rejected')
                                        <button class="btn btn-cancel me-2 mb-2 mb-sm-0 border border-secondary-subtle fw-bold"
                                            style="flex: 2; width: 100%;  color:red; border:none; border-radius: 20px" disabled>Rejected</button>
                                        @endif

                                    </div>
                                </div>
                            </div>

                            <!-- Reusable Modal Component -->
                            <x-confirmation-modal
                                :id="$team->hiringRequestData->hiring_request_id"
                                title="Confirm Cancellation"
                                message="Are you sure you want to cancel this offer?"
                                :actionUrl="''"
                                method="PATCH" />
                        </div>
                        @endforeach
                        @endif

                        <!--for individual freelancers -->
                        @if($hiringRequests->isNotEmpty())
                        @foreach ($hiringRequests as $freelancer)
                        <div class="col-lg-6 col-xl-4 mb-4">
                            <div class="card h-100 rounded-4" style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                <!-- Upper Part -->
                                <div class="card-header rounded-top-4 d-flex justify-content-between align-items-center" style="border-bottom: none; line-height:1.2;">
                                    @if(isset($freelancer->serviceDetails))
                                    <div class="align-items-start">
                                        <small class="note">Hiring as </small><br>
                                        <span class="fs-6 poppins-medium text-uppercase ps-0 badge"
                                            style="color: #91216C;">{{ $freelancer->serviceDetails->job_title }}</span>
                                    </div>
                                    <div class="text-end">
                                        <small class="mb-0">Service Fee:</small><br>
                                        <span class="fs-6 poppins-medium text-uppercase pe-0 badge" style="color:mediumseagreen;">Php {{ $freelancer->serviceDetails->job_fee}}</span>
                                    </div>
                                    @else
                                    <p>Service details not available.</p>
                                    @endif
                                </div>
                                <!-- Profile Info -->
                                <div class="card-body flex-grow-1">
                                    <div class=" d-flex align-items-start mb-3">
                                        <a href="{{route('view-freelancer-profile', ['id' => $freelancer->user_id])}}">
                                            <img src="{{ asset($freelancer->user->profile_image_url) }}" alt="Profile Image" class="rounded-circle ms-2" style="width: 60px; height: 60px; object-fit: cover;">
                                        </a>
                                        <div class="ms-4">
                                            <a href="{{route('view-freelancer-profile', ['id' => $freelancer->user_id])}}"
                                                class="text-decoration-none text-black">
                                                <h6 class="mb-0">{{ $freelancer->user->first_name }} {{ $freelancer->user->last_name }} </h6>
                                            </a>
                                            <p class="text-muted mb-0">{{ $freelancer->user->city }}</p>
                                            @if($freelancer->number_of_projects != 0)
                                            <small class="text-success mb-0">{{ $freelancer->number_of_projects }} Projects done</small>
                                            @else
                                            <small class="text-muted mb-0">No projects yet</small>
                                            @endif
                                        </div>
                                        <div class="ms-auto text-end">
                                            @if($freelancer->avg_rating > 0)
                                            <div class="d-flex justify-content-evenly align-items-center">
                                                <span class="fs-6 text-warning">⭐</span>
                                                <small class="badge text-black">{{ number_format($freelancer->avg_rating, 1) }}</small>
                                            </div>
                                            @else
                                            <span class="badge text-muted">No ratings yet</span>
                                            @endif
                                        </div>
                                    </div>


                                    <!-- Table Negotiation -->
                                    <div class="mt-auto">
                                        @if(isset($freelancer->hiringRequestData))
                                        <table class="table table-borderless mb-2 w-100">
                                            <thead>
                                                <tr class="text-center">
                                                    <th class="note" style="white-space: nowrap;">Freelancer's Offer</th>
                                                    <th class="note" style="white-space: nowrap;">Your Offer</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <td class="fw-bold" @if($freelancer->hiringRequestData->dealer_user_type === 'freelancer')style="color: mediumseagreen;" @endif>₱{{$freelancer->hiringRequestData->freelancer_pricing}} {{ $freelancer->serviceDetails->fee_type }}</td>
                                                    <td class="fw-bold" @if($freelancer->hiringRequestData->dealer_user_type === 'client')style="color: mediumseagreen;" @endif>₱{{$freelancer->hiringRequestData->client_pricing}} {{ $freelancer->serviceDetails->fee_type }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @else
                                        <p>No hiring request data.</p>
                                        @endif

                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-flex flex-column flex-md-row justify-content-start">

                                        @if($freelancer->hiringRequestData->status != 'Rejected')

                                        @if($freelancer->hiringRequestData->dealer_user_type == 'client' && $freelancer->hiringRequestData->status != 'Accepted')
                                        <button class="pending-color confirm me-2 mb-2 mb-md-0" disabled style="background-color: #D9D9D9;">Pending</button>
                                        @elseif($freelancer->hiringRequestData->dealer_user_type == 'freelancer' && $freelancer->hiringRequestData->status != 'Accepted')
                                        <button class="confirm me-2 mb-2 mb-md-0" data-bs-toggle="modal" data-bs-target="#modal-{{ $freelancer->hiringRequestData->hiring_request_id }}"
                                            data-action="accept" data-hiringid="{{ $freelancer->hiringRequestData->hiring_request_id }}" data-modal-type="confirm-modal">Accept</button>
                                        @elseif($freelancer->hiringRequestData->status == 'Accepted')
                                        <a href="{{route('client-transaction')}}" class="confirm me-2 mb-2 mb-md-0">View Transaction</a>
                                        @endif

                                        @if($freelancer->hiringRequestData->status != 'Accepted')
                                        <button class="confirm me-2 mb-2 mb-md-0" style="background-color: #8FE2ED; color: black;" data-bs-toggle="modal" data-bs-target="#negotiateModal-{{$freelancer->hiringRequestData->hiring_request_id}}">Negotiate</button>
                                        @endif

                                        <!--if accepted this will be gone-->
                                        @if($freelancer->hiringRequestData->status != 'Accepted')
                                        <button class="confirm mb-2 mb-md-0" style="background-color:crimson;"
                                            data-bs-toggle="modal" data-bs-target="#modal-{{ $freelancer->hiringRequestData->hiring_request_id }}"
                                            data-action="cancel" data-hiringid="{{ $freelancer->hiringRequestData->hiring_request_id }}" data-modal-type="confirm-modal">Cancel</button>
                                        @endif

                                        @elseif($freelancer->hiringRequestData->status == 'Rejected')
                                        <button class="btn btn-cancel me-2 mb-2 mb-sm-0 border border-secondary-subtle fw-bold mb-2 mb-md-0"
                                            style="flex: 2; width: 100%;  color:red; border:none; border-radius: 20px" disabled>Rejected</button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Reusable Modal Component -->
                            <x-confirmation-modal
                                :id="$freelancer->hiringRequestData->hiring_request_id"
                                title="Confirm Cancellation"
                                message="Are you sure you want to cancel this offer?"
                                :actionUrl="''"
                                method="PATCH" />


                            <!-- Negotiate Modal-->
                            @livewire('negotiate-modal', ['hiringRequestId' => $freelancer->hiringRequestData->hiring_request_id,
                            'service' => $freelancer->serviceDetails] , key($freelancer->hiringRequestData->hiring_request_id))

                        </div>
                        @endforeach
                        @elseif($teamHiringRequests->isEmpty() && $hiringRequests->isEmpty())
                        <p class="text-center open-sans-reg">No Hiring Requests</p>
                        @endif
                    </div>
                </div>

                <!-- Recommendation Tab -->
                <div class="tab-pane fade px-2" id="recommendation" role="tabpanel" aria-labelledby="recommendation-tab">
                    <div class="row">

                        @if($teamRecommendations->isNotEmpty())
                        <!--for the team freelancer recomms -->
                        @foreach($teamRecommendations as $team)
                        <div class="col-lg-6 col-xl-4 mb-4">
                            <div class="card h-100 rounded-4 d-flex flex-column" style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                <div class="card-header d-flex justify-content-start align-items-center"
                                    style="border-bottom: none;">
                                    <small class="note me-2">Services:</small>
                                    <div class="my-1">
                                        <span class="badge fs-6 mb-1"
                                            style="background-color: aliceblue; border:1px solid lightgray; color:#323232;">{{ $team->package_service }}</span>
                                    </div>
                                </div>

                                <!-- Profile Info -->
                                <div class="card-body flex-grow-1">
                                    <div class=" d-flex align-items-start mb-3">
                                        <img src="{{ asset('storage/' . $team->team_profilepic) }}" alt="Profile Image" class="rounded-circle ms-2" style="width: 60px; height: 60px; object-fit: cover;">
                                        <div class="ms-4">
                                            <h6 class="mb-0">{{ $team->team_name }}
                                                @if($team->number_of_projects)
                                                <p class="text-success mb-0">{{ $team->number_of_projects}} Projects done</p>
                                                @else
                                                <p class="text-muted mb-0">No projects yet</p>
                                                @endif
                                        </div>
                                        <div class="ms-auto text-end">
                                            @if($team->avg_rating != 0)
                                            <div class="d-flex justify-content-evenly align-items-center">
                                                <span class="fs-6 text-warning">⭐</span>
                                                <small class="badge text-black">{{ number_format($team->avg_rating, 1) }}</small>
                                            </div>
                                            @else
                                            <span class="badge text-black">No ratings yet</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="justify-content-start">
                                        <button class="confirm mb-2" data-bs-toggle="modal" data-bs-target="##hireTeamRecommModal-{{$team->team_code}}" style="color:black; background-color:#8FE2ED;">Hire</button>
                                        <a href="{{route('team-profile-view', ['id' => $team->team_id])}}" class="btn-seeprof " style="border: 1px solid #8b206a; color:#8b206a;">See Profile</a>
                                    </div>

                                    <!-- Hire Modal -->
                                    @include('modals.Hiring.team_hire', ['uniqueId' => $team->team_code,'team' => $team,
                                    'durationInHours' => $durationInHours, 'eventId'=> $event->event_id, 'payment_method' => $event->payment_method,
                                    'job_services' => $event->event_jobs])
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif

                        <!--for individual freelancers -->
                        @if($recommendations->isNotEmpty())
                        @foreach ($recommendations as $recomm)
                        <div class="col-lg-6 col-xl-4 mb-4">
                            <div class="card h-100 rounded-4 d-flex flex-column" style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                <div class="card-header d-flex justify-content-start align-items-center"
                                    style="border-bottom: none;">
                                    <small class="note me-2">Services:</small>
                                    <div class="my-1">
                                        @foreach($recomm->services as $service)
                                        <span class="badge fs-6 mb-1"
                                            style="background-color: aliceblue; border:1px solid lightgray; color:#323232;">{{ $service->job_title }}</span>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Profile Info -->
                                <div class="card-body flex-grow-1">
                                    <div class=" d-flex align-items-start mb-3">
                                        <img src="{{ asset($recomm->user->profile_image_url) }}" alt="Profile Image" class="rounded-circle ms-2" style="width: 60px; height: 60px; object-fit: cover;">
                                        <div class="ms-4">
                                            <h6 class="mb-0">{{ $recomm->user->first_name }} {{ $recomm->user->last_name }}</h6>
                                            <p class="text-muted mb-0">{{ $recomm->user->street }}, {{ $recomm->user->barangay }}, {{ $recomm->user->city }}</p>
                                            @if($recomm->number_of_projects)
                                            <small class="text-success mb-0">{{ $recomm->number_of_projects}} Projects done</small>
                                            @else
                                            <small class="text-muted mb-0">No projects yet</small>
                                            @endif
                                        </div>
                                        <div class="ms-auto text-end">
                                            @if($recomm->avg_rating != 0)
                                            <div class="d-flex justify-content-evenly align-items-center">
                                                <span class="fs-6 text-warning">⭐</span>
                                                <small class="badge text-black">{{ number_format($recomm->avg_rating, 1) }}</small>
                                            </div>
                                            @else
                                            <span class="badge text-black">No ratings yet</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="justify-content-start">
                                        <button class="confirm mb-2" data-bs-toggle="modal" data-bs-target="#hireRecommModal-{{$recomm->user_id}}" style="color:black; background-color:#8FE2ED;">Hire</button>
                                        <a href="{{route('view-freelancer-profile' , ['id' => $recomm->user_id] ) }}" class="btn-seeprof " style="border: 1px solid #8b206a; color:#8b206a;">See Profile</a>
                                    </div>

                                    <!-- Hire Modal -->
                                    @include('modals.Hiring.hire_recomm', ['uniqueId' => $recomm->user_id,'freelancer' => $recomm,
                                    'durationInHours' => $durationInHours, 'eventId'=> $event->event_id, 'payment_method' => $event->payment_method,
                                    'job_services' => $event->event_jobs])
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif

                        @if($teamRecommendations->isEmpty() && $recommendations->isEmpty())
                        <p class="text-center open-sans-reg">No Recommendations</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .nav-link.inactive {
        color: #B0B0B0;
    }

    .nav-link.active {
        color: #91216C;
    }
</style>

@endsection