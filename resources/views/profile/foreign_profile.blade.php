@extends('layouts.app')
<link rel="stylesheet" href="{{ URL::asset('css/browse.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/thumbnailPic.css') }}">
<style>
.userbar {
    padding: 5px;
    width: 100%;
    border-top-right-radius: 10px;
    border-top-left-radius: 10px;
    background: rgba(211, 211, 211,1);
}

.userpost{
    background-color:white;
    padding-top:6em;
    border-bottom-right-radius: 10px;
    border-bottom-left-radius: 10px;
}
h1 {
    font-weight: bold;
}
h3 {
    font-style: italic;
    opacity: 0.6;
}
.followblock {
    margin: auto;
    margin-top: 20px;
    text-align: right;
}
.userbuttons {
    background-color: rgb(0, 100, 200); 
    border: 0 none;
    border-radius: 20px;
    width: 100px;
    text-align: center;
    color: white;
    font-size: 20px;
    font-weight: bold;
}
</style>

<html lang="en">
	<script src ="http://code.jquery.com/jquery-1.11.1.js "> </script>
	<script>
		function followuser() {
			$.ajaxSetup({
        			headers: {
            		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        		}});
			$.ajax({
				type:"POST",
				url: "{{ url('/follow\/'.$User->username )}}",
				cache:false,
				success: function(data){
					$('#follow').attr('onclick', 'unfollowuser()')
					$('#follow').val('Unfollow');
					
				}
			});
			return false;
		}
		function unfollowuser() {
			$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }});
			$.ajax({

				type:"POST",
				url: "{{ url('/unfollow\/'.$User->username) }}",
				cache:false,
				success: function(data){
					$('#unfollow').attr('onclick', 'followuser()')
					$('#unfollow').val('Follow');
					
				}
			});
			return false;
		}


		////////
		function  blockuser() {
			$.ajaxSetup({
        			headers: {
            		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        		}});
			$.ajax({
				type:"POST",
				url: "{{ url('/block\/'.$User->username )}}",
				cache:false,
				success: function(data){
					$('#block').attr('onclick', 'unblockuser()')
					$('#block').val('Unblock');
					
				}
			});
			return false;
		}
		function unblockuser() {
			$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }});
			$.ajax({

				type:"POST",
				url: "{{ url('/unblock\/'.$User->username) }}",
				cache:false,
				success: function(data){
					$('#unblock').attr('onclick', 'blockuser()')
					$('#unblock').val('Block');
					
				}
			});
			return false;
		}
		/////////

	</script>
@section('content')
@if (Auth::guest())
	<div class="container">
		<div>
			<form class="form-horizontal" role="form" method="POST" action="{{ url('/follow\/').$User->username }}">
				<input type="submit" value ="Follow" >
			</form>
			<form class="form-horizontal" role="form" method="POST" action="{{ url('/block\/').$User->username }}">
				<input type="submit" value ="Block" >
			</form>
		</div>
	</div>

@else
	<div class="container">
		@if ($User->username !=  Auth::user()->username)
        <div class="row userbar">
            <div class="col-md-10">
                <h1>
                    {{$User->username}}
                </h1>
                <h3>
                    {{$User->name}}
                </h3>
            </div>

    		<div class="col-md-2 followblock">
        		@if ($IsFollowed)
        			<form>         
        			<input type="submit" class="userbuttons" id="unfollow" value ="Unfollow" onclick ="return unfollowuser()">
        			</form>
    			@else
        			<form>
    				<input type="submit" class="userbuttons" id="follow" value ="Follow" onclick ="return followuser()">
        			</form>
    			@endif
                <br />
    			@if ($IsBlocked)
        			<form>         
       				<input type="submit" class="userbuttons" id="unblock" value ="Unblock" onclick ="return unblockuser()">
        			</form>
    			@else
        			<form>
    				<input type="submit" class="userbuttons" id="block" value ="Block" onclick ="return blockuser()">
        			</form>
    			@endif
            </div>
		</div>
        @endif
	</div>
    <div class="container-fluid">
        @if(isset($pictureList))
            <div class="row userpost">
                @foreach ($pictureList as $index => $piclist )
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="cell" style="height: 400px;">
                            <a href="/post/picture/{{$pictureList[$index]->picture_id}}">
                                <img src="{{ URL::to('/') }}{{$piclist->picture_link}}" />
                            </a>
                            <div class="overlay">
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
                                        <p class="storypreview">
                                            {{$storyList[$index]->content}}
                                        </p>
                                    </p>
                                @endif
                            </div>
                        </div>
                        <br />
                        <br />
                    </div>
                @endforeach
            </div>
            {!! $pictureList->render() !!}
        @endif
    </div>
</div>
@endif

@endsection
</html>
