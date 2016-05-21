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
    	<form id="accountForm" method="post" class="form-horizontal">
		    <div class="tab-content">
		        <div class="tab-pane active" id="Setting_tab">
		            <div class="form-group">
		                <label class="col-xs-3 control-label">Full name</label>
		                <div class="col-xs-5">
		                    <input type="text" class="form-control" name="fullName" />
		                </div>
		            </div>

		            <div class="form-group">
		                <label class="col-xs-3 control-label">Company</label>
		                <div class="col-xs-5">
		                    <input type="text" class="form-control" name="company" />
		                </div>
		            </div>

		            <div class="form-group">
		                <label class="col-xs-3 control-label">Job title</label>
		                <div class="col-xs-5">
		                    <input type="text" class="form-control" name="jobTitle" />
		                </div>
		            </div>
		        </div>
		    </div>

			<div class="tab-content">
		        <div class="tab-pane active" id="Follower_tab">
		            <div class="form-group">
		                <label class="col-xs-3 control-label">Full name</label>
		                <div class="col-xs-5">
		                    <input type="text" class="form-control" name="fullName" />
		                </div>
		            </div>

		            <div class="form-group">
		                <label class="col-xs-3 control-label">Company</label>
		                <div class="col-xs-5">
		                    <input type="text" class="form-control" name="company" />
		                </div>
		            </div>

		            <div class="form-group">
		                <label class="col-xs-3 control-label">Job title</label>
		                <div class="col-xs-5">
		                    <input type="text" class="form-control" name="jobTitle" />
		                </div>
		            </div>
		        </div>
		    </div>

		    <div class="form-group" style="margin-top: 15px;">
		        <div class="col-xs-5 col-xs-offset-3">
		            <button type="submit" class="btn btn-default">Validate</button>
		        </div>
		    </div>
		</form>
    </div>

    <div class="sidebar">
	    <ul class="nav nav-stacked">
		    <li class="active"><a href="#Posts_tab" data-toggle="tab">Posts</a></li>
		    <li class="active"><a href="#Follower_tab" data-toggle="tab" >Follower</a></li>
		    <li class="active"><a href="#Setting_tab" data-toggle="tab">Settings</a></li>
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
