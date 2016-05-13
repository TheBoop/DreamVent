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
                @if(isset($pictureList))
                    @if ($isFavorited[$index])
                        <form>         
                            <input type="submit" id="storyunfollow" value ="Unfavorite" onclick ="return unfollow()">
                        </form>
                        @else
                        <form>
                            <input type="submit" id="storyfollow" value ="Favorite" onclick ="return follow()">
                        </form>
                    @endif

                    @if ($isLiked[$index])
                        <form>         
                            <input type="submit" id="storyunlike" value ="Unlike" onclick ="return unlike()">
                        </form>
                        @else
                        <form>
                            <input type="submit" id="storylike" value ="Like" onclick ="return like()">
                        </form>
                    @endif
                @endif
            @endif
        @endforeach

    </div>
    {!! $pictureList->render() !!}
    @endif
</body>
</html>


@endsection
@if(isset($pictureList))
    <script src ="http://code.jquery.com/jquery-1.11.1.js "> </script>
    <script>
        function follow() {
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }});
            $.ajax({
                type:"POST",
                url: "{{ url('/favoriteStory\/'.$storyList[0]->story_id )}}",
                cache:false,
                success: function(data){
                    $('#storyfollow').attr('onclick', 'unchk()')
                    $('#storyfollow').val('Unfavorite');
                    
                }
            });
            return false;
        }
        function unfollow() {
            $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }});
            $.ajax({

                type:"POST",
                url: "{{ url('/unfavoriteStory\/'.$storyList[0]->story_id) }}",
                cache:false,
                success: function(data){
                    $('#storyunfollow').attr('onclick', 'chk()')
                    $('#storyunfollow').val('Favorite');
                    
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
                url: "{{ url('/likeStory\/'.$storyList[0]->story_id )}}",
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

                type:"POST",
                url: "{{ url('/unlikeStory\/'.$storyList[0]->story_id) }}",
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

