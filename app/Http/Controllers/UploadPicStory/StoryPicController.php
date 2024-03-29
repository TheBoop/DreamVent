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
use App\Tags;
use App\TagOccurence;
use App\Repositories\AccountRepository;

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
		$story->title = $request->title;
		$story->save();

		//fill grab_pics relation table
		$picture->save();
		$grab_pics->story_id = $story->story_id;
		$grab_pics->picture_id = $picture->getKey();
		$grab_pics->username = Auth::user()->username;
		$grab_pics->title =  $request->title;
		$grab_pics->save();

		if ($request->pic_tags != '')
		{
			$pic_tags = new Tags();
			$taglist = explode(',', $request->pic_tags);
			foreach ($taglist as $index => $tag) {
				$pic_tags = new Tags();
				$taglist[$index] = rtrim(ltrim($taglist[$index]));
				$taglist[$index] = preg_replace('!\s+!', ' ', $taglist[$index]);
				$pic_tags->tag_id = $taglist[$index];
				$pic_tags->picture_id = $picture->picture_id;
				$pic_tags->save();
				
				//Update Tag Occurences after insert
				$tag_occurence = TagOccurence::where('tag', $pic_tags->tag_id)->where('user_id', Auth::user()->id)->first();
				
				if ($tag_occurence) { //If exists, increment num_occurences.
					$tag_occurence->num_occurences += 1;
					$tag_occurence->save();
				}
				else { //If it doesn't exist, create an entry and set num occurences to 1.
					$tag_occurence = new TagOccurence();
					$tag_occurence->user_id = Auth::user()->id;
					$tag_occurence->tag = $pic_tags->tag_id;
					$tag_occurence->num_occurences = 1;
					$tag_occurence->save();
				}
			}

		}

		if ($request->story_tags != '')
		{
			$story_tags = new Tags();
			$taglist = explode(',', $request->story_tags);
			foreach ($taglist as $index => $tag) {
				$story_tags = new Tags();
				$taglist[$index] = rtrim(ltrim($taglist[$index]));
				$taglist[$index] = preg_replace('!\s+!', ' ', $taglist[$index]);
				$story_tags->tag_id = $taglist[$index];
				$story_tags->story_id = $story->story_id;
				$story_tags->save();
				
				//Update Tag Occurences after insert
				$tag_occurence = TagOccurence::where('tag', $story_tags->tag_id)->where('user_id', Auth::user()->id)->first();
				
				if ($tag_occurence) { //If exists, increment num_occurences.
					$tag_occurence->num_occurences += 1;
					$tag_occurence->save();
				}
				else { //If it doesn't exist, create an entry and set num occurences to 1.
					$tag_occurence = new TagOccurence();
					$tag_occurence->user_id = Auth::user()->id;
					$tag_occurence->tag = $story_tags->tag_id;
					$tag_occurence->num_occurences = 1;
					$tag_occurence->save();
				}
			}

		}
		return redirect('post/story/'.$grab_pics->story_id);
		
	}
}

?>