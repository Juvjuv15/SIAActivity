<!DOCTYPE html>
<html lang="en">
<head>
<title>Instant Plot</title>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<script src="http://mymaplist.com/js/vendor/TweenLite.min.js"></script> -->
</head>
<style>
body{
    background-image:url('/images/roadmap.png');
    background-size:100%;
    background-repeat:no-repeat;
    transition: 1.0s;
}
.container{
    margin-top:120px;
}
#capslockMessage {display:none;color:red}
div#instruction_modal {
  background-color: #17a2b873;
  overflow: auto;
}
.join:hover{
    cursor:pointer;
}
.show-password{position: relative} 

.show-password .ptxt { 

position: absolute; 

top: 50%; 

right: 10px; 

z-index: 99; 

color: #f36c01; 

margin-top: -10px; 

cursor: pointer; 

transition: .3s ease all; 

} 

.show-password .ptxt:hover{color: #333333;} 
</style>
 @if(session('status'))
                                    
    <div align="center" class="alert alert-success" id="prompt">
        <strong>{{ session('status') }}<i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></strong>
    </div>
@endif
<div class="container">
	<div class="row justify-content-center">
		<div class="col-12 col-md-8 col-lg-6 pb-5">

                    <form method="POST" action="{{ route('login') }}" autocomplete="off">
                    @csrf
                        <div class="card border-info rounded-5">
                            <div class="card-header p-0">
                                <div class="bg-info text-white text-center py-2">
                                    
                                    <h2 style="margin: 20px 0px 20px 0px;"><img src="{{ asset('images/iplot.png') }}" height="50" width="140"></h2>
                                    
                                </div>
                            </div>
                            <div class="card-body p-3">

                                <!--Body-->
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-envelope text-info"></i></div>
                                        </div>
                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2 show-password">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-key text-info"></i></div>
                                        </div>
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                    </div>
                                </div>
                                <center><p id="capslockMessage">Caps lock is ON.</p></center>

                                <div align="center">
                                    @if(session('passwordstatus'))
                                    
                                                <div align="center" class="alert alert-danger" id="prompt">
                                                    <strong>{{ session('passwordstatus') }}<i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></strong>
                                                </div>
                                    @elseif(session('emailstatus'))
                                    
                                                <div align="center" class="alert alert-danger" id="prompt">
                                                    <strong >{{ session('emailstatus') }}<i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-transparent w3-display-topright" id="close"></i></strong>
                                                </div>
                                    @endif
                                </div>

                               <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <div class="checkbox">
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                            <font size="3">Forgot your password?</font>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center" style="margin:15px 0px 0px 0px;">
                                    <input type="submit" value="Login" class="btn btn-info btn-block rounded-5 py-2">
                                </div>

                                <div class="text-center" style="margin:10px 0px 0px 0px;">
                                    <font size="2">Buy/Rent or Sell/Charter lot property with us </font>
                                    <a id="join" class="join" href="{{ '/reg' }}"><font size="2" color="blue">Join us</font></a>
                                </div>
                            </div>

                        </div>
                    </form>
        </div>
	</div>
</div>
<!-- <div class="modal instruction_modal-modal-lg" id="instruction_modal" tabindex="-1" role="dialog" aria-labelledby="instruction_modal" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="upload_modal">INSTRUCTIONS</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" onclick="w3_close()" id="close">×</span>
            </button>
        </div>
        <div class="modal-body">
        1. Register a valid email account.<br/>
        SELLING/CHARTERING<br/>
        2. Confirm properties you owned in the assessors office. Bring valid documents as proof of ownership (e.g. tax declaration, lot title).<br/>
        3. Authorization letter from the property owner notarized by a lawyer is needed when confirming properties you do not own. Bring valid documents as proof of ownership (e.g. tax declaration, lot title).<br/>
        4. Use registered email address in InstantPlot as the email address to be used when confirming properties in the assessors office.(A notification will be sent after confirming the property)<br/>
        5. Login using your InstantPlot Registered G-mail and password.<br/>
        6. Click Sell button in the Home Page to view confirmed properties. Confirmed Properties can also be viewed on the left side of the Dashboards below your profile.<br/>
        7. Click on the Lot Number of the property you want to sell or charter.<br/>
        BUYING/RENTING<br/>
        8. Click Buy/Rent Button.<br/>
        9. Set your own criterias in searching.<br/>
        10. Hover on the markers to view partial lot details.<br/>
        11. Click on the marker to view full details.<br/>
        12. Click Place an Intent Button to notify seller your interest in buying or leasing the property.<br/>
        13. Viola! You're good to go.<br/><br/>
        Disclaimer: <br/>
        &emsp;Property details confirmed in the assessors office are not disclosed with other users of InstantPlot except the property owner. Property owner are the only ones who can view the list of properties they confirmed in the assessors office. Other confirmed properties confirmed by other users are not disclosed and are not viewable by other users.<br/>
        &emsp;The information contained on each individual property for sale or for rent has been gathered from the seller or leasor of the property. We cannot verify or guarantee its accuracy either way. Prospective purchasers or tenants must rely on their own inquiries and should verify accuracy of information before proceeding to buy or lease.<br/>
        &emsp;Please note, the material available is general information only, and is subject to change without notice. The information held within this website should not be relied on as a substitute for legal, financial, real-estate or other expert advice. InstantPlot disclaims all liability, responsibility and negligence for direct and indirect loss or damage suffered by any person arising from the use of information presented on this website or material that arises from it.
        <div class="footer text-center">
        <hr>
        <a class="continue" href="{{ route('register') }}"><font size="2">CONTINUE...</font></a>
        </div>
        </div>
    </div>
</div>
</div> -->
<script>
//for the showing hiding of password
// $(document).ready(function(){
// $('.show-password').append('<span class="ptxt">Show</span>');  
// });

// $(document).on('click','.show-password .ptxt', function(){ 

// $(this).text($(this).text() == "Show" ? "Hide" : "Show"); 

// $(this).prev().attr('type', function(index, attr){return attr == 'password' ? 'text' : 'password'; }); 

// });  

function w3_close() {
    document.getElementById("prompt").style.display = "none";
}

var emailInput = document.getElementById("email");
var passInput = document.getElementById("password");

var text = document.getElementById("capslockMessage");
emailInput.addEventListener("keyup", function(event) {

if (event.getModifierState("CapsLock")) {
    text.style.display = "block";
  } else {
    text.style.display = "none"
  }
});

passInput.addEventListener("keyup", function(event) {
if (event.getModifierState("CapsLock")) {
    text.style.display = "block";
  } else {
    text.style.display = "none"
  }
});
// $(document).ready(function(){
//     $("#join").click(function(){
//         $("#instruction_modal").show();
//     });
// });
// function w3_close() {
//     document.getElementById("instruction_modal").style.display = "none";
// }
</script>
</body>
</html>