<?php

/*
*
*	Why there are methods for parent/child: I thought you might use different views and 
*	I don't know if I have to handle the data differently.
*/


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //for Auth::user()

use App\Http\Requests;

use App\Story; //Eloquent Model
use App\Picture; //Eloquent Model

class StoryController extends Controller
{
    //User must be authenticated.
	public function __construct() {
		$this->middleware('auth');
	}

	//This is for uploading a standalone story.
	public function uploadParent () {
		echo "upload parent story <br/>";
		
		return view('story/uploadStory', ['picture_path' => NULL]);
	}
	
	public function storeParent(Request $request) {
		
		//new instance of model
		$story = new Story();
		
		//make story content required field
		$this->validate($request, [
			'storyContent' => 'required'
		]);
		
		//fill out fields in model
		$story->author_id = Auth::user()->id;
		$story->content = $request->storyContent;
		
		$story->save();
		
		return;
	}
	
	//This is for uploading a story as a response to a picture prompt.
	public function uploadChild ($picture_id) {
		echo "in progress <br/>";
		echo "upload child story <br/>";
		
		$picture = Picture::find($picture_id);
		echo $picture->picture_link;
		
		return view('story/uploadStory', ['picture_path' => $picture->picture_link]);
		
		//{{ URL::to('/') }}/images/stackoverflow.png
	}
	
	//Storing a child involves a picture_id of some sort.
	public function storeChild () {
		//new instance of model
		$story = new Story();
		$grab_pics = new GrabPics();
		
		//make story content required field
		$this->validate($request, [
			'storyContent' => 'required'
		]);
		
		//fill out fields in model
		$story->author_id = Auth::user()->id;
		$story->content = $request->storyContent;
		
		$story->save();
		
		return;
	}
	
	//May delete later, here just in case I can use a single function to handle
	//both parent and child.
	public function testUpload () {
		echo "test elegant upload";
		return;
	}
	public function testStore() {
		echo "test elegant store";
		return;
	}

}
