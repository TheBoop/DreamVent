@extends('layouts.app')

<link rel="stylesheet" href="{{ URL::asset('css/containers.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/buttons.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/padding.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/commentWindow.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/thumbnailStory.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/storyGallery.css') }}">

@section('content')


<!-- Picture and buttons -->
<dic class="contentContainer">
  <div class="pictureContainer">
    <img src="{{asset($picture->picture_link)}} " width="100%" height="100%">
  </div>
</div>

<div class="buttonContainer">
    <div class="centered">
      @if ($isliked)
        <input type="image" src="{{asset('assets/images/arrow-up1.png')}}" class="sideButton" id="unliketopButton" value ="Unlike" onclick ="return unlike()">
      @else
        <input type="image" src="{{asset('assets/images/arrow-up.png')}}" class="sideButton" id="liketopButton" value ="Like" onclick ="return like()">
      @endif

        @if ($isfavorited)  
            <input type="image" src="{{asset('assets/images/heart1.png')}}" class="sideButton" id="unfavoritebuttonSpace" value ="Unfavorite" onclick ="return unfavorite()">
          @else
             <input type="image" src="{{asset('assets/images/heart.png')}}" class="sideButton" id="favoritebuttonSpace" value ="Favorite" onclick ="return favorite()">
        @endif

        <a href="{{ url('/uploadStory/'.$picture->picture_id) }}" id="buttonSpace">
          <img src="{{asset('assets/images/document.png')}}" class="sideButton">
        </a>

        <a href="#comments" class="commentButton"; id="buttonSpace"></a>
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

<script src ="http://code.jquery.com/jquery-1.11.1.js "> </script>
<script>
    function like() {
        $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }});
        $.ajax({
            type:"POST",
            url: "/likePicture/{{$picture->picture_id}}",
            cache:false,
            success: function(data){
                $('#liketopButton').attr('onclick', 'unlike()')
                $('#liketopButton').attr('src', '{{asset('assets/images/arrow-up1.png')}}')
                $('#liketopButton').val('Unlike');
                $('#unliketopButton').attr('onclick', 'unlike()')
                $('#unliketopButton').attr('src', '{{asset('assets/images/arrow-up1.png')}}')
                $('#unliketopButton').val('Unlike');
                
            }
        });
        return false;
    }
    function unlike() {
        $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});
        $.ajax({

            type:"delete",
            url: "/unlikePicture/{{$picture->picture_id}}",
            cache:false,
            success: function(data){
                $('#liketopButton').attr('onclick', 'like()')
                $('#liketopButton').attr('src', '{{asset('assets/images/arrow-up.png')}}')
                $('#liketopButton').val('Like');
                $('#unliketopButton').attr('onclick', 'like()')
                $('#unliketopButton').attr('src', '{{asset('assets/images/arrow-up.png')}}')
                $('#unliketopButton').val('Like');
                
            }
        });
        return false;
    }
    function favorite() {
        $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }});
        $.ajax({
            type:"POST",
            url: "/favoritePicture/{{$picture->picture_id}}",
            cache:false,
            success: function(data){
                $('#favoritebuttonSpace').attr('onclick', 'unfavorite()')
                $('#favoritebuttonSpace').attr('src', '{{asset('assets/images/heart1.png')}}')
                $('#favoritebuttonSpace').val('Unfavorite');
                $('#unfavoritebuttonSpace').attr('onclick', 'unfavorite()')
                $('#unfavoritebuttonSpace').attr('src', '{{asset('assets/images/heart1.png')}}')
                $('#unfavoritebuttonSpace').val('Unfavorite');
            }
        });
        return false;
    }
    function unfavorite() {
        $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});
        $.ajax({

            type:"delete",
            url: "/unfavoritePicture/{{$picture->picture_id}}",
            cache:false,
            success: function(data){
                $('#unfavoritebuttonSpace').attr('onclick', 'favorite()')
                $('#unfavoritebuttonSpace').val('Favorite');
                $('#unfavoritebuttonSpace').attr('src', '{{asset('assets/images/heart.png')}}')
                $('#favoritebuttonSpace').attr('onclick', 'favorite()')
                $('#favoritebuttonSpace').val('Favorite');
                $('#favoritebuttonSpace').attr('src', '{{asset('assets/images/heart.png')}}')
                
            }
        });
        return false;
    }
</script> 
@endsection
