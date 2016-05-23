<link rel="stylesheet" href="{{ URL::asset('css/upload.css') }}">

@extends('layouts.app')

@section('content')
<div class="main">
	<div class="block">
		<div class="innerblock">

			<h1 class="title">Picture Upload</h1>

			{!! Form::open(array('url'=>'/uploadPicture','method'=>'POST', 'files'=>true)) !!}
			
			<div class="control-group">
				<div class="controls">
					<p class="centered" style="margin-top: 30px; margin-bottom: 30px;">
						{!! Form::file('picture', array('style'=>'margin-left: -20px;')) !!}
					</p>
					<p class="centered" style="margin-top: 10px;">
					<b>Description:</b>
					{!! Form::text('description') !!}
					</p>

					</p>
					<p class="centered" style="margin-top: 10px;">
					<b>Tags:</b>
					{!! Form::text('tags') !!}
					</p>

			  	</div>
			</div>

			<div id="success"> </div>
			<h1 class="submit">
				{!! Form::submit('Submit', array('class'=>'send-button')) !!}
				{!! Form::close() !!}
			</h1>
		</div>
	</div>
</div>
@endsection