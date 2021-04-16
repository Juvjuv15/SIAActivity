@extends('header')
@section('styles')
.bold{font-weight:bold !important;}
.lease,.sold{
    font-family: sans-serif;
    font-size: 10pt;
    font-weight: 20;
    text-align: center !important;
    color: white;
    width: 10%;
    box-sizing: border-box;
    border: 2px solid white;
    border-radius: 50px;
    background-color: #63c8c9;
    padding: 10px 25px 10px 25px;
    z-index:99;
    outline:none !important;
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
hr {
    display: block;
    height: 2px;
    width:65%;
    border: 0;
    border-top: 2px solid teal;
    margin: 1em 0;
    padding: 0; 
}

@stop
@section('body')
    <center>
        <div class="intender">
            <br/>
            @if($intended->sellingType=="For Lease")
                <!-- <h4><b>{{__('PERSONS WHO ARE INTERESTED TO RENT YOUR PROPERTY')}}</b></h4> -->
                <h6>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</h6>
                <p>(Select the person who will lease your property.)</p>
            @elseif($intended->sellingType=="For Rent")
            <!-- <h4><b>{{__('PERSONS WHO ARE INTERESTED TO RENT YOUR PROPERTY')}}</b></h4> -->
            <h6>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</h6>
            <p>(Select the person who will rent your property.)</p>
            @else
                <!-- <h4><b>{{__('PERSONS WHO ARE INTERESTED TO BUY YOUR PROPERTY')}}</b></h4> -->
                <h6>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</h6>
                <p>(Select the person who will buy your property.)</p>
            @endif
            
            <hr/>
            <div style="" class="table-intend">
                @foreach($listall as $name)
                <!-- <input type="text" name="buyerleaser" value="{{ $name['id'] }}" > -->

                <table width="40%">    
                    <tbody>
                        <tr>
                            <td rowspan="6" style="text-align:left !important">
                                @if($name->fileExt)
                                    <a class="btn btn-info" id="changeLink" username="{{ $name['name'] }}" address="{{ $name['address'] }}" link="{{url('/dashboard/'.$tid.'/'.$name['id'].'/soldleased')}}" data-toggle="modal" data-target="#confirmSellModal"><img class="pictureintender" src="{{ $name->fileExt }}" height=150" width="150"></a>
                                @else
                                    <a class="btn btn-info" id="changeLink" username="{{ $name['name'] }}" address="{{ $name['address'] }}" link="{{url('/dashboard/'.$tid.'/'.$name['id'].'/soldleased')}}" data-toggle="modal" data-target="#confirmSellModal"><img  class="pictureintender" src="{{ asset('images/avatar3.png') }}" height="150" width="150"> </>
                                @endif
                            </td>
                            <!-- <td>&emsp;</td> -->
                            <input type="hidden"  id="username">
                            <td style="text-align:left !important" width="55%"><b>{{ $name['name'] }}, {{ $name['address'] }}</b>
                                <br/>{{ $name['email'] }}<br/>
                                {{ $name['contact'] }}<br/>
                                @if($name->contact != null)
                                    {{ $name['secondarycontact'] }}
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
                <hr/>


                @endforeach
                <br/>

                
            </div>
        </div>
    </center>
                      <!-- ConfirmSell Modal-->
  <div class="modal fade" id="confirmSellModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            SYSTEM GENERATED
            @if($intended->sellingType=="For Lease")
                CONTRACT OF LEASE
            @else
                CONTRACT TO SELL
            @endif
            </h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">                
            <form autocomplete="off" action="" method="post" enctype="multipart/form-data" id="formconfirm"> 
                    @csrf
                        <p>@if($intended->sellingType=="For Sale")
                                Contract Price: <input id="contractprice" type="text" class="col-3" name="contractprice" value="{{$intended->lotPrice}}">
                                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                Location: {{$intended->lotAddress}}
                                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                Lot No.{{$intended->lotNumber}}<br/>
                                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                Area: {{$intended->lotArea}} {{$intended->unitOfMeasure}}
                                <br/>
                            @else
                                <!-- Contract Period: 
                                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                Location: {{$intended->lotAddress}}
                                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                <br/>
                                Start Date: {{$intended->lotAddress}}
                                End Date: {{$intended->lotNumber}}<br/>
                                <br/> -->

                            @endif
                        </p>

                        <p>This CONTRACT @if($intended->sellingType=="For Sale")TO SELL @else OF LEASE @endif, made and executed this
                        <input id="dateexecuted" type="text" class="col-3" name="dateexecuted" value="{{date('Y-m-d')}}"> by and between:
                        </p>
                        <p><input id="name" type="text" class="col-5" name="seller" value="{{$intended->lotOwner}}">, hereinafter referred to as the 
                        @if($intended->sellingType=="For Sale")
                            "SELLER/VENDOR".
                        @else
                            "LESSOR".
                        @endif
                        </p>

                                        <center><p>-AND-</p></center>

                        <p><input id="leaserbuyer" type="text" class="col-5" name="leaserbuyer" value=""> with residence and postal address at <br/><br/><input id="leaserbuyeraddress" type="text" class="col-5" name="leaserbuyeraddress" value="">, hereinafter referred to as the
                        @if($intended->sellingType=="For Sale")
                            "BUYER/VENDEE".
                            <br/><br/>
                            The agreed mode of payment is <input id="sellpaymenttype" type="text" class="col-3" name="sellpaymenttype" value="{{$intended->paymentType}}">.
                            @if($intended->paymentType=="Installment")
                            With <input id="downpayment" type="text" class="col-3" name="downpayment" value="{{$intended->installDownPayment}}"> as<br/><br/>downpayment. And an interest of (%)
                            <input id="interest" type="text" class="col-1" name="interest" value="{{$intended->interest}}"> shall be imposed for the remaining balance.
                            <br/><br/>
                            The remaining balance shall be payable for 
                            <input id="installtimetopay" type="text" class="col-3" name="installtimetopay" value="{{$intended->installTimeToPay}}"> with an amortization of <br/><br/>
                            <input id="installpayment" type="text" class="" name="installpayment" value="{{$intended->installPayment}}"> 
                            <input id="installpaymenttype" type="text" class="col-3" name="installpaymenttype" value="{{$intended->installPaymentType}}"> 
                            @endif
                            <br/><br/>
                            Date Sold:  <input id="datesold" type="text" class="col-3" name="datesold" value="" placeholder="(format)2019-02-26"> 
                        @else
                            "LESSEE".
                            <br/><br/>
                            This term of lease is for <input id="contractperiod" type="text" class="col-3" name="contractperiod" value="{{$intended->contractPeriod}}">. From <input id="startcontract" type="text" class="col-3" name="startcontract" placeholder="(format)2019-01-20"> to <br/><br/><input id="endcontract" type="text" class="col-3" name="endcontract" placeholder="(format)2019-05-20"> inclusive.
                            <br/><br/>
                            The LESSEE will pay  an amount of <input id="amortprice" type="text" class="col-3" name="amortprice" value="{{$intended->lotPrice}}">, payable <input id="leasepaymenttype" type="text" class="col-4" name="leasepaymenttype" value="{{$intended->paymentType}}">.
                                @if($intended->leaseDeposit!=null)
                                    With <input id="leasedeposit" type="text" class="col-3" name="leasedeposit" value="{{$intended->leaseDeposit}}"> advance deposit.
                                @endif
                        @endif
                        </p>
                    
            </div>
                <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">CANCEL</button>
                <button class="btn btn-success" type="submit" >CONFIRM</button>
                </div>
        </div>
      </form>
    </div>
  </div>
  @section('js')
  <script>
    $(document).ready(function(){
        var startcontract =  $('#startcontract').val();
        console.log(startcontract);
        $("a").click(function(){
            // e.preventDefault()
            var link =$(this).attr('link');
            var username =$(this).attr('username');
            var address =$(this).attr('address');
            console.log (link);
            console.log (username);
            $("#formconfirm").attr("action", link);
            $("#leaserbuyer").attr("value", username);
            $("#leaserbuyeraddress").attr("value", address);
        });
    });
  </script>
  @endsection

@stop




