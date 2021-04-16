@extends('header')
@section('styles')

@stop

@section('body')
<img  class="bg" src="{{ asset('images/admincover.jpg') }}" height="300" width="100%"> 
<!-- <img  class="profile" src="{{ asset('images/avatar3.png') }}" height="200" width="200">  -->
@if($profilepicture==null)
<img  class="profile" src="{{ asset('images/avatar3.jpg') }}" height="200" width="200"> 
@endif
@if($profilepicture!=null)
<img  class="profile" src="{{ $profilepicture->fileExt }}" height="200" width="200">  
@endif
<br/><br/>
<div class="userinfo">
    <font size="3"><b>{{$intender['name']}} {{$intender['lname']}}</b></font>
    <font size="1">Member since {{date('F d, Y', strtotime($intender['created_at']))}}</font>
    <div align="left">
        <b><i class="fa fa-bookmark"></i></b>
        {{ $intender['address'] }}<br>
        <b><i class="fa fa-envelope"></i> </b>
        {{$intender['email']}}<br>
        <b><i class="fa fa-phone"></i> </b>
        {{$intender['contact']}}<br>&nbsp;&nbsp;&nbsp;
        {{$intender['secondarycontact']}}
    </div>
</div>
<br/>
<a class="backbutton" href="{{ url()->previous() }}"><i class="fa fa-chevron-circle-left" style="font-size:48px; color:teal;"></i>back</a>
@stop

<style>
.profile {
  position: absolute;
  border-radius: 50%;
  border: 2px solid white; 
  bottom: 30%;
  left: 8%;
  z-index: 1;
  }
  .userinfo{
    position: relative;
    margin-left: 25%;
  }
</style>
