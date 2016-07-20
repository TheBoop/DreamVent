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
	
	public function getPictureSearch(Request $request) {
		return view('search.searchPicture');
	}
	
	public function getPicturesByTag($tag) {
		$tagged = Tags::whereNotNull('picture_id')->where('tag_id', $tag)->get();
		$picIDs = array();
		foreach($tagged as $key => $value) {
			$picIDs[] = $value->picture_id;
		}
		
		$holdlist = Picture::distinct('picture_link')->whereIn('picture_id', $picIDs)->latest()->paginate(12);
		return view('pagetype.index',
        [
            'pictureList' => $holdlist, 
        ]); 
	}
	
		public function getStoriesByTag($tag, Request $request) {
		$tagged = Tags::whereNotNull('story_id')->where('tag_id', $tag)->get();
		$storyIDs = array();
		foreach($tagged as $key => $value) {
			$storyIDs[] = $value->story_id;
		}
		
		$holdList = $this->search->GetStoryDescNPic($storyIDs, $request->user());
        return view('pagetype.index',
        [
            'pictureList' => $holdList[1],
            'storyList' => $holdList[0],
        ]);
	}
	
	public function postSearch(Request $request) {
		
		//Check to see if submission is empty.
		$this->validate($request, [
			'keyword' => 'required'
		]);

		//Put the search phrase into a variable so it can be modified.
		$searchRequest = $request->keyword;
		
		/*
			Parse through the search phrase to find title requests, put them in 
			an array containing titles to search for, and remove them from the 
			search phrase.
		*/
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
		
		//Reset index after unset.
		$search_words = array_values($search_words);
		
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
		for($i = 1; $i < count($search_words); $i++) {
			foreach($searchResults as $key => $result) {
				if (!(Tags::where('story_id', $result)->where('tag_id', $search_words[$i])->first())) {
					unset($searchResults[$key]);
				}
			}
		}

		$holdList = $this->search->GetStoryDescNPic($searchResults, $request->user());
        return view('pagetype.index',
        [
            'pictureList' => $holdList[1],
            'storyList' => $holdList[0],
        ]);
	}
	
	public function postPictureSearch(Request $request) {
		
		//Check to see if submission is empty.
		$this->validate($request, [
			'keyword' => 'required'
		]);
		
		//Put the search phrase into a variable so it can be modified.
		$searchRequest = $request->keyword;
		
		/*
			Parse through the search phrase to find title requests, put them in 
			an array containing titles to search for, and remove them from the 
			search phrase.
		*/
		$titles = array();
		
		//process titles from the search request
		while ($this->search->containsTitleRequest($searchRequest)) {
			if ($this->search->validateTitleRequest($searchRequest)) {
				array_push($titles, $this->search->getFirstTitleOccurence($searchRequest));		
			}
			else
				break;
		}
		
		//Get picture_ids with matching titles
		$searchResults = array();	

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
		
		//Reset index after unset.
		$search_words = array_values($search_words);
		
		//Get tag results for first term. we use this to obtain story_ids for next step.
		if (empty($searchResults)) {
			$collection = Tags::where('tag_id', $search_words[0])->latest()->get();
			foreach ($collection as $result) {
				$searchResults[] = $result->picture_id;
			}
		}
		
		//if there are additional terms, remove each result that does not contain those terms
		for($i = 1; $i < count($search_words); $i++) {
			foreach($searchResults as $key => $result) {
				if (!(Tags::where('picture_id', $result)->where('tag_id', $search_words[$i])->first())) {
					unset($searchResults[$key]);
				}
			}
		}
		
		$holdlist = Picture::distinct('picture_link')->whereIn('picture_id', $searchResults)->latest()->paginate(12);
        return view('pagetype.index',
        [
            'pictureList' => $holdlist, 
        ]);
	}
}