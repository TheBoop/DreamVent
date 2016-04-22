<?php
namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    protected $table = 'USER';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'name', 'friendlist_id',
        'followlist_id', 'contactlist_id', 'pagelist_id', 'holderid4', 
        'holderid5', 'holderid6','holderid7','holderid8', 'holderid9',
    ];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * Get all of the tasks for the user.
     */
    public function account()
    {
        return $this->hasMany(Account::class);
    }
}
