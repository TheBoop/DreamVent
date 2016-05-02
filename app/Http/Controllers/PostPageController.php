<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Picture; //Eloquent Model

class PostPage extends Controller
{
    public function ViewImage($picture_id) {
		return view('post/post',  ['picture' => Picture::find($picture_id)]);
	}
	
	public function ViewStory ($story_id) {
		//return view('view name here', ['story_id' => $story_id])
	}
}
