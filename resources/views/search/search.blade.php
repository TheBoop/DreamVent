@extends('layouts.app')
@section('content')
<body>
<div class="container">
    search tag
    {{Form::open(array('url' =>'/search'))}}
      {{Form::text('keyword', null, array('placeholder'=>'search by keyword'))}}
      {{Form::submit('search')}}
    {{Form::close()}}

</div>

</body>
</html>
@endsection
