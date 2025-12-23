"use strict";

/* ===============================
   PASSWORD SHOW / HIDE
================================ */
$('.hide-pass').on('click', function () {
    var model = $('#auth').data('model');
    $(this).toggleClass("show-pass");

    // LOGIN
    if (model === 'Login') {
        let passwordInput = $(".password");
        passwordInput.attr(
            'type',
            passwordInput.attr('type') === "password" ? 'text' : 'password'
        );
    }
    // REGISTRATION & RESET PASSWORD
    else {
        let passwordInput = $(this).siblings('input');
        passwordInput.attr(
            'type',
            passwordInput.attr('type') === "password" ? 'text' : 'password'
        );
    }
});

/* ===============================
   FILL DEMO CREDENTIALS
================================ */
function fillup(email, password) {
    $(".email").val(email);
    $(".password").val(password);
}

/* ===============================
   LOGIN FORM SUBMIT (AJAX)
   🔥 THIS FIXES THE JSON ISSUE
================================ */
$(document).on('submit', 'form[action*="login"]', function (e) {
    e.preventDefault();

    let form = $(this);
    let submitBtn = form.find('.submit-btn');

    submitBtn.prop('disabled', true).text('Logging in...');

    $.ajax({
        type: "POST",
        url: form.attr('action'),
        data: form.serialize(),
        dataType: "json",
        success: function (res) {
            if (res.redirect) {
                window.location.href = res.redirect;
            } else {
                submitBtn.prop('disabled', false).text('Log In');
            }
        },
        error: function (xhr) {
            submitBtn.prop('disabled', false).text('Log In');

            if (xhr.responseJSON && xhr.responseJSON.message) {
                Notify('error', xhr.responseJSON.message);
            } else {
                Notify('error', 'Login failed. Please try again.');
            }
        }
    });
});

/* ===============================
   OTP COUNTDOWN
================================ */
let countdownInterval;

function startCountdown(timeLeft) {
    const countdownElement = $("#countdown");
    const resendButton = $("#otp-resend");

    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        return `${String(minutes).padStart(2, "0")}:${String(remainingSeconds).padStart(2, "0")}`;
    }

    if (countdownInterval) {
        clearInterval(countdownInterval);
    }

    countdownElement.text(formatTime(timeLeft));
    resendButton.addClass("disabled").attr("disabled", true);

    countdownInterval = setInterval(() => {
        timeLeft--;
        countdownElement.text(formatTime(timeLeft));

        if (timeLeft <= 0) {
            clearInterval(countdownInterval);
            countdownElement.text("00:00");
            resendButton.removeClass("disabled").removeAttr("disabled");
        }
    }, 1000);
}

/* ===============================
   RESEND OTP
================================ */
$('#otp-resend').on('click', function () {
    const resendButton = $(this);

    if (resendButton.hasClass("disabled")) {
        return;
    }

    const route = resendButton.data("route");
    const originalText = resendButton.text();
    const email = $("#dynamicEmail").text();

    if (!email) {
        Notify("error", "Email is missing. Please try again.");
        return;
    }

    resendButton.text("Sending...").addClass("disabled").attr("disabled", true);

    $.ajax({
        type: "POST",
        url: route,
        data: { email: email },
        dataType: "json",
        success: function (response) {
            resendButton.text(originalText).addClass("disabled").attr("disabled", true);
            startCountdown(response.otp_expiration);
        },
        error: function () {
            resendButton.text(originalText).removeClass("disabled").removeAttr("disabled");
            Notify("error", "Failed to resend OTP");
        },
    });
});