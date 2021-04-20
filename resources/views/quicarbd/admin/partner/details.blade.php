@extends('quicarbd.admin.layout.admin')
@section('title','Partner')
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
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="nid" class="control-label mb-10">NID No <span class="text-danger" title="Required">*</span></label>                                            
                                                    <input type="nid" id="nid" name="nid" value="{{ $partner->nid }}" placeholder="Enter NID Number" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
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
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="account_status" class="control-label mb-10">Account Status <span class="text-danger" title="Required">*</span></label>                                            
                                                    <select id="account_status" name="account_status" class="form-control selectable" readonly>
                                                        <option selected disabled>Select</option>                                                            
                                                        <option value="0" @if($partner->account_status == 0) selected @endif>Pending</option>                                                            
                                                        <option value="1" @if($partner->account_status == 1) selected @endif>Active</option>                                                            
                                                        <option value="2" @if($partner->account_status == 2) selected @endif>Cancel</option>                                                                  
                                                    </select>
                                                    @if($errors->has('account_status'))
                                                        <span class="text-danger"> {{ $errors->first('account_status') }}</span>
                                                    @endif
                                                </div>
                                            </div>                              
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="service_location_district" class="control-label mb-10">Service Location Disitrict <span class="text-danger" title="Required">*</span></label>                                            
                                                    <input type="text" id="service_location_district" value="{{ $district_name }}" class="form-control" readonly>
                                                </div>
                                            </div>                            
                                        </div>
                                        <div class="row">
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
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="img1" class="control-label mb-10">Image </label>  
                                                    <div class="avatar-upload">
                                                        <div class="avatar-edit">
                                                            <input type='file' name="img" id="img1Upload" accept=".png, .jpg, .jpeg" required/>
                                                            <label class="img-popup" src="http://quicarbd.com/mobileapi/asset/owner/{{ $partner->img }}"><i class="fa fa-eye"></i></label>
                                                        </div>
                                                        <div class="avatar-preview" style="width:100%">
                                                            <div id="img1Preview" style="background-image: url(http://quicarbd.com/mobileapi/asset/owner/{{ $partner->img }});"></div>
                                                        </div>
                                                    </div>
                                                    @if($errors->has('img'))
                                                        <span class="text-danger"> {{ $errors->first('img') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="img2" class="control-label mb-10">NID Front Pic </label>   
                                                    <div class="avatar-upload">
                                                        <div class="avatar-edit">
                                                            <input type='file' name="nid_font_pic" id="img2Upload" accept=".png, .jpg, .jpeg"/>
                                                            <label class="img-popup" src="http://quicarbd.com/mobileapi/asset/owner/{{ $partner->nid_font_pic }}"><i class="fa fa-eye"></i></label>
                                                        </div>
                                                        <div class="avatar-preview" style="width:100%">
                                                            <div id="img2Preview" style="background-image: url(http://quicarbd.com/mobileapi/asset/owner/{{ $partner->nid_font_pic }});"></div>
                                                        </div>
                                                    </div>
                                                    @if($errors->has('nid_font_pic'))
                                                        <span class="text-danger"> {{ $errors->first('nid_font_pic') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="img3" class="control-label mb-10">NID Back Pic </label>  
                                                    <div class="avatar-upload">
                                                        <div class="avatar-edit">
                                                            <input type='file' name="nid_back_pic" id="img3Upload" accept=".png, .jpg, .jpeg"/>
                                                            <label class="img-popup" src="http://quicarbd.com/mobileapi/asset/owner/{{ $partner->nid_back_pic }}"><i class="fa fa-eye"></i></label>
                                                        </div>
                                                        <div class="avatar-preview" style="width:100%">
                                                            <div id="img3Preview" style="background-image: url(http://quicarbd.com/mobileapi/asset/owner/{{ $partner->nid_back_pic }});"></div>
                                                        </div>
                                                    </div>
                                                    @if($errors->has('nid_back_pic'))
                                                        <span class="text-danger"> {{ $errors->first('nid_back_pic') }}</span>
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
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="txt-dark capitalize-font"><i class="fa fa-car mr-10"></i>Partner Account History</h6> 
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="table-wrap">
                            <div class="table-responsive">
                                <table id="datable_1" class="table table-hover display pb-30" >
                                    <thead>
                                        <tr>
                                            <th>Amount</th>
                                            <th>Quicar Charge</th>
                                            <th>Net Amount</th>
                                            <th>Type</th>
                                            <th>Income From</th>
                                            <th>Reason</th>
                                            <th>Date & Time</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Amount</th>
                                            <th>Quicar Charge</th>
                                            <th>Net Amount</th>
                                            <th>Type</th>
                                            <th>Income From</th>
                                            <th>Reason</th>
                                            <th>Date & Time</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($accounts as $account)
                                            @php 
                                                $db_time = DateTime::createFromFormat('Y-m-d H:i:s', $account->created_at, new DateTimeZone("UTC"));
                                                $formattedTime = $db_time->format('j M, Y h:i A');
                                            @endphp
                                            <tr>
                                                <td>{{ $account->amount }}</td>
                                                <td>{{ $account->quicar_charge }}</td>
                                                <td>{{ $account->net_amount }}</td>
                                                <td>{{ $account->type == 0 ? 'Debit' : 'Credit' }}</td>
                                                <td>{{ incomeFrom($account->income_from) }}</td>
                                                <td>{{ $account->reason_text }}</td>
                                                <td>{{ $formattedTime }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>	
        </div>
    </div>    
</div>
@php 
    function incomeFrom($type) {
       if ($type == 1) {
        echo 'Ride';
       } else if ($type == 2) {
        echo 'Car Package';
       } else if ($type == 3) {
        echo 'Hotel Package';
       } else if ($type == 4) {
        echo 'Travel Package';
       } else if ($type == 5) {
        echo 'Bonous';
       } else if ($type == 6) {
        echo 'Incentive';
       } else if ($type == 7) {
        echo 'Cashback';
       }
    }
@endphp
@endsection
@section('scripts')
	<script src="{{ asset('quicarbd/admin/js/partner.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
