@extends('layouts.app')

@section('content')
<div class="container">
    <div class="stepper">
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

    <h2 style="text-align: center;">Verify your Mobile Number</h2>

    <div class="form-section">
        <label for="phone-number">Enter your Mobile Phone number:</label>
        <p class="note">Note: Mobile number must be a valid number from the Philippines.</p>
        <div class="input-group">
            <span class="prefix">+63</span>
            <input type="tel" id="phone-number" placeholder="Please enter your phone number">
            <button class="btn send-otp">Send OTP</button>
        </div>
    </div>

    <div class="form-section">
        <label for="otp">Enter the One Time Password (OTP):</label>
        <p class="note">Please enter the 6 digits code sent to your mobile number.</p>
        <div class="otp-inputs">
            <input type="text" maxlength="1">
            <input type="text" maxlength="1">
            <input type="text" maxlength="1">
            <input type="text" maxlength="1">
            <input type="text" maxlength="1">
            <input type="text" maxlength="1">
        </div>
        <button class="btn confirm">Confirm</button>
    </div>
</div>
@endsection