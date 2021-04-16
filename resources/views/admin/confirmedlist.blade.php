@extends('layouts.layout')

@section('styles')
@stop

@section('body')
@if (session('status'))
    <div align="center" class="alert alert-danger" id="prompt">
        <h5>{{ session('status') }}<i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h5>
    </div>
@endif
@if (session('confirmedstatus'))
    <div align="center" class="alert alert-success" id="prompt">
        <h5>{{ session('confirmedstatus') }}<i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h5>
    </div>
@endif
<br>
<div style="height: 500px; overflow: auto;" class="table-lot">
<table align="center" id="lotTable">
<thead class="theader">
<tr>
<th>
    LOT NUMBER
</th>
<th>
    EMAIL ADDRESS
</th>
</tr>
</thead>
<tbody class="tbody">
@foreach ($confirmedList as $confirmed) 
<tr>
<td>{{$confirmed->lotNumber}}</td> 
<td>{{$confirmed->email}}</td>
</tr>
@endforeach


</tbody>
</table>
</div>


@stop