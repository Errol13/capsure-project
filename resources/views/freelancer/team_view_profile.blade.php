@extends('layouts.app')

@section('content')
<div class="container py-2 my-3">
    <!-- Profile Header -->
    <div class="container rounded-4" style="background-color: #FCF2F9; box-shadow:1px 1px 2px rgba(0, 0, 0, 0.3);">
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

                        <div class="d-flex align-items-center my-2">
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
                                            @for ($i = 1; $i <= 5; $i++) @if ($i <=floor($team->avg_rating))
                                                <i class="fas fa-star filled"></i> <!-- Filled star -->
                                                @elseif ($i == ceil($team->avg_rating) && $team->avg_rating -
                                                floor($team->avg_rating) > 0)
                                                <i class="fas fa-star-half-alt filled"></i> <!-- Half star -->
                                                @else
                                                <i class="far fa-star"></i> <!-- Empty star -->
                                                @endif
                                                @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="package-fee">
                            Package Offer: <strong>{{$team->package_service}}</strong>
                        </div>

                        <div class="package-fee mb-3">
                            Package Fee: <strong>Php {{$team->package_price}}</strong>
                        </div>
                        <small class="description" style="line-height: 1.2;">{{$team->team_description}}</small>
                    </div>

                    <div class="col-auto me-3">
                        <div class="d-flex justify-content-start align-items-center mt-2 mt-lg-0">
                            <a href="#" class="text-center btn-seemore rounded-start-1 px-2 py-1 px-md-4 poppins-medium fs-sm">HIRE THE TEAM</a>
                            <button type="submit" class="btn border-0 m-0 p-0">
                                <i class="fas fa-comment text-purple fs-6 me-4 rounded-end-1 border border-1 px-3 py-2 me-3 me-md-4" style="background-color: white;cursor: pointer;"></i>
                            </button>
                            <i class="bi bi-person-fill-exclamation fs-4"
                                style="color: crimson; cursor: pointer;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                <div class=" p-3 mb-3 rounded-4 border-0" style="background-color:white;">
                    <div class="col team-member d-flex justify-content-between align-items-center">
                        <div class=" member-info d-flex justify-content-start align-items-start ms-1">
                            <img src="{{$member->user->profile_image_url}}" alt="Member" style="margin-right: 10px; max-width: 50px; max-height: 50px; object-fit: cover;">
                            <div>
                                <div style="line-height: 1;">
                                    <p class="member-name" style="margin: 0; white-space: nowrap;">{{$member->user->fullName()}}</p>
                                    @if($team->team_leader === $member->user_id)
                                    <span class="fw-bold fs-smaller text-start txt-purple note py-1">Admin</span>
                                    @else
                                    <span class="badge rounded-pill bg-light text-dark">Member</span>
                                    @endif
                                </div>
                                @if($member->avg_rating > 0)
                                <small style="margin: 0;">★ {{ number_format($member->avg_rating, 1) }}</small>
                                @else
                                <small style="margin: 0;" class="text-muted fs-smaller fst-italic">No ratings yet</small>
                                @endif
                                <div class="col">
                                    @foreach($member->services as $service)
                                    <span class="text-start badge rounded-pill me-1" style="background-color:aliceblue; color:gray;">
                                        {{$service->job_title}}
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-end m-3">
                            <div class="status text-center text-success">Available</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col col-lg-8 poppins-regular my-3">
            <div class="row flex-grow-1">
                <!-- Terms of Service -->
                <div class="col-lg-12 col-md-6 terms-of-service">
                    <h5 class="poppins-medium">Terms of Services</h5>
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
            </div>
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
</style>
@endsection