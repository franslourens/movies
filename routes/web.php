<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|

frans@rsaweb.net
Dk50F7ikXHsa

*/

Route::get('/', function () {
    return Redirect::to( '/home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('movies', 'MovieController');

Route::get('/watch', 'WatchController@index');
Route::post('/watch', 'WatchController@store');
Route::delete('/watch/{watch}', 'WatchController@destroy');
