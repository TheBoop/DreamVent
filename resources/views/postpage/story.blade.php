@extends('layouts.app')

<link rel="stylesheet" href="{{ URL::asset('css/containers.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/buttons.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/padding.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/commentWindow.css') }}">

@section('content')

<div class="contentContainer">
    <div class="pictureContainer">
        <img src="{{asset($piclist->picture_link)}} " width="100%" height="100%">
    </div>
    <div class="storyContainer" >
        {{$story->content}}
    </div>
</div>
<div class="buttonContainer">
    <div class="centered">
        @if ($isliked)
            <input type="image" src="{{asset('assets/images/arrow-up1.png')}}" class="sideButton" id="unliketopButton" onclick ="return unlike()">
        @else
            <input type="image" src="{{asset('assets/images/arrow-up.png')}}" class="sideButton" id="liketopButton" onclick ="return like()">
        @endif

        @if ($isfavorited)
            <input type="image" src="{{asset('assets/images/heart.png')}}" class="sideButton" id="unliketopButton" onclick ="return unfavorite()">
        @else
            <input type="image" src="{{asset('assets/images/heart.png')}}" class="sideButton" id="liketopButton" onclick ="return favorite()">
        @endif
        <a href="#comments" class="commentButton"; id="buttonSpace"></a>
    </div>
</div>

<div id="comments-modal">
  <div id="comments" class="overlay">
    <div class="popup">
        <h2>Comments</h2>
        <a class="close" href="#">x</a>
        <div class="content">
            {{$comments}}
        </div>
    </div>
  </div>
</div>

@endsection

