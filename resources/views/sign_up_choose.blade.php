@extends('layouts.app')

@section('content')

<div class="container poppins-light">
    <div class="row justify-content-center">

        <span class="fs-1 fw-medium text-center p-4 mt-4"> Choose to Sign Up </span>
        <!-- First Box -->
        <div class="col-12 col-md-4 col-lg-3 d-flex flex-column align-items-center mb-1 mb-md-1 p-1 p-md-2"  id="box1">
            <div class="text-center p-md-3 border-1 rounded-4 box box-content" data-page="client">
                <img src="{{ asset('assets/Account.svg') }}" type="image/svg+xml" alt="Image 1" class="mt-4 p-4 img-fluid mb-2">
                <p class="pt-1 pt-md-4 fw-medium">I am Client</p>
            </div>
        </div>

        <!-- Second Box -->
        <div class="col-12 col-md-4 col-lg-3 d-flex flex-column align-items-center mb-md-1 p-1 p-md-2 "  id="box2">
            <div class=" box text-center p-md-3 border-1 rounded-4  box-content" data-page="freelancer">
                <img src="{{ asset('assets/Lawyer.svg') }}" type="image/svg+xml" alt="Image 2" class=" mt-4 p-4 img-fluid mb-2">
                <p class="pt-2 pt-md-4 fw-medium">I am a Freelancer</p>
            </div>
        </div>

        <!--Continue -->
        <div class="text-center my-3 ">
            <button type="button" class="btn-auth rounded-pill border-0" id="continueBtn" disabled>
                Continue
            </button>

            <div class="mt-2 mt-md-2">
                <div class="d-flex justify-content-center align-items-center">
                    <p class="mb-0 me-2">Already have an account?</p>
                    <a href="{{ route('login') }}" class="text-purple fs-6 fw-medium">Log in</a>
                </div>
            </div>

        </div>
    </div>
</div>


@endsection

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const boxes = document.querySelectorAll('.box');
        const continueBtn = document.getElementById('continueBtn');
        let selectedPage = '';

        boxes.forEach(box => {
            box.addEventListener('click', () => {
                // Remove selected class from all boxes
                boxes.forEach(b => b.classList.remove('selected'));
                
                // Add selected class to the clicked box
                box.classList.add('selected');

                // Store the page to navigate to
                selectedPage = box.getAttribute('data-page');
                
                // Enable the continue button
                continueBtn.disabled = false;
            });
        });

        continueBtn.addEventListener('click', () => {
            if (selectedPage) {
                // Redirect based on the selected page
                window.location.href = selectedPage === 'client' ? '/register/client' : '/register/freelancer';
            }
        });
    });
</script>