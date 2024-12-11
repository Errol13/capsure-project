@extends('layouts.app')

@section('content')
<div class="container mb-4 pb-4">
    <div class="row justify-content-center pb-2">

        <!-- Search Filter and Create Event Button -->
        <livewire:client.search-filter />

        <div class="row mx-4 pt-3">
            <h3 class="poppins-medium text-center">Services For You</h3>
        </div>

        <!-- Solo Freelancers Services -->
        <div class="row">
            <div class="col-align mb-2 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <img src="assets/solo.svg" class="inside-icon me-1">
                    <h4 class="poppins-regular mb-0">Freelancers</h4>
                </div>
            </div>

            <livewire:client-home />

            <!-- Team Freelancers Services -->
            <div class="row py-3">
                <div class="col-align mb-2 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <img src="assets/team.svg" class="inside-icon me-1" style="width: 40px; height: 40px">
                        <h4 class="poppins-regular mb-0">Team Freelancers</h4>
                    </div>
                    <a class="poppins-light fs-5 mb-0 text-purple right-side" href="#">View All</a>
                </div>

                <!-- Responsive Grid Layout -->
                <div class="row g-3 justify-content-center">
                    @if($teams)
                    @foreach($teams as $team)
                    <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center">
                        <div class="card shadow-box" style="width: 18rem; border-radius: 15px; border:none; box-shadow:1px 1px 5px rgba(0, 0, 0, 0.3);">
                            <div class="card-body open-sans-reg p-3">

                                <!-- Package Details Section -->
                                <div class="d-flex justify-content-between mb-3">
                                    <h5 class="card-title poppins-medium mb-0">{{$team->package_service}}</h5>
                                    <h5 class="poppins-medium fs-5 mb-0">{{$team->package_price}}</h5>
                                </div>

                                <ul class="list-unstyled text-center mb-3 px-3 py-3" style="background-color: #F6F2F2; width: 100%; height: 150px; object-fit: cover;">

                                    <!--count the services-->
                                    @php
                                    // Initialize an array to store the count of each service title
                                    $serviceCount = [];

                                    // Iterate through the team's services
                                    foreach($team->getServices() as $service) {
                                    // Count the occurrences of each service title
                                    if (isset($serviceCount[$service->job_title])) {
                                    $serviceCount[$service->job_title]++;
                                    } else {
                                    $serviceCount[$service->job_title] = 1;
                                    }
                                    }
                                    @endphp

                                    @foreach($serviceCount as $title => $count)
                                    <p>{{ $count }} {{ $title }}@if($count > 1){{ 's' }}@endif</p>
                                    @endforeach
                                </ul>

                                <div class="d-flex align-items-center">
                                    <img src="{{asset('storage/' . $team->team_profilepic)}}" class="rounded-circle" alt="profile" style="width: 50px; height: 50px;">
                                    <div class="ms-3">
                                        <p class="card-text open-sans-reg fw-bold mb-0">{{$team->team_name}}</p>
                                        <p class="card-text open-sans-light small mb-0 text-truncate">{{$team->description}}</p>
                                        @if($team->number_of_projects)
                                        <p class="card-text open-sans-light fs-smaller text-success mb-0">No. of projects:{{number_format($team->number_of_projects)}}</p>
                                        @endif
                                    </div>
                                    @if($team->avg_rating > 0)
                                    <div class="ms-auto text-end">
                                        <span class="text-warning me-1">★</span>
                                        <span class="fw-bold">{{$team->avg_rating}}</span>
                                        <span class="text-muted small ms-1">({{$team->totalReviews()}})</span>
                                    </div>
                                    @else
                                    <p class="text-muted text-nowrap small">No ratings yet</p>
                                    @endif
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <a href="{{route('team-profile-view', ['id' => $team->team_id])}}" class="btn-round btn-seeprof" style="border: 1px solid #8b206a; color:#8b206a;">See Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <p class="text-muted fs-6 text-center">No team freelancers.</p>
                    @endif
                </div>
            </div><!--end for team-->

        </div>
    </div>
</div>
@endsection