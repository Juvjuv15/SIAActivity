@extends('header')
@section('styles')
.bold{font-weight:bold !important;}
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
.history-body td{
    vertical-align:top;
    padding:5px;
}
.thead-history th{
    padding:10px;
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
.center{
    text-align:center
}
table {
  border-collapse: collapse;
  border-radius: 1em;
  overflow: hidden;
  position:center;
  width:100%;
}

th, td {
  padding: 1em;
  border-bottom: 2px solid white; 
}

thead{
    background: #138496;
    color:white;
}

.title{
    font-size:36px;
    color:teal;
    margin-left:10px;
    font-weight:bold;
}

tr:hover{
    background: none;
    opacity: 0.9;
}
tr:nth-child(even) {
    background-color: #b2faf0;
}
tbody{
  font-size: 10pt;
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
<div class="col-xl-12 col-lg-3">
    <div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h4 class="m-0 font-weight-bold text-primary">
                PROPERTY HISTORY RECORDS
            </h4>
        </div>
    
    <!-- Card Body -->
            <div class="card-body" style="width:100%;">
                <table  width="100%" class="border">
                    <thead class="theader thead-history">
                        <tr>
                            <th class="bold center">LOT NUMBER</th>
                            <th class="bold center">LOT ADDRESS</th>
                            <th class="bold center">STATUS</th>
                            <th class="bold center">LEASER/BUYER</th>
                            <th class="bold center">PRICE</th>
                            <th class="bold center">PAYMENT MODE</th>
                            <th class="bold center">DATE SOLD</th>
                            <th class="bold center">CONTRACT PERIOD</th>
                            <th class="bold center">START OF CONTRACT</th>
                            <th class="bold center">END OF CONTRACT</th>
                        </tr>
                    </thead>
                    <tbody class="history-body">
                        @foreach($listall as $sellers)
                        <tr>
                            <td class="caps center">{{$sellers->lotNumber}}</td>
                            <td class="caps center">{{$sellers->lotAddress}}</td>
                            <td class="caps center">{{$sellers->sellingStatus}}</td>
                            <td class="caps center">{{$sellers->leaserbuyer}}</td>
                            @if($sellers->sellingType=="For Sale")
                                <td class="caps center">{{$sellers->contractprice}}</td>
                            @else
                                <td class="caps center">{{$sellers->amortprice}}</td>
                            @endif
                            <td class="caps center">{{$sellers->paymenttype}}</td>
                            <td class="caps center">{{$sellers->datesold}}</td>
                            <td class="caps center">{{$sellers->contractperiod}}</td>
                            <td class="caps center">{{$sellers->startcontract}}</td>
                            <td class="caps center">{{$sellers->endcontract}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<center>{{ $listall->links() }}</center>
@section('js')
@endsection
@stop