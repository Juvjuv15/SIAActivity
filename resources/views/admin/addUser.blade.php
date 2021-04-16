@extends('layouts.layout')
@section('styles')

@stop

@section('body')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-12 col-lg-10 col-lg-6 pb-5">
        <form method="POST" autocomplete="off" action="{{ route('saveUser') }}">
                    @csrf
                        <div class="card border-info rounded-5">
                            <div class="card-header p-0">
                                <div class="bg-info text-white text-center py-2">
                                    
                                    <h2 style="margin: 20px 0px 20px 0px;">ADD CITY ASSESSOR ADMIN</h2>
                                    
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <!--Body-->
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-user text-info"></i></div>
                                        </div>
                                        <select id="city" class="form-control" name="city" required>
                                                <option value="">Assigned Office</option>
                                                <option value="Alcantara">Alcantara</option>
                                                <option value="Alcoy">Alcoy</option>
                                                <option value="Alegria">Alegria</option>
                                                <option value="Aloguinssan"> Aloguinssan</option>
                                                <option value="Argao">Argao</option>
                                                <option value="Asturias">Asturias</option>
                                                <option value="Badian">Badian</option>
                                                <option value="Balamban"> Balamban</option>
                                                <option value="Bantayan">Bantayan</option>
                                                <option value="Bogo City">Bogo City</option>
                                                <option value="Boljoon">Boljoon</option>
                                                <option value="Borbon">Borbon</option>
                                                <option value="Carcar City">Carcar City</option>
                                                <option value="Carmen">Carmen</option>
                                                <option value="Catmon">Catmon</option>
                                                <option value="Cebu City">Cebu City</option>
                                                <option value="Compostela">Compostela</option>
                                                <option value="Consolacion">Consolacion</option>
                                                <option value="Cordova">Cordova</option>
                                                <option value="Daanbantayan">Daanbantayan</option>
                                                <option value="Dalaguete">Dalaguete</option>
                                                <option value="Danao">Danao City</option>
                                                <option value="Dumanjug">Dumanjug</option>
                                                <option value="Ginatilan">Ginatilan</option>
                                                <option value="Lapu-lapu City">Lapu-lapu City</option>
                                                <option value="Liloan">Liloan</option>
                                                <option value="Madridejos">Madridejos</option>
                                                <option value="Malabuyoc">Malabuyoc</option>
                                                <option value="Mandaue City">Mandaue City</option>
                                                <option value="Medilin">Medilin</option>
                                                <option value="Minglanilla">Minglanilla</option>
                                                <option value="Moalboal">Moalboal</option>
                                                <option value="Naga City">Naga City</option>
                                                <option value="Pilar">Pilar</option>
                                                <option value="Pinamungahan">Pinamungahan</option>
                                                <option value="Poro">Poro</option>
                                                <option value="Ronda">Ronda</option>
                                                <option value="Samboan">Samboan</option>
                                                <option value="San Fernando">San Fernando</option>
                                                <option value="San Francisco">San Francisco</option>
                                                <option value="San Remigio">San Remigio</option>
                                                <option value="">Santa Fe</option>
                                                <option value="Santander">Santander</option>
                                                <option value=Sibonga"">Sibonga</option>
                                                <option value="Sogod">Sogod</option>
                                                <option value="Tabogon">Tabogon</option>
                                                <option value="Tabuelan">Tabuelan</option>
                                                <option value="Talisay City">Talisay City</option>
                                                <option value="Toledo City">Toledo City</option>
                                                <option value="Tuburan">Tuburan</option>
                                                <option value="Tudela">Tudela</option>
                                        </select>                                    
                                        </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-user text-info"></i></div>
                                        </div>
                                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Name" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-user text-info"></i></div>
                                        </div>
                                        <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Username" required>
                                    </div>
                                </div>
                            
                                <!-- <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-envelope text-info"></i></div>
                                        </div>
                                        <input id="" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email Address" required>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <div class="input-group mb-2 show-password">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-key text-info"></i></div>
                                        </div>
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password (minimum of 6 characters long)" required>

                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <input id="address" type="hidden" class="form-control" name="address" value="null">
                                <input id="userType" type="hidden" class="form-control" name="userType" value="1">
                                <input id="userStatus" type="hidden" class="form-control" name="userStatus" value="0">
                                <input id="contact" type="hidden" class="form-control" name="contact" value="null" placeholder="Primary Contact Number" required>
                                <input id="secondarycontact" type="hidden" class="form-control" name="secondarycontact" value="null" placeholder="Secondary Contact Number (optional)">

                                <div class="text-center" style="margin:5px 15px 0px 15px;">
                                <input type="submit" value="ADD" class="btn btn-info btn-block rounded-5 py-2">
                                <a class="text" href="{{ route('adminLanding') }}" style="padding:3px 15px 3px 15px"><font size="2">CANCEL</font></a>
                                </div>
                                
                            </div>

                        </div>
                    </form>
        </div>
	</div>
</div>

@endsection