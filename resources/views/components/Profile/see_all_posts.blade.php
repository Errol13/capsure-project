@extends('layouts.app')

@section('content')
<div class="container py-4 my-2">

    <a href="javascript:history.back()"  class="fs-5" style="text-decoration:none; color:black;">
        <i class="mt-3 fas fa-arrow-left me-2 mb-4"></i>Back
    </a>

    <div class="row">
        <div class="col-12">
            <div class="row d-flex align-items-center">
                <div class="col-auto pt-3 poppins-medium">
                    <h3 class="text-purple">{{$fullName}}'s Event Posts</h3>
                </div>

                <!--Content-->
                <div class="col ms-auto text-end">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" style="background-color: white; border-radius:12px; color:black; border-color:lightgray;" type="button" id="filterToggleButton" data-bs-toggle="dropdown" aria-expanded="false">
                            Filter: {{ ucfirst($status) }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end mb-1" style="background-color: white;" aria-labelledby="filterToggleButton">
                            <li><a class="dropdown-item {{ $status == 'Open' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['status' => 'Open']) }}">Open</a></li>
                            <li><a class="dropdown-item {{ $status == 'Closed' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['status' => 'Closed']) }}">Closed</a></li>
                            <li><a class="dropdown-item {{ $status == 'All' ? 'active' : '' }}" href="{{ request()->url() }}">All</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                @if($events->isNotEmpty())
                @foreach ($events as $event)
                <div class="col-12 col-sm-6 col-md-4 mb-3">
                    <div class="card" style="border-radius: 20px; background-color:white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="card-title poppins-medium mb-0" style="line-height: 0.5;">{{ $event->title }}</h4>
                                <span class="{{ $event->status == 'Open' ? 'bg-success' : 'bg-danger' }} badge text-uppercase">
                                    {{ $event->status }}
                                </span>
                            </div>

                            <span class="fs-6"><strong>Budget:</strong> ₱{{ $event->budget_min }} - ₱{{ $event->budget_max }}</span>
                            <hr class="my-3" style="margin-bottom: 0; border: 1px solid #ddd;">

                            <!-- Event Stats Section -->
                            <div class="event-stats">
                                <div class="stat">
                                    <span class="label">Pending application:</span>
                                    <span class="value">{{ $event->jobApplicationsCount }}</span>
                                </div>
                                <div class="stat">
                                    <span class="label">Hiring request:</span>
                                    <span class="value">{{ $event->hiringRequestsCount }}</span>
                                </div>
                                <div class="stat">
                                    <span class="label">Hired:</span>
                                    <span class="value">{{ $event->hiredCount }}</span>
                                </div>
                            </div>


                            <div class="d-flex justify-content-end mt-3">
                                <a href="{{ route('client-viewpost', ['id' => $event->event_id]) }}" class="confirm me-2" style="white-space:nowrap;">View Post</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <p class="mt-5 text-muted text-center fs-5">No Posts</p>
                @endif
            </div>

        </div>
    </div>
</div>
<style>
    .event-stats {
        display: flex;
        flex-direction: column;
        max-width: 100%;
        /* Adjust as needed */
    }

    .stat {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem;
    }

    .label {
        font-weight: bold;
    }

    .value {
        text-align: right;
    }
</style>
@endsection