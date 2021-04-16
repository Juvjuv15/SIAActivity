@extends('layouts.layout')

@section('styles')

@stop

@section('body')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-12 col-lg-10 col-lg-6 pb-5">
                    <form autocomplete="off" action="{{url('/lot/newLot')}}" method="post">
                    @csrf
                        <div class="card border-info rounded-5">
                            <div class="card-header p-0">
                                <div class="bg-info text-white text-center py-2">
                                <a class="closebutton" href="{{url('/adminLanding')}}"><font size="5" color="white"><i class="fa fa-close"></i></font></a>
                                    <h1 style="margin: 20px 0px 20px 0px;">PROPERTY INFORMATION</h1>
                                    
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <!--Body-->
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-bookmark text-info"></i></div>
                                        </div>
                                        <input id="lotNumber" type="text" class="form-control" name="lotNumber" value="{{old('lotNumber')}}" placeholder="Lot Number" required>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-book text-info"></i></div>
                                        </div>
                                        <input id="lotTitleNumber" type="text" class="form-control" name="lotTitleNumber" value="{{ old('lotTitleNumber') }}" placeholder="Title Number" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-building text-info"></i></div>
                                        </div>
                                        <input id="lotAddress" type="text" class="form-control" name="lotAddress" value="{{old('lotAddress')}}" placeholder="Property Address" required>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-user text-info"></i></div>
                                        </div>
                                        <input id="lotOwner" type="text" class="form-control" name="lotOwner" value="{{ old('lotOwner') }}" placeholder="Property Owner" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-cubes text-info"></i></div>
                                        </div>
                                        <select id="lotCornerInfluence" class="form-control" name="lotCornerInfluence" required>
                                            <option value="">Lot Corner Influence</option>
                                            <option value="YES">YES</option>
                                            <option value="NO">NO</option>
                                        </select>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-cube text-info"></i></div>
                                        </div>
                                        <select id="lotType" class="form-control" name="lotType" required>
                                            <option value="">Lot Type</option>
                                            <option value="Agricultural Lot">Agricultural Lot</option>
                                            <option value="Commercial Lot">Commercial Lot</option>
                                            <option value="Residential Lot">Residential Lot</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-area-chart text-info"></i></div>
                                        </div>
                                        <input id="lotArea" type="text" class="form-control" name="lotArea" value="{{old('lotArea')}}" placeholder="Area" required>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-codepen text-info"></i></div>
                                        </div>
                                        <select id="unitOfMeasure" class="form-control" name="unitOfMeasure" required>
                                            <option value="">Unit of Measure</option>
                                            <option value="sqm">sqm</option>
                                            <option value="hectare">hectare</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-money text-info"></i></div>
                                        </div>
                                        <input id="lotUnitValue" type="text" class="form-control" name="lotUnitValue" value="{{ old('lotUnitValue') }}" placeholder="Value per Unit" required>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-percent text-info"></i></div>
                                        </div>
                                        <input id="lotAdjustment" type="text" class="form-control" name="lotAdjustment" value="{{ old('lotAdjustment') }}" placeholder="Lot Adjustment" required>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-stack-exchange text-info"></i></div>
                                        </div>
                                        <select id="mortgage" class="form-control" name="mortgage" required>
                                            <option value="">Mortgage Status</option>
                                            <option value="YES">YES</option>
                                            <option value="NO">NO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" align="center"><b>PROPERTY BOUNDARIES</b></div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-map-pin text-info"></i></div>
                                        </div>
                                        <input id="lotNorthEastBoundary" type="text" class="form-control" name="lotNorthEastBoundary" value="{{old('lotNorthEastBoundary')}}" placeholder="North East" required>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-map-pin text-info"></i></div>
                                        </div>
                                        <input id="lotNorthWestBoundary" type="text" class="form-control" name="lotNorthWestBoundary" value="{{ old('lotNorthWestBoundary') }}" placeholder="North West" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-map-pin text-info"></i></div>
                                        </div>
                                        <input id="lotSouthEastBoundary" type="text" class="form-control" name="lotSouthEastBoundary" value="{{old('lotSouthEastBoundary')}}" placeholder="South East" required>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-map-pin text-info"></i></div>
                                        </div>
                                        <input id="lotSouthWestBoundary" type="text" class="form-control" name="lotSouthWestBoundary" value="{{ old('lotSouthWestBoundary') }}" placeholder="South West" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-map-pin text-info"></i></div>
                                        </div>
                                        <input id="lotNorthBoundary" type="text" class="form-control" name="lotNorthBoundary" value="{{old('lotNorthBoundary')}}" placeholder="North" required>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-map-pin text-info"></i></div>
                                        </div>
                                        <input id="lotEastBoundary" type="text" class="form-control" name="lotEastBoundary" value="{{ old('lotEastBoundary') }}" placeholder="East" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-map-pin text-info"></i></div>
                                        </div>
                                        <input id="lotSouthBoundary" type="text" class="form-control" name="lotSouthBoundary" value="{{old('lotSouthBoundary')}}" placeholder="South" required>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-map-pin text-info"></i></div>
                                        </div>
                                        <input id="lotWestBoundary" type="text" class="form-control" name="lotWestBoundary" value="{{ old('lotWestBoundary') }}" placeholder="West" required>
                                    </div>
                                </div>
                                </div> <!--end body div -->
                                
                                <div class="text-center" style="margin:5px 15px 0px 15px;">
                                <input type="submit" value="SAVE" class="btn btn-info btn-block rounded-5 py-2">
                                </div>
                                <br/>
                            </div>

                        </div>
                    </form>
        </div>
	</div>
</div>

@endsection