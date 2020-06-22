<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('public.index');
});

Route::group([
    'middleware' => [
        'guest'
    ]
], function (){

    Route::get('/login', [\App\Http\Controllers\Front\FrontController::class, 'login']);

    Route::get('/register', [\App\Http\Controllers\Front\FrontController::class, 'register']);

    // Socialite Routes
    Route::get('login/{provider}', [SocialLoginController::class, 'login'])->name('social.login');
    Route::get('login/{provider}/callback', [SocialLoginController::class, 'login']);

    // Confirm Account Routes
    Route::get('account/confirm/{token}', [ConfirmAccountController::class, 'confirm'])->name('account.confirm');
    Route::get('account/confirm/resend/{uuid}', [ConfirmAccountController::class, 'sendConfirmationEmail'])->name('account.confirm.resend');

    // Password Reset Routes
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.email');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email.post');

    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset');

});

