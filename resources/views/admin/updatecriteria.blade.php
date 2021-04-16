@extends('layouts.layout')

@section('styles')
table {
  border-collapse: collapse;
  border-radius: 1em;
  overflow: hidden;
  position:center;
  width:100%;
}

th, td {
  padding: 1em;
  vertical-align:top;
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
    background-color: white !important;
}
tbody{
  font-size: 10pt;
}
@stop

@section('body')
<form autocomplete="off" action="{{url('/update/recommender')}}" method="post"> 
{{csrf_field()}}
<table>
    <tr>
        <td>
            <table>
                <thead>
                    <tr>
                        <td colspan="3">CRITERIA</td>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td><b>CRITERIA</b></td>
                    <td><b>CURRENT</b></td>
                    <td><b>SCORE(%)</b></td>
                </tr>
                @foreach ($criteria as $row) 
                    <tr>
                        <td>{{$row->cdesc}}</td>
                        <td>{{$row->cscore}}</td>
                        <td><input type="text" name="cscore[]" value="{{$row->cscore}}"></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </td>
        <td>
            <table>
                <thead>
                    <tr>
                        <td colspan="3">ESTABLISHMENT SCORE</td>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td><b>ESTABLISHMENT</b></td>
                    <td><b>CURRENT</b></td>
                    <td><b>SCORE</b></td>
                </tr>
                @foreach ($estabscore as $row) 
                    <tr>
                        <td>{{$row->estab}}</td>
                        <td>{{$row->escore}}</td>
                        <td><input type="text" name="escore[]" value="{{$row->escore}}"></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table>
                <thead>
                    <tr>
                        <td colspan="3">PRICE RANGE</td>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td><b>DESCRIPTION</b></td>
                    <td><b>CURRENT</b></td>
                    <td><b>RANGE</b></td>
                </tr>
                @foreach ($pricerange as $row) 
                    <tr>
                        <td>{{$row->rangedesc}}</td>
                        <td>{{$row->rangescore}}</td>
                        <td><input type="text" name="pricerangescore[]" value="{{$row->rangescore}}"></td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3">HIGH:Above fair range</td>
                </tr>
                </tbody>
            </table>
        </td>
        <td>
            <table>
                <thead>
                    <tr>
                        <td colspan="3">PRICE SCORE</td>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td><b>DESCRIPTION</b></td>
                    <td><b>CURRENT</b></td>
                    <td><b>SCORE(%)</b></td>
                </tr>
                @foreach ($pricescore as $row) 
                    <tr>
                        <td>{{$row->pdesc}}</td>
                        <td>{{$row->pscore}}</td>
                        <td><input type="text" name="pricescore[]" value="{{$row->pscore}}"></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </td>
    </tr>

    <tr>
        <td>
            <table>
                <thead>
                    <tr>
                        <td colspan="3">RADIUS RANGE</td>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td><b>DESCRIPTION</b></td>
                    <td><b>CURRENT</b></td>
                    <td><b>RANGE IN KM</b></td>
                </tr>
                @foreach ($radiuskm as $row) 
                    <tr>
                        <td>{{$row->radiusdesc}}</td>
                        <td>{{$row->radiuskm}}</td>
                        <td><input type="text" name="radiuskm[]" value="{{$row->radiuskm}}"></td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3">FAR:Above fair range</td>
                </tr>
                </tbody>
            </table>
        </td>
        <td>
            <table>
                <thead>
                    <tr>
                        <td colspan="3">RADIUS SCORE</td>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td><b>DESCRIPTION</b></td>
                    <td><b>CURRENT</b></td>
                    <td><b>SCORE(%)</b></td>
                </tr>
                @foreach ($radiusscore as $row) 
                    <tr>
                        <td>{{$row->rdesc}}</td>
                        <td>{{$row->rscore}}</td>
                        <td><input type="text" name="radiusscore[]" value="{{$row->rscore}}"></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </td>
    </tr>
</table>
<div class="text-center" style="margin:5px 15px 0px 15px;">
    <input type="submit" value="UPDATE" class="btn btn-info btn-block rounded-5 py-2">
</div>
</form>
@stop