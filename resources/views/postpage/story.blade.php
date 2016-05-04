@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
@section('content')

<div class="container">
<img src="{{ URL::to('/') }}{{$piclist->picture_link}} ">
</div>
<!-- display story -->
{{$story->content}}
<br/>
<br/>

<!-- display comments -->
Comments for Story <br/>
@foreach ($comments as $comment)
	{{$comment->text}} <br/>
@endforeach

<!-- comment text area-->
<div class="about-section">
   <div class="text-content">
     <div class="span7 offset1">
        @if(Session::has('success'))
          <div class="alert-box success">
          <h2>{!! Session::get('success') !!}</h2>
          </div>
        @endif
        <div class="secure">Post Comment</div>
			{!! Form::open(array('url'=>'/post/story/'.$story->story_id,'method'=>'POST')) !!}
         <div class="control-group">
          <div class="controls">
			{{ Form::textarea('comment') }} 
			
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
</html>