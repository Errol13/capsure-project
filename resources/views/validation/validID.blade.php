@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="my-4 pt-4" style="text-align: center;">Verify your Government ID</h2>

    <form id="id-form-validation" method="POST" action="{{ url('/validate-id/store') }}" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="xbox mb-4">
            <div class="form-section">
                <label for="government-id">Choose Government ID type:</label>
                <ul>
                    <li class="note">ID must include your name, picture, and signature</li>
                    <li class="note">Student ID is not allowed.</li>
                    <li class="note">All fields are required.</li>
                </ul>
                <div style="position: relative; display: flex; align-items: center;">
                    <select name="id_type" class="form-control" style="padding-right: 30px; flex: 1;" required>
                        <option disabled selected>Select ID type</option>
                        <option>UMID</option>
                        <option>Passport</option>
                        <option>Driver's License</option>
                        <option>Philippine Identification (PhilID)</option>
                        <option>Professional Regulation Commission (PRC) ID</option>
                        <option>Senior Citizen ID</option>
                        <option>SSS ID</option>
                        <option>COMELEC / Voter’s ID</option>
                        <option>Integrated Bar of the Philippines (IBP) ID</option>
                        <option>Firearms License</option>
                        <option>AFPSLAI ID</option>
                        <option>AFP Beneficiary ID</option>
                        <option>BIR (TIN)</option>
                        <option>Pag-ibig ID</option>
                        <option>Person’s With Disability (PWD) ID</option>
                        <option>Solo Parent ID</option>
                        <option>Philippine Postal ID</option>
                        <option>Phil-health ID</option>

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
                <div class="col-md-6 mb-3" style="flex: 1; display: flex; flex-direction: column; justify-content: space-between; min-height: 400px;">
                    <div style="padding: 20px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                        <p class="text-center">ID PHOTO ONLY</p>
                        <div style="display: flex; justify-content: center; align-items: center; flex-grow: 1;">
                            <img src="{{ asset('assets/validID.png') }}" style="height: 180px; width: 100%; max-width: 230px;" alt="Valid ID">
                        </div>
                        <ul class="note">
                            <i class="fas fa-check me-2" style="color: lightgreen; height:75px;"></i> Clear photo and details
                        </ul>
                    </div>
                    <div class="upload-section" style="padding: 10px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                        <div style="display: flex; justify-content: center; align-items: center; flex-grow: 1;">
                            <img src="{{ asset('assets/idphoto_def.svg') }}" id="id-photo" style="height: 180px; width: 100%; max-width: 230px;" alt="Valid ID">
                        </div>
                        <label for="idPhoto" class="upload-btn" style="cursor:pointer; display: block; text-align: center; border-radius: 10px; padding: 10px; margin-top: 10px; background-color: #e9ecef;">
                            <i class="fas fa-upload me-2"></i>Upload your ID Photo here
                        </label>
                        <input type="file" name="id_card_image" id="idPhoto" accept="image/*" style="display: none;" required>
                    </div>
                </div>

                <!-- Selfie with ID Upload -->
                <div class="col-md-6 mb-3" style="flex: 1; display: flex; flex-direction: column; justify-content: space-between; min-height: 400px;">
                    <div style="padding: 20px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                        <p class="text-center">SELFIE WITH ID PHOTO</p>
                        <div style="display: flex; justify-content: center; align-items: center; flex-grow: 1;">
                            <img src="{{ asset('assets/selfieID.png') }}" style="height: 180px; width: 100%; max-width: 230px;" alt="Selfie ID">
                        </div>
                        <ul class="note">
                            <i class="fas fa-check me-2" style="color: lightgreen;"></i> Clear photo and ID details</br>
                            <i class="fas fa-check me-2" style="color: lightgreen;"></i> Person in the selfie should be the same person in the ID</br>
                            <i class="fas fa-check me-2" style="color: lightgreen;"></i> Holding the same uploaded government ID</br>
                        </ul>
                    </div>
                    <div class="upload-section" style="padding: 10px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                        <div style="display: flex; justify-content: center; align-items: center; flex-grow: 1;">
                            <img src="{{ asset('assets/idphoto_def.svg') }}" id="selfie-with-id" style="height: 180px; width: 100%; max-width: 230px;" alt="Selfie ID">
                        </div>
                        <label for="selfiePhoto" class="upload-btn" style="cursor:pointer; display: block; text-align: center; border-radius: 10px; padding: 10px; margin-top: 10px; background-color: #e9ecef;">
                            <i class="fas fa-upload me-2"></i>Upload your Selfie with ID here
                        </label>
                        <input type="file" name="pic_with_id" id="selfiePhoto" accept="image/*" style="display: none;" required>
                    </div>
                </div>

            </div>


            <!-- Confirm Verification Button -->
            <div class="text-center">
                <button type="submit" id="submit-button-id" class="w-50 confirm" disabled>Submit</button>
                <p class="note mt-2">Your application will be verified within 2-3 days.</p>
            </div>

        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function previewImage(input, imgElementId) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(imgElementId).src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }

        document.getElementById('idPhoto').addEventListener('change', function() {
            previewImage(this, 'id-photo');
        });

        document.getElementById('selfiePhoto').addEventListener('change', function() {
            previewImage(this, 'selfie-with-id');
        });

        function checkFields() {
            const idType = document.querySelector('select[name="id_type"]');
            const idPhoto = document.getElementById('idPhoto');
            const selfiePhoto = document.getElementById('selfiePhoto');
            const submitButton = document.getElementById('submit-button-id');

            const allFieldsFilled = idType.value && idPhoto.files.length > 0 && selfiePhoto.files.length > 0;

            if (allFieldsFilled) {
                submitButton.disabled = false;
                submitButton.classList.remove('btn-secondary', 'btn');
                submitButton.classList.add('confirm');
            } else {
                submitButton.disabled = true;
                submitButton.classList.add('btn-secondary', 'btn');
                submitButton.classList.remove('confirm');
            }
        }

        document.querySelector('select[name="id_type"]').addEventListener('change', checkFields);
        document.getElementById('idPhoto').addEventListener('change', checkFields);
        document.getElementById('selfiePhoto').addEventListener('change', checkFields);
        checkFields();

        document.getElementById('id-form-validation').addEventListener('submit', function(e) {
            // console.log('Form submitted');
        });
    });
</script>


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