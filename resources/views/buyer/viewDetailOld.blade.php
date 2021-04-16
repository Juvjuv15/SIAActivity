@extends('header')
<style>
#map {
        height: 100%;
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
/* #makeScrollable
{
    width:100%;
    height: 100%;
    position: relative;
    margin:auto;
    padding:15px;
} */
/* Replace the last selector for the type of element you have in
    your scroller. If you have div's use #makeMeScrollable div.scrollableArea div,
    if you have links use #makeMeScrollable div.scrollableArea a and so on. */
/* #makeScrollable div.scrollableArea img
{
    
    position: relative;
    width:auto;
    height:600px;
    margin: 0; */
    /* If you don't want the images in the scroller to be selectable, try the following
        block of code. It's just a nice feature that prevent the images from
        accidentally becoming selected/inverted when the user interacts with the scroller. */
    /* -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -o-user-select: none;
    user-select: none;
} */
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
    padding: 12px 30px 12px 11px;
    outline:none !important;
} 
.criteria{
  width: 1100px;
  border:2px solid #63c8c9;
  border-radius:50px;
  background-color: #63c8c9;
  padding: 5px 5px 5px 5px;
}
.select{
    width: 188px;
    box-sizing: border-box;
    border: 2px solid #63c8c9;
    font-size: 16px;
    color:gray;
    background-color: white;
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    margin-right: -6px;
    padding: 12px 30px 12px 10px;
    outline:none !important;
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
    padding: 10px 45px 10px 10px;
    outline:none !important;
}
.find:hover{
  background: linear-gradient(to right, #32fa95, #63c8c9);
}
</style>
@section('styles')
<link rel="Stylesheet" type="text/css" href="{{asset('css/smoothDivScroll.css')}}">
.bold{font-weight:bold !important;}
.button{
    <!-- font-family: sans-serif; -->
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
.seller_info{font-family: sans-serif;background-color:#f1f6f9;margin-left:10px;margin-right:10px;margin-bottom:10px;}
.valign{vertical-align:top;}
@stop

@section('body')
{!! Form::open(['url'=>'/filter','id'=>'filter']) !!}
    {{csrf_field()}}
    <center>
        <div class="criteria" align="center">
            <input type="text" id="searchaddress" name="searchaddress" class="address"  placeholder="Location .....">
            <select name="selltype" id="selltype" class="select">
            <option value="">Selling Type</option>
            <option value="For Sale">For Sale</option>
            <option value="For Lease">For Lease</option>
            </select>
            <select name="lottype" id="lottype" class="select">
            <option value="">Lot Type</option>
            @foreach($lottype as $types)
            <option value="{{$types['lotType']}}">{{$types['lotType']}}</option>
            @endforeach
            </select>

            <select name="minPrice" id="minPrice" class="select">
            <option value="">min price</option>
            @foreach($price as $prices)
            <option value="{{$prices['price']}}">{{number_format($prices['price'])}}</option>
            @endforeach
            </select>

            <select name="maxPrice" id="maxPrice"  class="select">
            <option value="">max price</option>
            @foreach($price as $prices)
            <option value="{{$prices['price']}}">{{number_format($prices['price'])}}</option>
            @endforeach
            </select>
            {!! Form::submit('&nbsp;&nbsp;FIND',['class'=>'find','id'=>'find'])!!}
        </div>
    </center>
{!! Form::close() !!}
<div class="map_detail" id="map_detail">
    <div id="map"></div>
    <label id="legend"><h3>MAP Legend</h3></label>
</div>
<div class="lot_detail" id="lot_detail">
    <table width="50%">
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
                <!-- @if($lotDetails->count!=null)
                    @if($lotDetails->sellingtype=="For Sale")
                        (<font size="2">No. of Potential Buyers <b> {{$lotDetails['count']}}</b></font>)
                    @else
                        (<font size="2">No. of Potential Leasers <b> {{$lotDetails['count']}}</b></font>)
                    @endif
                @endif -->
            </td>
        </tr>
    </table>
    @foreach($lotDetails->images as $image)
    @if($image->filetype == "image")  
        <label class="col-md-11 col-form-label">        
            <div id="makeMeScrollable" class="scrollableArea">
                <img class="image" src="{{ $image->fileExt }}"> 
            </div>
        </label>
    @endif
    @endforeach
    <table>
        <tr>
            @foreach($lotDetails->images as $image)
                <td>
                    @if($image->filetype == "video") 
                        <video src="{{ $image->fileExt }}" height="249px" controls> 
                        </video>
                    @endif
                </td>
            @endforeach
        </tr>
    </table>
    <br/>
    <table width="90%">
        <td class="" width="30%">
            <div class="seller">
                <br/>
                <center>@if($sellerpicture==null)
                    <img  class="seller_picture" src="{{ asset('images/avatar3.png') }}"> 
                @endif
                @if($sellerpicture!=null)
                    <img class="seller_picture" src="{{ $sellerpicture->fileExt }}">  
                @endif</center>
                <div class="seller_info center">
                    <font size="1">Member since {{date('F d, Y', strtotime($user->created_at))}}</font><br/>
                    <font color="black"><b>{{$user['name']}} {{$user['lname']}}</b></font>
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
        <td class="valign">
            <table width="100%">
                <tr>
                    <td class="bold f17"><b>General Information</b></td>
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
                <tr>
                    <td>
                        <a href="{{url('/document/'.$lotDetails['tid'].'/view')}}">view attached proofs</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <font color="red" size="1"><b>{{ __('Date Posted') }}</b></font> <font color="" size="1">{{date('F d, Y', strtotime($lotDetails['created_at']))}}</font>
                    </td>
                </tr>
                <tr>
                    <td>
                        @if($lotDetails->sellingtype=="For Lease")
                            <a href="http://localhost:8000/newInquire/{{$lotDetails['tid']}}/intend" class="btn btn-info">Place Intent to Lease</a>
                        @else
                            <a href="http://localhost:8000/newInquire/{{$lotDetails['tid']}}/intend" class="btn btn-info">Place Intent to Buy</a>
                        @endif
                        <!-- &emsp;&emsp;<a class="btn btn-secondary" href="{{ url()->previous() }}">BACK TO MAP</a> -->

                    </td>
                </tr>
            </table>
        </td>
    </table>
</div>
@section('js')
    <!-- script for the panoramic viewing -->
    <!-- <script src="{{asset('js/jquery-ui-1.10.3.custom.min.js')}}" type="text/javascript"></script>  
    <script src="{{asset('js/jquery.mousewheel.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/jquery.kinetic.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/jquery.smoothdivscroll-1.3-min.js')}}" type="text/javascript"></script>   -->
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
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxdYAzq688HGpFDMmvo3q9mSM2LfVIgjE&libraries=places&callback">  
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js">
    </script>
    <!-- script for the map -->
    <script src="{{asset('js/script.js')}}"></script>
    <script>
        $(document).ready(function(){
            $("#map_detail").hide();
            $("#find").click(function(){
                $("#map_detail").show();
                $("#lot_detail").hide();
            });
        });
    </script>
@endsection
@endsection


