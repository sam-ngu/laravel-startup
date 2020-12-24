<?php

use App\Http\Controllers\Api\V1\User\UserController;
use App\Http\Controllers\Api\V1\User\UserPasswordController;
use App\Http\Controllers\Api\V1\User\UserTwoFactorAuthController;
use App\Http\Controllers\Auth\LoginController;

Route::group([
    'middleware' => [
        'role:'.config('access.users.admin_role'),
    ],
], function () {

    // all routes prefixed with api.v1
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'store']);
    Route::patch('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);

    Route::post('/users/{user}/two-factor', [UserTwoFactorAuthController::class, 'update2FA']);

    // for admin to login as user
    Route::post('/users/{user}/login-as', [LoginController::class, 'loginAs']);
});

//For when admin is logged in as user from backend
Route::get('/user-logout-as', [LoginController::class, 'logoutAs'])->name('logout-as');

// non admin routes
Route::patch('/users/{user}/profile/picture', [UserController::class, 'updateProfilePicture']);
Route::patch('/users/{user}/profile/password', [UserPasswordController::class, 'updatePassword']);
