@extends('header')
@section('styles')
.add{
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

.add:hover {
    background: #9ecdd5;
    text-decoration: none; 
    color: gray;
}

@stop
@section('body')
<br>
<div class="container">
    <div class="row justify-content-center">
    
        <div class="col-md-11">
        
            <div class="card">
                <div class="card-header" align="center">
                <h1>{{ Auth::user()->name }}</h1>
                </div>
                
                <div class="card-body">   
                <div align="right"> 
                <input type="button" onclick="location.href='{{url('seller/addlotform')}}'" name="transactionType" class="add" value="SELL/MAGPAUPA">&nbsp;
                  </div>
                         @foreach($listall as $sellers)
                              <div>
                              <table class="pagination card col-sm-10 list-group-item" align="center"> 
                              <br> 
                              <tr>
                              <td>
                              @foreach($sellers->images as $image)
                                <div class="panorama">   
                                <img src="{{ $image->fileExt }}" height="170px" width:"270px">   
                                <!-- <video src="{{ $image->fileExt }}" height="170px" width:"270px"> -->
                                <!-- <img src="C:\xampp\htdocs\laravel\project\public\public\files\0d958d788358255b5b36570f9d33b764.jpg" height="100" width="100">-->
                                </div>    
                              @endforeach  
                              </td>   
                              </tr>
                              <th>Lot number</th>
                              <tr>  
                              <td> 
                              {{$sellers['slotnumber']}}
                              </td> 
                              </tr>
                              <th>Selling Type:</th>
                              <tr>
                              <td>
                              {{$sellers['sellingtype']}}
                              <td>
                              </tr>
                              <th>Land Type:</th>
                              <tr>
                              <td>
                              {{$sellers['lottype']}}
                              <td>
                              </tr>
                              <th>Lot Area:</th>
                              <tr>
                              <td>
                              {{$sellers['lotarea']}}
                              </td>
                              </tr>
                              <th>Lot Price:</th>
                              <tr>
                              <td>
                              {{$sellers['lotprice']}}
                              </td>
                              </tr>
                              <th>Contact Number:</th>
                              <tr>
                              <td>
                              {{$sellers['contactnumber']}}
                              </td>
                              </tr>
                              <th>Lot Description:</th>
                              <tr>   
                              <td>
                              {{$sellers['lotdescription']}}
                              </td>
                              </tr>
                              <th>Date Posted:</th>
                              <tr>
                              <td>
                              {{$sellers['created_at']}}
                              </td>
                              </tr>
                              <tr> 
                              <td>
                              <a href="{{url('/seller/'.$sellers['tid'].'/edit')}}" class="btn btn-success">Edit</a>
                              </td>
                              @endforeach
                              </table>
                              <br>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
</div> 
@section('js')

@stop

@endsection

