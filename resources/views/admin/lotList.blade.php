@extends('layouts.layout')
@section('styles')

.button{
    font-family: arial,bold;
    font-size: 100px;
    font-weight: 700;
    color: white;
    width: 200px;
    box-sizing: border-box;
    border: 2px solid #63c8c9;
    border-radius: 10px;
    font-size: 16px;
    background-color: #63c8c9;
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 10px 30px 10px 10px;
    display: right;
    text-align: center;
}
.button:hover{
    background: #9ecdd5;
}
.buttonImage{
    /* font-family: arial,bold;
    font-size: 100px;
    font-weight: 700; */
    color: white;
    width: 100px;
    box-sizing: border-box;
    border-radius: 2px;
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 16px 20px 18px 20px;
    display: right;
}
.buttonImage:hover {
    <!-- background: #d9d9d9; -->
    text-decoration: none; 
}
input[type=text] {
    width: 350px;
}

#lotnumber:focus {
   border-color: #4d90fe;
}
#location:focus {
    border-color: #4d90fe;
}

.select{
    width: 200px;
    box-sizing: border-box;
    border: 2px solid #63c8c9;
    border-radius: 0px !important;
    font-size: 16px;
    color:gray;
    background-color: white;
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    margin-right: -50px;
    padding: 12px 30px 12px 10px;
    outline:none;
}
.criteria{
  width: 870px !important;
  border:2px solid #63c8c9;
  border-radius:50px;
  background-color: #63c8c9;
  padding: 5px 5px 5px 5px;
}
.left{
  border-radius: 50px !important;
}
.search_icon{
    width: 50px;
    text-align:center;
    box-sizing: border-box;
    border: 2px solid white;
    border-radius:50px;
    font-size: 16px;
    /* background-color: #63c8c9; */
    background: linear-gradient(to right, #63c8c9, #32fa95);
    margin-left: 20px;
    /* background-position: 10px 10px; 
    background-repeat: no-repeat; */
    padding: 12px 45px 9px 10px;
    outline:none !important;
}
@stop
@section('body')

    @if (session('status'))
    <div align="center" class="alert alert-success" id="prompt">
        <h5>{{ session('status') }}<i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h5>
    </div>
    @endif
    @if (session('uploadstatus'))
    <div align="center" class="alert alert-success" id="prompt">
        <h5>{{ session('uploadstatus') }}<i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h5>
    </div>
    @endif

<center><div class="criteria" align="center">
  <input type="text" id="lotnumber" class="select left" onkeyup="lotnumFunction()" placeholder="Lot number.....">
  <input type="text" id="location" class="select" onkeyup="locationFunction()" placeholder="Lot address.....">
  <!-- <input type="text" id="lotnumber" placeholder="Search anything....."> -->
  <select id="lotType" class="select" onclick="lottypeFunction()">
  <option value="">Lot Type</option>
  <option value="Agricultural Lot">Agricultural Lot</option>
  <option value="Commercial Lot">Commercial Lot</option>
  <option value="Residential Lot">Residential Lot</option>
  </select>
  <button class="search_icon"><img  src="{{ asset('images/searchIcon.png') }}" height="25" width="20"></button>
</div></center>
<br/>
<div style="height: 500px; overflow: auto;" class="table-lot">
<table id="lotTable">
<thead class="theader">
  <tr>
    <th>
        Lot Number
    </th>
    <th>
        Lot Address
    </th>
    <th>
        Owner
    </th>
    <th>
        Type
    </th>
    <th>
        Area
    </th>
    <th>

    </th>
    <th>

    </th>
  </tr>
</thead>

<tbody class="tbody" id="lotlist">
@foreach ($lotList as $lots) 
<tr>
    <td bgcolor="">{{$lots['lotNumber']}}</td>
    <td>{{$lots['lotAddress']}}</td>
    <td>{{$lots['lotOwner']}}</td>
    <td>{{$lots['lotType']}}</td>
    <td>{{$lots['lotArea']}} {{$lots['unitOfMeasure']}}</td>
    <td><a href="http://localhost:8000/lots/{{$lots['lotId']}}/view" class="buttonImage view" data-toggle="tooltip" data-placement="left" title="View"> <b><i class="fa fa-external-link" style="color:teal"></i> </b></a></td>
    <td><a href="{{url('/updatelot/'.$lots['lotId'].'/edit')}}" class="buttonImage edit" data-toggle="tooltip" data-placement="left" title="Edit"> <b><i class="fa fa-edit" style="color:teal"></i> </b> </a></td>
    <!-- <img  src="{{ asset('images/edit.svg') }}" height="25" width="20">
    <img  src="{{ asset('images/eye.png') }}" height="25" width="20"> -->
</tr>
@endforeach
</tbody>
</table>
</div>
<!-- <div align="center">
<font color="gray">Back to <a href="#" style="color:gray">top</a></font>&nbsp;&nbsp;
</div> -->
<br>
 <script>
function lotnumFunction() {
  // Declare variables 
  var input, filter, table, tr, td,td1, i;
  input = document.getElementById("lotnumber");
  filter = input.value.toUpperCase();
  table = document.getElementById("lotTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];

    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}

function locationFunction() {
  // Declare variables 
  var input, filter, table, tr, td,td1, i;
  input = document.getElementById("location");
  filter = input.value.toUpperCase();
  table = document.getElementById("lotTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];

    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}

function lottypeFunction() {
  // Declare variables 
  var input, filter, table, tr, td,td1, i;
  input = document.getElementById("lotType");
  filter = input.value.toUpperCase();
  table = document.getElementById("lotTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[3];

    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- <script>
$(document).ready(function(){
  $("#lotnumber").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#lotTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script> -->
@endsection

