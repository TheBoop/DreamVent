<! --@extends('layouts.app') -->

@section('content')

<!-- Background color/Theme -->
<style>
body {
    background-color: lightblue;
}
</style>

<!-- The navigation bar on top of the page -->
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand logo-nav" href="#">Awesome Logo</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">AutoTab 1</a></li>
        <li><a href="/">Tab 2</a></li>
        <li><a href="/">Tab 3</a></li>
        <li><a href="/">Tab 4</a></li>
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
                        <li><a href="{{ url('/') }}">Inbox</a></li>
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

    </div><!--/.nav-collapse -->
  </div>
</nav>


<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Contents</div>
                	<div class="panel-body">
               		    Contents.
                      
                	</div>
     		</div>




        </div>
    </div>
</div>
@endsection
