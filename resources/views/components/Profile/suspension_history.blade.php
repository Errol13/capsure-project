@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col col-lg-8">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0 poppins-medium">Suspension History</h4>
                <span class="note text-muted">Latest to Oldest</span>
            </div>
            <div class="card-body mt-3">
                @forelse($suspensions as $index => $suspension)
                <div class="p-3 mb-2 {{ $index % 2 === 0 ? 'bg-light' : 'bg-white' }} rounded" style="box-shadow:2px 2px 2px rgba(0, 0, 0, 0.3);">
                        <p class="mb-1">{{ $suspension->data['message'] }}</p>
                        <small class="text-muted">
                            {{ $suspension->created_at->diffForHumans() }}
                            <span class="badge bg-danger ms-2">Suspended</span>
                        </small>
                </div>
                
                @empty
                <div class="p-3 text-center text-muted">
                    No suspensions found.
                </div>
                @endforelse
            </div>
            
                <div class="card-footer text-center">
                {{ $suspensions->links('vendor.pagination.bootstrap-4') }} <!-- Pagination -->
                </div>
        </div>
    </div>
</div>
@endsection
