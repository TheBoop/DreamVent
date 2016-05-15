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
		
		//Parse through to find title requests, put them in the Title Array
		echo "<br /> Title requests: <br />";
		$searchRequest = $request->keyword;
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
		$titleResults = array();
		$collection = array();
		$collection = Story::whereIn('title', $titles)->latest()->get();
		foreach($collection as $collection)
        {
            $titleResults[] = $collection->story_id;
        }		
		
		foreach($titles as $title) {
			echo "$title <br />";
		}
		
		echo "<br /> actual request: $searchRequest <br />";

		//parse search string
		$search_words = array_map('trim', explode(",", $searchRequest));
		
		//find and remove stop words & additional spaces
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
		
		//Get tag results for first term. we use this to obtain story_ids for next step.
		$tagResults = Tags::where('tag_id', $search_words[0])->get();//->orderBy('created_at', 'desc');
		
		echo "<br /> results containing $search_words[0]: <br />";
		foreach($tagResults as $result) {
			echo $result . "<br />";
		}
		
		//use the story ids to pull all tags of those stories?
		
		//if there are additional terms, remove each result that does not contain those terms
		echo "<br /> during additional terms: <br />";
		for($i = 1; $i < count($search_words); $i++) {
			echo "results not containing $search_words[$i]: <br />";;
			foreach($tagResults as $key => $result) {
				if (!(Tags::where('story_id', $result->story_id)->where('tag_id', $search_words[$i])->first())) {
					echo $key . ":" . $result . "<br/>";
					unset($tagResults[$key]);
				}
			}
			echo "<br />";
		}

		echo "<br /> final results containing all search terms: <br />";
		foreach($tagResults as $result) {
			echo $result . "<br />";
		}
		
		echo "<br /> final results containing all titles: <br />";
		foreach($titleResults as $result) {
			echo "$result <br />";
		}
		
		/*
			The final step is to return a view, passing it the following information:
			1. $tagResults - contains all the results associated with the tags from the search. 
				Access $tagResults->story_id to make a link in the view.
			
			2. $titleResults - contains all the results associated with the titles from the search.
			
		*/
		/*
		$this->search->GetStoryDescNPic($tagResults, $request->user());
        return view('pagetype.index',
        [
            'pictureList' => $holdList[1],
            'storyList' => $holdList[0],
        ]);*/
		
	}
}