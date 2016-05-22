@extends('layouts.app')
<link rel="stylesheet" href="{{ URL::asset('css/upload.css') }}">

<html lang="en">
@section('content')
<div class="main">
  	<div class="block">
	    @if(Session::has('success'))
	        <div class="alert-box success">
	            <h2>{!! Session::get('success') !!}</h2>
	        </div>
	    @endif
	    <div class="innerblock" style="width: 70%;">
	   		<h1 class="title">Picture+Story Upload</h1>
	        {!! Form::open(array('url'=>'/uploadStoryPic','method'=>'POST', 'files'=>true)) !!}
		    <p class="centered" style="margin-top: 30px; margin-bottom: 30px;">
				{!! Form::file('picture', array('style'=>'margin-left: -20px;')) !!}
			</p>

			<p class="left">
				<b >Image Description:</b>
				{!! Form::text('description') !!}
			</p>

			<p class="left">
		        <b>Story Title:</b>
		        <input type="text" name="title">
		    </p>

			<!--@if(Session::has('error'))
				<p class="errors">{!!$errors->first('image')!!}</p>
			    <p class="errors">{!! Session::get('error') !!}</p>
			@endif -->

		    {!! Form::open(array('url'=>'/uploadStoryPic','method'=>'POST')) !!}
		    <p class="left">
		    	<b>Story:</b>
		    </p>

		    <p style="margin-left: 25%;
				margin-right: auto;
				width: 15em;">

			    {{ Form::textarea('storyContent') }} 
		    </p>

			<p class="left">
			    <b>Tags:</b>
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
			<h1 class="submit">
				{!! Form::submit('Submit', array('class'=>'send-button')) !!}
				{!! Form::close() !!}
			</h1>
	    </div>
    	<div id="success"> </div>
  	</div>
</div>

@endsection
</html>

