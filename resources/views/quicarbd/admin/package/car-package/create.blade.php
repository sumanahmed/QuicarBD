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
            <li class="active"><span>Add Car Package</span></li>
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
                                    <form action="{{ route('car_package.store') }}" method="post" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="form-body">     
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="name" class="control-label mb-10">Package Name <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" placeholder="Package Name" required>
                                                        @if($errors->has('name'))
                                                            <span class="text-danger"> {{ $errors->first('name') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="owner_id" class="control-label mb-10">Partner <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select id="owner_id" name="owner_id" class="form-control selectable" required>
                                                            <option selected disabled>Select</option>
                                                            @foreach($partners as $partner)
                                                                <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('owner_id'))
                                                            <span class="text-danger"> {{ $errors->first('owner_id') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="car_id" class="control-label mb-10">Select Car <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select class="form-control" name="car_id" id="car_id"> 
                                                        </select>
                                                        @if($errors->has('car_id'))
                                                            <span class="text-danger"> {{ $errors->first('car_id') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-3">                                        
                                                    <div class="form-group">
                                                        <label for="quicar_charge" class="control-label mb-10"> Quicar Charge <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="quicar_charge" name="quicar_charge" value="{{ old('quicar_charge') }}" class="form-control" placeholder="Quicar Charge" readonly required>
                                                        <input type="hidden" id="quicar_charge_percent">
                                                        @if($errors->has('quicar_charge'))
                                                            <span class="text-danger"> {{ $errors->first('quicar_charge') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                        
                                                    <div class="form-group">
                                                        <label for="details" class="control-label mb-10"> Details <span class="text-danger" title="Required">*</span></label>                                            
                                                        <textarea class="form-control" id="details" name="details" placeholder="Details" rows="3"></textarea>
                                                        @if($errors->has('details'))
                                                            <span class="text-danger"> {{ $errors->first('details') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                        
                                                    <div class="form-group">
                                                        <label for="facilities" class="control-label mb-10"> Factilites <span class="text-danger" title="Required">*</span></label>                                            
                                                        <textarea class="form-control" id="facilities" name="facilities" placeholder="Facilites" rows="3"></textarea>
                                                        @if($errors->has('facilities'))
                                                            <span class="text-danger"> {{ $errors->first('facilities') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="district_id" class="control-label mb-10">Select Tour District <span class="text-danger" title="Required">*</span></label>
                                                        <select id="district_id" name="district_id" class="form-control selectable" required>
                                                            <option selected disabled>Select</option>
                                                            @foreach($districts as $district)
                                                                <option value="{{ $district->id }}">{{ $district->value }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('district_id'))
                                                            <span class="text-danger"> {{ $errors->first('district_id') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <label for="spot_id" class="control-label mb-10">Select Tour Spot <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select id="spot_id" name="spot_id[]" class="form-control" multiple required>                                                
                                                        </select>
                                                        @if($errors->has('spot_id'))
                                                            <span class="text-danger"> {{ $errors->first('spot_id') }}</span>
                                                        @endif
                                                    </div>
                                                </div>                                                
                                                <div class="col-md-2">                                        
                                                    <div class="form-group">
                                                        <label for="duration" class="control-label mb-10"> Duration(day) <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="duration" name="duration" value="{{ old('duration') }}" class="form-control" placeholder="Duration" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
                                                        @if($errors->has('duration'))
                                                            <span class="text-danger"> {{ $errors->first('duration') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-2">                                        
                                                    <div class="form-group">
                                                        <label for="starting_location" class="control-label mb-10"> Starting Location <span class="text-danger" title="Required">*</span></label>
                                                        <select id="starting_location" name="starting_location" class="form-control selectable" required>
                                                            <option selected disabled>Select</option>
                                                            @foreach($districts as $district)
                                                                <option value="{{ $district->id }}">{{ $district->value }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('starting_location'))
                                                            <span class="text-danger"> {{ $errors->first('starting_location') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-2">                                        
                                                    <div class="form-group">
                                                        <label for="starting_city_id" class="control-label mb-10"> Starting City <span class="text-danger" title="Required">*</span></label>                                        
                                                        <select id="starting_city_id" name="starting_city_id" class="form-control selectable" required>
                                                            
                                                        </select>
                                                        @if($errors->has('starting_city_id'))
                                                            <span class="text-danger"> {{ $errors->first('starting_city_id') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="starting_location_address" class="control-label mb-10"> Starting Location Address <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="starting_location_address" name="starting_location_address" value="{{ old('starting_location_address') }}" class="form-control" placeholder="Starting Location Address" required>
                                                        @if($errors->has('starting_location_address'))
                                                            <span class="text-danger"> {{ $errors->first('starting_location_address') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-2">                                        
                                                    <div class="form-group">
                                                        <label for="total_person" class="control-label mb-10"> Total Person <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="total_person" name="total_person" value="{{ old('total_person') }}" class="form-control" placeholder="Total Person" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required readonly>
                                                        @if($errors->has('total_person'))
                                                            <span class="text-danger"> {{ $errors->first('total_person') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-3">                                        
                                                    <div class="form-group">
                                                        <label for="price" class="control-label mb-10"> Price <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="price" name="price" value="{{ old('price') }}" class="form-control" oninput="calculateCharge()" placeholder="Price" required>
                                                        @if($errors->has('price'))
                                                            <span class="text-danger"> {{ $errors->first('price') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="owner_get" class="control-label mb-10">Owner Get <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="owner_get" name="owner_get" value="{{ old('owner_get') }}" class="form-control" placeholder="Owner Get" readonly required>
                                                        @if($errors->has('owner_get'))
                                                            <span class="text-danger"> {{ $errors->first('owner_get') }}</span>
                                                        @endif
                                                    </div>
                                                </div>       
                                                <div class="col-md-3">                                        
                                                    <div class="form-group">
                                                        <label for="cash_back_price" class="control-label mb-10">Cash Back Price</label>
                                                        <input type="text" id="cash_back_price" name="cash_back_price" value="{{ old('cash_back_price') }}" class="form-control" placeholder="Cash Back Price" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                                        @if($errors->has('cash_back_price'))
                                                            <span class="text-danger"> {{ $errors->first('cash_back_price') }}</span>
                                                        @endif
                                                    </div>
                                                </div>                                         
                                                <div class="col-md-3">                                        
                                                    <div class="form-group">
                                                        <label for="cash_back_status" class="control-label mb-10">Cash Back Status </label>
                                                        <select id="cash_back_status" name="cash_back_status" class="form-control">
                                                            <option selected disabled>Select</option>
                                                            <option value="0">Pause</option>
                                                            <option value="1">Active</option>
                                                        </select>
                                                        @if($errors->has('cash_back_status'))
                                                            <span class="text-danger"> {{ $errors->first('cash_back_status') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-3">                                        
                                                    <div class="form-group">
                                                        <label for="cash_back_staring_time" class="control-label mb-10">Cash Back Start Time</label>
                                                        <input type="datetime-local" id="cash_back_staring_time" name="cash_back_staring_time" value="{{ old('cash_back_staring_time') }}" class="form-control">
                                                        @if($errors->has('cash_back_staring_time'))
                                                            <span class="text-danger"> {{ $errors->first('cash_back_staring_time') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-3">                                        
                                                    <div class="form-group">
                                                        <label for="cash_back_ending_time" class="control-label mb-10">Cash Back End Time </label>
                                                        <input type="datetime-local" id="cash_back_ending_time" value="{{ old('cash_back_ending_time') }}" name="cash_back_ending_time" class="form-control">
                                                        @if($errors->has('cash_back_ending_time'))
                                                            <span class="text-danger"> {{ $errors->first('cash_back_ending_time') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-3">                                        
                                                    <div class="form-group">
                                                        <label for="status" class="control-label mb-10"> Status <span class="text-danger" title="Required">*</span></label>
                                                        <select id="status" name="status" class="form-control" required>
                                                            <option value="0" selected>Pending</option>
                                                            <option value="1">Success</option>
                                                            <option value="2">Cancel</option>
                                                        </select>
                                                        @if($errors->has('status'))
                                                            <span class="text-danger"> {{ $errors->first('status') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-3">                                        
                                                    <div class="form-group">
                                                        <label for="package_status" class="control-label mb-10">Package Status <span class="text-danger" title="Required">*</span></label>
                                                        <select id="package_status" name="package_status" value="{{ old('package_status') }}" class="form-control" required>                                                       
                                                            <option value="1" selected>Visible</option>
                                                            <option value="0">Invisible</option>
                                                        </select>
                                                        @if($errors->has('package_status'))
                                                            <span class="text-danger"> {{ $errors->first('package_status') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-3">                                        
                                                    <div class="form-group">
                                                        <label for="status_message" class="control-label mb-10"> Status Message </label>
                                                        <input type="text" id="status_message" name="status_message" value="{{ old('status_message') }}" class="form-control" placeholder="Status Message" required>
                                                        @if($errors->has('status_message'))
                                                            <span class="text-danger"> {{ $errors->first('status_message') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-12">                                        
                                                    <div class="form-group">
                                                        <label for="terms_condition" class="control-label mb-10"> Terms Condition <span class="text-danger" title="Required">*</span></label>                                            
                                                        <textarea class="form-control" id="terms_condition" name="terms_condition" placeholder="Terms Condition" rows="3"></textarea>
                                                        @if($errors->has('terms_condition'))
                                                            <span class="text-danger"> {{ $errors->first('terms_condition') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="submit" class="btn btn-success" value="Submit"/>
                                                        <input type="reset" class="btn btn-danger" value="Cancel"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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
    <script src="{{ asset('quicarbd/admin/js/car-package.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
