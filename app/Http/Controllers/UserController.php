<?php

//This controller is for testing purposes for now.

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;


class UserController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}
	
    //Test: Get display current user.
	public function CurrentUser() {
		$user = Auth::user();
		if ($user) {
			echo ($user);
		}
		else {
			echo "what user?";
		}
	}
}
