@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #ad3d88;">
                    <h5 class="mb-0">All Notifications</h5>
                    <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-light">Mark All as Read</button>
                    </form>
                </div>
                <div class="card-body">
                    @forelse($notifications as $index => $notification)
                        <div class="p-3 mb-2 {{ $index % 2 === 0 ? 'bg-light' : 'bg-white' }} rounded shadow-sm">
                            <a href="{{ $notification->data['url'] }}" class="text-decoration-none text-dark">
                                <p class="mb-1 {{$notification->read_at ? 'fw-normal' : 'fw-bold' }}">{{ $notification->data['message'] }}</p>
                                <small class="text-muted">
                                    {{ $notification->created_at->diffForHumans() }}
                                    @if($notification->read_at)
                                        <span class="badge bg-success ms-2">Read</span>
                                    @else
                                        <span class="badge bg-warning ms-2">Unread</span>
                                    @endif
                                </small>
                            </a>
                        </div>
                    @empty
                        <div class="p-3 text-center text-muted">
                            No notifications found.
                        </div>
                    @endforelse
                </div>
                <div class="card-footer text-center">
                    {{ $notifications->links() }} <!-- Pagination -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
