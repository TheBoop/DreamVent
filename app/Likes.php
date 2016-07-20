<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    //table
	protected $table = 'LIKES';
	
	//what fields can be mass-assigned
	protected $fillable = [
		'picture_id',
		'story_id',
		'user_id',
	];

	public function Picture()
   {
        return $this->hasOne('App\Picture');
   }
}
