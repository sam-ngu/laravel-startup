<?php

Route::group([
    'namespace' => 'Permission',
    'middleware' => [
        'role:'.config('access.users.admin_role')
    ],
], function (){

    Route::get('permissions', "PermissionController@index");

});
