@extends ('layouts.app')

@section('content')
<div class="container open-sans-reg mt-4">
    <div class="row">
        <div class="row rounded-4" style="background-color: white;">
            <!--First Column -->
            <div class="col-4 col-md-4 col-lg-4">
                <!--Profile Pic and Personal Information -->
                <div class="row my-3">
                    <div class="profile-container d-flex justify-content-center align-items-center">
                        <img src="{{ $user->profile_image_url}}" alt="Profile Picture" class="rounded-circle ">
                    </div>
                </div>

                <!--Address and Contacts -->
                <div class="row my-3 text-center mb-1 ms-md-4">
                    <div class="col-12 d-flex align-items-center justify-content-start ms-4">
                        <div class="d-flex align-items-center">
                            <i class="fs-smaller fs-md fas fa-location-dot"></i>
                        </div>
                        <div class="ms-2 ms-md-3">
                            <p class="mb-0 fs-sm-cont fs-md word-wrap text-start">{{$user->street}} {{$user->barangay}} {{$user->city}}</p>
                        </div>
                    </div>
                </div>

                <div class="row my-0 text-center mb-1 ms-md-4">
                    <div class="col-12 d-flex align-items-center justify-content-start ms-4">
                        <div class="d-flex align-items-center">
                            <i class="fs-smaller fs-md fas fa-sharp fa-thin fa-envelope" style="color: #0a0a0a;"></i>
                        </div>
                        <div class="ms-2 ms-md-3">
                            <p class="mb-0 fs-sm-cont fs-md text-start">{{$user->email}}</p>
                        </div>
                    </div>
                </div>

                @if($user->contact_number)
                <div class="row my-1 text-center mb-1 ms-md-4">
                    <div class="col-12 d-flex align-items-center justify-content-start ms-4">
                        <div class="d-flex align-items-center">
                            <i class="fs-smaller fs-md fas fa-solid fa-phone"></i>
                        </div>
                        <div class="ms-2 ms-md-3">
                            <p class="mb-0 fs-sm-cont fs-md text-start">{{$user->contact_number}}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Social Media Accounts -->
                <div class="row my-1 text-center mb-4 mt-3">
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

            <div class="col-8 col-md-8 col-lg-8 poppins-regular" style="border-left: 15px solid #F8FAFC;">
                <div class="row my-3 ps-4">
                    <!-- Full Name and Verification Status -->
                    <div class="col-12 col-md-12">
                        <div class="d-flex align-items-center">
                            <p class="fs-sm-name fs-md-name text-start mb-0 poppins-medium">
                                {{ $fullName }}
                            </p>
                            @if($user->isVerified)
                            <span class="d-flex align-items-center mt-2 mb-0">
                                <i class="fas fa-check-circle fs-6 ms-2 ms-md-1 me-md-1 ms-lg-4 verify-icon mb-1 mb-md-0" title="Verified"></i>
                                <span class="fs-sm fs-md ms-1 mb-1 mb-md-0 poppins-medium">Verified</span>
                            </span>
                            @endif
                        </div>
                    </div>
                    <p class="mt-0 m-0 open-sans-reg light-color-prof">{{$user->age}} years old</p>

                    <!-- Star Rating Container -->
                    <p class="fs-6 mb-0 mt-2 open-sans-reg light-color-prof ">Rating</p>
                    @if($user->client->avg_rating == 0)
                    <p class="fs-6 open-sans-reg light-color-prof mt-1 fst-italic text-muted">No ratings yet</p>
                    @else

                    <div class="star-rating mt-0 mt-md-1">
                        <div class="row">
                            <div class="col-auto">
                                <p class="mb-0 fs-sm fs-md">{{ number_format($user->client->avg_rating, 1) }}</p>
                            </div>
                            <div class="col">
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
                        </div>
                    </div>

                    @endif


                    <div class="row mt-3 d-flex align-items-center">
                        <div class="col-md-5 flex-grow-1">
                            <!-- Events Posted -->
                            <div class="card rounded-4 p-3 pb-4 border-0" style="height: 116px; box-shadow:1px 1px 2px rgba(0, 0, 0, 0.3);">
                                <div class="row align-items-center">
                                    <div class="col-12 d-flex justify-content-center align-items-center">
                                        <h1 class=" fs-md-3 me-3" style="color: #91216C;">{{$user->client->events->count()}}</h1>
                                        <h5 class=" fs-md-4 poppins-medium light-color-prof me-3" style="white-space: nowrap;">Events posted</h5>
                                        <a href="#" class="fs-sm poppins-medium text-decoration-underline text-muted d-none d-md-inline" style="white-space: nowrap;">
                                            <small class="text-purple align-items-center justify-content-end">See Posts</small>
                                        </a>
                                    </div>
                                    <!-- Show the link on smaller screens -->
                                    <div class="col-12 d-md-none mt-1">
                                        <a href="#" class="fs-sm poppins-medium text-decoration-underline text-muted" style="white-space: nowrap;">
                                            <small>See Events Posts</small>
                                        </a>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <small class="mb-0 text-center" style="line-height: 1; color:darkgray;">Total number of events posted by the client.</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 flex-grow-1">
                            <!-- Hiring Success Rate -->
                            <div class="card p-3 border-0 rounded-4" style="box-shadow:1px 1px 2px rgba(0, 0, 0, 0.3);">
                                <div class="row align-items-center">
                                    <div class="col-12 d-flex justify-content-center align-items-center">
                                        <h1 class="fs-md-3 me-3" style="color: #91216C;">
                                            @if($hiringSuccessRate == 0)
                                            0%
                                            @else
                                            {{ number_format($hiringSuccessRate, 1) }}%
                                            @endif
                                        </h1>
                                        <h5 class=" fs-md-4 poppins medium light-color-prof me-3" style="white-space:nowrap;">Hiring Success Rate</h5>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <small class="mb-0 text-center" style="line-height: 1.2; color:darkgray;">Represents how often a client successfully hires after posting an event.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p class="mt-3 pt-4 mb-0 open-sans-reg light-color-prof fs-sm">Member since <strong>{{date_format($user->date_joined, 'F j, Y')}}</strong></p>
                </div>
            </div>
        </div>
        <!--Freelancer Review -->
        <section id="client-reviews">
            <div class="d-flex justify-content-between align-items-center my-4">

                <!--count the reviews for client -->
                @php
                $totalReviews = $user->client->reviews()->where('reviewee_role', 'client')->count();
                @endphp
                <div class="d-flex align-items-center">
                    <h2 class="text-start mb-0 fs-sm fs-md poppins-medium me-2">Freelancer's Reviews</h2>
                    @if($user->client->reviews->isNotEmpty())
                    @if($totalReviews > 1)
                    <p class="mb-0 fs-smaller">({{$totalReviews}} reviews)</p>
                    @else
                    <p class="mb-0 fs-smaller">({{$totalReviews}} review)</p>
                    @endif
                    @endif
                </div>
                @if($totalReviews > 0)
                <a class="fs-sm fs-md poppins-light txt-review" href="#">See All Reviews</a>
                @endif
            </div>


            @if($totalReviews === 0)
            <p class="text-center fs-5 text-muted">No reviews</p>
            @else
            <!-- Reviews -->
            @foreach($eventsWithReviews as $eventsWithReview)

            @php
            $start_date_formatted = \Carbon\Carbon::parse($eventsWithReview->start_date)->format('M j, Y');
            $end_date_formatted = \Carbon\Carbon::parse($eventsWithReview->end_date)->format('M j, Y');
            @endphp

            <div class="container">
                <div class="row d-flex align-items-center justify-content-between" style="gap: 25px;">
                    <!-- Review Item 1 -->
                    <div class="col-md-2 flex-grow-1 mb-4 rvw-container rounded shadow-sm">
                        <div class="d-flex align-items-center justify-content-between mb-0 mt-3 ms-2">
                            <div>
                                <h2 class="text-start mb-0 fs-sm fs-md poppins-medium me-2">{{$eventsWithReview->title}}</h2>
                            </div>
                            <a class="fs-sm fs-md poppins-light txt-review me-2" href="{{route('client-viewpost', ['id' => $eventsWithReview->event_id] )}}">See Post</a>
                        </div>
                        <span class="fs-sm fs-md poppins-light mt-0 ms-2">{{$start_date_formatted}} - {{$end_date_formatted}}</span>

                        @foreach($eventsWithReview->transactions as $transaction)

                        @if($transaction->reviews && $transaction->reviews->isNotEmpty())
                        @foreach($transaction->reviews as $review)
                        <div class="d-flex mt-3">
                            <div class="me-3">
                                <!-- Profile Picture -->
                                <img src="{{ asset($review->freelancer->user->profile_image_url) }}" alt="Reviewer Profile" class="rounded-circle justify-content-start ms-2" style="align-items:start;width: 50px; height: 50px;">
                            </div>
                            <div>
                                <!-- Review Content -->
                                <span class="font-weight-bold">{{$review->freelancer->user->first_name}} {{$review->freelancer->user->last_name}}</span>
                                <div class=" star-rating mb-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <=floor($review->rating))
                                        <i class="fas fa-star filled"></i> <!-- Filled star -->
                                        @elseif ($i == ceil($review->rating) && $review->rating - floor($review->rating) > 0)
                                        <i class="fas fa-star-half-alt filled"></i> <!-- Half star -->
                                        @else
                                        <i class="far fa-star"></i> <!-- Empty star -->
                                        @endif

                                        @endfor
                                        <span class="ms-1">{{ number_format($review->rating, 1) }}</span>
                                </div>
                                <p>{{$review->content}}</p>
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
    @include('modals.c_report')
</div>
@endsection