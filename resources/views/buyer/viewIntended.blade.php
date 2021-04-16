@extends('header')
@section('styles')
<!-- * {
    box-sizing: border-box;
} -->

<!-- /* Add a gray background color with some padding */ -->
<!-- body {
    font-family: Arial;
    /* padding: 20px; */
    background: #f1f1f1;
} -->

<!-- /* Create two unequal columns that floats next to each other */
/* Left column */ -->
.leftcolumn {   
    float: left;
    width: 75%;
    padding-left: 10px;
    padding-top: 10px;

}

<!-- /* Right column */ -->
.rightcolumn {
    float: left;
    width: 25%;
    padding-left: 10px;

}

<!-- /* Fake image */ -->
.information {
    background-color: #aaa;
    width: 100%;
    padding: 20px;
}

<!-- /* Add a card effect for articles */ -->
<!-- .begin {
     background-color: white;
     padding: 20px;
     width: 100%;
     margin-top: 20px;
} -->
.begin {
     background-color: white;
     padding: 20px;
     width: 100%;
     border:1px;
     border-radius: 5px;
     margin-top: 10px;
     <!-- background-color:#cdf2f2; -->

}

.beginleft {
     background-color: white;
     padding: 20px;
     width: 100%;
     border:1px;
     border-radius: 5px;
     <!-- background-color:#fcd12a; -->
     <!-- margin-top: 20px; -->
     margin-top: 10px;
     margin-bottom: 10px;



}
<!-- /* Clear floats after the columns */ -->
.start:after {
    content: "";
    display: table;
    clear: both;
}

<!-- /* Footer */
.footer {
    padding: 20px;
    text-align: center;
    background: #ddd;
    margin-top: 20px;
} -->

<!-- /* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other */ -->
@media screen and (max-width: 800px) {
    .leftcolumn, .rightcolumn {   
        width: 100%;
        padding: 0;
    }
    
}

@stop
@section('body')
<div class="dashboard">

<!-- <div class="header">
  <h2>Blog Name</h2>
</div> -->

<div class="start">

  <div class="leftcolumn">

  @foreach($listallintendedlots as $sellers)
<div class="beginleft">
<div class="form-group row">
<label class="col-md-6 col-form-label text-md-right">
@foreach($sellers->images as $image)
  @if($image->filetype == "image")
  
  <div id="makeMeScrollable">
    <img class="image" src="{{ $image->fileExt }}"> 
 </div>
  @else
    <video src="{{ $image->fileExt }}" height="300px" width:"100%" controls> 
    </video>
  @endif
  <!-- </td>    -->
  @endforeach@extends('header')
@section('styles')
<link rel="Stylesheet" type="text/css" href="{{asset('css/smoothDivScroll.css')}}">  

<!-- * {
    box-sizing: border-box;
} -->

<!-- /* Add a gray background color with some padding */ -->
<!-- body {
    font-family: Arial;
    /* padding: 20px; */
    background: #f1f1f1;
} -->

<!-- /* Create two unequal columns that floats next to each other */
/* Left column */ -->
.leftcolumn {   
    float: left;
    width: 75%;
    padding-left: 10px;
    padding-top: 10px;

}

<!-- /* Right column */ -->
.rightcolumn {
    float: left;
    width: 25%;
    padding-left: 10px;

}

<!-- /* Fake image */ -->
.information {
    background-color: #aaa;
    width: 100%;
    padding: 20px;
}

<!-- /* Add a card effect for articles */ -->
<!-- .begin {
     background-color: white;
     padding: 20px;
     width: 100%;
     margin-top: 20px;
} -->
.begin {
     background-color: white;
     padding: 20px;
     width: 100%;
     border:1px;
     border-radius: 5px;
     margin-top: 10px;
     <!-- background-color:#cdf2f2; -->

}

.beginleft {
     background-color: white;
     padding: 20px;
     width: 100%;
     border:1px;
     border-radius: 5px;
     <!-- background-color:#fcd12a; -->
     <!-- margin-top: 20px; -->
     margin-top: 10px;
     margin-bottom: 10px;



}
<!-- /* Clear floats after the columns */ -->
.start:after {
    content: "";
    display: table;
    clear: both;
}

<!-- /* Footer */
.footer {
    padding: 20px;
    text-align: center;
    background: #ddd;
    margin-top: 20px;
} -->

<!-- /* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other */ -->
@media screen and (max-width: 800px) {
    .leftcolumn, .rightcolumn {   
        width: 100%;
        padding: 0;
    }
    
}

@stop
@section('body')
<div class="dashboard">

<!-- <div class="header">
  <h2>Blog Name</h2>
</div> -->

<div class="start">

  <div class="leftcolumn">
  @if (session('lotstatus'))
  <div class="beginleft" align="center">
    <div align="center" class="alert alert-danger">
        <h5>{{ session('lotstatus') }}</h5>
    </div>
</div>
@endif

@if (session('poststatus'))
<div class="beginleft" align="center">
    <div align="center" class="alert alert-success">
        <h5>{{ session('poststatus') }}</h5>
    </div>
</div>
@endif


<div class="beginleft">
<div class="form-group row">
<label class="col-md-6 col-form-label text-md-right">
@foreach($lotDetails->images as $image)
  @if($image->filetype == "image")
  <div id="makeMeScrollable">
  <img src="{{ $image->fileExt }}" height="100%" width:"100%"> 
  </div>
  @else
  <video src="{{ $image->fileExt }}" height="300px" width:"100%" controls> 
  </video>
  @endif
  @endforeach 
</label>
<div class="col-md-6">
  <b>
  {{$lotDetails['sellingtype']}} 
  {{$lotDetails['lottype']}}
  </b>
  <br>
  <img src="{{ asset('images/location.png') }}" height="13" width="13"> {{$lotDetails['lotaddress']}}
  <br>
  <b>Area: </b>{{$lotDetails['lotarea']}}
  <br>
  <b>Price: </b>{{$lotDetails['lotprice']}}
<br>
<b>Mode of Payment: </b> {{$lotDetails['sellpayment']}}{{$lotDetails['leasepayment']}}
<br>
<b>Property Description:</b>
<br>
@if($lotDetails->lotdescription!=null)
{{$lotDetails['lotdescription']}}
<br>
@endif
<a href="{{url('/document/'.$lotDetails['tid'].'/view')}}">view attached proofs</a>
<br>
<font color="red"><b>{{ __('Date Posted') }}</b></font> {{$lotDetails['created_at']}}  
<br>
<a href="http://localhost:8000/newInquire/{{$lotDetails['tid']}}/intend" class="btn btn-success">Place an Intent</a>
</div>
</div>
<center>
@if($lotDetails->count!=null)
@if($lotDetails->sellingtype=="For Sale")
No. of Potential Buyers<font color="red"><b> {{$lotDetails['count']}}</b></font>
@else
No. of Potential Leasers<font color="red"><b> {{$lotDetails['count']}}</b></font>
@endif
@endif
</center> 
    </div>
  </div>

  <div class="rightcolumn">
    <div class="begin" align="center">
                <div class="">
                <h6>Listing Provided by:</h6>
                @if($sellerpicture==null)
                <img  class="profile" src="{{ asset('images/avatar3.jpg') }}" height="150" width="150"> 
                @endif
                @if($sellerpicture!=null)
                <img  src="{{ $sellerpicture->fileExt }}" height="150" width="150">  
                @endif
                <br>
                <font size="1">Member since {{$user['created_at']}}</font>
                <br>
                <div align="left">
                <b><i class="fa fa-user"></i></b> {{$user['name']}} {{$user['lname']}}
                <br>
                <b><i class="fa fa-phone"></i> </b> {{$user['contact']}}<br>&nbsp;&nbsp;&nbsp;
                 {{$user['secondarycontact']}}
                <br>
                <b><i class="fa fa-envelope"></i> </b><a href="#"> {{$user['email']}}</a>
                </div>


            </div>
    </div>
    
  </div>
  
</div>
</div>

<script src="{{asset('js/jquery-ui-1.10.3.custom.min.js')}}" type="text/javascript"></script>  
<script src="{{asset('js/jquery.mousewheel.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/jquery.kinetic.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/jquery.smoothdivscroll-1.3-min.js')}}" type="text/javascript"></script>  

<script type="text/javascript">
	$(document).ready(function () {
			// None of the options are set
			$("div#makeMeScrollable").smoothDivScroll({
				manualContinuousScrolling: true,
				autoScrollingMode: "onStart",
				hotSpotScrolling: false,
				touchScrolling: true
			});
		});

  </script>

<style>
  .profile {
    border-radius: 50%;
    /* border: 1px solid gray; */

    }

</style>
@stop
</label>
<div class="col-md-6">
  <b>
  {{$sellers['sellingtype']}} 
  {{$sellers['lottype']}}
  </b>
  <br>
  <img src="{{ asset('images/location.png') }}" height="13" width="13"> {{$sellers['lotaddress']}}
  <br>
  <b>Lot number: </b>{{$sellers['lotnumber']}}
  <br>
  <b>Area: </b>{{$sellers['lotarea']}}
  <br>
  <b>Price: </b>{{$sellers['lotprice']}}
<br>
<b>Mode of Payment: </b> {{$sellers['sellpayment']}}{{$sellers['leasepayment']}}
<br>
@if($sellers->lotdescription!=null)
<b>Property Description:</b>
<br>
{{$sellers['lotdescription']}}
<br>
@endif

@foreach($owner as $owned)
<b>Contact Information: </b> {{$owned['contact']}} {{$owned['secondarycontact']}}
<br>
<b>Email: </b><a href="#">{{$owned['email']}}</a>
@endforeach
<br>
<a href="{{url('/documents/'.$sellers['tid'].'/view')}}">view attached proofs</a>
<br>
<font color="red"><b>{{ __('Date Posted') }}</b></font> {{$sellers['created_at']}}  
</div>
</div>
<center>
@if($sellers->count!=null)
@if($sellers->sellingtype=="For Sale")
No. of Potential Buyers<font color="red"><a href="{{url('/viewuserwhointended/'.$sellers['tid'].'/list')}}"><b> {{$sellers['count']}}</b></a></font>
@else
No. of Potential Leasers<font color="red"><a href="{{url('/viewuserwhointended/'.$sellers['tid'].'/list')}}"><b> {{$sellers['count']}}</b></a></font>
@endif
@endif
</center> 
      <!-- <h2>TITLE HEADING</h2>
      <h5>Title description, Dec 7, 2017</h5>
      <div class="information" style="height:200px;">Image</div>
      <p>Some text..</p>
      <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p> -->
    </div>

    @endforeach
  </div>
  <div class="rightcolumn">
    <div class="begin" align="center">
                <div class="">
                <h2>About Me</h2>
                @if($picture==null)
                <img  class="profile" src="{{ asset('images/avatar3.jpg') }}" height="150" width="150"> 
                @endif
                @if($picture!=null)
                <img class="profile" src="{{ $picture->fileExt }}" height="150" width="150">  
                @endif
                <br>

                @foreach($profile as $profiles)
                
                <font size="3"><b>{{ Auth::user()->name }} {{ Auth::user()->lname }}</b></font>
                <a href="{{url('/changeProfile/'.$profiles['id'].'/edit')}}"><i class="fa fa-gear"  style="font-size:20px;color:black;"></i></a><br>
                <div align="left">
                <b><i class="fa fa-bookmark"></i></b>
                 {{ Auth::user()->address }}<br>
                <b><i class="fa fa-envelope"></i> </b>
                 {{ Auth::user()->email }}<br>
                <b><i class="fa fa-phone"></i> </b>
                {{ Auth::user()->contact }}<br>&nbsp;&nbsp;&nbsp;
                 {{ Auth::user()->secondarycontact }}
                </div>
                @endforeach
                

             @if (session('status'))
            <div align="center">
            <div class="col-md-12">

                <div align="center" class="alert alert-success">
                    <h6>{{ session('status') }}</h6>

                </div>
            </div>
            </div>
            @endif
            </div>
    </div>
    <div class="begin">
    <center>
    <h3>Registered Properties</h3>
    </center>
    @foreach($ownedLot as $value)
    <a href="{{url('/sell/'.$value->lotId.'/post')}}">{{$value->lotNumber}}</a>&nbsp;&nbsp;&nbsp;&nbsp;

    @endforeach

    </div>
    <div class="begin">
    <a href="{{url('/sellerpotentialdashboard')}}">LOT WITH POTENTIAL BUYERS/LEASERS</a>

    </div>
  </div>
  
</div>
</div>

<script src="{{asset('js/jquery-ui-1.10.3.custom.min.js')}}" type="text/javascript"></script>  
<script src="{{asset('js/jquery.mousewheel.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/jquery.kinetic.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/jquery.smoothdivscroll-1.3-min.js')}}" type="text/javascript"></script>  

<script type="text/javascript">
	$(document).ready(function () {
			// None of the options are set
			$("div#makeMeScrollable").smoothDivScroll({
				manualContinuousScrolling: true,
				autoScrollingMode: "onStart",
				hotSpotScrolling: false,
				touchScrolling: true
			});
		});

  </script>

<style>
  .profile {
    border-radius: 50%;
    /* border: 1px solid gray; */

    }

</style>
@stop