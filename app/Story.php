<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    //table
	protected $table = 'STORY';
	
	//primary key
	protected $primaryKey = 'story_id';
	
	//set timestamps false;
	public $timestamps  = false;
	
	protected $fillable = [
		'author_id',
		'content',
		//'num_likes',
	];
	
}
