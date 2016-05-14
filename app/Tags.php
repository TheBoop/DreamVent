<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    //table
	protected $table = 'TAGS';
	
	//what fields can be mass-assigned
	protected $fillable = [
		'picture_id',
		'story_id',
		'user_id',
		'tag_id'
	];

}
