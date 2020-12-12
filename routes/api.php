<?php

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
    ],
], function () {
    require __DIR__ . '/api/v1.php';
});
