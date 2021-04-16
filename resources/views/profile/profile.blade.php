@extends('header')
@section('styles')
.center{
    text-align:center;
}
@stop

@section('body')
    <div class="update">
        @foreach($profile as $profiles)
            <a data-toggle="tooltip" data-placement="right" 
    title="UPDATE PROFILE" href="{{url('/changeProfile/'.$profiles['id'].'/edit')}}"><i class="fas fa-cog"  style="font-size:20px;color:white;"></i></a><br>       
        @endforeach
    </div>
    <img  class="bg" src="{{ asset('images/admincover.jpg') }}" height="300" width="100%"> 
    <!-- <img  class="profilepicture" src="{{ asset('images/avatar3.png') }}" height="200" width="200">  -->
    @if($picture==null)
    <img  class="profilepicture" src="{{ asset('images/avatar3.png') }}" height="270" width="220"> 
    @endif
    @if($picture!=null)
    <img class="profilepicture" src="{{ $picture->fileExt }}" height="270" width="220">  
    @endif
    <br>
    <div class="userinfo">
    <table width="100%">
        <tr>
            <td></td>
            <td>NAME:</td>
            <td>{{ Auth::user()->name }} {{ Auth::user()->lname }}</td>
        </tr>
        <tr>
            <td></td>
            <td>ADDRESS:</td>
            <td>{{ Auth::user()->address }}</td>
        </tr>
        <tr>
            <td></td>
            <td>EMAIL ADDRESS:</td>
            <td>{{ Auth::user()->email }}</td>
        </tr>
        <tr>
            <td></td>
            <td>CONTACT NO.:</td>
            <td>{{ Auth::user()->contact }}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>{{ Auth::user()->secondarycontact }}</td>
        </tr>
        <tr>
        <td colspan="3" class="center"><font size="1">Member since {{date('F d, Y', strtotime(Auth::user()->created_at))}}</font></td>
        </tr>
    </table>
    </div>
    <br/>
@stop
<style>
.profilepicture {
  position: absolute;
  /* border-radius: 50%; */
  border: 2px solid white; 
  bottom: 20%;
  left: 20%;
  z-index: 1;
  }
  .userinfo{
    position: relative;
    margin-top: 1%;
    margin-left: 27%;
  }
  .update{
      position: absolute !important;
      float:left !important;
      margin-left:79% !important;
      padding-top:1% !important;
      z-index:9;
  }
</style>
