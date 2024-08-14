@extends ('layouts.app')

@section('content')

<div class="container">
    <div class="row">

        <!--First Column -->
        <div class="col-4 col-md-4 col-lg-4">
            <!--Profile Pic and Personal Information -->
            <div class="row my-3">
                <div class="profile-container">
                    <img src="{{ asset('assets/daisy.svg') }}" alt="Profile Picture" class="rounded-circle img-fluid">
                </div>
            </div>

            <!--Address and Contacts -->
            <div class="row my-3 text-center mb-1">
                <div class="col-auto me-0 ms-4 ms-md-5 d-flex justify-content-center align-items-center">
                    <i class="fs-smaller fs-md fas fa-location-dot"></i>
                </div>

                <div class="col ms-0 d-flex align-items-center">
                    <p class="mb-0 fs-sm-cont fs-md word-wrap">{{$user->street}} {{$user->barangay}} {{$user->city}}</p>
                </div>
            </div>

            <div class="row my-0 text-center mb-1 ">
                <div class="col-auto  me-0 ms-4 ms-md-5 d-flex justify-content-center align-items-center">
                    <i class=" fs-smaller fs-md fas fa-sharp fa-thin fa-envelope" style="color: #0a0a0a;"></i>
                </div>

                <div class="col ms-0 col-md-8 d-flex align-items-center">
                    <p class="mb-0 fs-sm-cont fs-md ">{{$user->email}}</p>
                </div>
            </div>

            <div class="row my-1 text-center mb-1 ">
                <div class="col-auto me-0 ms-4 ms-md-5 d-flex justify-content-center align-items-center">
                    <i class="fs-smaller fs-md fas fa-solid fa-phone"></i>
                </div>

                <div class="col ms-0 d-flex align-items-center">
                    <p class="mb-0 fs-sm-cont fs-md">{{$user->contact_number}}</p>
                </div>
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
                        <span class="d-flex align-items-center mt-2 mb-0">
                            <i class="fas fa-check-circle fs-6 ms-2 ms-md-1 me-md-1 ms-lg-4 verify-icon mb-1 mb-md-0" title="Verified"></i>
                            <span class="fs-sm fs-md ms-1 mb-1 mb-md-0 poppins-medium">Verified</span>
                        </span>

                    </div>
                </div>
                <p class="mt-0 m-0 open-sans-reg light-color-prof">{{$user->age}} years old</p>
                <p class="fs-6 mb-0 mt-2 open-sans-reg light-color-prof ">Rating</p>
                @if($user->freelancer->avg_rating != 0)
                <p class="fs-6 open-sans-reg light-color-prof mt-1 fst-italic text-muted">No ratings yet</p>
                @else
                <!-- Star Rating Container -->
                <div class="star-rating mt-0 mt-md-1">
                    <div class="row">
                        <div class="col-auto">
                            <p class="mb-0">{{ number_format($user->freelancer->avg_rating, 1) }}</p>
                        </div>
                        <div class="col">
                            <div class="d-flex align-items-center mt-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $user->freelancer->avg_rating ? 'filled' : '' }}"></i>
                                    @endfor
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!--Hire Chat Report -->
                <div class="d-flex justify-content-start align-items-start mt-2 mt-md-4">
                    <a href="#" class="text-center btn-seemore rounded-1 px-3 py-1 px-md-5 me-3 me-md-4 poppins-light fs-sm">HIRE</a>
                    <a href="#" class=" rounded-1 btn-chat me-3 me-md-4 px-3 py-1 px-md-5 poppins-light fs-sm">CHAT</a>
                    <a href="#" class=" rounded btn-report me-2 px-3 px-md-5 py-1 py-md-1 poppins-light fs-sm ">Report</a>
                </div>

                <!--Team -->
                <div class=""></div>

                <!--Services -->
                <p class="mt-3 fs-sm fs-md poppins-medium">Services</p>
                <div class="row mt-1 open-sans-reg">
                    @foreach ($user->freelancer->services as $service)
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
                    @endforeach
                </div>

                <!--Terms of Service-->
                <p class="mt-3 fs-sm fs-md poppins-medium">Terms of Service</p>
                <div class="container terms-container rounded">
                    <p class="text-start fs-smaller fs-md mt-2 ">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
                    </p>
                </div>

            </div>
        </div>

    </div>
</div>




@endsection