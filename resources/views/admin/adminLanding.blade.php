@extends('layouts.layout')
@section('styles')
  .upload_status{
    position:absolute;
    z-index:999;
  }
  #prompt{
    z-index:9999999999;
  }
@stop

@section('body')
  @if (session('updatestatus'))
    <div align="center" class="alert alert-success" id="prompt">
        <h6>{{ session('updatestatus') }}<i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h6>
    </div>
  @endif
  @if (session('csvstatus'))
    <div align="center" class="alert alert-danger" id="prompt">
        <h6>{{ session('csvstatus') }}<i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h6>
    </div>
  @endif
  @if (session('adminstatus'))
    <div align="center" class="alert alert-success" id="prompt">
        <h6>{{ session('adminstatus') }}<i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></h6>
    </div>
  @endif
  @foreach($profile as $profiles)
  <a class="settings" href="{{url('/changeProfile/'.$profiles['id'].'/edit')}}"><i class="fa fa-gear"  style="font-size:20px;color:white;"></i></a>
  @endforeach
  <img  class="bg" src="{{ asset('images/admincover.jpg') }}" height="300" width="100%"> 
  @if($picture==null)
  <img  class="profile" src="{{ asset('images/avatar3.png') }}" height="250" width="250"> 
  @endif
  @if($picture!=null)
  <img class="profile" src="{{ $picture->fileExt }}" height="250" width="250">  
  @endif
  <br>
  <div class="userinfo">
  <br/>
  <div style="text-transform:uppercase; font-size:40pt;"><b>WELCOME {{ Auth::user()->name }}!</b></div>
  <!-- <font size="1">Member since {{date('F d, Y', strtotime(Auth::user()->created_at))}}</font> -->

  <!-- <div align="left"> -->
  <!-- <b><i class="fa fa-bookmark"></i></b>
  {{ Auth::user()->address }}<br> -->
  <!-- <b><i class="fa fa-envelope"></i> </b>
  {{ Auth::user()->email }}<br> -->
  <!-- <b><i class="fa fa-phone"></i> </b>
  {{ Auth::user()->contact }}<br>&nbsp;&nbsp;&nbsp;
  {{ Auth::user()->secondarycontact }} -->
  <!-- </div> -->
  </div>

@stop

<style>
.profile {
  position: absolute;
  border-radius: 50%;
  border: 2px solid white; 
  bottom: 5%;
  left: 8%;
  z-index: 1;
  }
  .userinfo{
    position: relative;
    left: 30%;
  }
  .settings{
    position:absolute;
    top: 20px;
    right: 25px;
    z-index: 2;
  }
</style>