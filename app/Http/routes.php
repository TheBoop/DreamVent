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
	
	/*
	* =====================
	* Welcome Page
	* =====================
	*/
	Route::get('/', 'WelcomeController@nonUserFrontPage'
		)->middleware('guest');

	Route::get('/frontpages', 'FrontPageController@userBaseFrontPage');
	Route::get('/YourPictures', 'FrontPageController@YourPictures');

	//Search stuff REALLLY DESPERATE FAST SEARCH.
	//It searches for description not tag for example 
	Route::get('/searchtest', 'WelcomeController@gettestSearch');
	Route::post('/searchtest', 'WelcomeController@posttestSearch');
	
	/*
	* =====================
	* Authentication
	* =====================
	*/
	Route::auth();
	
	Route::controllers([
	   'password' => 'Auth\PasswordController',
	]);
<<<<<<< HEAD
	// === End: Temporary Test Stuff ===
	
	// === Begin: Post Page ===
	//Route::get('/post/pic/{picture_id}','PostPage@ViewImage');
	//Route::get('/post/story/{story_id}','PostPage@ViewStory');
=======
	
	/*
	* =====================
	* User Page
	* =====================
	*/
	Route::get('profile/{username}', function($username){
		//echo $username;
		return view('profile.foreign_profile');
	});

	/*
	* =====================
	* Temporary Test Stuff
	* =====================
	*/
	Route::get('/currentUser', 'UserController@currentUser');
	//Route::get('/test/{picture_id}', 'test@test' );

>>>>>>> refs/remotes/origin/Matt_2
	

	/*
	* =====================
	* Post Page (i.e. displaying content)
	* =====================
	*/
	//Display
	Route::get('/post/picture/{picture_id}','PostPage@ViewImage');
	Route::get('/post/story/{story_id}','PostPage@ViewStory');
	
	//Comments
	Route::post('/post/picture/{picture_id}','PostPage@StoreImageComment');
	Route::post('/post/story/{story_id}','PostPage@StoreStoryComment');

	
	/*
	* =====================
	* Browsing
	* =====================
	*/
	//content: pictures, stories
	Route::get('/browse', 'Browse@defaultBrowse');
	//users
	Route::get('/browseUsers', 'Browse@defaultBrowseUser');


	
	/*
	* =====================
	* Uploading Pictures
	* =====================
	*/
	//Upload Form
	Route::get('/uploadPicture', 'PictureController@upload');
	
	//Store
	Route::post('/uploadPicture', 'PictureController@store');

	//View uploaded pictures
	Route::get('/viewPictures', 'PictureController@show');
	
	/*
	* =====================
	* Uploading Stories
	* =====================
	*/
	//Upload Form
	Route::get ('/uploadStory/', 'StoryController@uploadParent'); 				//upload story as standalone
	Route::get ('/uploadStory/{picture_id}', 'StoryController@uploadChild');	//upload story in response to picture prompt
	
	//Store
	Route::post('/uploadStory/', 'StoryController@storeParent');				//store parent
	Route::post('/uploadStory/{picture_id}', 'StoryController@storeChild');		//store child

	

});

