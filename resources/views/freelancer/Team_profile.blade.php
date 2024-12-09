@extends('layouts.app')

@section('content')
<div class="container py-2 my-3">
    <!-- Profile Header -->
    <div class="container rounded-4 mb-3" style="background-color: #FCF2F9; box-shadow:1px 1px 2px rgba(0, 0, 0, 0.3);">
        <div class="row d-flex justify-content-center">
            <div class="col-5 col-md-4 col-lg-4">
                <!--Profile Pic and Team Information -->
                <div class="row my-3">
                    <div class="profile-container d-flex justify-content-center align-items-center">
                        <img src="{{asset('storage/' .$team->team_profilepic)}}" alt="Profile Picture"
                            class="rounded-circle img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-7 col-md-8 col-lg-8 ps-4">
                <div class="row my-3">
                    <div class="col">
                        <!-- Full Name and Verification Status -->
                        <div class="mt-2 d-flex align-items-center">
                            <h5 class="fs-md-name text-start mb-0 me-2 poppins-medium">
                                {{$team->team_name}}
                            </h5>
                            @if($allMembersVerified)
                            <small style="text-align:end;"> All members verified </small>
                            @endif
                        </div>

                        <!--review details-->
                        <div class="d-flex align-items-center mb-1">
                            @if($team->avg_rating == 0)
                            <span class="fst-italic text-muted" style="white-space: nowrap;">No ratings yet</span>
                            @else
                            <h6 class="fw-bold me-3 mb-0">Rating:</h6>
                            <!-- Star Rating Container -->
                            <div class="star-rating ms-2">
                                <div class="row">
                                    <div class="col-auto p-0 me-1">
                                        <span class=" fs-sm fs-md">{{ number_format($team->avg_rating, 1) }}</span>
                                    </div>
                                    <div class="col-auto p-0">
                                        <div class="d-flex align-items-center mt-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <=floor($team->avg_rating))
                                                <i class="fas fa-star filled"></i> <!-- Filled star -->
                                                @elseif ($i == ceil($team->avg_rating) && $team->avg_rating - floor($team->avg_rating) > 0)
                                                <i class="fas fa-star-half-alt filled"></i> <!-- Half star -->
                                                @else
                                                <i class="far fa-star"></i> <!-- Empty star -->
                                                @endif
                                                @endfor
                                        </div>
                                    </div>
                                    @php
                                    $totalReviews = $team->reviews()->where('reviewee_role', 'team')->count();
                                    @endphp
                                    <div class="col-auto p-0 ms-1">
                                        @if($team->reviews->isNotEmpty())
                                        @if($totalReviews > 1)
                                        <span class="note">({{$totalReviews}})</span>
                                        @else
                                        <span class="note">({{$totalReviews}})</span>
                                        @endif
                                        @endif
                                    </div>

                                </div>
                            </div>
                            @endif
                            <div class="team-code ms-4 ps-4">
                                Team Code: <strong>{{$team->team_code}}</strong>
                            </div>

                        </div>
                        <!--team number of projects-->
                        @if($team->number_of_projects > 0)
                        <span class="text-success fw-light mb-2">Number of projects: {{$team->number_of_projects}}</span>
                        @endif

                        <div class="package-fee mb-3">
                            Package Offer: <strong>{{$team->package_service}}</strong>
                        </div>

                        <div class="package-fee mb-3">
                            Package Fee: <strong>Php {{$team->package_price}}</strong>
                        </div>
                        <small class="description" style="line-height: 1.2;">{{$team->team_description}}</small>
                    </div>
                    <div class="col-auto me-3">
                        <div class="d-flex justify-content-start align-items-center mt-2 mt-lg-0">
                            <i class="fas fa-pencil" data-bs-toggle="modal"
                                data-bs-target="#editTeamModal"></i>

                            @include('modals.editTeam')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs id=" myTab" role="tablist">
        <li class="nav-item col text-start mb-2 mb-md-0" role="presentation">
            <button class="nav-link active" id="profile-tab"
                data-bs-toggle="tab" data-bs-target="#profile"
                type="button" role="tab" aria-controls="profile"
                aria-selected="true">Profile</button>
        </li>
        <li class="nav-item col text-center mb-2 mb-md-0" role="presentation">
            <button class="nav-link" id="application-tab"
                data-bs-toggle="tab" data-bs-target="#application"
                type="button" role="tab" aria-controls="application"
                aria-selected="false">Application<span class="badge-notification">{{$appliedJobsCount}}</span></button>
        </li>
        <li class="nav-item col text-center" role="presentation">
            <button class="nav-link" id="hiring-request-tab"
                data-bs-toggle="tab" data-bs-target="#hiring-request"
                type="button" role="tab" aria-controls="hiring-request"
                aria-selected="false">Hiring Request
                <span class="badge-notification">{{$hiringRequestsCount}}</span></button>
        </li>
        <li class="nav-item col text-center" role="presentation">
            <button class="nav-link" id="jobs-tab"
                data-bs-toggle="tab" data-bs-target="#jobs"
                type="button" role="tab" aria-controls="jobs"
                aria-selected="false">Jobs Available
                <span class="badge-notification">{{$eventsCount}}</span></button>
        </li>
    </ul>
    <!-- Tab Content -->
    <div class="tab-content" id="myTabContent">
        <!-- Profile Tab -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="tab-pane show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="row d-block d-lg-flex justify-content-center">
                <div class="col col-lg-4 my-3">
                    <div class="flex-grow-1">
                        <div class="d-flex">
                            <h5 class="poppins-medium">Team Members</h5>
                            <small class="ms-1">({{$membersCount}})</small>
                        </div>
                    </div>
                    <div class="col" style="height: 400px; overflow-y: auto;">
                        <!-- Card container with scroll enabled -->
                        @foreach($teamMembers as $member)
                        <div class="p-3 mb-3 rounded-4 border-0" style="background-color:white;">
                            <div class="col team-member d-flex justify-content-between align-items-center">
                                <div class=" member-info d-flex justify-content-start align-items-start ms-1">
                                    <img src="{{$member->user->profile_image_url}}" alt="Member" style="margin-right: 10px; max-width: 50px; max-height: 50px; object-fit: cover;">
                                    <div>
                                        <div style="line-height: 1;">
                                            <p class="member-name" style="margin: 0; white-space: nowrap;">{{$member->user->fullName()}}</p>
                                            @if($team->team_leader === $member->user_id)
                                            <span class="fw-bold fs-smaller text-start txt-purple note py-1">Admin</span>
                                            @else
                                            <span class="fw-bold fs-smaller text-start text-black note py-1">Member</span>
                                            @endif
                                        </div>
                                        @if($member->avg_rating > 0)
                                        <small style="margin: 0;">★ {{ number_format($member->avg_rating, 1) }}</small>
                                        @else
                                        <small style="margin: 0;" class="text-muted fs-smaller fst-italic">No ratings yet</small>
                                        @endif
                                        <div class="col">
                                            @foreach($member->services as $service)
                                            <span class="text-start badge rounded-pill me-1" style="background-color:#FCF2F9; color:gray;">
                                                {{$service->job_title}}
                                            </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="col-end m-3">
                                    <small class="status text-center text-success">Available</small>
                                </div>

                                <!--Tooltip for actions -->

                                @if(auth()->user()->id === $team->team_leader && $member->user_id !== $team->team_leader )
                                <div class="dropdown">
<<<<<<< HEAD
                                    <button class="btn btn-light border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
=======
                                    <button class="btn btn-light border-0 p-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
>>>>>>> 2400bbda73edb56d42cba1cedddd7631c485af3d
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Make Admin</a></li>
                                        <li><a class="dropdown-item" href="#">View Profile</a></li>
                                        <li><a class="dropdown-item text-danger" href="#">Remove</a></li>
                                    </ul>
                                </div>
                                @elseif(auth()->user()->id === $member->user_id && $member->user_id !== $team->team_leader)
                                <div class="dropdown">
                                    <button class="btn btn-light border-0 p-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu">
<<<<<<< HEAD
                                        <li><a class="dropdown-item" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#editServiceModal">Edit Service</a></li>
                                        <li><a class="dropdown-item text-danger" href="#">Leave Team</a></li>
                                    </ul>
                                </div> @include('modals.editServiceTeam')
                                @endif
=======
                                        <li><a class="dropdown-item" href="#">Edit service</a></li>
                                        <li><a class="dropdown-item text-danger" href="#">Leave team</a></li>
                                    </ul>
                                </div>
                                @endif

>>>>>>> 2400bbda73edb56d42cba1cedddd7631c485af3d
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col col-lg-8 poppins-regular my-3">
                    <div class="row flex-grow-1">
                        <!-- Terms of Service -->
                        <div class="col-lg-12 col-md-6 terms-of-service">
                            <div class="d-flex align-items-center">
                                <h5 class="poppins-medium">Terms of Services</h5>
                                <!-- Edit Icon -->
                                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#editTermsTeamModal">
                                    <i class="ms-0 me-4 fs-6 text-start fas fa-pen fa-solid"></i>
                                </button>
                            </div>
                            <p class="p-3 rounded-4" style="background-color: white;">{{$team->terms_of_services}}</p>
                        </div>
                        <div class="col-lg-12 col-md-6">
                            <section id="team-reviews">
                                <div class="d-flex justify-content-between align-items-center my-3">
                                    <div class="d-flex align-items-center">
                                        <h5 class="text-start poppins-medium mb-0 me-2">Client Reviews</h5>
                                        <p class="mb-0 fs-smaller">({{$reviews->count()}})</p>
                                    </div>
                                    <a class="poppins-light text-purple" href="{{route('allReviews.show', ['id' => $team->team_name])}}" style="font-size:small;">See All Reviews</a>
                                </div>
                                <p class="text-center my-2">Recent Projects</p>

                                @if($reviews)

                                @foreach($reviews as $review)

                                @php
                                $start_date_formatted = \Carbon\Carbon::parse($review->transaction->event->start_date)->format('M j, Y');
                                $end_date_formatted = \Carbon\Carbon::parse($review->transaction->event->end_date)->format('M j, Y');
                                @endphp

                                <div class="container card rounded-4 border-0" style="background-color: white; box-shadow:1px 1px 2px rgba(0, 0, 0, 0.3);">
                                    <div class="row d-flex align-items-center justify-content-center">
                                        <!-- Review Item  -->
                                        <div class=" card-header d-flex align-items-center justify-content-between rounded-top-4" style="border-bottom: none; background-color:#f8e3f2;">
                                            <div class="row align-items-center w-100">
                                                <div class="col">
                                                    <h2 class="text-start mb-0 fs-sm fs-md poppins-medium me-2">{{$review->transaction->event->title}}</h2>
                                                    <span class="note">{{$start_date_formatted}} {{$end_date_formatted}}</span>
                                                </div>
                                                <div class="col-auto ms-auto">
                                                    <a class="note fw-medium poppins-light text-purple"
                                                        href="{{route('client-viewpost', ['id' => $review->transaction->event->event_id] )}}">See Post</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-flex">
                                            <div class="col-auto text-center my-2 px-0">
                                                <!-- Profile Picture -->
                                                <img src="{{ asset($review->client->user->profile_image_url) }}" alt="Reviewer Profile" class="img-fluid rounded-circle" style="width: 40px; height: 40px;">
                                            </div>
                                            <div class="col-10">
                                                <!-- Review Content -->
                                                <div>
                                                    <small class="font-weight-bold mt-3">{{$review->client->user->first_name}} {{$review->client->user->last_name}} </small>
                                                </div>
                                                <div class="star-rating mb-2">
                                                    <span>{{ number_format($review->rating, 1) }}</span>

                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <=floor($review->rating))
                                                        <i class="fas fa-star filled"></i> <!-- Filled star -->
                                                        @elseif ($i == ceil($review->rating) && $review->rating - floor($review->rating) > 0)
                                                        <i class="fas fa-star-half-alt filled"></i> <!-- Half star -->
                                                        @else
                                                        <i class="far fa-star"></i> <!-- Empty star -->
                                                        @endif
                                                        @endfor
                                                </div>
                                                <div>
                                                    <p class="mb-2" style="line-height: 1.2;">"{{$review->content}}"</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </section>
                        </div>
<<<<<<< HEAD
                        </section>
                        @include('modals.termsTeam')
=======
>>>>>>> 2400bbda73edb56d42cba1cedddd7631c485af3d
                    </div>
                </div>
            </div>
        </div>

        <!-- application Tab -->
        <div class="tab-pane show" id="application" role="tabpanel" aria-labelledby="application-tab">
            <div class="application-section" style="padding: 20px;">
                @if($appliedJobs->isNotEmpty())
                <div class="row">
                    <!-- Jobs Applied -->
                    @foreach($appliedJobs as $job)
                    <div class="col-lg-6 col-xl-4 mb-4">
                        <div class="card h-100 rounded-4"
                            style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                            <div class="card-header d-flex justify-content-between align-items-center"
                                style="border-bottom: none;">
                                <div class="d-flex align-items-center">
                                    <small class="note">Applying as </small><br>
                                    <span class="fs-6 poppins-medium text-uppercase badge"
                                        style="color: #91216C;">{{ $job->event_job->service_needed }}</span>
                                </div> <span
                                    class="{{ $job->event_job->event->status == 'Open' ? 'bg-success' : 'bg-danger' }} badge text-uppercase">
                                    {{ $job->event_job->event->status }}</span>
                            </div>
                            <div class="card-body flex-grow-1">
                                <span class="fs-5 me-2 poppins-medium">{{ $job->event_job->event->title }}</span><br>
                                <strong class="note">Date & Time:</strong><br>
                                <span> {{ $job->event_job->event->start_date_formatted }} -
                                    {{ $job->event_job->event->end_date_formatted }}</span><br>
                                <strong class="note">Location:</strong><br>
                                <span> {{ $job->event_job->event->street }}, {{ $job->event_job->event->barangay }},
                                    {{ $job->event_job->event->city }}</span><br>
                                <strong class="note">Budget:</strong><br>
                                <span> ₱{{ $job->event_job->event->budget_min }} - ₱{{ $job->event_job->event->budget_max }}</span>

                                <!-- Divider Line -->
                                <hr class="my-1" style="margin-bottom: 0; border: 1px solid #ddd;">
                                <div class="mt-auto p-3 mb-2">
                                    <div class="{{ $job->status == 'Pending' ? 'pending-color' : ($job->status == 'Accepted' ? 'text-success' : 'text-danger') }} btn-round flex-grow-1 mb-2 fw-bold"
                                        style="background-color:aliceblue; border-radius:0px;">
                                        {{ $job->status }}
                                    </div>
                                    <a href="{{ route('client-viewpost', ['id' => $job->event_job->event->event_id]) }}"
                                        class="confirm flex-grow-1 mb-2">View Post</a>
                                    @if($job->status == 'Pending')
                                    <button class="btn-round flex-grow-1 text-danger" style="border: 1px solid red;"
                                        data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal">Cancel</button>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Modal for Confirming Cancellation -->
                    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Deletion</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to cancel this job application?</p>
                                </div>
                                <div class="modal-footer">
                                    <!-- Confirm button that redirects to the cancellation route -->
                                    <form id="cancelJobApplicationForm" action="{{ route('team-apply-cancel') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="job_id" id="job_id" value="{{$job->event_job->job_id}}">
                                        <button type="submit" class="btn btn-danger">Confirm</button>
                                    </form>
                                    <!-- Cancel button that dismisses the modal -->
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </div>
                @else
                <p class="text-center mt-5 text-muted">No Applications</p>
                @endif

            </div>
        </div>

        <!-- Jobs-->
        <div class="tab-pane show" id="jobs" role="tabpanel" aria-labelledby="jobs-tab">
            <div class="jobs-section" style="padding: 20px;">

                <!--If no recommendations-->
                @if($eventRecommendations->isNotEmpty())
                <div class="row">
                    @foreach($eventRecommendations as $event)
                    <div class="col-lg-6 col-xl-4 mb-4">
                        <div class="card h-100 rounded-4 d-flex flex-column"
                            style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                            <div class="card-header d-flex justify-content-center align-items-center"
                                style="border-bottom: none;">
                                <small class="note me-2">Service/s required:</small>
                                <div class="my-1">
                                    @foreach($event->event_jobs as $job)
                                    <span class="badge fs-6 mb-1"
                                        style="background-color: #8FE2ED; color:#323232;">{{$job->service_needed}}</span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="card-body flex-grow-1">
                                <span class="fs-5 me-2 poppins-medium">{{ $event->title }}</span><br>
                                <strong class="note">Date & Time:</strong><br>
                                <span class="small"> {{ $event->start_date_formatted }} - {{ $event->end_date_formatted }}</span><br>
                                <strong class="note">Location:</strong><br>
                                <span>{{ $event->street }}, {{ $event->barangay }}, {{ $event->city }}</span><br>
                                <strong class="note">Budget:</strong><br>
                                <span> ₱{{ $event->budget_min }} - ₱{{ $event->budget_max }}</span>
                            </div>
                            <div class="mt-auto p-3 mb-1">
                                <a href="{{ route('client-viewpost', ['id' => $job->event->event_id]) }}"
                                    class="confirm h-100">View Post</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-muted text-center mt-4">No Available Events</p>
                @endif
            </div>
        </div>

        <!-- Hiring Request Tab --------------------------------------------------------------------------------------------------------------------->
        <div class="tab-pane fade" id="hiring-request" role="tabpanel" aria-labelledby="hiring-request-tab">
            @if($hiringRequests->isNotEmpty())
            <div class="row">
                <!-- Job Offers -->
                @foreach($hiringRequests as $job)
                <div class="col-lg-6 col-xl-4 mb-4">
                    <div class="card h-100 rounded-4 d-flex flex-column"
                        style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                        <div class="card-header d-flex justify-content-between align-items-center"
                            style="border-bottom: none;">
                            <div class="d-flex align-items-center">
                                <small class="note">Hiring as </small><br>
                                <span class="fs-6 poppins-medium text-uppercase badge"
                                    style="color: #91216C;">{{$team->package_service}}</span>
                            </div>
                        </div>

                        <div class="card-body flex-grow-1">
                            <span class="fs-5 me-2 poppins-medium">{{ $job->eventjob->event->title }}</span><br>
                            <strong class="note">Date & Time:</strong><br>
                            <span> {{ $job->eventjob->event->start_date_formatted }} -
                                {{ $job->eventjob->event->end_date_formatted }}</span><br>
                            <strong class="note">Location:</strong><br>
                            <span>{{ $job->eventjob->event->street }}, {{ $job->eventjob->event->barangay }},
                                {{ $job->eventjob->event->city }}</span><br>
                            <strong class="note">Budget:</strong><br>
                            <span> ₱{{ $job->eventjob->event->budget_min }} -
                                ₱{{ $job->eventjob->event->budget_max }}</span>
                        </div>

                        <!-- Divider Line -->
                        <hr class="my-1" style="margin-bottom: 0; border: 1px solid #ddd;">

                        <!-- Table and Buttons at Bottom -->
                        <div class="mt-auto p-3">
                            <table class="table table-borderless mb-2 w-100">
                                <thead>
                                    <tr class="text-center">
                                        <th class="note" style="white-space: nowrap;">Fee</th>
                                        <th class="note" style="white-space: nowrap;">Client's Offer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-center">
                                        <td>₱{{ $job->freelancer_pricing }}</td>
                                        <td>₱{{ $job->client_pricing }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-start">
                                @if($job->status != 'Rejected')
                                @if($job->dealer_user_type == 'freelancer' && $job->status != 'Accepted')
                                <a href="#" class="btn btn-rounded pending-color rounded-pill me-2"
                                    style="background-color: #D9D9D9;">Pending</a>

                                @elseif($job->dealer_user_type == 'client' && $job->status != 'Accepted')
                                <button data-bs-toggle="modal" data-bs-target="#modal-{{ $job->hiring_request_id }}"
                                    data-action="accept" data-modal-type="confirm-modal"
                                    data-hiringid="{{ $job->hiring_request_id }}" class="confirm btn-verify me-2">Accept
                                </button>

                                @elseif($job->status == 'Accepted')
                                <a href="{{route('freelancer-transaction')}}" class="confirm">View Transaction</a>
                                @endif

                                @if($job->status != 'Accepted')
                                <button data-bs-toggle="modal"
                                    data-bs-target="#negotiateModal-{{$job->hiring_request_id}}"
                                    class="confirm btn-seemore me-2" style="background-color: #8FE2ED; color: black;">
                                    Negotiate
                                </button>
                                <button data-bs-toggle="modal" data-bs-target="#modal-{{ $job->hiring_request_id }}"
                                    data-modal-type="confirm-modal" data-action="decline"
                                    data-hiringid="{{ $job->hiring_request_id }}" class="confirm"
                                    style="background-color: crimson;">
                                    Decline
                                </button>
                                @endif

                                @elseif($job->status == 'Rejected')
                                <button class="confirm" disabled style="color: white; background-color:lightpink;">
                                    Offer Declined
                                </button>
                                @endif
                            </div>
                            <!--modal component -->
                            <div wire:ignore>
                                <x-confirmation-modal :id="$job->hiring_request_id" title="Confirmation"
                                    message="Are you sure you want to decline this offer?" :actionUrl="''"
                                    method="POST" />
                            </div>

                            <!-- Negotiate Modal-->
                            @livewire('negotiate-modal', ['hiringRequestId' => $job->hiring_request_id,
                            'service' => $team])
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-muted text-center mt-4">No Hiring Requests</p>
            @endif
        </div>

    </div>

</div>

<style>
    .badge-notification {
        display: inline-block;
        background-color: #8FE2ED;
        color: black;
        border-radius: 50%;
        padding: 2px 6px;
        font-size: 12px;
        font-weight: bold;
        line-height: 1.2;
        margin-left: 8px;
        /* Adds space between text and badge */
        min-width: 20px;
        text-align: center;
    }

    .application-item {
        display: flex;
        justify-content: star;
        align-items: start;
    }

    .application-item img {
        border-radius: 8px;
        margin-bottom: 10px;
        /* Optional: Set a max-width or height if desired */
    }

    /* Tab-specific styling */
    .nav-tabs .nav-link {
        color: black;
        white-space: nowrap;
    }

    .nav-tabs .nav-link.active {
        color: #91216C;
        border: none;
    }

    .nav-tabs .nav-application {
        color: black;
        border: none;
        background: none;
        width: 150px;
        height: 40px;
        background-color: none;
    }

    .nav-tabs .nav-application.active {
        color: #91216C;
        border: none;
        background-color: none;
        background-color: #E1C1D7;
        border-radius: 50px;
        height: 40px;
    }

    .tab-content {
        margin-top: 20px;
    }

    .hiring-request-section form {
        display: flex;
        flex-direction: column;
    }

    .hiring-request-section label {
        margin-top: 10px;
    }

    .hiring-request-section input {
        padding: 10px;
        border-radius: 5px;
        margin-top: 5px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
    }

    .hiring-request-section button {
        margin-top: 20px;
        padding: 10px;
        border: none;
        background-color: #007bff;
        color: white;
        border-radius: 5px;
        cursor: pointer;
    }

    .hiring-request-section button:hover {
        background-color: #0056b3;
    }
</style>
@endsection