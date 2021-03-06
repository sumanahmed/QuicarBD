@extends('quicarbd.admin.layout.admin')
@section('title','Travel Package')
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
        <div class="col-md-md-md-md-lg-3 col-md-4 col-sm-4 col-xs-12">
        </div>
        <!-- Breadcrumb -->
        <div class="col-md-md-md-md-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Package</a></li>
            <li class="active"><span>Edit Travel Package</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
    <!-- /Title -->    
    <!-- Row -->
    <div class="row">
        <div class="col-md-md-md-md-sm-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="txt-dark capitalize-font"><i class="fa fa-hotel mr-10"></i>Travel Package Info</h6> 
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <form action="{{ route('travel_package.update', $travel_package->id) }}" method="post" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="tour_name" class="control-label mb-10">Tour Name </label>
                                        <input type="text" id="tour_name" name="tour_name" value="{{ $travel_package->tour_name }}" class="form-control"  placeholder="Tour Name" readonly>
                                        @if($errors->has('tour_name'))
                                            <span class="text-danger"> {{ $errors->first('tour_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="organizer_name" class="control-label mb-10">Organizer Name </label>
                                        <input type="text" id="organizer_name" name="organizer_name" value="{{ $travel_package->organizer_name }}" class="form-control" placeholder="Organizer Name" readonly>
                                        @if($errors->has('organizer_name'))
                                            <span class="text-danger"> {{ $errors->first('organizer_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="organizer_phone" class="control-label mb-10">Organizer Phone </label>
                                        <input type="text" id="organizer_phone" name="organizer_phone" value="{{ $travel_package->organizer_phone }}" class="form-control" placeholder="Organizer Phone" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" readonly>
                                        @if($errors->has('organizer_phone'))
                                            <span class="text-danger"> {{ $errors->first('organizer_phone') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="district_id" class="control-label mb-10">District </label>
                                        <<input type="text" name="organizer_phone" value="{{ $district }}" class="form-control" placeholder="Organizer Phone" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="spot_ids" class="control-label mb-10">Tour Spot </label>                                            
                                        <select id="spot_ids" name="spot_ids[]" class="form-control selectable" multiple readonly>                                                
                                            @foreach($spots as $spot)                                              
                                                <option value="{{ $spot->id }}" @if(in_array($spot->id, json_decode($travel_package->spot_ids))) selected @endif>{{ $spot->name }}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">                                        
                                    <div class="form-group">
                                        <label for="facilities" class="control-label mb-10">Travel Factilites </label>                                                                                                                               
                                        <textarea id="facilities" name="facilities" class="form-control" rows="4" placeholder="Travel Facilities" readonly>{{ $travel_package->facilities }}</textarea>
                                        @if($errors->has('facilities'))
                                            <span class="text-danger"> {{ $errors->first('facilities') }}</span>
                                        @endif
                                    </div>
                                </div> 
                                <div class="col-md-4">                                        
                                    <div class="form-group">
                                        <label for="details" class="control-label mb-10">Travel Details </label>                                                                                       
                                        <textarea id="details" name="details" class="form-control" rows="4" placeholder="Details" readonly>{{ $travel_package->details }}</textarea>
                                        @if($errors->has('details'))
                                            <span class="text-danger"> {{ $errors->first('details') }}</span>
                                        @endif
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-md-2">                                        
                                    <div class="form-group">
                                        <label for="starting_location" class="control-label mb-10"> Starting Location </label>                                        
                                        <input type="text" value="{{ $starting_location }}" class="form-control" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-2">                                        
                                    <div class="form-group">
                                        <label for="starting_city_id" class="control-label mb-10"> Starting City </label>                                        
                                        <input type="text" value="{{ $starting_city }}" class="form-control" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-4">                                        
                                    <div class="form-group">
                                        <label for="starting_address" class="control-label mb-10"> Starting Address </label>
                                        <input type="text" id="starting_address" name="starting_address" value="{{ $travel_package->starting_address }}" class="form-control" placeholder="Starting Address" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2">                                        
                                    <div class="form-group">
                                        <label for="day_night" class="control-label mb-10"> Day Night </label>
                                        <input type="text" id="day_night" name="day_night" value="{{ $travel_package->day_night }}" class="form-control" placeholder="Day Night" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2">                                        
                                    <div class="form-group">
                                        <label for="total_person" class="control-label mb-10"> Total Person </label>
                                        <input type="text" id="total_person" name="total_person" value="{{ $travel_package->total_person }}" class="form-control" placeholder="Total Person" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">                                        
                                    <div class="form-group">
                                        <label for="owner_id" class="control-label mb-10"> Partner </label>
                                        <input type="text" id="day_night" name="day_night" value="{{ $owner }}" class="form-control"  readonly>
                                    </div>
                                </div>                                  
                                <div class="col-md-2">                                        
                                    <div class="form-group">
                                        <label for="quicar_charge" class="control-label mb-10"> Qucar Charge </label>
                                        <input type="text" id="quicar_charge" name="quicar_charge" value="{{ $travel_package->quicar_charge }}" class="form-control" placeholder="Quicar Charge" readonly>                                        
                                        @if($errors->has('quicar_charge'))
                                            <span class="text-danger"> {{ $errors->first('quicar_charge') }}</span>
                                        @endif
                                    </div>
                                </div>  
                                <div class="col-md-2">                                        
                                    <div class="form-group">
                                        <label for="cost_per_person" class="control-label mb-10"> Cost Per Person </label>
                                        <input type="text" id="cost_per_person" name="cost_per_person" value="{{ $travel_package->cost_per_person }}" oninput="calculateCharge()" class="form-control" placeholder="Price" readonly>
                                        @if($errors->has('cost_per_person'))
                                            <span class="text-danger"> {{ $errors->first('cost_per_person') }}</span>
                                        @endif
                                    </div>
                                </div> 
                                <div class="col-md-2">                                        
                                    <div class="form-group">
                                        <label for="owner_get_per_person" class="control-label mb-10"> Owner Get </label>
                                        <input type="text" id="owner_get_per_person" name="owner_get_per_person" value="{{ $travel_package->owner_get_per_person }}" class="form-control" placeholder="Owner get" readonly>
                                        @if($errors->has('owner_get_per_person'))
                                            <span class="text-danger"> {{ $errors->first('owner_get_per_person') }}</span>
                                        @endif
                                    </div>
                                </div>                                 
                                <div class="col-md-2">                                        
                                    <div class="form-group">
                                        <label for="referrel_code" class="control-label mb-10"> Referrel Code </label>
                                        <input type="text" id="referrel_code" name="referrel_code" value="{{ $travel_package->referrel_code }}" class="form-control" placeholder="Referrel Code (Optional)" readonly>
                                        @if($errors->has('referrel_code'))
                                            <span class="text-danger"> {{ $errors->first('referrel_code') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">                                        
                                    <div class="form-group">
                                        <label for="cash_back_price" class="control-label mb-10">Cash Back Price</label>
                                        <input type="text" id="cash_back_price" name="cash_back_price" value="{{ $travel_package->cash_back_price }}" class="form-control" placeholder="Cash Back Price" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" readonly>
                                    </div>
                                </div>                                         
                                <div class="col-md-3">                                        
                                    <div class="form-group">
                                        <label for="cash_back_status" class="control-label mb-10">Cash Back Status </label>
                                        <select id="cash_back_status" name="cash_back_status" class="form-control">
                                            <option value="0" @if($travel_package->cash_back_status == 0) selected @endif>Pause</option>
                                            <option value="1" @if($travel_package->cash_back_status == 1) selected @endif>Active</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">                                        
                                    <div class="form-group">
                                        <label for="cash_back_staring_time" class="control-label mb-10">Cash Back Start Time</label>
                                        <input type="datetime-local" id="cash_back_staring_time" name="cash_back_staring_time" @if($travel_package->cash_back_staring_time != null) value="{{ date('Y-m-d\TH:i:s', strtotime($travel_package->cash_back_staring_time)) }}" @endif class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">                                        
                                    <div class="form-group">
                                        <label for="cash_back_ending_time" class="control-label mb-10">Cash Back End Time </label>
                                        <input type="datetime-local" id="cash_back_ending_time" name="cash_back_ending_time" @if($travel_package->cash_back_ending_time != null) value="{{ date('Y-m-d\TH:i:s', strtotime($travel_package->cash_back_ending_time)) }}" @endif class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2">                                        
                                    <div class="form-group">
                                        <label for="travel_starting_date" class="control-label mb-10"> Travel Starting Date </label>
                                        <input type="date" id="travel_starting_date" name="travel_starting_date" value="{{ $travel_package->travel_starting_date }}" class="form-control datePicker" placeholder="Referrel Code" readonly>
                                        @if($errors->has('travel_starting_date'))
                                            <span class="text-danger"> {{ $errors->first('travel_starting_date') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">                                        
                                    <div class="form-group">
                                        <label for="travel_starting_date_timestamp" class="control-label mb-10"> Travel Starting Time </label>
                                        <input type="time" id="travel_starting_date_timestamp" name="travel_starting_date_timestamp" value="{{ $travel_package->travel_starting_date_timestamp }}" class="form-control" placeholder="Referrel Code" readonly>
                                        @if($errors->has('travel_starting_date_timestamp'))
                                            <span class="text-danger"> {{ $errors->first('travel_starting_date_timestamp') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">                                        
                                    <div class="form-group">
                                        <label for="travel_package_rating" class="control-label mb-10"> Travel Package Rating</label>
                                        <input type="text" id="travel_package_rating" name="travel_package_rating" class="form-control" value="{{ $travel_package->travel_package_rating }}" placeholder="Travel Package Rating" readonly>
                                        @if($errors->has('travel_package_rating'))
                                            <span class="text-danger"> {{ $errors->first('travel_package_rating') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">                                        
                                    <div class="form-group">
                                        <label for="status" class="control-label mb-10"> Status </label>
                                        <select id="status" name="status" class="form-control" readonly>
                                            <option value="0" @if($travel_package->status == 0) selected @endif>Pending</option>
                                            <option value="1" @if($travel_package->status == 1) selected @endif>Success</option>
                                            <option value="2" @if($travel_package->status == 2) selected @endif>Cancel</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">                                        
                                    <div class="form-group">
                                        <label for="status_message" class="control-label mb-10"> Status Message </label>
                                        <input type="text" id="status_message" name="status_message" value="{{ $travel_package->status_message }}" class="form-control" placeholder="Status Message" readonly>
                                        @if($errors->has('status_message'))
                                            <span class="text-danger"> {{ $errors->first('status_message') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">                                        
                                    <div class="form-group">
                                        <label for="term_and_condition" class="control-label mb-10"> Terms & Condition </label>                                            
                                        <textarea class="form-control" id="term_and_condition" name="term_and_condition"  placeholder="Terms & Condition" rows="3" readonly>{{ $travel_package->term_and_condition }}</textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-md-md-4">
                                    <div class="form-group">
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
    <script src="{{ asset('quicarbd/admin/js/travel-package.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
