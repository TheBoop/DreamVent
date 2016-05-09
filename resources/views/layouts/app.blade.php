<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
    @include('includes.styles')
</head>
<body id="app-layout">
    @include('includes.header')
    <div id="main" >
        <div id="content">
            @yield('content')
        </div>
    </div>
    @include('javascript.include_java')
</body>
</html>