<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- or css styles fa fa icons -->
    <!-- <link rel="stylesheet" href="/w3css/3/w3.css">   -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
  <!-- CSRF Token -used para d ma hack or makuha ang data na gipang input sa user sa iyang mga transactions with the site-->
     <meta name="csrf-token" content="{{ csrf_token() }}">
      
    <title>Instant Plot</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">

    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

<style>
#close{
    float:right;
}
.text img{
    height:400px;
    width:40%;
}

body{
    /* background-color:#2f4454; */
    background-image:url('/images/bg5.jpg');
    background-size:100%;
    background-repeat:no-repeat;
    transition: 1.0s;

    }

body:hover{
    background-image:url('/images/bg6.jpg');
    background-size:100%;
    background-repeat:no-repeat;
    transition: 1.0s;

}

h3{
    color:white;
}
.appname{
    color:white;
    font-size:60%;
}
.text:hover{
    text-decoration:none;
}
.button{
    font-family: arial,bold;
    font-size: 100%;
    font-weight: 500;
    color: white;
    width: 40%;
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
.leftcolumn {   
    float: left;
    width: 69%;
}

.rightcolumn {
    float: right;
    width: 31%;
    padding-right: 30px;
}


.begin {
     background-color: white;
     padding: 20px;
     width: 100%;
     border:2px;
     border-radius:5px;
     /* background-color:white; */
     background-color:#cdf2f2;
     margin-top: 50px;
     margin-bottom: 20px;
     
}

.beginleft {
     padding: 20px;
     width: 96%;
     /* background-color:#2f4454; */
     /* margin: 20px; */
}
.start:after {
    content: "";
    display: table;
    clear: both;
}

.joinUs{
    animation-name:flashing;
    animation-duration:1s;
    animation-timing-function:linear;
    animation-iteration-count:infinite;

}

@keyframes flashing{
    0%{
        opacity:1.0;
    }
    25%{
        opacity:0.6;
    }
    50%{
        opacity:0.3;
    }
    75%{
        opacity:0.6;
    }
    100%{
        opacity:1.0;
    }
}



/* @media screen and (max-width: 800px) {
    .leftcolumn, .rightcolumn {   
        width: 100%;
        padding: 0;
    }
    
} */
</style>
<body>
<div class="adminlanding">

<div class="start">

  <div class="leftcolumn">
    <div class="beginleft">
    <div align=center>
    <br>
    <a href="{{url('/instantplot.com')}}" class="text"><img  src="{{ asset('images/logo1.png') }}" height="" width=""></a>
    <!-- <div class=appname>
    Instant Plot
    </div> -->
    <br><br><br>
    <h3>
    InstantPlot is not a salesperson. It is a match-maker. It introduce people to lands, until they fall in love with one.
    <br>
    <br>
    </h3>
    <!-- <h3>
    “As the online world flourish it becomes the market place of property listings, but it also becomes the breeding place of property swindlers or scammers. InstantPlot is an online hub that focuses on lot property listings. Property listed on InstantPlot are verified through a reliable data source before it is posted. With InstantPlot rest assured that the money you invest is safe and secure.”
    </h3> -->
    </div>
    </div>
  </div>

  <div class="rightcolumn">
    <div class="begin">
    <br>
    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-sm-5 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-7">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-5 col-form-label text-md-right">{{ __('Password') }}</label>
                            <div class="col-md-7">
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
                                     <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                                    </label>
                                </div>
                                </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">

                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                    <a class="text" href="{{ route('register') }}"><font size="2">Forgot your password?</font>
                                    </a>
                                
                            </div>
                        </div>
                        <br>
                        <div class="form-group row mb-0">
                            <div class="col-md-7 offset-md-6" >
                                <button type="submit" class="button">
                                Log in
                                </button>
                                <br>
                            </div>
                        </div> 
                        <br><br>
                        <center>
                        <font size="2">Buy or Sell a lot property with us </font><a class="joinUs" href="{{ route('register') }}"><font size="2">Join us</font></a>
                        <center>
                        <br> 
                    </form>



            </div>
    
  </div>
  </div>
  
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


</script>
</body>
</html>