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
	Route::get('/', 'pageType\NonUserPageType@FeaturedFrontPage');
	Route::get('/YourStories', 'pageType\UserPageType@YourStories');
	Route::get('/Follows', 'pageType\UserPageType@FollowPage');
	Route::get('/Favorites', 'pageType\UserPageType@FavoritePage');


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
	Route::get('/post/picture/{picture_id}','ViewStoryComm\NonUserPostController@ViewImage');
	Route::get('/post/story/{story_id}','ViewStoryComm\NonUserPostController@ViewStory');
	
	//Comments
	Route::post('/post/picture/{picture_id}','ViewStoryComm\UserPostController@StoreImageComment');
	Route::post('/post/story/{story_id}','ViewStoryComm\UserPostController@StoreStoryComment');

	
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
	/*
	* =====================
	* Make a Story+Picture Upload
	* =====================
	*/
	Route::get('/uploadStoryPic', 'UploadPicStory\StoryPicController@upload');
	Route::post('/uploadStoryPic', 'UploadPicStory\StoryPicController@Store');


	//TESTING AND DEMONSTRATION CAN BE REMOVED LATER ONCE VIEWS ARE GOOD.
	/*
	* =====================
	* Add/Remove People You Follow - Chris
	* =====================
	*/
	Route::get('testprofile/{username}', 'UserList\NonUserListController@testProfile');
	Route::post('followtest/{username}', 'UserList\UserListController@addFollower');
	Route::post('unfollowtest/{username}', 'UserList\UserListController@removeFollower');

	/*
	* =====================
	* Favorite/Unfavorite Stories  - Chris
	* =====================
	*/
	Route::post('favoriteStory/{story_id}', 'UserList\UserListController@Favorite');
	Route::post('unfavoriteStory/{story_id}', 'UserList\UserListController@Unfavorite');

	Route::post('likeStory/{story_id}', 'UserList\UserListController@Like');
	Route::post('unlikeStory/{story_id}', 'UserList\UserListController@Unlike');
	Route::post('likePicture/{picture_d}', 'UserList\UserListController@Like_pic');
	Route::post('unlikePicture/{picture_d}', 'UserList\UserListController@Unlike_pic');
});

