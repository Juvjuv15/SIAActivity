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

#prompt{
    width: 77%;
    position: absolute; 
    border: 1 px solid;  
    border-radius: 0px;
    z-index: 1;
}
#close{
    float:right;
}

.header {
width:100%;
  padding: 7px 5px;
  /* background:#414141; */
/*  background: #72cdd8;
*/  color: #f1f1f1;
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
     background-color: #72cdd8; 
/*   background-color: #cdf2f2;
*/  top: 500;
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
.notifdropdown:hover, .notifdropdown:focus {
    background-color: #2f4454; 

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
 @yield('styles');
</style>
</head>
<body>

<div class="content">
@yield('body')
</div>

<form id="logout-form" action="{{ route('logouts') }}" method="GET" style="display: none;">
@csrf
</form>

<div class="js">
<!-- script for the map -->
<script src="{{asset('js/script.js')}}"></script>

<!-- menu passed as parameter kay nangayo ang function ug 1 param paras menu bar na mu change -->
<script>
function changeMenu(menu) {
    menu.classList.toggle("change");
}

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