@extends('quicarbd.admin.layout.admin')
@section('title','Car Package')
@section('content')
<div class="container-fluid">               
    <!-- Title -->
    <div class="row heading-bg">
        <div class="col-md-md-lg-3 col-md-4 col-sm-4 col-xs-12">
        </div>
        <!-- Breadcrumb -->
        <div class="col-md-md-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Package</a></li>
            <li class="active"><span>Car Package Details</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
    <!-- /Title -->    
    <!-- Row -->
    <div class="row">
        <div class="col-md-md-sm-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="txt-dark capitalize-font"><i class="fa fa-car mr-10"></i>Car Package Info</h6> 
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-md-sm-12 col-xs-12">
                                <div class="form-wrap">
                                    <div class="form-body">     
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="name" class="control-label mb-10">Package Name <span class="text-danger" title="Required">*</span></label>
                                                    <input type="text" id="name" name="name" value="{{ $car_package->name }}" class="form-control" placeholder="Package Name" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="owner_id" class="control-label mb-10">Partner <span class="text-danger" title="Required">*</span></label>                                            
                                                    <input type="text" value="{{ $partner }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="car_id" class="control-label mb-10">Select Car <span class="text-danger" title="Required">*</span></label>                                            
                                                    <select class="form-control" name="car_id" id="car_id" readonly> 
                                                        @foreach($cars as $car)
                                                            <option value="{{ $car->id }}" @if($car_package->car_id == $car->id) selected @endif>{{ $car->carRegisterNumber }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('car_id'))
                                                        <span class="text-danger"> {{ $errors->first('car_id') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-3">                                        
                                                <div class="form-group">
                                                    <label for="quicar_charge" class="control-label mb-10"> Quicar Charge <span class="text-danger" title="Required">*</span></label>
                                                    <input type="text" id="quicar_charge" name="quicar_charge" value="{{ $car_package->quicar_charge }}" class="form-control" placeholder="Quicar Charge" readonly required>
                                                    <input type="hidden" id="quicar_charge_percent" value="{{ $charge }}">
                                                    @if($errors->has('quicar_charge'))
                                                        <span class="text-danger"> {{ $errors->first('quicar_charge') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">                                        
                                                <div class="form-group">
                                                    <label for="details" class="control-label mb-10"> Details <span class="text-danger" title="Required">*</span></label>                                            
                                                    <textarea class="form-control" id="details" name="details" placeholder="Details" rows="3" readonly>{{ $car_package->details }}</textarea>
                                                    @if($errors->has('details'))
                                                        <span class="text-danger"> {{ $errors->first('details') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">                                        
                                                <div class="form-group">
                                                    <label for="facilities" class="control-label mb-10"> Factilites <span class="text-danger" title="Required">*</span></label>                                            
                                                    <textarea class="form-control" id="facilities" name="facilities" placeholder="Facilites" rows="3" readonly>{{ $car_package->facilities }}</textarea>
                                                    @if($errors->has('facilities'))
                                                        <span class="text-danger"> {{ $errors->first('facilities') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="district_id" class="control-label mb-10">Select Tour District <span class="text-danger" title="Required">*</span></label>
                                                    <input type="text" class="form-control selectable" value="{{ $district }}" required readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label for="spot_id" class="control-label mb-10">Select Tour Spot <span class="text-danger" title="Required">*</span></label>                                            
                                                    <select id="spot_id" name="spot_id[]" class="form-control" multiple required  readonly>                                                
                                                        @foreach($spots as $spot)
                                                            <option value="{{ $spot->id }}"  @if(in_array($spot->id, json_decode($car_package->spot_id))) selected @endif>{{ $spot->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('spot_id'))
                                                        <span class="text-danger"> {{ $errors->first('spot_id') }}</span>
                                                    @endif
                                                </div>
                                            </div>                                                
                                            <div class="col-md-2">                                        
                                                <div class="form-group">
                                                    <label for="duration" class="control-label mb-10"> Duration(day) <span class="text-danger" title="Required">*</span></label>
                                                    <input type="text" id="duration" name="duration" value="{{ $car_package->duration }}" class="form-control" placeholder="Duration" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  readonly>
                                                    @if($errors->has('duration'))
                                                        <span class="text-danger"> {{ $errors->first('duration') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-2">                                        
                                                <div class="form-group">
                                                    <label for="starting_location" class="control-label mb-10"> Starting Location <span class="text-danger" title="Required">*</span></label>                                                        
                                                    <input type="text" value="{{ $starting_location }}" name="starting_location" class="form-control selectable" required  readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-2">                                        
                                                <div class="form-group">
                                                    <label for="starting_city_id" class="control-label mb-10"> Starting City <span class="text-danger" title="Required">*</span></label>                                        
                                                    <input type="text" value="{{ $starting_city }}" name="starting_location" class="form-control selectable" required  readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">                                        
                                                <div class="form-group">
                                                    <label for="starting_location_address" class="control-label mb-10"> Starting Location Address <span class="text-danger" title="Required">*</span></label>
                                                    <input type="text" id="starting_location_address" name="starting_location_address" value="{{ $car_package->starting_location_address }}" class="form-control" placeholder="Starting Location Address" required readonly>
                                                    @if($errors->has('starting_location_address'))
                                                        <span class="text-danger"> {{ $errors->first('starting_location_address') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-2">                                        
                                                <div class="form-group">
                                                    <label for="total_person" class="control-label mb-10"> Total Person <span class="text-danger" title="Required">*</span></label>
                                                    <input type="text" id="total_person" name="total_person" value="{{ $car_package->total_person }}" class="form-control" placeholder="Total Person" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required readonly>
                                                    @if($errors->has('total_person'))
                                                        <span class="text-danger"> {{ $errors->first('total_person') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-3">                                        
                                                <div class="form-group">
                                                    <label for="price" class="control-label mb-10"> Price <span class="text-danger" title="Required">*</span></label>
                                                    <input type="text" id="price" name="price" value="{{ $car_package->price }}" class="form-control" oninput="calculateCharge()" placeholder="Price" required readonly>
                                                    @if($errors->has('price'))
                                                        <span class="text-danger"> {{ $errors->first('price') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="owner_get" class="control-label mb-10">Owner Get <span class="text-danger" title="Required">*</span></label>
                                                    <input type="text" id="owner_get" name="owner_get" value="{{ $car_package->owner_get }}" class="form-control" placeholder="Owner Get" readonly required>
                                                    @if($errors->has('owner_get'))
                                                        <span class="text-danger"> {{ $errors->first('owner_get') }}</span>
                                                    @endif
                                                </div>
                                            </div>       
                                            <div class="col-md-3">                                        
                                                <div class="form-group">
                                                    <label for="cash_back_price" class="control-label mb-10">Cash Back Price </label>
                                                    <input type="text" id="cash_back_price" name="cash_back_price" value="{{ $car_package->cash_back_price }}" class="form-control" placeholder="Cash Back Price" readonly oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                                    @if($errors->has('cash_back_price'))
                                                        <span class="text-danger"> {{ $errors->first('cash_back_price') }}</span>
                                                    @endif
                                                </div>
                                            </div>                                         
                                            <div class="col-md-3">                                        
                                                <div class="form-group">
                                                    <label for="cash_back_status" class="control-label mb-10">Cash Back Status </label>
                                                    <select id="cash_back_status" name="cash_back_status" class="form-control" readonly>
                                                        <option selected disabled>Select</option>
                                                        <option value="0" @if( $car_package->cash_back_status == 0) selected @endif>Pause</option>
                                                        <option value="1" @if( $car_package->cash_back_status == 1) selected @endif>Active</option>
                                                    </select>
                                                    @if($errors->has('cash_back_status'))
                                                        <span class="text-danger"> {{ $errors->first('cash_back_status') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-3">                                        
                                                <div class="form-group">
                                                    <label for="cash_back_staring_time" class="control-label mb-10">Cash Back Start Time </label>
                                                    <input type="datetime-local" id="cash_back_staring_time" name="cash_back_staring_time" @if($car_package->cash_back_staring_time != null) value="{{ date('Y-m-d\TH:i:s', strtotime($car_package->cash_back_staring_time)) }}" @endif class="form-control" readonly>
                                                    @if($errors->has('cash_back_staring_time'))
                                                        <span class="text-danger"> {{ $errors->first('cash_back_staring_time') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-3">                                        
                                                <div class="form-group">
                                                    <label for="cash_back_ending_time" class="control-label mb-10">Cash Back End Time </label>
                                                    <input type="datetime-local" id="cash_back_ending_time" name="cash_back_ending_time" @if($car_package->cash_back_ending_time != null) value="{{ date('Y-m-d\TH:i:s', strtotime($car_package->cash_back_ending_time)) }}" @endif class="form-control" readonly>
                                                    @if($errors->has('cash_back_ending_time'))
                                                        <span class="text-danger"> {{ $errors->first('cash_back_ending_time') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-3">                                        
                                                <div class="form-group">
                                                    <label for="status" class="control-label mb-10"> Status <span class="text-danger" title="Required">*</span></label>
                                                    <select id="status" name="status" class="form-control" required readonly>
                                                        <option selected disabled>Select</option>
                                                        <option value="0" @if( $car_package->status == 0) selected @endif>Pending</option>
                                                        <option value="1" @if( $car_package->status == 1) selected @endif>Success</option>
                                                        <option value="2" @if( $car_package->status == 2) selected @endif>Cancel</option>
                                                    </select>
                                                    @if($errors->has('status'))
                                                        <span class="text-danger"> {{ $errors->first('status') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-3">                                        
                                                <div class="form-group">
                                                    <label for="package_status" class="control-label mb-10">Package Status <span class="text-danger" title="Required">*</span></label>
                                                    <select id="package_status" name="package_status" class="form-control" required readonly>
                                                        <option selected disabled>Select</option>
                                                        <option value="1" @if( $car_package->status == 1) selected @endif>Visible</option>
                                                        <option value="0" @if( $car_package->status == 0) selected @endif>Invisible</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">                                        
                                                <div class="form-group">
                                                    <label for="status_message" class="control-label mb-10"> Status Message <span class="text-danger" title="Required">*</span></label>
                                                    <input type="text" id="status_message" name="status_message" value="{{ $car_package->status_message }}" class="form-control" placeholder="Status Message" required readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-12">                                        
                                                <div class="form-group">
                                                    <label for="terms_condition" class="control-label mb-10"> Terms Condition <span class="text-danger" title="Required">*</span></label>                                            
                                                    <textarea class="form-control" rows="6" id="terms_condition" name="terms_condition" placeholder="Terms Condition" rows="3" readonly>{{ $car_package->terms_condition }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="reset" class="btn btn-danger" value="Cancel"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
    
    <!-- Delete Class Modal -->
    <div id="deleteDriverModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title mb-10" id="exampleModalLabel">Are you sure to delete ?</h5>
                    <input type="hidden" name="del_id"/>
                    <button type="button" class="btn btn-xs btn-danger btn-raised mr-2" id="destroyDriver"><i class="fas fa-trash-alt"></i> Proceed</button>
                    <button type="button" class="btn btn-xs btn-warning btn-raised" data-dismiss="modal" aria-label="Close"><i class="fas fa-backspace"></i> Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
