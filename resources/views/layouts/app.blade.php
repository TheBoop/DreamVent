<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
    @include('includes.styles')
</head>
<body id="app-layout">
    <nav class="navbar navbar-default">
        <div class="container">

            @include('includes.header')

        </div>
    </nav>

    <div id="main" class="row">
        <div id="sidebar" class="col-md-2">
            @include('includes.sidebar')
        </div>

        <div id="content" class="col-md-10">
            @yield('content')
        </div>
        
    </div>
    <!-- JavaScripts -->
    @include('javascript.include_java')

</body>
</html>
