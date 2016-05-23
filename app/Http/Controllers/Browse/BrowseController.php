<?php
namespace App\Http\Controllers\Browse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\AccountRepository;

//Eloquent Models
use App\Story; 
use App\Picture; 
use App\TagOccurence; 
use App\Favorites;
use App\Tags;
use App\Likes;
use App\User as User;

class BrowseController extends Controller
{
	protected $Browser;
	
	public function __construct(AccountRepository $Browser) {
		$this->Browser = $Browser;
		$this->middleware('auth');
	}
	
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
	
	public function BrowseContent(Request $request) {
		echo "Browse <br />";
		/*
			======= Liked Content Tags =======
		*/
		//Get IDs of stories you've faved, and find the tags associated with them.
		$likedStoryIDCollection = array();
		$likes = Likes::where('user_id', Auth::user()->id)->get();
		foreach($likes as $result) {
			$likedStoryIDCollection[] = $result->story_id;
		}
		$likedTags = Tags::whereIn('story_id', $likedStoryIDCollection)->get();
		
		//Count them and put the result in $likedTagNumOccurences
		$likedTagNumOccurences = array();
		echo "<br /> likedTags: <br />";
		foreach($likedTags as $key => $value) {
			echo "$key: $value->tag_id <br>";
			$lowercaseValue = strtolower($value->tag_id);
			if (array_key_exists($lowercaseValue, $likedTagNumOccurences)) { //If the key exists, increment
				$likedTagNumOccurences[$lowercaseValue] += 1;
			}
			else { //If the key doesn't exist, create it, and give that element a value of 1.
				$likedTagNumOccurences[$lowercaseValue] = 1;
			}
		}
		
		echo "OCCURENCES<br>";
		foreach ($likedTagNumOccurences as $key => $value) {
			echo "$key: $value <br>";
		}
		
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
		//how many people user is following
		$numFollowing = count($this->Browser->followListAuthorID());
		$numFollowing = ($numFollowing < 1) ? 1 : $numFollowing;
		
		//Get list of tags to perform computations on
		$tagList = array();
		$this->Browser->updateTaglistFromTagOccurence($tagList, $likedTagNumOccurences);
		$this->Browser->updateTaglistFromTagOccurence($tagList, $favedTagNumOccurences);
		$this->Browser->updateTaglistFromTagOccurence($tagList, $yourTagNumOccurences);
		$this->Browser->updateTaglistFromTagOccurence($tagList, $followedTagNumOccurences);
		
		//Use those to calculate tag ranks. http://stackoverflow.com/questions/2794272/tag-keyword-based-recommendation
		foreach ($tagList as $tag => $rank) {
			$liked		= array_key_exists($tag, $likedTagNumOccurences) ? $likedTagNumOccurences[$tag] : 0;
			$faved		= array_key_exists($tag, $favedTagNumOccurences) ? $favedTagNumOccurences[$tag] : 0;
			$content	= array_key_exists($tag, $yourTagNumOccurences) ? $yourTagNumOccurences[$tag] : 0; 
			$followed	= array_key_exists($tag, $followedTagNumOccurences) ? $followedTagNumOccurences[$tag] : 0;
			$tagList[$tag] = (1.5 * $liked) + (2.0 * $faved) + (1.2 * $content) + (1.0 * $followed / $numFollowing);
			
			//echo "$tag: $tagList[$tag] = (1.5 * $liked) + (2.0 * $faved) + (1.2 * $content) + (1.0 * $followed / $numFollowing) <br>";
		}
		
		//sort high to low
		arsort($tagList);
		
		echo "<br> Sorted Tag Ranks: <br>";
		foreach($tagList as $tag => $rank) {
			echo "$tag: $rank <br>";
		}
		
		//How many tags to search for
		$maxTags = 10;
		$numTags = count($tagList);
		$numTags = $numTags > $maxTags ? $maxTags : $numTags; 
		
		//Get top tags, make em elements
		$topTags = array_slice($tagList, 0, $numTags, true);
		echo "<br> Top Tags <br>";
		foreach($topTags as $key => $value) {
			$topTags[$key] = $key;
		}
		foreach($topTags as $key => $value) {
			echo "$key: $value <br>";
		}
		
		//get story ids with these tags
		$storyIDs = array();
		$collection = Tags::whereNotNull('story_id')->whereIn('tag_id', $topTags)->get();
		foreach($collection->unique('story_id') as $k=>$c) {
			echo "$k: $c <br>";
			$storyIDs[] = $c->story_id;
		}
		//$storyIDs = array_unique($storyIDs);
		
		foreach($storyIDs as $k => $v) {
			echo "$k: $v <br>";
		}
		
		//return
		$holdList = $this->Browser->GetStoryDescNPic($storyIDs, $request->user());
        return view('pagetype.index',
        [
            'pictureList' => $holdList[1],
            'storyList' => $holdList[0],
        ]);
		
		
		//Test:
		echo "<br /> Extra Testing stuff: <br />";
		//var_dump($this->Browser->followListAuthorID());
		//echo "<pre>" .var_dump($followedTags)."<pre />;
	}
	
		public function BrowsePictureContent(Request $request) {
		echo "Browse <br />";
		/*
			======= Liked Content Tags =======
		*/
		//Get IDs of stories you've faved, and find the tags associated with them.
		$likedStoryIDCollection = array();
		$likes = Likes::where('user_id', Auth::user()->id)->get();
		foreach($likes as $result) {
			$likedStoryIDCollection[] = $result->story_id;
		}
		$likedTags = Tags::whereIn('story_id', $likedStoryIDCollection)->get();
		
		//Count them and put the result in $likedTagNumOccurences
		$likedTagNumOccurences = array();
		echo "<br /> likedTags: <br />";
		foreach($likedTags as $key => $value) {
			echo "$key: $value->tag_id <br>";
			$lowercaseValue = strtolower($value->tag_id);
			if (array_key_exists($lowercaseValue, $likedTagNumOccurences)) { //If the key exists, increment
				$likedTagNumOccurences[$lowercaseValue] += 1;
			}
			else { //If the key doesn't exist, create it, and give that element a value of 1.
				$likedTagNumOccurences[$lowercaseValue] = 1;
			}
		}
		
		echo "OCCURENCES<br>";
		foreach ($likedTagNumOccurences as $key => $value) {
			echo "$key: $value <br>";
		}
		
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
		//how many people user is following
		$numFollowing = count($this->Browser->followListAuthorID());
		$numFollowing = ($numFollowing < 1) ? 1 : $numFollowing;
		
		//Get list of tags to perform computations on
		$tagList = array();
		$this->Browser->updateTaglistFromTagOccurence($tagList, $likedTagNumOccurences);
		$this->Browser->updateTaglistFromTagOccurence($tagList, $favedTagNumOccurences);
		$this->Browser->updateTaglistFromTagOccurence($tagList, $yourTagNumOccurences);
		$this->Browser->updateTaglistFromTagOccurence($tagList, $followedTagNumOccurences);
		
		//Use those to calculate tag ranks. http://stackoverflow.com/questions/2794272/tag-keyword-based-recommendation
		foreach ($tagList as $tag => $rank) {
			$liked		= array_key_exists($tag, $likedTagNumOccurences) ? $likedTagNumOccurences[$tag] : 0;
			$faved		= array_key_exists($tag, $favedTagNumOccurences) ? $favedTagNumOccurences[$tag] : 0;
			$content	= array_key_exists($tag, $yourTagNumOccurences) ? $yourTagNumOccurences[$tag] : 0; 
			$followed	= array_key_exists($tag, $followedTagNumOccurences) ? $followedTagNumOccurences[$tag] : 0;
			$tagList[$tag] = (1.5 * $liked) + (2.0 * $faved) + (1.2 * $content) + (1.0 * $followed / $numFollowing);
			
			//echo "$tag: $tagList[$tag] = (1.5 * $liked) + (2.0 * $faved) + (1.2 * $content) + (1.0 * $followed / $numFollowing) <br>";
		}
		
		//sort high to low
		arsort($tagList);
		
		echo "<br> Sorted Tag Ranks: <br>";
		foreach($tagList as $tag => $rank) {
			echo "$tag: $rank <br>";
		}
		
		//How many tags to search for
		$maxTags = 10;
		$numTags = count($tagList);
		$numTags = $numTags > $maxTags ? $maxTags : $numTags; 
		
		//Get top tags, make em elements
		$topTags = array_slice($tagList, 0, $numTags, true);
		echo "<br> Top Tags <br>";
		foreach($topTags as $key => $value) {
			$topTags[$key] = $key;
		}
		foreach($topTags as $key => $value) {
			echo "$key: $value <br>";
		}
		
		//get story ids with these tags
		$storyIDs = array();
		$collection = Tags::whereNotNull('story_id')->whereIn('tag_id', $topTags)->get();
		foreach($collection->unique('story_id') as $k=>$c) {
			echo "$k: $c <br>";
			$storyIDs[] = $c->story_id;
		}
		//$storyIDs = array_unique($storyIDs);
		
		foreach($storyIDs as $k => $v) {
			echo "$k: $v <br>";
		}
		
		//return
		$holdList = $this->Browser->GetStoryDescNPic($storyIDs, $request->user());
        return view('pagetype.index',
        [
            'pictureList' => $holdList[1],
            'storyList' => $holdList[0],
        ]);
		
		
		//Test:
		echo "<br /> Extra Testing stuff: <br />";
		//var_dump($this->Browser->followListAuthorID());
		//echo "<pre>" .var_dump($followedTags)."<pre />;
	}
}
