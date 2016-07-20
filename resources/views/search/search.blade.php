<link rel="stylesheet" href="{{ URL::asset('css/search.css') }}">

@extends('layouts.app')
@section('content')
<body>
    <div class="search" id="tagSearch">
        Find stories
        {{Form::open(array('url' =>'/search'))}}
            {{Form::text('keyword', null, array('class'=>'searchbox', 'placeholder'=>'search by tag (comma separated)'))}}
            {{Form::submit('search')}}
        {{Form::close()}}
    </div>
    <br />
    <div class="search" id="pictureSearch">
        Find pictures
        {{Form::open(array('url' =>'/searchPicture'))}}
            {{Form::text('keyword', null, array('class'=>'searchbox', 'placeholder'=>'search by pictures'))}}
            {{Form::submit('search')}}
        {{Form::close()}}
    </div>
    <br />
    <div class="search" id="userSearch">
        Find other users
        {{Form::open(array('url' =>'/searchUser'))}}
            {{Form::text('keyword', null, array('class'=>'searchbox', 'placeholder'=>'search by username'))}}
            {{Form::submit('search')}}
        {{Form::close()}}
    </div>
</body>

</html>
@endsection
