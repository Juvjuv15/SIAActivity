@extends('header')
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 
@section('styles')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
   <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
.container{
    border: 1px solid #138496 !important;
    border-radius:5px !important;
}
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
    border: 2px;
    border-radius: 5px;
    font-size: 16px;
    background-color: #2f4454;
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 12px 10px 12px 10px;
    display: right;
    text-align: center;
}

.button:hover {
    background: teal;
    text-decoration: none; 
    color: white;
}
<!-- #editable{
    border:1px solid red;
} -->
.card-body{
    font-family: "Roboto Condensed", sans-serif;
    background:white;
    border: 1px solid #17a2b8 !important;
    <!-- border-radius: 5px; -->
}
.card-header{
    border: 1px solid #17a2b8 !important;
}
@stop

@section('body')


@if (session('findstatus'))
    <div align="center" class="alert alert-danger">
        <h5>{{ session('findstatus') }}</h5>
    </div>
@endif


<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-lg-6 pb-5">  
            <div class="card border-info rounded-5">
                <div class="card-header p-0">
                    <div class="bg-info text-white text-center py-2">
                        
                        <h1 style="margin: 20px 0px 20px 0px;">UPDATE PENDING PROPERTY</h1>
                        
                    </div>
                </div>
                <div class="card-body p-3">
                    <form autocomplete="off" action="{{url('/add/'.$pendinglotDetails->id.'/savependingProperty')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <center>
                        <!-- <font size="4"><b>Fields marked with</font><font size="5" color="red"><b> *</b></font><font size="4"> are editable.</b></font> -->
                        
                        </center>

                        <font size="3"><b>Property Information</b></font>
                        <div class="form-group row">
                            <label for="lotNumber" class="col-md-4 col-form-label text-md-right">{{ __('Owner') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="lotowner" value="{{$pendinglotDetails->lotOwner}}" placeholder="owners name in the tax declaration or title ">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lotNumber" class="col-md-4 col-form-label text-md-right">{{ __('Lot number') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="lotNumber" value="{{$pendinglotDetails->lotNumber}}"  >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lotTitleNumber" class="col-md-4 col-form-label text-md-right">{{ __('Lot Title Number') }}</label>
                            <div class="col-md-6">
                                <!-- <span id="loTitletNumber" type="text" class="form-control" name="lotTitleNumber">{{$pendinglotDetails->lotTitleNumber}}</span> -->
                                <input type="text" class="form-control" name="lotTitleNumber" value="{{$pendinglotDetails->lotTitleNumber}}" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lotArea" class="col-md-4 col-form-label text-md-right">{{ __('Lot Area') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="lotArea" value="{{$pendinglotDetails->lotArea}}"  >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="unitOfMeasure" class="col-md-4 col-form-label text-md-right">{{ __('Unit Of Measure') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="unitOfMeasure" value="{{$pendinglotDetails->unitOfMeasure}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lotType" class="col-md-4 col-form-label text-md-right">{{ __('Lot Type') }}</label>
                            <div class="col-md-6">
                                <select name="lotType" class="form-control" required>
                                    <option value="{{$pendinglotDetails->lotType}}">{{$pendinglotDetails->lotType}}</option>
                                    @foreach($lotType as $types)
                                    <option value="{{$types['lotType']}}">{{$types['lotType']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- <div class="form-group row">
                            <label for="lotNumber" class="col-md-4 col-form-label text-md-right">{{ __('Lot number') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="lotNumber" value="{{$pendinglotDetails->lotNumber}}"  n>
                            </div>
                        </div> -->

                        <div class="form-group row">
                            <label for="lotNorthEastBoundary" class="col-md-4 col-form-label text-md-right">{{ __('Lot North East Boundary') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="lotNorthEastBoundary" value="{{$pendinglotDetails->lotNorthEastBoundary}}"  >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lotNorthWestBoundary" class="col-md-4 col-form-label text-md-right">{{ __('Lot North West Boundary') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="lotNorthWestBoundary" value="{{$pendinglotDetails->lotNorthWestBoundary}}"  >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lotSouthEastBoundary" class="col-md-4 col-form-label text-md-right">{{ __('Lot South East Boundary') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="lotSouthEastBoundary" value="{{$pendinglotDetails->lotSouthEastBoundary}}"  >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lotSouthWestBoundary" class="col-md-4 col-form-label text-md-right">{{ __('Lot South West Boundary') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="lotSouthWestBoundary" value="{{$pendinglotDetails->lotSouthWestBoundary}}"  >
                            </div>
                        </div>

                        
                        <div class="form-group row">
                            <label for="lotNorthBoundary" class="col-md-4 col-form-label text-md-right">{{ __('Lot North Boundary') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="lotNorthBoundary" value="{{$pendinglotDetails->lotNorthBoundary}}"  >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lotEastBoundary" class="col-md-4 col-form-label text-md-right">{{ __('Lot East Boundary') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="lotEastBoundary" value="{{$pendinglotDetails->lotEastBoundary}}"  >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lotSouthBoundary" class="col-md-4 col-form-label text-md-right">{{ __('Lot South Boundary') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="lotSouthBoundary" value="{{$pendinglotDetails->lotSouthBoundary}}"  >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lotWestBoundary" class="col-md-4 col-form-label text-md-right">{{ __('Lot West Boundary') }}</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="lotWestBoundary" value="{{$pendinglotDetails->lotWestBoundary}}">
                            </div>
                        </div>

                        <div class="text-center" style="margin:5px 15px 0px 15px;">
                                <input type="submit" value="UPDATE" class="btn btn-info btn-block rounded-5 py-2">
                        </div>

                            
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@section('js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>


<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection
@stop

