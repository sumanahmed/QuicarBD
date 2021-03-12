@extends('quicarbd.admin.layout.admin')
@section('title','Hotel or Resort Package')
@section('styles')
    <style>
        input[type=file] {
            display: none;
        }
    </style>
@endsection
@section('content')
<div class="container-fluid">               
    <!-- Title -->
    <div class="row heading-bg">
        <div class="col-md-md-md-lg-3 col-md-4 col-sm-4 col-xs-12">
        </div>
        <!-- Breadcrumb -->
        <div class="col-md-md-md-lg-9 col-sm-8 col-md-8 col-xs-12">
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
        <div class="col-md-md-md-sm-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="txt-dark capitalize-font"><i class="fa fa-hotel mr-10"></i>Hotel & Resort Package Info</h6> 
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <form action="{{ route('hotel_package.store') }}" method="post" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="hotel_name" class="control-label mb-10">Hotel or Resort Name <span class="text-danger" title="Required">*</span></label>
                                        <input type="text" id="hotel_name" name="hotel_name" class="form-control" placeholder="Hotel or Resort Name" required>
                                        @if($errors->has('hotel_name'))
                                            <span class="text-danger"> {{ $errors->first('hotel_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="district_id" class="control-label mb-10">Select District <span class="text-danger" title="Required">*</span></label>
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="city_id" class="control-label mb-10">Select City <span class="text-danger" title="Required">*</span></label>
                                        <select id="city_id" name="city_id" class="form-control selectable" required>
                                        </select>
                                        @if($errors->has('city_id'))
                                            <span class="text-danger"> {{ $errors->first('city_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">                                        
                                    <div class="form-group">
                                        <label for="area" class="control-label mb-10"> Area <span class="text-danger" title="Required">*</span></label>
                                        <input type="text" id="area" name="area" class="form-control" placeholder="Area" required>
                                        @if($errors->has('area'))
                                            <span class="text-danger"> {{ $errors->first('area') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">                                        
                                    <div class="form-group">
                                        <label for="propertyType" class="control-label mb-10"> Property Type <span class="text-danger" title="Required">*</span></label>                                            
                                        <select id="propertyType" name="propertyType" class="form-control" requireed>
                                            @foreach($property_types as $property_type)
                                                <option value="{{ $property_type->id }}">{{ $property_type->name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('propertyType'))
                                            <span class="text-danger"> {{ $errors->first('propertyType') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">                                        
                                    <div class="form-group">
                                        <label for="room_type" class="control-label mb-10"> Room Type </label>
                                        <input type="text" id="room_type" name="room_type" class="form-control" placeholder="Room Type">
                                        @if($errors->has('room_type'))
                                            <span class="text-danger"> {{ $errors->first('room_type') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">                                        
                                    <div class="form-group">
                                        <label for="room_size" class="control-label mb-10"> Room Size </label>
                                        <input type="text" id="room_size" name="room_size" class="form-control" placeholder="Room Size">
                                        @if($errors->has('room_size'))
                                            <span class="text-danger"> {{ $errors->first('room_size') }}</span>
                                        @endif
                                    </div>
                                </div> 
                                <div class="col-md-4">                                        
                                    <div class="form-group">
                                        <label for="hotel_website" class="control-label mb-10"> Hotel Website </label>
                                        <input type="text" id="hotel_website" name="hotel_website" class="form-control" placeholder="Hotel Website">
                                        @if($errors->has('hotel_website'))
                                            <span class="text-danger"> {{ $errors->first('hotel_website') }}</span>
                                        @endif
                                    </div>
                                </div> 
                                <div class="col-md-4">                                        
                                    <div class="form-group">
                                        <label for="referrel_code" class="control-label mb-10"> Referrel Code </label>
                                        <input type="text" id="referrel_code" name="referrel_code" class="form-control" placeholder="Referrel Code">
                                        @if($errors->has('referrel_code'))
                                            <span class="text-danger"> {{ $errors->first('referrel_code') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">                                        
                                    <div class="form-group">
                                        <label for="owner_id" class="control-label mb-10"> Partner <span class="text-danger" title="Required">*</span></label>
                                        <select id="owner_id" name="owner_id" class="form-control" required>
                                            <option selected disabled> Select</option>
                                            @foreach($owners as $owner)
                                                <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('owner_id'))
                                            <span class="text-danger"> {{ $errors->first('owner_id') }}</span>
                                        @endif
                                    </div>
                                </div>     
                            </div>
                            <div class="row">
                                <div class="col-md-2">                                        
                                    <div class="form-group">
                                        <label for="quicar_charge" class="control-label mb-10"> Qucar Charge(%) <span class="text-danger" title="Required">*</span></label>
                                        <input type="text" id="quicar_charge" name="quicar_charge" class="form-control" placeholder="Quicar Charge(%)" readonly required>
                                        @if($errors->has('quicar_charge'))
                                            <span class="text-danger"> {{ $errors->first('quicar_charge') }}</span>
                                        @endif
                                    </div>
                                </div> 
                                <div class="col-md-2">                                        
                                    <div class="form-group">
                                        <label for="price" class="control-label mb-10"> Price <span class="text-danger" title="Required">*</span></label>
                                        <input type="text" id="price" name="price" oninput="calculateCharge()" class="form-control" placeholder="Price" required>
                                        @if($errors->has('price'))
                                            <span class="text-danger"> {{ $errors->first('price') }}</span>
                                        @endif
                                    </div>
                                </div> 
                                <div class="col-md-2">                                        
                                    <div class="form-group">
                                        <label for="price" class="control-label mb-10"> Partner Get <span class="text-danger" title="Required">*</span></label>
                                        <input type="text" id="you_will_get" name="you_will_get" class="form-control" placeholder="Partner Get" readonly required>
                                        @if($errors->has('you_will_get'))
                                            <span class="text-danger"> {{ $errors->first('you_will_get') }}</span>
                                        @endif
                                    </div>
                                </div> 
                                <div class="col-md-3">                                        
                                    <div class="form-group">
                                        <label for="min_price" class="control-label mb-10"> Minimum Price <span class="text-danger" title="Required">*</span></label>
                                        <input type="text" id="min_price" name="min_price" class="form-control" placeholder="Minimum Price" required>
                                        @if($errors->has('min_price'))
                                            <span class="text-danger"> {{ $errors->first('min_price') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">                                        
                                    <div class="form-group">
                                        <label for="max_price" class="control-label mb-10"> Max Price <span class="text-danger" title="Required">*</span></label>
                                        <input type="text" id="max_price" name="max_price" class="form-control" placeholder="Max Price" required>
                                        @if($errors->has('max_price'))
                                            <span class="text-danger"> {{ $errors->first('max_price') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">                                        
                                    <div class="form-group">
                                        <label for="booking_contact_number" class="control-label mb-10"> Booking Contact Number</label>
                                        <input type="text" id="booking_contact_number" name="booking_contact_number" class="form-control" placeholder="Booking Contact Number">
                                        @if($errors->has('booking_contact_number'))
                                            <span class="text-danger"> {{ $errors->first('booking_contact_number') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">                                        
                                    <div class="form-group">
                                        <label for="status" class="control-label mb-10"> Status <span class="text-danger" title="Required">*</span></label>
                                        <select id="status" name="status" class="form-control" required>
                                            <option value="0">Pending</option>
                                            <option value="1">Success</option>
                                            <option value="2">Cancel</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">                                        
                                    <div class="form-group">
                                        <label for="package_status" class="control-label mb-10">Package Status <span class="text-danger" title="Required">*</span></label>
                                        <select id="package_status" name="package_status" class="form-control" required>
                                            <option value="0">Invisible</option>
                                            <option value="1">Visible</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">                                        
                                    <div class="form-group">
                                        <label for="facebook_page" class="control-label mb-10"> Facebook Page </label>
                                        <input type="text" id="facebook_page" name="facebook_page" class="form-control" placeholder="Facebook Page">
                                        @if($errors->has('facebook_page'))
                                            <span class="text-danger"> {{ $errors->first('facebook_page') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">                                        
                                    <div class="form-group">
                                        <label for="hotel_check_in_time" class="control-label mb-10"> Hotel Check In Time <span class="text-danger" title="Required">*</span></label>
                                        <input type="time" id="hotel_check_in_time" name="hotel_check_in_time" class="form-control" placeholder="Hotel Check In Time" required>
                                        @if($errors->has('hotel_check_in_time'))
                                            <span class="text-danger"> {{ $errors->first('hotel_check_in_time') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">                                        
                                    <div class="form-group">
                                        <label for="hotel_check_out_time" class="control-label mb-10"> Hotel Check Out Time <span class="text-danger" title="Required">*</span></label>
                                        <input type="time" id="hotel_check_out_time" name="hotel_check_out_time" class="form-control" placeholder="Hotel Check Out Time" required>
                                        @if($errors->has('hotel_check_out_time'))
                                            <span class="text-danger"> {{ $errors->first('hotel_check_out_time') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">                                        
                                    <div class="form-group">
                                        <label for="facilities" class="control-label mb-10"> Factilites <span class="text-danger" title="Required">*</span></label>                                                                                       
                                        <select id="facilities" name="facilities[]" class="form-control selectable" multiple required>  
                                            @foreach($amenities as $amenity)                                              
                                                <option value="{{ $amenity->id }}">{{ $amenity->name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('facilities'))
                                            <span class="text-danger"> {{ $errors->first('facilities') }}</span>
                                        @endif
                                    </div>
                                </div> 
                            </div>
                            <div class="row">                                     
                                <div class="col-md-6">                                        
                                    <div class="form-group">
                                        <label for="booking_policy" class="control-label mb-10"> Booking Policy <span class="text-danger" title="Required">*</span></label>                                            
                                        <textarea class="form-control" id="booking_policy" name="booking_policy" placeholder="Booking Policy" rows="3"></textarea>
                                        @if($errors->has('booking_policy'))
                                            <span class="text-danger"> {{ $errors->first('booking_policy') }}</span>
                                        @endif
                                    </div>
                                </div>  
                                <div class="col-md-6">                                        
                                    <div class="form-group">
                                        <label for="cancellation_policy" class="control-label mb-10"> Cancellation Policy <span class="text-danger" title="Required">*</span></label>                                            
                                        <textarea class="form-control" id="cancellation_policy" name="cancellation_policy" placeholder="Cancellation Policy" rows="3"></textarea>
                                        @if($errors->has('cancellation_policy'))
                                            <span class="text-danger"> {{ $errors->first('cancellation_policy') }}</span>
                                        @endif
                                    </div>
                                </div>  
                                <div class="col-md-6">                                        
                                    <div class="form-group">
                                        <label for="hotel_image" class="control-label mb-10">Hotel or Resort Image <span class="text-danger" title="Required">*</span></label>                                                                                
                                        <div class="avatar-upload">
                                            <div class="avatar-edit">
                                                <input type='file' name="hotel_image" id="hotelImgUpload" accept=".png, .jpg, .jpeg" required/>
                                                <label for="hotelImgUpload"><i class="fa fa-edit"></i></label>
                                            </div>
                                            <div class="avatar-preview" style="width:100%">
                                                <div id="hotelImgPreview" style="background-image: url();"></div>
                                            </div>
                                        </div>
                                        @if($errors->has('hotel_image'))
                                            <span class="text-danger"> {{ $errors->first('hotel_image') }}</span>
                                        @endif
                                    </div>
                                </div>  
                                <div class="col-md-6">                                        
                                    <div class="form-group">
                                        <label for="room_image" class="control-label mb-10">Room Image <span class="text-danger" title="Required">*</span></label>                                            
                                        <div class="avatar-upload">
                                            <div class="avatar-edit">
                                                <input type='file' name="room_image" id="roomImgUpload" accept=".png, .jpg, .jpeg" required/>
                                                <label for="roomImgUpload"><i class="fa fa-edit"></i></label>
                                            </div>
                                            <div class="avatar-preview" style="width:100%">
                                                <div id="roomImgPreview" style="background-image: url();"></div>
                                            </div>
                                        </div>
                                        @if($errors->has('room_image'))
                                            <span class="text-danger"> {{ $errors->first('room_image') }}</span>
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
@endsection
@section('scripts')
    <script src="{{ asset('quicarbd/admin/js/hotel-package.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
