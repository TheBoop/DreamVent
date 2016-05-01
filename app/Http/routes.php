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
	
	//Testing: check current user
	Route::get('/currentUser', 'UserController@currentUser');
	
	//=== Begin: Uploading Pictures ===
	//Display: upload standalone picture
	Route::get('/uploadPicture', 'PictureController@upload');
	
	//Handles submission
	Route::post('/uploadPicture', 'PictureController@store');

	//View uploaded pictures
	Route::get('/viewPictures', 'PictureController@show');
	// === End: Uploading Pictures ===
	
	
	// === Begin: Uploading Stories ===
	//display: uploading standalone story.
	Route::get ('/uploadStory/', 'StoryController@uploadParent'); 				//upload story as standalone
	Route::get ('/uploadStory/{picture_id}', 'StoryController@uploadChild');	//upload story in response to picture prompt
	
	//Store
	Route::post('/uploadStory/', 'StoryController@storeParent');				//store parent
	Route::post('/uploadStory/{picture_id}', 'StoryController@storeChild');	
	
	
	
	//display:
	
	

});

