<!DOCTYPE html>
<html lang=en>
<head>
<meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{asset('/css/app.css') }}">
<meta http-equiv="X-UA-Compatible" content="ie-edge">

</head>

<body>
<form action={{route('adminlogin')}} method="post">
 {{csrf_field()}} 
<table>

<tr>
    <td colspan="2">Member Login</td>
</tr>
<tr>
    <td colspan="2">Username</td>
    <td><input type="text" name="username"></td> 
</tr>

<tr>
    <td colspan="2">Password</td>
    <td><input type="text" name="password"></td> 
</tr>

<tr>
<td colspan="2">
<button type="submit" class="btn btn-primary">Login</button>
<button type="reset" class="btn btn-primary">Reset</button>
</td>
</tr>

</table>

</form>




</body>


</html>
