
@extends('layouts.app')

<link rel="stylesheet" href="{{ URL::asset('css/containers.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/buttons.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/commentModal.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/thumbnailStory.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/fonts.css') }}">

@section('content')
<!-- Comment Modal -->
<body onload="myFunction()">
<div id="myModal" class="modal">
	<!-- Modal content -->
	<div class="modal-content">
		<div class="row">
    <span class="close">x</span>
		<div class="commentSection" id="uniqueCommentBox">  
			@foreach($comments as $comment)
				<div class="row">
					<div class="commentBox">
						<a href="/profile/{{$comment->username}}"class="userName">
							<a class="userNameFont">{{$comment->username}}</a>
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

<!-- Picture and buttons -->
<div class="row">
	<div class="contentContainer">
		<div class="pictureContainer">
			<img src="{{asset($picture->picture_link)}} " width="100%"; height="100%" >
		</div>
	</div>

	<div class="buttonContainer">
    <div class="numLikeContainer" >

        <h2 style="color:green">{{$number_of_likes}}</h2>
    </div>
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

		<a href="{{ url('/uploadStory/'.$picture->picture_id) }}" >
		 	<img src="{{asset('assets/images/document.png')}}" class="sideButton" id="buttonSpace">
		</a>

		<!-- Trigger Comment Modal -->
		<input type="image" src="{{asset('assets/images/chat.png')}} " class="sideButton" id="commentBtn">
	</div>
</div>


<!-- Picture Description -->
<div class="row">
	<div class="pictureDescriptionContainer">
		<div class="descriptionChild">
			<p class="descriptionFont">{{$picture->description}}</p>
		</div>
	</div>
</div>
	@if(count($story) != 0)
	<div class="col-md-10">
		<div class="storyGallery" >
			<div class="row-fluid">
				@foreach ($story as $index => $storyContent )

					<div class="col-md-3">
						<div class="thumbnailStory">
							<a href='/post/story/{{$story[$index]->story_id}}'>  
								<div class="fill-div">
									<div class="title">
										{{$story[$index]->title}}<br/>
									</div>
									By: {{$story[$index]->username}}
									<div class="storySample">
										{{$story[$index]->content}}
									</div>
								</div>  
							</a>  
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
	@endif
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
                                                                                                      
                $('#numoflikes').val({{$number_of_likes++}});
                                                                                                      
								
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
                                                                                                      
								$('#numoflikes').val({{$number_of_likes--}});
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
