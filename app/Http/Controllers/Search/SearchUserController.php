<?php
namespace App\Http\Controllers\Search;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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
		
		//Put the search phrase into a variable so it can be modified.
		$searchRequest = $request->keyword;
		
		//parse search string
		$search_words = array_map('trim', explode(",", $searchRequest));
		
		//Find and remove stop words & additional spaces
		foreach ($search_words as $key => $word) {
			if ($this->search->isStopWord($word) || $word == '') {
				unset($search_words[$key]);
			} 
		}
		
		//remove duplicates
		$search_words = array_unique($search_words);
		
		//Reset array indices.
		$search_words = array_values($search_words);
		
		//declare results array
		$searchResults = array();
		
		//Get results
		//$searchResults = User::where('username', 'like', '%' . $search_words[0] . '%')->latest()->get();
		
		//Get results in loop.
		$collection = new Collection();
		foreach ($search_words as $key => $word) {
			$tmp = User::where('username', 'like', '%' . $word . '%')->get();
			foreach($tmp as $tmpKey => $tmpResult) {
				$collection->push($tmpResult);
			}
		}
		
		return view('search.searchUserResults',
        [
            'users' => $collection->unique()
        ]);
	}
}