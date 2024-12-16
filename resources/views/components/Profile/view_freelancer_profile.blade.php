@extends ('layouts.app')

@section('content')

<div class="container py-2 my-3">
    <a href="#" onclick="window.history.go(-1); return false;" style="text-decoration:none; color:black;">
        <i class="mt-3 fas fa-arrow-left me-2 mb-4"></i>Back
    </a>

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
                <div class="row mb-2">
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
                    <div class="col">
                        <!-- Full Name and Verification Status -->
                        <div class="mt-2 d-flex align-items-center">
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
                        <span class="note">{{$user->age}} years old</span>

                        <div class="my-2 d-flex align-items-center">
                            @php
                            $totalReviews = $user->freelancer->reviews()->where('reviewee_role', 'freelancer')->count();
                            @endphp

                            <h6 class="fw-bold me-3 mb-0">Rating:</h6>
                            @if($user->freelancer->avg_rating == 0)
                            <h6 class="fst-italic text-muted" style="white-space: nowrap;">No ratings yet</h6>
                            @else
                            <!-- Star Rating Container -->
                            <div class="star-rating ms-2">
                                <div class="row">
                                    <div class="col-auto p-0 me-1">
                                        <span class=" fs-sm fs-md">{{ number_format($user->freelancer->avg_rating, 1) }}</span>
                                    </div>
                                    <div class="col-auto p-0">
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
                                    <div class="col-auto p-0 ms-1">
                                        @if($user->freelancer->reviews->isNotEmpty())
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

                        @if(empty($user->freelancer->skills))
                        <div></div>
                        @else
                        <div class="mb-2">
                            @foreach ($user->freelancer->skills as $index => $skill)
                            <span class="text-start badge badge-custom rounded-pill me-1"
                                style="background-color: #91216C;">
                                {{ $skill }}
                            </span>
                            @endforeach
                        </div>
                        @endif

                        <!--Address and Contacts -->
                        <div class="row my-3 text-start">
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

                        <p class="mb-2 open-sans-reg light-color-prof fs-sm">Member since <strong>{{date_format($user->date_joined, 'F j, Y')}}</strong></p>
                    </div>
                    <div class="col-auto me-3">
                        <div class="d-flex justify-content-start align-items-center mt-2 mt-lg-0">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#hireDirectlyModal-{{ $user->user_id }}"
                                class="text-center btn-seemore rounded-start-1 px-2 py-1 px-md-4 poppins-medium fs-sm">HIRE FREELANCER</a>
                            <form action="{{ route('chat.redirect') }}" method="POST" id="messageForm">
                                @csrf
                                <input type="hidden" name="recipientId" value="{{ $user->id }}">
                                <button type="submit" class="btn border-0 m-0 p-0">
                                    <i class="fas fa-comment text-purple fs-6 me-4 rounded-end-1 border border-1 px-3 py-2 me-3 me-md-4" style="background-color: white;cursor: pointer;"></i>
                                </button>
                            </form>
                            <i class="bi bi-person-fill-exclamation fs-4" data-bs-toggle="modal" data-bs-target="#reportProfileModal"
                                style="color: crimson; cursor: pointer;"></i>
                        </div>
                        <!-- Hire Modal -->
                        @include('modals.Hiring.hire_from_profile', ['uniqueId' => $user->user_id,'freelancer' => $user->freelancer,
                        'events'=> $events])

                        <!-- Report Modal -->
                        @include('modals.f_report', ['reportee' => $user])
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row d-flex justify-content-center my-3 mx-2 rounded-4" style="background-color: white;">
        <div class="col-5 col-md-4 col-lg-4" style="border-right: 18px solid #F8FAFC;">
            <!--Awards and Certifications -->
            <h5 class="my-3 fs-sm poppins-medium text-center">Awards & Certifications</h5>
            <div class="row text-center">
                @if($user->freelancer->certificates->isEmpty())
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <h6 class="fst-italic text-muted">No Awards</h6>
                </div>
                @else
                @foreach($user->freelancer->certificates as $certificate)
                <div class="col-12 d-flex align-items-center justify-content-center p-2">
                    <div class="d-lg-flex d-none align-items-center">
                        <a data-fancybox="certificate-gallery" data-caption="{{ $certificate->title }}" href="{{ asset('storage/' . str_replace('public/', '', $certificate->image)) }}">
                            <img src="{{ asset('storage/' . str_replace('public/', '', $certificate->image)) }}" alt="{{ $certificate->title }}" class="me-2 " style="width: 35px; height: 35px;">
                        </a>
                    </div>
                    <div style="line-height: 1;">
                        <div>
                            <span class="mb-0 fs-smaller fs-md text-start" style="white-space:nowrap;">{{ $certificate->title }}</span>
                        </div>
                        <div>
                            <span class="justify-content-start note">{{ $certificate->date }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
        <div class="col-7 col-md-8 col-lg-8 ps-3">
            <h3 class=" poppins-medium mt-3">Services</h3>
            <div class="container row">
                <!--Services -->

                <!--Team -->
                <div class="my-3">
                    @if($user->freelancer->team)
                    <div class="d-flex justify-content-start align-items-start">
                        <img src="{{asset('storage/'. $user->freelancer->team->team_profilepic)}}" alt="Team picture" class="rounded-circle me-1" width="30" height="30">
                        <div class="row" style="line-height:1.3 ;">
                            <a href="{{route('team-profile-view', ['id' => $user->freelancer->team->team_id])}}" class="ms-2" style="text-decoration: none; color:black;">{{$user->freelancer->team->team_name}}</a>
                            @if($user->freelancer->team->team_leader === auth()->id())
                            <small class="ms-2 note">Admin</small>
                            @else
                            <small class="ms-2 note">Member</small>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                <div class="list-group mb-4">
                    @foreach($user->freelancer->services as $service)
                    <div class="list-group-item d-lg-flex d-block justify-content-between align-items-center" style="background-color: #FCF2F9;">
                        <span class="fw-bold"> {{ $service->job_title }}</span>
                        <span>₱{{ $service->job_fee }}{{ $service->fee_type }}</span>
                        <span class="badge poppins-medium {{ $service->isAvailable ? 'text-success' : 'text-danger' }}">
                            {{ $service->isAvailable ? 'Available' : 'Not Available' }}
                        </span>
                    </div>
                    @endforeach
                </div>
                
            </div>
            <div class="row">
                <!--Terms of Service-->
                <h3 class="mt-3 poppins-medium">Terms of Service</h3>
                <div>
                    @if($user->freelancer->terms_and_conditions != null)
                    <p class="text-start mt-2 me-2">
                        {{$user->freelancer->terms_and_conditions}}
                    </p>
                    @else
                    <span class="text-start mt-2 me-2" style="line-height: 1;">
                        The freelancer agrees to perform the services as outlined in the project brief or as otherwise agreed upon with the client. The freelancer will deliver the services with reasonable skill, care, and diligence.
                    </span>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <div class="row d-block d-lg-flex justify-content-center pe-3">
        <div class="col col-lg-4 mb-3 pe-0">
            <!--Client Review -->
            <section id="client-reviews ">
                <div class="d-flex justify-content-between align-items-center mx-2">
                    <!--count the reviews for freelancer -->
                    @php
                    $totalReviews = $user->freelancer->reviews()->where('reviewee_role', 'freelancer')->count();
                    @endphp
                    <div class="d-flex align-items-center">
                        <h5 class="text-start poppins-medium mb-0 me-2">Client Reviews</h5>
                        @if($user->freelancer->reviews->isNotEmpty())
                        @if($totalReviews > 1)
                        <p class="mb-0 fs-smaller">({{$totalReviews}} reviews)</p>
                        @else
                        <p class="mb-0 fs-smaller">({{$totalReviews}} review)</p>
                        @endif
                        @endif
                    </div>
                    @if($totalReviews > 0)
                    <a class="poppins-light text-purple" href="{{route('allReviews.show', ['id' => $user->id])}}" style="font-size:small;">See All Reviews</a>
                    @endif
                </div>

                @if($user->freelancer->reviews->isEmpty())
                <h6 class="text-center fst-italic text-muted">No Reviews</h6>
                @else
                <p class="text-center my-2">Recent Projects</p>

                <!-- Reviews -->
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

                                    <span class="note">{{$start_date_formatted}} - {{$end_date_formatted}}</span>
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
        <div class="col col-lg-8 ps-4 mb-4">
            <!--Portfolio -->
            <section id="portfolio-freelancer">
                <div class="row rounded-4" style="background-color: white;">
                    <h3 class="text-start poppins-medium me-2 mt-3">Portfolio</h3>

                    <div class="container mt-2 mb-4">
                        @if ($user->freelancer->portfolios->isEmpty())
                        <h6 class="fst-italic text-muted">No portfolios found.</h6>

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
    </div>
</div>




@endsection