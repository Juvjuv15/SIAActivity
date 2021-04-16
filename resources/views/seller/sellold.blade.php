@extends('header')
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 
@section('styles')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
   <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

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
    border: 1px #9aacb8;
    border-radius: 5px;

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
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <form autocomplete="off" action="{{url('seller/addlot')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <center>
                        <!-- <font size="4"><b>Fields marked with</font><font size="5" color="red"><b> *</b></font><font size="4"> are editable.</b></font> -->
                        
                        </center>
                        <font size="3"><b>Seller's Information</b></font>
                        <div class="form-group row">
                            <label for="postedBy" class="col-md-4 col-form-label text-md-right">{{ __('Seller') }}</label>

                            <div class="col-md-6">
                                <span id="postedBy" type="text" class="form-control" name="postedBy" value="">{{$user->name}} {{$user->lname}}</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <span id="email" type="text" class="form-control" name="email" value="">{{$user->email}}</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="contact" class="col-md-4 col-form-label text-md-right">{{ __('Primary Contact Number') }}</label>

                            <div class="col-md-6">
                                <span id="contact" type="text" class="form-control" name="contact" value="">{{$user->contact}}</span>
                            </div>
                        </div>
                        @if($user->secondarycontact!=null)
                        <div class="form-group row">
                            <label for="scontact" class="col-md-4 col-form-label text-md-right">{{ __('Secondary Contact Number') }}</label>
                            <div class="col-md-6">
                            <span id="scontact" type="text" class="form-control" name="scontact" value="">{{$user->secondarycontact}}</span>
                            </div>
                        </div>
                        @endif
                        
                        <font size="3"><b>Property Information</b></font>

                        <div class="form-group row">
                            <label for="slotNumber" class="col-md-4 col-form-label text-md-right">{{ __('Lot number') }}</label>

                            <div class="col-md-6">
                            <span id="slotNumber" type="text" class="form-control" name="slotNumber">{{$lotDetails->lotNumber}} {{$lotDetails->unitOfMeasure}}</span>

                                <input type="text" class="form-control" name="slotNumber" value="{{$lotDetails->lotNumber}}" hidden>
                                </div>
                            </div>

                            <div class="form-group row">
                            <label for="lotaddress" class="col-md-4 col-form-label text-md-right">{{ __('Property Address') }}<font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                                <input id="lotaddress" type="text" class="form-control" name="lotaddress" value="{{$lotDetails->lotAddress}}">
                                </div>
                            </div>

                            
                            <div class="form-group row">
                            <label for="lottype" class="col-md-4 col-form-label text-md-right">{{ __('Land type') }}<font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                            <select name="lottype" class="form-control" required>
                            <option value="{{$lotDetails->lotType}}">{{$lotDetails->lotType}}</option>
                            @foreach($lotType as $types)
                            <option value="{{$types['lotType']}}">{{$types['lotType']}}</option>
                            @endforeach
                            </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lotarea" class="col-md-4 col-form-label text-md-right">{{ __('Lot area') }}<font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                                <input id="lotarea" type="text" class="form-control" name="lotarea" value="{{$lotDetails->lotArea}} {{$lotDetails->unitOfMeasure}}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="rightofway" class="col-md-4 col-form-label text-md-right">{{ __('Vehicular Right of Access to Site') }}<font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-7">
                                (select all that fits)<br/>
                                <input id="rightofway" type="checkbox" class="" name="rightofway[]" value="Motorcycle">Motorcycle<br>
                                <input id="rightofway" type="checkbox" class="" name="rightofway[]" value="Car">Car<br>
                                <input id="rightofway" type="checkbox" class="" name="rightofway[]" value="DumpTruck">Dump Truck<br>
                                <input id="rightofway" type="checkbox" class="" name="rightofway[]" value="TenWheelerTruck">Ten Wheeler Truck

                            </div>
                        </div>

                            <div class="form-group row">
                            <label for="sellingtype" class="col-md-4 col-form-label text-md-right">{{ __('Selling Type') }}<font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                            <select id="type" name="sellingtype"  class="form-control" required>
                            <option value="">Select one</option>
                            @foreach($sellingType as $types)
                            <option value="{{$types['sellingType']}}">{{$types['sellingType']}}</option>
                            @endforeach
                            </select>
                            </div>
                            </div>

                        <div id="lease" style="display:none;">

                        <div class="form-group row">
                            <label for="leasepaymenttype" class="col-md-4 col-form-label text-md-right">{{ __('Payment Basis') }} <font size="4" color="red"><b>*</b></font></label>
                            <div class="col-md-6">
                                <select name="leasepaymenttype"  class="form-control">
                                <option value="">Select one</option>
                                    @foreach($paymenttypes as $value)
                                    <option value="{{$value['paymentType']}}">{{$value['paymentType']}}</option>
                                    @endforeach
                                </select>                            
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="leaseprice" class="col-md-4 col-form-label text-md-right">{{ __('Price') }}<font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                                <input id="leaseprice" type="text" class="form-control" name="leaseprice" value="{{ old('leaseprice') }}" >
                             </div>
                        </div>

                        <div class="form-group row">
                            <label for="leasedeposit" class="col-md-4 col-form-label text-md-right">{{ __('Advance Deposit') }} </label>
                                <div class="col-md-6">
                                    <select name="leasedeposit"  class="form-control">
                                    <option value="">Select one</option>
                                    @foreach($months as $month)
                                    <option value="{{$month['month']}}">{{$month['month']}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        

                        <div id="sell" style="display:none;">

                        <div class="form-group row">
                        <label for="sellpaymenttype" class="col-md-4 col-form-label text-md-right">{{ __('Payment Basis') }} <font size="4" color="red"><b>*</b></font></label>
                            <div class="col-md-6">
                                <select id="sellpaymenttype" name="sellpaymenttype"  class="form-control">
                                <option value="">Select one</option>
                                <option value="Cash">Cash</option>
                                <option value="Installment">Installment</option>
                                </select>                            
                            </div>
                        </div>

                        <div id="cashpayment" style="display:none;">
                        <div class="form-group row">
                            <label for="cashlotprice" class="col-md-4 col-form-label text-md-right">{{ __('Price') }}<font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                                <input id="cashlotprice" type="text" class="form-control" name="cashlotprice" value="{{ old('cashlotprice') }}">
                             </div>
                        </div>
                        </div>

                    <div id="installment" style="display:none;">                      
                        <div class="form-group row">
                        <label for="installmentprice" class="col-md-4 col-form-label text-md-right">{{ __('Price') }}<font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                                <input id="installmentprice" type="text" class="form-control" name="installmentprice" value="{{ old('installmentprice') }}" >
                             </div>
                        </div>

                        <div class="form-group row">     
                            <label for="installmentdownpayment" class="col-md-4 col-form-label text-md-right">{{ __('Downpayment (optional)') }}</label>
                            <div class="col-md-6">
                            <input id="installmentdownpayment" type="text" class="form-control" name="installmentdownpayment" value="{{ old('installmentdownpayment') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="interest" class="col-md-4 col-form-label text-md-right">{{ __('Interest rate') }} <font size="4" color="red"><b>*</b></font></label>
                            <div class="col-md-6">
                            <input id="interest" type="text" class="form-control" name="interest" value="{{ old('interest') }}" >                                                        
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="installmentPaymentType" class="col-md-4 col-form-label text-md-right">{{ __('Payment Basis') }} <font size="4" color="red"><b>*</b></font></label>
                            <div class="col-md-6">
                                <select name="installmentPaymentType"  class="form-control">
                                    @foreach($paymenttypes as $value)
                                    <option value="{{$value['paymentType']}}">{{$value['paymentType']}}</option>
                                    @endforeach
                                </select>                            
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="installmenttimetopay" class="col-md-4 col-form-label text-md-right">{{ __('Years/Months to pay balance') }} <font size="4" color="red"><b>*</b></font></label>
                            <div class="col-md-6">
                            <select name="installmenttimetopay"  class="form-control">
                                    @foreach($months as $month)
                                    <option value="{{$month['month']}}">{{$month['month']}}</option>
                                    @endforeach
                            </select>
                            <!-- <select name="timeToPayUnit"  class="form-control">
                                    @foreach($months as $month)
                                    <option value="{{$month['month']}}">{{$month['month']}}</option>
                                    @endforeach
                            </select>   -->
                            </div>
                            </div>

                    </div>
                </div>


                        <div class="form-group row">
                            <label for="lotdescription" class="col-md-4 col-form-label text-md-right">{{ __('Lot description') }} <font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                                <textarea rows="10" cols="1000" name="lotdescription" id="lotdescription" class="form-control" value="{{ old('lotdescription') }}" required></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="file[]" class="col-md-4 col-form-label text-md-right">{{ __('Add picture or panoramic picture') }}<font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                                <input id="file" type="file" class="" name="file[]" required>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="file[]" class="col-md-4 col-form-label text-md-right">{{ __('Add video') }}</label>

                            <div class="col-md-6">
                                <input id="file" type="file" class="" name="file[]" multiple>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="document[]" class="col-md-4 col-form-label text-md-right">{{ __('Add lot plan') }}</label>

                            <div class="col-md-6">
                                <input id="document" type="file" class="" name="document[]" multiple>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="document[]" class="col-md-4 col-form-label text-md-right">{{ __('Property Title') }}<font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                                <input id="document" type="file" class="" name="document[]" multiple required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="document[]" class="col-md-4 col-form-label text-md-right">{{ __('Property Tax Declaration') }}<font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                                <input id="document" type="file" class="" name="document[]" multiple required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-3" align="center">
                                <button type="submit" class="button">
                                    {{ __('POST') }}
                                </button>

                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="location.href='{{url('/dashboard')}}'" class="button" value="CANCEL">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

<script>
        $(document).ready(function (){
            $("#type").change(function() {
                if ($(this).val() == "For Lease") {
                    $("#lease").show();
                }else{
                    $("#lease").hide();
                } 
            });
        });

        $(document).ready(function (){
            $("#type").change(function() {
                // foo is the id of the other select box 
                if ($(this).val() == "For Sale") {
                    $("#sell").show();
                }else{
                    $("#sell").hide();
                } 
            });
        });

        $(document).ready(function (){
            $("#sellpaymenttype").change(function() {
                if ($(this).val() == "Installment") {
                    $("#installment").show();
                }else{
                    $("#installment").hide();
                } 
            });
        }); 

        $(document).ready(function (){
            $("#sellpaymenttype").change(function() {
                if ($(this).val() == "Cash") {
                    $("#cashpayment").show();
                }else{
                    $("#cashpayment").hide();
                } 
            });
        }); 


</script>
@stop

