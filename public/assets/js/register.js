function displayCNIC(userType) {
    $(".cnic_number").addClass("d-none");
    $("#cnic").prop("disabled", true);
    if (userType !== "seller") {
        if (userType === "agent") {
            $("#cnic").attr("placeholder", "CNIC: (xxxxx-xxxxxxx-x)");
            $("#cnic").prop("disabled", false);
        }
        if (userType === "agency") {
            $("#cnic").attr("placeholder", "CEO CNIC: (xxxxx-xxxxxxx-x)");
            $("#cnic").prop("disabled", false);
        }
        $(".cnic_number").removeClass("d-none");
    }
}

$(document).ready(function () {
    $("#cnic").mask("00000-0000000-0", { placeholder: "_____-_______-_" });
    // $('#phone').mask('00 (000) 000-0000', {placeholder: "__ (___) ___-____"});
    // $('#phone').attr('placeholder', 'Phone: 00 (000) 000-0000');
    /* $('#phone').mask("+929999999999", {placeholder: "+92__________"});
    $('#phone').attr('placeholder', 'Phone: +920000000'); */


    // this is for both sms and email send otp
    $(document).on("submit", "#sendOTP", function (event) {
        event.preventDefault();

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $("#sendOtpBtn").attr("disabled", true);

        $.ajax({
            type: "POST",
            url: $(this).attr('action'), // Use the form's action attribute
            data: $(this).serialize(),
            dataType: "JSON",
            success: function (response, status, xhr) {
                console.log(response);
                if (xhr.status === 200) {
                    toastr.success(response.msg); // Show success message
                    const sentTime = Date.now(); // Capture the current time
                    sessionStorage.setItem("remainingTime", sentTime); // Store it in session storage

                    $("#sendOtpBtn").addClass("d-none"); // Hide the resend button
                    $("#retry-timer").removeClass("d-none"); // Show the timer display
                    let showTimer = true;
                    // Start a 2-minute countdown timer
                    startTimer(
                        2 * 60,
                        document.getElementById("time"),
                        "sendOtpBtn",
                        "otpSentTime"
                    );
                    window.location.reload();
                    response.remainingTime = 2 * 60;
                    
                } else {
                    $("#sendOtpBtn").removeAttr("disabled"); // Re-enable the button on error
                    toastr.error(response.msg); // Show error message
                }
            },
            error: function (xhr) {
                $("#sendOtpBtn").removeAttr("disabled"); // Re-enable the button on error
                if (xhr.status === 500) {
                    toastr.error(
                        "Internal Server Error. Please Try Again Later !!"
                    ); // Handle internal server errors
                } else {
                    const obj = JSON.parse(xhr.responseText); // Parse the error response
                    toastr.error(obj.msg); // Show the error message
                }
            },
        });
    });

    // $(document).on("submit", "#sendEmailOTP", function (event) {
    //     event.preventDefault();
    //     $.ajaxSetup({
    //         headers: {
    //             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    //         },
    //     });

    //     $("#sendEmailOtpBtn").html("Sending...");
    //     $("#sendEmailOtpBtn").attr("disabled", true);

    //     $.ajax({
    //         type: "POST",
    //         url: "send-email-otp",
    //         cache: false,
    //         processData: false,
    //         contentType: false,
    //         dataType: "JSON",
    //         success: function (response, status, xhr) {
    //             console.log(response);
    //             $("#sendEmailOtpBtn").html("Resend OTP");
    //             if (xhr.status === 200) {
    //                 toastr.success(response.msg);
    //                 const sentTime = Date.now();
    //                 localStorage.setItem("otpEmailSentTime", sentTime);

    //                 $("#sendEmailOtpBtn")
    //                     .css("display", "none")
    //                     .css("important", "true");
    //                 $("#timer").show();

    //                 startTimer(
    //                     10 * 60,
    //                     document.getElementById("time"),
    //                     "sendEmailOtpBtn",
    //                     "otpEmailSentTime"
    //                 ); // 10 minutes countdown
    //             } else {
    //                 $("#sendEmailOtpBtn").removeAttr("disabled");
    //                 toastr.error(response.msg);
    //             }
    //         },
    //         error: function (xhr, status, error) {
    //             console.log(xhr);
    //             $("#sendEmailOtpBtn").html("Resend OTP");
    //             $("#sendEmailOtpBtn").removeAttr("disabled");
    //             var obj = JSON.parse(xhr.responseText);
    //             if (xhr.status === 500) {
    //                 toastr.error(
    //                     "Internal Server Error. Please Try Again Later !!"
    //                 );
    //             } else {
    //                 toastr.error(obj.msg);
    //             }
    //         },
    //     });
    // });

    // Function to start the countdown timer
    
    function startTimer(duration, display, elem, item) {
        let timer = duration,
            minutes,
            seconds;
        const interval = setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = minutes + ":" + seconds;

            if (--timer < 0) {
                clearInterval(interval);
                document.getElementById("timer").style.display = "none";
                document.getElementById(elem).style.display = "block";
                $("#" + elem).removeAttr("disabled");
                localStorage.removeItem(item);
            }
        }, 1000);
    }

    // Function to initialize the timer on page load
    function initializeTimer() {
        const sentTime = localStorage.getItem("otpSentTime");
        if (sentTime) {
            const currentTime = Date.now();
            const elapsed = Math.floor((currentTime - sentTime) / 1000);
            const duration = 2 * 60;

            if (elapsed < duration) {
                // Calculate the remaining time
                const remainingTime = duration - elapsed;

                // Hide the button and show the timer
                document.getElementById("sendOtpBtn").style.display = "none";
                document.getElementById("timer").style.display = "block";

                // Start the countdown with the remaining time
                startTimer(
                    remainingTime,
                    document.getElementById("time"),
                    "sendOtpBtn",
                    "otpSentTime"
                );
            } else {
                // Clear the stored timestamp if the time has already passed
                localStorage.removeItem("otpSentTime");
            }
        }
    }

    // Initialize the timer when the page loads
    // window.onload = initializeTimer;

    // Function to initialize the timer on page load
    function initializeTimerEmail() {
        const sentTime = localStorage.getItem("otpEmailSentTime");
        if (sentTime) {
            const currentTime = Date.now();
            const elapsed = Math.floor((currentTime - sentTime) / 1000);
            const duration = 10 * 60;

            if (elapsed < duration) {
                // Calculate the remaining time
                const remainingTime = duration - elapsed;

                // Hide the button and show the timer
                document.getElementById("sendEmailOtpBtn").style.display =
                    "none";
                document.getElementById("timer").style.display = "block";

                // Start the countdown with the remaining time
                startTimer(
                    remainingTime,
                    document.getElementById("time"),
                    "sendEmailOtpBtn",
                    "otpEmailSentTime"
                );
            } else {
                // Clear the stored timestamp if the time has already passed
                localStorage.removeItem("otpEmailSentTime");
            }
        }
    }

    // Initialize the timer when the page loads
    // window.onload = initializeTimerEmail;

    window.onload = function () {
        const currentUrl = window.location.href;

        if (currentUrl.includes("email-verification")) {
            initializeTimerEmail();
        } else if (currentUrl.includes("otp-verification")) {
            initializeTimer();
        }
    };

    $("#googleSignUpButton").click(function (event) {
        event.preventDefault(); // Prevent the default action of the link

        var selectedValue = $("#userType").val();

        if (selectedValue && selectedValue !== "Select User Type") {
            // Perform the GET request (you can change the URL as needed)
            var url = "auth/google?user_type=" + selectedValue;
            window.location.href = url;
        } else {
            toastr.error("Please Select User Type");
        }
    });

    $("#facebookSignUpButton").click(function (event) {
        event.preventDefault(); // Prevent the default action of the link

        var selectedValue = $("#userType").val();

        if (selectedValue && selectedValue !== "Select User Type") {
            // Perform the GET request (you can change the URL as needed)
            var url = "auth/facebook?user_type=" + selectedValue;
            window.location.href = url;
        } else {
            toastr.error("Please Select User Type");
        }
    });

    $("#togglePassword").click(function () {
        var passwordField = $("#password");
        var passwordFieldType = passwordField.attr("type");
        var icon = $(this);

        if (passwordFieldType === "password") {
            passwordField.attr("type", "text");
            icon.removeClass("fa-eye-slash");
            icon.addClass("fa-eye");
        } else {
            passwordField.attr("type", "password");
            icon.removeClass("fa-eye");
            icon.addClass("fa-eye-slash");
        }
    });

    $("#toggleConfirmPassword").click(function () {
        var passwordField = $("#password_confirmation");
        var passwordFieldType = passwordField.attr("type");
        var icon = $(this);

        if (passwordFieldType === "password") {
            passwordField.attr("type", "text");
            icon.removeClass("fa-eye-slash");
            icon.addClass("fa-eye");
        } else {
            passwordField.attr("type", "password");
            icon.removeClass("fa-eye");
            icon.addClass("fa-eye-slash");
        }
    });
});
