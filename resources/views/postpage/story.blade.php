@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
@section('content')

<div class="container">
<img src="{{ URL::to('/') }}{{$piclist->picture_link}} ">
</div>
<!-- display story -->
{{$story->content}}
<br/>
<br/>
@if(isset($piclist))
    @if ($isfavorited)
    <form>         
        <input type="submit" id="storyfollow" value ="Unfavorite" onclick ="return unfavorite()">
    </form>
    @else
    <form>
        <input type="submit" id="storyfollow" value ="Favorite" onclick ="return favorite()">
    </form>
    @endif
    @if ($isliked)
    <form>         
        <input type="submit" id="storyunlike" value ="Unlike" onclick ="return unlike()">
    </form>
    @else
    <form>
        <input type="submit" id="storylike" value ="Like" onclick ="return like()">
    </form>
    @endif
@endif
<!-- display comments -->
Comments for Story <br/>
@foreach ($comments as $comment)
	{{$comment->text}} <br/>
@endforeach

<!-- comment text area-->
<div class="about-section">
   <div class="text-content">
     <div class="span7 offset1">
        @if(Session::has('success'))
          <div class="alert-box success">
          <h2>{!! Session::get('success') !!}</h2>
          </div>
        @endif
        <div class="secure">Post Comment</div>
			{!! Form::open(array('url'=>'/post/story/'.$story->story_id,'method'=>'POST')) !!}
         <div class="control-group">
          <div class="controls">
			{{ Form::textarea('comment') }} 
			
	  <p class="errors">{!!$errors->first('story')!!}</p> <!-- I'm not sure what this line is actually for, or if I'm doing it right. -->
	@if(Session::has('error'))
	<p class="errors">{!! Session::get('error') !!}</p> 
	@endif
        </div>
        </div>
        <div id="success"> </div>
      {!! Form::submit('Submit', array('class'=>'send-btn')) !!}
      {!! Form::close() !!}
      </div>
   </div>
</div>

@endsection
</html>


@if(isset($piclist))
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
                    $('#storyfollow').attr('onclick', 'unfavorite()')
                    $('#storyfollow').val('Unfavorite');
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
                    $('#storyfollow').attr('onclick', 'favorite()')
                    $('#storyfollow').val('Favorite');
                    
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
                    $('#storylike').attr('onclick', 'unlike()')
                    $('#storylike').val('Unlike');
                    
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
                    $('#storyunlike').attr('onclick', 'like()')
                    $('#storyunlike').val('Like');
                    
                }
            });
            return false;
        }
    </script>
@endif

