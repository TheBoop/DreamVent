@extends('layouts.app')
@section('content')
<body>
<div class="container">
    search tag
    {{Form::open(array('url' =>'/searchtest'))}}
      {{Form::text('keyword', null, array('placeholder'=>'search by keyword'))}}
      {{Form::submit('search')}}
    {{Form::close()}}
    @foreach ($pictureList as $piclist)
        <img src="{!! $piclist->picture_link !!}">
        <a href="{{ url('/post/picture/'.$piclist->picture_id) }}">
            <button 
                class="btn btn-primary">View Post Page
            </button>
        </a>
        <a href="{{ url('/uploadStory/'.$piclist->picture_id) }}">
            <button 
                class="btn btn-primary">Make your Story
            </button>
        </a>
    @endforeach
</div>
{!! $pictureList->links() !!}

</body>
</html>
@endsection
