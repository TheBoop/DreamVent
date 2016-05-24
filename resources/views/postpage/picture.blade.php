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
							<a href="/profile/{{$comment->username}}"class="userName">
								{{$comment->username}}
							</a>
							<h5 class="comment">{{$comment->text}}</h5>
							<a class="date">{{$comment->created_at}}</a>
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
</div>

<!-- Picture and buttons -->
<div class="contentContainer">
	<div class="pictureContainer">
		<img src="{{asset($picture->picture_link)}} " width="100%" height="100%">
	</div>
</div>

<div class="buttonContainer">
	<div class="row">
		<div class="col-md-12">
			@if ($isliked)
				<input type="image" src="{{asset('assets/images/arrow-up1.png')}}" class="sideButton" id="unliketopButton" value ="Unlike" onclick ="return unlike()">
			@else
				<input type="image" src="{{asset('assets/images/arrow-up.png')}}" class="sideButton" id="liketopButton" value ="Like" onclick ="return like()">
			@endif
		</div>

		<div class="col-md-12">
			@if ($isfavorited)  
					<input type="image" src="{{asset('assets/images/heart1.png')}}" class="sideButton" id="unfavoritebuttonSpace" value ="Unfavorite" onclick ="return unfavorite()">
				@else
					 <input type="image" src="{{asset('assets/images/heart.png')}}" class="sideButton" id="favoritebuttonSpace" value ="Favorite" onclick ="return favorite()">
			@endif
		</div>

		<div class="col-md-12">
			<a href="{{ url('/uploadStory/'.$picture->picture_id) }}" >
	          	<img src="{{asset('assets/images/document.png')}}" class="sideButton" id="buttonSpace">
	        </a>
	    </div>

	    <div class="col-md-12">
			<!-- Trigger Comment Modal -->
			<input type="image" src="{{asset('assets/images/chat.png')}} " class="sideButton" id="commentBtn">
		</div>
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

<script type="text/javascript" src="{{URL::to('/')}}/js/commentsBtn.js"></script>

@endsection
