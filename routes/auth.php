<?php

use App\Http\Controllers\AgreementController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\FacebookController;
use App\Http\Controllers\Auth\OtpVerificationController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store'])->name('register.store');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');

    Route::get('auth/google', [GoogleController::class, 'index']);
    Route::get('auth/google_login', [GoogleController::class, 'google_login']);
    Route::get('auth/google/callback', [GoogleController::class, 'google_register']);

    Route::get('auth/facebook', [FacebookController::class, 'index']);
    Route::get('auth/facebook_login', [FacebookController::class, 'facebook_login']);
    Route::get('auth/facebook/callback', [FacebookController::class, 'facebook_register']);
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');

    Route::controller(OtpVerificationController::class)->group(function() {
        Route::get('otp-verification/{type?}','view')->name('otp.verification');
        // Route::get('sms-otp-verification','viewSms')->name('sms-otp.verification');
        Route::post('check-otp', 'check')->name('check.otp');
        Route::post('send-otp', 'sendOtp')->name('send.otp');
        Route::post('edit-mobile', 'edit_mobile')->name('edit.mobile');
        Route::get('too-many-otp-attempts', 'tooManyOTPAttempts')->name('otp.attempts');

        //Email Verification
        // Route::get('email-verification','view_email')->name('email.verification');
        // Route::post('send-email-otp', 'send_email')->name('send.emailotp');
        // Route::post('check-email-otp', 'check_email')->name('check.emailotp');
    });

    Route::get('/agreement', [AgreementController::class, 'show'])->name('agreement.show');
    Route::post('/agreement/accept', [AgreementController::class, 'accept'])->name('agreement.accept');
});
