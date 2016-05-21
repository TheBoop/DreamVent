@extends('layouts.app')
@section('content')
<body>
<div class="container">
    search user here. Currently only searches first word; i.e. searching <br />
	for 'test, foobar' without quotation marks returns results containing 'test'.
    {{Form::open(array('url' =>'/searchUser'))}}
      {{Form::text('keyword', null, array('placeholder'=>'search by keyword'))}}
      {{Form::submit('search')}}
    {{Form::close()}}

</div>

</body>
</html>
@endsection
