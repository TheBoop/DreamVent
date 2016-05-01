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