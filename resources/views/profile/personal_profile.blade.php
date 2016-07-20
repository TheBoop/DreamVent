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
		</form>
    </div>

    <div class="sidebar">
	    <ul class="nav nav-stacked">
		    <li class="active"><a href="/followlist">Following</a></li>
		    <li class="active"><a href="/blocklist">Blocked</a></li>
		    <li class="active"><a href="#Setting_tab">Settings</a></li>
		</ul>
    </div>
</div>

@stop
