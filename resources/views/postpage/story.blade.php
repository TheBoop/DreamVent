@extends('layouts.app')

<link rel="stylesheet" href="{{ URL::asset('css/containers.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/buttons.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/padding.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/commentWindow.css') }}">

@section('content')

<div class="container">
    <div class="row-fluid">
        <div class="col-md-9 col-md-offset-1">
            <div class="pictureContainer">
                <img src="{{asset($piclist->picture_link)}} ">  
            </div>
            <div class="storyContainer" >
                {{$story->content}}
            </div>
        </div>
        <div class-"col-md-2">
            <div class="rightBox">
                @if ($isliked)
                    <form>         
                    <input type="submit" class="likeButton" id="unliketopButton" value ="Unlike" onclick ="return unlike()">
                    </form>
                @else
                    <form>
                    <input type="submit" class="likeButton" id="liketopButton" value ="Like" onclick ="return like()">
                    </form>
                @endif
                @if ($isfavorited)
                    <form>         
                    <input type="submit" class="uploadButton" id="unfavoritebuttonSpace" value ="Unfavorite" onclick ="return unfavorite()">
                    </form>
                @else
                    <form>
                    <input type="submit" class="uploadButton" id="favoritebuttonSpace" value ="Favorite" onclick ="return favorite()">
                    </form>
                @endif
                <a href="#comments" class="commentButton"; id="buttonSpace"></a>
            </div>
        </div>
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
