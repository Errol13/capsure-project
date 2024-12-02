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
    </div>

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
</style>
@endsection