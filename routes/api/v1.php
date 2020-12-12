<?php
///**
// * Created by PhpStorm.
// * User: sam
// * Date: 2/03/19
// * Time: 6:24 PM
// */
use App\Http\Controllers\Api\V1\User\UserController;
use App\Http\Controllers\Api\V1\User\UserStatusController;

Route::group([
    'namespace' => 'V1',
    'prefix' => 'v1',
    'as' => 'v1.',

], function () {
    /**
     * All route names are prefixed with 'api.v1.'.
     */

    include_route_files(__DIR__ . '/v1/');

//
//
//    /*User routes*/
//    Route::group([
//        'namespace' => 'User',
//        'middleware' => [
//            'role:'.config('access.users.admin_role')
//        ]
//    ], function(){
//        /*
//         * All route names are prefixed with api.v1.user
//         * */
//
//        /*User routes*/
//        Route::apiResource('users', 'UserController');
//
//        // TODO: make this work
////        Route::get('login-as', [\App\Http\Controllers\Backend\Auth\User\UserAccessController::class, 'loginAs'])->name('user.login-as');
//
//
//        Route::group([
//            'prefix' => 'users/{user}'
//        ], function (){
//            // Status
//            Route::get('mark/{status}', [UserStatusController::class, 'mark'])->where(['status' => '[0,1]']);
//
//            // Deleted
//            Route::get('delete', [UserStatusController::class, 'delete']);
//            Route::get('restore', [UserStatusController::class, 'restore']);
//        });
//
//    });
//
//
//
});
