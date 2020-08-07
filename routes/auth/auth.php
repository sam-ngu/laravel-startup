<?php

use App\Http\Controllers\Api\V1\Auth\SocialLoginController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;

Route::group([
    'middleware' => [
        'guest'
    ]
], function (){

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
    Route::post('password/confirm', [ConfirmPasswordController::class, 'confirm']);

    // Socialite Routes
    Route::get('login/{provider}', [SocialLoginController::class, 'login'])->name('social.login');
    Route::get('login/{provider}/callback', [SocialLoginController::class, 'login']);


    if(config('access.users.confirm_email')){
        // verification routes
        Route::get('email/verify', [VerificationController::class, 'show']);
        Route::post('email/resend', [VerificationController::class, 'resend']);
        Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify']);
    }else{
        // TODO: admin to approve user account
        // Confirm Account Routes
//        Route::get('account/confirm/{token}', [AuthController::class, 'confirm'])->name('account.confirm');
//        Route::get('account/confirm/resend/{uuid}', [ConfirmAccountController::class, 'sendConfirmationEmail'])->name('account.confirm.resend');
    }



    // Password Reset Routes
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);



});

/*
    * These routes require the user to be logged in
    */
Route::group(['middleware' => 'auth'], function () {
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    //For when admin is logged in as user from backend
    Route::get('logout-as', [LoginController::class, 'logoutAs'])->name('logout-as');

    // These routes can not be hit if the password is expired
    Route::group(['middleware' => 'password_expires'], function () {
        // Change Password Routes
//        Route::patch('password/update', [UpdatePasswordController::class, 'update'])->name('password.update');
    });
    // Password expired routes
//    Route::get('password/expired', [PasswordExpiredController::class, 'expired'])->name('password.expired');
//    Route::patch('password/expired', [PasswordExpiredController::class, 'update'])->name('password.expired.update');
});