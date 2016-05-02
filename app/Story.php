<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    //table
	protected $table = 'STORY';
	
	//primary key
	protected $primaryKey = 'story_id';
	
	protected $fillable = [
		'author_id',
		'content',
		'num_likes',
	];
	
}
