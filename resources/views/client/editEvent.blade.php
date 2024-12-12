@extends('layouts.app')

@section('content')

@livewire('edit-event-post', ['eventReceivedId' => $id])

@endsection