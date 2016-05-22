@extends('layouts.app')

<link rel="stylesheet" href="{{ URL::asset('css/containers.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/buttons.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/padding.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/commentWindow.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/thumbnailStory.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/storyGallery.css') }}">

@section('content')


<!-- Picture and buttons -->
<dic class="container">
  <div class="row-fluid">
    <div class="col-md-9 col-md-offset-1">
      <div class="pictureContainer">
        <img src="{{asset($picture->picture_link)}} " width="100%" height="100%">
      </div>
    </div>
    <div class="col-md-2 ">
      <div class="rightBox">
        <a href="#" class="likeButton"; id="topButton">Likes</a>
        <a href="{{ url('/uploadStory/'.$picture->picture_id) }}" class="uploadButton"; id="buttonSpace">Favorite</a>
        <a href="#comments" class="commentButton"; id="buttonSpace"></a>
      </div>
    </div>
  </div>
</div>

<!-- Story Gallery -->
<?php
  static $storyCount=0;
?>
<div class="container">
  <div class="row-fluid">
    <div class="storyGallery" >
      @foreach ($story as $story)
        <?php switch ($storyCount):
          case 0: ?>
            <div class="col-md-3">
              <div class="thumbnailStory">
                <a href='/post/story/{{$story->story_id}}'>  
                  <div class="fill-div">
                    {{$story->title}}<br/>
                    By: {{$story->username}}
                  </div>  
                </a>  
              </div>
            </div>
            <?php break; ?>
          <?php case 1: ?>
          <?php case 2: ?>
          <?php case 3: ?>
            <div class="col-md-3">
              <div class="thumbnailStory">
                <a href='/post/story/{{$story->story_id}}'>  
                  <div class="fill-div">
                    {{$story->title}}<br/>
                    By: {{$story->username}}
                  </div>  
                </a>  
              </div>
            </div>
            <?php 
                if($storyCount==3)
                  $storyCount=-1;
            ?>  
            <?php break; ?>
        <?php endswitch ?>  
        <?php $storyCount++ ?>  
      @endforeach
    </div>
  </div>
</div>

<!-- Comment Modal -->
<div id="comments" class="overlay">
	<div class="popup">
		<h2>Comments</h2>
		<a class="close" href="#">x</a>
		<div class="content">
			@foreach ($comments as $comment)
        {{$comment->content}} <br/>
      @endforeach
		</div>
	</div>
</div>
@endsection
