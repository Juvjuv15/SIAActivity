@extends('header')
@section('styles')
.showallnotif{
    padding: 35px;
}

.line{
    height: 0px;
    border: none;
    border-top: 2px solid teal;
}

@endsection
@section('body')

<div class="showallnotif" width="100%">
<!-- <h3>Your Notifications</h3> -->
<!-- <hr class="line"> -->
    @foreach(Auth::user()->notifications as $notif)
        @if($notif->tid_fk == '0')
            <a class="dropdown-item" href="{{url('/properties')}}">
            <i class="fa fa-circle" style="font-size:5px"></i><font size="2">&emsp;{{$notif['data']}}</font>
            <br>
            &emsp;<small>{{date('F d, Y', strtotime($notif->created_at))}} </small>
            </a>
        @else
            <a class="dropdown-item" href="{{url('/view/'.$notif->tid_fk.'/notif')}}">
            <i class="fa fa-circle" style="font-size:5px"></i><font size="2">&emsp;{{$notif['data']}}</font>
            <br>
            &emsp;<small>{{date('F d, Y', strtotime($notif->created_at))}} </small>
            </a>
        @endif
    @endforeach
</div> 
@endsection