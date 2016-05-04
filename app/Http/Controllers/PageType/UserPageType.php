<?php
namespace App\Http\Controllers\pageType;

use Illuminate\Http\Request;

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

    public function LandingPage()
    {
        return view('PageType.welcome');
    }
    /**
     * Gets Pictures based on search algorithm in AccountRepository 
     * function UserFrontPage()
     * @param  We can change paramater to fit our needs
     * @return View with set of pictures returned from UserFrontPage function
     */
    public function RecommendFrontPage(Request $request)
    {
        return view('PageType.index', [
            'pictureList' => $this->UserPagePreference->UserFrontPage($request->user()),
        ]);
    }

    /**
     * Gets Pictures based on search algorithm in AccountRepository 
     * function UserFrontPage()
     * @param  request is user() info
     * @return View with set of pictures where user()->id
     */
    public function YourPictures(Request $request)
    {
        return view('PageType.index', [
            'pictureList' => $this->UserPagePreference->viewYourOwnPicture($request->user()),
        ]);
    }
}