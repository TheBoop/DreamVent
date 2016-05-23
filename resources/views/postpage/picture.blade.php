@extends('layouts.app')

<link rel="stylesheet" href="{{ URL::asset('css/containers.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/buttons.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/padding.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/commentModal.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/thumbnailStory.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/storyGallery.css') }}">

@section('content')
<!-- Comment Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="row">
      <div class="col-md-12">
        <span class="close">x</span>
      </div>
    <div class="commentSection">  
      @foreach($comments as $comment)
        <div class="col-md-12">
          <div class="commentBox">
            <h6 class="date">{{$comment->created_at}}</h6>
            <h5 class="comment">{{$comment->text}}</h5>
          </div>
        </div>
      @endforeach
    </div>

    <div class="submitComment">
      <!-- comment text area-->
      <div class="about-section">
         <div class="text-content">
           <div class="span7 offset1">
              @if(Session::has('success'))
                <div class="alert-box success">
                <h2>{!! Session::get('success') !!}</h2>
                </div>
              @endif
              <div class="post">Post Comment</div>
      			{!! Form::open(array('url'=>'/post/picture/'.$picture->picture_id,'method'=>'POST')) !!}
               <div class="control-group">
                <div class="controls">
      			{{ Form::textarea('comment',null,['size' => '30x2']) }} 
      			
      	  <p class="errors">{!!$errors->first('story')!!}</p> <!-- I'm not sure what this line is actually for, or if I'm doing it right. -->
      	@if(Session::has('error'))
      	<p class="errors">{!! Session::get('error') !!}</p>
      	@endif
              </div>
              </div>
              <div id="success"> </div>
            {!! Form::submit('Submit', array('class'=>'submitButton')) !!}
            {!! Form::close() !!}
            </div>
         </div>
      </div>
    </div>
    </div>
  </div>
</div>

<!-- Picture and buttons -->
<div class="contentContainer">
  <div class="pictureContainer">
    <img src="{{asset($picture->picture_link)}} " width="100%" height="100%">
  </div>
</div>

<div class="buttonContainer">
    <div class="centered">
      <a href="#" class="likeButton"; id="topButton">Likes</a>
      <a href="{{ url('/uploadStory/'.$picture->picture_id) }}" class="uploadButton"; id="buttonSpace">Favorite</a>

      <!-- Trigger Comment Modal -->
      <input type="image" src="{{asset('assets/images/chat.png')}} " class="commentBtn" id="myBtn">

    </div>
</div>

<!-- Picture Description -->

  <div class="row">
    <div class="col-md-10">
      <div class="pictureDescriptionContainer">
        <div class="descriptionChild">
          <p class="descriptionFont">{{$picture->description}}</p>
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


<script type="text/javascript" src="{{URL::to('/')}}/js/commentsBtn.js"></script>

@endsection
