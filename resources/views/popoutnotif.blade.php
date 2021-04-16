@extends('header')
@section('styles')
.sell{
    font-family: arial,bold;
    font-size: 100px;
    font-weight: 700;
    color: white;
    width: 160px;
    box-sizing: border-box;
    border: 2px solid #63c8c9;
    border-radius: 10px;
    font-size: 16px;
    background-color: #63c8c9;
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 10px 10px 10px 10px;
    display: right;
    text-align: center;
    /* margin: 10px 0; */
}

.sell:hover {
    background: #9ecdd5;
    text-decoration: none; 
    color: gray;
    <!-- color: #f1f1f1; -->


}

.card-header{
    background: white;
}
@stop
@section('forloopnotify')
    @foreach($notifications as $notification)
    <li>{{$notification['lotid']}}</li>
    @endforeach
@stop

<script>
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function notifyfunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>