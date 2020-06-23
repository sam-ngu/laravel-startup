<?php


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

include_route_files(__DIR__ . '/auth');

//\Illuminate\Support\Facades\Auth::routes();


//Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');


if(\Illuminate\Support\Facades\App::environment('local')){
    Route::get('/playground', function (){

    });
}
