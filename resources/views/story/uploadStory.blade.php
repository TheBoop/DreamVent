@extends('layouts.app')

<link rel="stylesheet" href="{{ URL::asset('css/upload.css') }}">

@section('content')

<div class="main">
	<div class="block">
		<!--@if(Session::has('success'))
			<div class="alert-box success">
				<h2>{!! Session::get('success') !!}</h2>
			</div>
		@endif-->

		<div class="innerblock" style="width: 70%;padding-left: 5%; padding-top:3em;">
			<img class="displayCenter" src="{{asset($picture_path)}}"> 

			<p class="centered" style="float:center">
				{!! Form::open(array('url'=>'/uploadStory/'.$picture_id,'method'=>'POST')) !!}
			</p>
			
			<p class="left"><b>Story Title:</b>
				<input type="input" name="storyTitle">
			</p>

			<p class="left">
		    	<b>Story:</b>
		    </p>

		    <p style="margin-left: 25%;
				margin-right: auto;
				width: 15em;">

			    {{ Form::textarea('storyContent') }} 
		    </p>

			<p class="left">
			    <b>Tags</b>
			    <input type="text" name="tags" onKeyPress="return disableEnterKey(event)">
			    <script>
			        var textarea = document.querySelector('input[name="tags"]');
			        textarea.addEventListener("keydown", function(event) {
			            // The key code for F2 happens to be 113
			            if (event.keyCode == 13) {
			             	replaceSelection(textarea, ",");
			             	event.preventDefault();
			            }
			        });
			        function replaceSelection(field, word) {
			            var from = field.selectionStart, to = field.selectionEnd;
			            field.value = field.value.slice(0, from) + word +
			                         field.value.slice(to);
			            // Put the cursor after the word
			            field.selectionStart = field.selectionEnd =
			             from + word.length;
			        }
			    </script>
			</p>

			<p class="errors">{!!$errors->first('story')!!}</p> <!-- I'm not sure what this line is actually for, or if I'm doing it right. -->
			@if(Session::has('error'))
			<p class="errors">{!! Session::get('error') !!}</p>
			 @endif

			<div id="success"> </div>
			<h1 class="submit">
				{!! Form::submit('Submit', array('class'=>'send-button')) !!}
				{!! Form::close() !!}
			</h1>
		</div>
	</div>
</div>

@endsection