@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Profile Header -->
    <div class="my-4 profile-header">
        <div class="image ms-4">
            <img src="{{asset('storage/' .$team->team_profilepic)}}" alt="Party Needs" class="rounded-circle" style="height: 200px; width: 200px; max-width: 200px; max-height: 200px; object-fit: cover;">
        </div>
        <div class="details px-4 ms-4">
            <div class="d-flex">
                <h1 class="d-flex fs-sm-name fs-md-name text-start mb-0 poppins-medium">{{$team->team_name}}</h1>
                @if($allMembersVerified)
                <small style="text-align:end;"> All members verified </small>
                @endif
            </div>

            <!--review details-->
            <div class="d-flex align-items-center mb-3">
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
                        <!-- <div class="col-auto p-0 ms-1">
                        @if($team->reviews->isNotEmpty())
                        @if($totalReviews > 1)
                        <span class="note">({{$totalReviews}})</span>
                        @else
                        <span class="note">({{$totalReviews}})</span>
                        @endif
                        @endif
                    </div> -->

                    </div>
                </div>
                @endif
                <div class="team-code ms-4 ps-4">
                    Team Code: <strong>{{$team->team_code}}</strong>
                </div>
            </div>

            <div class="package-fee mb-3">
                Package Offer: <strong>{{$team->package_service}}</strong>
            </div>

            <div class="package-fee mb-3">
                Package Fee: <strong>Php {{$team->package_price}}</strong>
            </div>
            <div class="description me-4 pe-4">
                {{$team->team_description}}
            </div>
        </div>
        <div class="align-items-start" style="position: absolute;top: 100px; right: 120px; font-size: 16px;">
            <i class="fas fa-pencil"></i>
        </div>
    </div>


    <!-- Tabs for Profile, Applications, Hiring Request and Jobs -------------------------------------------------------------------------------------------------------------------------------------------------->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">Profile</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="application-tab" data-bs-toggle="tab" data-bs-target="#application" type="button" role="tab" aria-controls="application" aria-selected="false">Application<span class="badge-notification">{{$appliedJobsCount}}</span></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="hiring-request-tab" data-bs-toggle="tab" data-bs-target="#hiring-request" type="button" role="tab" aria-controls="hiring-request" aria-selected="false">Hiring Request<span class="badge-notification">3</span></button>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="jobs-tab" data-bs-toggle="tab" data-bs-target="#jobs" type="button" role="tab" aria-controls="jobs" aria-selected="false">Jobs Available<span class="badge-notification">{{$eventsCount}}</span></button>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="myTabContent">
        <!-- Profile Tab -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
        <div class="tab-pane show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="row">
                <!-- Team Members Section -->
                <span class="poppins-medium fs-5">Team Members<small>({{$membersCount}})</small></span>
                <div class="col-lg-6 col-md-6 team-members" style="height: 400px; overflow-y: auto;">
                    @foreach($teamMembers as $member)
                    <div class="team-member d-flex justify-content-between align-items-center">
                        <div class="col member-info d-flex justify-content-start align-items-center">
                            <img src="{{$member->user->profile_image_url}}" alt="Member" style="margin-right: 10px; max-width: 50px; max-height: 50px; object-fit: cover;">
                            <div>
                                <p class="member-name" style="margin: 0; line-height: 1; white-space: nowrap;">{{$member->user->fullName()}}</p>
                                @if($team->team_leader === $member->user_id)
                                <span class="fw-bold fs-smaller text-start text-purple px-3 py-1">Admin</span>
                                @else
                                <span class="badge rounded-pill bg-light text-dark">Member</span>
                                @endif
                                </br>
                                <!--services-->
                                @foreach($member->services as $service)
                                <p class="fs-smaller text-muted badge rounded-pill bg-light text-dark" style="margin: 0;">{{$service->job_title}}</p>
                                @endforeach
                                @if($member->avg_rating > 0)
                                <p style="margin: 0;">★ {{ number_format($member->avg_rating, 1) }}</p>
                                @else
                                <p style="margin: 0;" class="text-muted fs-smaller">No ratings yet</p>
                                @endif
                            </div>
                        </div>
                        <div class="col">
                            <div class="status text-center text-success">Available</div>
                        </div>

                        <!--Tooltip for actions -->

                        @if(auth()->user()->id === $team->team_leader && $member->user_id !== $team->team_leader )
                        <div class="dropdown">
                            <button class="btn btn-light border-0 p-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                                <li><a class="dropdown-item" href="#">Edit service</a></li>
                                <li><a class="dropdown-item text-danger" href="#">Leave team</a></li>
                            </ul>
                        </div>
                        @endif





                    </div>
                    @endforeach
                </div>
                <div class="col ms-4 ps-2">
                    <div class="row">
                        <!-- Terms of Service -->
                        <div class="col-lg-12 col-md-6 terms-of-service">
                            <span class="poppins-medium fs-5">Terms of Services</span>
                            <p>{{$team->terms_of_services}}</p>
                        </div>
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
                <p class="text-center mt-5 text-muted fs-4">No Applications</p>
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
                                <span> {{ $event->start_date_formatted }} - {{ $event->end_date_formatted }}</span><br>
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
                <p class="text-muted text-center mt-4 fs-4">No Available Events</p>
                @endif
            </div>
        </div>

        <!-- Hiring Request Tab --------------------------------------------------------------------------------------------------------------------->
        <div class="tab-pane fade" id="hiring-request" role="tabpanel" aria-labelledby="hiring-request-tab">
            <p>Helo</p>
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

    .profile-header {
        display: flex;
        justify-content: center;
        align-items: center;
        padding-bottom: 10px;
        margin-bottom: 15px;
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
        width: 250px;
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

    .team-member {
        padding: 15px;
        background-color: white;
        border-radius: 10px;
        margin-bottom: 10px;
        box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.1);
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