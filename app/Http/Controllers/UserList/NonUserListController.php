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
use App\Repositories\AccountRepository;

class NonUserListController extends Controller
{
	protected $UserList;

	public function __construct(AccountRepository $UserList)
    {
        $this->UserList = $UserList;
    }

    public function testProfile($username)
    {
        return view('profile.test_profile', 
            [
              'User' => $this->UserList->getUserIDByUsername($username),
              'IsFollowed' => $this->UserList->isFollowedByUsername($username)
            ]);
    }

}