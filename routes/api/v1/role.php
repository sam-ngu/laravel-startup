<?php

use App\Http\Controllers\Api\V1\Role\RoleController;

Route::group([
    'middleware' => [
        'role:'.config('access.users.admin_role')
    ],
], function (){
    /*
     * All route names are prefixed with api.v1.role
     * */

    Route::get('/roles', [RoleController::class, 'index']);
    Route::get('/roles/{role}', [RoleController::class, 'show']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::patch('/roles/{role}', [RoleController::class, 'update']);
    Route::delete('/roles/{role}', [RoleController::class, 'destroy']);
});
