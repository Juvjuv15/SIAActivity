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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto Condensed">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merienda">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Abel">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

<style>
body{
    font-family: "Roboto Condensed", sans-serif;
    background-color:#72cdd8;
    /* background-image: url("/images/lot1.jpg"); */
    /* background-position: 10px 10px;   */
    background-repeat: no-repeat;
    }
.footer {
  font-family: "Roboto Condensed", sans-serif;
  padding: 10px 16px;
  background: #2f4454;
  color: #f1f1f1;
  padding-bottom: 50px;
}
.button{
    font-family: "Roboto Condensed", sans-serif;
    font-size: 100px;
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

.card-header{
    background: #72cdd8;
}
</style>



<body>
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div align="center" class="card-header">
                <a href="{{url('/instantplot.com')}}" class="text"><img  src="{{ asset('images/logo1.png') }}" height="200" width="275"></a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

    <!-- <div class="form-group row">
         <label for="state" class="col-md-4 col-form-label text-md-right">{{ __('Register as') }}<font size="4" color="red"><b>*</b></font></label>
         <div class="col-md-6">
            <select id="state" name="state" class="form-control">
            <option value="">Select one</option>
            <option value="private">Personal User</option>
            <option value="company">Company User</option>           
        </select>
        </div>
    </div> -->
    <center><font size="2"><b>Fields marked with </b></font><font size="4" color="red"><b>*</b></font><font size="2"><b> are fillable informations.</b></font></center><br>
    

                        
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Firstname') }} <font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lname" class="col-md-4 col-form-label text-md-right">{{ __('Lastname') }} <font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                                <input id="lname" type="text" class="form-control" name="lname" value="{{ old('lname') }}">
                            </div>
                        </div>

                 

                        <div class="form-group row">
                            <label for="contact" class="col-md-4 col-form-label text-md-right">{{ __('Primary Contact Number') }}<font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                                <input id="contact" type="text" class="form-control{{ $errors->has('contact') ? ' is-invalid' : '' }}" name="contact" value="{{ old('contact') }}" required>

                                @if ($errors->has('contact'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contact') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="secondarycontact" class="col-md-4 col-form-label text-md-right">{{ __('Secondary Contact Number') }}</label>

                            <div class="col-md-6">
                            <input id="secondarycontact" type="text" class="form-control{{ $errors->has('secondarycontact') ? ' is-invalid' : '' }}" name="secondarycontact" value="{{ old('secondarycontact') }}">

                                @if ($errors->has('secondarycontact'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('secondarycontact') }}</strong>
                                    </span>
                                @endif


                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}<font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}<font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}<font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="must be 6 characters long" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}<font size="4" color="red"><b>*</b></font></label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <input id="userType" type="hidden" class="form-control" name="userType" value="0">

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4" align="center">
                                <button type="submit" class="button">
                                    {{ __('Sign up') }}
                                </button>
                                <a class="text" href="{{ route('instantplot.com') }}"><font size="2">Cancel registration</font></a>
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
<div class="footer">
<footer class="w3-container w3-padding-64 w3-center w3-black w3-xlarge" align="center">
  <br>
  <a href="#"><i class="fa fa-facebook-official" style="color:white"> </i></a>
  <a href="#"><i class="fa fa-pinterest-p" style="color:white"> </i></a>
  <a href="#"><i class="fa fa-twitter" style="color:white"> </i></a>
  <a href="#"><i class="fa fa-flickr" style="color:white"> </i></a>
  <a href="#"><i class="fa fa-linkedin" style="color:white"></i></a>
  <br>
  <p class="w3-medium">
  All rights reserved 2018 <a href="https://www.instantPlot.com" style="color:white">instantPlot.com</a>
  </p>
</footer>
</div>
</body>


</html>
