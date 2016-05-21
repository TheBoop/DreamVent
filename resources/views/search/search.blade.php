<link rel="stylesheet" href="{{ URL::asset('css/search.css') }}">

@extends('layouts.app')
@section('content')
<body>

    <div class="search">
        Find stories and pictures by tag (comma separated)
        {{Form::open(array('url' =>'/search'))}}
            {{Form::text('keyword', null, array('class'=>'searchbox', 'placeholder'=>'search by tag'))}}
            {{Form::submit('search')}}
        {{Form::close()}}
    </div>

</body>
</html>
@endsection
