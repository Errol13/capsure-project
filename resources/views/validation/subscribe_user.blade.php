@extends('layouts.app')

@section('content')
<div class="container">
    <div class="stepper mb-4">
        <div class="line"></div>
        <div class="step active">
            <div class="circle">1</div>
            <p class="pt-3">VERIFY MOBILE NUMBER</p>
        </div>
        <div class="line"></div>
        <div class="step">
            <div class="circle">2</div>
            <p class="pt-3">VERIFY ID</p>
        </div>
        <div class="line"></div>
    </div>

    <h2 class="mb-4" style="text-align: center;">Grant Permission to Receive SMS</h2>

    <div class="vbox mb-4">
        <div class="form-section">
            <label for="phone-number">Grant Capsure to send you SMS:</label>
            <p class="note">Note: Submitting this form will allow Capsure to send you OTP SMS.</p>
            <div class="input-group">
                <a href="https://developer.globelabs.com.ph/dialog/oauth/kLrqSAB5zLh5riGoAoc5g6hq6L8nS5gj" class="btn-seemore  px-3 py-2 rounded">Opt-In to Receive OTP</a>
            </div>
        </div>
    </div>

</div>

<style>
    .input-group {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .input-group .prefix {
        background-color: #e9ecef;
        padding: 10px;
        border-radius: 5px 0 0 5px;
    }

    .input-group input {
        flex: 1;
        min-width: 200px;
    }

    .input-group button {
        white-space: nowrap;
    }

    .otp-inputs input {
        width: 40px;
        text-align: center;
        margin-right: 5px;
    }

    @media (max-width: 768px) {
        .input-group {
            flex-direction: column;
            align-items: flex-start;
        }

        .otp-inputs {
            justify-content: space-around;
            margin-bottom: 10px;
        }

        .btn.confirm {
            width: 100%;
        }
    }
</style>
@endsection