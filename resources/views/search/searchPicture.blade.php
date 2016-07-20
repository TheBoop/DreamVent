<link rel="stylesheet" href="{{ URL::asset('css/search.css') }}">

@extends('layouts.app')
@section('content')
<body>
THIS FILE IS searchPicture.blade.php IN THE search FOLDER. IT IS FOR TESTING PICTURE SEARCH.
    <div class="search">
        Find pictures by tag
        {{Form::open(array('url' =>'/searchPicture'))}}
            {{Form::text('keyword', null, array('class'=>'searchbox', 'placeholder'=>'search by tag (comma separated)'))}}
            {{Form::submit('search')}}
        {{Form::close()}}
    </div>
    <br />
    <div class="search">
        Find other users
        {{Form::open(array('url' =>'/searchUser'))}}
            {{Form::text('keyword', null, array('class'=>'searchbox', 'placeholder'=>'search by username'))}}
            {{Form::submit('search')}}
        {{Form::close()}}
    </div>


</body>
</html>
@endsection
