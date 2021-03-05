@extends('quicarbd.admin.layout.admin')
@section('title','Partner')
@section('content')
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-md-lg-3 col-md-4 col-sm-4 col-xs-12">
        </div>
        <!-- Breadcrumb -->
        <div class="col-md-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Partner</a></li>
            <li class="active"><span>Add New Partner</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
    <!-- /Title -->    
    <!-- Row -->
    <div class="row">
        <div class="col-md-sm-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="txt-dark capitalize-font"><i class="fa fa-user mr-10"></i>Partner Info</h6> 
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-sm-12 col-xs-12">
                                <div class="form-wrap">
                                    <form action="{{ route('partner.store') }}" method="post" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="form-body">     
                                            <div class="row">
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="name" class="control-label mb-10">Name <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="name" name="name" placeholder="Enter Name" class="form-control" required>
                                                        @if($errors->has('name'))
                                                            <span class="text-danger"> {{ $errors->first('name') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="email" class="control-label mb-10">Email <span class="text-danger" title="Required">*</span></label>
                                                        <input type="email" id="email" name="email" placeholder="Enter Email Address" class="form-control" required>
                                                        @if($errors->has('email'))
                                                            <span class="text-danger"> {{ $errors->first('email') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="phone" class="control-label mb-10">Phone <span class="text-danger" title="Required">*</span></label>                                            
                                                        <input type="phone" id="phone" name="phone" placeholder="Enter Phone Number" class="form-control" required>
                                                        @if($errors->has('phone'))
                                                            <span class="text-danger"> {{ $errors->first('phone') }}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="dob" class="control-label mb-10">Date of Birth <span class="text-danger" title="Required">*</span></label>                                            
                                                        <input type="date" id="dob" name="dob" class="form-control datePicker" required>
                                                        @if($errors->has('dob'))
                                                            <span class="text-danger"> {{ $errors->first('dob') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="nid" class="control-label mb-10">NID No <span class="text-danger" title="Required">*</span></label>                                            
                                                        <input type="nid" id="nid" name="nid" placeholder="Enter NID Number" class="form-control" required>
                                                        @if($errors->has('nid'))
                                                            <span class="text-danger"> {{ $errors->first('nid') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="account_type" class="control-label mb-10">Account Type <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select id="account_type" name="account_type" class="form-control selectable" required>
                                                            <option selected disabled>Select</option>                                                            
                                                            <option value="0">Car</option>                                                            
                                                            <option value="1">Hotel</option>                                                            
                                                            <option value="2">Travel</option>                                                            
                                                            <option value="3">Car & Hotel</option>                                                            
                                                            <option value="4">Car & Hotel & Travel</option>                                                            
                                                            <option value="5">Hotel & Travel</option>                                                            
                                                            <option value="6">Car & Travel</option>                                                            
                                                        </select>
                                                        @if($errors->has('account_type'))
                                                            <span class="text-danger"> {{ $errors->first('account_type') }}</span>
                                                        @endif
                                                    </div>
                                                </div>                                    
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="account_status" class="control-label mb-10">Account Status <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select id="account_status" name="account_status" class="form-control selectable" required>
                                                            <option selected disabled>Select</option>                                                            
                                                            <option value="0">Pending</option>                                                            
                                                            <option value="1">Active</option>                                                            
                                                            <option value="2">Cancel</option>                                                                  
                                                        </select>
                                                        @if($errors->has('account_status'))
                                                            <span class="text-danger"> {{ $errors->first('account_status') }}</span>
                                                        @endif
                                                    </div>
                                                </div>                                    
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="district" class="control-label mb-10">Disitrict <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select id="district" name="district" class="form-control selectable" required>
                                                            <option selected disabled>Select</option>
                                                            @foreach($districts as $district)
                                                                <option value="{{ $district->id }}">{{ $district->value }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('district'))
                                                            <span class="text-danger"> {{ $errors->first('district') }}</span>
                                                        @endif
                                                    </div>
                                                </div>                                    
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="city" class="control-label mb-10">City <span class="text-danger" title="Required">*</span></label>               
                                                        <select id="city" name="city" class="form-control selectable" required>
                                                        </select>
                                                        @if($errors->has('city'))
                                                            <span class="text-danger"> {{ $errors->first('city') }}</span>
                                                        @endif
                                                    </div>
                                                </div>                                    
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="service_location_district" class="control-label mb-10">Service Location Disitrict <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select id="service_location_district" name="service_location_district" class="form-control selectable" required>
                                                            <option selected disabled>Select</option>
                                                            @foreach($districts as $district)
                                                                <option value="{{ $district->id }}">{{ $district->value }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('service_location_district'))
                                                            <span class="text-danger"> {{ $errors->first('service_location_district') }}</span>
                                                        @endif
                                                    </div>
                                                </div>                                    
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="service_location_city" class="control-label mb-10"> Service Location City <span class="text-danger" title="Required">*</span></label>               
                                                        <select id="service_location_city" name="service_location_city" class="form-control selectable" required>
                                                        </select>
                                                        @if($errors->has('service_location_city'))
                                                            <span class="text-danger"> {{ $errors->first('service_location_city') }}</span>
                                                        @endif
                                                    </div>
                                                </div>                                    
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="area" class="control-label mb-10">Area <span class="text-danger" title="Required">*</span></label>                                            
                                                        <input type="area" id="area" name="area" placeholder="Enter area" class="form-control" required>
                                                        @if($errors->has('area'))
                                                            <span class="text-danger"> {{ $errors->first('area') }}</span>
                                                        @endif
                                                    </div>
                                                </div> 
                                                                                  
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="img" class="control-label mb-10">Image </label>                                            
                                                        <input type="file" name="img" class="form-control" />
                                                        @if($errors->has('img'))
                                                            <span class="text-danger"> {{ $errors->first('img') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="nid_font_pic" class="control-label mb-10">NID Front Pic </label>                                            
                                                        <input type="file" name="nid_font_pic" class="form-control" />
                                                        @if($errors->has('nid_font_pic'))
                                                            <span class="text-danger"> {{ $errors->first('nid_font_pic') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="nid_back_pic" class="control-label mb-10">NID Back Pic </label>                                            
                                                        <input type="file" name="nid_back_pic" class="form-control" />
                                                        @if($errors->has('nid_back_pic'))
                                                            <span class="text-danger"> {{ $errors->first('nid_back_pic') }}</span>
                                                        @endif
                                                    </div>
                                                </div>                                   
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="bidding_percent" class="control-label mb-10">Bidding Percent  <span class="text-danger" title="Required">*</span></label>                                            
                                                        <input type="text" id="bidding_percent" name="bidding_percent" placeholder="Bidding Percent" class="form-control" required>
                                                        @if($errors->has('bidding_percent'))
                                                            <span class="text-danger"> {{ $errors->first('bidding_percent') }}</span>
                                                        @endif
                                                    </div>
                                                </div>                                    
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="car_package_charge" class="control-label mb-10">Car Package Charge  <span class="text-danger" title="Required">*</span></label>                                            
                                                        <input type="text" id="car_package_charge" name="car_package_charge" placeholder="Car Package Charge" class="form-control" required>
                                                        @if($errors->has('car_package_charge'))
                                                            <span class="text-danger"> {{ $errors->first('car_package_charge') }}</span>
                                                        @endif
                                                    </div>
                                                </div>                                    
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="hotel_package_charge" class="control-label mb-10">Hotel Package Charge  <span class="text-danger" title="Required">*</span></label>                                            
                                                        <input type="text" id="hotel_package_charge" name="hotel_package_charge" placeholder="Hotel Package Charge" class="form-control" required>
                                                        @if($errors->has('hotel_package_charge'))
                                                            <span class="text-danger"> {{ $errors->first('hotel_package_charge') }}</span>
                                                        @endif
                                                    </div>
                                                </div>                                    
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="travel_package_charge" class="control-label mb-10">Travel Package Charge  <span class="text-danger" title="Required">*</span></label>                                            
                                                        <input type="text" id="travel_package_charge" name="travel_package_charge" placeholder="Travel Package Charge" class="form-control" required>
                                                        @if($errors->has('travel_package_charge'))
                                                            <span class="text-danger"> {{ $errors->first('travel_package_charge') }}</span>
                                                        @endif
                                                    </div>
                                                </div>  
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
	<script src="{{ asset('quicarbd/admin/js/partner.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
