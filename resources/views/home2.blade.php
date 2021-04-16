<!DOCTYPE html>
<html lang="en">
<head>
</head>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link rel="dns-prefetch" href="https://fonts.gstatic.com">
<!-- External Bootstrap -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<style>
h1,h2,h3{
    font-family: "Roboto Condensed", sans-serif;
}
.lotnum{
    font-family: "Roboto Condensed", sans-serif;
}
.button1{
    font-family: "Roboto Condensed", sans-serif;
    font-size: 100%;
    font-weight: 700;
    color: white;
    width: 35%;
    box-sizing: border-box;
    border: 2px;
    border-radius: 50px;
    font-size: 30px;
    background-color: #2f4454;
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 25px 30px 25px 10px;
    display: right;
    text-align: center;
    /* margin: 10px 0; */
}

.button1:hover {
    background: #2f4454;
    opacity: 0.8;
    text-decoration: none; 
    color: white;
    
}
.button2{
    font-family: "Roboto Condensed", sans-serif;
    font-size: 100%;
    font-weight: 700;
    color: white;
    width: 35%;
    box-sizing: border-box;
    border: 2px;
    border-radius: 50px;
    font-size: 30px;
    background-color: #63c8c9;
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 25px 30px 25px 10px;
    display: right;
    text-align: center;
    <!-- animation-name:flashing;
    animation-duration:1s;
    animation-timing-function:linear;
    animation-iteration-count:infinite; -->

}

.button2:hover {
    background: #63c8c9;
    opacity: 0.8;
    text-decoration: none; 
    color: white;
    <!-- color: #f8dea5; -->
    
}
.gallery-area img {
  margin-bottom: 30px;
  width: 100%;
}

.generic-blockquote {
  padding: 30px 50px 30px 30px;
  background: #f9f9ff;
border-left: 4px solid #b68834;
border-bottom: 4px solid #b68834;


}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 200px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    <!-- background-color: #fefefe; -->
    background-color: #2f4454;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 60%;
}

/* The Close Button */
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

@keyframes flashing{
    0%{
        opacity:1.0;
    }
    25%{
        opacity:0.6;
    }
    50%{
        opacity:0.3;
    }
    75%{
        opacity:0.6;
    }
    100%{
        opacity:1.0;
    }
}
.footer {
  font-family: "Roboto Condensed", sans-serif;
  padding: 10px 16px;
  background: #2f4454;
  color: #f1f1f1;
  padding-bottom: 50px;
}
</style>
<body>
<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
<ol class="carousel-indicators">    
<li data-target="#carousel" data-slide-to="0" class="active"></li>    
<li data-target="#carousel" data-slide-to="1"></li>    
<li data-target="#carousel" data-slide-to="2"></li>  
<li data-target="#carousel" data-slide-to="3"></li>  
</ol>    
    <div class="carousel-inner">     
        <div class="carousel-item active">       
            <img  src="{{ asset('images/bg6.jpg') }}" height="660px" width="100%">
            <div class="carousel-caption d-none d-md-block" align="center">     

            <center>
            <input type="button" name="transactionType" class="button1" id="sellRent0" value="SELL/MAGPA-RENTA">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" onclick="location.href='{{url('/map')}}'" name="transactionType" class="button2" value="BUY/RENT">
            </center>
            <br>
            <br>
            <h1>What kind of lot are you looking for?</h1>     
            <h3></h3>   
            </div>     
        </div>        
        <div class="carousel-item">       
            <img  src="{{ asset('images/bg.jpg') }}" height="595" width="100%">
            <div class="carousel-caption d-none d-md-block">
            <center>
            <input type="button" name="transactionType" class="button1" id="sellRent1" value="SELL/MAGPA-RENTA">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" onclick="location.href='{{url('/map')}}'" name="transactionType" class="button2" value="BUY/RENT">
            </center>
            <br>
            <br>
            <h2>INSTANT PLOT</h2>     
            <h3>Your one stop property hub</h3>     
            </div>     
        </div>
        <div class="carousel-item">       
            <img  src="{{ asset('images/bg7.jpg') }}" height="595" width="100%">
            <div class="carousel-caption d-none d-md-block">
            <center>
            <input type="button"  name="transactionType" class="button1" id="sellRent2" value="SELL/MAGPA-RENTA">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" onclick="location.href='{{url('/map')}}'" name="transactionType" class="button2" value="BUY/RENT">
            </center>
  
            <br>
            <br>   
            <h2>Explore at your own time...</h2>     
            <h3></h3>  
            </div>     
        </div> 
        <div class="carousel-item">       
            <img  src="{{ asset('images/bg8.jpg') }}" height="595" width="100%">     
            <div class="carousel-caption d-none d-md-block">    
            <center>
            <input type="button" id="sellRent3" name="transactionType" class="button1" value="SELL/MAGPA-RENTA">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" onclick="location.href='{{url('/map')}}'" name="transactionType" class="button2" value="BUY/RENT">
            </center> 
            <br>
            <br>
            <h1>REST ASSURED YOUR MONEY IS SECURED</h1>   
            </div>
        </div> 
        <div id="showRegProperties" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close" align="right">&times;</span>
        <div align="left">
                @foreach($ownedLot as $value)
                <a href="{{url('/sell/'.$value->lotId.'/post')}}" class="lotnum">property no. {{$value->lotNumber}}</a>&nbsp;&nbsp;&nbsp;&nbsp;
                @endforeach
        </div>

    </div>
</div>        
</div>
</div>
            <!-- <div class="whole-wrap">
				<div class="container">
                    <div class="section-top-border">
						<h3 class="mb-10">INSTANT PLOT</h3>
						<div class="row">
							<div class="col-lg-12">
								<blockquote class="generic-blockquote">
									“As the online world flourish it becomes the market place of property listings, but it also becomes the breeding place of property swindlers or scammers. InstantPlot is an online hub that focuses on lot property listings. Property listed on InstantPlot are verified through a reliable data source before it is posted. With InstantPlot rest assured that the money you invest is safe and secure.” 
								</blockquote>
							</div>
						</div>
					</div>
                </div> 
            </div>

            <div class="whole-wrap">
				<div class="container">
                    <div class="section-top-border">
						<h3 class="mb-10">MISSION</h3>
						<div class="row">
							<div class="col-lg-12">
								<blockquote class="generic-blockquote">
									“As the online world flourish it becomes the market place of property listings, but it also becomes the breeding place of property swindlers or scammers. InstantPlot is an online hub that focuses on lot property listings. Property listed on InstantPlot are verified through a reliable data source before it is posted. With InstantPlot rest assured that the money you invest is safe and secure.” 
								</blockquote>
							</div>
						</div>
					</div>
                </div> 
            </div>

            <div class="whole-wrap">
				<div class="container">
                    <div class="section-top-border">
						<h3 class="mb-10">VISSION</h3>
						<div class="row">
							<div class="col-lg-12">
								<blockquote class="generic-blockquote">
									“As the online world flourish it becomes the market place of property listings, but it also becomes the breeding place of property swindlers or scammers. InstantPlot is an online hub that focuses on lot property listings. Property listed on InstantPlot are verified through a reliable data source before it is posted. With InstantPlot rest assured that the money you invest is safe and secure.” 
								</blockquote>
							</div>
						</div>
					</div>
                </div> 
            </div> -->
<!-- Start gallery Area -->
            <!-- <section class="gallery-area section-gap" id="gallery" align="center"> -->
            <!-- <section class="gallery-area" id="gallery" align="center">
				<div class="container"> -->
					<!-- <div class="row d-flex justify-content-center">
						<div class="menu-content pb-60 col-lg-10">
							<div class="title text-center">
								<h1 class="mb-10">What kind of lot are you looking for?</h1>
								<p>Explore at your own time and schedule.</p>
							</div>
						</div>
					</div>						 -->
                    
					<!-- <div class="row">
						<div class="col-lg-4">
							<a href="images/lot1.jpg" class="img-pop-home">
								<img class="img-fluid" src="images/lot1.jpg" alt="">
							</a>	
							<a href="images/lot2.jpg" class="img-pop-home">
								<img class="img-fluid" src="images/lot2.jpg" alt="">
							</a>	
						</div>
						<div class="col-lg-7">
							<a href="images/lot6.jpg" class="img-pop-home">
								<img class="img-fluid" src="images/lot6.jpg" alt="">
							</a>	
							<div class="row">
								<div class="col-lg-6">
									<a href="images/lot7.jpg" class="img-pop-home">
										<img class="img-fluid" src="images/lot7.jpg" alt="">
									</a>	
								</div>
								<div class="col-lg-6">
									<a href="images/lot5.jpg" class="img-pop-home">
										<img class="img-fluid" src="images/lot5.jpg" alt="">
									</a>	
								</div>
							</div>
						</div>
					</div>
				</div>	
			</section> -->
			<!-- End gallery Area -->
           	     

<!-- for the modal pop up -->
<script>
// Get the modal
var modal = document.getElementById('showRegProperties');

// Get the button that opens the modal
var btn0 = document.getElementById("sellRent0");
var btn1 = document.getElementById("sellRent1");
var btn2 = document.getElementById("sellRent2");
var btn3 = document.getElementById("sellRent3");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal 
btn0.onclick = function() {
    modal.style.display = "block";
}
btn1.onclick = function() {
    modal.style.display = "block";
}
btn2.onclick = function() {
    modal.style.display = "block";
}
btn3.onclick = function() {
    modal.style.display = "block";
}
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
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