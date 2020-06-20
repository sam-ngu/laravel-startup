<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'namespace' => 'Api',
    'as' => 'api.',
    'middleware' => [
        'auth:api',
        \App\Http\Middleware\ParseFormData::class,
    ]
], function(){
    include_route_files(__DIR__ . '/api/');

});


