<link rel="stylesheet" href="{{ URL::asset('css/upload.css') }}">

@extends('layouts.app')

@section('content')
<div class="main">
	<div class="block">
		@if(Session::has('success'))

		<div class="alert-box success">
			<h2>{!! Session::get('success') !!}</h2>
		</div>

		@endif

		<h1 class="title">Upload</h1>

		{!! Form::open(array('url'=>'/uploadPicture','method'=>'POST', 'files'=>true)) !!}
		
		<div class="control-group">
			<div class="controls">
				<p class="centered">
					{!! Form::file('picture') !!}

				Description:
				{!! Form::text('description') !!}
				</p>
			   <p class="errors">{!!$errors->first('image')!!}</p>

			   @if(Session::has('error'))
			   	<p class="errors">{!! Session::get('error') !!}</p>
		   	@endif
		  	</div>
		</div>

		<div id="success"> </div>
		<h1 class="title">
		{!! Form::submit('Submit', array('class'=>'send-button')) !!}
		{!! Form::close() !!}
		</h1>
	</div>
</div>
@endsection