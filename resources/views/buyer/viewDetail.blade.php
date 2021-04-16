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
<div class="col-xl-12 col-lg-3">
    <div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                {{$lotDetails->sellingType}}&emsp;{{$lotDetails->lotType}}<br/>
                P{{number_format($lotDetails->lotPrice,2)}} {{$lotDetails->paymentType}}<br/>
                Located at {{$lotDetails->lotAddress}}
            </h6>
            
        </div>
    <!-- Card Body -->
            <div class="card-body">
                @foreach($lotDetails->images as $image)
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
                <table>
                    <tr>
                        @foreach($lotDetails->images as $image)
                            <td>
                                @if($image->filetype == "video") 
                                    <video src="{{ $image->fileExt }}" height="195px" controls> 
                                    </video>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                </table>
                <br/>
                <table  width="100%">
                    <tr>
                    <td class="" width="30%">
                        <div class="seller">
                            <br/>
                            <center>@if($sellerpicture==null)
                                <img  class="seller_picture" width="200" height="280" src="{{ asset('images/avatar3.png') }}"> 
                            @endif
                            @if($sellerpicture!=null)
                                <img class="seller_picture" width="200" height="280" src="{{ $sellerpicture->fileExt }}">  
                            @endif</center>
                            <div class="seller_info center">
                                <font size="1">Member since {{date('F d, Y', strtotime($user->created_at))}}</font><br/>
                                <font color="black"><b>{{$user['name']}}</b></font>
                                <br/>
                                <font color="gray" size="2">SELLER</font>
                                <br>
                                <font color="gray" size="3">
                                    <b><i class="fa fa-phone"></i> </b>
                                    {{$user['contact']}}
                                    @if($user->secondarycontact!=null)
                                    <br>{{$user['secondarycontact']}}
                                    @endif
                                    <br>
                                    <b><i class="fa fa-envelope"></i> </b>
                                    {{$user['email']}}
                                    <br/><br/>
                                </font>
                            </div>
                        </div>
                    </td>
                    <td>
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
                                        <img src="{{ asset('images/detail1.png') }}">&emsp;{{$lotDetails->lotArea}} {{$lotDetails->unitOfMeasure}}
                                    </td>
                                    <td class="f10">
                                        <img src="{{ asset('images/detail2.png') }}">&emsp;{{str_replace(" ", ",",$lotDetails->rightOfWay)}}
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
                                            {{$lotDetails->lotDescription}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    @if($lotDetails->paymentType!="Cash")
                        <tr>
                            <td class="bold f12"><b>Additional Details</b></td>
                        </tr>
                        <!-- <tr><td>&nbsp;</td></tr> -->
                    @endif
                    <tr>
                        <td>
                            <table width="100%" style="border-left:2px solid gray;">
                                <tr>
                                    @if($lotDetails->sellingType=="For Lease")
                                        @if($lotDetails->leaseDeposit!=NULL)
                                            <td width="20%" class="f10">Advance Deposit</td>
                                        @endif
                                        <td class="f10">Contract Period</td>
                                    @endif
                                    @if($lotDetails->paymentType=="Installment")
                                        @if($lotDetails->interest!=null)
                                            <td class="f10">Interest</td>
                                        @endif
                                        @if($lotDetails->installDownPayment!=null)
                                        <td class="f10">Downpayment</td>
                                        @endif
                                        <td class="f10">Years/Months to pay remaining balance</td>
                                        <td class="f10">Payment</td>
                                    @endif
                                </tr>
                                <tr>
                                    @if($lotDetails->sellingType=="For Lease")
                                        @if($lotDetails->leaseDeposit!=NULL)
                                            <td class="f10">{{$lotDetails->leaseDeposit}}</td>
                                        @endif
                                        <td class="f10">{{$lotDetails->contractPeriod}}</td>
                                    @endif
                                    @if($lotDetails->sellingType=="For Rent")
                                        <td class="f10">{{$lotDetails->leaseDeposit}}</td>
                                    @endif
                                    @if($lotDetails->paymentType=="Installment")
                                        @if($lotDetails->interest!=null)
                                            <td class="f10">{{$lotDetails->interest}}%</td>
                                        @endif
                                        @if($lotDetails->installDownPayment!=null)
                                            <td class="f10">{{number_format($lotDetails->installDownPayment)}}</td>
                                        @endif
                                        <td class="f10">{{$lotDetails->installTimeToPay}}</td>
                                        <td class="f10">{{$lotDetails->installPaymentType}} (P{{number_format($lotDetails->installPayment,2)}} {{$lotDetails->installPaymentType}})</td>
                                    @endif
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <a href="{{url('/document/'.$lotDetails->tid.'/view')}}">VIEW ATTACHED DOCUMENT(S)</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <font color="red" size="1"><b>{{ __('Date Posted') }}</b></font> <font color="" size="1">{{date('F d, Y', strtotime($lotDetails->created_at))}}</font>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            @if($lotDetails->sellingType=="For Lease")
                                <a href="http://localhost:8000/newInquire/{{$lotDetails['tid']}}/intend" class="btn btn-info">Place Intent to Lease</a>
                            @elseif($lotDetails->sellingType=="For Rent")
                                <a href="http://localhost:8000/newInquire/{{$lotDetails['tid']}}/intend" class="btn btn-info">Place Intent to Rent</a>
                            @else
                                <a href="http://localhost:8000/newInquire/{{$lotDetails['tid']}}/intend" class="btn btn-info">Place Intent to Buy</a>
                            @endif
                            <!-- &emsp;&emsp;<a class="btn btn-secondary" href="{{ url()->previous() }}">BACK TO MAP</a> -->

                        </td>
                    </tr>
                    </table>
                    </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
   
</div>
    <a class="text" href="{{ url()->previous() }}" style="margin-left:50% !important" ><i class="fas fa-arrow-alt-circle-left fa-lg"></i></a>

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