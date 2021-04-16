@extends('header')
@section('styles')
    .center{
        text-align:center;
    }
    .property-table{
        margin-top:10px;
    }
    .property-table table {
    border-collapse: collapse;
    border-radius: 1em;
    overflow: hidden;
    position:center;
    width:80%;
    }

    #property th, #property td {
    padding: 1em;
    border-bottom: 2px solid white; 
    }

    #property thead{
        background: #138496;
        color:white;
    }
    
   #property  tr:hover{
        background: none;
        opcity: 0.9;
    }
    #property tr:nth-child(even) {
        background-color: #b2faf0;
    }
    #property tbody{
    font-size: 10pt;
    }
@endsection

@section('body')
<center>
<div style="height: 500px; overflow: auto;" class="property-table">
    <table id="property">
        <thead class="theader">
            <tr>
                <th>
                    LOT NUMBER
                </th>
                <th class="center">
                    PROPERTY ADDRESS
                </th>
                <th class= "center">
                    POSTED STATUS
                </th>
                <th class= "center">
                    SELL/GRANT A LEASE
                </th>
            </tr>
        </thead>
        <tbody class="tbody" id="propertylist">
        @if($ownedLot)
            @foreach ($ownedLot as $value) 
                <tr>
                    <td>{{$value->lotNumber}}</td>
                    <td>{{$value->lotAddress}}</td>
                    @if($value->status=="null")
                        <td class="center">NO</td>
                        <td class="center"><a class="ownedProperties" href="{{url('/sell/'.$value->lotId.'/post')}}"><i class="fa fa-tags" style="color:teal"></i></a></td>
                    @else
                        <td class="center">YES</td>
                        <td class="center"></td>
                    @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="4" class="center">NO PROPERTIES CONFIRMED</td>
            </tr>
        @endif
    </table>
</div>
</center>
@endsection