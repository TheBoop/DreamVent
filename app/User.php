<?php
namespace App;

use App\AccountFrontPage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    protected $table = 'USER';
    public $timestamps = false;
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 
		'email', 
		'password', 
		'name', 
		'friendlist_id',
        'followlist_id', 
		'contactlist_id', 
		'pagelist_id', 
		'blocklist_id', 
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

    public function pictures()
    {
        return $this->hasMany(AccountFrontPage::class);
    }

   public function followlist_id()
   {
        return $this->hasOne('App\UserList','list_id');
   }

   public function favorite_list()
   {
        return $this->hasMany('App\Favorites','user_id');
   }
}