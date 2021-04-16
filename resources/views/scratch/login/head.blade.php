<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- or css styles fa fa icons -->
    <link rel="stylesheet" href="/w3css/3/w3.css">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'InstantPlot') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
@yield('styles')

/* body {
  margin: 0;
  font-family: Arial;
} */

/* .top-container {
  background-color: #f1f1f1;
  padding: 30px;
  text-align: center;
} */

.header {
    
  padding: 10px 16px;
  /* background: #f97484; */
  /* background: #07889b; */
  background: #72cdd8;
  color: #f1f1f1;
}
.text {
  color: #f1f1f1;
  font-style: arial;
  }
  .text:hover{
    text-decoration: none; 
    color: pink;
  }

body {
    background-color: #f4f4f4;
  /* background-color: #e9fbfa; */
  /* background-color: #8aa236; */
  /* background-color: #dce8b7; */
  top: 500;
  size: 100%;
  /* padding: 106px; */
}

.sticky {
  position: fixed;
  top: 0;
  width: 100%;
}
 /* .sticky + .content { */
   /* position: fixed; */
   /* top: 0;
    width: 100%;
    padding-top: 102px;
   } */

   .footer {
  padding: 10px 16px;
  /* background: #f97484; */
  /* background: #07889b; */
  /* background: #66a5ad; */
  /* position:fixed; */
  /* width:100%; */
  background: black;
  color: #f1f1f1;
  padding-bottom: 10px;
}
 }
</style>
</head>
<body>

<div class="header" id="myHeader">
  
  <div id="app">
  <nav class="navbar navbar-expand-md navbar-light">
  <h1><a href="{{url('/home')}}" class="text"><img  src="{{ asset('images/logo1.png') }}" height="80" width="140"></a>&nbsp;</h1>
            <!-- <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'InstantPlot') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button> -->

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                    <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('dashboard') }}"
                                       onclick="event.preventDefault();">
                                        {{ __('Profile') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Notification') }}
                                    </a>

                                     <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                        <a class="text" href="{{ route('logout') }}">Logout</a>

                    @else
                        <a class="text" href="{{ route('login') }}">Login</a>
                        <a class="text" href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif
                        @guest
                            <li><a class="text" href="{{ route('login') }}">{{ __('Login') }}</a></li>&nbsp;&nbsp;&nbsp;
                            <li><a class="text" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('dashboard') }}"
                                       onclick="event.preventDefault();">
                                        {{ __('Profile') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Notification') }}
                                    </a>

                                     <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                                
                            </li>
                            
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
</div>

<div class="content">
@yield('body')
</div>
<div>
<script src="{{asset('js/script.js')}}"></script>
@yield('js')
</div>
<div class="footer">
<footer class="w3-container w3-padding-64 w3-center w3-black w3-xlarge" align="center">
<br>
  <a href="#"><i class="fa fa-facebook-official"></i></a>
  <a href="#"><i class="fa fa-pinterest-p"></i></a>
  <a href="#"><i class="fa fa-twitter"></i></a>
  <a href="#"><i class="fa fa-flickr"></i></a>
  <a href="#"><i class="fa fa-linkedin"></i></a>
  <br>
  <p class="w3-medium">
  All rights reserved 2018 <a href="https://www.instantPlot.com" target="_blank">instantPlot.com</a>
  </p>
</footer>
</div>
</body>
</html>
