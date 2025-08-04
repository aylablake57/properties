<x-guest-layout>
    <div class="box-wrapper p-0 pb-5" style="height: auto;">
        <div class="login-form" id="loginTab">
            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <div class="title" id="title-topbar">Change Password</div>
                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div>
                    <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email', $request->email)" required autofocus readonly autocomplete="username" placeholder="Enter Email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                </div>

                <!-- Password -->
                <div class="mt-1">
                    <div class="input-group">
                        <x-text-input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" placeholder="Enter New Password"/>
                        <span class="input-group-text"><i class=" far fa-eye-slash show_hide_password" id="togglePassword"></i></span>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-1">
                    <div class="input-group">
                        <x-text-input id="password_confirmation" class="form-control"
                                        type="password"
                                        name="password_confirmation" required autocomplete="new-password" placeholder="Confirm New Password"/>
                        <span class="input-group-text"><i class=" far fa-eye-slash show_hide_password" id="toggleConfirmPassword"></i></span>
                    </div>

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger" />
                </div>
                <button type="submit" class="btnLogin">Reset Password</button>

                <!-- <div class="flex items-center justify-end mt-4">
                    <x-primary-button>
                        {{ __('Reset Password') }}
                    </x-primary-button>
                </div> -->
            </form>
        </div>
    </div>
</x-guest-layout>
