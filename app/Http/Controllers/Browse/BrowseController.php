<?php
namespace App\Http\Controllers\Browse;

use Illuminate\Http\Request;
//use Illuminate\Pagination\Environment as Paginator;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//Eloquent Models
use App\Story; 
use App\Picture; 
use App\TagOccurence; 
use App\Favorites;
use App\Tags;
use App\User as User;

class BrowseController extends Controller
{
    public function defaultBrowse () {
		//Paginator::setPageName('Pictures');
		$pictures = Picture::paginate(3, ['*'], 'Pictures');
		
		//Paginator::setPageName('Stories');
		$stories = Story::paginate(10, ['*'], 'Stories');
		
		return view('browse/browse', 
			['pictures' => $pictures,
			 'stories' => $stories]);
	}
	
	public function defaultBrowseUser() {
		//$users = User::->paginate(3);//->orderBy('created_at', 'desc')->get();
		$users = NULL;
		return view('placeholder', ['users' => $users]);
	}
	
	public function BrowseContent() {
		echo "Browse <br />";
		/*
			======= Liked Content Tags =======
		*/
		//TODO
		//Get tags of stuff you like and count them
		$likedTags = array();
		
		/*
			======= Favorited Content Tags =======
		*/
		//Get IDs of stories you've faved, and find the tags associated with them.
		$faveStoryIDCollection = array();
		$faves = Favorites::where('user_id', Auth::user()->id)->get();
		foreach($faves as $result) {
			$faveStoryIDCollection[] = $result->story_id;
		}
		$favedTags = Tags::whereIn('story_id', $faveStoryIDCollection)->get();

		//Count them and put the result in $favedTagNumOccurences
		$favedTagNumOccurences = array();
		echo "<br /> favedTags: <br />";
		foreach($favedTags as $key => $value) {
			echo "$key: $value->tag_id <br>";
			$lowercaseValue = strtolower($value->tag_id);
			if (array_key_exists($lowercaseValue, $favedTagNumOccurences)) { //If the key exists, increment
				$favedTagNumOccurences[$lowercaseValue] += 1;
			}
			else { //If the key doesn't exist, create it, and give that element a value of 1.
				$favedTagNumOccurences[$lowercaseValue] = 1;
			}
		}
		
		echo "OCCURENCES<br>";
		foreach ($favedTagNumOccurences as $key => $value) {
			echo "$key: $value <br>";
		}
		
		/*
			======= Your Uploaded Content Tags =======
		*/	
		//Get number of occurences of tags of content you've uploaded. This is just a lookup.
		$yourTags = TagOccurence::select('tag', 'num_occurences')->where('user_id', Auth::user()->id)->get();
		
		echo "<br /> yourTags: <br />";
		foreach($yourTags as $key => $value) {
			echo "$key: $value <br /> ";
		}
		
		//Count them and put the results in $yourTagNumOccurences
		$yourTagNumOccurences = array();
		foreach($yourTags as $key => $value) {
			$lowercaseValue = strtolower($value->tag);
			if (array_key_exists($lowercaseValue, $yourTagNumOccurences)) { //If the key exists, increment
				$yourTagNumOccurences[$lowercaseValue] += $value->num_occurences;
			}
			else {
				$yourTagNumOccurences[$lowercaseValue] = $value->num_occurences;
			}
		}
		echo "OCCURENCES<br>";
		foreach ($yourTagNumOccurences as $key => $value) {
			echo "$key: $value <br>";
		}
		
		
		/*
			======= Followed User Content Tags =======
		*/
		//Get number of occurences of tags of content people you follow have uploaded. This is just a lookup.
		$followedTags = TagOccurence::select('tag', 'num_occurences')->whereIn('user_id', $this->Browser->followListAuthorID())->get();
		//TODO: addition is required here: ex: you follow 2 users who uploaded tag "test", one 4 times, and the other once. Combine to get 5 total.
		$numFollowing = count($this->Browser->followListAuthorID());
		echo "<br /> following $numFollowing users <br />"; 
		echo "followedTags: <br />";
		if ($followedTags) {
			foreach($followedTags as $key => $value) {
				echo "$key: $value <br /> ";
			}
		}
		else {
			echo "no results <br /> ";
		}
		
		//Count them and put the results in $followedTagNumOccurences
		$followedTagNumOccurences = array();
		foreach($followedTags as $key => $value) {
			$lowercaseValue = strtolower($value->tag);
			if (array_key_exists($lowercaseValue, $followedTagNumOccurences)) { //If the key exists, increment
				$followedTagNumOccurences[$lowercaseValue] += $value->num_occurences;
			}
			else {
				$followedTagNumOccurences[$lowercaseValue] = $value->num_occurences;
			}
		}
		echo "OCCURENCES<br>";
		foreach ($followedTagNumOccurences as $key => $value) {
			echo "$key: $value <br>";
		}
		
		
		/*
			======= Tag Ranking =======
		*/
		//Use those to calculate tag weights. http://stackoverflow.com/questions/2794272/tag-keyword-based-recommendation
		$tagWeights = array();
		
		//Test:
		echo "<br /> Extra Testing stuff: <br />";
		//var_dump($this->Browser->followListAuthorID());
		//echo "<pre>" .var_dump($followedTags)."<pre />;
		
	
	}
}
