@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">

        <livewire:Freelancer.searchbar /> 

        <div class="row mx-0 mt-4">
            <h3 class="poppins-medium fs-3 text-start">Jobs For You</h3>
        </div>
        <!-- Events -->
        <div class="container mt-2 poppins-regular ">
            <div class="row">

                @foreach($users as $user)
                @if($user->client && $user->client->events)
                @foreach($user->client->events as $event)
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm rounded-4" style="background-color: white;">
                        <div class="card-body">

                            <div class="d-flex justify-content-between ">
                                <h4 class="card-title poppins-medium">{{$event->title}}</h4>
                                <!-- Calculate and display the time since creation -->
                                @php
                                $createdAt = \Carbon\Carbon::parse($event->created_at);
                                $timeSince = $createdAt->diffForHumans();
                                @endphp
                                <p class="card-text note">{{ $timeSince }}</p>
                            </div>
                            <div class="row rw-height-eventdesc mb-2">
                            <p class="card-text content-color">{!! nl2br(e($event->description)) !!}</p>
                            </div>
                           
                            <div class="d-flex flex-wrap">
                                @foreach($event->event_jobs ?? [] as $event_job)
                                <span class="badge fs-6 me-2 mb-2" style="background-color: #8FE2ED; color:#323232;">{{$event_job->service_needed}}</span>
                                @endforeach
                            </div>

                            <hr class="mt-2 border-1 opacity-25">
                            <div class="d-flex align-items-center mt-3">
                                <img src="{{ $user->profile_image_url }}" alt="Profile" class="rounded-circle me-2" width="50">
                                <div>
                                    <h6 class="mb-0 poppins-medium">{{$user->first_name}} {{$user->last_name}}</h6>
                                    <small class="text-muted">{{$user->city}}</small>
                                </div>
                                <div class="ms-auto d-flex align-items-center">
                                    @if ($user->client->avg_rating > 0)
                                    <span class="text-warning me-1">★</span>
                                    <span class="fw-bold">{{ number_format($user->client->avg_rating, 1) }}</span>
                                    <span class="text-muted small ms-1">({{ $user->client->reviews()->where('reviewee_role', 'client')->count() }})</span>
                                    @else
                                    <span class="note me-1">No ratings yet</span>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-3">
                                <a href="{{ route('client-viewpost', ['id' => $event->event_id]) }}" class="confirm me-2">See Details</a>
                                <a href=" {{route('view-client-profile', ['id' => $event->client_id] ) }}" class="btn-round" style="border: 1px solid #8b206a; color:#8b206a;">See Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
                @endforeach



            </div>

            <!-- Pagination -->
            <div class=" mt-4 d-flex justify-content-center">
                {{ $users->links('vendor.pagination.bootstrap-4') }}
            </div>

        </div>


    </div>
</div>


@endsection('content')