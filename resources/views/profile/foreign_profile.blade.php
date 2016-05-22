@extends('layouts.app')
<!DOCTYPE html>
<style>
.userbar {
    position: relative;
    padding: 5px;
    width: 100%;
    max-height: 300px;
    border-radius: 10px;
    background: rgba(211, 211, 211, 0.5);
}
h1 {
    font-size: 24;
    font-weight: bold;
}
h3 {
    font-size: 20;
    font-style: italic;
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

    		<div class="col-md-2">
        		@if ($IsFollowed)
        			<form>         
        			<input type="submit" id="unfollow" value ="Unfollow" onclick ="return unfollowuser()">
        			</form>
    			@else
        			<form>
    				<input type="submit" id="follow" value ="Follow" onclick ="return followuser()">
        			</form>
    			@endif
    			@if ($IsBlocked)
        			<form>         
       				<input type="submit" id="unblock" value ="Unblock" onclick ="return unblockuser()">
        			</form>
    			@else
        			<form>
    				<input type="submit" id="block" value ="Block" onclick ="return blockuser()">
        			</form>
    			@endif
            </div>
		</div>
        @endif
	</div>
@endif

@endsection
</html>
