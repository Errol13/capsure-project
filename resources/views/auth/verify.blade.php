<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email Address</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/capsure.css') }}">
    <style>
        .verification-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .verification-box {
            max-width: 500px;
            width: 100%;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .text-ver{
            color: #91216C;
        }
    </style>
</head>

<body>
    <div class="verification-container m-3">
        <div class="verification-box d-flex flex-column justify-content-center align-items-start " style="border-color: gray; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); ">
            <h4 class="text-center no-wrap fs-2 fw-bold text-ver">Verify Your Email Address</h4>

            @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
            @endif

            <p class="text-start note">
                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }},
            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="btn btn-seemore px-4 m-0 text-center text-decoration-none">{{ __('click here to request another') }}</button>.
            </form>
            </p>

            <p class="text-center note mt-4">If you entered a wrong email,
                <a href="{{ route('clear-session') }}" class="btn btn-outline-secondary btn-sm">
                    click here to register again
                </a>
            </p>

        </div>

    </div>
</body>

</html>