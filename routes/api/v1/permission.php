<?php

Route::group([

    'middleware' => [
        'role:'.config('access.users.admin_role')
    ],
], function (){

//    Route::get('permissions', );

});
