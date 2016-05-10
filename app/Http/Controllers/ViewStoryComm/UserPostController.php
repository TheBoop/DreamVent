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
			 'story_ids' => $this->PostPageInstance->getStoryIDsBasedOnPID($picture_id),
			 'comments' => $this->PostPageInstance->getPicCommentBasedonPID($picture_id)
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
		 'comments' => $this->PostPageInstance->getStoryCommentBasedonSID($story_id)
		]);

	}
}
