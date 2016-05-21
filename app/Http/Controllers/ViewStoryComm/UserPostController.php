<?php

namespace App\Http\Controllers\ViewStoryComm;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //for Auth::user()

use App\Http\Requests;
use App\Http\Controllers\Controller;


//Eloquent Model
use App\Picture; 
use App\Story;
use App\GrabPics;
use App\PictureComment;
use App\StoryComment;
use App\Favorites;
use App\Likes;
use App\Tags;
use App\TagOccurence;
use App\Repositories\AccountRepository;


class UserPostController extends Controller
{
	protected $PostPageInstance;

    public function __construct(AccountRepository $PostPageInstance)
    {
        $this->middleware('auth');
        $this->PostPageInstance = $PostPageInstance;
    }
	
	public function StoreImageComment (Request $request, $picture_id) {
		//make new instance of comment.
		$comment = new PictureComment();
		
		//required field
		$this->validate($request, [
			'comment' => 'required'
		]);
		
		$this->PostPageInstance->StorePicCommentMethod($request, $picture_id, $comment);
		return view('postpage/picture', 
			[
			 'picture' => $this->PostPageInstance->getPictureBasedonPID($picture_id),
			 'story' =>  $this->PostPageInstance->getStoryIDsBasedOnPID($picture_id),
			 'comments' => $this->PostPageInstance->getPicCommentBasedonPID($picture_id),
			 'isfavorited' => $this->PostPageInstance->isFavoritedBySID($story_id),
		 	 'isliked' => $this->PostPageInstance->isLikedBySID($story_id),
			]);

	}
	
	public function StoreStoryComment (Request $request, $story_id) {
				//make new instance of comment.
		$comment = new StoryComment();
		
		//required field
		$this->validate($request, [
			'comment' => 'required'
		]);
		
		$this->PostPageInstance->StoreStoryCommentMethod($request, $story_id, $comment);

		return view('postpage/story', 
		[
		 'piclist'=> $this->PostPageInstance->getPicBasedOnSID($story_id),
		 'story' => $this->PostPageInstance->getStoryBasedonSID($story_id),
		 'comments' => $this->PostPageInstance->getStoryCommentBasedonSID($story_id),
		 'isfavorited' => $this->PostPageInstance->isFavoritedBySID($story_id),
		 'isliked' => $this->PostPageInstance->isLikedBySID($story_id),
		]);

	}

	public function Favorite($story_id, Request $request)
    {
        $favorite = new Favorites();
        $this->PostPageInstance->StoreFavoriteBySID($story_id, $favorite, $request);
        //return redirect()->action('UserList\NonUserListController@testProfile', [$story_id]);

    }
    public function Unfavorite($story_id)
    {   
        $this->PostPageInstance->RemoveFavoriteBySID($story_id);
        //return redirect()->action('UserList\NonUserListController@testProfile', [$story_id]);
    }

    public function Like($story_id, Request $request)
    {
        $like = new Likes();
        $this->PostPageInstance->StoreLikeBySID($story_id, $like, $request);
        //return redirect()->action('UserList\NonUserListController@testProfile', [$story_id]);

    }
    public function Unlike($story_id)
    {   
        $this->PostPageInstance->RemoveLikeBySID($story_id);
        //return redirect()->action('UserList\NonUserListController@testProfile', [$story_id]);
    }
    public function DeleteStory($story_id)
    {   
        $this->PostPageInstance->DeleteStoryBySID($story_id);
        //return redirect()->action('UserList\NonUserListController@testProfile', [$story_id]);
    }
    public function GetTags($story_id, Request $request) {
		$currentTag = $this->PostPageInstance->ReturnStoryTagsBySID($story_id);
		return view('postpage/edittags', 
		[
		 'piclist'=> $this->PostPageInstance->getPicBasedOnSID($story_id),
		 'story' => $this->PostPageInstance->getStoryBasedonSID($story_id),
		 'currentTag' => $currentTag,
		]);
		//return redirect()->action('UserList\NonUserListController@testProfile', [$story_id]);
	}
	public function StoreNewTags($story_id, Request $request)
    {   
		$author_id = Story::find($story_id)->author_id;
	
		//Delete Tags
    	$getTagColumn = Tags::where('story_id', $story_id);
		
		//Update Tag Occurences before delete
		foreach($getTagColumn->get() as $key => $tag) {
			$tag_occurence = TagOccurence::where('tag', $tag->tag_id)->where('user_id', $author_id)->first();
			
			if ($tag_occurence) { //If exists, decrement num_occurences, make sure its not less than 0;
				if ($tag_occurence->num_occurences > 0) {
					$tag_occurence->num_occurences -= 1;
					$tag_occurence->save();
				}
			}
			else {
				//technically this shouldn't happen.
			}
		}
		
    	$getTagColumn->delete();

    	//Insert Tags
		if ($request->input('tag') != '')
		{
			$tags = new Tags();
			$taglist = explode(',', $request->input('tag'));
			foreach ($taglist as $index => $tag) {
				$tags = new Tags();
				$taglist[$index] = rtrim(ltrim($taglist[$index]));
				$taglist[$index] = preg_replace('!\s+!', ' ', $taglist[$index]);
				$tags->tag_id = $taglist[$index];
				$tags->story_id = $story_id;
				$tags->save();
				
				//Update Tag Occurences after insert
				$tag_occurence = TagOccurence::where('tag', $tags->tag_id)->where('user_id', $author_id)->first();
				
				if ($tag_occurence) { //If exists, increment num_occurences.
					$tag_occurence->num_occurences += 1;
					$tag_occurence->save();
				}
				else { //If it doesn't exist, create an entry and set num occurences to 1.
					$tag_occurence = new TagOccurence();
					$tag_occurence->user_id = $author_id;
					$tag_occurence->tag = $tags->tag_id;
					$tag_occurence->num_occurences = 1;
					$tag_occurence->save();
				}
			}

		}
    	//
       return redirect('/post/story/'.$story_id);
    }

    public function DeleteComment($comment_id)
    {   
        $this->PostPageInstance->DeleteStoryCommentByID($comment_id);
        //return redirect()->action('UserList\NonUserListController@testProfile', [$story_id]);
    }
}
