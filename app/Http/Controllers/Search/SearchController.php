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

class SearchController extends Controller
{
	protected $search;
	
	public function __construct (AccountRepository $search) {
		$this->search = $search;
	}
	
	public function getSearch(Request $request) {
		return view('search.search');
	}
	
	public function postSearch(Request $request) {
		echo "Input: $request->keyword <br /><br />";
		
		//parse
		$search_words = explode(" ", $request->keyword);
		
		//find and remove stop words
		echo "Stop Words: <br />";
		foreach ($search_words as $key => $word) {
			if ($this->search->isStopWord($word)) {
				echo $word . "<br />";
				unset($search_words[$key]);
			}
		}
		$search_words = array_values($search_words);
		echo "<br />";
		
		//test: print search terms
		echo "Search Words: <br />";
		foreach ($search_words as $key => $word) {
			echo $key . ": " . $word . "<br />";
		}
		
		//set num terms
		$results = array();
		
		//Get tag results for first term. we use this to obtain story_ids for next step.
		$results = Tags::where('tag_id', $search_words[0])->get();//->orderBy('created_at', 'desc');
		
		echo "<br /> results containing $search_words[0]: <br />";
		foreach($results as $result) {
			echo $result . "<br />";
		}
		
		//use the story ids to pull all tags of those stories?
		
		//if there are additional terms, remove each result that does not contain those terms
		echo "<br /> during additional terms: <br />";
		for($i = 1; $i < count($search_words); $i++) {
			echo "results not containing $search_words[$i]: <br />";;
			foreach($results as $key => $result) {
				if (!(Tags::where('story_id', $result->story_id)->where('tag_id', $search_words[$i])->first())) {
					echo $key . ": " . $result . "<br/>";
					unset($results[$key]);
				}
			}
			echo "<br />";
		}

		echo "<br /> final results containing all search terms: <br />";
		foreach($results as $result) {
			echo $result . "<br />";
		}
		
		
		
	}
}