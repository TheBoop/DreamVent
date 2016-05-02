<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //for Auth::user()

use App\Http\Requests;


//Eloquent Model
use App\Picture; 
use App\Story;
use App\GrabPics;
use App\PictureComment;
use App\StoryComment;

class PostPage extends Controller
{
    public function ViewImage($picture_id) {
		$picture = Picture::find($picture_id);
		$story_ids = GrabPics::where('picture_id', $picture_id)->select('story_id')->get();
		$comments = PictureComment::where('picture_id', $picture_id)->get();
		
		return view('postpage/picture', 
			['picture' => $picture,
			 'story_ids' => $story_ids,
			 'comments' => $comments]);
	}
	
	public function ViewStory ($story_id) {
		$story = Story::find($story_id);
		$comments = StoryComment::where('story_id', $story_id)->get();
		
		return view('postpage/story', 
		['story' => $story,
		 'comments' => $comments]);
	}
	
	public function StoreImageComment (Request $request, $picture_id) {
		//make new instance of comment.
		$comment = new PictureComment();
		
		//required field
		$this->validate($request, [
			'comment' => 'required'
		]);
		
		//store comment. there are other fields I dont know what to do with.
		$comment->text = $request->comment;
		$comment->picture_id = $picture_id;
		$comment->author_id = Auth::user()->id;
		
		$comment->save();
		
		//This is basically the contents of ViewImage(). I wrote this in a rush and don't know how to call the function.
		$picture = Picture::find($picture_id);
		$story_ids = GrabPics::where('picture_id', $picture_id)->select('story_id')->get();
		$comments = PictureComment::where('picture_id', $picture_id)->get();
		
		return view('postpage/picture', 
			['picture' => $picture,
			 'story_ids' => $story_ids,
			 'comments' => $comments]);

	}
	
	public function StoreStoryComment (Request $request, $story_id) {
				//make new instance of comment.
		$comment = new StoryComment();
		
		//required field
		$this->validate($request, [
			'comment' => 'required'
		]);
		
		//store comment. there are other fields I dont know what to do with.
		$comment->text = $request->comment;
		$comment->story_id = $story_id;
		$comment->author_id = Auth::user()->id;
		
		$comment->save();
		
		//This is basically the contents of ViewStory(). I wrote this in a rush and don't know how to call the function.
		$story = Story::find($story_id);
		$comments = StoryComment::where('story_id', $story_id)->get();
		
		return view('postpage/story', 
		['story' => $story,
		 'comments' => $comments]);

	}
}
