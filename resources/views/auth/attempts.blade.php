<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DHA 360 | Authentic Properties</title>

    <!-- For Face BooK Login -->
    <meta property="og:url" content="https://example.com" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Site's placeholder title" />
    <meta property="og:description" content="Site's placeholder description" />
    <meta property="og:image" content="https://mystoragebucket/mysiteimage.png" />
    <meta property="fb:app_id" content="888613483105988" />

    <!-- Favicons -->
    <link rel="icon" href="{{getAdminAsset('images/logo.ico')}}" sizes="36x36">
    <link rel="icon" href="{{getAdminAsset('images/logo.ico')}}" sizes="192x192">
    <link rel="apple-touch-icon" href="{{getAdminAsset('images/logo-1.png')}}">
    <meta name="msapplication-TileImage" content="{{getAdminAsset('images/logo-1.png')}}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <!-- Library: Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Library: swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Library: Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <!-- Library: Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link href="{{getAdminAsset('css/login.css')}}?v={{ config('app.version') }}" rel="stylesheet">
    <link href="{{getAdminAsset('css/media.css')}}?v={{ config('app.version') }}" rel="stylesheet">

    {!! RecaptchaV3::initJs() !!}

    @yield('local-style')
</head>

<body class="d-flex align-items-center justify-content-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4 alert alert-success text-white" :status="session('status')" />
                        <div class="login-form" id="loginTab">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="alert alert-danger ">Too many attempts! Please wait for <span id="time-left"></span> seconds.</div>

                                <div class="links-wrapper d-flex justify-content-between mb-3">
                                    <a href="{{ route('register') }}" id="registerLink" data-bs-toggle="tooltip" data-bs-title="If you do not have account, click here to create one">Register here!</a>
                                    @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" id="forgotPwLink" data-bs-toggle="tooltip" data-bs-title="Change your password, if you do not remember it">Forgot password?</a>
                                    @endif
                                    <a href="{{ route('home') }}">
                                        <i class="fa-solid fa-rotate-left"></i> Back to website
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- <script src="https://kit.fontawesome.com/c8d0b72f05.js" crossorigin="anonymous"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <!-- Library: custom -->
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
    <script src="{{getAdminAsset('js/register.js')}}?v={{ config('app.version') }}"></script>

    <script>
        const expiryTime = new Date(@json(session('otp_expiry_time'))).getTime();

        function updateCountdown() {
            const now = new Date().getTime();
            const timeLeft = Math.max(0, Math.floor((expiryTime - now) / 1000));

            const timeLeftDisplay = document.getElementById('time-left');
            timeLeftDisplay.innerText = timeLeft;

            if (timeLeft <= 0) {
                clearInterval(countdownInterval);
                timeLeftDisplay.innerText = "0";

                window.history.back();
            }
        }

        updateCountdown();
        const countdownInterval = setInterval(updateCountdown, 1000);
    </script>

</body>

</html>