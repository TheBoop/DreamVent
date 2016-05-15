<?php
namespace App\Repositories;

use App\User;
use App\Picture; 
use App\Story;
use App\GrabPics;
use App\PictureComment;
use App\StoryComment;
use App\Http\Requests;
use App\UserListContains;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class AccountRepository
{
    /*
     * @param  User  $user
     * @return Set of Columns.Picture in which the user owns (4)
     */
    public function viewYourOwnPicture(User $user)
    {
       return Picture::where('author_id', $user->id)
                    ->paginate(4);
    }

    /*
     * ===================================================================
     * =================            SearchAlgo        ====================
     * ===================================================================
     */

    /*
     * THIS currently gets keyword and searches TABLE PICTURE for keyword in description
     * Need to modify to search for multitags and such.
     */
    public function showTagResults($keyword)
    {
        $keyword = Input::get('keyword');
        /*
        $pic_des = Picture::where('description', 'LIKE', '%'.$keyword.'%')->get();
        foreach($pic_des as $pic_des){
            var_dump($pic_des->picture_id);
        }
        */
        return Picture::where('description', $keyword)
                    ->paginate(4);
    }

    /*
     *  Get a list of the user's followers
     *  Returns list of author_ids
     */
    public function followListAuthorID()
    {
        //get authenticated user's id 
        $author_id = array();
        $followlist_id = USER::find(Auth::user()->id)->followlist_id;
        //get collection of user_ids the user follows
        $collection = UserListContains::where('list_id', $followlist_id)->get(); 
        //since we use get collect all data
        foreach($collection as $collection)
        {
            $author_id[] = $collection->user_id;
        }
        //use data to give picture list
        return $author_id;
    }

    /*
     *  Get a list of StoryIDs associated by Author_id
     *  Returns list of story IDS Sorted by latest
     */
    public function followListStoryID($author_id)
    { 
        $story_id = array();
        $collection = Story::whereIn('author_id', $author_id)->latest()->get();
        foreach($collection as $collection)
        {
            $story_id[] = $collection->story_id;
        }
        return $story_id;
    }

    /*
     * @param   
     * @return an ordered list of story_id
     */
    public function featuredList()
    {
        //search algorithm
        $collection = Story::orderBy('num_likes', 'DESC')->get();

        //get all story IDS we might have to limit for past 2 days or whatever
        $story_id = array();
        foreach($collection as $collection)
        {
            $story_id[] = $collection->story_id;
        }
        return $story_id; 
    }
	
	/*  ===========================================
	*	======== More Search Stuff by Matt ========
	*   ===========================================
	*/
	//remove stop words
	public function isStopWord ($word) {
		$wordList = array(
			"I", 
			"a", 
			"about", 
			"an", 
			"are", 
			"as", 
			"at", 
			"be", 
			"by", 
			"com", 
			"for", 
			"from",
			"how",
			"in", 
			"is", 
			"it", 
			"of", 
			"on", 
			"or", 
			"that",
			"the", 
			"this",
			"to", 
			"was", 
			"what", 
			"when",
			"where",
			"who", 
			"will", 
			"with",
			"the",
			"www",
			);
			
			if (in_array($word, $wordList)) return true;
			else return false;
	}
	
	public function containsTitleRequest($searchRequest) {
		$pos = strpos($searchRequest, 'title:');
		if ($pos === 0 || $pos) {
			return true;
		}
		else 
			return false;
	}
	
	public function validateTitleRequest($searchRequest) {
		$pos = strpos($searchRequest, 'title:');
		$openQuotePos = $pos + strlen("title:");
		$closeQuotePos = strpos($searchRequest, '"', $openQuotePos+1 );
		
		if ($closeQuotePos) {
			return true;
		}
		else return false;
	}
	
	public function getFirstTitleOccurence(&$searchRequest) {		
		$pos = strpos($searchRequest, 'title:');
		$openQuotePos = $pos + strlen("title:");
		$closeQuotePos = strpos($searchRequest, '"', $openQuotePos+1 );
		//echo "open:$openQuotePos:$searchRequest[$openQuotePos] <br />"; 
		//echo "close:$closeQuotePos:$searchRequest[$closeQuotePos] <br />";
		$title = substr($searchRequest,$openQuotePos + 1, $closeQuotePos - $openQuotePos - 1);
		//echo "title:$title <br />";

		//echo "<br /> end title occurence function: ". substr($searchRequest, $pos, $closeQuotePos - $pos + 1) . " <br />";
		
		//remove title from search request
		$searchRequest = str_replace(substr($searchRequest, $pos, $closeQuotePos - $pos + 1), "", $searchRequest);
		
		return $title;
	}





    /*
     * ===================================================================
     * =================    Parameter $picture_id   ======================
     * ===================================================================
     */

    /*
     *  Get Picture based on PID
     *  Returns all columns in Table:Picture
     */
    public function getPictureBasedonPID($picture_id)
    {
       return Picture::find($picture_id);
    }

    /*
     * Get StoryIDs based on PID
     * Returns all columns in Table:GrabPics
     */
    public function getStoryIDsBasedonPID($picture_id)
    {
       return GrabPics::where('picture_id', $picture_id)->get();
    }

    /*
     * Get Comments associated with PID
     * Returns all columns in Table:PictureComment
     */
    public function getPicCommentBasedonPID($picture_id)
    {
       return PictureComment::where('picture_id', $picture_id)->get();
    }

    /*
     * Story Comments associated with PID
     */
    public function StorePicCommentMethod(Request $request, $picture_id, $comment)
    {
        $comment->text = $request->comment;
        $comment->picture_id = $picture_id;
        $comment->author_id = Auth::user()->id;

        $comment->save();
    }

    /*
     * ===================================================================
     * =================      story_id              ======================
     * ===================================================================
     */

    /*
     *  Get Story based on SID
     *  Returns all columns in Table:Story
     */
    public function getStoryBasedonSID($story_id)
    {
       return Story::find($story_id);
    }

    /*
     *  Get Story based on SID
     *  Returns all columns in Table:Story
     */
    public function getUsernameBasedonSID($story_id)
    {
       return User::where('id', $story_id->author_id);
    }

    /*
     *  Get Story based on SID
     *  Returns all columns in Table:Story
     */
    public function getPicBasedOnSID($story_id)
    {
       $piclist = GrabPics::where('story_id', $story_id)->first();
       return Picture::find($piclist->picture_id);
    }

    /*
     * Get Comments associated with SID
     * Returns all columns in Table:StoryComment
     */
    public function getStoryCommentBasedonSID($story_id)
    {
       return StoryComment::where('story_id', $story_id)->get();
    }

    /*
     * Story Comments associated with SID
     */
    public function StoreStoryCommentMethod(Request $request, $story_id, $comment)
    {
        $comment->text = $request->comment;
        $comment->story_id = $story_id;
        $comment->author_id = Auth::user()->id;

        $comment->save();
    }

    /*
     *  Get a Story Description and associated Picture using story_id
     *  return two objects [Story Object, Picture Object]
     *  Order is made by previous functions (Ordering of story_id)
     */
    public function GetStoryDescNPic($story_id)
    {
        $piclist = array();

        foreach ($story_id as $index => $value) {
            //confusing for someone new to relations but I used relations for find look at models
            $piclist[$index] = Picture::find(
                                Story::find($story_id[$index])->pic_id->picture_id)->picture_id;
        }
        $storyids_ordered = implode(',', $story_id);
        $picids_ordered = implode(',', $piclist);
        if (!empty($piclist))
            return [
                Story::whereIn('story_id', $story_id)->orderByRaw("FIELD(story_id, $storyids_ordered)")->paginate(4),
                Picture::whereIn('picture_id', $piclist)->orderByRaw("FIELD(picture_id, $picids_ordered)")->paginate(4)
                ];
        return;
    }

     /*
     * ===================================================================
     * =================      Username              ======================
     * ===================================================================
     */
     /*
     * Get UserID associated with username
     * Returns table USER matching
     */ 
    public function getUserIDByUsername($username)
    {
       return User::where('username', $username)->first();
    }

    /*
     * Check if Username is followed by person who is logged in
     * Returns 0 or 1
     */ 
    public function isFollowedByUsername($username)
    {
        //get Authenticated User's followlist_id
        if(Auth::guest())
            return 0;
        $followlist_id = USER::find(Auth::user()->id)->followlist_id;
        $user_id = User::where('username', $username)->select('id')->first()->id;
        $zero_or_one = UserListContains::
                        where('list_id', $followlist_id) 
                        ->where('user_id', $user_id)->first();
        //return 0 or 1 depending if the user is followed or not
        return count($zero_or_one);
    }

    /*
     * Store Follower in database
     */ 
    public function StoreFollowByUsername($username, $follow , $request)
    {
        //select foreign key holy moly one to one magic relationship
        //var_dump(USER::find(6)->followlist_id);
        $follow->list_id = USER::find(Auth::user()->id)->followlist_id;
        $follow->user_id = USER::where('username', $username)->first()->id;

        //error checking for ajax bug
        $zero_or_one = UserListContains::
                        where('list_id', $follow->list_id)
                        ->where('user_id', $follow->user_id)->first();
         if (count($zero_or_one))
             return;
         $follow->save();
    }

    /*
     * Destroy Foller in database
     */ 
    public function RemoveFollowByUsername($username)
    {
        $followlist_id = USER::find(Auth::user()->id)->followlist_id;
        $user_id = User::where('username', $username)->select('id')->first()->id;
        //get column
        $data = UserListContains::
                        where('list_id', $followlist_id) 
                        ->where('user_id', $user_id)->first();
        if (count($data))
            $data->delete();
        return;

    }
}