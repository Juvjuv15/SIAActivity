@extends('header')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>    <link rel="Stylesheet" type="text/css" href="{{asset('css/smoothDivScroll.css')}}">  
@section('styles')

.caps{
    text-transform:uppercase;
}
.container{
    width:100% !important;
}
@stop
@section('body')
    <div class="container">
        <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a data-toggle="tab" href="#home">HOME</a></li>
            <li><a data-toggle="tab" href="#posted">SOLD/CHARTERED</a></li>
            <li><a data-toggle="tab" href="#markintended">INTENDED BY BUYER(S)/LEASER(S)</a></li>
            <li><a data-toggle="tab" href="#intended">INTENDED PROPERTY(IES)</a></li>
        </ul>

        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
            <h3>HOME</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>
            <div id="posted" class="tab-pane fade">
                @foreach($listall as $sellers)

                    <div class="form-group row">

                    <label class="col-md-7 col-form-label text-md-right">

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
                    @endforeach
                    </label>
                    <div class="col-md-5">
                    @if($sellers->status=="free")
                    <a class="edit" href="{{url('/seller/'.$sellers['tid'].'/edit')}}"><img  src="{{ asset('images/pencil.png') }}" height="15" width="15"></a>
                    @endif
                    @if($sellers->sellingstatus!=null)
                    @if($sellers->sellingtype=="For Lease")
                    <img src="{{ asset('images/rent.png') }}" class="status">
                    @else
                    <img src="{{ asset('images/sold1.png') }}" class="status">
                    @endif
                    @endif
                    <b>
                    {{$sellers['sellingtype']}} 
                    {{$sellers['slottype']}}
                    </b>
                    <br>
                    <img src="{{ asset('images/location.png') }}" height="13" width="13"> {{$sellers['slotaddress']}}
                    <br>
                    <b>Area: </b>{{$sellers['slotarea']}}
                    <br>
                    <b>Price: </b>{{$sellers['lotprice']}}
                    <br>
                    <b>Mode of Payment: </b>{{$sellers['paymenttype']}}
                    <br>

                    @if($sellers->sellingtype=="For Lease")
                    <b>Advance Deposit: </b>{{$sellers['leasedeposit']}}
                    <br>
                    @endif



                        @if($sellers->paymenttype=="Installment")
                            @if($sellers->interest!=null)
                            <b>Interest Rate: </b>{{$sellers['interest']}}%
                            <br>
                            @endif
                            @if($sellers->installmentdownpayment!=null)
                            <b>Downpayment: </b>{{$sellers['installmentdownpayment']}}
                            <br>
                            @endif
                            <b>Years/Months to pay remaining balance: </b>{{$sellers['installmenttimetopay']}}
                            <br>
                            <b>Payment Type: </b>{{$sellers['installmentPaymentType']}} ({{$sellers['installmentPayment']}} {{$sellers['installmentPaymentType']}})
                            <br>
                            
                        @endif


                    @if($sellers->lotdescription!=null)
                    <b>Property Description:</b>
                    <br>
                    {{$sellers['lotdescription']}}
                    <br>
                    @endif
                    @foreach($owner as $owned)
                    <b><i class="fa fa-phone"></i> </b>
                    {{$owned['contact']}}
                    @if($owned->secondarycontact!=null)
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;{{$owned['secondarycontact']}}
                    @endif
                    <br>
                    <b><i class="fa fa-envelope"></i> </b>
                    <a href="#">{{$owned['email']}}</a>
                    @endforeach
                    <br>
                    <a href="{{url('/documents/'.$sellers['tid'].'/view')}}">view attached proofs</a>
                    <br>
                    <font color="red" size="1"><b>{{ __('Date Posted') }}</b></font> <font color="" size="1">{{date('F d, Y', strtotime($sellers['created_at']))}}</font>
                    </div>
                    </div>
                    <center>
                    @if($sellers->sellingstatus==null)
                    @if($sellers->count!=null)
                    @if($sellers->sellingtype=="For Sale")
                    No. of Potential Buyers<font color="red"><a href="{{url('/viewuserwhointended/'.$sellers['tid'].'/list')}}"><b> {{$sellers['count']}}</b></a></font>
                    @else
                    No. of Potential Leasers<font color="red"><a href="{{url('/viewuserwhointended/'.$sellers['tid'].'/list')}}"><b> {{$sellers['count']}}</b></a></font>
                    @endif
                    @endif
                    @endif
                    </center> 
                @endforeach
            </div> <!--end posted div -->
            <div id="markintended" class="tab-pane fade">
            <h3>Menu 2</h3>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
            </div>
            <div id="intended" class="tab-pane fade">
            <h3>Menu 3</h3>
            <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
            </div>
        </div>
    </div>
    <!-- property owned modal -->
    <div class="modal fade property_modal-modal-md" id="upload_modal" tabindex="-1" role="dialog" aria-labelledby="upload_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
            <form action="{{url('/uploadCsv')}}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="upload_modal">UPLOAD CSV FILE</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                <input type="file" name="upload-file" required>
                
                <div class="footer text-center">
                <!-- <hr> -->
                <input type="submit" class="btn btn-outline-info" value="Upload">
                </div>
                </div>
            </form>
            </div>
        </div>
    </div>
@endsection