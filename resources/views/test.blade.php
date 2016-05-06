@extends('layouts.app')

@section('content')

{{$Picture}} <br/>

@foreach ($story_ids as $story_id)
{{$story_id->story_id}} <br/>
@endforeach

@endsection