<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    @include('includes.head')
    @include('includes.styles')
</head>
<body>
    <div id="wrapper">
        <div class ="container">
            <div id="header" class="row">
                @include('includes.header')
            </div>

            <div id="main">
                <div class="box">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
     <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
</body>
</html>


