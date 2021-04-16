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
    margin-top:30px;
}
</style>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-12 col-md-8 col-lg-6 pb-5">

                <form autocomplete="off" action="{{url('/changeProfile/'.$user['id'].'/save')}}" method="post" enctype="multipart/form-data"> 
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
                                        <input id="name" type="text" class="form-control" name="name" value="{{$profile->name}}" required>
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-user text-info"></i></div>
                                        </div>
                                        <input id="lname" type="text" class="form-control" name="lname" value="{{$profile->lname}}" required>
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-phone text-info"></i></div>
                                        </div>
                                        <input id="contact" type="text" class="form-control{{ $errors->has('contact') ? ' is-invalid' : '' }}" name="contact" value="{{$profile->contact}}" required>

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
                                        <input id="secondarycontact" type="text" class="form-control{{ $errors->has('secondarycontact') ? ' is-invalid' : '' }}" name="secondarycontact" value="{{$profile->secondarycontact}}" placeholder="Secondary Contact Number (optional)">

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
                                        <input id="address" type="text" class="form-control" name="address" value="{{$profile->address}}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-envelope text-info"></i></div>
                                        </div>
                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{$profile->email}}"  required>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group" style="vertical-lign:center;">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"> 
                                                @if($profile->fileExt == null)
                                                    <img id="preview" src="{{ asset('images/avatar3.png') }}" height="60" width="60" />
                                                @else
                                                    <img id="preview" src="{{ $profile->fileExt }}" height="60" width="60" />
                                                @endif
                                            </div>
                                        </div>
                                       
                                        <input id="picture" type="file" class="form-control" name="picture" accept="image/*" onchange="readURL(this);">
                                    </div>
                                </div>
                                </div>
                                <!-- <input id="userType" type="hidden" class="form-control" name="userType" value="0"> -->
                                <div class="text-center" style="margin:5px 15px 0px 15px;">
                                <input type="submit" value="SAVE" class="btn btn-info btn-block rounded-5 py-2">
                                
                                @if($profile->userType == "0")
                                <a class="text" href="{{url('/myprofile')}}" style="padding:3px 15px 3px 15px"><font size="2">Cancel Update</font></a>
                                @else
                                <a class="text" href="{{url('/adminLanding')}}" style="padding:3px 15px 3px 15px"><font size="2">Cancel Update</font></a>
                                @endif
                                </div>                              
                            </div>

                        </div>
                    </form>
        </div>
	</div>
</div>
</body>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview')
                    .attr('src', e.target.result)
                    .width(60)
                    .height(60);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
</html>