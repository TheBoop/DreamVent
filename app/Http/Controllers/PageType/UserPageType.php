<?php
namespace App\Http\Controllers\PageType;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\AccountFrontPage;
use App\Picture;
use App\Repositories\AccountRepository;

class UserPageType extends Controller
{
    /**
     * Instance for Front page for Logged-In User
     *
     * 
     */
    protected $UserPagePreference;

    public function __construct(AccountRepository $UserPagePreference)
    {
        $this->middleware('auth');
        $this->UserPagePreference = $UserPagePreference;
    }


    /**
     * Gets Pictures based on search algorithm in AccountRepository 
     * function UserFrontPage()
     * @param  request is user() info
     * @return View with set of pictures where user()->id
     */
    public function YourStories(Request $request)
    {
        $authorid[] = $request->user()->id;
        $list_story_id = $this->UserPagePreference->followListStoryID($authorid);
        $holdList = $this->UserPagePreference->GetStoryDescNPic($list_story_id, $request->user());
        return view('pagetype.index', [
            'pictureList' => $holdList[1],
            'storyList' => $holdList[0],
        ]);
    }

    public function YourPictures(Request $request)
    {
        $picture_id = $this->UserPagePreference->viewYourOwnPicture(Auth::user());
        return view('pagetype.index', [
            'pictureList' => $picture_id,
        ]);
    }

    public function FollowPage(Request $request)
    {
        //we have list of authors the user follow now
        $list_author_id = $this->UserPagePreference->followListAuthorID();
        //get lateststory
        $list_story_id = $this->UserPagePreference->followListStoryID($list_author_id);
        //with each story ID grab story description and Pic
        //get picture listGetStoryDescNPic
        $holdList = $this->UserPagePreference->GetStoryDescNPic($list_story_id, $request->user());
        return view('pagetype.index', [
            'pictureList' => $holdList[1],
            'storyList' => $holdList[0],
        ]);
    }

    public function FavoritePage(Request $request)
    {
        //get lateststory
        $list_story_id = $this->UserPagePreference->favoriteListStoryID($request->user()->id);
        //var_dump($list_story_id);
        //with each story ID grab story description and Pic
        //get picture listGetStoryDescNPic
        $holdList = $this->UserPagePreference->GetStoryDescNPic($list_story_id, $request->user());
        return view('pagetype.index', [
            'pictureList' => $holdList[1],
            'storyList' => $holdList[0],
        ]);
    }
}