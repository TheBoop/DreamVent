<?php

namespace App\Http\Controllers\UploadPic;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth; //for Auth::user()

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tags;
use App\TagOccurence;

use Validator;
use Redirect;
use Session;

use App\Picture; //Eloquent Model

class PictureController extends Controller
{
	//User must be authenticated.
	public function __construct() {
		$this->middleware('auth');
	}
	
    //display form for uploading
	public function upload() {
		return view('picture/uploadPicture');
	}
	
	//handles storing of the image.
	//$request is the POST submission.
	public function store(Request $request) {

		//echo "POST";
		
		//new instance of model
		$picture = new Picture();
		
		//make fields required???
		$this->validate($request, [
			'picture' => 'required'
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
		$picture->save();


		if ($request->tags != '')
		{
			$tags = new Tags();
			$taglist = explode(',', $request->tags);
			foreach ($taglist as $index => $tag) {
				$tags = new Tags();
				$taglist[$index] = rtrim(ltrim($taglist[$index]));
				$taglist[$index] = preg_replace('!\s+!', ' ', $taglist[$index]);
				$tags->tag_id = $taglist[$index];
				$tags->picture_id = $picture->picture_id;
				$tags->save();
				
				//Update Tag Occurences after insert
				$tag_occurence = TagOccurence::where('tag', $tags->tag_id)->where('user_id', Auth::user()->id)->first();
				
				if ($tag_occurence) { //If exists, increment num_occurences.
					$tag_occurence->num_occurences += 1;
					$tag_occurence->save();
				}
				else { //If it doesn't exist, create an entry and set num occurences to 1.
					$tag_occurence = new TagOccurence();
					$tag_occurence->user_id = Auth::user()->id;
					$tag_occurence->tag = $tags->tag_id;
					$tag_occurence->num_occurences = 1;
					$tag_occurence->save();
				}
			}
		return redirect('/YourPictures');
		//I don't know what this line does exactly, and it causes an error.
		//return $this->create()->with('success', 'what black magic is this?!?!'); 
		}
	}
}


/*

class ApplyController extends Controller {
public function upload() {
  // getting all of the post data
  $file = array('image' => Input::file('image'));
  // setting up rules
  $rules = array('image' => 'required',); //mimes:jpeg,bmp,png and for max size max:10000
  // doing the validation, passing post data, rules and the messages
  $validator = Validator::make($file, $rules);
  if ($validator->fails()) {
    // send back to the page with the input data and errors
    return Redirect::to('upload')->withInput()->withErrors($validator);
  }
  else {
    // checking file is valid.
    if (Input::file('image')->isValid()) {
      $destinationPath = 'uploads'; // upload path
      $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
      $fileName = rand(11111,99999).'.'.$extension; // renameing image
      Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
      // sending back with message
      Session::flash('success', 'Upload successfully'); 
      return Redirect::to('upload');
    }
    else {
      // sending back with error message.
      Session::flash('error', 'uploaded file is not valid');
      return Redirect::to('upload');
    }
  }
}
}
*/