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

    public function userProfile($username)
    {   
        if (Auth::guest() == false)
            if ($username == Auth::user()->username){
                return redirect('myprofile/');
            }
        $authorid[] = $this->UserList->getUserIDByUsername($username)->id;
        $list_story_id = $this->UserList->followListStoryID($authorid);
        $holdList = $this->UserList->GetStoryDescNPic($list_story_id, $request->user()); 
        return view('profile.foreign_profile', 
            [
              'User' => $this->UserList->getUserIDByUsername($username),
              'IsFollowed' => $this->UserList->isFollowedByUsername($username),
              'IsBlocked' =>$this->UserList->isBlockedByUsername($username),
              'pictureList' => $holdList[1],
              'storyList' => $holdList[0],
            ]);
    }
}