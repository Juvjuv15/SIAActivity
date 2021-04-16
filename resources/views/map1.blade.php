@extends('header')
    <title>Lot Search</title>
@section('styles')
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
<!-- .sticky + .content {
    position: fixed;
  padding-top: 102px;
} -->
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
      }

      #infowindow-content .title {
        font-weight: bold;
      }

      #infowindow-content {
        display: none;
      }

      #map #infowindow-content {
        display: inline;
      }

      .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

input[type=text] {
    width: 500px;
    box-sizing: border-box;
    border: 2px solid #63c8c9;
    border-radius: 4px;
    font-size: 16px;
    background-color: white;
    background-image: url('images/searchicon.png');
    background-position: 10px 10px; 
    background-size: 20px 20px;
    background-repeat: no-repeat;
    padding: 12px 20px 12px 40px;
    -webkit-transition: width 0.4s ease-in-out;
    transition: width 0.4s ease-in-out;
}

input[type=text]:focus {
    width: 50%;
}
      

      #pac-input:focus {
        border-color: #4d90fe;
      }

      #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
      }
      #target {
        width: 345px;
      }

     .select{
    width: 200px;
    box-sizing: border-box;
    border: 2px solid #63c8c9;
    border-radius: 4px;
    font-size: 16px;
    background-color: #63c8c9;
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 12px 30px 12px 10px;
} 

    @stop
    
  
  @section('body')

  <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
<ol class="carousel-indicators">    
<li data-target="#carousel" data-slide-to="0" class="active"></li>    
<li data-target="#carousel" data-slide-to="1"></li>    
<li data-target="#carousel" data-slide-to="2"></li>  
<li data-target="#carousel" data-slide-to="3"></li>  
</ol>    
    <div class="carousel-inner">     
        <div class="carousel-item active">       
            <img  src="{{ asset('images/lot3.jpg') }}" height="400" width="100%">
            <div class="carousel-caption d-none d-md-block">     
            <h1>WHAT ARE YOU LOOKING?</h1>     
            <h3></h3>   
            </div>     
        </div>        
        <div class="carousel-item">       
            <img  src="{{ asset('images/lot6.jpg') }}" height="400" width="100%">
            <div class="carousel-caption d-none d-md-block">     
            <h2>INSTANT PLOT</h2>     
            <h3>Your one stop property hub</h3>     
            </div>     
        </div>
        <div class="carousel-item">       
            <img  src="{{ asset('images/lot7.jpg') }}" height="400" width="100%">
            <div class="carousel-caption d-none d-md-block">     
            <h2>Explore at your own time...</h2>     
            <h3></h3>  
            </div>     
        </div> 
        <div class="carousel-item">       
            <img  src="{{ asset('images/lot1.jpg') }}" height="400" width="100%">     
            <div class="carousel-caption d-none d-md-block">     
            <!-- <h2>with Instant Plot</h2>      -->
            <h1>REST ASSURE YOUR MONEY IS SECURE</h1>   
            </div>
        </div>         
    </div>
</div>

<br>
<center>

<!-- <select name="type" class="select">
@foreach($lottype as $types)
<option value="{{$types['lotType']}}">{{$types['lotType']}}</option>
@endforeach
</select>&nbsp;&nbsp;
<select name="minPrice" class="select">
<option value="0">min price</option>
<option value="100000">100,000</option>
<option value="200000">200,000</option>
<option value="300000">300,000</option>
<option value="400000">400,000</option>
<option value="500000">500,000</option>
<option value="600000">600,000</option>
<option value="700000">700,000</option>
<option value="800000">800,000</option>
<option value="900000">900,000</option>
<option value="1000000">100,0000</option>
<option value="1100000">1,100,000</option>
<option value="1200000">1,200,000</option>
<option value="1300000">1,300,000</option>
<option value="1400000">1,400000</option>
<option value="1500000">1,500,000</option>
<option value="1600000">1,600,000</option>
<option value="1700000">1,700,000</option>
<option value="1800000">1,800,000</option>
<option value="1900000">1,900,000</option>
<option value="2000000">2,000,000</option>
<option value="2100000">2,100000</option>
<option value="2200000">2,200,000</option>
<option value="2300000">2,300,000</option>
<option value="2400000">2,400,000</option>
<option value="2500000">2,500,000</option>
<option value="2600000">2,600,000</option>
<option value="2700000">2,700,000</option>
<option value="2800000">2,800,000</option>
<option value="2900000">2,900,000</option>
<option value="3000000">3,000,000</option>
<option value="3100000">3,100,000</option>
<option value="3200000">3,200,000</option>
<option value="3300000">3,300,000</option>
<option value="3400000">3,400,000</option>
<option value="3500000">3,500,000</option>
<option value="3600000">3,600,000</option>
<option value="3700000">3,700,000</option>
<option value="3800000">3,800,000</option>
<option value="3900000">3,900,000</option>
<option value="4000000">4,000,000</option>
<option value="4100000">4,100,000</option>
<option value="4200000">4,200,000</option>
<option value="4300000">4,300,000</option>
<option value="4400000">4,400,000</option>
<option value="4500000">4,500,000</option>
<option value="4600000">4,600,000</option>
<option value="4700000">4,700,000</option>
<option value="4800000">4,800,000</option>
<option value="4900000">4,900,000</option>
<option value="5000000">5,000,000</option>
<option value="5100000">5,100,000</option>
<option value="5200000">5,200,000</option>
<option value="5300000">5,300,000</option>
<option value="5400000">5,400,000</option>
<option value="5500000">5,500,000</option>
<option value="5600000">5,600,000</option>
<option value="5700000">5,700,000</option>
<option value="5800000">5,800,000</option>
<option value="5900000">5,900,000</option>

</select>
&nbsp;&nbsp;
<select name="maxPrice" class="select">
<option value="0">max price</option>
<option value="100000">100,000</option>
<option value="200000">200,000</option>
<option value="300000">300,000</option>
<option value="400000">400,000</option>
<option value="500000">500,000</option>
<option value="600000">600,000</option>
<option value="700000">700,000</option>
<option value="800000">800,000</option>
<option value="900000">900,000</option>
<option value="1000000">100,0000</option>
<option value="1100000">1,100,000</option>
<option value="1200000">1,200,000</option>
<option value="1300000">1,300,000</option>
<option value="1400000">1,400000</option>
<option value="1500000">1,500,000</option>
<option value="1600000">1,600,000</option>
<option value="1700000">1,700,000</option>
<option value="1800000">1,800,000</option>
<option value="1900000">1,900,000</option>
<option value="2000000">2,000,000</option>
<option value="2100000">2,100000</option>
<option value="2200000">2,200,000</option>
<option value="2300000">2,300,000</option>
<option value="2400000">2,400,000</option>
<option value="2500000">2,500,000</option>
<option value="2600000">2,600,000</option>
<option value="2700000">2,700,000</option>
<option value="2800000">2,800,000</option>
<option value="2900000">2,900,000</option>
<option value="3000000">3,000,000</option>
<option value="3100000">3,100,000</option>
<option value="3200000">3,200,000</option>
<option value="3300000">3,300,000</option>
<option value="3400000">3,400,000</option>
<option value="3500000">3,500,000</option>
<option value="3600000">3,600,000</option>
<option value="3700000">3,700,000</option>
<option value="3800000">3,800,000</option>
<option value="3900000">3,900,000</option>
<option value="4000000">4,000,000</option>
<option value="4100000">4,100,000</option>
<option value="4200000">4,200,000</option>
<option value="4300000">4,300,000</option>
<option value="4400000">4,400,000</option>
<option value="4500000">4,500,000</option>
<option value="4600000">4,600,000</option>
<option value="4700000">4,700,000</option>
<option value="4800000">4,800,000</option>
<option value="4900000">4,900,000</option>
<option value="5000000">5,000,000</option>
<option value="5100000">5,100,000</option>
<option value="5200000">5,200,000</option>
<option value="5300000">5,300,000</option>
<option value="5400000">5,400,000</option>
<option value="5500000">5,500,000</option>
<option value="5600000">5,600,000</option>
<option value="5700000">5,700,000</option>
<option value="5800000">5,800,000</option>
<option value="5900000">5,900,000</option>

</select>
</center> -->
<br>   
 

<center>
    <input id="pac-input" class="controls" type="text" placeholder="Enter location you want to search for lots.....">
</center>
    <div id="map">

    </div>
    <div id="legend"><h3>MAP Legend</h3></div>
    <!-- @section('js') -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxdYAzq688HGpFDMmvo3q9mSM2LfVIgjE&libraries=places&callback=i"
         async defer></script>
      <script>
      var map;
      </script>

     <!-- @stop -->
<style>
#legend {
        font-family: Arial, sans-serif;
        background-color: white;
        padding: 25px 70px 30px 10px;
        margin: 10px;
        /* border: 1px solid white; */
      }
      #legend h3 {
        margin-top: 0;
      }
      #legend img {

    vertical-align: middle;
 }
</style>
@endsection
