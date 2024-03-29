<?php

namespace App\Http\Controllers\UserList;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //for Auth::user()

use App\Http\Requests;
use App\Http\Controllers\Controller;


//Eloquent Model
use App\Picture; 
use App\Story;
use App\Likes;
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

    public function addBlock($username, Request $request)
    {
        $block = new UserListContains();
        $this->UserList->StoreBlockByUsername($username, $block, $request);
        //return redirect()->action('UserList\NonUserListController@testProfile', [$username]);

    }
    public function removeBlock($username)
    {   
        $this->UserList->RemoveBlockByUsername($username);
        //return redirect()->action('UserList\NonUserListController@testProfile', [$username]);
    }

    public function Like_pic($picture_id, Request $request)
    {
        $like = new Likes();
        $this->UserList->StoreLikeByPID($picture_id, $like, $request);
        //return redirect()->action('UserList\NonUserListController@testProfile', [$story_id]);

    }
    public function Unlike_pic($picture_id)
    {   
        $this->UserList->RemoveLikeByPID($picture_id);
        //return redirect()->action('UserList\NonUserListController@testProfile', [$story_id]);
    }

    public function Favorite_pic($picture_id, Request $request)
    {
        $like = new Favorites();
        $this->UserList->StoreFavoriteByPID($picture_id, $like, $request);
        //return redirect()->action('UserList\NonUserListController@testProfile', [$story_id]);

    }
    public function Unfavorite_pic($picture_id)
    {   
        $this->UserList->RemoveFavoriteByPID($picture_id);
        //return redirect()->action('UserList\NonUserListController@testProfile', [$story_id]);
    }

    public function myProfile()
    {
        return view('profile.personal_profile');
    }

    public function view_follower()
    {   
        return view('search.searchUserResults', 
        [
            'users'=> $this->UserList->GetFollowList(),
        ]);
    }

    public function view_block()
    {   
        return view('search.searchUserResults', 
        [
            'users'=> $this->UserList->GetBlockList(),
        ]);
    }

}