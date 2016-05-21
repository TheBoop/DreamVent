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
use App\Repositories\AccountRepository;


class NonUserPostController extends Controller
{
	protected $PostPageInstance;

    public function __construct(AccountRepository $PostPageInstance)
    {
        $this->PostPageInstance = $PostPageInstance;
    }

    public function ViewImage($picture_id) {		
		return view('postpage/picture', 
			[
			 'picture' => $this->PostPageInstance->getPictureBasedonPID($picture_id),
			 'story' => $this->PostPageInstance->getStoryIDsBasedOnPID($picture_id),
			 'comments' => $this->PostPageInstance->getPicCommentBasedonPID($picture_id)
			 ]);
	}

    public function ViewPost($picture_id) {
		return view('post/viewPost',  
			[
			 'picture' => $this->PostPageInstance->getPictureBasedonPID($picture_id),
			]);

	}
	
	public function ViewStory ($story_id) {
		//Event::fire('story.view',$story_id);
		return view('postpage/story', 
		[
		 	'piclist'=> $this->PostPageInstance->getPicBasedOnSID($story_id),
		 	'story' => $this->PostPageInstance->getStoryBasedonSID($story_id),
		 	'comments' => $this->PostPageInstance->getStoryCommentBasedonSID($story_id),
		 	'isfavorited' => $this->PostPageInstance->isFavoritedBySID($story_id),
		 	'isliked' => $this->PostPageInstance->isLikedBySID($story_id),
		]);
	}
	
}
