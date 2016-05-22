<link rel="stylesheet" href="{{ URL::asset('css/browse.css') }}">

@extends('layouts.app')
<!DOCTYPE html>
@section('content')

<body>
    <div class="container-fluid">
     @if(isset($pictureList))
        <div class="row">
            @foreach ($pictureList as $index => $piclist )
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="cell">
                        <a href="/post/picture/{{$pictureList[$index]->picture_id}}">
                            <img src="{{ URL::to('/') }}{{$piclist->picture_link}}" />
                        </a>
                        @if(isset($storyList))
                            <p class="titleauthor">
                                <a href="/post/story/{{$storyList[$index]->story_id}}" class="title">
                                    {{$storyList[$index]->title}}
                                </a>
                                <br />
                                by
                                <a href="/post/story/{{$storyList[$index]->author_id}}" class="author">
                                    {{$storyList[$index]->username}}
                                </a>
                            </p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    {!! $pictureList->render() !!}
    @endif
    </div>
</body>
</html>


@endsection
