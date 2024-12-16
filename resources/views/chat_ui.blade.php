@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar for chat users -->
        <div class="col-3 col-md-4 col-lg-3">
            <!-- Livewire component for the user list -->
            <livewire:user-list :conversationId="$conversationId" />
        </div>

        <!-- Chat panel -->
        <div class="col-9 col-md-8 col-lg-9 p-3" style="background-color: white;">
            <!-- Livewire component for the chat panel -->
            <livewire:chat :conversationId="$conversationId"/>
        </div>
    </div>
</div>

@endsection