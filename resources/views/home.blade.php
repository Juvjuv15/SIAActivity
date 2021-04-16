@extends('header')
<style>

</style>
@section('styles')
a:hover {
  text-decoration: none !important;
}
@endsection

@section('body')
@if (session('poststatus'))
    <div align="center" class="alert alert-success" id="prompt">
        <h5>{{ session('poststatus') }}<i onclick="w3_close()" class="fa fa-times w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h5>
    </div>
@endif
@if (session('poststatusinvalid'))
    <div align="center" class="alert alert-danger" id="prompt">
        <h5>{{ session('poststatusinvalid') }}<i onclick="w3_close()" class="fa fa-times w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h5>
    </div>
@endif
@if (session('poststatuswarning'))
    <div align="center" class="alert alert-warning" id="prompt">
        <h5>{{ session('poststatuswarning') }}<i onclick="w3_close()" class="fa fa-times w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h5>
    </div>
@endif
@if (session('poststatusdanger'))
    <div align="center" class="alert alert-danger" id="prompt">
        <h5>{{ session('poststatusdanger') }}<i onclick="w3_close()" class="fa fa-times w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h5>
    </div>
@endif
@if (session('favoritestatus'))
        <div align="center" class="alert alert-success" id="prompt">
            <h6>{{ session('favoritestatus') }}<i onclick="w3_close()" class="fa fa-times w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h6>
        </div>
@endif
<br/>
<!-- NAVBAR -->
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="clickseller" data-toggle="tab" href="#" role="tab" aria-controls="seller" aria-selected="true">AS A SELLER</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="clickbuyer" data-toggle="tab" href="#" role="tab" aria-controls="buyer" aria-selected="false">AS A BUYER</a>
  </li>
</ul>

  <!-- ORIGINAL CODE BELOW -->
          <!-- Page Heading -->
            <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">&nbsp;</h1>
            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;
            <a href="#" id="clickseller" data-toggle="modal" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm pl-2"> -->
            <!-- <i class="fas fa-plus-square fa-sm text-white-50"></i> -->
            <!-- data-target="#addPropertyModal"  -->
            <!-- As a Seller</a> &emsp;&emsp;&emsp;&emsp;
            <a href="#" id="clickbuyer" data-toggle="modal" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"> -->
            <!-- <i class="fas fa-plus-square fa-sm text-white-50"></i> -->
            <!-- data-target="#addBuyerPropertyModal"  -->
            <!-- As a Buyer</a> 
            </div>  -->

<div id="sellerni" class="row">
        <div class="container">
        <br>
        <div class="col-xl-3 col-md-6 mb-4">              
        <a href="#" id="addproperty" data-target="#addBuyerPropertyModal" data-toggle="modal" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus-square fa-sm text-white-50"></i> 
        Add Property</a> 
        </div>
        </div>
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-danger shadow h-25 py-2">
        <a href="#" data-toggle="modal" data-target="#propertyModal">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-s font-weight-bold text-danger text-uppercase mb-1">LIST OF PROPERTIES</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{count($ownedLot)}}</div>
                <div class="text-s font-weight-bold text-danger text-uppercase mb-1">PENDING</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{count($pendingLot)}}</div>
            </div>
            <div class="col-auto">
                <i class="fas fa-user fa-2x text-gray-300"></i>
            </div>
            </div>
        </div>
        </a>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
     <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-25 py-2">
        <a href="{{ route('dashboardsell') }}">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-s font-weight-bold text-primary text-uppercase mb-1">FOR SALE</div>
                <!-- <div class="h5 mb-0 font-weight-bold text-gray-800">{{count($forsale)}}</div> -->
            </div>
            <div class="col-auto">
                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
            </div>
            </div>
        </div>
        </a>
        </div>
     </div> 

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-25 py-2">
        <a href="{{route('propertiesSold')}}">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-s font-weight-bold text-success text-uppercase mb-1">SOLD</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
            </div>
            <div class="col-auto">
                <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                <!-- <i class="fa-2x text-gray-300">&#8369;</i> -->
            </div>
            </div>
        </div>
        </a>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-25 py-2">
        <a href="{{ route('dashboardlease') }}">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-s font-weight-bold text-primary text-uppercase mb-1">FOR LEASE</div>
                <!-- <div class="h5 mb-0 font-weight-bold text-gray-800">{{count($forlease)}}</div> -->
            </div>
            <div class="col-auto">
                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
            </div>
            </div>
        </div>
        </a>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">    
        <div class="card border-left-orange shadow h-25 py-2">
        <a href="{{route('propertiesGrantedForLease')}}">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-s font-weight-bold text-orange text-uppercase mb-1">GRANTED AS LEASED</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
            </div>
            <div class="col-auto">
                <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
            </div>
            </div>
        </div>
        </a>
        </div>
    </div>

     <!-- Earnings (Monthly) Card Example -->
     <div class="col-xl-3 col-md-6 mb-4">    
        <div class="card border-left-orange shadow h-25 py-2">
        <a href="{{route('propertiesRenew')}}">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-s font-weight-bold text-orange text-uppercase mb-1">CONTRACT RENEWAL</div>
                <div class="h5 mb-0 font-weight-bold text-red-800">{{count($renew)}}</div>
            </div>
            <div class="col-auto">
                <i class="fas fa-user fa-2x text-gray-300"></i>
            </div>
            </div>
        </div>
        </a>
        </div>
    </div>

</div>

<!-- AS A BUYER -->
<div id="buyerni" class="row">
    <div class="container">
    <br>    
        <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4"> -->
           <!-- <h1 class="h3 mb-0 text-gray-800">&nbsp;</h1>   -->
        <div class="col-xl-3 col-md-6 mb-4">           
              <a href="{{'/map'}}"class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-search fa-sm text-white-50"></i>Find Property</a>
          </div>    
        </div>


    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">    
    <div class="card border-left-info shadow h-25 py-2">
        <a href="{{ route('intendedlots') }}">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-s font-weight-bold text-info text-uppercase mb-1">PROPERTIES YOU ARE INTERESTED TO BUY/LEASE</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
            </div>
            <div class="col-auto">
            <i class="fas fa-bookmark fa-2x text-gray-300"></i>
                <!-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> -->
            </div>
            </div>
        </div>
        </a>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">    
        <div class="card border-left-warning shadow h-25 py-2">
        <a href="{{ route('boughtproperties') }}">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-s font-weight-bold text-warning text-uppercase mb-1">BOUGHT</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
            </div>
            <div class="col-auto">
            <i class="fas fa-hands-helping fa-2x text-gray-300"></i>
                <!-- <i class="fas fa-comments fa-2x text-gray-300"></i> -->
            </div>
            </div>
        </div>
        </a>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">    
        <div class="card border-left-violet shadow h-25 py-2">
        <a href="{{ route('rentedproperties') }}">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
            <div class="col mr-2">
                <div class="text-s font-weight-bold text-violet text-uppercase mb-1">LEASED</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
            </div>
            <div class="col-auto">
            <i class="fas fa-thumbtack fa-2x text-gray-300"></i>
                <!-- <i class="fas fa-comments fa-2x text-gray-300"></i> -->
            </div>
            </div>
        </div>
        </a>
        </div>
    </div>
    <div class="col-xl-12 col-md-6 mb-1">    
    <div id="countresult"></div>
    <br/>
        <div id="lotresult"></div>

        <div id="map"></div>
    <label id="legend"><h3>MAP Legend</h3></label>
</div>
    </div>
    

</div> 
@section('js')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxdYAzq688HGpFDMmvo3q9mSM2LfVIgjE&libraries=places&callback">  
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js">
  </script>
  <!-- script for the map -->
  <script src="{{asset('js/script.js')}}" type="text/javascript"></script>
<script>

    $(document).ready(function(){
        $("#sellerni").show();
        $("#buyerni").hide();   
        $("#addproperty").hide(); 
        // $("#map").hide(); 
        // $("#legend").hide(); 

        $("#clickbuyer").click(function(){
            $("#sellerni").hide();            
            $("#buyerni").show();
        });

        $("#clickseller").click(function(){
            $("#sellerni").show();            
            $("#buyerni").hide();
            $("#addproperty").show();            

        });
    });


</script>
@stop
@endsection
<style type="text/css">
 #map {
        height: 100%;
        width: 100%;
      }
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