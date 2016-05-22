<?php
namespace App\Http\Controllers\Browse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Pagination\Environment as Paginator;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\AccountRepository;

//Eloquent Models
use App\Story; 
use App\Picture; 
use App\TagOccurence; 
use App\User as User;



class BrowseController extends Controller
{
	protected $Browser;
	
	public function __construct(AccountRepository $Browser) {
		$this->Browser = $Browser;
	}
	
    public function defaultBrowse () {
		//Paginator::setPageName('Pictures');
		$pictures = Picture::paginate(2, ['*'], 'Pictures');
		
		//Paginator::setPageName('Stories');
		$stories = Story::paginate(2, ['*'], 'Stories');
		
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
		//TODO
		//Get tags of stuff you like and count them
		$likedTags = array();
		
		//TODO
		//Get tags of stuff you fav and count them
		$favedTags = array();
			
		//Get number of occurences of tags of content you've uploaded. This is just a lookup.
		$yourTags = TagOccurence::select('tag', 'num_occurences')->where('user_id', Auth::user()->id)->get();
		
		echo "<br /> yourTags: <br />";
		foreach($yourTags as $key => $value) {
			echo "$key: $value <br /> ";
		}
		
		//Get number of occurences of tags of content people you follow have uploaded. This is just a lookup.
		$followedTags = TagOccurence::select('tag', 'num_occurences')->whereIn('user_id', $this->Browser->followListAuthorID())->get();
		
		echo "<br /> followedTags: <br />";
		if ($followedTags) {
			foreach($followedTags as $key => $value) {
				echo "$key: $value <br /> ";
			}
		}
		else {
			echo "no results <br /> ";
		}
		
		//TODO
		//use those to calculate tag weights. http://stackoverflow.com/questions/2794272/tag-keyword-based-recommendation
		$tagWeights = array();
		
		//Test:
		echo "<br /> Extra Testing stuff: <br />";
		//var_dump($this->Browser->followListAuthorID());
		//var_dump($followedTags);
		
	
	}
	
}
