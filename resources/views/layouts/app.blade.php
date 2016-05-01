<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dreamvents</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        body {
            font-family: 'Lato';
            background-color: lightblue;
        }
        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    DreamVents
                </a>
            </div>

            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="/YourPictures">View Your Pictures</a></li>
                    <li><a href="/browse">Browse</a></li>
                    <li><a href="/search">Search</a></li>
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

    @yield('content')


</body>
</html>
