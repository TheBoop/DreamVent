<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\AccountFrontPage;
use App\Picture;
use App\Repositories\AccountRepository;
use Illuminate\Support\Facades\Input;

class WelcomeController extends Controller
{
    /**
     * The task repository instance.
     *
     * @var TaskRepository
     */
    protected $frontpages;
    public function __construct(AccountRepository $frontpages)
    {
        $this->frontpages = $frontpages;
    }


    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function nonUserFrontPage()
    {
        return view('welcome', [
            'frontpages' => $this->frontpages->forNonUser(),
        ]);
    }

    public function gettestSearch(Request $request)
    {
        //get keyword
        //the frontpages => line doesnt make sense to me but it kept getting
        //variable frontpages not found if i left it there
        //to fix line the view page must be fixed to handle post/get
        //too tired to do that right now
        return view('testsearch', [
            'frontpages' => $this->frontpages->showTagResults($request->keyword),
        ]);
    }
    public function posttestSearch(Request $request)
    {
        //uses keyword input to search
        //Function in App/Repositories/AccountRepository.php
        return view('testsearch', [
            'frontpages' => $this->frontpages->showTagResults($request->keyword),
        ]);
    }
    
}