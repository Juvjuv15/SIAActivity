@extends('header')
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

@stop

@section('body')

<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                <form autocomplete="off" action="{{url('/seller/'.$singleSeller->tid.'/edit')}}" method="post" enctype="multipart/form-data"> 
                        @csrf

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
                            <span id="slotNumber" type="text" class="form-control" name="slotNumber">{{$singleSeller->slotnumber}}</span>

                                <input type="text" class="form-control" name="slotNumber" value="{{$singleSeller->slotnumber}}" hidden>
                                </div>
                            </div>

                            <div class="form-group row">
                            <label for="lotaddress" class="col-md-4 col-form-label text-md-right">{{ __('Property Address') }}<font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                            <input id="lotaddress" type="text" class="form-control" name="lotaddress" value="{{ $singleSeller->slotaddress }}">
                                </div>
                            </div>

                            
                            <div class="form-group row">
                            <label for="lottype" class="col-md-4 col-form-label text-md-right">{{ __('Land type') }}<font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                            <select name="lottype" class="form-control" required>
                            <option value="{{$singleSeller->slottype}}">{{$singleSeller->slottype}}</option>
                            @foreach($lotType as $types)
                            <option value="{{$types['lotType']}}">{{$types['lotType']}}</option>
                            @endforeach
                            </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lotarea" class="col-md-4 col-form-label text-md-right">{{ __('Lot area') }}<font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                                <input id="lotarea" type="text" class="form-control" name="lotarea" value="{{$singleSeller->slotarea}}" required>
                            </div>
                        </div>

                            <div class="form-group row">
                            <label for="sellingtype" class="col-md-4 col-form-label text-md-right">{{ __('Selling Type') }}<font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                            <select id="type" name="sellingtype"  class="form-control" required>
                            <option value="{{$singleSeller->sellingtype}}">{{$singleSeller->sellingtype}}</option>
                            @foreach($sellingType as $types)
                            <option value="{{$types['sellingType']}}">{{$types['sellingType']}}</option>
                            @endforeach
                            </select>
                            </div>
                            </div>

                        <div id="lease">

                        <div class="form-group row">
                            <label for="leasepaymenttype" class="col-md-4 col-form-label text-md-right">{{ __('Payment Basis') }} <font size="4" color="red"><b>*</b></font></label>
                            <div class="col-md-6">
                                <select name="leasepaymenttype"  class="form-control">
                                <option value="{{$singleSeller->paymenttype}}">{{$singleSeller->paymenttype}}</option>
                               @foreach($pType as $value)
                                <option value="{{$value['paymentType']}}">{{$value['paymentType']}}</option>
                                @endforeach
                                </select>                            
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="leaseprice" class="col-md-4 col-form-label text-md-right">{{ __('Price') }}<font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                                <input id="leaseprice" type="text" class="form-control" name="leaseprice" value="{{$singleSeller->lotprice}}" required>
                             </div>
                        </div>

                        <div class="form-group row">
                            <label for="leasedeposit" class="col-md-4 col-form-label text-md-right">{{ __('Advance Deposit') }} <font size="4" color="red"><b>*</b></font></label>
                                <div class="col-md-6">
                                    <select name="leasedeposit"  class="form-control">
                                    <option value="{{$singleSeller->leasedeposit}}">{{$singleSeller->leasedeposit}}</option>
                                @foreach($month as $value)
                                <option value="{{$value['month']}}">{{$value['month']}}</option>
                                @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        

                        <div id="sell">

                        <div class="form-group row">
                        <label for="sellpaymenttype" class="col-md-4 col-form-label text-md-right">{{ __('Payment Basis') }} <font size="4" color="red"><b>*</b></font></label>
                            <div class="col-md-6">
                                <select id="sellpaymenttype" name="sellpaymenttype"  class="form-control">
                                @if($singleSeller->paymenttype=="Cash")
                                <option value="Cash">Cash</option>
                                <option value="Installment">Installment</option>
                                @elseif($singleSeller->paymenttype=="Installment")
                                <option value="Installment">Installment</option>
                                <option value="Cash">Cash</option>
                                @else
                                <option value="Cash">Cash</option>
                                <option value="Installment">Installment</option>
                                @endif
                                </select>                            
                            </div>
                        </div>

                        <div id="cashpayment" style="display:none;">
                        <div class="form-group row">
                            <label for="cashlotprice" class="col-md-4 col-form-label text-md-right">{{ __('Price') }}<font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                                <input id="cashlotprice" type="text" class="form-control" name="cashlotprice" value="{{$singleSeller->lotprice}}" required>
                             </div>
                        </div>
                        </div>

                    <div id="installment" style="display:none;">                      
                        <div class="form-group row">
                        <label for="installmentprice" class="col-md-4 col-form-label text-md-right">{{ __('Price') }}<font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                                <input id="installmentprice" type="text" class="form-control" name="installmentprice" value="{{$singleSeller->lotprice}}" required>
                             </div>
                        </div>

                        <div class="form-group row">     
                            <label for="installmentdownpayment" class="col-md-4 col-form-label text-md-right">{{ __('Downpayment (optional)') }} <font size="4" color="red"><b>*</b></font></label>
                            <div class="col-md-6">
                            <input id="installmentdownpayment" type="text" class="form-control" name="installmentdownpayment" value="{{$singleSeller->installmentdownpayment}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="installmenttimetopay" class="col-md-4 col-form-label text-md-right">{{ __('Years/Months to pay remaining balance') }} <font size="4" color="red"><b>*</b></font></label>
                            <div class="col-md-6">
                            <select name="installmenttimetopay"  class="form-control">
                            <option value="{{$singleSeller->installmenttimetopay}}">{{$singleSeller->installmenttimetopay}}</option>
                                @foreach($month as $value)
                                <option value="{{$value['month']}}">{{$value['month']}}</option>
                                @endforeach
                            </select>  
                            </div>
                            </div>

                    </div>
                </div>


                        <div class="form-group row">
                            <label for="lotdescription" class="col-md-4 col-form-label text-md-right">{{ __('Add description (optional)') }}</label>

                            <div class="col-md-6">
                                <textarea rows="10" cols="1000" name="lotdescription" id="lotdescription" class="form-control" value="{{ old('lotdescription') }}"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="file[]" class="col-md-4 col-form-label text-md-right">{{ __('Add picture or panoramic picture') }}</label>

                            <div class="col-md-6">
                                <input id="file" type="file" class="" name="file[]" multiple>
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
                            <label for="document[]" class="col-md-4 col-form-label text-md-right">{{ __('Property Title') }}</label>

                            <div class="col-md-6">
                                <input id="document" type="file" class="" name="document[]" multiple>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="document[]" class="col-md-4 col-form-label text-md-right">{{ __('Property Tax Declaration') }}</label>

                            <div class="col-md-6">
                                <input id="document" type="file" class="" name="document[]" multiple>
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
<br>
<br>
@stop