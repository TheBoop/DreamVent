@extends('layouts.app')

@section('content')

<body>
    <div class="container">
     @if(isset($pictureList))
        @foreach ($pictureList as $index => $piclist )
            <a href="/post/story/{{$storyList[$index]->story_id}}">
                <img src="{{ URL::to('/') }}{{$piclist->picture_link}} ">
            </a>
            @if(isset($storyList))
                Story: {{$storyList[$index]->content}}
                <div></div>
                Story created by: {{$storyList[$index]->username}}
            @endif
        @endforeach

    </div>
    {!! $pictureList->render() !!}
    @endif
</body>
</html>
@endsection
