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
	Route::get('/', 'PageType\NonUserPageType@FeaturedFrontPage');
	Route::get('/YourStories', 'PageType\UserPageType@YourStories');
	Route::get('/Follows', 'PageType\UserPageType@FollowPage');
	Route::get('/Favorites', 'PageType\UserPageType@FavoritePage');
	Route::get('/YourPictures', 'PageType\UserPageType@YourPictures');



	/*
	* =====================
	* Authentication - Laravel / Chris
	* =====================
	*/
	
	Route::controllers([
	   'password' => 'Auth\PasswordController',
	]);

	
	/*
	* =====================
	* User Page 
	* =====================
	*/
	Route::get('myprofile/', 'UserList\UserListController@myProfile');
	Route::get('profile/{username}', 'UserList\NonUserListController@userProfile');
	
	/*
	* =====================
	* Browsing - Matt
	* =====================
	*/
	//content: pictures, stories
	Route::get('/browse', 'Browse\BrowseController@defaultBrowse');
	//users
	Route::get('/browseUsers', 'Browse\BrowseController@defaultBrowseUser');
	
	//Browse, the actual one - in progress
	Route::get('/Browse', 'Browse\BrowseController@BrowseContent');
	

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

	/*
	* =====================
	* Search
	* =====================
	*/	
	//Search Stories - Matt
	Route::get('/search', 'Search\SearchController@getSearch');
	Route::post('/search', 'Search\SearchController@postSearch');
	
	//Search Users - Matt
	Route::get('/searchUser', 'Search\SearchUserController@getSearch');
	Route::post('/searchUser', 'Search\SearchUserController@postSearch');
	
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
	Route::post('follow/{username}', 'UserList\UserListController@addFollower');
	Route::post('unfollow/{username}', 'UserList\UserListController@removeFollower');
	Route::get('followlist/', 'UserList\UserListController@view_follower');
	Route::post('block/{username}', 'UserList\UserListController@addBlock');
	Route::post('unblock/{username}', 'UserList\UserListController@removeBlock');
	Route::get('blocklist/', 'UserList\UserListController@view_block');


	/*
	* =====================
	* Favorite/Unfavorite Stories  - Chris
	* =====================
	*/
	Route::post('favoriteStory/{story_id}', 'ViewStoryComm\UserPostController@Favorite');
	Route::delete('unfavoriteStory/{story_id}', 'ViewStoryComm\UserPostController@Unfavorite');

	Route::post('likeStory/{story_id}', 'ViewStoryComm\UserPostController@Like');
	Route::delete('unlikeStory/{story_id}', 'ViewStoryComm\UserPostController@Unlike');
	//need a form or method to this route
	Route::delete('deleteStory/{story_id}', 'ViewStoryComm\UserPostController@DeleteStory');
	Route::get('/editTag/{story_id}', 'ViewStoryComm\UserPostController@GetTags');
	Route::post('/editTag/{story_id}', 'ViewStoryComm\UserPostController@StoreNewTags');

	Route::get('/editStoryContent/{story_id}', 'ViewStoryComm\UserPostController@GetStoryContent');
	Route::post('/editStoryContent/{story_id}', 'ViewStoryComm\UserPostController@StoreNewStoryContent');

	Route::post('deleteStoryComment/{comment_id}', 'ViewStoryComm\UserPostController@DeleteComment');

	//
	Route::post('likePicture/{picture_id}', 'UserList\UserListController@Like_pic');
	Route::delete('unlikePicture/{picture_id}', 'UserList\UserListController@Unlike_pic');
	Route::post('favoritePicture/{picture_id}', 'UserList\UserListController@Favorite_pic');
	Route::delete('unfavoritePicture/{picture_id}', 'UserList\UserListController@Unfavorite_pic');
	
});

Route::auth();
