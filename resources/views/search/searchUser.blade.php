<link rel="stylesheet" href="{{ URL::asset('css/search.css') }}">

@extends('layouts.app')
@section('content')
<body>
    <div class="search">
        Find other users (comma separated)
        {{Form::open(array('url' =>'/searchUser'))}}
            {{Form::text('keyword', null, array('class'=>'searchbox', 'placeholder'=>'search by username'))}}
            {{Form::submit('search')}}
        {{Form::close()}}
    </div>

</div>

</body>
</html>
@endsection
