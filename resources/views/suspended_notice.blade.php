@extends('layouts.app')

@section('content')

<div class="container d-flex align-items-center justify-content-center min-vh-100">
    @php
    $user = Auth::user();
    $suspendedReasons = optional($user->suspension)->suspended_reason;

    // Decode JSON string into an array if suspended_reason is not null
    if ($suspendedReasons) {
    $suspendedReasons = json_decode($suspendedReasons);
    }

    $startAt = optional($user->suspension)->start_at;
    $endAt = optional($user->suspension)->end_at;

    $totalDuration = $startAt && $endAt ? \Carbon\Carbon::parse($startAt)->diffForHumans(\Carbon\Carbon::parse($endAt), true) : 'N/A';
    $remainingDuration = $endAt ? \Carbon\Carbon::now()->diffForHumans(\Carbon\Carbon::parse($endAt), true) : 'N/A';
    @endphp

    <div class="d-flex justify-content-center align-items-center w-75">
        <!-- Fixed-width container with border and padding -->
        <div class="border rounded-4 p-4 w-75" style="max-width: 800px; background-color: white; box-shadow:1px 2px 2px rgba(0, 0, 0, 0.3);">
            <div class="row justify-content-center align-items-center">
                <div class="d-flex justify-content-center align-items-center flex-column">
                    <!-- Exclamation icon -->
                    <i class="fas fa-circle-exclamation text-danger fs-3 mb-4"></i>
                    <!-- Suspended message -->
                    <h5 class="text-danger text-center mb-3 open-sans-medium text-bold">Your account has been suspended</h5>
                </div>

                <p class="text-muted text-center">Your account has been suspended for <strong>{{$totalDuration}}</strong> due to a violation of our community guidelines,
                    specifically related to
                    @if($suspendedReasons && count($suspendedReasons) > 0)
                    @php
                    $lastReasonIndex = count($suspendedReasons) - 1;
                    @endphp
                    @foreach($suspendedReasons as $index => $reason)
                    <strong>{{$reason}}</strong>
                    @if($index !== $lastReasonIndex)
                    ,
                    @else
                    .
                    @endif
                    @endforeach
                    @else
                    <strong>No reason provided.</strong>
                    @endif
                    Please review our policies for more details.
                    If you believe this suspension was made in error,
                    you may contact support for further assistance.
                </p>
                <p class="text-center mt-3">Time Remaining: {{$remainingDuration}}</p>
            </div>
            <div class="d-flex justify-content-center mt-3 align-items-center">
                <a href="#" class="me-4 text-purple">See Policy</a>
                <a href="#" class="text-purple">Contact Us</a>
            </div>
        </div>
    </div>
</div>

@endsection