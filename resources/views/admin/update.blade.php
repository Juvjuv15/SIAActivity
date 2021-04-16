@extends('layouts.layout')

@section('styles')

@stop

@section('body')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-lg-6 pb-5">  
                <form autocomplete="off" action="{{url('/updatelot/'.$lotRecord['lotId'].'/save')}}" method="post"> 
                {{csrf_field()}}
                        
                <div class="card border-info rounded-5">
                            <div class="card-header p-0">
                                <div class="bg-info text-white text-center py-2">
                                <a class="closebutton" href="{{url('/lotList')}}"><font size="5" color="white"><i class="fa fa-close"></i></font></a>
                                    <h1 style="margin: 20px 0px 20px 0px;">UPDATE PROPERTY INFORMATION</h1>
                                    
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <!--Body-->
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-bookmark text-info"></i></div>
                                        </div>
                                        <!-- <label for="lotNumber" class="col-md-4 col-form-label text-md-right">{{ __('Lot Number') }}</label> -->
                                        <input id="lotNumber" type="text" class="form-control" name="lotNumber" value="{{$lotRecord->lotNumber}}">                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-book text-info"></i></div>
                                        </div>
                                        <!-- <label for="lotTitleNumber" class="col-md-4 col-form-label text-md-right">{{ __('Title Number') }}</label> -->
                                        <input id="lotTitleNumber" type="text" class="form-control" name="lotTitleNumber" value="{{$lotRecord->lotTitleNumber}}">              
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-building text-info"></i></div>
                                        </div>
                                        <!-- <label for="lotAddress" class="col-md-5 col-form-label text-md-right">{{ __('Property Address') }}</label> -->
                                         <input id="lotAddress" type="text" class="form-control" name="lotAddress" value="{{$lotRecord->lotAddress}}">                            
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-user text-info"></i></div>
                                        </div>
                                        <!-- <label for="lotOwner" class="col-md-5 col-form-label text-md-right">{{ __('Property Owner') }}</label>                             -->
                                        <input id="lotOwner" type="text" class="form-control" name="lotOwner" value="{{$lotRecord->lotOwner}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-cubes text-info"></i></div>
                                        </div>
                                        <select id="lotCornerInfluence" class="form-control" name="lotCornerInfluence">
                                            @if($lotRecord->lotCornerInfluence == "yes" || $lotRecord->lotCornerInfluence == "YES")
                                                <option value="YES">YES</option>
                                                <option value="NO">NO</option>
                                            @else
                                                <option value="NO">NO</option>
                                                <option value="YES">YES</option>
                                            @endif
                                        </select>
                                
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-cube text-info"></i></div>
                                        </div>


                                       <!-- <label for="lotType" class="col-md-4 col-form-label text-md-right">{{ __('Land Type') }}</label>                             -->
                                        <select name="lotType" class="form-control">
                                        <option value="{{$lotRecord->lotType}}">{{$lotRecord->lotType}}</option>
                                        @foreach($lotType as $types)
                                        <option value="{{$types['lotType']}}">{{$types['lotType']}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-area-chart text-info"></i></div>
                                        </div>
                                        <!-- <label for="lotArea" class="col-md-3 col-form-label text-md-right">{{ __('Area') }}</label>                             -->
                                            <input id="lotArea" type="text" name="lotArea" class="form-control" value="{{$lotRecord->lotArea}}">
                                            <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-codepen text-info"></i></div>
                                            </div>
                                            <input id="unitOfMeasure" type="text" name="unitOfMeasure" class="form-control" value="{{$lotRecord->unitOfMeasure}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-money text-info"></i></div>
                                        </div>
                                        <!-- <label for="lotUnitValue" class="col-md-3 col-form-label text-md-right">{{ __('Value') }}</label> -->
                                        <input id="lotUnitValue" type="text" class="form-control" name="lotUnitValue" value="{{$lotRecord->lotUnitValue}}" required>
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-percent text-info"></i></div>
                                        </div>
                                        <!-- <label for="lotAdjustment" class="col-md-4 col-form-label text-md-right">{{ __('Adjustment') }}</label> -->
                                        <input id="lotAdjustment" type="text" class="form-control" name="lotAdjustment" value="{{$lotRecord->lotAdjustment}}" required>
                                        <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-stack-exchange text-info"></i></div>
                                        </div>
                                        <select id="mortgage" class="form-control" name="mortgage" required>
                                            @if($lotRecord->mortgage == "yes" || $lotRecord->mortgage == "YES")
                                            <option value="YES">YES</option>
                                            <option value="NO">NO</option>
                                            @else
                                            <option value="NO">NO</option>
                                            <option value="YES">YES</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" align="center"><b>PROPERTY BOUNDARIES</b></div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">NE</div>
                                        </div>
                                        <input id="lotNorthEastBoundary" type="text" class="form-control" name="lotNorthEastBoundary" value="{{$lotRecord->lotNEBoundary}}" placeholder="North East" required>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">NW</div>
                                        </div>
                                        <input id="lotNorthWestBoundary" type="text" class="form-control" name="lotNorthWestBoundary" value="{{$lotRecord->lotNWBoundary}}" placeholder="North West" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">SE</div>
                                        </div>
                                        <!-- <label for="lotSouthEastBoundary" class="col-md-4 col-form-label text-md-right">{{ __('South East') }}</label> -->
                                        <input id="lotSouthEastBoundary" type="text" class="form-control" name="lotSouthEastBoundary" value="{{$lotRecord->lotSEBoundary}}" required>
                                                                 <div class="input-group-prepend">
                                            <div class="input-group-text">SW</div>
                                        </div>
                                        <!-- <label for="lotSouthWestBoundary" class="col-md-4 col-form-label text-md-right">{{ __('South West') }}</label> -->
                                <input id="lotSouthWestBoundary" type="text" class="form-control" name="lotSouthWestBoundary" value="{{$lotRecord->lotSWBoundary}}" required>
                                                                </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">N</div>
                                        </div>
                                        <!-- <label for="lotNorthBoundary" class="col-md-3 col-form-label text-md-right">{{ __('North') }}</label> -->
                                <input id="lotNorthBoundary" type="text" class="form-control" name="lotNorthBoundary" value="{{$lotRecord->lotNBoundary}}" required>
                                                                   <div class="input-group-prepend">
                                            <div class="input-group-text">E</div>
                                        </div>
                                        <!-- <label for="lotEastBoundary" class="col-md-3 col-form-label text-md-right">{{ __('East') }}</label> -->
                                <input id="lotEastBoundary" type="text" class="form-control" name="lotEastBoundary" value="{{$lotRecord->lotEBoundary}}" required>
                                                              </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">S</div>
                                        </div>
                                        <!-- <label for="lotSouthBoundary" class="col-md-3 col-form-label text-md-right">{{ __('South') }}</label> -->
                                <input id="lotSouthBoundary" type="text" class="form-control" name="lotSouthBoundary" value="{{$lotRecord->lotSBoundary}}" required>
                                                                  <div class="input-group-prepend">
                                            <div class="input-group-text">W</div>
                                        </div>
                                        <!-- <label for="lotWestBoundary" class="col-md-3 col-form-label text-md-right">{{ __('West') }}</label> -->
                                <input id="lotWestBoundary" type="text" class="form-control" name="lotWestBoundary" value="{{$lotRecord->lotWBoundary}}" required>
                                                          </div>
                                </div>
                            <div class="text-center" style="margin:5px 15px 0px 15px;">
                                <input type="submit" value="UPDATE" class="btn btn-info btn-block rounded-5 py-2">
                            </div>
                            <br/>
                        </div>

                    </form>
               
        </div>
    </div>
</div>
@endsection
