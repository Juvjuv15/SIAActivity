@extends('header')
@section('styles')
.left {
     background-color: #effdff;
     width: 25%;
     height: 100%:
}
.edit{
    float: right;
}
td{
    vertical-align:top;
}
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
    left:80px;
    right:0px;
    bottom:100px;
    z-index:0;
    width:30%;
    height:45%;
}
@stop
@section('notification')
@if(count($notifications) == 0)
    No Notifications    
@else
            @foreach(Auth::user()->unreadNotifications as $notif)
            <a class="dropdown-item" href="{{url('/view/'.$notif->route.'/notif')}}">{{$notif['data']}}
            <small>{{date('F d, Y', strtotime($notif->created_at))}} </small>
            </a>
            @endforeach
@endif
@endsection
@section('body')
<div class="dashboard">
<table>
<tr>
<td class="left">
        <center>
            @if($picture==null)
                <img  class="profile" src="{{ asset('images/avatar3.png') }}" height="200" width="200"> 
                @endif
                @if($picture!=null)
                <img class="profile" src="{{ $picture->fileExt }}" height="200" width="200">  
                @endif
                <br>
        </center>
                @foreach($profile as $profiles)
                
                <font size="3"><b>{{ Auth::user()->name }} {{ Auth::user()->lname }}</b></font>
                <a href="{{url('/changeProfile/'.$profiles['id'].'/edit')}}">o<i class="fa fa-gear"  style="font-size:20px;color:white;"></i></a><br>
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
            </div>
            <a data-toggle="modal" data-target="#property_modal"><font color="white">CONFIRM PROPERTY OWNER</font></a>
</td>
<td>
@foreach($listall as $sellers)

<div class="form-group row">

<label class="col-md-7 col-form-label text-md-right">

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
<div class="col-md-5">
@if($sellers->status=="free")
<a class="edit" href="{{url('/seller/'.$sellers['tid'].'/edit')}}"><img  src="{{ asset('images/pencil.png') }}" height="15" width="15"></a>
@endif
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
@if($sellers->sellingstatus==null)
@if($sellers->count!=null)
@if($sellers->sellingtype=="For Sale")
No. of Potential Buyers<font color="red"><a href="{{url('/viewuserwhointended/'.$sellers['tid'].'/list')}}"><b> {{$sellers['count']}}</b></a></font>
@else
No. of Potential Leasers<font color="red"><a href="{{url('/viewuserwhointended/'.$sellers['tid'].'/list')}}"><b> {{$sellers['count']}}</b></a></font>
@endif
@endif
@endif
</center> 
@endforeach
</td>
</tr>
</table>
<!-- property owned modal -->
    <div class="modal fade property_modal-modal-md" id="property_modal" tabindex="-1" role="dialog" aria-labelledby="upload_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
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
                <font size="2" color="white">no registered properties</font>
                </center>
            @endif
            </div>
        </div>
    </div>
        @if (session('status'))
                <div align="center" class="alert alert-success" id="prompt">
                    <h6>{{ session('status') }}<i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h6>
                </div>
        @endif
        @if (session('lotstatus'))
            <div align="center" class="alert alert-danger" id="prompt">
                <h5>{{ session('lotstatus') }}<i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h5>
            </div>
        @endif

        @if (session('poststatus'))
            <div align="center" class="alert alert-success" id="prompt">
                <h5>{{ session('poststatus') }}<i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h5>
            </div>
        @endif
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