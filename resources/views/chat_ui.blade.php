@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Sidebar for chat users -->
        <div class="col-md-4 border-end">
            <!-- Livewire component for the user list -->
            <livewire:user-list />
        </div>

        <!-- Chat panel -->
        <div class="col-md-8">
            <!-- Livewire component for the chat panel -->
            @if(session('selectedUserId'))
                <livewire:chat :recipient-id="session('selectedUserId')" />
            @else
                <div class="text-center d-flex justify-content-center align-items-center mt-5">
                    <div class="row">
                    <h5 class="text-center text-muted open-sans-reg">Select a user to start chatting</h5>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
