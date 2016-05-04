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
//need to read up on middleware.
Route::group(['middleware' => ['web']], function () {
	
	/*
	* =====================
	* Page Types - Chris
	* =====================
	*/
	Route::get('/', 'pageType\NonUserPageType@LandingPage');
	Route::get('/Featured', 'pageType\NonUserPageType@FeaturedFrontPage');
	Route::get('/Recommended', 'pageType\UserPageType@RecommendFrontPage');
	Route::get('/YourPictures', 'pageType\UserPageType@YourPictures');

	
	/*
	* =====================
	* Authentication - Laravel / Chris
	* =====================
	*/
	Route::auth();
	
	Route::controllers([
	   'password' => 'Auth\PasswordController',
	]);

	
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
	* Browsing - Matt
	* =====================
	*/
	//content: pictures, stories
	Route::get('/browse', 'Browse\BrowseController@defaultBrowse');
	//users
	Route::get('/browseUsers', 'Browse\BrowseController@defaultBrowseUser');
	

	/*
	* =====================
	* Post Page (i.e. displaying content)
	* =====================
	*/
	//Display
	Route::get('/post/picture/{picture_id}','ViewStoryComm\PostPageController@ViewImage');
	Route::get('/post/story/{story_id}','ViewStoryComm\PostPageController@ViewStory');
	
	//Comments
	Route::post('/post/picture/{picture_id}','ViewStoryComm\PostPageController@StoreImageComment');
	Route::post('/post/story/{story_id}','ViewStoryComm\PostPageController@StoreStoryComment');

	
	/*
	* =====================
	* Uploading Pictures - Matt
	* =====================
	*/
	//Upload Form
	Route::get('/uploadPicture', 'UploadPic\PictureController@upload');
	Route::post('/uploadPicture', 'UploadPic\PictureController@store');
	
	/*
	* =====================
	* Uploading Stories - Matt
	* =====================
	*/
	Route::get ('/uploadStory/', 'UploadStory\StoryController@uploadParent'); 				//upload story as standalone
	Route::get ('/uploadStory/{picture_id}', 'UploadStory\StoryController@uploadChild');	//upload story in response to picture prompt
	
	//Store
	Route::post('/uploadStory/', 'UploadStory\StoryController@storeParent');				//store parent
	Route::post('/uploadStory/{picture_id}', 'UploadStory\StoryController@storeChild');


	//Search stuff REALLLY DESPERATE FAST SEARCH.
	//It searches for description not tag for example 
	Route::get('/searchtest', 'PageType\NonUserPageType@gettestSearch');
	Route::post('/searchtest', 'PageType\NonUserPageType@posttestSearch');	//store child
});

