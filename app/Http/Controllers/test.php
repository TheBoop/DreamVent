<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

//models
use App\Picture; 

class test extends Controller
{
    //test function
	public function test($picture_id) {
		//$picture = Picture::find($picture_id);
		//return view('test', ['Picture' => $picture]);
	}
}
