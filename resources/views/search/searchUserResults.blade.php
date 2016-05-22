@extends('layouts.app')
<link rel="stylesheet" href="{{ URL::asset('css/search.css') }}">

@section('content')

<style>
.usercell {
    position: relative;
    padding: 5px;
    width: 250px;
    max-height: 300px;
    border-radius: 10px;
    background: rgba(211, 211, 211, 0.5);
    text-align: center;
    font-size: 20;
    font-weight: bold;
}
.usercell:hover {
}
</style>

<body>
    @if(isset($users))
    @foreach ($users as $index => $user )
    <div class="usercell">
        <a href="/profile/{{$user->username}}">
            {{$user->username}}
        </a>
    </div>
    <p />
    @endforeach
    @endif
</body>
</html>

@endsection
