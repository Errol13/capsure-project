<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Capsure</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/capsure.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body>
    <div class="bg-signup"></div>
    <div class="container card-container mt-3 mt-md-3 txt-smaller poppins-light">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card bg-white px-4 " style="border-radius: 20px;">
                    <a class="btn-close position-absolute" href="{{ route('client-settings') }}" style="top: 10px; right: 10px;" aria-label="Close"></a>
                    <div class="card-header border-0 bg-white fs-4 text-center poppins-medium mt-2">
                        Fill to proceed as <b class="text-purple poppins-medium">Freelancer</b>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register.freelancer.post') }}">
                            @csrf

                            <!-- Job Title -->
                            <div class="mb-3">
                                <label for="job_title" class="form-label">{{ __('Job Title') }}</label>
                                <input id="job_title" type="text" class="mx-1 form-control @error('job_title') is-invalid @enderror" name="job_title" value="{{ old('job_title') }}" required autocomplete="job_title">
                                @error('job_title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Job Category -->
                            <div class="mb-3">
                                <label for="job_category" class="form-label">{{ __('Job Category') }}</label>
                                <select id="job_category" class="mx-1 form-select @error('job_category') is-invalid @enderror" name="job_category" required>
                                    <option value="" disabled selected></option>
                                    <option value="Arts" {{ old('job_category') == 'Arts' ? 'selected' : '' }}>Arts</option>
                                    <option value="Entertainment" {{ old('job_category') == 'Entertainment' ? 'selected' : '' }}>Entertainment</option>
                                    <option value="Event Planner" {{ old('job_category') == 'Event Planner' ? 'selected' : '' }}>Event Planner</option>
                                    <option value="Food Service" {{ old('job_category') == 'Food Service' ? 'selected' : '' }}>Food Service</option>
                                    <option value="Handicrafts" {{ old('job_category') == 'Handicrafts' ? 'selected' : '' }}>Handicrafts</option>
                                    <option value="Online Services" {{ old('job_category') == 'Online Services' ? 'selected' : '' }}>Online Services</option>
                                    <option value="Photography" {{ old('job_category') == 'Photography' ? 'selected' : '' }}>Photography</option>
                                    <option value="Styling" {{ old('job_category') == 'Styling' ? 'selected' : '' }}>Styling</option>
                                    <option value="Videography" {{ old('job_category') == 'Videography' ? 'selected' : '' }}>Videography</option>
                                    <option value="Voice Talent" {{ old('job_category') == 'Voice Talent' ? 'selected' : '' }}>Voice Talent</option>
                                </select>
                                @error('job_category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="row mb-4">
                                <!-- Job Fee -->
                                <div class="col-12 col-md-6">
                                    <label for="job_fee" class="form-label">{{ __('Job Fee') }}</label>
                                    <input id="job_fee" type="number" step="0.01" class="mx-1 form-control @error('job_fee') is-invalid @enderror" name="job_fee" value="{{ old('job_fee') }}" required autocomplete="job_fee">
                                    @error('job_fee')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <!-- Fee Type -->
                                <div class="col-12 col-md-6">
                                    <label for="fee_type" class="form-label">{{ __('Fee Type') }}</label>
                                    <select id="fee_type" class="mx-0 form-select @error('fee_type') is-invalid @enderror" name="fee_type" required>
                                        <option value="" disabled selected></option>
                                        <option value="/hour" {{ old('fee_type') == '/hour' ? 'selected' : '' }}>/hr</option>
                                        <option value="/project" {{ old('fee_type') == '/project' ? 'selected' : '' }}>/project</option>
                                    </select>
                                    @error('fee_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="text-center mb-4">
                                <button type="submit" class="confirm">
                                    Continue
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        html,
        body {
            height: 100%;
            overflow: hidden;
        }


        .card {
            max-width: 600px;
            width: 100%;
        }

        .card-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
    </style>
</body>

</html>