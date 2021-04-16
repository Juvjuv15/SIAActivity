@extends('header')
<style>
#makeScrollable
{
    width:100%;
    height: 100%;
    position: relative;
    margin:auto;
    padding:15px;
}
/* Replace the last selector for the type of element you have in
    your scroller. If you have div's use #makeMeScrollable div.scrollableArea div,
    if you have links use #makeMeScrollable div.scrollableArea a and so on. */
#makeScrollable div.scrollableArea img
{
    
    position: relative;
    width:auto;
    height:600px;
    margin: 0;
    /* If you don't want the images in the scroller to be selectable, try the following
        block of code. It's just a nice feature that prevent the images from
        accidentally becoming selected/inverted when the user interacts with the scroller. */
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -o-user-select: none;
    user-select: none;
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
    padding: 9px 30px 10px 9px;
} 
.criteria{
  width: 1150px;
  border:2px solid #63c8c9;
  border-radius:50px;
  background-color: #63c8c9;
  padding: 5px 5px 5px 5px;
}
.select{
    width: 200px;
    box-sizing: border-box;
    border: 2px solid #63c8c9;
    font-size: 16px;
    color:gray;
    background-color: white;
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    margin-right: -6px;
    padding: 12px 30px 12px 10px;
}
.find{
    width: 80px;
    text-align:center;
    box-sizing: border-box;
    border: 2px solid white;
    border-radius:50px;
    font-size: 16px;
    /* background-color: #63c8c9; */
    background: linear-gradient(to right, #63c8c9, #32fa95);
    margin-left: -20px;
    /* background-position: 10px 10px; 
    background-repeat: no-repeat; */
    padding: 9px 45px 9px 10px;
}
</style>
@section('styles')
<link rel="Stylesheet" type="text/css" href="{{asset('css/smoothDivScroll.css')}}">
.bold{font-weight:bold !important;}
.button{
    font-family: sans-serif;
    font-size: 10pt;
    font-weight: 20;
    text-align: left !important;
    color: white;
    width: 150%;
    box-sizing: border-box;
    border: 2px solid white;
    border-radius: 50px;
    background-color: #63c8c9;
    padding: 10px 25px 10px 25px;
    outline:none !important;
}
.caps{text-transform:uppercase;}
.center{text-align:center;}
.description{color:gray;}
.f10{font-size:10pt;}
.f17{font-size:17pt;}
.f25{font-size:30pt;}
.phead{padding: 20px 0px 0px 100px;}
.right{text-align:right;}
.seller{background-color:#f1f6f9;margin-left:50px;margin-right:50px;}
.seller_picture{height:311px;width:270px;}
.seller_info{font-family: sans-serif;background-color:#f1f6f9;margin-left:105px;margin-right:105px;margin-bottom:10px;}
.valign{vertical-align:top;}
@stop

@section('body')
    <table width="90%">
        <tr>
            <td class="bold caps f25 phead" width="40%">
                {{$lotDetails['slottype']}}
            </td>
            <td width="2%">
                <button class="button right">{{$lotDetails['sellingtype']}}<br/>
                P{{number_format($lotDetails['lotprice'],2)}} {{$lotDetails['paymenttype']}}</button>
            </td>
        </tr>
        <tr>
            <td class="bold" style="padding-left:100px; color:gray;">
                {{$lotDetails['slotaddress']}}
                @if($lotDetails->count!=null)
                    @if($lotDetails->sellingtype=="For Sale")
                        @if($lotDetails->user_fk == Auth::user()->id)
                            @if($lotDetails->sellingstatus==null)
                                (<font size="2">No. of Potential Buyers <a href="{{url('/viewuserwhointended/'.$lotDetails['tid'].'/list')}}"><b>{{$lotDetails['count']}}</b></a></font>)
                            @endif
                        @endif
                    @else
                        @if($lotDetails->user_fk == Auth::user()->id)
                            @if($lotDetails->sellingstatus==null)
                                (<font size="2">No. of Potential Leasers <a href="{{url('/viewuserwhointended/'.$lotDetails['tid'].'/list')}}"><b>{{$lotDetails['count']}}</a></b></font>)
                            @endif
                        @endif
                    @endif
                @endif
            </td>
        </tr>
    </table>
    @foreach($lotDetails->images as $image)
        @if($image->filetype == "image")  
            <div id="makeScrollable">
                <img class="image" src="{{ $image->fileExt }}"> 
            </div>
        @endif
    @endforeach
    <table>
        <tr>
            @foreach($lotDetails->images as $image)
                <td>
                    @if($image->filetype == "video") 
                        <video src="{{ $image->fileExt }}" height="205px" controls> 
                        </video>
                    @endif
                </td>
            @endforeach
        </tr>
    </table>
    <br/>
    <table width="100%">
        <td class="valign">
            <table width="100%>
                <tr>
                    <td class="bold f17"><b>Facilities</b></td>
                </tr>
                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td>
                        <table width="117%" style="background-color:#f1f6f9;">
                            <tr>
                                <td width="20%" class="f10">Area</td>
                                <td class="f10">Vehicle Access on Way</td>
                            </tr>
                            <tr>
                                <td class="f10">
                                    <img src="{{ asset('images/detail1.png') }}">&emsp;{{$lotDetails['slotarea']}}
                                </td>
                                <td class="f10">
                                    <img src="{{ asset('images/detail2.png') }}">&emsp;{{$lotDetails['rightofway']}}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td class="bold f17"><b>Description</b></td>
                </tr>
                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td class="description f10">
                        {{$lotDetails['lotdescription']}}
                    </td>
                </tr>
                <tr><td>&nbsp;</td></tr>
                @if($lotDetails->paymenttype!="Cash")
                    <tr>
                        <td class="bold f17"><b>Additional Details</b></td>
                    </tr>
                    <tr><td>&nbsp;</td></tr>
                @endif
                <tr>
                    <td>
                        <table width="117%" style="border-left:2px solid gray;">
                            <tr>
                                @if($lotDetails->sellingtype=="For Lease")
                                    <td width="20%" class="f10">Advance Deposit</td>
                                @endif
                                @if($lotDetails->paymenttype=="Installment")
                                    @if($lotDetails->interest!=null)
                                        <td class="f10">Interest</td>
                                    @endif
                                    @if($lotDetails->installmentdownpayment!=null)
                                    <td class="f10">Downpayment</td>
                                    @endif
                                    <td class="f10">Years/Months to pay remaining balance</td>
                                    <td class="f10">Payment</td>
                                @endif
                            </tr>
                            <tr>
                                @if($lotDetails->sellingtype=="For Lease")
                                    <td class="f10">{{$lotDetails['leasedeposit']}}</td>
                                @endif
                                @if($lotDetails->paymenttype=="Installment")
                                    @if($lotDetails->interest!=null)
                                        <td class="f10">{{$lotDetails['interest']}}%</td>
                                    @endif
                                    @if($lotDetails->installmentdownpayment!=null)
                                        <td class="f10">{{number_format($lotDetails['installmentdownpayment'])}}</td>
                                    @endif
                                    <td class="f10">{{$lotDetails['installmenttimetopay']}}</td>
                                    <td class="f10">{{$lotDetails['installmentPaymentType']}} (P{{number_format($lotDetails['installmentPayment'],2)}} {{$lotDetails['installmentPaymentType']}})</td>
                                @endif
                            </tr>
                        </table>
                    </td>
                </tr>
                <td>
                    <a href="{{url('/document/'.$lotDetails->tid.'/view')}}">view attached proofs</a>
                </td>
                <tr>
                    <td>
                        <font color="red" size="1"><b>{{ __('Date Posted') }}</b></font> <font color="" size="1">{{date('F d, Y', strtotime($lotDetails['created_at']))}}</font>
                    </td>
                </tr>
            </table>
        </td>
    </table>
    <!-- script for the panoramic viewing -->
    <script src="{{asset('js/jquery-ui-1.10.3.custom.min.js')}}" type="text/javascript"></script>  
    <script src="{{asset('js/jquery.mousewheel.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/jquery.kinetic.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/jquery.smoothdivscroll-1.3-min.js')}}" type="text/javascript"></script>  
    <script type="text/javascript">
        $(document).ready(function () {
            // None of the options are set
            $("div#makeScrollable").smoothDivScroll({
                manualContinuousScrolling: true,
                autoScrollingMode: "onStart",
                hotSpotScrolling: false,
                touchScrolling: true
            });
        });
    </script>
@endsection

