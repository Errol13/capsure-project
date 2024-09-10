@extends('layouts.app')

@section('content')
<div class="container py-4 my-2">
    <div class="row">
        <div class="col-12">
            <div class="row d-flex align-items-center">
                <div class="col-auto pt-3">
                    <h2>My Posts</h2>
                </div>
                <div class="col-auto">
                    <a href="{{ url('/events') }}" class="btn btn-primary" style="background-color:#8FE2ED; border:none; color:black;">+</a>
                </div>
                <div class="col ms-auto text-end">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" style="background-color: white; border-radius:12px; color:black; border-color:lightgray;" type="button" id="filterToggleButton" data-bs-toggle="dropdown" aria-expanded="false">
                            Filter
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end mb-1" style="background-color: white;" aria-labelledby="filterToggleButton">
                            <li><a class="dropdown-item" href="#">Open</a></li>
                            <li><a class="dropdown-item" href="#">Closed</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Larger Screens -->

            <div class="table-responsive d-none d-md-block">
                @if($events->isNotEmpty())
                <table class="table mt-3">
                    <thead class="table-primary text-center poppins-extralight">
                        <tr>
                            <th></th>
                            <th>Status</th>
                            <th>Pending application</th>
                            <th>Hiring request</th>
                            <th>Hired</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($events as $event)
                        <tr>
                            <td>
                                <small>Created {{ $event->created_at->diffForHumans() }}</small><br>
                                <strong class="poppins-medium">{{ $event->title }}</strong><br>
                                <small>Budget: ₱{{ $event->budget_min }} - ₱{{ $event->budget_max }}</small>
                            </td>
                            <td class="{{ $event->status == 'Open' ? 'text-success' : 'text-danger' }} fw-bold text-uppercase">
                                {{ $event->status }}
                            </td>

                            <td class="fs-5">{{$event->jobApplicationsCount}}</td>
                            <td class="fs-5">{{$event->hiringRequestsCount}}</td>
                            <td class="fs-5">{{$event->hiredCount}}</td>
                            <td>
                                <a href="{{ route('client-viewpost', ['id' => $event->event_id]) }}" class="{{ $event->status == 'Closed' ? 'mt-4' : 'mt-0' }} btn btn-link" style="white-space: nowrap; color: #91216C; text-decoration:none;">View Post</a><br>

                                @if($event->status == 'Open')
                                <a href="#" class="btn btn-link text-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#confirmationModal"
                                    data-event-id="{{ $event->event_id }}"
                                    style="border:none; border-radius: 12px; text-decoration:none;"
                                    id="openModalButton">Close</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach

                    </tbody>

                </table>
                @else
                <p class="my-5 text-muted text-center fs-5">No Posts</p>
                @endif
            </div>

            <!-- Small Screens -->
            <div class="d-block d-md-none mt-3">
                @if($events->isNotEmpty())
                @foreach ($events as $event)
                <div class="card mb-3" style="border-radius: 20px;background-color:white;box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                    <div class="card-body">
                        <span class="{{ $event->status == 'Open' ? 'bg-success' : 'bg-danger' }} badge me-2 mb-3 text-uppercase">{{ $event->status }}</span>
                        <small>Created {{ $event->created_at->diffForHumans() }}</small>
                        <h5 class="card-title poppins-medium">{{ $event->title }}</h5>
                        <p class="card-text">Budget: {{ $event->budget_min }} - {{ $event->budget_max }}</p>
                        <hr>
                        <p class="mt-2 mb-0">Pending application:{{$event->jobApplicationsCount}}</p>
                        <p class="mb-0">Hiring request: {{$event->hiringRequestsCount}}</p>
                        <p class="mb-2">Hired: {{$event->hiredCount}}</p>

                        <a href="{{ route('client-viewpost', ['id' => $event->event_id]) }}" class="btn btn-primary" style="background-color: #91216C; color:white; border:none; border-radius: 12px;">View Post</a>
                        @if($event->status == 'Open')
                        <a href="{{ route('eventpost.close', ['id' => $event->event_id]) }}" class="btn btn-danger ms-2"
                            data-bs-toggle="modal" data-bs-target="#confirmationModal" data-event-id="{{ $event->event_id }}" style="border:none; border-radius: 12px;" id="openModalButton">Close</a>
                        @endif
                    </div>
                </div>
                @endforeach
                @else
                <p class="mt-5 text-muted text-center fs-5">No Posts</p>
                @endif
            </div>

            <!--Modal for closing the post -->
            @include('modals.Hiring.close_event')

        </div>
    </div>
</div>
@endsection