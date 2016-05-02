<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PictureComment extends Model
{
	//table
	protected $table = 'PICTURE_COMMENT';
	
	//primary key
	protected $primaryKey = 'comment_id';
	
	//mass-assignable fields
	protected $fillable = [
		'text',
		'picture_id',
		'author_id',
		'num_likes',
		'comment_type',
	];
}
