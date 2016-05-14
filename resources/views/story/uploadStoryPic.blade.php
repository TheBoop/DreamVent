@extends('layouts.app')

<html lang="en">
@section('content')

<div class="about-section">
   <div class="text-content">
     <div class="span7 offset1">
        @if(Session::has('success'))
            <div class="alert-box success">
                <h2>{!! Session::get('success') !!}</h2>
            </div>
        @endif
        <div class="secure">Upload form</div>
            {!! Form::open(array('url'=>'/uploadStoryPic','method'=>'POST', 'files'=>true)) !!}
                <div class="control-group">
                <div class="controls">
                    {!! Form::file('picture') !!}
                    Description:
                    {!! Form::text('description') !!}
                    <p class="errors">{!!$errors->first('image')!!}</p>
                    @if(Session::has('error'))
                        <p class="errors">{!! Session::get('error') !!}</p>
                    @endif
                </div>
                </div>
                {!! Form::open(array('url'=>'/uploadStoryPic','method'=>'POST')) !!}
                Story:
                {{ Form::textarea('storyContent') }} 
        <div id="success"> </div>
      {!! Form::submit('Submit', array('class'=>'send-btn')) !!}
      {!! Form::close() !!}
      </div>
   </div>
</div>
@endsection
</html>