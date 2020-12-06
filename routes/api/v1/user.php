<?php

use App\Http\Controllers\Api\V1\User\UserController;

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


    // for admin to login as user
//    Route::post('/users/{user}/login-as', [\App\Http\Controllers\Auth\LoginController::class, 'loginAs']);
});
