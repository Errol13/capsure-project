@extends('layouts.app')

@section('content')
<div class="container mb-4 pb-4">
    <div class="row justify-content-center mb-4">

        <h3 class="my-4 text-start poppins-medium ">Favorites</h3>
        @if ($freelancers->isEmpty())
        <p>No favorites found.</p>
        @else
        <div class="card-grid d-md-flex row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

            @foreach ($freelancers as $freelancer)

            @php
            $service = $freelancer->services->first();
            $portfolio = $freelancer->portfolios->first();
            @endphp

            <div class="card mx-auto shadow-box" style="width: 18rem; border-radius: 15px; border:none; box-shadow:1px 1px 5px rgba(0, 0, 0, 0.3);">
                <div class="col-align px-2 mt-1">
                    <h5 class="card-title poppins-medium mt-1">{{ $service->job_title }}</h5>
                    <h5 class="poppins-medium fs-5 mb-0 right-side">₱{{ $service->job_fee}}</h5>
                </div>
                <!-- Display Freelancer Cover Image -->
                @if($portfolio)
                <!--display the first image in their first album -->
                @php
                $paths = json_decode($portfolio->path, true);
                $firstImage = $paths[0];
                $relativePath = str_replace('public/', '', $firstImage);
                @endphp
                <img src="{{ asset('storage/' . $relativePath) }}" class="card-img-top rounded-0" alt="cover" style="border-radius: 15px 15px 0 0;">
                @else
                <img src="{{ asset('assets/cover_def.png') }}" class="card-img-top rounded-0" alt="cover" style="border-radius: 15px 15px 0 0;">
                @endif

                <div class="card-body open-sans-reg p-3">
                    <div class="d-flex align-items-center mb-2">
                        <img src="{{ $freelancer->user->profile_image_url }}" class="rounded-circle" alt="profile" style="width: 50px; height: 50px;">
                        <div class="ms-3">
                            <p class="card-text open-sans-reg fw-bold mb-0" style="line-height: 1;">{{ $freelancer->user->first_name }} {{ $freelancer->user->last_name }}</p>
                            <p class="card-text open-sans-light small mb-0">{{ $freelancer->user->city }}</p>
                            <!-- if no projects yet -->
                            @if($freelancer->number_of_projects > 0)
                            <p class="card-text open-sans-light small text-success mb-0">({{ $freelancer->number_of_projects }}) projects done</p>
                            @else
                            <p class="card-text open-sans-light small text-success mb-0">No projects yet</p>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="#" class="btn btn-seeprof rounded-pill w-100 me-2" style="border-color: #91216C; color:#91216C;">See Profile</a>
                        <form action="{{ route('favorites.remove', $freelancer->user_id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE') <!-- Use DELETE method for removing -->
                            <button type="submit" style="border: none; background: none; cursor: pointer;">
                                <img src="{{ asset('assets/saved.svg') }}" alt="Unbookmark" class="bookmark-icon" style="width: 30px; height: 30px;">
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
        @endif
    </div>
</div>
@endsection
