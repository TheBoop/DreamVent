@extends('layouts.app')

@section('content')

Pictures <br/>

@foreach ($pictures as $picture)
{{$picture}} <br/>
@endforeach 
{!! $pictures->render() !!}
<br/>

Stories <br/>
@foreach ($stories as $story)
{{$story}} <br/>
@endforeach 
{!! $stories->render() !!}

<br/>


@endsection