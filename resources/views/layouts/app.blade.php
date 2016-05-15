<!DOCTYPE html>
<html lang="en">
<head>
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
</body>
</html>


