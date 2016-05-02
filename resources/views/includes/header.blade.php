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
        <li><a href="/viewPictures">Temp View Pictures</a></li>
        <li><a href="/browse">Browse</a></li>
        <li><a href="/search">Search</a></li>
        <li><a href="/uploadPicture">Temp Upload</a></li>
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
                    <li><a href="{{ url('profile/'.Auth::user()->name) }}">Personal Page</a></li>
                    <li><a href="{{ url('logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                </ul>
            </li>
        @endif
    </ul>
</div>