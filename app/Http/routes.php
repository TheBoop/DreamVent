<?php

use Illuminate\Http\Request;

Route::group(['middleware' => ['web']], function () {

	Route::get('/', function () {
	    return view('welcome');
	})->middleware('guest');

	Route::auth();
	Route::get('/account', 'AccountController@index');
	
});

