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
*/

Route::get('/', function () {
    return view('welcome');
});

//--------------------------------------------------------------------------

Route::get('/login', function () {
    return view('login');
});
 
Route::post('/loginme', 'loginController@login'); // (method in .php , Controller_name@function_name )

//--------------------------------------------------------------------------

Route::get('/funel', function () {
    return view('funel');
});

Route::post('/submit', 'funelController@submit');

//--------------------------------------------------------------------------

Route::get('/graph', 'graphController@getFile');


//--------------------------------------------------------------------------

Route::get('/display', 'funelController@show');

//--------------------------------------------------------------------------
