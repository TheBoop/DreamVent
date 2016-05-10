<?php
namespace App\Http\Controllers\pageType;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\AccountRepository;
use Illuminate\Support\Facades\Input;

//Eloquent Models
use App\Story; 
use App\Picture; 
use App\User as User;

class NonUserPageType extends Controller
{
    /**
     * The task repository instance.
     *
     * @var TaskRepository
     */
    protected $NonUserPagetype;
    public function __construct(AccountRepository $search)
    {
        $this->NonUserPagetype = $search;
    }

    public function FeaturedFrontPage()
    {
        $storyList = $this->NonUserPagetype->featuredList();
        $holdList = $this->NonUserPagetype->GetStoryDescNPic($storyList);
        return view('pagetype.index',
        [
            'pictureList' => $holdList[1],
            'storyList' => $holdList[0]
        ]);
    }

     public function FollowPage(Request $request)
    {
        //we have list of authors the user follow now
        $list_author_id = $this->UserPagePreference->followList();
        //get lateststory
        $list_story_id = $this->UserPagePreference->getStoryIDListByAuthorID($list_author_id);
        //with each story ID grab story description and Pic
        //get picture listGetStoryDescNPic
        $holdList = $this->UserPagePreference->GetStoryDescNPic($list_story_id);
        return view('pagetype.index', [
            'pictureList' => $holdList[1],
            'storyList' => $holdList[0]
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
        return view('search.testsearch', [
            'pictureList' => $this->NonUserPagetype->showTagResults($request->keyword),
        ]);
    }

    /*
     *  uses $keyword (from the view) input to search
     *  Search Function in App/Repositories/AccountRepository.php
     */
    public function posttestSearch(Request $request)
    {
        return view('search.testsearch', [
            'pictureList' => $this->NonUserPagetype->showTagResults($request->keyword),
        ]);
    }
    
}