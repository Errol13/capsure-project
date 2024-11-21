@extends ('layouts.app')

@section('content')
<div class="container py-2 my-3">
    <h4 class="text-start text-purple open-sans-reg">All Reviews</h4>

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
                        <img src="{{ asset($review->client->user->profile_image) }}" alt="Reviewer Profile" class="img-fluid rounded-circle" style="width: 80px; height: 80px;">
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

</div>
@endsection