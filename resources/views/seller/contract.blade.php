@extends('header')
@section('styles')
    .contract{
        width:80%;
        margin-left:10%;
    }
    .contract-info{
        background-color:#fff;
        box-shadow: inset 0px 0px 15px 15px teal;
        padding:20px;
    }
@stop
@section('body')
<br/>

<div class="contract">
    <div class="contract-info">
        
        <p>@if($contract->sellingType=="For Sale")
                Contract Price: {{$contract->contractprice}}
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;
                Location: {{$contract->lotAddress}}
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                Lot No.{{$contract->lotNumber}}<br/>
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                Area: {{$contract->lotArea}} {{$contract->unitOfMeasure}}
                <br/>
                <hr/>
                <br/>
            @endif
        </p>
        <center>
            <p>This CONTRACT @if($contract->sellingType=="For Sale")TO SELL @else OF LEASE @endif, made and executed this
            {{$contract->dateexecuted}} by and between:
            </p>
            <p>{{$contract->owner}}, hereinafter referred to as the 
            @if($contract->sellingType=="For Sale")
                "SELLER/VENDOR".
            @else
                "LESSOR".
            @endif
            </p>

                            <center><p>-AND-</p></center>

            <p>{{$contract->leaserbuyer}} with residence and postal address at {{$contract->address}}, hereinafter referred to as the
            @if($contract->sellingType=="For Sale")
                "BUYER/VENDEE".
                <br/><br/>
                The agreed mode of payment is {{$contract->paymenttype}}.
                @if($contract->paymenttype=="Installment")
                With {{$contract->downpayment}} as<br/><br/>downpayment. And an interest of (%)
                {{$contract->interest}} shall be imposed for the remaining balance.
                <br/><br/>
                The remaining balance shall be payable for {{$contract->installtimetopay}} with an amortization of {{$contract->installpayment}} {{$contract->installpaymenttype}}
                @endif
                <br/><br/>
                Date Sold: {{$contract->datesold}}
            @else
                "LESSEE".
                <br/><br/>
                This term of lease is for {{$contract->contractperiod}}. From {{$contract->startcontract}} to {{$contract->endcontract}} inclusive.
                <br/><br/>
                The LESSEE will pay  an amount of {{$contract->amortprice}}, payable {{$contract->paymenttype}}.
                    @if($contract->leasedeposit!=null)
                        With {{$contract->leasedeposit}} advance deposit.
                    @endif
            @endif
            </p>
            </center>
            <br/><br/>
            <p><font size='2'><center>
                    NOTE: This is a system generated contract modified by the  @if($contract->sellingType=="For Sale")
                        "SELLER/VENDOR".
                    @else
                        "LESSOR".
                    @endif
                </center></font>
            </p>
    </div>
    <br/>
    <center><a href="{{ url()->previous() }}" style="color:blue;">BACK</a></center>
</div>

<br/>		
@stop