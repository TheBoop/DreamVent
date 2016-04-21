<?php

use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});



//Route::post('/task', 'DreamventsController@store');
//Route::delete('/task/{task}', 'DreamventsController@destroy');

Route::auth();

//Route::get('/home', 'HomeController@index');
