@extends('layouts.layout')

@section('styles')
@stop

@section('body')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-lg-6 pb-5">  
                <div class="card border-info rounded-5">
                            <div class="card-header p-0">
                                <div class="bg-info text-white text-center py-2">
                                <a class="closebutton" href="http://localhost:8000/lotList"><font size="5" color="white"><i class="fa fa-close"></i></font></a>
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
                                        <span id="lotNumber" class="form-control" name="lotNumber">{{$lotDetails['lotNumber']}} (lot number)</span>
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-book text-info"></i></div>
                                        </div>
                                        <span id="lotTitleNumber" class="form-control" name="lotTitleNumber">{{$lotDetails['lotTitleNumber']}} (title number)</span>
                                        </div>                
                                    </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-building text-info"></i></div>
                                        </div>
                                        <span id="lotAddress" class="form-control" name="lotAddress">{{$lotDetails['lotAddress']}}</span>                           
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-user text-info"></i></div>
                                        </div>
                                        <span id="lotOwner" class="form-control" name="lotOwner">{{$lotDetails['lotOwner']}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-cubes text-info"></i></div>
                                        </div>
                                        <span id="lotCornerInfluence" class="form-control" name="lotCornerInfluence">{{$lotDetails['lotCornerInfluence']}} (corner influence)</span>
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-cube text-info"></i></div>
                                        </div>
                                        <span id="lotType" class="form-control" name="lotType">{{$lotDetails['lotType']}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-area-chart text-info"></i></div>
                                        </div>
                                        <span id="lotArea" class="form-control" name="lotArea">{{$lotDetails['lotArea']}} (area)</span>    
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-codepen text-info"></i></div>
                                        </div>
                                        <span id="unitOfMeasure" class="form-control" name="unitOfMeasure">{{$lotDetails['unitOfMeasure']}}</span>                   
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-money text-info"></i></div>
                                        </div>
                                        <span id="lotUnitValue" class="form-control" name="lotUnitValue">P{{$lotDetails['lotUnitValue']}} (property unit value)</span>                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-percent text-info"></i></div>
                                        </div>
                                        <span id="lotAdjustment" class="form-control" name="lotAdjustment">{{$lotDetails['lotAdjustment']}}% (adjustment)</span>                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-stack-exchange text-info"></i></div>
                                        </div>
                                        <span id="mortgage" class="form-control" name="mortgage">{{$lotDetails['mortgage']}} (mortgage)</span>
                                    </div>
                                </div>
                                <div class="form-group" align="center"><b>PROPERTY BOUNDARIES</b></div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-map-pin text-info"></i></div>
                                        </div>
                                        <span id="lotNorthEastBoundary" class="form-control" name="lotNorthEastBoundary">{{$lotDetails['lotNEBoundary']}} (North East Boundary)</span>                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-map-pin text-info"></i></div>
                                        </div>
                                        <span id="lotNorthWestBoundary" class="form-control" name="lotNorthWestBoundary">{{$lotDetails['lotNWBoundary']}} (North West Boundary)</span>                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-map-pin text-info"></i></div>
                                        </div>
                                        <span id="lotSouthEastBoundary" class="form-control" name="lotSouthEastBoundary">{{$lotDetails['lotSEBoundary']}} (South East Boundary)</span>                                                                 <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-map-pin text-info"></i></div>
                                        </div>
                                        <span id="lotSouthWestBoundary" class="form-control" name="lotSouthWestBoundary">{{$lotDetails['lotSWBoundary']}} (South West Boundary)</span>                                                                </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-map-pin text-info"></i></div>
                                        </div>
                                        <span id="lotNorthBoundary" class="form-control" name="lotNorthBoundary">{{$lotDetails['lotNBoundary']}} (North Boundary)</span>                                                                   <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-map-pin text-info"></i></div>
                                        </div>
                                        <span id="lotEastBoundary" class="form-control" name="lotEastBoundary">{{$lotDetails['lotEBoundary']}} (East Boundary)</span>                                                              </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-map-pin text-info"></i></div>
                                        </div>
                                        <span id="lotSouthBoundary" class="form-control" name="lotSouthBoundary">{{$lotDetails['lotSBoundary']}} (South Boundary)</span>                    <div class="input-group-prepend">                      <div class="input-group-text"><i class="fa fa-map-pin text-info"></i></div>
                                        </div>
                                        <span id="lotWestBoundary" class="form-control" name="lotWestBoundary">{{$lotDetails['lotWBoundary']}} (West Boundary)</span>                                                          </div>
                                </div>
                                <div class="form-group row mb-0">
                            <div class="col-md-4 offset-md-4" align="center">
                            </div>

                        </div>
                        </div>
                        </div>


        </div>
    </div>
</div>
<br>
<br>
@endsection
