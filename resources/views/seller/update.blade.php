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
                        
                        <h1 style="margin: 20px 0px 20px 0px;">UPDATE POSTED PROPERTY</h1>
                        
                    </div>
                </div>
                <div class="card-body p-3">
                    <form autocomplete="off" action="{{url('/seller/'.$singleSeller->tid.'/edit')}}" method="post" enctype="multipart/form-data" id="form3"> 
                        @csrf
                        <!-- <center>
                        <font size="4"><b>Fields marked with</font><font size="5" color="red"><b> *</b></font><font size="4"> are editable.</b></font>
                        
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
                         -->
                        <font size="3"><b>Property Information</b></font>

                        <div class="form-group row">
                            <label for="slotNumber" class="col-md-4 col-form-label text-md-right">{{ __('Lot number') }}</label>

                            <div class="col-md-6">
                            <span id="slotNumber" type="text" class="form-control" name="slotNumber">{{$singleSeller->lotNumber}}</span>

                                <input type="text" class="form-control" name="slotNumber" value="{{$singleSeller->lotNumber}}" hidden>
                                </div>
                            </div>

                            <div class="form-group row">
                            <label for="lotaddress" class="col-md-4 col-form-label text-md-right">{{ __('Property Address') }}</label>

                            <div class="col-md-6">
                                <span id="lotaddress" type="text" class="form-control" name="lotaddress">{{$singleSeller->lotAddress}}</span>
                                <!-- <input id="lotaddress" type="text" class="form-control" name="lotaddress" value="{{$singleSeller->lotAddress}}"> -->
                                </div>
                            </div>

                            
                            <div class="form-group row">
                            <label for="lottype" class="col-md-4 col-form-label text-md-right">{{ __('Land type') }}</label>

                            <div class="col-md-6">
                                <span id="lottype" type="text" class="form-control" name="lottype">{{$singleSeller->lotType}}</span>
                            <!-- <select name="lottype" class="form-control" required>
                            <option value="{{$singleSeller->lotType}}">{{$singleSeller->lotType}}</option>
                            @foreach($lotType as $types)
                            <option value="{{$types['lotType']}}">{{$types['lotType']}}</option>
                            @endforeach
                            </select> -->
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lotarea" class="col-md-4 col-form-label text-md-right">{{ __('Lot area') }}</label>

                            <div class="col-md-6">
                                <span id="lotarea" type="text" class="form-control" name="lotarea">{{$singleSeller->lotArea}} {{$singleSeller->unitOfMeasure}}</span>
                                <!-- <input id="lotarea" type="text" class="form-control" name="lotarea" value="{{$singleSeller->lotArea}}" required> -->
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="rightofway" class="col-md-4 col-form-label text-md-right">{{ __('Vehicular Right of Access to Site') }}<font size="4" color="red"><b>*</b></font></label>
                            <?php $rways = $singleSeller->rightOfWay; 
                                  $vehicles = explode(" ",$rways);
                            ?>
                            <div class="col-md-7">
                                (select all that applies)<br/>
                                <input id="rightofway1" class="rightofway" <?php if (in_array("Motorcycle",$vehicles)) {echo "checked";} ?> type="checkbox" name="rightofway[]" value="Motorcycle">Motorcycle<br>
                                <input id="rightofway2" class="rightofway" <?php if (in_array("Car",$vehicles)) {echo "checked";} ?> type="checkbox" name="rightofway[]" value="Car">Car<br>
                                <input id="rightofway4" class="rightofway" <?php if (in_array("DumpTruck",$vehicles)) {echo "checked";} ?> type="checkbox" name="rightofway[]" value="DumpTruck">Dump Truck<br>
                                <input id="rightofway5" class="rightofway" <?php if (in_array("TenWheelerTruck",$vehicles)) {echo "checked";} ?> type="checkbox" name="rightofway[]" value="TenWheelerTruck">Ten Wheeler Truck

                            </div>
                        </div>

                            <div class="form-group row">
                            <label for="sellingtype" class="col-md-4 col-form-label text-md-right">{{ __('Selling Type') }}<font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                            <select id="type" name="sellingtype"  class="form-control" required>
                            <option value="{{$singleSeller->sellingType}}">{{$singleSeller->sellingType}}</option>
                            @foreach($sellingType as $types)
                            <option value="{{$types['sellingType']}}">{{$types['sellingType']}}</option>
                            @endforeach
                            </select>
                            </div>
                            </div>
                            <!-- ---------------------------------------- -->
                            <!-- <div id="rent" style="display:none;">
                            <div class="form-group row">
                                <label for="rentpaymenttype" class="col-md-4 col-form-label text-md-right">{{ __('Payment Basis') }} <font size="4" color="red"><b>*</b></font></label>
                                <div class="col-md-6">
                                    <select name="rentpaymenttype"  class="form-control">
                                        <option value="{{$singleSeller->paymentType}}">{{$singleSeller->paymentType}}</option>
                                        @foreach($pType as $value)
                                        <option value="{{$value['paymentType']}}">{{$value['paymentType']}}</option>
                                        @endforeach
                                    </select>                            
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="rentprice" class="col-md-4 col-form-label text-md-right">{{ __('Rent Price') }}<font size="4" color="red"><b>*</b></font></label>

                                <div class="col-md-6">
                                    <input id="rentprice" type="text" class="form-control" name="rentprice" value="{{$singleSeller->lotPrice}}" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="rentdeposit" class="col-md-4 col-form-label text-md-right">{{ __('Advance Deposit') }} </label>
                                <div class="col-md-6">
                                    <select name="rentdeposit"  class="form-control">
                                        <option value="{{$singleSeller->leaseDeposit}}">{{$singleSeller->leaseDeposit}}</option>
                                        @foreach($advanceDeposit as $value)
                                        <option value="{{$value['month']}}">{{$value['month']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="rentcontract" class="col-md-4 col-form-label text-md-right">{{ __('Contract Period') }} </label>
                                    <div class="col-md-6">
                                        <select name="rentcontract"  class="form-control">
                                        <option value="{{$singleSeller->contractPeriod}}">{{$singleSeller->contractPeriod}}</option>
                                        @foreach($contractperiod as $month)
                                        <option value="{{$month['month']}}">{{$month['month']}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                            </div>
                        </div> -->
                        <!-- ---------------------------- -->
                        <div id="lease" style="display:none;">

                        <div class="form-group row">
                            <label for="leasepaymenttype" class="col-md-4 col-form-label text-md-right">{{ __('Payment Basis') }} <font size="4" color="red"><b>*</b></font></label>
                            <div class="col-md-6">
                                <select name="leasepaymenttype"  class="form-control">
                                    <option value="{{$singleSeller->paymentType}}">{{$singleSeller->paymentType}}</option>
                                    @foreach($pType as $value)
                                    <option value="{{$value['paymentType']}}">{{$value['paymentType']}}</option>
                                    @endforeach
                                </select>                            
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="leaseprice" class="col-md-4 col-form-label text-md-right">{{ __('Lease Price') }}<font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                                <input id="leaseprice" type="text" class="form-control" name="leaseprice" value="{{$singleSeller->lotPrice}}" >
                             </div>
                        </div>

                        <div class="form-group row">
                            <label for="leasedeposit" class="col-md-4 col-form-label text-md-right">{{ __('Advance Deposit') }} </label>
                                <div class="col-md-6">
                                    <select name="leasedeposit"  class="form-control">
                                    <option value="{{$singleSeller->leaseDeposit}}">{{$singleSeller->leaseDeposit}}</option>
                                    @foreach($advanceDeposit as $value)
                                    <option value="{{$value['month']}}">{{$value['month']}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="contractPeriod" class="col-md-4 col-form-label text-md-right">{{ __('Contract Period') }} <font size="4" color="red"><b>*</b></font></label>
                                    <div class="col-md-6">
                                        <select name="contractPeriod"  class="form-control">
                                        <option value="{{$singleSeller->contractPeriod}}">{{$singleSeller->contractPeriod}}</option>
                                        @foreach($contractperiod as $month)
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
                                @if($singleSeller->paymentType=="Cash")
                                <option value="Cash">Cash</option>
                                <option value="Installment">Installment</option>
                                @elseif($singleSeller->paymentType=="Installment")
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
                            <label for="cashlotprice" class="col-md-4 col-form-label text-md-right">{{ __('Cash Price') }}<font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                                <input id="cashlotprice" type="text" class="form-control" name="cashlotprice" value="{{$singleSeller->lotPrice}}">
                             </div>
                        </div>
                        </div>

                    <div id="installment" style="display:none;">                      
                        <div class="form-group row">
                        <label for="installmentprice" class="col-md-4 col-form-label text-md-right">{{ __('Installment Price') }}<font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                                <input id="installmentprice" type="text" class="form-control" name="installmentprice" value="{{$singleSeller->lotPrice}}" >
                             </div>
                        </div>

                        <div class="form-group row">     
                            <label for="installmentdownpayment" class="col-md-4 col-form-label text-md-right">{{ __('Downpayment (optional)') }}</label>
                            <div class="col-md-6">
                            <input id="installmentdownpayment" type="text" class="form-control" name="installmentdownpayment" value="{{$singleSeller->installDownPayment}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="interest" class="col-md-4 col-form-label text-md-right">{{ __('Interest rate') }} <font size="4" color="red"><b>*</b></font></label>
                            <div class="col-md-6">
                            <input id="interest" type="text" class="form-control" name="interest" value="{{$singleSeller->interest}}" >                                                        
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="installmentPaymentType" class="col-md-4 col-form-label text-md-right">{{ __('Payment Basis') }} <font size="4" color="red"><b>*</b></font></label>
                            <div class="col-md-6">
                                <select name="installmentPaymentType"  class="form-control">
                                    <option value="{{$singleSeller->paymentType}}">
                                    @foreach($pType as $value)
                                    <option value="{{$value['paymentType']}}">{{$value['paymentType']}}</option>
                                    @endforeach
                                </select>                            
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="installmenttimetopay" class="col-md-4 col-form-label text-md-right">{{ __('Years/Months to pay balance') }} <font size="4" color="red"><b>*</b></font></label>
                            <div class="col-md-6">
                                <select name="installmenttimetopay"  class="form-control">
                                        <option value="{{$singleSeller->installTimeToPay}}">
                                        @foreach($month as $month)
                                        <option value="{{$month['month']}}">{{$month['month']}}</option>
                                        @endforeach
                                </select>
                            </div>
                            </div>

                    </div>
                </div>


                        <div class="form-group row">
                            <label for="lotdescription" class="col-md-4 col-form-label text-md-right">{{ __('Lot description') }} <font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                                <textarea rows="10" cols="1000" name="lotdescription" id="lotdescription" class="form-control" value="{{$singleSeller->lotDescription}}" required>{{$singleSeller->lotDescription}}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="file[]" class="col-md-4 col-form-label text-md-right">{{ __('Update picture or panoramic picture') }}</label>

                            <div class="col-md-6">
                                <input id="file" type="file" name="file[]" accept="image/*">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="video[]" class="col-md-4 col-form-label text-md-right">{{ __('Update video') }}</label>

                            <div class="col-md-6">
                                <input id="video" type="file" name="video[]" accept="video/*" multiple>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="document[]" class="col-md-4 col-form-label text-md-right">{{ __('Update lot plan') }}</label>

                            <div class="col-md-6">
                                <input id="document" type="file" name="document[]" accept="image/*">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="document[]" class="col-md-4 col-form-label text-md-right">{{ __('Update Property Title') }}</label>

                            <div class="col-md-6">
                                <input id="document" type="file" name="document[]" accept="image/*">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="document[]" class="col-md-4 col-form-label text-md-right">{{ __('Update Property Tax Declaration') }}</label>

                            <div class="col-md-6">
                                <input id="document" type="file" name="document[]" accept="image/*">
                            </div>
                        </div>

                        <div class="text-center" style="margin:5px 15px 0px 15px;">
                            <input type="submit" value="UPDATE" class="btn btn-info btn-block rounded-5 py-2"><br/>
                            <a class="text" href="{{ url()->previous() }}" style="padding:3px 15px 3px 15px"><font size="2" color="blue">Cancel </font></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@section('js')
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

<script>
        //For the uploading of files
        $(function(){
            $("#form3").submit(function(){
                var $fileUpload = $("input[id='video']");
                if (parseInt($fileUpload.get(0).files.length)>3){
                alert("You can only upload a maximum of 3 video files");
                return false;
                }
            });    
        });

        //for checking if any checkbox is selected before submitting
        $("#form3").submit(function(){
            // var checked = $('.rightofway').find(':checked').length;

            // if (!checked){
            //     alert('Please select vehicular right of access to site!');
            //     return false;
            // }
            price = $("#cashlotprice").val();
            iprice = $("#installmentprice").val();
                if (price >= ({{$singleSeller->lotMarketValue}}+500000)) {
                   alert('Price is too high compared to its lot market value. Click "OK" to proceed.');
                   return true;
                } 
                if (iprice >= ({{$singleSeller->lotMarketValue}}+500000)) {
                   alert('Price is too high compared to its lot market value. Click "OK" to proceed.');
                   return true;
                } 
        });

        //for the autochecking of checkboxes
        var r1 = $("input[type='checkbox'][value='Motorcycle']");
        var r2 = $("input[type='checkbox'][value='Car']");
        var r3 = $("input[type='checkbox'][value='Bus']");
        var r4 = $("input[type='checkbox'][value='DumpTruck']")
        var r5 = $("input[type='checkbox'][value='TenWheelerTruck']")

        r2.on('change', function(){
            r1.prop('checked',this.checked);
            r3.prop('checked',false);
            r4.prop('checked',false);
        });
        r3.on('change', function(){
            r1.prop('checked',this.checked);
            r2.prop('checked',this.checked);
            r4.prop('checked',false);
            r5.prop('checked',false);
        });
        r4.on('change', function(){
            r1.prop('checked',this.checked);
            r2.prop('checked',this.checked);
            r3.prop('checked',this.checked);
            r5.prop('checked',false);
        });
        r5.on('change', function(){
            r1.prop('checked',this.checked);
            r2.prop('checked',this.checked);
            r3.prop('checked',this.checked);
            r4.prop('checked',this.checked);
        });

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
            $("#type").change(function() {
                // foo is the id of the other select box 
                if ($(this).val() == "For Rent") {
                    $("#rent").show();
                }else{
                    $("#rent").hide();
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
@endsection
@stop

