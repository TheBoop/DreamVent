<?php
namespace App\Repositories;

use App\User;
use App\Picture;
use Illuminate\Support\Facades\Input;

class AccountRepository
{
    /**
     * Get all of the tasks for a given user.
     *
     * @param  User  $user
     * @return Collection
     */

    //Need algorithm for user's tag likes etc
    public function UserFrontPage(User $user)
    {
        //order by tags likes etc
        //return Picture::where('author_id', $user->id)
        //          ->get();
        //order by tags likes etc
        return Picture::paginate(4);
    }

    /*
     * for any non-logged user. this is our "front page of the internet" like reddit.
     * There is no preference for the user
     */
    public function forNonUser()
    {
       return Picture::orderBy('num_likes', 'DESC')
                    ->paginate(4); 
    }

    /*
     * Show pictures of the current User
     */
    public function viewYourOwnPicture(User $user)
    {
       return Picture::where('author_id', $user->id)
                    ->paginate(4);
    }


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


}