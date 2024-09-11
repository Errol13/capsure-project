@extends('layouts.app')

@section('content')
<div class="container">
    <div class="stepper mb-4">
        <div class="line"></div>
        <div class="step done">
            <div class="circle"><i class="fas fa-check"></i></div>
            <p class="pt-3">VERIFY MOBILE NUMBER</p>
        </div>
        <div class="line"></div>
        <div class="step active">
            <div class="circle">2</div>
            <p class="pt-3">VERIFY ID</p>
        </div>
        <div class="line"></div>
    </div>

    <h2 class="mb-4" style="text-align: center;">Verify your Government ID</h2>

    <div class="xbox mb-4">
        <div class="form-section">
            <label for="government-id">Choose Government ID type:</label>
            <ul>
                <li class="note">ID must include your name, picture, and signature</li>
                <li class="note">Student ID is not allowed.</li>
            </ul>
            <div style="position: relative; display: flex; align-items: center;">
                <select class="form-control" style="padding-right: 30px; flex: 1;">
                    <option>Select ID type</option>
                    <option>Passport</option>
                    <option>Driver's License</option>
                    <option>National ID</option>
                </select>
                <i class="fas fa-angle-down" style="position: absolute; right: 10px; pointer-events: none;"></i>
            </div>
        </div>
    </div>

    <!-- Upload Section for ID and Selfie -->
    <div class="xbox">
        <label for="govrnment-id">Take a photo of your valid Government ID</label>
        <p class="note">IDs should be taken using a mobile phone camera. Scanned, digital copies, or photocopied IDs will be disapproved.</p>

        <div class="form-row mb-4 d-flex flex-wrap" style="gap: 10px;"> <!-- Small space between columns -->
           
            <!-- ID Photo Upload -->
            <div class="col-md-6 mb-3" style="flex: 1; display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
                <div class="upload-section" style="padding: 20px; height: 100%;">
                    <p class="text-center">ID PHOTO ONLY</p>
                    <div style="display: flex; justify-content: center; align-items: center; height: 100%;">
                        <img src="{{ asset('assets/validID.png') }}" style="height: 180px; width: 100%; max-width: 230px;" alt="Valid ID">
                    </div>
                    <ul class="note">
                        <i class="fas fa-check me-2" style="color: lightgreen;"></i> Clear photo and details
                    </ul>
                    <label for="selfiePhoto" class="upload-btn" style="display: block; text-align: center; border-radius:10px;padding: 10px; margin-top: 10px; background-color: #e9ecef;">
                        <i class="fas fa-upload me-2"></i>Upload your ID Photo here
                    </label>
                    <input type="file" id="idPhoto" accept="image/*">
                </div>
            </div>

            <!-- Selfie with ID Upload -->
            <div class="col-md-6 mb-3" style="flex: 1; display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
                <div class="upload-section" style="padding: 20px; height: 100%;">
                    <p class="text-center">SELFIE WITH ID PHOTO</p>
                    <div style="display: flex; justify-content: center; align-items: center; height: 100%;">
                        <img src="{{ asset('assets/selfieID.png') }}" style="height: 180px; width: 100%; max-width: 230px;" alt="Selfie ID">
                    </div>
                    <ul class="note">
                        <i class="fas fa-check me-2" style="color: lightgreen;"></i>Clear photo and ID details</br>
                        <i class="fas fa-check me-2" style="color: lightgreen;"></i>Person in the selfie should be the same person in the ID</br>
                        <i class="fas fa-check me-2" style="color: lightgreen;"></i>Holding the same uploaded government ID</br>
                    </ul>
                    <label for="selfiePhoto" class="upload-btn" style="display: block; text-align: center; border-radius:10px;padding: 10px; margin-top: 10px; background-color: #e9ecef;">
                        <i class="fas fa-upload me-2"></i>Upload your Selfie with ID here
                    </label>
                    <input type="file" id="selfiePhoto" accept="image/*">
                </div>
            </div>
        </div>

        <!-- Confirm Verification Button -->
        <div class="text-center">
            <a href="#" class="confirm" style="white-space: nowrap; max-width: 200px;">Submit</a>
            <p class="note mt-2">Your application will be verified within 2-3 days.</p>
        </div>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
        }

        .col-md-6 {
            width: 100%;
        }

        
        .upload-section {
            margin-bottom: 20px;
        }
    }

    .btn.confirm {
        width: 100%;
    }
</style>
@endsection