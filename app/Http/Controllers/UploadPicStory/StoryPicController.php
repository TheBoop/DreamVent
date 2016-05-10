<?php

namespace App\Http\Controllers\UploadPicStory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth; //for Auth::user()
use Illuminate\Support\Facades\URL;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Validator;
use Redirect;
use Session;

use App\Picture; //Eloquent Model
use App\Story;
use App\GrabPics;

class StoryPicController extends Controller
{
	//User must be authenticated.
	public function __construct() {
		$this->middleware('auth');
	}
	
    //display form for uploading
	public function upload() {
		return view('story/uploadStoryPic');
	}
	
	//handles storing of the image.
	//$request is the POST submission.
	public function store(Request $request) {

		//echo "POST";
		
		//new instance of model
		$picture = new Picture();
		
		//make fields required???
		$this->validate($request, [
			'picture' => 'required',
			'storyContent' => 'required'
		]);
		
		//fill out fields in model
		$picture->description = $request->description;
		$picture->author_id = Auth::user()->id;
		$picture->username = Auth::user()->username;
		
		if ($request->hasFile('picture')) {
			$file = Input::file('picture');
			
			//prefix it with a timestamp later.
			$timestamp = $timestamp = str_replace([' ', ':'], '-', microtime()); //lol microtime, TODO find something more informative?
			$name = $timestamp . $file->getClientOriginalName();
			
			//$picture->picture_link = public_path().'/Pictures/'. $name;
			$picture->picture_link = '/Pictures/'. $name;
			
			$file->move(public_path().'/Pictures/', $name);
		}

		
		$story = new Story();
		$grab_pics = new GrabPics();
		
		//fill out fields in model
		$story->author_id = Auth::user()->id;
		$story->content = $request->storyContent;
		$story->username = Auth::user()->username;
		$story->save();

		//fill grab_pics relation table
		$picture->save();
		$grab_pics->story_id = $story->story_id;
		$grab_pics->picture_id = $picture->getKey();
		$grab_pics->save();
		return redirect('post/story/'.$grab_pics->story_id);
		
	}
}
