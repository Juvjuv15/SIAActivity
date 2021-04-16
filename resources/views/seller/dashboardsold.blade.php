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
    left:85%;
    <!-- right:50px; -->
    bottom:-200px; 
    z-index:99;
    width:15%;
    height:20%;
}
@stop
@section('body')
<div class="row">
    @if (session('status'))
        <div align="center" class="alert alert-success" id="prompt">
            <h6>{{ session('status') }}<i onclick="w3_close()" class="fa fa-times w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h6>
        </div>
    @endif
    @if (session('lotstatus'))
        <div align="center" class="alert alert-danger" id="prompt">
            <h5>{{ session('lotstatus') }}<i onclick="w3_close()" class="fa fa-times w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h5>
        </div>
    @endif
    @if (session('updatestatus'))
        <div align="center" class="alert alert-success" id="prompt">
            <h5>{{ session('updatestatus') }}<i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h5>
        </div>
    @endif
    @if (session('repoststatus'))
        <div align="center" class="alert alert-success" id="prompt">
            <h5>{{ session('repoststatus') }}<i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h5>
        </div>
    @endif
    @if (session('poststatus'))
        <div align="center" class="alert alert-success" id="prompt">
            <h5>{{ session('poststatus') }}<i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h5>
        </div>
    @endif
@foreach($listall as $sellers)
<div class="col-xl-12 col-lg-3">
    <div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                {{$sellers->sellingType}}&emsp;{{$sellers->lotType}}<br/>
                P{{number_format($sellers->lotPrice,2)}} {{$sellers->paymentType}}<br/>
                Located at {{$sellers->lotAddress}}<br/>
                Property Number {{$sellers->lotNumber}}
            </h6>
        </div>
    <!-- Card Body -->
            <div class="card-body">
                    <center>
                        <label class="col-md-11 col-form-label">        
                            <div id="makeMeScrollable" class="scrollableArea">
                                <img class="image" src="{{ $sellers->fileExt }}"> 
                            </div>
                        </label>
                    </center>   
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
                                        <img src="{{ asset('images/detail1.png') }}">&emsp;{{$sellers->lotArea}} {{$sellers->unitOfMeasure}}
                                    </td>
                                    <td class="f10">
                                        <img src="{{ asset('images/detail2.png') }}">&emsp;{{str_replace(" ", ",",$sellers->rightOfWay)}}
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
                                            {{$sellers->lotDescription}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    @if($sellers->paymentType!="Cash")
                        <tr>
                            <td class="bold f12"><b>Additional Details</b></td>
                        </tr>
                        <!-- <tr><td>&nbsp;</td></tr> -->
                    @endif
                    <tr>
                        <td>
                            <table width="100%" style="border-left:2px solid gray;">
                                <tr>
                                    @if($sellers->sellingType=="For Lease")
                                        <td width="20%" class="f10">Advance Deposit</td>
                                    @endif
                                    @if($sellers->paymentType=="Installment")
                                        @if($sellers->interest!=null)
                                            <td class="f10">Interest</td>
                                        @endif
                                        @if($sellers->installDownPayment!=null)
                                        <td class="f10">Downpayment</td>
                                        @endif
                                        <td class="f10">Years/Months to pay remaining balance</td>
                                        <td class="f10">{{$sellers->installPaymentType}} Payment</td>
                                    @endif
                                </tr>
                                <tr>
                                    @if($sellers->sellingType=="For Lease")
                                        <td class="f10">{{$sellers->leaseDeposit}}</td>
                                    @endif
                                    @if($sellers->paymentType=="Installment")
                                        @if($sellers->interest!=null)
                                            <td class="f10">{{$sellers->interest}}%</td>
                                        @endif
                                        @if($sellers->installDownPayment!=null)
                                            <td class="f10">{{number_format($sellers->installDownPayment)}}</td>
                                        @endif
                                        <td class="f10">{{$sellers->installTimeToPay}}</td>
                                        <td class="f10">P{{number_format($sellers->installmentPayment,2)}}</td>
                                    @endif
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="{{url('/contracts/'.$sellers->tid.'/view')}}">VIEW CONTRACT</a>
                            <!-- <a href="{{url('/documents/'.$sellers['tid'].'/view')}}">view attached proofs</a> -->
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <font color="red" size="2"><b>{{ __('Sold To') }}</b></font> <font color="" size="2">{{$sellers->leaserbuyer}}</font> &emsp;
                            <font color="red" size="2"><b>{{ __('Date Sold') }}</b></font> <font color="" size="2">{{$sellers->datesold}}</font>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

@endforeach
</div>
<center>{{ $listall->links() }}</center>
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