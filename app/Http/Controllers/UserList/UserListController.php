<?php

namespace App\Http\Controllers\UserList;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //for Auth::user()

use App\Http\Requests;
use App\Http\Controllers\Controller;


//Eloquent Model
use App\Picture; 
use App\Story;
use App\GrabPics;
use App\PictureComment;
use App\StoryComment;
use App\Favorites;
use App\UserListContains;
use App\Repositories\AccountRepository;

class UserListController extends Controller
{
	protected $UserList;

	public function __construct(AccountRepository $UserList)
    {
        $this->middleware('auth');
        $this->UserList = $UserList;
    }


    public function addFollower($username, Request $request)
    {
        $follow = new UserListContains();
        $this->UserList->StoreFollowByUsername($username, $follow, $request);
    	//return redirect()->action('UserList\NonUserListController@testProfile', [$username]);

    }
    public function removeFollower($username)
    {   
        $this->UserList->RemoveFollowByUsername($username);
        //return redirect()->action('UserList\NonUserListController@testProfile', [$username]);
    }

    public function Favorite($story_id, Request $request)
    {
        $favorite = new Favorites();
        $this->UserList->StoreFavoriteBySID($story_id, $favorite, $request);
        //return redirect()->action('UserList\NonUserListController@testProfile', [$story_id]);

    }
    public function Unfavorite($story_id)
    {   
        $this->UserList->RemoveFavoriteBySID($story_id);
        //return redirect()->action('UserList\NonUserListController@testProfile', [$story_id]);
    }

}