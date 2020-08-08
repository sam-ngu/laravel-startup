<?php


use App\Http\Controllers\App\AppController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('public.index');
});

Route::group([
    'middleware' => [
        \App\Http\Middleware\Authenticate::class,
    ]
], function (){
    Route::get('/app', [AppController::class, 'dashboard']);

});

Route::group([
    'middleware' => [
        \App\Http\Middleware\Authenticate::class,
        // admin only
    ]
], function (){
    Route::get('/admin', [AppController::class, 'dashboard']);

});




include_route_files(__DIR__ . '/auth');

//\Illuminate\Support\Facades\Auth::routes();


//Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');


if(\Illuminate\Support\Facades\App::environment('local')){
    Route::get('/playground', function (){
        $user = User::query()->find(1);

        $user->sendPasswordResetNotification('123');
    })->middleware(['password.confirm']);
}
