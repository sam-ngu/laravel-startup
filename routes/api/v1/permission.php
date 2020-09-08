<?php

use App\Http\Controllers\Api\V1\Permission\PermissionController;

Route::group([

    'middleware' => [
        'role:'.config('access.users.admin_role'),
    ],
], function () {

    Route::get('permissions', [PermissionController::class, 'index']);

});
