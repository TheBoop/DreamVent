<?php
namespace App\Repositories;

use App\User;
use App\AccountFrontPage;
use App\Picture;

class AccountRepository
{
    /**
     * Get all of the tasks for a given user.
     *
     * @param  User  $user
     * @return Collection
     */
    public function UserFrontPage(User $user)
    {
        //order by tags likes etc
        //return Picture::where('author_id', $user->id)
        //          ->get();
        //order by tags likes etc
        return Picture::paginate(4);
    }
    public function forNonUser()
    {
       return Picture::orderBy('num_likes', 'DESC')
                    ->paginate(4); 
    }

    public function viewYourOwnPicture(User $user)
    {
       return Picture::where('author_id', $user->id)
                    ->paginate(4);
    }
}