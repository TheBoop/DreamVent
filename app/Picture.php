<?php

//This defines the model for the PICTURE table.

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    //table
	protected $table = 'PICTURE';
	
	//primary key
	protected $primaryKey = 'picture_id'; 
	
	//dont automatically deal with timestamps
	public $timestamps = false;
	
	//what fields can be mass-assigned
	protected $fillable = [
		//'picture_id', //the database should auto-increment automatically
		'picture_link',
		'author_id',
		'description'
	];
	
	
}
