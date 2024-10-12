@extends ('layouts.app')

@section('content')

<div class="container  open-sans-reg">
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

            <!--Awards and Certifications -->
            <p class="mt-3 fs-sm fs-md poppins-medium text-center">Awards & Certifications</p>

            <div class="row my-1 text-center mb-1 ms-md-4">
                @if($user->freelancer->certificates->isEmpty())
                <div class="col-12 d-flex align-items-center justify-content-start">
                    <div class="d-flex align-items-center">
                        <img class="socmed-container" src="{{ asset('assets/Prize.svg') }}" alt="Certificate">
                    </div>
                    <div class="ms-2 ms-md-3">
                        <p class="mb-0 fs-sm-cont fs-md text-start text-muted">No Awards</p>
                    </div>
                </div>
                @else
                @foreach($user->freelancer->certificates as $certificate)
                <div class="col-12 d-flex align-items-center justify-content-start">
                    <div class="d-flex align-items-center">
                        <img class="socmed-container" src="{{ asset('assets/Prize.svg') }}" alt="Certificate">
                    </div>
                    <div class="col">
                        <div class="ms-2 ms-md-3">
                            <p class="mb-0 fs-sm-cont fs-md text-start">{{ $certificate->title }}</p>
                        </div>
                        <div class="ms-2 ms-md-3">
                            <p class="mb-0 fs-sm-cont fs-md text-start">{{ $certificate->date }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>

        </div>

        <!--Second Column -->
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
                <p class="fs-6 mb-0 mt-2 open-sans-reg light-color-prof ">Rating</p>
                @if($user->freelancer->avg_rating == 0)
                <p class="fs-6 open-sans-reg light-color-prof mt-1 fst-italic text-muted">No ratings yet</p>
                @else
                <!-- Star Rating Container -->
                <div class="star-rating mt-0 mt-md-1">
                    <div class="row">
                        <div class="col-auto">
                            <p class="mb-0 fs-sm fs-md">{{ number_format($user->freelancer->avg_rating, 1) }}</p>
                        </div>
                        <div class="col">
                            <div class="d-flex align-items-center mt-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <=floor($user->freelancer->avg_rating))
                                    <i class="fas fa-star filled"></i> <!-- Filled star -->
                                    @elseif ($i == ceil($user->freelancer->avg_rating) && $user->freelancer->avg_rating - floor($user->freelancer->avg_rating) > 0)
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

               

                <!--Team -->
                <div class=""></div>

                <!--Services -->
                <p class="mt-3 fs-sm fs-md poppins-medium">Services</p>
                @foreach ($user->freelancer->services as $service)
                <div class="row mt-1 open-sans-reg">

                    <div class="col">
                        <p class="fs-smaller fs-md">{{$service->job_title}}</p>
                    </div>

                    <div class="col">
                        <p class="fs-smaller fs-md">₱{{$service->job_fee}} {{$service->fee_type}}</p>
                    </div>

                    <div class="col">
                        @if ($service->isAvailable === true)
                        <p class="text-success fs-smaller fs-md">Available</p>
                        @else
                        <p class="text-danger fs-smaller fs-md">Not Available</p>
                        @endif
                    </div>
                </div>
                @endforeach

                <!--Terms of Service-->
                <p class="mt-3 fs-sm fs-md poppins-medium">Terms of Service</p>
                <div class="container terms-container rounded">
                    @if($user->freelancer->terms_and_conditions != null)
                    <p class="text-start fs-smaller fs-md mt-2 ">
                        {{$user->freelancer->terms_and_conditions}}
                    </p>
                    @else
                    <p class="text-start fs-smaller fs-md mt-2">
                        The freelancer agrees to perform the services as outlined in the project brief or as otherwise agreed upon with the client.
                        The freelancer will deliver the services with reasonable skill, care, and diligence.
                    </p>
                    @endif
                </div>

            </div>
        </div>

    </div>

    <!--Client Review -->
    <section id="client-reviews">
        <div class="d-flex justify-content-between align-items-center">

            <!--count the reviews for freelancer -->
            @php
            $totalReviews = $user->freelancer->reviews()->where('reviewee_role', 'freelancer')->count();
            @endphp
            <div class="d-flex align-items-center">
                <h2 class="text-start mb-0 fs-sm fs-md poppins-medium me-2">Client Reviews</h2>
                @if($user->freelancer->reviews->isNotEmpty())
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

        @if($user->freelancer->reviews->isEmpty())
        <p class="fs-6 text-center text-muted">No Reviews</p>
        @else

        <p class="text-center fs-smaller fs-md mt-2">Recent Projects</p>

        <!-- Reviews -->
        @foreach($reviews as $review)

        @php
        $start_date_formatted = \Carbon\Carbon::parse($review->transaction->event->start_date)->format('M j, Y');
        $end_date_formatted = \Carbon\Carbon::parse($review->transaction->event->end_date)->format('M j, Y');
        @endphp
        <div class="container">
            <div class="row d-flex align-items-center justify-content-between">
                <!-- Review Item  -->
                <div class="col-sm-12 col-md-5 mb-4 rounded rvw-container ">
                    <div class="d-flex align-items-center justify-content-between m-1 mb-0">
                        <div>
                            <h2 class="text-start mb-0 fs-sm fs-md poppins-medium me-2">{{$review->transaction->event->title}}</h2>
                        </div>
                        <a class="fs-sm fs-md poppins-light txt-review"
                            href="{{route('client-viewpost', ['id' => $review->transaction->event->event_id] )}}">See Post</a>
                    </div>
                    <p class="fs-sm poppins-light mt-0">{{$start_date_formatted}} - {{$end_date_formatted}}</p>
                    <div class="d-flex">
                        <div class="text-center me-3">
                            <!-- Profile Picture -->
                            <img src="{{ asset($review->client->user->profile_image_url) }}" alt="Reviewer Profile" class="img-fluid rounded-circle" style="width: 80px; height: 80px;">
                        </div>
                        <div>
                            <!-- Review Content -->
                            <h5 class="font-weight-bold">{{$review->client->user->first_name}} {{$review->client->user->last_name}} </h5>
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
                </div>

                <div class="col-1"></div>

            </div>
        </div>
        @endforeach
        @endif
    </section>

    <!--Portfolio -->
    <section id="portfolio-freelancer">
        <div class="row">
            <h2 class="text-start mb-0 fs-sm fs-md poppins-medium me-2">PORTFOLIO</h2>

            <div class="container mt-2 mb-4">

                @if ($user->freelancer->portfolios->isEmpty())
                <p class="text-muted">No portfolios found.</p>

                @else
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" id="portfolioTabs" role="tablist">
                    @foreach ($user->freelancer->portfolios as $index => $portfolio)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ $index == 0 ? 'active' : '' }}" id="tab-{{ $portfolio->portfolio_id }}" data-bs-toggle="tab" href="#portfolio-{{ $portfolio->portfolio_id }}" role="tab" aria-controls="portfolio-{{ $portfolio->portfolio_id }}" aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                            {{ $portfolio->album_name }}
                        </a>
                    </li>
                    @endforeach
                </ul>

                <!-- Tab content -->
                <div class="tab-content mt-3" id="portfolioTabsContent">
                    @foreach ($user->freelancer->portfolios as $index => $portfolio)
                    <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="portfolio-{{ $portfolio->portfolio_id }}" role="tabpanel" aria-labelledby="tab-{{ $portfolio->portfolio_id }}">
                        @if ($portfolio->path)
                        <div class="d-flex flex-wrap">
                            @foreach (json_decode($portfolio->path) as $filePath)
                            @php
                            $relativePath = str_replace('public/', '', $filePath);
                            $fileName = basename($relativePath);
                            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                            @endphp
                            @if (Str::startsWith($relativePath, 'portfolios/' . $portfolio->portfolio_id . '/'))
                            <div class="position-relative">
                                @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                <a href="{{ asset('storage/' . $relativePath) }}" data-fancybox="gallery" data-caption="{{ $portfolio->album_name }}">
                                    <img src="{{ asset('storage/' . $relativePath) }}" alt="Portfolio Image" class="img-profile-portfolio">
                                </a>
                                @elseif (in_array($fileExtension, ['mp4', 'mov', 'avi']))
                                <a href="{{ asset('storage/' . $relativePath) }}" data-fancybox="gallery" data-caption="{{ $portfolio->album_name }}">
                                    <video src="{{ asset('storage/' . $relativePath) }}" controls class="img-profile-portfolio"></video>
                                </a>
                                @else
                                <p>Unsupported file type: {{ $fileExtension }}</p>
                                @endif
                            </div>
                            @else
                            <p>File path mismatch: {{ $relativePath }}</p>
                            @endif
                            @endforeach
                        </div>
                        @else
                        <p>No media found for this album.</p>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif


            </div>
            <script>
                $("[data-fancybox]").fancybox({
                    buttons: [
                        "speed", // Speed button
                        "pip", // Picture in Picture button
                        "close", // Close button
                        
                    ],
                    protect: true // Disable right-click
                });
            </script>
    </section>


</div>




@endsection