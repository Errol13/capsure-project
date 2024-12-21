@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col col-lg-8">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0 poppins-medium">All Notifications</h4>
                <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-light" style="color: blue;">Mark All as Read</button>
                </form>
            </div>
            <div class="card-body mt-3">
                @forelse($notifications as $index => $notification)
                <div class="p-3 mb-2 {{ $index % 2 === 0 ? 'bg-light' : 'bg-white' }} rounded" style="box-shadow:1px 1px 2px rgba(0, 0, 0, 0.3);">
                    <a  href="{{ route('notifications.read', $notification->id) }}" class="text-decoration-none text-dark">
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

                <div class="card-footer text-center">
                {{ $notifications->links('vendor.pagination.bootstrap-4') }} <!-- Pagination -->
                </div>
                
                @empty
                <div class="p-3 text-center text-muted">
                    No notifications found.
                </div>
                @endforelse
            </div>
            

        </div>
    </div>
</div>
@endsection
