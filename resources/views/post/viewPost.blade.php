@extends('layouts.app')

@section('content')
<head> <style type="text/css">

.likeButton {
	-moz-box-shadow: 0px 10px 14px -7px #3aad1a;
	-webkit-box-shadow: 0px 10px 14px -7px #3aad1a;
	box-shadow: 0px 10px 14px -7px #3aad1a;
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #44c767), color-stop(1, #55db0d));
	background:-moz-linear-gradient(top, #44c767 5%, #55db0d 100%);
	background:-webkit-linear-gradient(top, #44c767 5%, #55db0d 100%);
	background:-o-linear-gradient(top, #44c767 5%, #55db0d 100%);
	background:-ms-linear-gradient(top, #44c767 5%, #55db0d 100%);
	background:linear-gradient(to bottom, #44c767 5%, #55db0d 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#44c767', endColorstr='#55db0d',GradientType=0);
	background-color:#44c767;
	-moz-border-radius:8px;
	-webkit-border-radius:8px;
	border-radius:8px;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-family:Arial;
	font-size:20px;
	font-weight:bold;
	padding:13px 32px;
	text-decoration:none;
	text-shadow:0px 1px 0px #2f6627;
}
.likeButton:hover {
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #55db0d), color-stop(1, #44c767));
	background:-moz-linear-gradient(top, #55db0d 5%, #44c767 100%);
	background:-webkit-linear-gradient(top, #55db0d 5%, #44c767 100%);
	background:-o-linear-gradient(top, #55db0d 5%, #44c767 100%);
	background:-ms-linear-gradient(top, #55db0d 5%, #44c767 100%);
	background:linear-gradient(to bottom, #55db0d 5%, #44c767 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#55db0d', endColorstr='#44c767',GradientType=0);
	background-color:#55db0d;
}
.likeButton:active {
	position:relative;
	top:1px;
}

.uploadButton {
	-moz-box-shadow: 0px 10px 14px -7px #276873;
	-webkit-box-shadow: 0px 10px 14px -7px #276873;
	box-shadow: 0px 10px 14px -7px #276873;
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #599bb3), color-stop(1, #408c99));
	background:-moz-linear-gradient(top, #599bb3 5%, #408c99 100%);
	background:-webkit-linear-gradient(top, #599bb3 5%, #408c99 100%);
	background:-o-linear-gradient(top, #599bb3 5%, #408c99 100%);
	background:-ms-linear-gradient(top, #599bb3 5%, #408c99 100%);
	background:linear-gradient(to bottom, #599bb3 5%, #408c99 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#599bb3', endColorstr='#408c99',GradientType=0);
	background-color:#599bb3;
	-moz-border-radius:8px;
	-webkit-border-radius:8px;
	border-radius:8px;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-family:Arial;
	font-size:20px;
	font-weight:bold;
	padding:13px 32px;
	text-decoration:none;
	text-shadow:0px 1px 0px #3d768a;
}
.uploadButton:hover {
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #408c99), color-stop(1, #599bb3));
	background:-moz-linear-gradient(top, #408c99 5%, #599bb3 100%);
	background:-webkit-linear-gradient(top, #408c99 5%, #599bb3 100%);
	background:-o-linear-gradient(top, #408c99 5%, #599bb3 100%);
	background:-ms-linear-gradient(top, #408c99 5%, #599bb3 100%);
	background:linear-gradient(to bottom, #408c99 5%, #599bb3 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#408c99', endColorstr='#599bb3',GradientType=0);
	background-color:#408c99;
}
.uploadButton:active {
	position:relative;
	top:1px;
}

</style> </head>
<?php
var_dump($picture->num_likes);
?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">posting</div>
                	<div class="panel-body">
                	    <img src="{{ URL::to('/') }}{{$picture->picture_link}} "
                	    
                	    <div position: fixed; width: 300px; height: 60px;>
                	      <a>
                	        <a href="#" class="likeButton" ; size: fixed>{{$picture->num_likes}}</a>
                	      </a>
                	      
                	      <a>
                	        <a href="{{ url('/uploadStory/'.$picture->picture_id) }}" class="uploadButton">Post</a>
                	      </a>
                	    
                	    </div>
                	    
                	    <div class="panel panel-default">
                	      <div class="panel-heading">description</div>
                	        {{$picture->description}}
        	    		</div>
        	</div>
        </div>
    </div>
</div>
@endsection