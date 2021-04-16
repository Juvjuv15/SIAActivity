@extends('layouts.header')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
   <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
   <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script> 
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

   
@section('styles')
.textBox{
    width: 200px;
    box-sizing: border-box;
    border: 2px solid #63c8c9;
    border-radius: 4px;
    font-size: 12px;
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 8px 2px 5px 15px;
}
.textArea{
    width: 870px;
    box-sizing: border-box;
    border: 2px solid #63c8c9;
    border-radius: 4px;
    font-size: 12px;
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 8px 2px 5px 15px;
}

.button{
    font-family: arial,bold;
    font-size: 100px;
    font-weight: 700;
    color: white;
    width: 120px;
    box-sizing: border-box;
    border: 2px solid #72cdd8;
    border-radius: 50px;
    font-size: 16px;
    background-color: #72cdd8;
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 10px 10px 10px 10px;
    display: right;
    text-align: center;
    /* margin: 10px 0; */
}

.button:hover {
    background: blue green;
    text-decoration: none; 
    color: gray;
    <!-- color: #f8dea5; -->
}

@stop

@section('body')

@if($mode=='add')
<form action="{{url('seller/addlot')}}" method="post" enctype="multipart/form-data">
{{ csrf_field() }}
{!!
$tid='';
$slotnumber='';
$sellingtype='';
$lottype='';
$lotarea='';
$lotprice='';
$contactnumber='';
$name='';
$lotdescription='';
!!}  
@elseif($mode=='edit')
<form  action="{{url('seller/update')}}" method="post" enctype="multipart/form-data">
{{csrf_field()}}
{!!
$tid=$sellerRecord['tid'];
$slotnumber=$sellerRecord['slotnumber'];
$sellingtype=$sellerRecord['sellingtype'];
$lottype=$sellerRecord['lottype'];
$lotarea=$sellerRecord['lotarea'];
$lotprice=$sellerRecord['lotprice'];
$contactnumber=$sellerRecord['contactnumber'];
$name=$sellerRecord['name'];
$lotdescription=$sellerRecord['lotdescription'];

!!}
<input type="hidden" name="tid">
@endif

<form action="{{url('seller/addlot')}}" method="post" enctype="multipart/form-data">

<br>
<br>
<table align="center">
<tr>
<td><h6>Lot Number</h6></td>
<input id="searchString" type="text" name="search_string" placeholder="Enter Search String" class="form-control" />

<td><input type="text" name="slotNumber" class="textBox"  value="{{$slotnumber}}" required></td>
<td><h6>Selling Type</h6></td>
<td>
<select name="sellingtype" required value="{{$sellingtype}}" class="textBox">
    <option value="For Lease">For Lease</option>
    <option value="For Sale">For Sale</option>
</select>
</td>
<td><h6>Land type</h6></td>
<td>

<select name="lottype" class="textBox" value="{{$lottype}}">
@foreach($lotType as $types)
<option value="{{$types['lotType']}}">{{$types['lotType']}}</option>
@endforeach
</select>
</td>
<tr>
<td><h6>Price</h6></td>
<td><input type="text" name="lotprice" class="textBox" value="{{$lotprice}}" required></td>
<td><h6>Area</h6></td>
<td><input type="text" name="lotarea" class="textBox" value="{{$lotarea}}" placeholder="specify sqm/hectares" required></td>
</tr>
<tr>
<td><h6>Contact Number</h6></td>
<td>
<input type="text" name="contactnumber" class="textBox" value="{{$contactnumber}}" required>
</td>
</tr>

</table>
<div align="center">
<tr>
<td><h6>Add description</h6></td>
<td><textarea rows="10" cols="1000" name="lotdescription" class="textArea" value="{{$lotdescription}}">
{{$lotdescription}}
</textarea></td>
</tr>
<tr>
<td><input type="file" class="form-control-file col-sm-2" name="file[]" multiple></td>
<!-- <td><h6>Add picture</h6></td> -->
<td>(Panoramic pictures are the recommended type)</td>
</tr>
</div>
<center>
<br>
<tr>
<td><button type="submit" class="button">SUBMIT</button></td>
<td><input type="button" onclick="location.href='{{url('/home')}}'" class="button" value="CANCEL"></td>
</tr>
</center>
<br>

@endsection

<script>

$( function() {
          $( "#searchString" ).autocomplete({
            //html : html,
            source: "display-search-queries",
            minLength: 1,
            select:function(e,ui) { 
                location.href = ui.item.link;
            }
        } );
      } );
</script>

