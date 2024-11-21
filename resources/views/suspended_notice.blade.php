@extends('layouts.app')

@section('content')

<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
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

    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <!-- Fixed-width container with border and padding -->
        <div class="border border-3 p-4 w-75" style="max-width: 800px;">
            <div class="d-flex flex-column justify-content-center align-items-center">
                <div class="d-flex justify-content-start align-items-center mb-3">
                    <!-- Exclamation icon -->
                    <i class="bi bi-exclamation-circle text-danger me-3 fs-4"></i>
                    <!-- Suspended message -->
                    <p class="text-danger fs-5 mb-0 open-sans-medium text-bold">Your account has been suspended!</p>
                </div>
                <p class="text-muted">Your account has been suspended for <strong>{{$totalDuration}}</strong> due to a violation of our community guidelines,
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
                <p class="text-muted">Time Remaining: {{$remainingDuration}}</p>
            </div>
            <div class="d-flex justify-content-end align-items-center">
                <a href="#" class="text-muted me-3 text-decoration-none">See Policy</a>
                <a href="#" class="text-muted text-decoration-none">Contact Us</a>
            </div>
        </div>
    </div>
</div>

@endsection