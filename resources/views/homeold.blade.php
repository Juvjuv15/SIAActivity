@extends('header')
<style>
/* .searchcriteria{
    position:absolute;
    margin-top:30px;
    z-index:99999;
} */
#map {
        height: 100%;
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
#makeScrollable
{
    width:100%;
    height: 100%;
    position: relative;
    margin:auto;
    padding:15px;
}
/* Replace the last selector for the type of element you have in
    your scroller. If you have div's use #makeMeScrollable div.scrollableArea div,
    if you have links use #makeMeScrollable div.scrollableArea a and so on. */
#makeScrollable div.scrollableArea img
{
    
    position: relative;
    width:auto;
    height:600px;
    margin: 0;
    /* If you don't want the images in the scroller to be selectable, try the following
        block of code. It's just a nice feature that prevent the images from
        accidentally becoming selected/inverted when the user interacts with the scroller. */
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -o-user-select: none;
    user-select: none;
}
.address{
    width: 300px;
    box-sizing: border-box;
    border: 2px solid #63c8c9;
    border-radius: 50px;
    font-size: 16px;
    background-color: white;
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    margin-right: -30px;
    padding: 9px 30px 10px 9px;
    outline:none !important;
} 
.criteria{
  width: 990px;
  border:2px solid #63c8c9;
  border-radius:50px;
  background-color: #63c8c9;
  padding: 5px 5px 5px 5px;
}
.select{
    width: 160px;
    box-sizing: border-box;
    border: 2px solid #63c8c9;
    font-size: 16px;
    color:gray;
    background-color: white;
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    margin-right: -6px;
    padding: 12px 30px 12px 10px;
    outline:none !important;
}
.find{
    width: 80px;
    text-align:center;
    box-sizing: border-box;
    border: 2px solid white;
    border-radius:50px;
    font-size: 16px;
    /* background-color: #63c8c9; */
    background: linear-gradient(to right, #63c8c9, #32fa95);
    margin-left: -20px;
    /* background-position: 10px 10px; 
    background-repeat: no-repeat; */
    padding: 9px 45px 9px 10px;
    outline:none !important;
}
.find:hover{
  background: linear-gradient(to right, #32fa95, #63c8c9);
}
</style>
@section('styles')
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
    outline:none !important;
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
    outline:none !important;
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
    <!-- background-color: #2f4454;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 60%; -->
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

@endsection
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
            <img  src="{{ asset('images/bg8.jpg') }}" height="595" width="100%">
            <div class="carousel-caption d-none d-block" align="center">     

            <center>
            <!-- For the Map and search -->
            <!-- <div class="searchcriteria">
                {!! Form::open(['url'=>'/filter','id'=>'filter']) !!}
                {{csrf_field()}}
                <center>
                    <div class="criteria" align="center">
                        <input type="text" id="searchaddress" name="searchaddress" class="address"  placeholder="Location .....">
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
                        {!! Form::submit('&nbsp;&nbsp;FIND',['class'=>'find','id'=>'find'])!!}
                    </div>
                </center>
                {!! Form::close() !!}
            </div> -->
            <input type="button" name="transactionType" class="button1" onclick="propertyfunction()" id="sellRent0" value="SELL/GRANT A LEASE">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" onclick="location.href='{{url('/map')}}'" name="transactionType" class="button2" value="BUY/RENT">
            </center>
            <br>
            <br>
            <h1>WHAT KIND OF LOT ARE YOU LOOKING FOR?</h1>     
            <h3></h3>   
            </div>     
        </div>        
        <div class="carousel-item">       
            <img  src="{{ asset('images/bg.jpg') }}" height="595" width="100%">
            <div class="carousel-caption d-none d-md-block">
            <center>
            <!-- For the Map and search -->
            <!-- <div class="searchcriteria">
                {!! Form::open(['url'=>'/filter','id'=>'filter']) !!}
                {{csrf_field()}}
                <center>
                    <div class="criteria" align="center">
                        <input type="text" id="searchaddress" name="searchaddress" class="address"  placeholder="Location .....">
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
                        {!! Form::submit('&nbsp;&nbsp;FIND',['class'=>'find','id'=>'find1'])!!}
                    </div>
                </center>
                {!! Form::close() !!}
            </div> -->
            <input type="button" name="transactionType" class="button1" onclick="propertyfunction()" id="sellRent1" value="SELL/GRANT A LEASE">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" onclick="location.href='{{url('/map')}}'" name="transactionType" class="button2" value="BUY/RENT">
            </center>
            <br>
            <br>
            <h2>INSTANT PLOT</h2>     
            <h3>YOUR ONE STOP PROPERTY HUB</h3>     
            </div>     
        </div>
        <div class="carousel-item">       
            <img  src="{{ asset('images/bg7.jpg') }}" height="595" width="100%">
            <div class="carousel-caption d-none d-md-block">
            <center>
            <!-- For the Map and search -->
            <!-- <div class="searchcriteria">
                {!! Form::open(['url'=>'/filter','id'=>'filter']) !!}
                {{csrf_field()}}
                <center>
                    <div class="criteria" align="center">
                        <input type="text" id="searchaddress" name="searchaddress" class="address"  placeholder="Location .....">
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
                        {!! Form::submit('&nbsp;&nbsp;FIND',['class'=>'find','id'=>'find2'])!!}
                    </div>
                </center>
                {!! Form::close() !!}
            </div> -->
            <input type="button"  name="transactionType" class="button1" onclick="propertyfunction()" id="sellRent2" value="SELL/GRANT A LEASE">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" onclick="location.href='{{url('/map')}}'" name="transactionType" class="button2" value="BUY/RENT">
            </center>
  
            <br>
            <br>   
            <h2>EXPLORE AT YOUR OWN TIME</h2>     
            <h3></h3>  
            </div>     
        </div> 
        <div class="carousel-item">       
            <img  src="{{ asset('images/bg6.jpg') }}" height="595" width="100%">     
            <div class="carousel-caption d-none d-md-block">    
            <center>
            <!-- For the Map and search -->
            <!-- <div class="searchcriteria">
                {!! Form::open(['url'=>'/filter','id'=>'filter']) !!}
                {{csrf_field()}}
                <center>
                    <div class="criteria" align="center">
                        <input type="text" id="searchaddress" name="searchaddress" class="address"  placeholder="Location .....">
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
                        {!! Form::submit('&nbsp;&nbsp;FIND',['class'=>'find','id'=>'find3'])!!}
                    </div>
                </center>
                {!! Form::close() !!}
            </div> -->
            <input type="button" id="sellRent3" name="transactionType" class="button1" onclick="propertyfunction()" value="SELL/GRANT A LEASE">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" onclick="location.href='{{url('/map')}}'" name="transactionType" class="button2" value="BUY/RENT">
            </center> 
            <br>
            <br>
            <h1>REST ASSURED YOUR MONEY IS SECURED</h1>   
            </div>
        </div> 

    <!-- Modal content -->
    <div class="modal property_modal-modal-lg" id="property_modal" tabindex="-1" role="dialog" aria-labelledby="instruction_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="property_modal">PROPERTIES OWNED</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" onclick="closeproperty()" id="close">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if($ownedLot)
                        <div align="left">
                        @foreach($ownedLot as $value)
                        @if($value->status=="null")
                        <a class="ownedProperties" href="{{url('/sell/'.$value->lotId.'/post')}}">property {{$value->lotNumber}}</a>&nbsp;&nbsp;&nbsp;&nbsp;
                        @else
                        <span style="font-size:80%;">property {{$value->lotNumber}}&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        @endif
                        @endforeach
                        </div>
                    @else
                        <center>
                        <font size="2" color="teal">no registered properties</font>
                        </center>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    
    <!-- <div class="map_detail" id="map_detail">
    {!! Form::open(['url'=>'/filter','id'=>'filter']) !!}
    {{csrf_field()}}
    <center>
        <div class="criteria" align="center">
            <input type="text" id="searchaddress" name="searchaddress" class="address"  placeholder="Location .....">
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
            {!! Form::submit('&nbsp;&nbsp;FIND',['class'=>'find','id'=>'find'])!!}
        </div>
    </center>
    {!! Form::close() !!}
        <div id="map"></div>
        <label id="legend"><h3>MAP Legend</h3></label>
    </div> -->
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxdYAzq688HGpFDMmvo3q9mSM2LfVIgjE&libraries=places&callback"> </script> -->
<script>
    // $(document).ready(function(){
    //     $("#map_detail").hide();
    //     $("#find").click(function(){
    //         $("#map_detail").show();
    //     });
    //     $("#find1").click(function(){
    //         $("#map_detail").show();
    //     });
    //     $("#find2").click(function(){
    //         $("#map_detail").show();
    //     });
    //     $("#find3").click(function(){
    //         $("#map_detail").show();
    //     });
    // });
    // Get the modal
    function propertyfunction() {
        $("#property_modal").show();
    }

    function closeproperty() {
        document.getElementById("property_modal").style.display = "none";
    }
</script>
@endsection