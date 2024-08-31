@extends('layouts.app')

@section('content')
<div class="container my-4 pb-2">
    <a href="{{ url('/client-events') }}" style="text-decoration:none; color:black;">
        <i class="fas fa-arrow-left me-2 mb-4"></i>Back
    </a>

    <!-- Event Details -->
    <div class="row">
        <div class="col-md-8 pb-4" style="border-radius:12px;">
            <h3 class="mt-2 pb-0 poppins-medium pt-2">{{$event->title}}</h3>
            <p class="text-muted">Posted {{ $event->created_at->diffForHumans() }}</p>
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
        </div>


        <!-- Event Jobs -->
        <div class="card col-md-4" style="border-radius: 15px; background-color:white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); border:none;">
            <div class="card-body poppins-medium">
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
    <div class="card mt-4 py-2">
        <div class="container mt-2">
            <!-- Nav tabs -->
            <ul class="nav nav-fill pt-2 poppins-medium" style="background-color: #FCF2F9; position: relative;">
                @foreach ($tabs as $tabId => $tabName)
                <li class="nav-item">
                    <a class="nav-link {{ $tabId === 'application' ? 'active' : '' }}"
                        id="{{ $tabId }}-tab"
                        data-bs-toggle="tab"
                        href="#{{ $tabId }}"
                        role="tab"
                        aria-controls="{{ $tabId }}"
                        aria-selected="{{ $tabId === 'application' ? 'true' : 'false' }}"
                        style="color:black; position:relative;">
                        <h6>
                            {{ $tabName }}
                            <span class="badge text-black" style="background-color: #8FE2ED; border-radius:150px">
                                {{ $badgeCounts[$tabId] }}
                            </span>
                        </h6>
                    </a>
                </li>
                @endforeach
            </ul>

            <!-- Tab content -->
            <div class="tab-content">

                <!-- Application Tab -->
                <div class="tab-pane fade show active" id="application" role="tabpanel" aria-labelledby="application-tab">
                    <div class="application-content mt-4">
                        <div class="row mb-4">
                            @if($applicants->isNotEmpty())
                            @foreach ($applicants as $applicant)
                            <div class="col-12 col-md-4 mb-3">
                                <div class="card p-3 rounded-4" style="border:none; background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                    <!-- Upper Part -->
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <div>
                                            <small class="mb-0">Applying as </small><br>
                                            <span class="fw-bold text-uppercase p-1" style="color: #91216C; background-color:whitesmoke; border-radius:12px;">{{ $applicant->role }}</span>
                                        </div>
                                        <div>
                                            <small class="mb-0">Service Fee:</small><br>
                                            <span class="fw-bold p-1" style="background-color:whitesmoke; border-radius:12px;">{{ $applicant->fee }}</span>
                                        </div>
                                    </div>
                                    <hr class="mb-2" style="color:#CBCACA;">
                                    <!-- Profile Info -->
                                    <div class="d-flex pb-3 pt-0">
                                        <img src="{{ $applicant->profile_image }}" alt="Profile Image" class="rounded-circle ms-2" style="width: 60px; height: 60px; object-fit: cover;">
                                        <div class="ms-4">
                                            <h6 class="mb-0">{{ $applicant->name }}</h6>
                                            <p class="text-muted mb-0">{{ $applicant->location }}</p>
                                            <small class="text-success mb-0">{{ $applicant->projects_done }} Projects done</small>
                                        </div>
                                        <div class="ms-auto text-end">
                                            <span class="badge text-black">{{ $applicant->rating }}</span>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-flex flex-column flex-sm-row align-items-center" style="width: 100%;">
                                        <button class="btn me-2 mb-2 mb-sm-0" style="flex: 1; width: 100%; white-space:nowrap; color:white; background-color:#91216C; border:none; border-radius: 20px">See Profile</button>
                                        <button class="btn btn-primary me-2 mb-2 mb-sm-0" data-bs-toggle="modal" data-bs-target="#hireModal" style="flex: 1; width: 100%; color:black; background-color:#8FE2ED; border:none; border-radius: 20px">Hire</button>
                                        <button class="btn mb-2 mb-sm-0" style="flex: 1; width: 100%; background-color:none; border-color:darkgrey; border-radius: 20px">Reject</button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else 
                            <p class="text-center open-sans-reg fs-5 my-3">No Applicants</p>
                            @endif 
                        </div>
                    </div>
                </div>

                <!-- Hiring Requests Tab -->
                <div class="tab-pane fade" id="hiring-requests" role="tabpanel" aria-labelledby="hiring-requests-tab">
                    <div class="application-content mt-4">
                        <div class="row mb-4">
                            @if($hiringRequests->isNotEmpty())
                            @foreach ($hiringRequests as $hiring)
                            <div class="col-12 col-md-4 mb-3">
                                <div class="card p-3 rounded-4" style="border:none; background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                    <!-- Upper Part -->
                                    <div class="d-flex justify-content-between align-items-center mb-0">
                                        <div>
                                            <small class="mb-0">Hiring as </small><br>
                                            <span class="fw-bold text-uppercase p-1" style="color: #91216C; background-color:whitesmoke; border-radius:12px;">{{ $hiring->role }}</span>
                                        </div>
                                        <div>
                                            <small class="mb-0">Service Fee:</small><br>
                                            <span class="fw-bold p-1" style="background-color:whitesmoke; border-radius:12px;">{{ $hiring->fee }}</span>
                                        </div>
                                    </div>
                                    <hr class="mb-2" style="color:#CBCACA;">
                                    <!-- Profile Info -->
                                    <div class="d-flex pb-3 pt-0">
                                        <img src="{{ $hiring->profile_image }}" alt="Profile Image" class="rounded-circle ms-2" style="width: 60px; height: 60px; object-fit: cover;">
                                        <div class="ms-4">
                                            <h6 class="mb-0">{{ $hiring->name }}</h6>
                                            <p class="text-muted mb-0">{{ $hiring->location }}</p>
                                            <small class="text-success mb-0">{{ $hiring->projects_done }} Projects done</small>
                                        </div>
                                        <div class="ms-auto text-end">
                                            <span class="badge text-black">{{ $hiring->rating }}</span>
                                        </div>
                                    </div>

                                    <!-- Table Negotiation -->
                                    <div class="d-flex table-responsive mt-1 mb-2 text-center">
                                        <table class="table table-bordered offer-table">
                                            <thead>
                                                <tr>
                                                    <th>Freelancer's Offer</th>
                                                    <th>Your Offer</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>₱600 per hour</td>
                                                    <td>₱500 per hour</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-flex flex-column flex-sm-row align-items-center" style="width: 100%;">
                                        <button class="btn me-2 mb-2 mb-sm-0 negotiate-btn" data-bs-toggle="modal" data-bs-target="#negotiateModal" style="flex: 1; width: 100%; white-space:nowrap; color:white; background-color:#91216C; border:none; border-radius: 20px">Negotiate</button>
                                        <button class="btn btn-primary me-2 mb-2 mb-sm-0" style="flex: 1; width: 100%; color:black; background-color:#8FE2ED; border:none; border-radius: 20px">Accept Offer</button>
                                        <button class="btn mb-2 mb-sm-0" style="flex: 1; width: 100%; background-color:none; border-color:darkgrey; border-radius: 20px">Cancel</button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else 
                            <p class="text-center open-sans-reg fs-5">No Hiring Requests</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Recommendation Tab -->
                <div class="tab-pane fade" id="recommendation" role="tabpanel" aria-labelledby="recommendation-tab">
                    <div class="application-content mt-4">
                        <div class="row mb-4">
                            @foreach ($recommendations as $recomm)
                            <div class="col-12 col-md-4 mb-3">
                                <div class="card p-3 rounded-4" style="border:none; background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                    <!-- Profile Info -->
                                    <div class="d-flex pb-0 pt-0">
                                        <img src="{{ $recomm->user->profile_image}}" alt="Profile Image" class="rounded-circle ms-2" style="width: 60px; height: 60px; object-fit: cover;">
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
                                            @if($recomm->avg_rating)
                                            <span class="badge text-black">{{ $recomm->avg_rating }}</span>
                                            @else
                                            <span class="badge text-black">No ratings yet</span>
                                            @endif
                                        </div>
                                    </div>
                                    <hr class=" p-0 m-1" style="color:#CBCACA;">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <small class="mb-0 ms-2">Service/s</small><br>
                                            <div class="col ms-2">
                                                @foreach($recomm->services as $service)
                                                <span class="fw-bold p-1 me-2" style="color: black; background-color:whitesmoke; border-radius:12px;">{{ $service->job_title }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-flex flex-column flex-sm-row align-items-center" style="width: 100%;">
                                        <button class="btn me-2 mb-2 mb-sm-0" style="flex: 1; width: 100%; white-space:nowrap; color:white; background-color:#91216C; border:none; border-radius: 20px">See Profile</button>
                                        <button class="btn btn-primary me-2 mb-2 mb-sm-0" data-bs-toggle="modal" data-bs-target="#hireModal" style="flex: 1; width: 100%; color:black; background-color:#8FE2ED; border:none; border-radius: 20px">Hire</button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Hire Modal -->
        @include('modals.hire_modal')

        <!-- Negotiate Modal-->
        @include('modals.negotiate_modal')
    </div>
</div>
@endsection