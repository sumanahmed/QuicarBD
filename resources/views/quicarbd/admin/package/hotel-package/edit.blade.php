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
            <li class="active"><span>Add Hotel or Resort Package</span></li>
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
                    <form action="{{ route('hotel_package.update', $hotel_package->id) }}" method="post" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="hotel_name" class="control-label mb-10">Hotel or Resort Name <span class="text-danger" title="Required">*</span></label>
                                        <input type="text" id="hotel_name" name="hotel_name" value="{{ $hotel_package->hotel_name }}" class="form-control" placeholder="Hotel or Resort Name" required>
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
                                                <option value="{{ $district->id }}" @if($hotel_package->district_id == $district->id) selected @endif>{{ $district->value }}</option>
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
                                            <option selected disabled>Select</option>
                                            @foreach($cities as $city)
                                                <option value="{{ $city->id }}" @if($hotel_package->city_id == $city->id) selected @endif>{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('city_id'))
                                            <span class="text-danger"> {{ $errors->first('city_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">                                        
                                    <div class="form-group">
                                        <label for="area" class="control-label mb-10"> Area <span class="text-danger" title="Required">*</span></label>
                                        <input type="text" id="area" name="area" value="{{ $hotel_package->area }}" class="form-control" placeholder="Area" required>
                                        @if($errors->has('area'))
                                            <span class="text-danger"> {{ $errors->first('area') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">                                        
                                    <div class="form-group">
                                        <label for="propertyType" class="control-label mb-10"> Property Type <span class="text-danger" title="Required">*</span></label>                                            
                                        <select id="propertyType" name="propertyType" value="{{ $hotel_package->propertyType }}" class="form-control" requireed>
                                            @foreach($property_types as $property_type)
                                                <option value="{{ $property_type->id }}" @if($hotel_package->propertyType == $property_type->id) selected @endif>{{ $property_type->name }}</option>
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
                                        <input type="text" id="room_type" name="room_type" value="{{ $hotel_package->room_type }}" class="form-control" placeholder="Room Type">
                                        @if($errors->has('room_type'))
                                            <span class="text-danger"> {{ $errors->first('room_type') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">                                        
                                    <div class="form-group">
                                        <label for="room_size" class="control-label mb-10"> Room Size </label>
                                        <input type="text" id="room_size" name="room_size" value="{{ $hotel_package->room_size }}" class="form-control" placeholder="Room Size">
                                        @if($errors->has('room_size'))
                                            <span class="text-danger"> {{ $errors->first('room_size') }}</span>
                                        @endif
                                    </div>
                                </div> 
                                <div class="col-md-4">                                        
                                    <div class="form-group">
                                        <label for="hotel_website" class="control-label mb-10"> Hotel Website </label>
                                        <input type="text" id="hotel_website" name="hotel_website" value="{{ $hotel_package->hotel_website }}" class="form-control" placeholder="Hotel Website">
                                        @if($errors->has('hotel_website'))
                                            <span class="text-danger"> {{ $errors->first('hotel_website') }}</span>
                                        @endif
                                    </div>
                                </div> 
                                <div class="col-md-4">                                        
                                    <div class="form-group">
                                        <label for="referrel_code" class="control-label mb-10"> Referrel Code </label>
                                        <input type="text" id="referrel_code" name="referrel_code" value="{{ $hotel_package->referrel_code }}" class="form-control" placeholder="Referrel Code">
                                        @if($errors->has('referrel_code'))
                                            <span class="text-danger"> {{ $errors->first('referrel_code') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">                                        
                                    <div class="form-group">
                                        <label for="owner_id" class="control-label mb-10"> Partner <span class="text-danger" title="Required">*</span></label>
                                        <select id="owner_id" name="owner_id" class="form-control" required>
                                            <option value="{{ $hotel_package->owner_id }}" selected>{{ $owner }}</option>
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
                                        <label for="quicar_charge" class="control-label mb-10"> Qucar Charge <span class="text-danger" title="Required">*</span></label>
                                        <input type="text" id="quicar_charge" name="quicar_charge" value="{{ $hotel_package->quicar_charge }}" class="form-control" placeholder="Quicar Charge(%)" readonly required>
                                        <input type="hidden" id="quicar_charge_percent">
                                        @if($errors->has('quicar_charge'))
                                            <span class="text-danger"> {{ $errors->first('quicar_charge') }}</span>
                                        @endif
                                    </div>
                                </div> 
                                <div class="col-md-2">                                        
                                    <div class="form-group">
                                        <label for="price" class="control-label mb-10"> Price <span class="text-danger" title="Required">*</span></label>
                                        <input type="text" id="price" name="price" oninput="calculateCharge()" value="{{ $hotel_package->price }}" class="form-control" placeholder="Price" required>
                                        @if($errors->has('price'))
                                            <span class="text-danger"> {{ $errors->first('price') }}</span>
                                        @endif
                                    </div>
                                </div> 
                                <div class="col-md-2">                                        
                                    <div class="form-group">
                                        <label for="price" class="control-label mb-10"> Partner Get <span class="text-danger" title="Required">*</span></label>
                                        <input type="text" id="you_will_get" name="you_will_get" value="{{ $hotel_package->you_will_get }}" class="form-control" placeholder="Partner Get" readonly required>
                                        @if($errors->has('you_will_get'))
                                            <span class="text-danger"> {{ $errors->first('you_will_get') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">                                        
                                    <div class="form-group">
                                        <label for="cash_back_price" class="control-label mb-10">Cash Back Price</label>
                                        <input type="text" id="cash_back_price" name="cash_back_price" value="{{ $hotel_package->cash_back_price }}" class="form-control" placeholder="Cash Back Price" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                    </div>
                                </div>                                         
                                <div class="col-md-3">                                        
                                    <div class="form-group">
                                        <label for="cash_back_status" class="control-label mb-10">Cash Back Status </label>
                                        <select id="cash_back_status" name="cash_back_status" class="form-control">
                                            <option value="0" @if($hotel_package->cash_back_status == 0) selected @endif>Pause</option>
                                            <option value="1" @if($hotel_package->cash_back_status == 1) selected @endif>Active</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">                                        
                                    <div class="form-group">
                                        <label for="cash_back_staring_time" class="control-label mb-10">Cash Back Start Time</label>
                                        <input type="datetime-local" id="cash_back_staring_time" name="cash_back_staring_time"  @if($hotel_package->cash_back_staring_time != null) value="{{ date('Y-m-d\TH:i:s', strtotime($hotel_package->cash_back_staring_time)) }}" @endif class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">                                        
                                    <div class="form-group">
                                        <label for="cash_back_ending_time" class="control-label mb-10">Cash Back End Time </label>
                                        <input type="datetime-local" id="cash_back_ending_time" name="cash_back_ending_time" @if($hotel_package->cash_back_staring_time != null) value="{{ date('Y-m-d\TH:i:s', strtotime($hotel_package->cash_back_staring_time)) }}" @endif class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">                                        
                                    <div class="form-group">
                                        <label for="booking_contact_number" class="control-label mb-10"> Booking Contact Number</label>
                                        <input type="text" id="booking_contact_number" name="booking_contact_number" value="{{ $hotel_package->booking_contact_number }}" class="form-control" placeholder="Booking Contact Number">
                                        @if($errors->has('booking_contact_number'))
                                            <span class="text-danger"> {{ $errors->first('booking_contact_number') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">                                        
                                    <div class="form-group">
                                        <label for="status" class="control-label mb-10"> Status <span class="text-danger" title="Required">*</span></label>
                                        <select id="status" name="status" class="form-control" required>
                                            <option value="0" @if($hotel_package->status == 0) selected @endif>Pending</option>
                                            <option value="1" @if($hotel_package->status == 1) selected @endif>Success</option>
                                            <option value="2" @if($hotel_package->status == 2) selected @endif>Cancel</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">                                        
                                    <div class="form-group">
                                        <label for="package_status" class="control-label mb-10">Package Status <span class="text-danger" title="Required">*</span></label>
                                        <select id="package_status" name="package_status" class="form-control" required>
                                            <option value="0" @if($hotel_package->package_status == 0) selected @endif>Invisible</option>
                                            <option value="1" @if($hotel_package->package_status == 1) selected @endif>Visible</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">                                        
                                    <div class="form-group">
                                        <label for="facebook_page" class="control-label mb-10"> Facebook Page </label>
                                        <input type="text" id="facebook_page" name="facebook_page" value="{{ $hotel_package->facebook_page }}" class="form-control" placeholder="Facebook Page">
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
                                        <input type="time" id="hotel_check_in_time" name="hotel_check_in_time" value="{{ date('H:i:s', strtotime($hotel_package->hotel_check_in_time)) }}" class="form-control" placeholder="Hotel Check In Time" required>
                                        @if($errors->has('hotel_check_in_time'))
                                            <span class="text-danger"> {{ $errors->first('hotel_check_in_time') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">                                        
                                    <div class="form-group">
                                        <label for="hotel_check_out_time" class="control-label mb-10"> Hotel Check Out Time <span class="text-danger" title="Required">*</span></label>
                                        <input type="time" id="hotel_check_out_time" name="hotel_check_out_time" value="{{ date('H:i:s', strtotime($hotel_package->hotel_check_out_time)) }}" class="form-control" placeholder="Hotel Check Out Time" required>
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
                                                <option value="{{ $amenity->id }}"  @if(in_array($amenity->id, json_decode($hotel_package->facilities))) selected @endif>{{ $amenity->name }}</option>
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
                                        <textarea class="form-control" id="booking_policy" name="booking_policy" placeholder="Booking Policy" rows="3">{{ $hotel_package->booking_policy }}</textarea>
                                        @if($errors->has('booking_policy'))
                                            <span class="text-danger"> {{ $errors->first('booking_policy') }}</span>
                                        @endif
                                    </div>
                                </div>  
                                <div class="col-md-6">                                        
                                    <div class="form-group">
                                        <label for="cancellation_policy" class="control-label mb-10"> Cancellation Policy <span class="text-danger" title="Required">*</span></label>                                            
                                        <textarea class="form-control" id="cancellation_policy" name="cancellation_policy" placeholder="Cancellation Policy" rows="3">{{ $hotel_package->cancellation_policy }}</textarea>
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
                                                <div id="hotelImgPreview" style="background-image: url(http://quicarbd.com/{{ $hotel_package->hotel_image }});"></div>
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
                                                <div id="roomImgPreview" style="background-image: url(http://quicarbd.com/{{ $hotel_package->room_image }});"></div>
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
