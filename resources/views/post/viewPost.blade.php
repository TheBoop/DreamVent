@extends('layouts.app')

@section('content')
<head> <style type="text/css">
.likeButton {
	background-color:#44c767;
	-moz-border-radius:28px;
	-webkit-border-radius:28px;
	border-radius:28px;
	border:1px solid #18ab29;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-family:Arial;
	font-size:17px;
	padding:16px 31px;
	text-decoration:none;
	text-shadow:0px 1px 0px #2f6627;
}
.likeButton:hover {
	background-color:#5cbf2a;
}
.likeButton:active {
	position:relative;
	top:1px;
  {{$picture->num_likes}}++
}
</style> </head>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">posting</div>

                <div class="panel-body">
                    <img src="{{ URL::to('/') }}{{$picture->picture_link}} " width="500" height="300"
                    
                    <div position: fixed; top 100px;>
                      <a onclick={{$picture->num_likes}}++>
                        <a href="#" class="likeButton">{{$picture->num_likes}}</a>
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
    </div>
</div>
@endsection