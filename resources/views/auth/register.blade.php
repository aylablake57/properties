<x-guest-layout>
    <div class="box-wrapper p-0 pb-5">
        @if (session('social_auth_status'))
            {!! session('social_auth_status') !!}
        @endif
        <x-auth-session-status class="mb-4 alert alert-success text-white" :status="session('status')" />
        <div class="login-form" id="loginTab">
            <form method="POST" action="{{ route('register.store') }}">
                @csrf
                <div class="title" id="title-topbar">Create an account </div>

                <!-- User Type -->
                <div>
                    <select class="form-select" id="userType" name="user_type" onchange="displayCNIC(this.value)"
                        data-bs-toggle="tooltip" data-bs-title="Select your account type with reference to your use">
                        <option selected disabled>Select User Type</option>
                        @foreach ($userTypes as $userType)
                            <option value="{{ $userType->value }}" @selected(old('user_type') == $userType->value)>{{ $userType->label() }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('userType')" class="text-small text-danger mt-2" />
                </div>

                <div class="row">
                    <!-- Name -->
                    <div class="col-sm-6">
                        <x-text-input id="name" class="form-control" type="text" name="name"
                            placeholder="Name" :value="old('name')" required autofocus autocomplete="name"
                            data-bs-toggle="tooltip" data-bs-title="Enter your full name" />
                        <x-input-error :messages="$errors->get('name')" class="text-small text-danger mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="col-sm-6">
                        <x-text-input id="email" class="form-control" type="email" name="email"
                            placeholder="Email" :value="old('email')" required autocomplete="email" data-bs-toggle="tooltip"
                            data-bs-title="Enter your email address" />
                        <x-input-error :messages="$errors->get('email')" class="text-small text-danger mt-2" />
                    </div>
                </div>

                <div>
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control mb-0"
                            placeholder="Password" required autocomplete="new-password" data-bs-toggle="tooltip"
                            data-bs-title="The password must contain at least 8 characters with atleast one uppercase, one lowercase letter , numbers and one special character. ">
                        <span class="input-group-text mb-0"><i class=" far fa-eye-slash show_hide_password"
                                id="togglePassword"></i></span>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="text-small text-danger mt-2" />
                </div>
                <div class="input-group">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="form-control mb-0" placeholder="Retype Password" required autocomplete="new-password"
                        data-bs-toggle="tooltip" data-bs-title="Retype your password for confirmation">
                    <span class="input-group-text mb-0"><i class=" far fa-eye-slash show_hide_password"
                            id="toggleConfirmPassword"></i></span>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="text-small text-danger mt-2" />

                <!-- Phone -->
                <x-phone-input name="phone" id="phone" placeholder="Your Phone (3xxxxxxxxx)"/>

                <!-- CNIC -->
                <div class="cnic_number <?= old('user_type') ? (old('user_type') != 'seller' ? '' : 'd-none') : 'd-none' ?>">
                    <x-text-input type="text" id="cnic" name="cnic" class="form-control"
                        placeholder="CNIC: (xxxxx-xxxxxxx-x)" :value="old('cnic')" autocomplete="cnic"
                        data-bs-toggle="tooltip" data-bs-title="Enter your CNIC number according to the format" />
                    <x-input-error :messages="$errors->get('cnic')" class="text-small text-danger mt-2" />
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" required>
                    <label class="form-check-label" for="flexCheckDefault" data-bs-toggle="tooltip"
                        data-bs-title="By checking this option you are giving your concent to agree our terms and conditions">
                        I agree with terms & conditions
                    </label>
                </div>

                {!! RecaptchaV3::field('register') !!}
                <input type="submit" class="btnLogin mb-3" data-bs-toggle="tooltip" data-bs-title="Click here to become authorized to access your dashboard" value="Register" />

                <div class="d-flex mb-3">
                    <a href="" class="btn btn-white flex-fill border-dark" id="googleSignUpButton"
                        data-bs-toggle="tooltip"
                        data-bs-title="Use your google account to get access to your dashboard">
                        <img src="{{ getAdminAsset('images/icons/google-login.svg') }}" class="me-2" width="20"
                            alt="google-logo">
                        Sign up with Google
                    </a>
                </div>
                <div class="d-flex mb-3">
                    <a href="" class="btn btn-primary flex-fill border-primary" id="facebookSignUpButton"
                        data-bs-toggle="tooltip"
                        data-bs-title="Use your facebook account to get access to your dashboard">
                        <img src="{{ getAdminAsset('images/icons/facebook-login.svg') }}" class="me-2"
                            width="20" alt="facebook-logo">
                        Sign up with Facebook
                    </a>
                </div>

                <div class="links-wrapper d-flex justify-content-between">
                    <a href="{{ route('login') }}" id="backToLogin" data-bs-toggle="tooltip"
                        data-bs-title="Click here to go to login page">Back to login</a>
                    <a class="" href="{{ route('home') }}">
                        <i class="fa-solid fa-rotate-left"></i> Back to website
                    </a>
                </div>
            </form>
        </div>

    </div>

    {{-- </div> --}}

</x-guest-layout>
