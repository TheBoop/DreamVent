@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
	<script src ="http://code.jquery.com/jquery-1.11.1.js "> </script>
	<script>
		function chk() {
			$.ajaxSetup({
        			headers: {
            		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        		}});
			$.ajax({
				type:"POST",
				url: "{{ url('/followtest\/'.$User->username )}}",
				cache:false,
				complete: function(data){
					$('#follow').attr('onclick', 'unchk()')
					$('#follow').val('Unfollow');
					
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
				url: "{{ url('/unfollowtest\/'.$User->username) }}",
				cache:false,
				complete: function(data){
					$('#unfollow').attr('onclick', 'chk()')
					$('#unfollow').val('Follow');
					
				}
			});
			return false;
		}
	</script>
@section('content')
@if (Auth::guest())
	<div class="container">
		<div>
			<form class="form-horizontal" role="form" method="POST" action="{{ url('/followtest\/').$User->username }}">
			{!! csrf_field() !!}
			<li><button type="submit" class="btn btn-primary">Follow This User</a></li>
		</div>
	</div>

@else
	<div class="container">
		@if ($User->username !=  Auth::user()->username)
		<div>
			@if ($IsFollowed)
			<form>         
				{!! csrf_field() !!}
				<input type="submit" id="unfollow" value ="Unfollow" onclick ="return unchk()">
			</form>
			@else
			<form>
				{!! csrf_field() !!}
				<input type="submit" id="follow" value ="Follow" onclick ="return chk()">
			</form>
			@endif
		@endif
		</div>
	</div>
@endif

@endsection
</html>