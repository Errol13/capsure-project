@extends('layouts.app')

@section('content')
<div class="container py-2 my-3">
    <a href="#" class="fs-5" onclick="window.history.back(); return false;" style="text-decoration:none; color:black;">
        <i class="fas fa-arrow-left me-2 mb-4"></i>Back
    </a>

    @if ($name)
    <h4 class="text-start text-purple open-sans-reg mb-2">
        {{ $name }}'s All Reviews
    </h4>
    @endif

    <div class="row">

        @foreach($reviews as $review)
        @php
        $start_date_formatted = \Carbon\Carbon::parse($review->transaction->event->start_date)->format('M j, Y');
        $end_date_formatted = \Carbon\Carbon::parse($review->transaction->event->end_date)->format('M j, Y');
        @endphp

        <div class="container card rounded-4 border-0 mb-2" style="background-color: white; box-shadow:1px 1px 2px rgba(0, 0, 0, 0.3);">
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
                <div class="row d-flex align-items-center flex-nowrap">
                    <div class="col-auto text-center my-2 px-0">

                        @if($review->team)
                        <img src="{{ asset('storage/' . $review->team->team_profilepic) }}" alt="Reviewer Profile" class="img-fluid rounded-circle" style="align-items:start;width: 50px; height: 50px;">
                        @elseif($review->reviewee_role === 'freelancer')
                        <a href="{{route('view-client-profile', ['id'=> $review->client->user_id])}}">
                            <img src="{{ asset($review->client->user->profile_image_url) }}" alt="Reviewer Profile" class="img-fluid rounded-circle" style="align-items:start;width: 50px; height: 50px;">
                        </a>
                        @else
                        <a href="{{route('view-freelancer-profile', ['id'=> $review->freelancer->user_id])}}">
                            <img src="{{ asset($review->freelancer->user->profile_image_url) }}" alt="Reviewer Profile" class="img-fluid rounded-circle" style="align-items:start;width: 50px; height: 50px;">
                        </a>
                        @endif

                    </div>
                    <div class="col-10">
                        <!-- Review Content -->
                        <div>
                            <!-- Review Content -->
                            @if($review->team)
                            <small class="font-weight-bold mt-3">{{$review->team->team_name}} (Team)</small>
                            @elseif($review->client)
                            <small class="font-weight-bold mt-3">{{$review->client->user->first_name}} {{$review->client->user->last_name}} </small>
                            @else
                            <small class="font-weight-bold mt-3">{{$review->freelancer->user->first_name}} {{$review->freelancer->user->last_name}} </small>
                            @endif
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

        <p class="text-center text-muted mt-3">&lt;------ Nothing follows ------&gt;</p>


    </div>

</div>
@endsection
