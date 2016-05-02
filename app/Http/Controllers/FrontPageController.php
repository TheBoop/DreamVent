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
     * The task repository instance.
     *
     * @var TaskRepository
     */
    protected $frontpages;

    public function __construct(AccountRepository $frontpages)
    {
        $this->middleware('auth');
        $this->frontpages = $frontpages;
    }

    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function userBaseFrontPage(Request $request)
    {
        return view('frontpages.index', [
            'frontpages' => $this->frontpages->UserFrontPage($request->user()),
        ]);
    }
    public function YourPictures(Request $request)
    {
        return view('frontpages.index', [
            'frontpages' => $this->frontpages->viewYourOwnPicture($request->user()),
        ]);
    }
}