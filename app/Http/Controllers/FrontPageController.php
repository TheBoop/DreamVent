<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\AccountFrontPage;
use App\Picture;
use App\Repositories\AccountRepository;

class FrontPageController extends Controller
{
    /**
     * Instance for Front page for Logged-In User
     *
     * 
     */
    protected $frontpages;

    public function __construct(AccountRepository $frontpages)
    {
        $this->middleware('auth');
        $this->frontpages = $frontpages;
    }

    /**
     * Gets Pictures based on search algorithm in AccountRepository 
     * function UserFrontPage()
     * @param  We can change paramater to fit our needs
     * @return View with set of pictures returned from UserFrontPage function
     */
    public function userBaseFrontPage(Request $request)
    {
        return view('frontpages.index', [
            'frontpages' => $this->frontpages->UserFrontPage($request->user()),
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
        return view('frontpages.index', [
            'frontpages' => $this->frontpages->viewYourOwnPicture($request->user()),
        ]);
    }
}