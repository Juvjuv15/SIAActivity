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
.lease,.sold{
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
    z-index:99;
}
.lease:hover, .sold:hover {
    background: teal;
    text-decoration: none; 
    color: white;
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

<div class="row">
@foreach($listallintendedlots as $sellers)
<div class="col-xl-12 col-lg-3">
    <div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                {{$sellers->sellingtype}}&emsp;{{$sellers['slottype']}}<br/>
                P{{number_format($sellers['lotprice'],2)}} {{$sellers['paymenttype']}}<br/>
                Located at {{$sellers['slotaddress']}}
            </h6>
            <h6>
            @if($sellers->count!=null)
                    @if($sellers->sellingtype=="For Sale")
                        @if($sellers->sellingstatus==null)
                            (<font size="2">No. of Potential Buyers <a href="{{url('/viewuserwhointended/'.$sellers['tid'].'/list')}}"><b> {{$sellers['count']}}</b></a></font>)
                        @endif
                    @else
                        @if($sellers->sellingstatus==null)
                            (<font size="2">No. of Potential Leasers <a href="{{url('/viewuserwhointended/'.$sellers['tid'].'/list')}}"><b> {{$sellers['count']}}</b></a></font>)
                        @endif
                    @endif
                @endif
            </h6>
        </div>
    <!-- Card Body -->
            <div class="card-body">
                @foreach($sellers->images as $image)
                    @if($image->filetype == "image")    
                    <center>
                        <label class="col-md-11 col-form-label">        
                            <div id="makeMeScrollable" class="scrollableArea">
                                <img class="image" src="{{ $image->fileExt }}"> 
                            </div>
                        </label>
                    </center>   
                    @endif
                @endforeach
                <br/>
                <table  width="100%">
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
                                        <img src="{{ asset('images/detail1.png') }}">&emsp;{{$sellers['slotarea']}}
                                    </td>
                                    <td class="f10">
                                        <img src="{{ asset('images/detail2.png') }}">&emsp;{{str_replace(" ", ",",$sellers['rightofway'])}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="bold f12"><b>Description</b></td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" style="border-left:2px solid gray;">
                                <!-- <tr><td>&nbsp;</td></tr> -->
                                <tr>
                                    <td class="description f10">
                                            {{$sellers['lotdescription']}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    @if($sellers->paymenttype!="Cash")
                        <tr>
                            <td class="bold f12"><b>Additional Details</b></td>
                        </tr>
                        <!-- <tr><td>&nbsp;</td></tr> -->
                    @endif
                    <tr>
                        <td>
                            <table width="100%" style="border-left:2px solid gray;">
                                <tr>
                                    @if($sellers->sellingtype=="For Lease")
                                        <td width="20%" class="f10">Advance Deposit</td>
                                    @endif
                                    @if($sellers->paymenttype=="Installment")
                                        @if($sellers->interest!=null)
                                            <td class="f10">Interest</td>
                                        @endif
                                        @if($sellers->installmentdownpayment!=null)
                                        <td class="f10">Downpayment</td>
                                        @endif
                                        <td class="f10">Years/Months to pay remaining balance</td>
                                        <td class="f10">Payment</td>
                                    @endif
                                </tr>
                                <tr>
                                    @if($sellers->sellingtype=="For Lease")
                                        <td class="f10">{{$sellers['leasedeposit']}}</td>
                                    @endif
                                    @if($sellers->paymenttype=="Installment")
                                        @if($sellers->interest!=null)
                                            <td class="f10">{{$sellers['interest']}}%</td>
                                        @endif
                                        @if($sellers->installmentdownpayment!=null)
                                            <td class="f10">{{number_format($sellers['installmentdownpayment'])}}</td>
                                        @endif
                                        <td class="f10">{{$sellers['installmenttimetopay']}}</td>
                                        <td class="f10">{{$sellers['installmentPaymentType']}} (P{{number_format($sellers['installmentPayment'],2)}} {{$sellers['installmentPaymentType']}})</td>
                                    @endif
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <a href="{{url('/documents/'.$sellers['tid'].'/view')}}">view attached proofs</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <font color="red" size="1"><b>{{ __('Date Posted') }}</b></font> <font color="" size="1">{{date('F d, Y', strtotime($sellers['created_at']))}}</font>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    @endforeach
</div>
@section('js')
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
@endsection
@stop