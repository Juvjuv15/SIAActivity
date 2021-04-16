<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <!-- or css styles fa fa icons -->
   <link rel="stylesheet" href="/w3css/3/w3.css">  
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">

  <title>Index</title>
<style>
.body{
  background-color:#63c8c9;
}
.footer {
  padding: 10px 16px;
  /* background: #f97484; */
  /* background: #07889b; */
  /* background: #66a5ad; */
  /* position:fixed; */
  width:100%;
  background: black;
  color: #f1f1f1;
  padding-bottom: 10px;
}
.button{
    font-family: arial,bold;
    font-size: 999px;
    font-weight: 999;
    color: white;
    width: 300px;
    box-sizing: border-box;
    border: 2px solid #63c8c9;
    border-radius:50px;
    font-size: 16px;
    background-color: black;
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 40px 30px 40px 20px;
    display: right;
    text-align: center;
    /* margin: 10px 0; */
}
.button:hover{
    background: #9ecdd5;
}
</style>

</head>
<body class="body">
<div align="center">
<img  src="{{ asset('images/logo1.png') }}" height="400" width="550">
</div>
<br>
<div align="center">
<input type="button" onclick='location.href="{{ route('login') }}"'  class="button" value="SIGN IN">&nbsp;&nbsp;
<input type="button" onclick='location.href="{{ route('register') }}"'  class="button" value="CREATE AN ACCOUNT">

</div>
<br><br><br>
<div class="footer">
<footer class="w3-container w3-padding-64 w3-center w3-black w3-xlarge" align="center">
<br>
  <a href="#"><i class="fa fa-facebook-official"></i></a>
  <a href="#"><i class="fa fa-pinterest-p"></i></a>
  <a href="#"><i class="fa fa-twitter"></i></a>
  <a href="#"><i class="fa fa-flickr"></i></a>
  <a href="#"><i class="fa fa-linkedin"></i></a>
  <br>
  <p class="w3-medium">
  All rights reserved 2018 <a href="https://www.instantPlot.com" target="_blank">instantPlot.com</a>
  </p>
</footer>
</div>

</body>
</html>
