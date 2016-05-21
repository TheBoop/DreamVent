<?php
/*
*
*	Why there are methods for parent/child: I thought you might use different views and 
*	I don't know if I have to handle the data differently.
*/
namespace App\Http\Controllers\uploadStory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //for Auth::user()
use App\Http\Requests;
use App\Http\Controllers\Controller;

//Eloquent Models
use App\Story; 
use App\Picture; 
use App\GrabPics; 
use App\Abort;
class StoryController extends Controller
{
    //User must be authenticated.
	public function __construct() {
		$this->middleware('auth');
	}
	//This is for uploading a standalone story.
	public function uploadParent () {
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
		$story->username =  Auth::user()->username;
		
		$story->save();
		
		return;
	}
	
	//This is for uploading a story as a response to a picture prompt.
	public function uploadChild ($picture_id) {
		$picture = Picture::find($picture_id);
		if (empty($picture))
			abort(404);
		return view('story/uploadStory', 
					['picture_path' => $picture->picture_link,
					 'picture_id' => $picture_id
					]);
	}
	
	//Storing a child involves a picture_id of some sort.
	public function storeChild (Request $request, $picture_id) {
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
		$story->username =  Auth::user()->username;
		$story->save();
		
		//fill grab_pics relation table
		$grab_pics->story_id = $story->story_id;
		$grab_pics->picture_id = $picture_id;
		
		$grab_pics->save();
		
		if ($request->tags != '')
		{
			$tags = new Tags();
			$taglist = explode(',', $request->tags);
			foreach ($taglist as $index => $tag) {
				$tags = new Tags();
				$taglist[$index] = rtrim(ltrim($taglist[$index]));
				$taglist[$index] = preg_replace('!\s+!', ' ', $taglist[$index]);
				$tags->tag_id = $taglist[$index];
				$tags->story_id = $story->story_id;
				$tags->save();
			}

		}
		return redirect('post/story/'.$grab_pics->story_id);
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