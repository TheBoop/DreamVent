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


<!-- comment text area-->
<div class="about-section">
   <div class="text-content">
     <div class="span7 offset1">
        @if(Session::has('success'))
          <div class="alert-box success">
          <h2>{!! Session::get('success') !!}</h2>
          </div>
        @endif
        <div class="secure">Edit Tags</div>
            {!! Form::open(array('url'=>'/editTag/'.$story->story_id,'method'=>'POST')) !!}
         <div class="control-group">
          <div class="controls">
            <input type="input" name="tag" value ="{{$currentTag}}">
            <script>
                    var textarea = document.querySelector('input[name="tag"]');
                    textarea.addEventListener("keydown", function(event) {
                      // The key code for F2 happens to be 113
                      if (event.keyCode == 13) {
                        replaceSelection(textarea, ",");
                        event.preventDefault();
                      }
                    });
                    function replaceSelection(field, word) {
                      var from = field.selectionStart, to = field.selectionEnd;
                      field.value = field.value.slice(0, from) + word +
                                    field.value.slice(to);
                      // Put the cursor after the word
                      field.selectionStart = field.selectionEnd =
                        from + word.length;
                    }
                  </script>
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
