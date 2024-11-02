@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar for chat users -->
        <div class="col-md-4 border-end">
            <!-- Livewire component for the user list -->
            <livewire:user-list :conversationId="$conversationId" />
        </div>

        <!-- Chat panel -->
        <div class="col-md-8">
            <!-- Livewire component for the chat panel -->
            <livewire:chat :conversationId="$conversationId"/>
        </div>
        
    </div>
    
</div>
@endsection