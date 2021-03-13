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
            <li class="active"><span>Details</span></li>
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
                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                <div class="panel panel-default card-view pa-0">
                                    <div class="panel-wrapper collapse in">
                                        <div class="panel-body pa-0">
                                            <div class="sm-data-box">
                                                <div class="container-fluid">
                                                    <div class="text-center pl-0 pr-0 data-wrap-left">
                                                        <a href="{{ route('car.index',['owner_id'=> $partner->id ]) }}">
                                                            <span class="txt-dark block counter"><span class="counter-anim">{{ $total_car }}</span></span>
                                                            <span class="weight-500 uppercase-font block font-13">Total Car</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
                                <div class="panel panel-default card-view pa-0">
                                    <div class="panel-wrapper collapse in">
                                        <div class="panel-body pa-0">
                                            <div class="sm-data-box">
                                                <div class="container-fluid">
                                                    <div class="text-center pl-0 pr-0 data-wrap-left">
                                                        <a href="{{ route('driver.index',['owner_id'=> $partner->id ]) }}">
                                                            <span class="txt-dark block counter"><span class="counter-anim">{{ $total_driver }}</span></span>
                                                            <span class="weight-500 uppercase-font block">Total Driver</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                    
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
                                <div class="panel panel-default card-view pa-0">
                                    <div class="panel-wrapper collapse in">
                                        <div class="panel-body pa-0">
                                            <div class="sm-data-box">
                                                <div class="container-fluid">
                                                    <div class="text-center pl-0 pr-0 data-wrap-left">
                                                        <a href="{{ route('car_package.index',['owner_id'=> $partner->id ]) }}">
                                                            <span class="txt-dark block counter"><span class="counter-anim">{{ $total_car_package }}</span></span>
                                                            <span class="weight-500 uppercase-font block">Total Car Package</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>   
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                <div class="panel panel-default card-view pa-0">
                                    <div class="panel-wrapper collapse in">
                                        <div class="panel-body pa-0">
                                            <div class="sm-data-box">
                                                <div class="container-fluid">
                                                    <div class="text-center pl-0 pr-0 data-wrap-left">
                                                        <a href="{{ route('hotel_package.index',['owner_id'=> $partner->id ]) }}">
                                                            <span class="txt-dark block counter"><span class="counter-anim">{{ $total_hotel_package }}</span></span>
                                                            <span class="weight-500 uppercase-font block">Total Hotel Package</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                <div class="panel panel-default card-view pa-0">
                                    <div class="panel-wrapper collapse in">
                                        <div class="panel-body pa-0">
                                            <div class="sm-data-box">
                                                <div class="container-fluid">
                                                    <div class="text-center pl-0 pr-0 data-wrap-left">
                                                        <a href="{{ route('travel_package.index',['owner_id'=> $partner->id ]) }}">
                                                            <span class="txt-dark block counter"><span class="counter-anim">{{ $total_travel_package }}</span></span>
                                                            <span class="weight-500 uppercase-font block">Total Travel Package</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-sm-12 col-xs-12">
                                <div class="form-wrap">
                                    <div class="form-body">     
                                        <div class="row">
                                            <div class="col-md-4">                                        
                                                <div class="form-group">
                                                    <label for="name" class="control-label mb-10">Name <span class="text-danger" title="Required">*</span></label>
                                                    <input type="text" id="name" name="name" value="{{ $partner->name }}" placeholder="Enter Name" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">                                        
                                                <div class="form-group">
                                                    <label for="email" class="control-label mb-10">Email <span class="text-danger" title="Required">*</span></label>
                                                    <input type="email" id="email" value="{{ $partner->email }}" name="email" placeholder="Enter Email Address" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Phone <span class="text-danger" title="Required">*</span></label>                                            
                                                    <input type="phone" id="phone" value="{{ $partner->phone }}" name="phone" placeholder="Enter Phone Number" class="form-control" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="dob" class="control-label mb-10">Date of Birth <span class="text-danger" title="Required">*</span></label>                                            
                                                    <input type="date" id="dob" value="{{ $partner->dob }}" name="dob" class="form-control datePicker" readonly>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="nid" class="control-label mb-10">NID No <span class="text-danger" title="Required">*</span></label>                                            
                                                    <input type="nid" id="nid" name="nid" value="{{ $partner->nid }}" placeholder="Enter NID Number" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="account_type" class="control-label mb-10">Account Type <span class="text-danger" title="Required">*</span></label>                                            
                                                    <select id="account_type" name="account_type" class="form-control selectable" readonly>
                                                        <option selected disabled>Select</option>                                                            
                                                        <option value="0" @if($partner->account_type == 0) selected @endif>Car</option>                                                            
                                                        <option value="1" @if($partner->account_type == 1) selected @endif>Hotel</option>                                                            
                                                        <option value="2" @if($partner->account_type == 2) selected @endif>Travel</option>                                                            
                                                        <option value="3" @if($partner->account_type == 3) selected @endif>Car & Hotel</option>                                                            
                                                        <option value="4" @if($partner->account_type == 4) selected @endif>Car & Hotel & Travel</option>                                                            
                                                        <option value="5" @if($partner->account_type == 5) selected @endif>Hotel & Travel</option>                                                            
                                                        <option value="6" @if($partner->account_type == 6) selected @endif>Car & Travel</option>                                                            
                                                    </select>
                                                </div>
                                            </div>                                    
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="account_status" class="control-label mb-10">Account Status <span class="text-danger" title="Required">*</span></label>                                            
                                                    <select id="account_status" name="account_status" class="form-control selectable" readonly>
                                                        <option selected disabled>Select</option>                                                            
                                                        <option value="0" @if($partner->account_status == 6) selected @endif>Pending</option>                                                            
                                                        <option value="1" @if($partner->account_status == 1) selected @endif>Active</option>                                                            
                                                        <option value="2" @if($partner->account_status == 2) selected @endif>Cancel</option>                                                                  
                                                    </select>
                                                    @if($errors->has('account_status'))
                                                        <span class="text-danger"> {{ $errors->first('account_status') }}</span>
                                                    @endif
                                                </div>
                                            </div>                                    
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="district" class="control-label mb-10">Disitrict <span class="text-danger" title="Required">*</span></label>                                            
                                                    <input type="text" id="district" value="{{ $partner->district }}" name="district" class="form-control" readonly>
                                                </div>
                                            </div>                                    
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="city" class="control-label mb-10">City <span class="text-danger" title="Required">*</span></label>               
                                                    <input type="text" id="city" value="{{ $partner->city }}" name="city" class="form-control" readonly>
                                                </div>
                                            </div>                                    
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="service_location_district" class="control-label mb-10">Service Location Disitrict <span class="text-danger" title="Required">*</span></label>                                            
                                                    <input type="text" id="service_location_district" value="{{ $partner->service_location_district }}" name="service_location_district" class="form-control" readonly>
                                                </div>
                                            </div>                                    
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="service_location_city" class="control-label mb-10"> Service Location City <span class="text-danger" title="Required">*</span></label>               
                                                    <input type="text" id="service_location_city" value="{{ $partner->service_location_city }}" name="service_location_city" class="form-control" readonly>
                                                </div>
                                            </div>                                    
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="area" class="control-label mb-10">Area <span class="text-danger" title="Required">*</span></label>                                            
                                                    <input type="area" id="area" name="area" value="{{ $partner->area }}" placeholder="Enter area" class="form-control" readonly>
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
                                                    <input type="text" id="bidding_percent" name="bidding_percent" value="{{ $partner->bidding_percent }}" placeholder="Bidding Percent" class="form-control" readonly>
                                                    @if($errors->has('bidding_percent'))
                                                        <span class="text-danger"> {{ $errors->first('bidding_percent') }}</span>
                                                    @endif
                                                </div>
                                            </div>                                    
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="car_package_charge" class="control-label mb-10">Car Package Charge  <span class="text-danger" title="Required">*</span></label>                                            
                                                    <input type="text" id="car_package_charge" name="car_package_charge" value="{{ $partner->car_package_charge }}" placeholder="Car Package Charge" class="form-control" readonly>
                                                    @if($errors->has('car_package_charge'))
                                                        <span class="text-danger"> {{ $errors->first('car_package_charge') }}</span>
                                                    @endif
                                                </div>
                                            </div>                                    
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="hotel_package_charge" class="control-label mb-10">Hotel Package Charge  <span class="text-danger" title="Required">*</span></label>                                            
                                                    <input type="text" id="hotel_package_charge" name="hotel_package_charge" value="{{ $partner->hotel_package_charge }}" placeholder="Hotel Package Charge" class="form-control" readonly>
                                                </div>
                                            </div>                                    
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="travel_package_charge" class="control-label mb-10">Travel Package Charge  <span class="text-danger" title="Required">*</span></label>                                            
                                                    <input type="text" id="travel_package_charge" name="travel_package_charge" value="{{ $partner->travel_package_charge }}" placeholder="Travel Package Charge" class="form-control" readonly>
                                                </div>
                                            </div>  
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
</div>
@endsection
@section('scripts')
	<script src="{{ asset('quicarbd/admin/js/partner.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
