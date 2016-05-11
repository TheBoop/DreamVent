@extends('layouts.app')
<!DOCTYPE html>
    <script src ="http://code.jquery.com/jquery-1.11.1.js "> </script>
    <script>
        function chk() {
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }});
            $.ajax({
                type:"POST",
                url: "{{ url('/favoriteStory\/'.$storyList[0]->story_id )}}",
                cache:false,
                success: function(data){
                    $('#follow').attr('onclick', 'unchk()')
                    $('#follow').val('Unfavorite');
                    
                }
            });
            return false;
        }
        function unchk() {
            $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }});
            $.ajax({

                type:"POST",
                url: "{{ url('/unfavoriteStory\/'.$storyList[0]->story_id) }}",
                cache:false,
                success: function(data){
                    $('#unfollow').attr('onclick', 'chk()')
                    $('#unfollow').val('Favorite');
                    
                }
            });
            return false;
        }
    </script>
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
                @if(isset($pictureList))
                    @if ($isFavorited[$index])
                        <form>         
                            {!! csrf_field() !!}
                            <input type="submit" id="unfollow" value ="Unfavorite" onclick ="return unchk()">
                        </form>
                        @else
                        <form>
                            {!! csrf_field() !!}
                            <input type="submit" id="follow" value ="Favorite" onclick ="return chk()">
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


