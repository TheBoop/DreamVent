<?php
namespace App\Http\Controllers\Search;

use Illuminate\Http\Request;
//use Illuminate\Pagination\Environment as Paginator;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\AccountRepository;

//Eloquent Models
use App\Story; 
use App\Picture; 
use App\Tags; 
use App\User as User;

class SearchUserController extends Controller
{
	protected $search;
	
	public function __construct (AccountRepository $search) {
		$this->search = $search;
	}
	
	public function getSearch(Request $request) {
		return view('search.searchUser');
	}
	
	public function postSearch(Request $request) {
		//Check to see if submission is empty.
		$this->validate($request, [
			'keyword' => 'required'
		]);
		
		//Test: repeat the search phrase.
		echo "Input: $request->keyword <br /><br />";
		
		//Put the search phrase into a variable so it can be modified.
		$searchRequest = $request->keyword;
		
		//parse search string
		$search_words = array_map('trim', explode(",", $searchRequest));
		
		//Find and remove stop words & additional spaces
		echo " <br /> Stop Words and Additional Spaces: <br />";
		foreach ($search_words as $key => $word) {
			if ($this->search->isStopWord($word) || $word == '') {
				echo $key . ":" . $word . "<br />";
				unset($search_words[$key]);
			} 
		}
		
		//Reset index after unset.
		$search_words = array_values($search_words);
		
		//Test: Print list of actual search terms.
		echo "<br /> Search Words: <br />";
		foreach ($search_words as $key => $word) {
			echo $key . ":" . $word . "<br />";
		}
		
		//declare results array
		$searchResults = array();
		
		//Get results
		$searchResults = User::where('username', 'like', '%' . $search_words[0] . '%')->latest()->get();
		
		//Test: print results
		echo "<br /> Results: <br />";
		foreach ($searchResults as $key => $result) {
			echo "$key: $result <br />";
		}
	}
}