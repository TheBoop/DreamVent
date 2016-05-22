@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ URL::asset('css/containers.css') }}">

<div class="everything">
	<div class="centered" style="float:center">
		<img class="img-rounded"
	    	src="{{asset($picture_path)}}"> 
	</div>

	@if(Session::has('success'))
	<div class="alert-box success">
		<h2>{!! Session::get('success') !!}</h2>
	</div>
	@endif
	<div class="secure">Upload form</div>

	{!! Form::open(array('url'=>'/uploadStory/'.$picture_id,'method'=>'POST')) !!}

	Story Title:
	<input type="input" name="storyTitle">
	<div class="control-group">
		<div class="controls">
	    	{{ Form::textarea('storyContent') }} 
	        <div>
	            Tags
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
	        </div>

	    	<p class="errors">{!!$errors->first('story')!!}</p> <!-- I'm not sure what this line is actually for, or if I'm doing it right. -->
	    	@if(Session::has('error'))
	    	<p class="errors">{!! Session::get('error') !!}</p>
	        @endif
	    </div>
	</div>
	<div id="success"> </div>
	{!! Form::submit('Submit', array('class'=>'send-btn')) !!}
	{!! Form::close() !!}
</div>
        
@endsection