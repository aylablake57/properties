{{-- <x-guest-layout>
    <style>
        body {}

        :where(form, .input-field, header) {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        form .input-field {
            flex-direction: row;
            column-gap: 10px;
        }

        .input-field input {
            height: 45px;
            width: 42px;
            border-radius: 6px;
            outline: none;
            font-size: 1.125rem;
            text-align: center;
            border: 1px solid #ddd;
        }

        .input-field input:focus {
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
        }

        .input-field input::-webkit-inner-spin-button,
        .input-field input::-webkit-outer-spin-button {
            display: none;
        }
    </style>

    <div class="box-wrapper p-0 pb-5" style="height: auto;">
        @if (session('opt_status'))
            {!! session('opt_status') !!}
        @endif
        <div class="login-form mt-3" id="loginTab">
            <form method="POST" action="{{ route('check.emailotp') }}">
                @csrf
                <div class="title" id="title-topbar">Email Verification </div>
                <!-- OTP -->
                <div class="input-field">
                    <input type="number" class="otp" id="otp1" name="otp1" />
                    <input type="number" class="otp" id="otp2" disabled name="otp2" />
                    <input type="number" class="otp" id="otp3" disabled name="otp3" />
                    <input type="number" class="otp" id="otp4" disabled name="otp4" />
                </div>
                <div id="Retry-timer" style="display: none;" class="text-danger pb-3 pt-3">Please wait <span
                        id="retrytime">10:00</span> minutes before retrying.</div>
                <x-input-error :messages="$errors->get('otp')" class="text-small text-danger mt-2" />

                {{-- <div class="text-center">
                    <input required type="text" autocomplete="one-time-code" name="otp" inputmode="numeric" maxlength="4" pattern="\d{4}">
                    <x-input-error :messages="$errors->get('otp')" class="text-small text-danger mt-2" />
                </div> --}}

                <div class="text-center mt-3 w-100">
                    <button type="submit" class="btnLogin">Verify</button>
                </div>
            </form>
            <form method="POST" id="sendEmailOTP">
                @csrf
                <div class="text-center w-100">
                    <button type="submit" id="sendEmailOtpBtn" class="btnLogin">Resend OTP</button>
                    <!-- Timer placeholder -->
                    <div id="timer" style="display: none;">Please wait <span id="time">10:00</span> minutes to
                        resend OTP.</div>
                </div>
            </form>
            <div class="links-wrapper d-flex justify-content-between">
                <a class="" href="{{ route('home') }}">
                    <i class="fa-solid fa-rotate-left"></i> Back to website
                </a>
                <a class="" href="{{ route('otp.verification') }}">
                    Try another method <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
    @section('page_script')
        <script>
            const inputs = document.querySelectorAll(".otp");

            // iterate over all inputs
            inputs.forEach((input, index1) => {
                input.addEventListener("keyup", (e) => {
                    // This code gets the current input element and stores it in the currentInput variable
                    // This code gets the next sibling element of the current input element and stores it in the nextInput variable
                    // This code gets the previous sibling element of the current input element and stores it in the prevInput variable
                    const currentInput = input,
                        nextInput = input.nextElementSibling,
                        prevInput = input.previousElementSibling;

                    // if the value has more than one character then clear it
                    if (currentInput.value.length > 1) {
                        currentInput.value = "";
                        return;
                    }

                    // if the next input is disabled and the current value is not empty
                    //  enable the next input and focus on it
                    if (nextInput && nextInput.hasAttribute("disabled") && currentInput.value !== "") {
                        nextInput.removeAttribute("disabled");
                        nextInput.focus();
                    }

                    // if the backspace key is pressed
                    if (e.key === "Backspace") {
                        // iterate over all inputs again
                        inputs.forEach((input, index2) => {
                            // if the index1 of the current input is less than or equal to the index2 of the input in the outer loop
                            // and the previous element exists, set the disabled attribute on the input and focus on the previous element
                            if (index1 <= index2 && prevInput) {
                                input.setAttribute("disabled", true);
                                input.value = "";
                                prevInput.focus();
                            }
                        });
                    }

                    //if the fourth input( which index number is 3) is not empty and has not disable attribute then
                    //add active class if not then remove the active class.
                    if (!inputs[3].disabled && inputs[3].value !== "") {
                        $('#btnLogin').addClass("active");
                        return;
                    }
                    $('#btnLogin').removeClass("active");
                });
            });

            //focus the first input which index is 0 on window load
            window.addEventListener("load", () => inputs[0].focus());

            //THE RETRY TIMER SCRIPT STARTS HERE
            document.addEventListener("DOMContentLoaded", function() {
                const retryTimerDiv = document.getElementById("Retry-timer");
                const retryTimeSpan = document.getElementById("retrytime");
                const verifyBtn = document.querySelector('button[type="submit"]');
                const resendOtpBtn = document.getElementById("sendEmailOtpBtn");
                const otpBoxes = [
                    document.getElementById("otp1"),
                    document.getElementById("otp2"),
                    document.getElementById("otp3"),
                    document.getElementById("otp4")
                ];

                // This will calculate the time based on retry_after session value, 
                @if (session('retry_after'))
                    // adjust "$expired_at = now()->addMinutes(10)" in OtpVerificationController to manage the session time
                    let retryAfter = {{ session('retry_after') }} * 1000; // Convert to milliseconds
                    let currentTime = new Date().getTime(); // Get current time in milliseconds
                    let remainingTime = retryAfter - currentTime; // Remaining time until retry allowed

                    if (remainingTime > 0) {
                        // Show the retry timer and disable both buttons while countdown is active
                        retryTimerDiv.style.display = "block";
                        verifyBtn.disabled = true; // Disable verify button
                        resendOtpBtn.disabled = true; // Disable resend OTP button
                        verifyBtn.classList.add("btn-disabled");
                        resendOtpBtn.classList.add("btn-disabled");
                        verifyBtn.classList.add("btn-disabled");
                        //Loop adds the otp-retry-alert class from otp boxes 
                        otpBoxes.forEach(otpBox => {
                            otpBox.disabled = true; // Disable each OTP input box
                            otpBox.classList.add("otp-retry-alert");
                        });


                        // Set the initial time in the timer display
                        let minutes = Math.floor(remainingTime / (1000 * 60));
                        let seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);
                        retryTimeSpan.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

                        // Start the countdown
                        let countdown = setInterval(function() {
                            remainingTime -= 1000; // Reduce time by 1 second

                            minutes = Math.floor(remainingTime / (1000 * 60));
                            seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

                            // Update the timer display
                            retryTimeSpan.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

                            // If the timer reaches 0, stop the countdown, hide the timer, and enable the buttons
                            if (remainingTime <= 0) {
                                clearInterval(countdown); // Stop the countdown
                                retryTimerDiv.style.display = "none"; // Hide the retry timer
                                verifyBtn.disabled = false; // Enable verify button
                                resendOtpBtn.disabled = false; // Enable resend OTP button
                                verifyBtn.classList.remove("btn-disabled");
                                resendOtpBtn.classList.remove("btn-disabled");
                                //Loop removes the otp-retry-alert class from otp boxes 
                                otpBoxes.forEach(otpBox => {
                                    otpBox.disabled = false; // Re-enable each OTP input box
                                    otpBox.classList.remove("otp-retry-alert");
                                });
                            }
                        }, 1000); // Decrease the timer every second (1000 ms)
                    }
                @endif
                //THE RETRY TIMER SCRIPT ENDS HERE
            });
        </script>
    @endsection
</x-guest-layout> --}}
