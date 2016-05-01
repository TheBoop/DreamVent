<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Tutorials and Examples
|--------------------------------------------------------------------------
Create
Route::post()

Read: whenever we submite our data to the form
Route::get()
	Variables
	Route::get('hello/{name}', function($name){
		echo 'Hello there ' . $name;
	});

	Send an item to put route
	Route::get('test',function(){
		echo '<form action="test" method="POST">';
		echo '<input type="submit" value="submit">';
		echo '<input type="submit" value="submit">';
	});
Update
Route::put()

Delete
Route::delete()
*/


//need to read up on middleware.
Route::group(['middleware' => ['web']], function () {
	
	//welcome page
	Route::get('/', function () {
	    return view('welcome');
	})->middleware('guest');

	Route::get('/frontpages', 'FrontPageController@index');
	
	//authentication
	Route::auth();
	
	Route::controllers([
	   'password' => 'Auth\PasswordController',
	]);
	
	//Check current user
	//Route::get('/currentUser', 'UserController@currentUser');
	//Route::resource('profile', 'ProfilesController', ['only' => ['show', 'edit', 'update']]);
	Route::get('/profile/{username}', 'ProfileController@show');

	//=== Uploading Pictures ===
	//display form
	Route::get('/uploadPicture', 'PictureController@upload');
	
	//Handles submission
	Route::post('/uploadPicture', 'PictureController@store');

	//View uploaded pictures
	Route::get('/viewPictures', 'PictureController@show');

});

