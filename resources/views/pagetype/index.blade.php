@extends('layouts.app')

@section('content')
<body>
    <div class="container">
        @foreach ($pictureList as $piclist)
            <a href="/post/picture/{{$piclist->picture_id}}">
            <img src="{{ URL::to('/') }}{{$piclist->picture_link}} ">
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
</body>
</html>
@endsection
