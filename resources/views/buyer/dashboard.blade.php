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
    <!-- right:50px;-->
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

@if (session('poststatus'))
    <div align="center" class="alert alert-success" id="prompt">
        <h5>{{ session('poststatus') }}<i onclick="w3_close()" class="fa fa-times w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h5>
    </div>
@endif
@if (session('favoritestatus'))
        <div align="center" class="alert alert-success" id="prompt">
            <h6>{{ session('favoritestatus') }}<i onclick="w3_close()" class="fa fa-times w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h6>
        </div>
@endif
@if (session('intendedstatus'))
    <div align="center" class="alert alert-danger" id="prompt">
        <h5>{{ session('intendedstatus') }}<i onclick="w3_close()" class="fa fa-times w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h5>
    </div>
@endif
@foreach($dashboard as $sellers)
<div class="col-xl-12 col-lg-3">
    <div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                {{$sellers->sellingType}}&emsp;{{$sellers->lotType}}<br/>
                P{{number_format($sellers->lotPrice,2)}} {{$sellers->paymentType}}<br/>
                Located at {{$sellers->lotAddress}}
            </h6>
            <div class="dropdown no-arrow">
                <a link="{{url('/cancelInquire/'.$sellers->tid.'/cancel')}}" data-toggle="modal" data-target="#cancelModal"><b><i class="fas fa-times-circle fa-lg" style="color:teal"></i></b></a>
            </div>
        </div>
        @if($sellers->sellingStatus!=null)
            @if($sellers->sellingType=="For Lease")
            <img src="{{ asset('images/rent.png') }}" class="status">
            @else
            <img src="{{ asset('images/sold1.png') }}" class="status">
            @endif
        @endif
    <!-- Card Body -->
            <div class="card-body">
                @if($sellers->filetype == "image")  
                <center>  
                    <label class="col-md-11 col-form-label text-md-right">        
                        <div id="makeMeScrollable" class="scrollableArea">
                            <img class="image" src="{{ $sellers->fileExt }}"> 
                        </div>
                    </label>
                </center>   
                @endif
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
                                        @if($sellers->leaseDeposit!=NULL)
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
                                        @if($sellers->leaseDeposit!=NULL)
                                            <td class="f10">{{$sellers->leaseDeposit}}</td>
                                        @endif
                                        <td class="f10">{{$sellers->contractPeriod}}</td>
                                    @endif
                                    @if($sellers->sellingType=="For Rent")
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
                                        <td class="f10">P{{number_format($sellers->installPayment,2)}}</td>
                                    @endif
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <a href="{{url('/document/'.$sellers->tid.'/view')}}">VIEW ATTACHED DOCUMENT(S)</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <font size="2">Posted by {{$sellers->name}}</font>&emsp;&emsp;&emsp;&emsp;<font color="red" size="2"><b>{{ __('Date Posted') }}</b></font> <font color="" size="1">{{date('F d, Y', strtotime($sellers->created_at))}}</font>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
         <!-- Cancel Modal-->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Are you sure to cancel?</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-info" id="link" href="">Yes</a>
        </div>
      </div>
    </div>
  </div>
@endforeach
</div>
<center>{{ $dashboard->links() }}</center>
@section('js')
<script>
    $(document).ready(function(){
        $("a").click(function(){
            // e.preventDefault()
            var link =$(this).attr('link');
            // console.log (link);
            $("#link").attr("href", link);
        });
    });
</script>
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