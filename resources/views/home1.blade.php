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
.home_body{
    background-image: url("/images/bg4.jpg");
    padding:15px 15px 15px 15px;
}
.dashboard_icons{
    <!-- border:1px solid lightgray !important; -->
}
.center{text-align:center}
th{border:1px solid gray;}

.dashboard th{width:170px}
@endsection
@section('body')
@if (session('poststatus'))
    <div align="center" class="alert alert-success" id="prompt">
        <h5>{{ session('poststatus') }}<i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h5>
    </div>
@endif
<br/>
<input type="button" name="" class="" onclick="otherpropertyfunction()" id="sellRent0" value="Add Lot Property">
<div class="modal otherproperty_modal-modal-lg" id="otherproperty_modal" tabindex="-1" role="dialog" aria-labelledby="instruction_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="property_modal">PROPERTY INFORMATION</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" onclick="othercloseproperty()" id="close">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" action="{{url('/seller/saveproperty')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="lotNumber" class="col-md-4 col-form-label text-md-right">{{ __('Lot Number') }}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="lotNumber" value="" required>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="lotTitleNumber" class="col-md-4 col-form-label text-md-right">{{ __('Lot Title Number') }}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="lotTitleNumber" value="">
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="lotArea" class="col-md-4 col-form-label text-md-right">{{ __('Lot Area') }}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="lotArea" value="" required>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="UnitOfMeasure" class="col-md-4 col-form-label text-md-right">{{ __('Unit of Measure') }}</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="UnitOfMeasure" required>
                                        <option value="sqm">Sqm</option>
                                        <option value="hectares">Hectares</option>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="lotNorthEastBoundary" class="col-md-4 col-form-label text-md-right">{{ __('Lot North East Boundary') }}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="lotNorthEastBoundary" value="">
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="lotNorthWestBoundary" class="col-md-4 col-form-label text-md-right">{{ __('Lot North West Boundary') }}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="lotNorthWestBoundary" value="">
                                </div>
                        </div>
                        <div class="text-center" style="margin:5px 15px 0px 15px;">
                            <input type="submit" value="Add Lot Property" class="btn btn-info btn-block rounded-5 py-2">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 
<br/>
    <div class="home_body" >
        <div class="dashboard_icons">
            <center>
                <table class="dashboard">
                    <thead>
                        <tr>
                            <th class="center">
                                <i class="fa fa-bar-chart" style="font-size:90px"></i><br/><font style="color:teal">{{count($propertysold)}}</font><br/>SOLD AND LEASED
                            </th>
                            <th class="center">
                                <a href="{{ route('dashboard') }}"><i class="fa fa-line-chart" style="font-size:90px"></i></a><br/><font style="color:teal">{{count($listall)}}</font><br/>POSTED<br/>
                            </th>
                            <th class="center">
                                <a href="{{ route('intendedlots') }}"><i class="fa fa-thumbs-o-up" style="font-size:90px"></i></a><br/><font style="color:teal">{{count($intended)}}</font><br>INTENDED<br/>
                            </th>
                            <th class="center">
                                <a href="{{ route('boughtrented') }}"><i class="fa fa-tags" style="font-size:90px"></i></a><br/><font style="color:teal">{{count($rented)}}</font><br>BOUGHT AND RENTED
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </center>
        </div>
    </div>
    <br/> 
    <!-- {!! Form::open(['url'=>'/filter','id'=>'filter']) !!}
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
            <option value="{{$prices['price']}}">{{number_format($prices['price'])}}</option>
            @endforeach
            </select>

            <select name="maxPrice" id="maxPrice"  class="select">
            <option value="">max price</option>
            @foreach($price as $prices)
            <option value="{{$prices['price']}}">{{number_format($prices['price'])}}</option>
            @endforeach
            </select>
            {!! Form::submit('&nbsp;&nbsp;FIND',['class'=>'find','id'=>'find'])!!}
        </div>
    </center>
{!! Form::close() !!} -->
    <!-- <img  src="{{ asset('images/bg4.jpg') }}" height="495" width="100%"> -->

<script>
    $(document).ready(function(){
        $("#map_detail").hide();
        $("#find").click(function(){
            $("#map_detail").show();
        });
    });
    // Get the modal
    function propertyfunction() {
        $("#property_modal").show();
    }

    function closeproperty() {
        document.getElementById("property_modal").style.display = "none";
    }


     function otherpropertyfunction() {
        $("#otherproperty_modal").show();
    }

    function othercloseproperty() {
        document.getElementById("otherproperty_modal").style.display = "none";
    }
</script>
@endsection
