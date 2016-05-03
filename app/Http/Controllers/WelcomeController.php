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


    public function nonUserFrontPage()
    {
        return view('welcome', [
            'frontpages' => $this->frontpages->forNonUser(),
        ]);
    }

    /*
     *  get keyword from view
     *  the frontpages => line doesnt make sense to me but it kept getting
     *  variable frontpages not found if I did not leave it there
     *  to get rid of line the view page must be changed to handle post/get
     *  frontpages => ~~ does not affect functionality in this function
     */
    public function gettestSearch(Request $request)
    {
        return view('testsearch', [
            'frontpages' => $this->frontpages->showTagResults($request->keyword),
        ]);
    }

    /*
     *  uses $keyword (from the view) input to search
     *  Search Function in App/Repositories/AccountRepository.php
     */
    public function posttestSearch(Request $request)
    {
        return view('testsearch', [
            'frontpages' => $this->frontpages->showTagResults($request->keyword),
        ]);
    }
    
}