<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrabPics extends Model
{
    //table
	protected $table = 'GRAB_PICS';
	
	//timestamps 
	public $timestamps = false;

	//mass-assignable fields
	protected $fillable = [
		'picture_id',
		'story_id',
	];
}
