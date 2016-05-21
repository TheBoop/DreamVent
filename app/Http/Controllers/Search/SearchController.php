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
		
		//Check to see if submission is empty.
		$this->validate($request, [
			'keyword' => 'required'
		]);
		
		//Test: repeat the search phrase.
		echo "Input: $request->keyword <br /><br />";
		
		//Put the search phrase into a variable so it can be modified.
		$searchRequest = $request->keyword;
		
		/*
			Parse through the search phrase to find title requests, put them in 
			an array containing titles to search for, and remove them from the 
			search phrase.
		*/
		echo "<br /> Title requests: <br />";
		$titles = array();
		
		//process titles from the search request
		while ($this->search->containsTitleRequest($searchRequest)) {
			if ($this->search->validateTitleRequest($searchRequest)) {
				array_push($titles, $this->search->getFirstTitleOccurence($searchRequest));		
			}
			else
				break;
		}
		
		//Get story_ids with matching titles
		$searchResults = array();
		$collection = array();
		$collection = Story::whereIn('title', $titles)->latest()->get();
		foreach($collection as $collection)
        {
            $searchResults[] = $collection->story_id;
        }		
		
		foreach($titles as $title) {
			echo "$title <br />";
		}
		
		echo "<br /> actual request: $searchRequest <br />";

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
		
		//remove duplicates
		$search_words = array_unique($search_words);
		
		//Reset index after unset.
		$search_words = array_values($search_words);
		
		//Test: Print list of actual search terms.
		echo "<br /> Search Words: <br />";
		foreach ($search_words as $key => $word) {
			echo $key . ":" . $word . "<br />";
		}
		
		//Get tag results for first term. we use this to obtain story_ids for next step.
		if (empty($searchResults)) {
			$collection = Tags::where('tag_id', $search_words[0])->latest()->get();
			foreach ($collection as $result) {
				$searchResults[] = $result->story_id;
			}
		}
		
		/*echo "<br /> results containing $search_words[0]: <br />";
		foreach($searchResults as $result) {
			echo $result . "<br />";
		}*/
		
		//if there are additional terms, remove each result that does not contain those terms
		echo "<br /> during additional terms: <br />";
		for($i = 1; $i < count($search_words); $i++) {
			echo "results not containing $search_words[$i]: <br />";;
			foreach($searchResults as $key => $result) {
				if (!(Tags::where('story_id', $result)->where('tag_id', $search_words[$i])->first())) {
					echo $key . ":" . $result . "<br/>";
					unset($searchResults[$key]);
				}
			}
			echo "<br />";
		}

		echo "<br /> final results containing matching titles/tags: <br />";
		foreach($searchResults as $result) {
			echo $result . "<br />";
		}
		
		
		$holdList = $this->search->GetStoryDescNPic($searchResults, $request->user());
        return view('pagetype.index',
        [
            'pictureList' => $holdList[1],
            'storyList' => $holdList[0],
        ]);
		
	}
}