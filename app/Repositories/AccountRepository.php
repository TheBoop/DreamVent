<?php
namespace App\Repositories;

use App\User;
use App\Picture; 
use App\Story;
use App\GrabPics;
use App\PictureComment;
use App\StoryComment;
use App\Favorites;
use App\Http\Requests;
use App\UserListContains;
use App\Likes;
use App\Tags;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class AccountRepository
{
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
     *  Get a list of the user's block list
     *  Returns list of author_ids
     */
    public function blockListAuthorID()
    {
        //get authenticated user's id 
        $author_id = array();
        $blocklist_id = USER::find(Auth::user()->id)->blocklist_id;
        //get collection of user_ids the user follows
        $collection = UserListContains::where('list_id', $blocklist_id)->get(); 
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
     *  Get a list of StoryIDs associated by Author_id
     *  Returns list of story IDS Sorted by latest
     */
    public function favoriteListStoryID($author_id)
    { 
        $story_id = array();
        $collection = Favorites::where('user_id', $author_id)->latest()->get();
        foreach($collection as $collection)
        {
            $story_id[] = $collection->story_id;
        }
        return $story_id;
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

    public function getNumOfLikesByPID($picture_id)
    {
        $data = Likes:: where('picture_id', $picture_id);
        return count($data);

    }

    public function getNumOfFavoritesByPID($picture_id)
    {
        $data = Favorites:: where('picture_id', $picture_id);
        return count($data);

    }

    public function StoreLikeByPID($picture_id, $like, $request)
    {
        //select foreign key holy moly one to one magic relationship
        //var_dump(USER::find(6)->followlist_id);
        $like->picture_id = $picture_id;
        $like->user_id = $request->user()->id;
        //error checking for ajax bug
        $zero_or_one = Likes::
                        where('picture_id', $like->picture_id)
                        ->where('user_id', $like->user_id)->first();
         if (count($zero_or_one))
             return;
         $like->save();
    }

    /*
     * Destroy Like in database
     */ 
    public function RemoveLikeByPID($picture_id)
    {
        $user_id = Auth::user()->id;
        $picture_id = $picture_id;

        //get column
        $data = Likes::
                        where('picture_id', $picture_id) 
                        ->where('user_id', $user_id)->first();
        if (count($data))
            $data->delete();
        return;

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

    public function GetStoryDescNPic($story_id, $request)
    {   
        //error cases with guest/nonguest
        if ($request==null)
            $user_id = 0;
        else
            $user_id = $request->id;
        if (empty($story_id))
            return;
        
        foreach ($story_id as $index => $value) {
            //confusing for someone new to relations but I used relations for find look at models
            $piclist[$index] = Picture::find(
                                Story::find($story_id[$index])->pic_id->picture_id)->picture_id;
        }
        $storyids_ordered = implode(',', $story_id);
        $picids_ordered = implode(',', $piclist);
        //I think i can get reduce query ask of Picture::whereIn and improve speed
        if (!empty($piclist))
            return [
                Story::whereIn('story_id', $story_id)->orderByRaw("FIELD(story_id, $storyids_ordered)")->paginate(4),
                Picture::whereIn('picture_id', $piclist)->orderByRaw("FIELD(picture_id, $picids_ordered)")->paginate(4),
                ];
        return;
    }

    public function StoreFavoriteBySID($story_id, $favorite , $request)
    {
        //select foreign key holy moly one to one magic relationship
        //var_dump(USER::find(6)->followlist_id);

        $favorite->story_id = $story_id;
        $favorite->user_id = $request->user()->id;

        //error checking for ajax bug
        $zero_or_one = Favorites::
                        where('story_id', $favorite->story_id)
                        ->where('user_id', $favorite->user_id)->first();
         if (count($zero_or_one))
             return;
         $favorite->save();
    }

    /*
     * Destroy Foller in database
     */ 
    public function RemoveFavoriteBySID($story_id)
    {
        $user_id = Auth::user()->id;
        $story_id = $story_id;
        //get column
        $data = Favorites::
                        where('story_id', $story_id) 
                        ->where('user_id', $user_id)->first();
        if (count($data))
            $data->delete();
        return;

    }

    public function StoreLikeBySID($story_id, $favorite , $request)
    {
        //select foreign key holy moly one to one magic relationship
        //var_dump(USER::find(6)->followlist_id);
        $favorite->story_id = $story_id;
        $favorite->user_id = $request->user()->id;
        //error checking for ajax bug
        $zero_or_one = Likes::
                        where('story_id', $favorite->story_id)
                        ->where('user_id', $favorite->user_id)->first();
         if (count($zero_or_one))
             return;
         $favorite->save();
    }

    /*
     * Destroy Like in database
     */ 
    public function RemoveLikeBySID($story_id)
    {
        $user_id = Auth::user()->id;
        $story_id = $story_id;
        //get column
        $data = Likes::
                        where('story_id', $story_id) 
                        ->where('user_id', $user_id)->first();
        if (count($data))
            $data->delete();
        return;

    }


    public function getNumOfLikesBySID($story_id)
    {
        $data = Likes:: where('story_id', $story_id);
        return count($data);

    }

    public function getNumOfFavoritesBySID($story_id)
    {
        $data = Favorites:: where('story_id', $story_id);
        return count($data);

    }

    /*
     * Check if SID is liked by user
     */ 
    public function isLikedBySID($story_id)
    {
        if(Auth::guest())
            return 0;
        $user_id = Auth::user()->id;
        $story_id = $story_id;
        //get column
        $data = Likes::
                        where('story_id', $story_id) 
                        ->where('user_id', $user_id)->first();
        return count($data);

    }


    /*
     * Check if SID is favorited by user
     */ 
    public function isFavoritedBySID($story_id)
    {
        if(Auth::guest())
            return 0;
        $user_id = Auth::user()->id;
        $story_id = $story_id;
        //get column
        $data = Favorites::
                        where('story_id', $story_id) 
                        ->where('user_id', $user_id)->first();
        return count($data);

    }

    public function DeleteStoryBySID($story_id)
    {
        //Check if story ID matches user id
        $user_id = Auth::user()->id;
        $check = Story::where('story_id', $story_id)
                        ->where('author_id', $user_id )->first();

        if($check){
            $grab_pic = GrabPics::where('story_id', $story_id)->first();
            $check->delete();
            $grab_pic->delete();
            //maybe have a column for display/dontdisplay instead of deleting
        }
        return;
    }
    public function ReturnStoryTagsBySID($story_id)
    {
        //Check if story ID matches user id
        $user_id = Auth::user()->id;
        $check = Story::where('story_id', $story_id)
                        ->where('author_id', $user_id )->first();

        if($check){
            $holdlist_tags = Tags::where('story_id', $story_id)->get();
            $tagstr = "";
            foreach ($holdlist_tags as $index => $holdlist_tag) {
                $tagstr = $tagstr.$holdlist_tags[$index]->tag_id.',';
            }
            $tagstr = rtrim($tagstr,',');
        }
        return $tagstr;
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
     * Get FollowList
     * List of followers
     */ 
    public function GetFollowList()
    {
        //get Authenticated User's followlist_id
        if(Auth::guest())
            return 0;
        $followlist_id = USER::find(Auth::user()->id)->followlist_id;
        $list_id = UserListContains::
                        where('list_id', $followlist_id)->get();
        //return 0 or 1 depending if the user is followed or not
        return $list_id;
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

    ////BLOCKED METHODS
    /*
     * Check if Username is blocked by person who is logged in
     * Returns 0 or 1
     */ 
    public function isBlockedByUsername($username)
    {
        //get Authenticated User's followlist_id
        if(Auth::guest())
            return 0;
        $blocklist_id = USER::find(Auth::user()->id)->blocklist_id;
        $user_id = User::where('username', $username)->select('id')->first()->id;
        $zero_or_one = UserListContains::
                        where('list_id', $blocklist_id) 
                        ->where('user_id', $user_id)->first();
        //return 0 or 1 depending if the user is followed or not
        return count($zero_or_one);
    }


    /*
     * Store Block in database
     */ 
    public function StoreBlockByUsername($username, $block , $request)
    {
        //select foreign key holy moly one to one magic relationship
        //var_dump(USER::find(6)->blocklist_id);
        $block->list_id = USER::find(Auth::user()->id)->blocklist_id;
        $block->user_id = USER::where('username', $username)->first()->id;

        //error checking for ajax bug
        $zero_or_one = UserListContains::
                        where('list_id', $block->list_id)
                        ->where('user_id', $block->user_id)->first();
         if (count($zero_or_one))
             return;
         $block->save();
    }

    /*
     * Destroy Block in database
     */ 
    public function RemoveBlockByUsername($username)
    {
        $blocklist_id = USER::find(Auth::user()->id)->blocklist_id;
        $user_id = User::where('username', $username)->select('id')->first()->id;
        //get column
        $data = UserListContains::
                        where('list_id', $blocklist_id) 
                        ->where('user_id', $user_id)->first();
        if (count($data))
            $data->delete();
        return;

    }

    /*
     * Get BlockList
     * List of Blocked people
     */ 
    public function GetBlockList()
    {
        //get Authenticated User's blocklist_id
        if(Auth::guest())
            return 0;
        $blocklist_id = USER::find(Auth::user()->id)->blocklist_id;
        $list_id = UserListContains::
                        where('list_id', $blocklist_id)->get();
        return $list_id;
    }

    /*
     * Get BlockList
     * List of Blocked people
     */ 
    public function DeleteStoryCommentByID($comment_id)
    {
        //get Authenticated User's blocklist_id
        if(Auth::guest())
            return 0;
        //get comment
        $comment = StoryComment::where('comment_id',$comment_id)
                                ->first();
        //check if Story_id is owned by the author user
        $check = Story::where('story_id', $comment->story_id)->first();
        $check_2 = Story::where('author_id', Auth::user()->id)->first();
        if ($comment == null)
            return 0;

        $comment->text = "Deleted";
        $comment->save();
    }



}
