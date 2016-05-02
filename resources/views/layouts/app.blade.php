<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
    @include('includes.styles')
</head>
<body id="app-layout">
    <nav class="navbar navbar-default">
        <div class="container">
                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    DreamVents
                </a>

            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="/YourPictures">View Your Pictures</a></li>
                    <li><a href="/browse">Browse</a></li>
                    <li><a href="/searchtest">Search</a></li>
                    <li><a href="/uploadPicture">Picture Upload</a></li>
                    <li><a href="/">Tab 5</a></li>
                    <li><a href="/">Tab 6</a></li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Never</a></li>
                        <li><a href="#">Gonna</a></li>
                        <li><a href="#">Give</a></li>
                        <li><a href="#">You</a></li>
                        <li><a href="#">Up</a></li>
                        <li><a href="#">K?</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Nav header</li>
                        <li><a href="#">Link to a tag page?</a></li>
                        <li><a href="#">User can add tags to be here.</a></li>
                      </ul>
                    </li>
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('login') }}">Login</a></li>
                        <li><a href="{{ url('register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
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