<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers


class ProfileController.php{
	public function show($username)
	{
		return view('profile.profile_home',['user' => Auth::user() ]);
	}

	public function index(){

		return view('Hello');
	}
}