<x-guest-layout>
    <div class="box-wrapper p-0 pb-5" style="height: 80vh;">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4 alert alert-success text-white" :status="session('status')" />
        <div class="login-form" id="loginTab">
            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf
                <div class="title mb-3" id="title-topbar">Sign into your account </div>
                <!-- Email Address -->
                <div class="mb-3">
                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" data-bs-toggle="tooltip" data-bs-title="Enter your email address" autofocus required placeholder="Email" autocomplete="email">
                    <div class="text-small text-danger mt-2 d-flex justify-content-start" id="combined-error-message">
                        <x-input-error :messages="$errors->get('email')" class="d-inline" />
                        <span id="error-message" class="d-inline"></span>
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control" data-bs-toggle="tooltip" data-bs-title="Enter your password" placeholder="Password">
                        <span class="input-group-text"><i class="far fa-eye-slash show_hide_password" id="togglePassword"></i></span>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="mb-3 text-end">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember_me">
                        <span class="ms-1 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>


                {!! RecaptchaV3::field('login') !!}
                <input type="submit" class="btnLogin mb-3" data-bs-toggle="tooltip" data-bs-title="Click here to access your dashboard" value="login"/>

                <div class="d-flex mb-3">
                    <a href="{{ url('auth/google_login') }}" class="btn btn-white flex-fill border-dark" data-bs-toggle="tooltip" data-bs-title="Click here to access your dashboard by using gmail account">
                        <img src="{{ getAdminAsset('images/icons/google-login.svg') }}" class="me-2" width="20" alt="google-logo">
                        Login with Google
                    </a>
                </div>
                <div class="d-flex mb-3">
                    <a href="{{ url('auth/facebook_login') }}" class="btn btn-primary flex-fill border-primary" data-bs-toggle="tooltip" data-bs-title="Click here to access your dashboard by using your facebook account">
                        <img src="{{ getAdminAsset('images/icons/facebook-login.svg') }}" class="me-2" width="20" alt="facebook-logo">
                        Login with Facebook
                    </a>
                </div>

                <div class="links-wrapper d-flex justify-content-between mb-3">
                    <a href="{{ route('register') }}" id="registerLink" data-bs-toggle="tooltip" data-bs-title="If you do not have account, click here to create one">Register here!</a>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" id="forgotPwLink" data-bs-toggle="tooltip" data-bs-title="Change your password, if you do not remember it">Forgot password?</a>
                    @endif
                    <a href="{{ route('home') }}" >
                        <i class="fa-solid fa-rotate-left"></i> Back to website
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
<script>
    @if ($errors->has('email') && strpos($errors->first('email'), 'Too many login attempts') !== false)
        document.getElementById('email').disabled = true;
        document.getElementById('password').disabled = true;
        document.querySelector('input[type="submit"]').disabled = true;
        let timeLeft = 60;
        const errorMessageElement = document.getElementById('error-message');
        const combinedErrorMessageElement = document.getElementById('combined-error-message');

        const countdownTimer = setInterval(function() {
            if (timeLeft <= 0) {
                clearInterval(countdownTimer); 
                errorMessageElement.textContent = ''; // Clear the countdown message
                combinedErrorMessageElement.remove(); // Remove the outer div when timer ends

                // Re-enable the inputs after the countdown ends
                document.getElementById('email').disabled = false;
                document.getElementById('password').disabled = false;
                document.querySelector('input[type="submit"]').disabled = false;
            } else {
                // Update the countdown text
                errorMessageElement.textContent = ' Please try again in ' + timeLeft + ' seconds.';
                timeLeft--;
            }
        }, 1000);   
    @endif
</script>
