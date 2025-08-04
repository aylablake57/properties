<x-guest-layout>


    <div class="box-wrapper p-0 pb-5" style="height: auto;">
        <!-- Session Status -->
        <x-auth-session-status class="alert alert-success" :status="session('status')" />
        <div class="login-form" id="loginTab">

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="title" id="title-topbar">Forgot your password?</div>
                <div class="mb-4 text-sm text-gray-600">
                    {{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </div>

                <!-- Email Address -->
                <div>
                    {{-- <x-input-label for="email" :value="__('Email')" /> --}}
                    <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus placeholder="Email"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                </div>

                <button type="submit" class="btnLogin">Email Password Reset Link</button>

                <div class="links-wrapper d-flex justify-content-between">
                    <a href="{{ route('login') }}" id="backToLogin">Back to login</a>
                    <a href="{{ route('home') }}" >
                        <i class="fa-solid fa-rotate-left"></i> Back to website
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
