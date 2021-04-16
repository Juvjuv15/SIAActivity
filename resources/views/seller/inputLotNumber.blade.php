@extends('layouts.header')
<head>
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
   <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
   <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

 
</head>
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
    border-radius: 10px;
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
<br>
<br>     
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                @if (session('findstatus'))
                    <div align="center" class="alert alert-danger">
                        <h5>{{ session('findstatus') }}</h5>
                    </div>
                @endif
                    <form autocomplete="off" action="{{url('seller')}}" method="post" enctype="multipart/form-data">
                  @csrf
                  <center>
                  <font size="2"><b>Input the lot number of lot to be posted</b></font>
                  <center>
<br>
                        <div class="form-group row">
                            <label for="slotNumber" class="col-md-4 col-form-label text-md-right">{{ __('Lot number') }}<font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                                <input id="searchString" type="text" class="form-control" name="slotNumber" value="{{ old('slotNumber') }}">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                            <div class="col-md-5 offset-md-4" align="center">
                                <button type="submit" class="button">
                                    {{ __('Next') }}
                                </button>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="button" onclick="location.href='{{url('/home')}}'" class="button" value="CANCEL">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<br>
<br>
<br>
<br>
@stop
<script>
$( function() {
          $( "#searchString" ).autocomplete({
            // html : html,
            source: "searchlotnumber",
            minLength: 1,
            // select:function(e,ui) { 
            //     location.href = ui.item.link;
            // }
        });
      } );
</script>