<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class UserList extends Model
{
    protected $table = 'USER_LIST';
    public $timestamps = false;
    protected $primaryKey = 'list_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'list_type',
    ];
}