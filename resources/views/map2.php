@extends('header')
    <title>Lot Search</title>
    <head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
    </head>
@section('styles')
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

 .find{
    width: 50px;
    box-sizing: border-box;
    border: 2px solid #63c8c9;
    border-radius: 4px;
    font-size: 16px;
    background-color: #63c8c9;
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 9px 45px 9px 10px;
} 
table {
        width: 99vw;
        height: 100vh;
      }
      td .map {
        width: 70%;
        height: 50%;
      }
      td .streetview{
        width: 30%;
        height: 50%;
      }
    @stop
    @section('notification')
    @foreach(Auth::user()->unreadNotifications as $notif)
            <a class="dropdown-item" href="{{url('/dashboard')}}">{{$notif['data']}}
            <br>
            <small>{{date('F d, Y', strtotime($notif->created_at))}} </small>
            </a>
            @endforeach
    @endsection
  
@section('body')


@if (session('intendedstatus'))
            <div align="center">
            <div class="">

                <div align="center" class="alert alert-danger" id="prompt">
                    <h5>{{ session('intendedstatus') }}<i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h5>
                </div>
            </div>
            </div>
@endif
            
    <center>
    {!! Form::open(['url'=>'/filter','id'=>'filter']) !!}

    {{csrf_field()}}
    <div align="center">

    <input type="text" id="searchaddress" name="searchaddress" class="controls"  placeholder="Enter location you want to search for lots.....">
    <!-- <label id="result"></label> -->
    <!-- <input type="text" name="searchaddress" id="searchaddress"> -->


<select name="selltype" id="selltype" class="select">
<option value="">Selling Type</option>
<option value="For Sale">For Sale</option>
<option value="For Lease">For Lease</option>
</select>

<select name="lottype" id="lottype" class="select">
<option value="">Lot Type</option>
@foreach($lottype as $types)
<option value="{{$types['lotType']}}">{{$types['lotType']}}</option>
@endforeach
</select>

<select name="minPrice" id="minPrice" class="select">
<option value="">min price</option>
@foreach($price as $prices)
<option value="{{$prices['price']}}">{{$prices['price']}}</option>
@endforeach
</select>

<select name="maxPrice" id="maxPrice"  class="select">
<option value="">max price</option>
@foreach($price as $prices)
<option value="{{$prices['price']}}">{{$prices['price']}}</option>
@endforeach
</select>



    {!! Form::submit('FIND',['class'=>'find'])!!}
    
    {!! Form::close() !!}
    </div>
    </center>
    <div id="map">

    </div>


    <label id="legend"><h3>MAP Legend</h3></label>

<!-- <script type="text/javascript">
google.maps.event.addDomListener(window,'load',initialize);
function initialize(){
  var autocomplete = new google.maps.places.Autocomplete(document.getElementById('searchaddress'));
  google.maps.event.addListener(autocomplete,'places_changed',function (){
    var place = autocomplete.getPlace();
    var location = "location" + place.formatted_Address + "<br/>";
    location += "lat" + place.geometry.location.A + "<br/>";
    location+= "long" + place.geometry.location.F + "<br/>";
    document.getElementById('result').innerHTML = location;

  });
};
</script> -->
    
<style>
#legend {
        font-family: Arial, sans-serif;
        background-color: white;
        padding: 30px 70px 30px 10px;
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



@extends('header')
@section('styles')
<!-- * {
    box-sizing: border-box;
} -->

<!-- /* Create two unequal columns that floats next to each other */
/* Left column */ -->
.rightcolumn {   
    float: right;
    width: 100%;
    margin-top: 0px;

}

<!-- /* Right column */ -->
.leftcolumn {
    float: right;
    width: 23%;
    <!-- padding-top: 10px;
    padding-left: 0px; -->

}

.begin {
     background-color: #72cdd8;
     <!-- padding: 20px; -->
     width: 100%;
<!--      border:1px;
     border-radius: 0px;
 -->     margin-top: 0px;
     <!-- background-color:#cdf2f2; -->

}

.beginright {
     background-color: white;
     width: 100%;
    <!--  border:1px;
     border-radius: 5px; -->
     <!-- background-color:#fcd12a; -->
     <!-- margin-top: 20px; -->
     margin-top: 0px;
     
 <!-- margin-bottom: 10px; -->



}
.start:after {
    content: "";
    display: table;
    clear: both;
}
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
        z-index:99999;
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
    background-color: white;
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 12px 30px 12px 10px;
} 

 .find{
    width: 50px;
    box-sizing: border-box;
    border: 2px solid #63c8c9;
    border-radius: 4px;
    font-size: 16px;
    background-color: white;
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 9px 45px 9px 10px;
} 
@stop
@section('notification')
  @foreach(Auth::user()->unreadNotifications as $notif)
    <a class="dropdown-item" href="{{url('/dashboard')}}">{{$notif['data']}}
            <br>
    <small>{{date('F d, Y', strtotime($notif->created_at))}} </small>
    </a>
  @endforeach
@endsection
@section('body')
<div class="adminlanding">
  <div class="start">
    <div class="rightcolumn">
      <div class="beginright">
        @if (session('intendedstatus'))
          <div align="center">
            <div align="center" class="alert alert-danger" id="prompt">
              <h5>{{ session('intendedstatus') }}<i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h5>
            </div>
          </div>
        @endif
        {!! Form::open(['url'=>'/filter','id'=>'filter']) !!}
        {{csrf_field()}}
        <div align="center">
          <input type="text" id="searchaddress" name="searchaddress" class="controls"  placeholder="Enter location you want to search for lots.....">
          <!-- <label id="result"></label> -->
          <!-- <input type="text" name="searchaddress" id="searchaddress"> -->
          <select name="selltype" id="selltype" class="select">
          <option value="">Selling Type</option>
          <option value="For Sale">For Sale</option>
          <option value="For Lease">For Lease</option>
          </select>

          <select name="lottype" id="lottype" class="select">
          <option value="">Lot Type</option>
          @foreach($lottype as $types)
          <option value="{{$types['lotType']}}">{{$types['lotType']}}</option>
          @endforeach
          </select>

          <select name="minPrice" id="minPrice" class="select">
          <option value="">min price</option>
          @foreach($price as $prices)
          <option value="{{$prices['price']}}">{{$prices['price']}}</option>
          @endforeach
          </select>

          <select name="maxPrice" id="maxPrice"  class="select">
          <option value="">max price</option>
          @foreach($price as $prices)
          <option value="{{$prices['price']}}">{{$prices['price']}}</option>
          @endforeach
          </select>
          {!! Form::submit('FIND',['class'=>'find'])!!}
          
          {!! Form::close() !!}
        </div>
        <div id="map"></div>
        <label id="legend"><h3>MAP Legend</h3></label>
      </div><!-- end begin right -->
    </div><!-- end rightcolumn -->


</div><!-- end div start  -->
</div><!-- end div admin  -->


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxdYAzq688HGpFDMmvo3q9mSM2LfVIgjE&libraries=places&callback">  
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js">
</script>
@stop
<style type="text/css">
  #legend {
        font-family: Arial, sans-serif;
        background-color: white;
        padding: 30px 70px 30px 10px;
        margin: 10px;
        z-index:1;
        /* border: 1px solid white; */
           }
  #legend h3 {
      margin-top: 0;
    }
  #legend img {
      vertical-align: middle;
    }
</style>