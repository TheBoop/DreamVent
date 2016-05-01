@extends('layouts.app')

<!DOCTYPE html>
<html lang="en">
<head>
  <title>DreamVents</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
@section('content')
<body>

<div class="container">
    @foreach ($frontpages as $frontpage)
        <img src="{!! $frontpage->picture_link !!}">
        <a href="{{ url('/viewPost/'.$frontpage->picture_id) }}">
            <button 
                class="btn btn-primary">View Post Page
            </button>
        </a>
        <a href="{{ url('/uploadStory/'.$frontpage->picture_id) }}">
            <button 
                class="btn btn-primary">Make your Story
            </button>
        </a>
    @endforeach
</div>
{!! $frontpages->links() !!}

</body>
</html>
@endsection
