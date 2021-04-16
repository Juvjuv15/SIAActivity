<!DOCTYPE html>
<html lang="en">
<head>
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
    /* background-image:url('/images/roadmap.png'); */
    background-size:100%;
    background-repeat:no-repeat;
    transition: 1.0s;
}
.container{
    margin-top:10px;
}
#capslockMessage {display:none;color:red}
.show-password,.reshow-password{position: relative} 

.show-password .ptxt, .reshow-password .rptxt{ 

position: absolute; 

top: 50%; 

right: 10px; 

z-index: 9999; 

color: #f36c01; 

margin-top: -10px; 

cursor: pointer; 

transition: .3s ease all; 
} 
.show-password .ptxt:hover, .reshow-password .rptxt:hover{color: #333333;} 

</style>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-12 col-md-8 col-lg-6 pb-5">

                    <form method="POST" action="{{ route('createuser') }}" autocomplete="off">
                    @csrf
                        <div class="card border-info rounded-5">
                            <div class="card-header p-0">
                                <div class="bg-info text-white text-center py-2">
                                    
                                    <h2 style="margin: 20px 0px 20px 0px;"><img src="{{ asset('images/iplot.png') }}" height="50" width="140"></h2>
                                    
                                </div>
                            </div>
                            <div class="card-body p-3">
                            <center><p id="capslockMessage">Caps lock is ON.</p></center>
                                <!--Body-->
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-user text-info"></i></div>
                                        </div>
                                        <input id="name" type="text" class="form-control" name="name" value="{{$name}}" placeholder="Name" required>
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-user text-info"></i></div>
                                        </div>
                                        <input id="lname" type="text" class="form-control" name="lname" value="{{ old('lname') }}" placeholder="Lastname" required>
                                    </div>
                                </div> -->  
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-phone text-info"></i></div>
                                        </div>
                                        <input id="contact" type="text" class="form-control{{ $errors->has('contact') ? ' is-invalid' : '' }}" name="contact" value="{{ $contact }}" placeholder="Primary Contact Number" required>

                                        @if ($errors->has('contact'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('contact') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-phone text-info"></i></div>
                                        </div>
                                        <input id="secondarycontact" type="text" class="form-control{{ $errors->has('secondarycontact') ? ' is-invalid' : '' }}" name="secondarycontact" value="{{ $secondarycontact }}" placeholder="Secondary Contact Number (optional)">

                                        @if ($errors->has('secondarycontact'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('secondarycontact') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-building text-info"></i></div>
                                        </div>
                                        <input id="address" type="text" class="form-control" name="address" value="{{ $address }}" placeholder="Address" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-envelope text-info"></i></div>
                                        </div>
                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email }}" placeholder="Email Address" required>
                                    </div>
                                </div>
                                @if($status!=null)
                                    <h6 style="color:red; text-align:center">{{ $status}}</h6>
                                @endif
                                <div class="form-group">
                                    <div class="input-group mb-2 show-password">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-key text-info"></i></div>
                                        </div>
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password (minimum of 6 characters long)" required>
                                    </div>
                                </div>
                                @if($passwordstatus!=null)
                                        <h6 style="color:red; text-align:center">{{ $passwordstatus}}</>
                                @endif
                                <div class="form-group">
                                    <div class="input-group mb-2 reshow-password">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-key text-info"></i></div>
                                        </div>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Re-enter Password" required>
                                        </div>
                                    </div>
                                </div>
                                <input id="userType" type="hidden" class="form-control" name="userType" value="0">
                                <div class="text-center" style="margin:5px 15px 0px 15px;">
                                <input type="submit" value="JOIN" class="btn btn-info btn-block rounded-5 py-2">
                                <a class="text" href="{{ route('login') }}" style="padding:3px 15px 3px 15px"><font size="2">Cancel registration</font></a>
                                </div>
                                
                            </div>

                        </div>
                    </form>
                    
        </div>
	</div>
</div>
<script>
//for the showing hiding of password
// $(document).ready(function(){
// $('.show-password').append('<span class="ptxt">Show</span>'); 
// $('.reshow-password').append('<span class="rptxt">Show</span>');  
// });

// $(document).on('click','.show-password .ptxt', function(){ 
// $(this).text($(this).text() == "Show" ? "Hide" : "Show"); 
// $(this).prev().attr('type', function(index, attr){return attr == 'password' ? 'text' : 'password'; }); 
// });


// $(document).on('click','.reshow-password .rptxt', function(){ 
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


</script>
</body>
</html>