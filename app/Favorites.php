<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorites extends Model
{
    //table
	protected $table = 'FAVORITES';
	
	//primary key
	protected $primaryKey = 'user_id';
	
	//what fields can be mass-assigned
	protected $fillable = [
		'picture_id',
		'story_id',
		'num_likes', //?
		'user_id',
	];

}
