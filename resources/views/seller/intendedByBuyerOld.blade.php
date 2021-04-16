@extends('header')
@section('styles')

.leftcolumn { 
    background-color: white;  
    float: right;
    width: 75%;
    padding-left: 10px;
    
    <!-- padding-right: 10px;
    padding-top: 10px; -->
}

.rightcolumn {
    float: right;
    width: 25%;
    padding-left:0px;

}

.begin {
     font-family: "Roboto Condensed", sans-serif;
     background-color: #067280;
     width: 100%;
     height: 100%;
     border:1px;
     border-radius: 0px;
     margin-top: 0px;
     padding:10px;
}

.beginleft {
    font-family: "Roboto Condensed", sans-serif;
     background-color: white;
     padding: 20px;
     height: 100%;
     width: 100%;
}
<!-- /* Clear floats after the columns */ -->
.start:after {
    content: "";
    display: table;
    clear: both;
}

<!-- /* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other */ -->
<!-- @media screen and (max-width: 800px) {
    .leftcolumn, .rightcolumn {   
        width: 100%;
        padding: 0;
    }
    
}  -->

.ownedProperties{
    color:#72cdd8;
    font-size:80% !important;
    margin:15px;
}

.ownedProperties:hover{
    text-decoration: none; 
    color: red;

}

.status{
    position:absolute;
    left:0px;
    right:0px;
    bottom:40px;
    z-index:0;
    width:50%;
    height:70%;
}
@stop
@section('notification')
@if(count($notifications) == 0)
    No Notifications    
@else
    @foreach(Auth::user()->unreadNotifications as $notif)
            <a class="dropdown-item" href="{{url('adminLanding')}}">{{$notif['data']}}
            <a class="dropdown-item" href="{{url('dashboard')}}">{{$notif['data']}}
            <br>
            <small>{{date('F d, Y', strtotime($notif->created_at))}} </small>
            </a>
            @endforeach
@endif
@endsection
@section('body')
<div class="dashboard">
<div class="start">
<div class="leftcolumn">
@foreach($listallintendedlots as $sellers)
<div class="beginleft">
<div class="form-group row">
<label class="col-md-6 col-form-label text-md-right">
@foreach($sellers->images as $image)
  @if($image->filetype == "image")
  
  <div id="makeMeScrollable">
    <img class="image" src="{{ $image->fileExt }}"> 
 </div>
  @else
    <video src="{{ $image->fileExt }}" height="300px" width:"100%" controls> 
    </video>
  @endif
  <!-- </td>    -->
  @endforeach
</label>
<div class="col-md-6">
  @if($sellers->sellingstatus!=null)
  @if($sellers->sellingtype=="For Lease")
  <img src="{{ asset('images/rent.png') }}" class="status">
  @else
  <img src="{{ asset('images/sold1.png') }}" class="status">
  @endif
  @endif
  <b>
  {{$sellers['sellingtype']}} 
  {{$sellers['slottype']}}
  </b>
  <br>
  <img src="{{ asset('images/location.png') }}" height="13" width="13"> {{$sellers['slotaddress']}}
  <br>
  <!-- <b>Lot number: </b>{{$sellers['slotnumber']}} -->
  <!-- <br> -->
  <b>Area: </b>{{$sellers['slotarea']}}
  <br>
  
<b>Price: </b>{{$sellers['lotprice']}}
<br>
<b>Mode of Payment: </b>{{$sellers['paymenttype']}}
<br>

@if($sellers->sellingtype=="For Lease")
<b>Advance Deposit: </b>{{$sellers['leasedeposit']}}
<br>
@endif

@if($sellers->paymenttype=="Installment")
        @if($sellers->interest!=null)
        <b>Interest Rate: </b>{{$sellers['interest']}}%
        <br>
        @endif
        @if($sellers->installmentdownpayment!=null)
        <b>Downpayment: </b>{{$sellers['installmentdownpayment']}}
        <br>
        @endif
        <b>Years/Months to pay remaining balance: </b>{{$sellers['installmenttimetopay']}}
        <br>
        <b>Payment Type: </b>{{$sellers['installmentPaymentType']}} ({{$sellers['installmentPayment']}} {{$sellers['installmentPaymentType']}})
        <br>

@endif


@if($sellers->lotdescription!=null)
        <b>Property Description:</b>
        <br>
        {{$sellers['lotdescription']}}
        <br>
@endif
@foreach($owner as $owned)
<b><i class="fa fa-phone"></i> </b>
 {{$owned['contact']}}
@if($owned->secondarycontact!=null)
<br>
&nbsp;&nbsp;&nbsp;&nbsp;{{$owned['secondarycontact']}}
 @endif
 <br>
 <b><i class="fa fa-envelope"></i> </b>
<a href="#">{{$owned['email']}}</a>
  @endforeach
<br>
<a href="{{url('/documents/'.$sellers['tid'].'/view')}}">view attached proofs</a>
<br>
<font color="red" size="1"><b>{{ __('Date Posted') }}</b></font> <font color="" size="1">{{date('F d, Y', strtotime($sellers['created_at']))}}</font>
</div>
</div>
<center>
@if($sellers->count!=null)
@if($sellers->sellingtype=="For Sale")
No. of Potential Buyers<font color="red"><a href="{{url('/viewuserwhointended/'.$sellers['tid'].'/list')}}"><b> {{$sellers['count']}}</b></a></font>
@else
No. of Potential Leasers<font color="red"><a href="{{url('/viewuserwhointended/'.$sellers['tid'].'/list')}}"><b> {{$sellers['count']}}</b></a></font>
@endif
@endif
</center> 
</div>
    @endforeach
  </div>

  <div class="rightcolumn">
    <div class="begin" align="center">
                @if($picture==null)
                <img  class="profile" src="{{ asset('images/avatar3.png') }}" height="200" width="200"> 
                @endif
                @if($picture!=null)
                <img class="profile" src="{{ $picture->fileExt }}" height="200" width="200">  
                @endif
                <br>

                @foreach($profile as $profiles)                
                <font size="3"><b>{{ Auth::user()->name }} {{ Auth::user()->lname }}</b></font>
                <a href="{{url('/changeProfile/'.$profiles['id'].'/edit')}}"><i class="fa fa-gear"  style="font-size:20px;color:white;"></i></a><br>
                <font size="1">Member since {{date('F d, Y', strtotime(Auth::user()->created_at))}}</font>

                <div align="left">
                <b><i class="fa fa-bookmark"></i></b>
                {{ Auth::user()->address }}<br>
                <b><i class="fa fa-envelope"></i> </b>
                {{ Auth::user()->email }}<br>
                <b><i class="fa fa-phone"></i> </b>
                {{ Auth::user()->contact }}<br>&nbsp;&nbsp;&nbsp;
                {{ Auth::user()->secondarycontact }}
                </div>
                @endforeach

             @if (session('status'))
            <div align="center">
            <div class="col-md-12">

                <div align="center" class="alert alert-success" id="prompt">
                    <h6>{{ session('status') }}<i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h6>

                </div>
            </div>
            </div>
            @endif
            <hr>
            @if($ownedLot)
            <center>
            <h3>Registered Properties</h3>
            </center>
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
                <h3>Registered Properties</h3>
                <font size="2" color="gray">no registered properties</font>
                </center>
            @endif
    </div>
  </div>
  
</div>
</div>

<script src="{{asset('js/jquery-ui-1.10.3.custom.min.js')}}" type="text/javascript"></script>  
<script src="{{asset('js/jquery.mousewheel.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/jquery.kinetic.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/jquery.smoothdivscroll-1.3-min.js')}}" type="text/javascript"></script>  

<script type="text/javascript">
	$(document).ready(function () {
			// None of the options are set
			$("div#makeMeScrollable").smoothDivScroll({
				manualContinuousScrolling: true,
				autoScrollingMode: "onStart",
				hotSpotScrolling: false,
				touchScrolling: true
			});
		});

  </script>

<style>
  .profile {
    border-radius: 50%;
    /* border: 1px solid gray; */

    }

</style>
@stop