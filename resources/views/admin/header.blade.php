<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <!-- or css styles fa fa icons -->
    <!-- <link rel="stylesheet" href="/w3css/3/w3.css">   -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">

   <!-- for glyph icons -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
    
     <!-- CSRF Token -used para d ma hack or makuha ang data na gipang input sa user sa iyang mga transactions with the site-->
     <meta name="csrf-token" content="{{ csrf_token() }}">
   
   

    <title>Instant Plot</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">

    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merienda">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Abel">

    <!-- for image pano -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
    <link rel="Stylesheet" type="text/css" href="{{asset('css/smoothDivScroll.css')}}">  


<style>
@yield('styles')
#close{
    float:right;
}

#makeMeScrollable
		{
			/* width:1085px; */
            /* width:970px; */
            width:485px;
			height: 250px;
			position: relative;
			margin:auto;
			text-align: center;
		}
		
		/* Replace the last selector for the type of element you have in
		   your scroller. If you have div's use #makeMeScrollable div.scrollableArea div,
		   if you have links use #makeMeScrollable div.scrollableArea a and so on. */
		#makeMeScrollable div.scrollableArea img
		{
			position: relative;
			width:auto;
			height:300px;
			margin: 0;
			padding: 0;
			/* If you don't want the images in the scroller to be selectable, try the following
			   block of code. It's just a nice feature that prevent the images from
			   accidentally becoming selected/inverted when the user interacts with the scroller. */
			-webkit-user-select: none;
			-khtml-user-select: none;
			-moz-user-select: none;
			-o-user-select: none;
			user-select: none;
		}

.header {
width:100%;
  padding: 7px 5px;
  /* background:#414141; */
  background: #72cdd8;
  color: #f1f1f1;
}
.text {
  color: white;
  font-style: arial;
  }
.text:hover{
    /* background: #9ecdd5; */
    text-decoration: none; 
    color: #f1f1f1;
  }

body{
    /* background-color: #f1f1f1; */
   background-color: #cdf2f2;
  top: 500;
  width:100%;
}


   .footer {
  padding: 10px 16px;
  background: #2f4454;
  color: #f1f1f1;
  padding-bottom: 50px;
}

/* for icons on header */
.icon-bar a {
    font-family: "Roboto", sans-serif;
     /* Float links side by side */
    text-align: center; /* Center-align text */
    width: 20%; /* Equal width (5 icons with 20% width each = 100%) */
    padding: 20px 20px; /* Some top and bottom padding */
    /* transition: all 0.3s ease; Add transition for hover effects */
    color: white; /* White text color */
    font-size: 20px; /* Increased font size */
}

.icon-bar a:hover {
    background-color: #2f4454; 
    text-decoration: none; 
    /* text-decoration: underline; */
}

.dropbtn {
    font-family: "Roboto", sans-serif;
    color: white;
    text-align: center; /* Center-align text */
    width: 20%; /* Equal width (5 icons with 20% width each = 100%) */
    padding: 20px 20px; /* Some top and bottom padding */
    font-size: 20px;

    /* cursor: pointer; */
}

.dropbtn:hover, .dropbtn:focus {
    background-color: #2f4454; 

}

.dropdown {
    float: right;
    position: relative;
    display: inline-block;
}


.dropdown-content {
    display: none;
    position: absolute;
    background-color: #2f4454;
    min-width: 160px;
    overflow: auto;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    right: 0;
    z-index: 1;
}

.dropdown-content a {
    color: white;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

/* for notification */
.notifdropdown {
    font-family: "Roboto", sans-serif;
    color: white;
    text-align: center; /* Center-align text */
    width: 20%; /* Equal width (5 icons with 20% width each = 100%) */
    padding: 20px 20px; /* Some top and bottom padding */
    font-size: 20px;

    /* cursor: pointer; */
}

.notifdropdown:hover, .notifdropdown:focus {
    background-color: #2f4454; 

}



.notif-content {
    display: none;
    position: absolute;
    background-color: #2f4454;
    min-width: 160px;
    overflow: auto;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    right: 0;
    z-index: 1;
}

.notif-content a {
    color: white;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}


  .profile {
    border-radius: 50%;
    /* border: 1px solid gray; */

    }


/* .dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: #3e8e41;} */

/* .dropdown a:hover {background-color: #cdf2f2;} */

.show {display: block;}

 }
</style>
</head>
<body>

<div class="header" id="myHeader">
  
  <div id="app">
  <nav class="navbar navbar-expand-md navbar-light">
  <b><a href="{{url('/home')}}" class="text"><img id="logo" src="{{ asset('images/logo1.png') }}" height="30" width="30">&nbsp;&nbsp;|&nbsp;&nbsp;InstantPlot</a></b></font>
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
                        @guest
                            <li><a class="text" href="{{ route('instantplot.com') }}"><font size="5" >LOGIN</font></a>&emsp;&nbsp;&nbsp;</li>
                            <li><a class="text" href="{{ route('register') }}"><font size="5">REGISTER</font></a></li>
                        @else
                        <div class="icon-bar">
                        <a href="{{url('/adminLanding')}}">Home</a>
                        <a href="{{url('/lotList')}}">LOT LIST</a>
                        <a href="{{url('/confirmedList')}}">REGISTERED EMAIL</a> 
                        </div>                     
                        <!-- <a href="{{url('/home')}}">Notifications</a> -->
                        <!-- <a href="{{route('dashboard')}}">{{ Auth::user()->name }}</a> -->

                        <!-- <a href="{{url('/home')}}"><i class="fa fa-home"  style="font-size:48px;color:white;"></i></a>
                        <a href="#" onclick="notifyfunction()"><i class="fa fa-globe" style="font-size:48px;color:white;"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
                        
                        <!-- <font size="5" color="white"><b>{{ Auth::user()->name }}</b></font> -->
                        <!-- </div>   -->


                        <div class="dropdown">
                        <!-- <i class="fa fa-caret-down"></i> -->
                        <font color="white"> <a onclick="dropdown()" class="dropbtn">
                        @if($picture==null)
                        <img  class="profile" src="{{ asset('images/avatar3.png') }}" height="29" width="29"> 
                        @endif

                        @if($picture!=null)
                        <img class="profile" src="{{ $picture->fileExt }}" height="29" width="29">  
                        @endif{{ Auth::user()->name }}</a></font>
                        
                             <div id="myDropdown" class="dropdown-content">
                                    <a class="dropdown-item" href="{{ route('logouts') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                            </div>
                        </div>                         

                                    <form id="logout-form" action="{{ route('logouts') }}" method="GET" style="display: none;">
                                        @csrf
                                    </form>
                                    <form id="dashboard-form" action="{{ route('dashboard') }}" method="GET" style="display: none;">
                                        @csrf
                                    </form>

                                    <form id="potential-form" action="{{ route('potential') }}" method="GET" style="display: none;">
                                        @csrf
                                    </form>

                                    <form id="intended-form" action="{{ route('intendedlots') }}" method="GET" style="display: none;">
                                        @csrf
                                    </form>
                                  
                                <!-- </div> -->
                                
                            <!-- </li> -->
                            
                        @endguest
                    </ul>
                </div>

                </nav>
            </div> 
</div>

<div class="content">
@yield('body')
</div>


<div>
<!-- script for the map -->
<script src="{{asset('js/script.js')}}"></script>

<!-- menu passed as parameter kay nangayo ang function ug 1 param paras menu bar na mu change -->
<script>
function changeMenu(menu) {
    menu.classList.toggle("change");
}
</script>
<!-- When the user clicks on the button, 
toggle between hiding and showing the dropdown content -->
<script>
function notifyfunction() {
    document.getElementById("notificationDropdown").classList.toggle("show");
}
window.onclick = function(event) {
  if (!event.target.matches('.notifdropdown')) {

    var dropdowns = document.getElementsByClassName("notif-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
// function notifydropdown() {
//     document.getElementById("myDropdown").classList.toggle("show");
// }
</script>
 <!-- Close the dropdown if the user clicks outside of it -->
<!-- <script>
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script> -->

<script>

function w3_close() {
    document.getElementById("prompt").style.display = "none";
}
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function dropdown() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>

@yield('js')

</div>

<div class="footer">
<footer class="w3-container w3-padding-64 w3-center w3-black w3-xlarge" align="center">
  <br>
  <a href="#"><i class="fa fa-facebook-official" style="color:white"> </i></a>
  <a href="#"><i class="fa fa-pinterest-p" style="color:white"> </i></a>
  <a href="#"><i class="fa fa-twitter" style="color:white"> </i></a>
  <a href="#"><i class="fa fa-flickr" style="color:white"> </i></a>
  <a href="#"><i class="fa fa-linkedin" style="color:white"></i></a>
  <br>
  <p class="w3-medium">
  All rights reserved 2018 <a href="https://www.instantPlot.com" style="color:white">instantPlot.com</a>
  </p>
</footer>
</div>


</body>
</html>