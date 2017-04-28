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
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('welcome');
});

//--------------------------------------------------------------------------

Route::get('/mail', function () {
    return view('email');
});


Route::get('/funel', function () {
    return view('funel');
});

// Route::get('/submit_funel', function () {
//     return view('submit_funel');
// });

Route::post('/submit_funel', 'FunelController@submit');
Route::post('/submit_graph', 'graphController@getFile');

Route::get('/graph', 'graphController@getFile');

Route::get('/display', 'FunelController@show');

Route::post('/send', 'EmailController@send');


