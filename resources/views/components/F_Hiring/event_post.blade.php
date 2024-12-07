@extends('layouts.app')

@section('content')
<div class="container my-4 pb-2">
    <a href="#" onclick="window.history.back(); return false;" style="text-decoration:none; color:black;">
        <i class="fas fa-arrow-left me-2 mb-4"></i>Back

    </a>

    <!-- Event Details -->
    <div class="row">
        <div class="col-md-8 pb-4" style="border-radius:12px;">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mt-2 pb-0 poppins-medium pt-2">{{$event->title}}</h3>
                <span class=" {{$event->status == 'Open'? 'text-success': 'text-danger' }} fs-6 fw-bold letter-spacing mt-2 text-uppercase">{{$event->status}}</span>
            </div>
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
            <p class="mt-3">{!! nl2br(e($event->description)) !!}</p>
            <hr>

            <!--Client Profile -->
            <div class="row mt-2">

                <div class="col-12 col-md-12 flex-grow-1 mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h5 class="text-start mb-0 poppins-medium me-2">CLIENT</h5>
                        </div>
                        <a class="fs-sm fs-md poppins-medium text-purple" href="{{route('view-client-profile', ['id' => $event->client_id] ) }}">See Profile</a>
                    </div>

                    <div class="d-flex">
                        <div class="text-center me-3">
                            <!-- Profile Picture -->
                            <img src="{{ $clientUser->profile_image_url }}" alt="Reviewer Profile" class="img-fluid rounded-circle" style="width: 60px; height: 60px;">
                        </div>
                        <div>
                            <!-- Profile Content -->
                            <h5 class="poppins-medium mb-0">{{$clientUser->first_name}} {{$clientUser->last_name}}</h5>
                            <span class="fs-sm mt-1 mb-0">{{$clientUser->city}}</span>
                            <div>
                            @if($clientUser->client->avg_rating == 0)
                            <small class="open-sans-reg light-color-prof mt-1 fst-italic note">No ratings yet</small>
                            @else
                            <!-- Star Rating Container -->
                            <div class="star-rating mt-0 mt-md-1">
                                <div class="row">
                                    <div class="col-auto">
                                        <p class="mb-0 fs-sm fs-md">{{ number_format($clientUser->client->avg_rating, 1) }}</p>
                                    </div>
                                    <div class="col">
                                        <div class="d-flex align-items-center mt-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $clientUser->client->avg_rating ? 'filled' : '' }}"></i>
                                                @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            </div>
                        </div>
                    </div>

                    <!--Client's Event Post Details -->
                    <div class="row mt-2">
                        <div class="col-4">
                            <div class="d-flex flex-column align-items-center open-sans-reg">
                                <div class="d-flex mt-2 align-items-center">
                                    <p class="fs-sm fs-md fw-bold me-2 mb-0">{{$TotalPosts}}</p>
                                    <p class="fs-sm fs-md txt-reviewer mb-0">Events Posted</p>
                                </div>
                                <span class="fs-sm fs-md text-muted text-start mt-1">Total number of events posted by the client.</span>
                            </div>

                        </div>

                        <div class="col-5">
                            <div class="d-flex flex-column align-items-center open-sans-reg">
                                <div class="d-flex mt-2 align-items-center">
                                    @if($hiringSuccessRate == 0)
                                    <p class="fs-sm fs-md fw-bold me-2 mb-0">0%</p>
                                    @else
                                    <p class="fs-sm fs-md fw-bold me-2 mb-0">{{ number_format($hiringSuccessRate, 2) }}%</p>
                                    @endif
                                    <p class="fs-sm fs-md txt-reviewer mb-0">Hiring Success Rate</p>
                                </div>
                                <span class="fs-sm fs-mdtext-muted text-start mt-1">Represents how often a client successfully hires after posting an event.</span>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="d-flex flex-column align-items-center open-sans-reg">
                                <div class="d-flex mt-2 align-items-center">
                                    <p class="fs-sm fs-md fw-bold me-2 mb-0">Member since</p>
                                </div>
                                <span class="fs-sm fs-mdtext-muted text-start mt-1">{{date_format($clientUser->date_joined, 'F j, Y')}}.</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <!-- Event Jobs -->
        <div class="card col-md-4" style="border-radius: 15px; background-color:white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); border:none;">
            <div class="card-body poppins-medium">

                <div class="row my-2 p-2">

                    <!--if the event is closed, the apply button should be disabled-->
                    @if($event->status == 'Open')
                    <button type="button" class="fs-4 rounded-pill btn-seemore border-0 px-5 text-center mb-2 poppins-medium" data-bs-toggle="modal" data-bs-target="#applyJobModal">
                        APPLY JOB
                    </button>

                    @if($freelancer->team && $freelancer->team->isLeader())
                    <p class="my-1 text-center or-line" style="color: gray;">or</p>
                    <button type="button" class="fs-4 btn-confirm border-0 btn-verify px-5 text-center mb-2 poppins-medium" data-bs-toggle="modal" data-bs-target="#applyJobTeamModal">
                        APPLY AS A TEAM
                    </button>
                    @include('modals.Hiring.team_apply', ['eventJobs' => $eventJobs, 'team' => $freelancer->team, 'completedHiredCounts'=> $completedHiredCounts] )
                    @endif
                    @else
                    <button type="button" class="fs-4 rounded-pill border-0 btn btn-secondary px-5 text-center mb-2 poppins-medium" data-bs-toggle="modal" data-bs-target="#applyJobModal" disabled>
                        APPLY JOB
                    </button>
                    @endif

                </div>
                @include('modals.apply_job_modal', ['eventJobs' => $eventJobs, 'freelancer' => $freelancer, 'completedHiredCounts'=> $completedHiredCounts] )



                <h4>Event Jobs</h4>
                <ul class="list-group">
                    @foreach($eventJobs as $eventJob)
                    <li class="list-group-item d-flex justify-content-between align-items-center" style="background-color: white;">
                        <span>{{$eventJob->number_of_people}}</span>
                        {{$eventJob->service_needed}}

                        @php
                        // Get the hired count for the current job, or default to 0 if not set
                        $completedHiredCount = $completedHiredCounts->get($eventJob->job_id, 0);
                        @endphp

                        <!-- Display badges based on the count -->
                        @if($completedHiredCount == 0)
                        <span class="badge bg-success badge-custom rounded-pill">Available</span>
                        @elseif($eventJob->number_of_people == $completedHiredCount)
                        <span class="badge bg-danger badge-custom rounded-pill">Not Available</span>
                        @else
                        <span class="badge bg-primary badge-custom rounded-pill">{{ $completedHiredCount }} Hired</span>
                        @endif

                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>


</div>

@endsection