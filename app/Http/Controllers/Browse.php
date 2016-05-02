<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Pagination\Environment as Paginator;

use App\Http\Requests;

//Eloquent Models
use App\Story; 
use App\Picture; 
use App\User as User;

class Browse extends Controller
{
    public function defaultBrowse () {
		//Paginator::setPageName('Pictures');
		$pictures = Picture::paginate(3, ['*'], 'Pictures');
		
		//Paginator::setPageName('Stories');
		$stories = Story::paginate(10, ['*'], 'Stories');
		
		return view('browse/browse', 
			['pictures' => $pictures,
			 'stories' => $stories]);
	}
	
	public function defaultBrowseUser() {
		//$users = User::->paginate(3);//->orderBy('created_at', 'desc')->get();
		$users = NULL;
		return view('placeholder', ['users' => $users]);
	}
}
