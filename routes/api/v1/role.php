<?php

Route::group([
    'namespace' => 'Role',
    'middleware' => [
        'role:'.config('access.users.admin_role')
    ],
], function (){
    /*
     * All route names are prefixed with api.v1.role
     * */
    Route::apiResource('roles', 'RoleController');
});
