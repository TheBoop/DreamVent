<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagOccurence extends Model
{
    //table
	protected $table = 'TAG_OCCURENCE_BY_USER';
	
	//what fields can be mass-assigned
	protected $fillable = [
		'tag',
		'user_id',
		'num_occurences'
	];
}
