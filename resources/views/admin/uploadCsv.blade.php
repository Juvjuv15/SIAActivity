@extends('header')

@section('styles') 
#upload {
  background-color: white;
  margin: 50px auto;
  border-radius: 10px;
  font-family: arial,bold;
  padding: 40px;
  width: 70%;
  min-width: 300px;
}

@stop

@section('body')
<br>
<br>
<br>
<form id="upload" action="{{url('/uploadCsv')}}" method="post" enctype="multipart/form-data">
{{csrf_field()}}
<div class="form-group" align="center">
<label for="upload-file"><h2><b>Upload LOT CSV File</b></h2></label>
<br>
<input type="file" name="upload-file">
<br><br>
<input class="btn btn-success" type="submit" value="Upload" name="submit">&nbsp;  <a href="/adminLanding">Cancel</a>

</div>
</form>
<br>
<br>


@stop