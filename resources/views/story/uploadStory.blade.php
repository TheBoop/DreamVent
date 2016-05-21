@extends('layouts.app')

@section('content')

@if ($picture_path != NULL)
	
<img class="img-rounded"
     src="{{asset($picture_path)}}"> 
</img>
@endif


<div class="about-section">
   <div class="text-content">
     <div class="span7 offset1">
        @if(Session::has('success'))
          <div class="alert-box success">
          <h2>{!! Session::get('success') !!}</h2>
          </div>
        @endif
        <div class="secure">Upload form</div>
		@if ($picture_path != NULL)
			{!! Form::open(array('url'=>'/uploadStory/'.$picture_id,'method'=>'POST')) !!}
		@else
			{!! Form::open(array('url'=>'/uploadStory','method'=>'POST')) !!}
		@endif
		
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
   </div>
</div>
@endsection