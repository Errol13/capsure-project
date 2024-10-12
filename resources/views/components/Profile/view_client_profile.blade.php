@extends ('layouts.app')

@section('content')
<div class="container open-sans-reg mt-4">

    <a href="/freelancer-homepage" class="fs-5" style="text-decoration:none; color:black;">
        <i class="mt-3 fas fa-arrow-left me-2 mb-4"></i>Back
    </a>

    <div class="row">
        <!--First Column -->
        <div class="col-4 col-md-4 col-lg-4">
            <!--Profile Pic and Personal Information -->
            <div class="row my-3">
                <div class="profile-container d-flex justify-content-center align-items-center">
                    <img src="{{ $user->profile_image_url}}" alt="Profile Picture" class="rounded-circle img-fluid">
                </div>
            </div>

            <!--Address and Contacts -->
            <div class="row my-3 text-center mb-1 ms-md-4">
                <div class="col-12 d-flex align-items-center justify-content-start">
                    <div class="d-flex align-items-center">
                        <i class="fs-smaller fs-md fas fa-location-dot"></i>
                    </div>
                    <div class="ms-2 ms-md-3">
                        <p class="mb-0 fs-sm-cont fs-md word-wrap text-start">{{$user->street}} {{$user->barangay}} {{$user->city}}</p>
                    </div>
                </div>
            </div>

            <div class="row my-0 text-center mb-1 ms-md-4">
                <div class="col-12 d-flex align-items-center justify-content-start">
                    <div class="d-flex align-items-center">
                        <i class="fs-smaller fs-md fas fa-sharp fa-thin fa-envelope" style="color: #0a0a0a;"></i>
                    </div>
                    <div class="ms-2 ms-md-3">
                        <p class="mb-0 fs-sm-cont fs-md text-start">{{$user->email}}</p>
                    </div>
                </div>
            </div>

            <div class="row my-1 text-center mb-1 ms-md-4">
                <div class="col-12 d-flex align-items-center justify-content-start">
                    <div class="d-flex align-items-center">
                        <i class="fs-smaller fs-md fas fa-solid fa-phone"></i>
                    </div>
                    <div class="ms-2 ms-md-3">
                        <p class="mb-0 fs-sm-cont fs-md text-start">{{$user->contact_number}}</p>
                    </div>
                </div>
            </div>

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

        <div class="col-8 col-md-8 col-lg-8 poppins-regular">
            <div class="row my-3">
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

                <!-- Buttons -->
                <div class="d-flex justify-content-start align-items-start mt-2 mt-md-3">
                    <a href="#" class="rounded-1 btn-chat me-3 me-md-4 px-3 py-1 px-md-5 poppins-light fs-sm">Chat</a>
                    <button type="button" class="rounded btn-report me-2 px-3 px-md-5 py-1 py-md-1 poppins-light fs-sm" data-bs-toggle="modal" data-bs-target="#reportClientModal">Report Profile</button>
                </div>

                <div class="row mt-4 pt-2">
                    <div class="col-1 text-end">
                        <h3 style="color: #91216C;">{{$user->client->events->count()}}</h3>
                    </div>
                    <div class="col-2 me-2 d-flex justify-content-center" style="white-space: nowrap;">
                        <h4 class="mb-0 open-sans-reg light-color-prof">Events posted</h4>
                    </div>
                    <div class="col-3">
                        <a href="#" class="fs-sm poppins-medium text-decoration-underline text-muted"><small>See Events Posts</small></a>
                    </div>
                    <div class="col-1 me-2">
                        <h3 style="color: #91216C;">
                            @if($hiringSuccessRate == 0)
                            0%
                            @else
                            {{ number_format($hiringSuccessRate, 1) }}%
                            @endif
                        </h3>
                    </div>
                    <div class="col ms-3 ">
                        <h4 class="mb-0 open-sans-reg light-color-prof">Hiring Success Rate</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="row note">
                            <span class="mb-0" style="line-height: 1; color:lightgray;">Total number of of events posted by the client. </span>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row note">
                            <span class="mb-0" style="line-height: 1; color:lightgray;">Represents how often a client successfully hires </span>
                        </div>
                        <div class="row note">
                            <span style=" color:lightgray;">after posting an event.</span>
                        </div>
                    </div>
                </div>
                <p class="mt-3 mb-0 open-sans-reg light-color-prof fs-sm">Member since <strong>{{date_format($user->date_joined, 'F j, Y')}}</strong></p>
            </div>
        </div>

        <!--Freelancer Review -->
        <section id="client-reviews">
            <div class="d-flex justify-content-between align-items-center mb-4">

                <!--count the reviews for client -->
                @php
                $totalReviews = $user->client->reviews()->where('reviewee_role', 'freelancer')->count();
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
        </section>
    </div>
    @include('modals.c_report')
</div>
@endsection