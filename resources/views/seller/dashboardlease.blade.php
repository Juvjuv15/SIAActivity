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
    left:80%;
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
            <h5>{{ session('updatestatus') }}<i onclick="w3_close()" class="fa fa-times w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h5>
        </div>
    @endif
    @if (session('repoststatus'))
        <div align="center" class="alert alert-success" id="prompt">
            <h5>{{ session('repoststatus') }}<i onclick="w3_close()" class="fa fa-times w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h5>
        </div>
    @endif
    @if (session('poststatus'))
        <div align="center" class="alert alert-success" id="prompt">
            <h5>{{ session('poststatus') }}<i onclick="w3_close()" class="fa fa-times w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h5>
        </div>
    @endif
@foreach($lease as $sellers)
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
            
            <h6>
                @if($sellers->count!=null)
                    @if($sellers->sellingType=="For Sale")
                        @if($sellers->sellingStatus==null)
                            (<font size="2">No. of Interested Buyers <a href="{{url('/viewuserwhointended/'.$sellers['tid'].'/list')}}"><b> {{$sellers['count']}}</b></a></font>)
                        @endif
                    @else
                        @if($sellers->sellingStatus==null)
                            (<font size="2">No. of Interested Leasers <a href="{{url('/viewuserwhointended/'.$sellers['tid'].'/list')}}"><b> {{$sellers['count']}}</b></a></font>)
                        @endif
                    @endif
                @endif
                @if($sellers->sellingStatus!="leased")
                <a href="{{url('/seller/'.$sellers['tid'].'/edit')}}" class="buttonImage view" data-toggle="tooltip" data-placement="left" title="UPDATE"> <b><i class="fa fa-edit" style="color:teal"></i> </b></a>
                @endif
                <!-- @if($sellers->status=="intended" && $sellers->sellingStatus=="leased")           
                    <a href="{{url('/seller/'.$sellers['tid'].'/repost')}}" class="buttonImage view" data-toggle="tooltip" data-placement="left" title="REPOST PROPERTY"> <b><i class="fas fa-retweet" style="color:teal"></i> </b></a>
                @endif -->
            </h6>
            <!-- @if($sellers->status=="free") -->
                    <!-- <div class="dropdown no-arrow"> -->
                        
                    <!-- </div> -->
            <!-- @endif -->
                
                <!-- @if($sellers->status=="intended" && $sellers->sellingStatus=="leased")
                    <div class="dropdown no-arrow">
                        <a href="{{url('/seller/'.$sellers['tid'].'/repost')}}" class="buttonImage view" data-toggle="tooltip" data-placement="left" title="REPOST PROPERTY"> <b><i class="fas fa-retweet fas-lg" style="color:teal"></i></b></a>
                </div>
                @endif -->
        </div>
        @if($sellers->sellingStatus!=null)
            @if($sellers->sellingType=="For Lease" || $sellers->sellingType=="For Rent")
            <img src="{{ asset('images/rent.png') }}" class="status">
            @else
            <img src="{{ asset('images/sold1.png') }}" class="status">
            @endif
        @endif
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
                <table  width="100%">
                    <tr>
                        @foreach($sellers->images as $image)
                            <td>
                                @if($image->filetype == "video") 
                                    <video src="{{ $image->fileExt }}" height="191px" controls> 
                                    </video>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                </table>
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
                                    @if($sellers->sellingType=="For Lease")
                                        @if($sellers->leaseDeposit != null)
                                        <td width="20%" class="f10">Advance Deposit</td>
                                        @endif
                                        <td class="f10">Contract Period</td>
                                    @endif
                                    @if($sellers->sellingType=="For Rent")
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
                                        @if($sellers->leaseDeposit != null)
                                        <td class="f10">{{$sellers->leaseDeposit}}</td>
                                        @endif
                                        <td class="f10">{{$sellers->contractPeriod}}</td>
                                    @endif
                                    @if($sellers->paymentType=="Installment")
                                        @if($sellers->interest!=null)
                                            <td class="f10">{{$sellers->interest}}%</td>
                                        @endif
                                        @if($sellers->installDownPayment!=null)
                                            <td class="f10">{{number_format($sellers->installDownPayment)}}</td>
                                        @endif
                                        <td class="f10">{{$sellers->installTimeToPay}}</td>
                                        <td class="f10">P{{number_format($sellers->installPayment,2)}}</td>
                                    @endif
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="{{url('/documents/'.$sellers['tid'].'/view')}}">VIEW ATTACHED DOCUMENT(S)</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <font color="red" size="2"><b>{{ __('Date Posted') }}</b></font> <font color="" size="2">{{date('F d, Y', strtotime($sellers->created_at))}}</font>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

@endforeach
</div>
<center>{{ $lease->links() }}</center>
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