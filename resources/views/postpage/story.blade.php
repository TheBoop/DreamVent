@extends('layouts.app')

<link rel="stylesheet" href="{{ URL::asset('css/containers.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/buttons.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/padding.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/commentWindow.css') }}">

@section('content')

<div class="contentContainer">
    <div class="pictureContainer">
        <img src="{{asset($piclist->picture_link)}}">
    </div>
    <div class="storyContainer" >
        {{$story->content}}
    </div>
</div>
<div class="buttonContainer">
    <div class="rightBox">
        @if ($isliked)
            <input type="image" src="{{asset('assets/images/arrow-up.png')}}" class="sideButton" id="unliketopButton" value ="Unlike" onclick ="return unlike()">
        @else
            <input type="image" src="{{asset('assets/images/arrow-up.png')}}" class="sideButton" id="liketopButton" value ="Like" onclick ="return like()">
        @endif

        @if ($isfavorited)       
            <input type="image" src="{{asset('assets/images/heart.png')}}" class="sideButton" id="unfavoritebuttonSpace" value ="Unfavorite" onclick ="return unfavorite()">
        @else
            <input type="image" src="{{asset('assets/images/heart.png')}}" class="sideButton" id="favoritebuttonSpace" value ="Favorite" onclick ="return favorite()">
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

<!--
<script src ="http://code.jquery.com/jquery-1.11.1.js "> </script>
<script>
    function favorite() {
        $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }});
        $.ajax({
            type:"POST",
            url: "/favoriteStory/{{$story->story_id}}",
            cache:false,
            success: function(data){
                $('#favoritebuttonSpace').attr('onclick', 'unfavorite()')
                $('#favoritebuttonSpace').val('Unfavorite');
            }
        });
        return false;
    }
    function unfavorite() {
        $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});
        $.ajax({

            type:"delete",
            url: "/unfavoriteStory/{{$story->story_id}}",
            cache:false,
            success: function(data){
                $('#unfavoritebuttonSpace').attr('onclick', 'favorite()')
                $('#unfavoritebuttonSpace').val('Favorite');
                
            }
        });
        return false;
    }


    function like() {
        $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }});
        $.ajax({
            type:"POST",
            url: "/likeStory/{{$story->story_id}}",
            cache:false,
            success: function(data){
                $('#liketopButton').attr('onclick', 'unlike()')
                $('#liketopButton').val('Unlike');
                
            }
        });
        return false;
    }
    function unlike() {
        $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});
        $.ajax({

            type:"delete",
            url: "/unlikeStory/{{$story->story_id}}",
            cache:false,
            success: function(data){
                $('#unliketopButton').attr('onclick', 'like()')
                $('#unliketopButton').val('Like');
                
            }
        });
        return false;
    }
</script> 
-->
@endsection

