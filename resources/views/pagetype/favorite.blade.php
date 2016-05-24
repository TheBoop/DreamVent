<link rel="stylesheet" href="{{ URL::asset('css/browse.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/thumbnailPic.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/upload.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/fonts.css') }}">
@extends('layouts.app')
<!DOCTYPE html>
@section('content')

<body>
    <div class="container-fluid">
        @if(isset($pictureList))
        <div class="innerblock" style="width: 70%;">
            <a class="favoritePageHeader">Your Favorite Stories</a>
        </div>
        <div class="row">
            @foreach ($pictureList as $index => $piclist )
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="cell">
                    <a href="/post/picture/{{$pictureList[$index]->picture_id}}">
                        <img src="{{ URL::to('/') }}{{$piclist->picture_link}}" />
                    </a>
                    @if(isset($storyList))
                        <div class="overlay">
                            <p class="titleauthor">
                                <a href="/post/story/{{$storyList[$index]->story_id}}" class="title">
                                    {{$storyList[$index]->title}}
                                </a>
                                <br />
                                by
                                <a href="/profile/{{$storyList[$index]->username}}" class="author">
                                    {{$storyList[$index]->username}}
                                </a>
                                <p class="storypreview">
                                    {{$storyList[$index]->content}}
                                </p>
                            </p>
                        </div>
                    @endif
                </div>
                <br />
                <br />
            </div>
            @endforeach
        </div>
        {!! $pictureList->render() !!}
        @endif
    </div>
</body>

@if (isset($favpiclist))
<div class="innerblock" style="width: 70%;">
  <b class="favoritePageHeader">Your Favorite Stories</b>
</div>
<body>
    <div class="container-fluid">
        @if(isset($favpiclist))
        <div class="row">
            @foreach ($favpiclist as $index => $piclist )
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="cell">
                    <a href="/post/picture/{{$favpiclist[$index]->picture_id}}">
                        <img src="{{ URL::to('/') }}{{$piclist->picture_link}}" />
                    </a>
                </div>
                <br />
                <br />
            </div>
            @endforeach
        </div>
        {!! $favpiclist->render() !!}
        @endif
    </div>
</body>
@endif
</html>


@endsection

