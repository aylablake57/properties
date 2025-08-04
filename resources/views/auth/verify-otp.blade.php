<x-guest-layout>
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

        .btn-disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>

    <div class="box-wrapper p-0 pb-5" style="height: auto;">
        @if (session('opt_status'))
            {!! session('opt_status') !!}
        @endif
        <div class="login-form mt-3" id="loginTab">

            <form method="POST" action="{{ route('check.otp') }}">
                @csrf
                @if ($type == 'sms')
                    <div class="title" id="title-topbar">Mobile Number Verification</div>
                @elseif ($type == 'email')
                    <div class="title" id="title-topbar">Email Verification</div>
                @endif

                <input type="hidden" name="type" value="{{ $type }}">
                <!-- OTP input fields -->
                <div class="input-field">
                    <input type="number" class="otp" id="otp1" name="otp1" required />
                    <input type="number" class="otp" id="otp2" disabled name="otp2" required />
                    <input type="number" class="otp" id="otp3" disabled name="otp3" required />
                    <input type="number" class="otp" id="otp4" disabled name="otp4" required />
                </div>
                <x-input-error :messages="$errors->get('otp')" class="text-small text-danger mt-2" />

                <div id="retry-timer" class="text-danger pb-3 pt-3">
                    Please wait <span id="countdown">{{ $remaining_time }}</span> seconds
                </div>

                <!-- Submit button -->
                <div class="text-center mt-3 w-100">
                    <button type="submit" class="btnLogin" id="verifyBtn">Verify</button>
                </div>
            </form>

            <!-- Resend OTP form -->
            <form method="POST" id="sendOTP" action="{{ route('send.otp') }}">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">
                <div class="text-center w-100">
                    <button type="submit" id="sendOtpBtn" class="btnLogin d-none">Resend OTP</button>
                </div>
                <div id="timer" class="d-none">
                    Please wait <span id="time"></span> minutes to resend OTP.
                </div>
            </form>

            @if ($type == 'sms')
                <p class="text-center">or</p>
                <button type="button" class="btnLogin" id="editMobileNumberBtn" data-bs-toggle="modal"
                    data-bs-target="#otpModal">Edit Mobile
                    Number</button>
                <div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="otpModalLabel">Edit Mobile Number</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('edit.mobile') }}">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <x-phone-input name="mobile_number" placeholder="Mobile Number" />
                                    </div>

                                    <div class="text-right">
                                        <button type="submit" class="btnLogin">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="links-wrapper d-flex justify-content-between">
                <a class="" href="{{ route('home') }}">
                    <i class="fa-solid fa-rotate-left"></i> Back to website
                </a>
                @auth
                    @if (!Auth::user()->google_id && !Auth::user()->facebook_id)
                        <a class="" href="{{ route('otp.verification') }}">
                            Try another method <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
    @php
        $remainingTime = session('remaining_time', 0);

    @endphp
    @section('page_script')
        <script>
            let tooManyAttempts = 0;
            const inputs = document.querySelectorAll(".otp");
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
            window.addEventListener("load", () => inputs[0].focus());

            document.addEventListener("DOMContentLoaded", function() {
                let remainingTime = {{ $remaining_time }};
                let otpSession = {{ $otp_session }};
                // console.log({{ auth()->user()->too_many_attempt }})

                let rateLimitSeconds = {{ session('rate_limit_seconds', 0) }};

                const storedRateLimit = sessionStorage.getItem('rateLimitSeconds');
                const storedRateLimitExpiry = sessionStorage.getItem('rateLimitExpiry');
                console.log("storedRateLimit:", storedRateLimit);

                function checkRateLimit() {
                    const storedRateLimitExpiry = sessionStorage.getItem('rateLimitExpiry');

                    if (storedRateLimitExpiry) {
                        const now = new Date().getTime();
                        if (now >= parseInt(storedRateLimitExpiry)) {
                            console.log('here')
                            sessionStorage.removeItem('rateLimitSeconds');
                            sessionStorage.removeItem('rateLimitExpiry');
                            window.location.reload();
                            return;
                        }
                        // tooManyAttempts = true;
                        rateLimitSeconds = Math.ceil((parseInt(storedRateLimitExpiry) - now) / 1000);
                    } else if (tooManyAttempts) {
                        sessionStorage.setItem('rateLimitSeconds', rateLimitSeconds);
                        sessionStorage.setItem('rateLimitExpiry', new Date().getTime() + rateLimitSeconds * 1000);
                    }
                }

                console.log("otpSession:", otpSession);
                console.log("remainingTime:", remainingTime);
                console.log("tooManyAttempts:", tooManyAttempts);
                console.log("rateLimitSeconds:", rateLimitSeconds);
                let countdownInterval;

                const countdownElement = $('#countdown');
                const retryTimerElement = $('#retry-timer');
                const resendButton = $('#sendOtpBtn');
                const verifyButton = $('#verifyBtn');
                const editMobileNumberBtn = $('#editMobileNumberBtn');

                function formatTime(seconds) {
                    const minutes = Math.floor(seconds / 60);
                    const remainingSeconds = Math.floor(seconds % 60);
                    return `${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
                }

                function updateTimerDisplay() {
                    if (tooManyAttempts) {

                        clearInterval(countdownInterval);
                        retryTimerElement.removeClass('d-none');
                        resendButton.removeClass('d-none');
                        if (rateLimitSeconds <= 0) {
                            resendButton.prop('disabled', false).removeClass('btn-disabled');
                            editMobileNumberBtn.prop('disabled', false).removeClass('btn-disabled');
                            retryTimerElement.addClass("d-none");
                        } else {
                            resendButton.prop('disabled', true).addClass('btn-disabled');
                            editMobileNumberBtn.prop('disabled', true).addClass('btn-disabled');
                        }
                        // resendButton.prop('disabled', true).addClass('btn-disabled');
                        verifyButton.prop('disabled', true).addClass('btn-disabled');
                        countdownElement.text(formatTime(rateLimitSeconds));


                    } else if (remainingTime > 0 && otpSession) {
                        retryTimerElement.removeClass('d-none');
                        resendButton.prop('disabled', true).addClass('btn-disabled');
                        verifyButton.prop('disabled', false).removeClass('btn-disabled');
                        countdownElement.text(formatTime(remainingTime));
                        editMobileNumberBtn.prop('disabled', false).removeClass('btn-disabled');
                    } else {

                        clearInterval(countdownInterval);
                        retryTimerElement.addClass('d-none');
                        resendButton.removeClass('d-none');
                        resendButton.prop('disabled', false).removeClass('btn-disabled');
                        verifyButton.prop('disabled', true).addClass('btn-disabled');
                        editMobileNumberBtn.prop('disabled', false).removeClass('btn-disabled');
                    }
                }

                function startTimer() {
                    clearInterval(countdownInterval);
                    remainingTime = {{ $remaining_time }};
                    updateTimerDisplay();

                    countdownInterval = setInterval(() => {
                        if (tooManyAttempts) {
                            rateLimitSeconds--;
                            updateTimerDisplay();
                        } else if (remainingTime > 0 && otpSession) {
                            remainingTime--;
                            updateTimerDisplay();
                        } else {
                            clearInterval(countdownInterval);
                            updateTimerDisplay();
                        }
                    }, 1000);
                }

                function startTimer() {
                    checkRateLimit(); // Check rate limit initially
                    updateTimerDisplay(); // Update the timer display based on current conditions

                    // Set an interval to run every second
                    const countdownInterval = setInterval(() => {
                        checkRateLimit(); // Check rate limit every second

                        if (tooManyAttempts) {
                            rateLimitSeconds--;
                            updateTimerDisplay();
                            if (rateLimitSeconds <= 0) {
                                clearInterval(countdownInterval); // Stop the timer once limit ends
                            }
                        } else if (remainingTime > 0 && otpSession) {
                            remainingTime--;
                            updateTimerDisplay();
                        } else {
                            clearInterval(countdownInterval); // Stop the timer once remaining time ends
                        }
                    }, 1000);
                }




                function fetchTooManyAttemptsStatus(callback) {
                    $.ajax({
                        url: "{{ route('otp.attempts') }}",
                        method: 'GET',
                        success: function(response) {
                            tooManyAttempts = response.too_many_attempts;
                            console.log("tooManyAttempts updated:", tooManyAttempts);
                            callback(); // Start the timer after the AJAX response
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching tooManyAttempts status:', error);
                        }
                    });
                }

                // Fetch the tooManyAttempts status, and after that, start the timer
                fetchTooManyAttemptsStatus(startTimer);
            });
        </script>
    @endsection
</x-guest-layout>
