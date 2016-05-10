<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class UserListContains extends Model
{
    protected $table = 'USER_LIST_CONTAINS';
    public $timestamps = false;
    protected $primaryKey = 'list_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'list_id', 'user_id'
    ];

}