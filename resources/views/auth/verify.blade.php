<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email Address</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .verification-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f9f9f9;
        }

        .verification-box {
            max-width: 500px;
            width: 100%;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="verification-container">
        <div class="verification-box">
            <h2 class="text-center mb-4">Verify Your Email Address</h2>

            @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('A new verification link has been sent to your email address.') }}
            </div>
            @endif

            <p class="text-center">
                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }},
            </p>

            <form class="d-inline text-center" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
            </form>

            <div class="text-center mt-4">
                <p>If you need to use a different email or entered wrong email.  
                    <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-sm"  
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">  
                        Register Again  
                    </a>.
                </p>
            </div>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</body>

</html>
