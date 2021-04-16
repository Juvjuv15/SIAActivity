@extends('header')
@section('styles')
      #map {
        height: 100%;
        width: 100%;
      }
      <!-- /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      } -->
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
    padding: 12px 30px 12px 9px;
    outline:none !important;
} 
.select{
    width: 188px;
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
    background: linear-gradient(to right, #63c8c9, #32fa95);
    margin-left: -20px;
    padding: 10px 45px 10px 10px;
    outline:none !important;
}
.find:hover{
  background: linear-gradient(to right, #32fa95, #63c8c9);
}
.criteria{
  width: 1100px;
  border:2px solid #63c8c9;
  border-radius:50px;
  background-color: #63c8c9;
  padding: 5px 5px 5px 5px;
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
            <div align="center" class="alert alert-danger" id="prompt">
              <h5>{{ session('intendedstatus') }}<i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h5>
            </div>
        @endif
        {!! Form::open(['url'=>'/filter','id'=>'filter']) !!}
        {{csrf_field()}}
        <center><div class="criteria" align="center">
          <!-- <label id="result"></label> -->
          <!-- <input type="text" name="searchaddress" id="searchaddress"> -->
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
          {!! Form::submit('&nbsp;&nbsp;FIND',['class'=>'find'])!!}
          
          {!! Form::close() !!}
        </div>
        </center>
        <div id="countresult"></div>
        <div id="lotresult"></div>

        <div id="map"></div>
        <label id="legend"><h3>MAP Legend</h3></label>
      </div><!-- end begin right -->
    </div><!-- end rightcolumn -->
</div><!-- end div start  -->
</div><!-- end div admin  -->

@section('js')
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxdYAzq688HGpFDMmvo3q9mSM2LfVIgjE&libraries=places&callback">  
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js">
  </script>
  <!-- script for the map -->
  <script src="{{asset('js/script.js')}}"></script>
  
  <!-- <script>$.ajaxSetup({
    headers:{'X-CSRF-Token':$('meta[name=_token]').attr('content')}
  });</script> -->
@stop
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