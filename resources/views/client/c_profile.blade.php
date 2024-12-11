@extends ('layouts.app')

@section('content')
<div class="container py-2 my-3">
    <div class="container rounded-4" style="background-color: #FCF2F9; box-shadow:1px 1px 2px rgba(0, 0, 0, 0.3);">
        <div class="row d-flex justify-content-center">
            <div class="col-5 col-md-4 col-lg-4">
                <!--Profile Pic and Personal Information -->
                <div class="row my-3">
                    <div class="profile-container d-flex justify-content-center align-items-center">
                        <img src="{{ $user->profile_image_url}}" alt="Profile Picture" class="rounded-circle img-fluid">
                    </div>
                </div>

                <!-- Social Media Accounts -->
                <div class="row my-2 text-center">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="d-flex align-items-center">
                            <a href="{{ $socialMediaLinks['Facebook'] ?? '#' }}" target="_blank">
                                <img class="socmed-container" src="{{ asset('assets/Facebook.svg') }}" alt="Facebook">
                            </a>
                        </div>
                        <div class="ms-1 ">
                            <a href="{{ $socialMediaLinks['LinkedIn'] ?? '#' }}" target="_blank">
                                <img class="socmed-container" src="{{ asset('assets/LinkedIn.svg') }}" alt="LinkedIn">
                            </a>
                        </div>
                        <div class="ms-1">
                            <a href="{{ $socialMediaLinks['Instagram'] ?? '#' }}" target="_blank">
                                <img class="socmed-container" src="{{ asset('assets/Instagram.svg') }}" alt="Instagram">
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-7 col-md-8 col-lg-8 ps-4">
                <div class="row my-3">
                    <!-- Full Name and Verification Status -->
                    <div class="col-12 col-md-12 mt-2">
                        <div class="d-flex align-items-center">
                            <h5 class="fs-md-name text-start mb-0 me-2 poppins-medium">
                                {{ $fullName }}
                            </h5>
                            @if($user->isVerified)
                            <span class="d-flex align-items-center note">
                                <i class="fas fa-check-circle verify-icon me-1" title="Verified"></i>
                                Verified
                            </span>
                            @endif
                        </div>
                    </div>
                    <span class="note">{{$user->age}} years old</span>

                    <div class="my-2 d-flex align-items-center">
                        @php
                        $totalReviews = $user->client->reviews()->where('reviewee_role', 'client')->count();
                        @endphp

                        @if($user->client->avg_rating == 0)
                        <span class="fs-6 open-sans-reg light-color-prof fst-italic text-muted">No ratings yet</span>
                        @else
                        <h6 class="mb-0 me-4">Rating:</h6>
                        <!-- Star Rating Container -->
                        <div class="star-rating">
                            <div class="row">
                                <div class="col-auto p-0 me-1">
                                    <span class="mb-0 fs-sm fs-md">{{ number_format($user->client->avg_rating, 1) }}</span>
                                </div>
                                <div class="col-auto p-0">
                                    <div class="d-flex align-items-center mt-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <=floor($user->client->avg_rating))
                                            <i class="fas fa-star filled"></i> <!-- Filled star -->
                                            @elseif ($i == ceil($user->client->avg_rating) && $user->client->avg_rating - floor($user->client->avg_rating) > 0)
                                            <i class="fas fa-star-half-alt filled"></i> <!-- Half star -->
                                            @else
                                            <i class="far fa-star"></i> <!-- Empty star -->
                                            @endif
                                            @endfor
                                    </div>
                                </div>
                                <div class="col-auto p-0 ms-1">
                                    @if($user->client->reviews->isNotEmpty())
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
                    </div>

                </div>

                <!--Address and Contacts -->
                <div class="row my-2 text-start">
                    <div class="col-12 d-flex align-items-center justify-content-start">
                        <i class="fas fa-location-dot text-purple"></i>
                        <small class="text-start ms-2" style="line-height: 1;">
                            <span>{{$user->street}}</span>
                            <span>{{$user->barangay}}</span>
                            <span>{{$user->city}}</span>
                        </small>
                    </div>
                    <div class="col-12 d-flex align-items-center justify-content-start my-2">
                        <i class="fas fa-sharp fa-thin fa-envelope text-purple"></i>
                        <small class="text-start ms-2">{{$user->email}}</small>
                    </div>
                    <div class="col-12 d-flex align-items-center justify-content-start">
                        <i class=" fas fa-solid fa-phone text-purple"></i>
                        <small class="text-start ms-2">{{$user->contact_number}}</small>
                    </div>
                </div>

                <p class="mt-3 open-sans-reg light-color-prof fs-sm">Member since <strong>{{date_format($user->date_joined, 'F j, Y')}}</strong></p>
            </div>
        </div>
    </div>

    <div class="row d-block d-lg-flex justify-content-center">
        <div class="col col-lg-4 my-3">
            <div class="container row my-3 mx-0 flex-grow-1 ">
                <!-- Events Posted -->
                <div class="card p-3 rounded-4 border-0" style=" background-color:white; box-shadow:1px 1px 2px rgba(0, 0, 0, 0.3);">
                    <div class="row align-items-center">
                        <div class="col-12 d-flex justify-content-center align-items-center">
                            <h1 class=" fs-md-3 me-2 mb-0 fw-bold" style="color: #91216C;">{{$user->client->events->count()}}</h1>
                        </div>
                        <h5 class=" fs-md-4 mb-0 poppins-medium light-color-prof me-3 text-center" style="white-space: nowrap;">Events posted</h5>
                        <a href="#" class="fs-sm poppins-medium justify-content-center text-center text-purple" style="white-space: nowrap;text-decoration:none;">
                            See Posts
                        </a>
                    </div>
                    <div class="row mt-1">
                        <small class="text-center" style=" color:darkgray;">Total number of events posted by the client.</small>
                    </div>
                </div>
            </div>

            <div class="container row my-3 mx-0 flex-grow-1">
                <!-- Hiring Success Rate -->
                <div class="card p-3 border-0 rounded-4" style="background-color:white;box-shadow:1px 1px 2px rgba(0, 0, 0, 0.3);">
                    <div class="row align-items-center">
                        <div class="col-12 justify-content-center align-items-center">
                            <h1 class="fs-md-4 fw-bold text-center" style="color: #91216C;">
                                @if($hiringSuccessRate == 0)
                                0%
                                @else
                                {{ number_format($hiringSuccessRate, 1) }}%
                                @endif
                            </h1>
                            <h5 class="text-center fs-md-4 mt-0 poppins-medium light-color-prof" style="white-space: nowrap;">Hire Success Rate</h5>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <small class="text-center" style="line-height: 1; color:darkgray;">Represents how often a client successfully hires after posting an event.</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col col-lg-8 poppins-regular my-3">
            <!--Freelancer Review -->
            <section id="client-reviews">
                <div class="d-flex justify-content-between align-items-center my-3">

                    <!--count the reviews for client -->
                    @php
                    $totalReviews = $user->client->reviews()->where('reviewee_role', 'client')->count();
                    @endphp
                    <div class="d-flex align-items-center">
                        <h5 class="text-start poppins-medium mb-2 me-2">Freelancer's Reviews</h5>
                        @if($user->client->reviews->isNotEmpty())
                        @if($totalReviews > 1)
                        <span class="mb-1 fs-smaller ">({{$totalReviews}} reviews)</span>
                        @else
                        <span class="mb-1 fs-smaller">({{$totalReviews}} review)</span>
                        @endif
                        @endif
                    </div>
                    @if($totalReviews > 0)
                    <a class="poppins-light text-purple" style="font-size:small;" href="#">See All Reviews</a>
                    @endif
                </div>


                @if($totalReviews === 0)
                <p class="text-center text-muted">No reviews</p>
                @else
                <!-- Reviews -->
                @foreach($eventsWithReviews as $eventsWithReview)

                @php
                $start_date_formatted = \Carbon\Carbon::parse($eventsWithReview->start_date)->format('M j, Y');
                $end_date_formatted = \Carbon\Carbon::parse($eventsWithReview->end_date)->format('M j, Y');
                @endphp

                <div class="container card rounded-4" style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                    <div class="row d-flex align-items-center justify-content-center">
                        <!-- Review Item 1 -->
                        <div class="card-header d-flex align-items-center rounded-top-4" style="border-bottom: none; background-color:#FCF2F9;">
                            <div class="row align-items-center w-100">
                                <div class="col">
                                    <h2 class="text-start mb-0 fs-sm fs-md poppins-medium me-2">{{$eventsWithReview->title}}</h2>
                                    <span class="note">{{$start_date_formatted}} - {{$end_date_formatted}}</span>
                                </div>
                                <div class="col-auto ms-auto">
                                    <a class="note fw-medium poppins-light text-purple" href="{{route('client-viewpost', ['id' => $eventsWithReview->event_id] )}}">See Post</a>
                                </div>
                            </div>
                        </div>
                        @foreach($eventsWithReview->transactions as $transaction)

                        @if($transaction->reviews && $transaction->reviews->isNotEmpty())
                        @foreach($transaction->reviews as $review)
                        <div class="row card-body d-flex">
                            <div class="col-auto text-center my-2 px-0">
                                <!-- Profile Picture -->
                                @if($transaction->team_code)
                                <img src="{{ asset('storage/' . $transaction->team->team_profilepic) }}" alt="Reviewer Profile" class="rounded-circle justify-content-start ms-2" style="align-items:start;width: 50px; height: 50px;">
                                @else
                                <img src="{{ asset($review->freelancer->user->profile_image_url) }}" alt="Reviewer Profile" class="rounded-circle justify-content-start ms-2" style="align-items:start;width: 50px; height: 50px;">
                                @endif
                            </div>
                            <div class="col-lg-10 col-9 col-md-9">
                                <!-- Review Content -->
                                <div>
                                    @if($transaction->team_code)
                                    <span class="font-weight-bold mt-3">{{$review->team->team_name}}<small>(Team)</small></span>
                                    @else
                                    <span class="font-weight-bold mt-3">{{$review->freelancer->user->first_name}} {{$review->freelancer->user->last_name}}</span>
                                    @endif
                                </div>
                                <div class=" star-rating mb-2">
                                    <span class="ms-1">{{ number_format($review->rating, 1) }}</span>

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
                                    <p class="mb-1" style="line-height: 1.2;">"{{$review->content}}"</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        @endforeach
                    </div>
                </div>
        </div>
        @endforeach
        @endif
        </section>

    </div>
</div>
@endsection