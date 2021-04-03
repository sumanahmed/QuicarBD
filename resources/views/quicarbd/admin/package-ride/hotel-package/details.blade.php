@extends('quicarbd.admin.layout.admin')
@section('title','Details')
@section('content')
@php 
    $helper = new App\Http\Lib\Helper;
@endphp
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-md-lg-3 col-md-4 col-sm-4 col-xs-12">
        </div>
        <!-- Breadcrumb -->
        <div class="col-md-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Package Ride</a></li>
                <li><a href="#">Hotel Package</a></li>
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
                        <h6 class="txt-dark capitalize-font"><i class="fa fa-car mr-10"></i>Hotel Package Details</h6> 
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-sm-12 col-xs-12">                                
                                <div class="form-wrap">
                                    <div class="form-body">     
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="hotel_name" class="control-label mb-10">Hotel or Resort Name <span class="text-danger" title="readonly">*</span></label>
                                                    <input type="text" id="hotel_name" name="hotel_name" value="{{ $detail->hotel_name }}" class="form-control" placeholder="Hotel or Resort Name" readonly>
                                                    @if($errors->has('hotel_name'))
                                                        <span class="text-danger"> {{ $errors->first('hotel_name') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="district_id" class="control-label mb-10">District <span class="text-danger" title="readonly">*</span></label>
                                                    <input type="text" id="hotel_name" name="hotel_name" value="{{ $district }}" class="form-control" placeholder="Hotel or Resort Name" readonly>                                    
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="city_id" class="control-label mb-10">City <span class="text-danger" title="readonly">*</span></label>
                                                    <input type="text" id="hotel_name" name="hotel_name" value="{{ $city }}" class="form-control" placeholder="Hotel or Resort Name" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">                                        
                                                <div class="form-group">
                                                    <label for="area" class="control-label mb-10"> Area <span class="text-danger" title="readonly">*</span></label>
                                                    <input type="text" id="area" name="area" value="{{ $detail->area }}" class="form-control" placeholder="Area" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">                                        
                                                <div class="form-group">
                                                    <label for="propertyType" class="control-label mb-10"> Property Type <span class="text-danger" title="readonly">*</span></label>                                            
                                                    <input type="text" id="area" name="area" value="{{ $property_type }}" class="form-control" placeholder="Area" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">                                        
                                                <div class="form-group">
                                                    <label for="room_type" class="control-label mb-10"> Room Type </label>
                                                    <input type="text" id="room_type" name="room_type" value="{{ $detail->room_type }}" class="form-control" placeholder="Room Type" readonly>
                                                    @if($errors->has('room_type'))
                                                        <span class="text-danger"> {{ $errors->first('room_type') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">                                        
                                                <div class="form-group">
                                                    <label for="room_size" class="control-label mb-10"> Room Size </label>
                                                    <input type="text" id="room_size" name="room_size" value="{{ $detail->room_size }}" class="form-control" placeholder="Room Size" readonly>
                                                    @if($errors->has('room_size'))
                                                        <span class="text-danger"> {{ $errors->first('room_size') }}</span>
                                                    @endif
                                                </div>
                                            </div> 
                                            <div class="col-md-4">                                        
                                                <div class="form-group">
                                                    <label for="hotel_website" class="control-label mb-10"> Hotel Website </label>
                                                    <input type="text" id="hotel_website" name="hotel_website" value="{{ $detail->hotel_website }}" class="form-control" placeholder="Hotel Website" readonly>
                                                    @if($errors->has('hotel_website'))
                                                        <span class="text-danger"> {{ $errors->first('hotel_website') }}</span>
                                                    @endif
                                                </div>
                                            </div> 
                                            <div class="col-md-4">                                        
                                                <div class="form-group">
                                                    <label for="referrel_code" class="control-label mb-10"> Referrel Code </label>
                                                    <input type="text" id="referrel_code" name="referrel_code" value="{{ $detail->referrel_code }}" class="form-control" placeholder="Referrel Code" readonly>
                                                    @if($errors->has('referrel_code'))
                                                        <span class="text-danger"> {{ $errors->first('referrel_code') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">                                        
                                                <div class="form-group">
                                                    <label for="owner_id" class="control-label mb-10"> Partner <span class="text-danger" title="readonly">*</span></label>
                                                    <input type="text" id="referrel_code" name="referrel_code" value="{{ $owner }}" class="form-control" placeholder="Referrel Code" readonly>
                                                </div>
                                            </div>     
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">                                        
                                                <div class="form-group">
                                                    <label for="quicar_charge" class="control-label mb-10"> Qucar Charge <span class="text-danger" title="readonly">*</span></label>
                                                    <input type="text" id="quicar_charge" name="quicar_charge" value="{{ $detail->quicar_charge }}" class="form-control" placeholder="Quicar Charge(%)" readonly>                                   
                                                </div>
                                            </div> 
                                            <div class="col-md-2">                                        
                                                <div class="form-group">
                                                    <label for="price" class="control-label mb-10"> Price <span class="text-danger" title="readonly">*</span></label>
                                                    <input type="text" id="price" name="price" oninput="calculateCharge()" value="{{ $detail->price }}" class="form-control" placeholder="Price" readonly>
                                                    @if($errors->has('price'))
                                                        <span class="text-danger"> {{ $errors->first('price') }}</span>
                                                    @endif
                                                </div>
                                            </div> 
                                            <div class="col-md-2">                                        
                                                <div class="form-group">
                                                    <label for="price" class="control-label mb-10"> Partner Get <span class="text-danger" title="readonly">*</span></label>
                                                    <input type="text" id="you_will_get" name="you_will_get" value="{{ $detail->you_will_get }}" class="form-control" placeholder="Partner Get" readonly>
                                                    @if($errors->has('you_will_get'))
                                                        <span class="text-danger"> {{ $errors->first('you_will_get') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-3">                                        
                                                <div class="form-group">
                                                    <label for="cash_back_price" class="control-label mb-10">Cash Back Price</label>
                                                    <input type="text" id="cash_back_price" name="cash_back_price" value="{{ $detail->cash_back_price }}" class="form-control" placeholder="Cash Back Price" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" readonly>
                                                </div>
                                            </div>                                         
                                            <div class="col-md-3">                                        
                                                <div class="form-group">
                                                    <label for="cash_back_status" class="control-label mb-10">Cash Back Status </label>
                                                    <select id="cash_back_status" name="cash_back_status" class="form-control">
                                                        <option value="0" @if($detail->cash_back_status == 0) selected @endif>Pause</option>
                                                        <option value="1" @if($detail->cash_back_status == 1) selected @endif>Active</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">                                        
                                                <div class="form-group">
                                                    <label for="cash_back_staring_time" class="control-label mb-10">Cash Back Start Time</label>
                                                    <input type="datetime-local" id="cash_back_staring_time" name="cash_back_staring_time"  @if($detail->cash_back_staring_time != null) value="{{ date('Y-m-d\TH:i:s', strtotime($detail->cash_back_staring_time)) }}" @endif class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">                                        
                                                <div class="form-group">
                                                    <label for="cash_back_ending_time" class="control-label mb-10">Cash Back End Time </label>
                                                    <input type="datetime-local" id="cash_back_ending_time" name="cash_back_ending_time" @if($detail->cash_back_staring_time != null) value="{{ date('Y-m-d\TH:i:s', strtotime($detail->cash_back_staring_time)) }}" @endif class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">                                        
                                                <div class="form-group">
                                                    <label for="booking_contact_number" class="control-label mb-10"> Booking Contact Number</label>
                                                    <input type="text" id="booking_contact_number" name="booking_contact_number" value="{{ $detail->booking_contact_number }}" class="form-control" placeholder="Booking Contact Number" readonly>
                                                    @if($errors->has('booking_contact_number'))
                                                        <span class="text-danger"> {{ $errors->first('booking_contact_number') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-3">                                        
                                                <div class="form-group">
                                                    <label for="status" class="control-label mb-10"> Status <span class="text-danger" title="readonly">*</span></label>
                                                    <select id="status" name="status" class="form-control" readonly>
                                                        <option value="0" @if($detail->status == 0) selected @endif>Pending</option>
                                                        <option value="1" @if($detail->status == 1) selected @endif>Success</option>
                                                        <option value="2" @if($detail->status == 2) selected @endif>Cancel</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">                                        
                                                <div class="form-group">
                                                    <label for="package_status" class="control-label mb-10">Package Status <span class="text-danger" title="readonly">*</span></label>
                                                    <select id="package_status" name="package_status" class="form-control" readonly>
                                                        <option value="0" @if($detail->package_status == 0) selected @endif>Invisible</option>
                                                        <option value="1" @if($detail->package_status == 1) selected @endif>Visible</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">                                        
                                                <div class="form-group">
                                                    <label for="facebook_page" class="control-label mb-10"> Facebook Page </label>
                                                    <input type="text" id="facebook_page" name="facebook_page" value="{{ $detail->facebook_page }}" class="form-control" placeholder="Facebook Page" readonly>
                                                    @if($errors->has('facebook_page'))
                                                        <span class="text-danger"> {{ $errors->first('facebook_page') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">                                        
                                                <div class="form-group">
                                                    <label for="hotel_check_in_time" class="control-label mb-10"> Hotel Check In Time <span class="text-danger" title="readonly">*</span></label>
                                                    <input type="time" id="hotel_check_in_time" name="hotel_check_in_time" value="{{ date('H:i:s', strtotime($detail->hotel_check_in_time)) }}" class="form-control" placeholder="Hotel Check In Time" readonly>
                                                    @if($errors->has('hotel_check_in_time'))
                                                        <span class="text-danger"> {{ $errors->first('hotel_check_in_time') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-3">                                        
                                                <div class="form-group">
                                                    <label for="hotel_check_out_time" class="control-label mb-10"> Hotel Check Out Time <span class="text-danger" title="readonly">*</span></label>
                                                    <input type="time" id="hotel_check_out_time" name="hotel_check_out_time" value="{{ date('H:i:s', strtotime($detail->hotel_check_out_time)) }}" class="form-control" placeholder="Hotel Check Out Time" readonly>
                                                    @if($errors->has('hotel_check_out_time'))
                                                        <span class="text-danger"> {{ $errors->first('hotel_check_out_time') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">                                     
                                            <div class="col-md-6">                                        
                                                <div class="form-group">
                                                    <label for="booking_policy" class="control-label mb-10"> Booking Policy <span class="text-danger" title="readonly">*</span></label>                                            
                                                    <textarea class="form-control" id="booking_policy" name="booking_policy" placeholder="Booking Policy" rows="3" readonly>{{ $detail->booking_policy }}</textarea>
                                                    @if($errors->has('booking_policy'))
                                                        <span class="text-danger"> {{ $errors->first('booking_policy') }}</span>
                                                    @endif
                                                </div>
                                            </div>  
                                            <div class="col-md-6">                                        
                                                <div class="form-group">
                                                    <label for="cancellation_policy" class="control-label mb-10"> Cancellation Policy <span class="text-danger" title="readonly">*</span></label>                                            
                                                    <textarea class="form-control" id="cancellation_policy" name="cancellation_policy" placeholder="Cancellation Policy" rows="3">{{ $detail->cancellation_policy }}</textarea>
                                                    @if($errors->has('cancellation_policy'))
                                                        <span class="text-danger"> {{ $errors->first('cancellation_policy') }}</span>
                                                    @endif
                                                </div>
                                            </div>  
                                            <div class="col-md-6">                                        
                                                <div class="form-group">
                                                    <label for="hotel_image" class="control-label mb-10">Hotel or Resort Image <span class="text-danger" title="readonly">*</span></label>                                                                                
                                                    <div class="avatar-upload">
                                                        <div class="avatar-edit">
                                                        </div>
                                                        <div class="avatar-preview" style="width:100%">
                                                            <div id="hotelImgPreview" style="background-image: url(http://quicarbd.com/{{ $detail->hotel_image }});"></div>
                                                        </div>
                                                    </div>
                                                    @if($errors->has('hotel_image'))
                                                        <span class="text-danger"> {{ $errors->first('hotel_image') }}</span>
                                                    @endif
                                                </div>
                                            </div>  
                                            <div class="col-md-6">                                        
                                                <div class="form-group">
                                                    <label for="room_image" class="control-label mb-10">Room Image <span class="text-danger" title="readonly">*</span></label>                                            
                                                    <div class="avatar-upload">
                                                        <div class="avatar-edit">
                                                        </div>
                                                        <div class="avatar-preview" style="width:100%">
                                                            <div id="roomImgPreview" style="background-image: url(http://quicarbd.com/{{ $detail->room_image }});"></div>
                                                        </div>
                                                    </div>
                                                    @if($errors->has('room_image'))
                                                        <span class="text-danger"> {{ $errors->first('room_image') }}</span>
                                                    @endif
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
            @if($detail->status == 3) 
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="txt-dark capitalize-font"><i class="fa fa-car mr-10"></i>Complete Ride Details</h6> 
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-sm-12 col-xs-12">                                
                                    <div class="form-wrap">
                                        <div class="form-body">     
                                            <div class="row">
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="name" class="control-label mb-10">Ride Amount</label>
                                                        <input type="text" id="name" name="name" value="{{ $ride_detail->bit_amount }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="phone" class="control-label mb-10">Quicar Charge</label>                                            
                                                        <input type="phone" id="phone" value="{{ $ride_detail->quicar_charge }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="name" class="control-label mb-10">Partner Get</label>
                                                        <input type="text" id="name" name="name" value="{{ $ride_detail->you_get }}" class="form-control" readonly>
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
            @endif	
            @if($detail->status == 2) 
                @php 
                    $cancel_reason = \App\Models\BidCancelList::find($detail->cancellation_reason)->name;
                @endphp
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="txt-dark capitalize-font"><i class="fa fa-car mr-10"></i>Cancel Package Ride Details</h6> 
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-sm-12 col-xs-12">                                
                                    <div class="form-wrap">
                                        <div class="form-body">     
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="phone" class="control-label mb-10">Cancel By</label>                                            
                                                        <input type="phone" id="phone" value="{{ $detail->cancel_by == 0 ? 'User' : 'Partner' }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="phone" class="control-label mb-10">Cancel Reason</label>                                            
                                                        <input type="phone" id="phone" value="{{ $cancel_reason }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="phone" class="control-label mb-10">Cancel Date & Time</label>                                            
                                                        <input type="phone" id="phone" value="{{ date('Y-m-d H:i:s a', strtotime($detail->cancelation_time)) }}" class="form-control" readonly>
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
            @endif	
        </div>
    </div>    
</div>
@php 
    function getStatus($status) {
       if ($status == 0) {
        echo 'Request send';
       } else if ($status == 1) {
        echo 'Request Accepted';
       } else if ($status == 2) {
        echo 'Request Cancel';
       } else if ($status == 3) {
        echo 'Request Start';
       } else if ($status == 4) {
        echo 'Request Finished';
       }
    }
@endphp
@endsection
@section('scripts')
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
