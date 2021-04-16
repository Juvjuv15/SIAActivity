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
                                            <div class="input-group-text"><i class="fa fa-user text-info"></i></div>
                                        </div>
                                        <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" placeholder="Username" required autofocus>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2 show-password">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-key text-info"></i></div>
                                        </div>
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>
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

                                <div class="text-center" style="margin:15px 0px 0px 0px;">
                                    <input type="submit" value="Login" class="btn btn-info btn-block rounded-5 py-2">
                                </div>
                            </div>

                        </div>
                    </form>
        </div>
	</div>
</div>
<script>
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