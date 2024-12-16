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


        <div class="col-sm-12 col-md-6 mb-4">
            <div class="rounded rvw-container p-3">
                <div class="d-flex align-items-center justify-content-between m-1 mb-0">
                    <div>
                        <h2 class="text-start mb-0 fs-sm fs-md poppins-medium me-2">{{$review->transaction->event->title}}</h2>
                    </div>
                    <a class="note fw-medium poppins-light text-purple"
                        href="{{route('client-viewpost', ['id' => $review->transaction->event->event_id] )}}">See Post</a>
                </div>
                <p class="fs-sm poppins-light mt-0">{{$start_date_formatted}} - {{$end_date_formatted}}</p>
                <div class="d-flex">
                    <div class="text-center me-3">
                        <!-- Profile Picture -->
                        @if($review->team)
                        <img src="{{ asset('storage/' . $review->team->team_profilepic) }}" alt="Reviewer Profile" class="img-fluid rounded-circle" style="width: 80px; height: 80px;">
                        @elseif($review->client)
                        <img src="{{ asset($review->client->user->profile_image) }}" alt="Reviewer Profile" class="img-fluid rounded-circle" style="width: 80px; height: 80px;">
                        @else
                        <img src="{{ asset($review->freelancer->user->profile_image) }}" alt="Reviewer Profile" class="img-fluid rounded-circle" style="width: 80px; height: 80px;">
                        @endif
                    </div>
                    <div>
                        <!-- Review Content -->
                        @if($review->team)
                        <h5 class="font-weight-bold">{{$review->team->team_name}} (Team)</h5>
                        @elseif($review->client)
                        <h5 class="font-weight-bold">{{$review->client->user->first_name}} {{$review->client->user->last_name}} </h5>
                        @else
                        <h5 class="font-weight-bold">{{$review->freelancer->user->first_name}} {{$review->freelancer->user->last_name}} </h5>
                        @endif
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
        </div>

        @endforeach

        <p class="text-center text-muted mt-3">&lt;------ Nothing follows ------&gt;</p>


    </div>

</div>
@endsection