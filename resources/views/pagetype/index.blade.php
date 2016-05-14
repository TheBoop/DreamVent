@extends('layouts.app')
<!DOCTYPE html>
@section('content')

<body>
    <div class="container">
     @if(isset($pictureList))
        @foreach ($pictureList as $index => $piclist )
            <a href="/post/picture/{{$pictureList[$index]->picture_id}}">
                <img src="{{ URL::to('/') }}{{$piclist->picture_link}} ">
            </a>
            @if(isset($storyList))
            <a href="/post/story/{{$storyList[$index]->story_id}}">
                Story Content: {{$storyList[$index]->content}}
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