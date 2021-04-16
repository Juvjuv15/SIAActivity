@extends('header')
@section('styles')
.bold{font-weight:bold !important;}
.button{
    font-family: sans-serif;
    font-size: 10pt;
    font-weight: 20;
    text-align: left !important;
    color: white;
    width: 18%;
    box-sizing: border-box;
    border: 2px solid white;
    border-radius: 50px;
    background-color: #63c8c9;
    padding: 10px 25px 10px 25px;
    margin-left:740px;
    position:absolute;
    z-index:99;
    outline:none !important;
}
.caps{text-transform:uppercase;}
.center{text-align:center;}
.description{color:gray;}
.f10{font-size:10pt;}
.f12{font-size:12pt;}
.f20{font-size:20pt;}
.left {
     background-color:#f1f6f9;
     <!-- width: 28%; -->
     height: 100%:
}
.edit{
    float: right;
}
td{
    vertical-align:top;
}

.picture{height:380px;width:285px;margin:10px;}
.right{text-align:right;}
.status{
    position:absolute;
    <!-- left:80px; -->
    <!-- right:50px;-->
    bottom:-200px; 
    z-index:99;
    width:22%;
    height:35%;
}

@stop
@section('body')
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
@if (session('favoritestatus'))
        <div align="center" class="alert alert-success" id="prompt">
            <h6>{{ session('favoritestatus') }}<i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h6>
        </div>
@endif
@if (session('intendedstatus'))
    <div align="center" class="alert alert-danger" id="prompt">
        <h5>{{ session('intendedstatus') }}<i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h5>
    </div>
@endif
<table>
<tr>
    <!-- <td class="left">
    <center>
        @if($picture==null)
            <img  class="picture" src="{{ asset('images/avatar3.png') }}"> 
            @endif
            @if($picture!=null)
            <img class="picture" src="{{ $picture->fileExt }}">  
        @endif
            <br>
    </center>
        @foreach($profile as $profiles)
            <div align="center" style="color:gray;">
                <font size="4"><b>{{ Auth::user()->name }} {{ Auth::user()->lname }}</b></font>
                <a href="{{url('/changeProfile/'.$profiles->id.'/edit')}}"><i class="fa fa-gear"  style="font-size:20px;color:gray;"></i></a><br>
                <font size="1">Member since {{date('F d, Y', strtotime(Auth::user()->created_at))}}</font><br/>
                <font size="2">
                    <b><i class="fa fa-bookmark"></i></b>
                    {{ Auth::user()->address }}<br>
                    <b><i class="fa fa-envelope"></i> </b>
                    {{ Auth::user()->email }}<br>
                    <b><i class="fa fa-phone"></i> </b>
                    {{ Auth::user()->contact }}<br>
                    {{ Auth::user()->secondarycontact }}
                </font>
                <br/>
                <a data-toggle="modal" data-target="#property_modal" class="property_owned"><font color="gray">PROPERTIES</font></a>
            </div>
         @endforeach
    </td> -->
    <br/>
    <div class="title_header"><h2>&nbsp;PROPERTIES YOU ARE INTERESTED TO BUY/RENT</h2></div>
    <hr/>
    <td style="padding:10px 10px 10px 170px;">
    @foreach($dashboard as $intended)
    <div class="button right">
        {{$intended->sellingtype}}<br/>
        P{{number_format($intended->lotprice,2)}} {{$intended->paymenttype}}
    </div>

    <table>
        <tr>
            <td class="bold caps f20 phead" width="40%">
                {{$intended->slottype}}
            </td>
        </tr>
        <tr>
            <td class="bold" style="padding-left:0px; color:gray;">
                {{$intended->slotaddress}}
                <!-- @if($intended->count!=null)
                    @if($intended->sellingtype=="For Sale")
                        (<font size="2">No. of Potential Buyers <b> {{$intended->count}}</b></a></font>)
                    @else
                        (<font size="2">No. of Potential Leasers <b> {{$intended->count}}</b></a></font>)
                    @endif
                @endif -->
            </td>
        </tr>
    </table>
    <table>
        <tr>
            @if($intended->sellingstatus!=null)
                @if($intended->sellingtype=="For Lease")
                    <img src="{{ asset('images/rent.png') }}" class="status">
                @else
                    <img src="{{ asset('images/sold1.png') }}" class="status">
                @endif
            @endif
            <td>
            <center>
                @if($intended->filetype == "image")       
                <label class="col-md-11 col-form-label text-md-right">        
                    <div id="makeMeScrollable" class="scrollableArea">
                        <img class="image" src="{{ $intended->fileExt }}"> 
                    </div>
                </label>
                @endif
            </center>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%">
                    <tr>
                        <td class="bold f12"><b>General Information</b></td>
                    </tr>
                    <!-- <tr><td>&nbsp;</td></tr> -->
                    <tr>
                        <td>
                            <table width="100%" style="background-color:#f1f6f9;">
                                <tr>
                                    <td width="20%" class="f10">Area</td>
                                    <td class="f10">Vehicle Access on Way</td>
                                </tr>
                                <tr>
                                    <td class="f10">
                                        <img src="{{ asset('images/detail1.png') }}">&emsp;{{$intended->slotarea}}
                                    </td>
                                    <td class="f10">
                                        <img src="{{ asset('images/detail2.png') }}">&emsp;{{str_replace(" ",",",$intended->rightofway)}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr><td>&nbsp;</td></tr>
                    <tr>
                        <td class="bold f12"><b>Description</b></td>
                    </tr>
                    <!-- <tr><td>&nbsp;</td></tr> -->
                    <tr>
                        <td class="description f10">
                                {{$intended->lotdescription}}
                        </td>
                    </tr>
                    <tr><td>&nbsp;</td></tr>
                    @if($intended->paymenttype!="Cash")
                        <tr>
                            <td class="bold f12"><b>Additional Details</b></td>
                        </tr>
                        <!-- <tr><td>&nbsp;</td></tr> -->
                    @endif
                    <tr>
                        <td>
                            <table width="100%" style="border-left:2px solid gray;">
                                <tr>
                                    @if($intended->sellingtype=="For Lease")
                                        <td width="20%" class="f10">Advance Deposit</td>
                                    @endif
                                    @if($intended->paymenttype=="Installment")
                                        @if($intended->interest!=null)
                                            <td class="f10">Interest</td>
                                        @endif
                                        @if($intended->installmentdownpayment!=null)
                                        <td class="f10">Downpayment</td>
                                        @endif
                                        <td class="f10">Years/Months to pay remaining balance</td>
                                        <td class="f10">Payment</td>
                                    @endif
                                </tr>
                                <tr>
                                    @if($intended->sellingtype=="For Lease")
                                        <td class="f10">{{$intended->leasedeposit}}</td>
                                    @endif
                                    @if($intended->paymenttype=="Installment")
                                        @if($intended->interest!=null)
                                            <td class="f10">{{$intended->interest}}%</td>
                                        @endif
                                        @if($intended->installmentdownpayment!=null)
                                            <td class="f10">{{number_format($intended->installmentdownpayment)}}</td>
                                        @endif
                                        <td class="f10">{{$intended->installmenttimetopay}}</td>
                                        <td class="f10">{{$intended->installmentPaymentType}} (P{{number_format($intended->installmentPayment,2)}} {{$intended->installmentPaymentType}})</td>
                                    @endif
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="{{url('/document/'.$intended->tid.'/view')}}">view attached proofs</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <font color="red" size="1"><b>{{ __('Date Posted') }}</b></font> <font color="" size="1">{{date('F d, Y', strtotime($intended->created_at))}}</font>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!-- <a href="{{url('/documents/'.$intended->tid_fk.'/view')}}">view attached proofs</a> -->
    <!-- <hr/> -->
    @endforeach
    </td>
</tr>
</table>

<!-- property owned modal -->
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
@stop