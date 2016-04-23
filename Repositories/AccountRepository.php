<?php
namespace App\Repositories;

use App\User;
use App\AccountFrontPage;

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
        return USER::where('id', $user->id)
                    ->get();
    }
}