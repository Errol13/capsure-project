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

    <h2 class="mb-4" style="text-align: center;">Verify your Mobile Number</h2>

    <div class="vbox mb-4">
        <div class="form-section">
            <label for="phone-number">Enter your Mobile Phone number:</label>
            <p class="note">Note: Mobile number must be a valid number from the Philippines.</p>
            <div class="input-group">
                <span class="prefix">+63</span>
                <input type="tel" id="phone-number" placeholder="Please enter your phone number"
                    maxlength="10" pattern="[0-9]*" inputmode="numeric"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                <button class="send-otp">Send OTP</button>
            </div>
        </div>
    </div>

    <div class="vbox">
        <div class="otp-section">
            <label for="otp">Enter the One Time Password (OTP):</label>
            <p class="note">Please enter the 6 digits code sent to your mobile number.</p>
            <div class="otp-wrapper d-flex align-items-center flex-wrap">
                <div class="otp-inputs d-flex justify-content-center">
                    <input type="text" class="otp-box form-control" maxlength="1">
                    <input type="text" class="otp-box form-control" maxlength="1">
                    <input type="text" class="otp-box form-control" maxlength="1">
                    <input type="text" class="otp-box form-control" maxlength="1">
                    <input type="text" class="otp-box form-control" maxlength="1">
                    <input type="text" class="otp-box form-control" maxlength="1">
                </div>
                <a href="{{ route('validID') }}" class="confirm ms-3" style="max-width: 100px; margin-top: 10px;">Confirm</a>
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