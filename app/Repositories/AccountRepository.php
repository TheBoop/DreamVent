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
    public function forUser(User $user)
    {
        return Picture::where('author_id', $user->id)
                    ->get();
    }
}