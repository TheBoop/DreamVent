@extends('layouts.app')
<style>
   div.sidebar {
		font-family: 'Lato';
		background-color: white;
		color:black;
		float: right; 
		width: 20%;
		border-radius: 10px;
	}

	.nav-stacked > .active > a, .nav-stacked > .active > a:hover, .nav-stacked > a:hover {
	    background-color: light-grey;
	    border-radius: 10px;
	}
</style>

@section('content')
<div style="width: 980px; margin: 0 auto; overflow: hidden;">
    <div style="float: left; width: 80%;" id="mainContent">
    	Left Column
    </div>
    <div class="sidebar">
	    <ul class="nav nav-stacked">
		    <li class="active"><a href="#tab1" data-toggle="tab" onclick="showPosts()">Posts</a></li>
		    <li class="active"><a href="#tab2" data-toggle="tab" onclick="showFollowers()">Follower</a></li>
		    <li class="active"><a href="#tab3" data-toggle="tab" onclick="showSettings()">Settings</a></li>
		</ul>
    </div>
</div>

<script>
function showPosts(){
	document.getElementById("mainContent").innerHTML = "Here are your Posts";
}
function showFollowers(){
	
}
function showSettings(){
	document.getElementById("mainContent").innerHTML = "YOU CLICKED ME!";
}
</script>
@stop
