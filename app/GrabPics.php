<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrabPics extends Model
{
    //table
	protected $table = 'GRAB_PICS';
	
	//timestamps 
	public $timestamps = false;
	protected $primaryKey = 'story_id';
	//mass-assignable fields
	public $incrementing = false; 
	protected $fillable = [
		'picture_id',
		'story_id',
		'username',
		'title'
	];

	public function Picture()
   {
        return $this->hasOne('App\Picture');
   }
}
