@extends('layouts.app')

<link rel="stylesheet" href="{{ URL::asset('css/containers.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/buttons.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/padding.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/commentWindow.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/thumbnailStory.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/storyGallery.css') }}">

@section('content')

<div class="rightBox">
<a href="#" class="likeButton"; id="topButton">Likes</a>

<a href="{{ url('/uploadStory/'.$picture->picture_id) }}" class="uploadButton"; id="buttonSpace">Favorite</a>

<a href="#comments" class="commentButton"; id="buttonSpace"></a>

</div>

<div class="row-fluid">
<div class="pictureContainer">
    <img src="{{asset($picture->picture_link)}} " width="780" height="380">
    
    <div class="storyGallery" >
      @foreach ($story as $story)
        <div class="thumbnailStory">
          <a href='/post/story/{{$story->story_id}}'>ok</a>
        </div>
      @endforeach
    </div>
</div>
</div>

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
