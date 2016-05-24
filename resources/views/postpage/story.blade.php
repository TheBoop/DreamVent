@extends('layouts.app')

<link rel="stylesheet" href="{{ URL::asset('css/containers.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/buttons.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/padding.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/commentModal.css') }}">

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
								{!! Form::open(array('url'=>'/post/story/'.$story->story_id,'method'=>'POST')) !!}
							<div class="control-group">
								<div class="controls">
									{{ Form::textarea('comment', null,['size' => '30x2']) }} 
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

<div class="row">
	<div class="contentContainer">
		<div class="pictureContainer">
			<img src="{{asset($piclist->picture_link)}}" width="100%" >
		</div>
	</div>

	<div class="buttonContainer">

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

		<!-- Trigger Comment Modal -->
		<input type="image" src="{{asset('assets/images/chat.png')}} " class="sideButton" id="commentBtn">

	</div>
</div>

<div class="row">
	<div class="storyContainer" >
		<h3 style="padding-top:0;">{{$story->title}}</h3>
		{{$story->content}}
	</div>
</div>

<script src ="http://code.jquery.com/jquery-1.11.1.js "> </script>
<script type="text/javascript" src="{{URL::to('/')}}/js/commentsBtn.js"></script>
<script>
	function like() {
		$.ajaxSetup({
				headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}});
		$.ajax({
			type:"POST",
			url: "/likeStory/{{$story->story_id}}",
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
			url: "/unlikeStory/{{$story->story_id}}",
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
			url: "/favoriteStory/{{$story->story_id}}",
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
			url: "/unfavoriteStory/{{$story->story_id}}",
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

