@extends('quicarbd.admin.layout.admin')
@section('title','Ride Details')
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
            <li><a href="#">Ride</a></li>
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
                        <h6 class="txt-dark capitalize-font"><i class="fa fa-car mr-10"></i>Ride Details</h6> 
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
                                                    <label for="name" class="control-label mb-10">Starting District</label>
                                                    <input type="text" id="name" name="name" value="{{ $helper->getDistrict($ride->starting_district) }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Starting City</label>                                            
                                                    <input type="phone" id="phone" value="{{ $helper->getCity($ride->starting_city) }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">                                        
                                                <div class="form-group">
                                                    <label for="name" class="control-label mb-10">Destination District</label>
                                                    <input type="text" id="name" name="name" value="{{ $helper->getDistrict($ride->destination_district) }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Destination City</label>                                            
                                                    <input type="phone" id="phone" value="{{ $helper->getCity($ride->destination_city) }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">                                        
                                                <div class="form-group">
                                                    <label for="name" class="control-label mb-10">Starting Area</label>
                                                    <input type="text" id="name" name="name" value="{{ $ride->startig_area }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Destination Area</label>                                            
                                                    <input type="phone" id="phone" value="{{ $ride->destination_area }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Car Type</label>                                            
                                                    <input type="phone" id="phone" value="{{ $helper->getCarType($ride->car_type) }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Extra Note</label>                                            
                                                    <input type="phone" id="phone" value="{{$ride->extra_note }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Round Way</label>                                            
                                                    <input type="phone" id="phone" value="{{ $ride->rown_way == 0 ? 'No' : 'Yes' }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Return Time For Round Way</label>                                            
                                                    <input type="phone" id="phone" value="{{ date('Y-m-d H:i:s a', strtotime($ride->return_time_for_round_way)) }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Start Time</label>                                            
                                                    <input type="phone" id="phone" value="{{ date('Y-m-d H:i:s a', strtotime($ride->start_time)) }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Status</label>                                            
                                                    <input type="phone" id="phone" value="{{ getStatus($ride->status) }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Payment Status</label>                                            
                                                    <input type="phone" id="phone" value="{{ $ride->payment_status == 0 ? 'Unpaid' : 'Paid' }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">TNX ID</label>                                            
                                                    <input type="phone" id="phone" value="{{ $ride->tnx_id }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Payment Complete Time</label>                                            
                                                    <input type="phone" id="phone" @if($ride->payment_complete_time != null) value="{{ date('Y-m-d H:i:s a', strtotime($ride->payment_complete_time)) }}" @endif class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Cancel By</label>                                            
                                                    <input type="phone" id="phone" value="{{ $ride->cancel_by == 0 ? 'User' : 'Partner' }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">User</label>                                            
                                                    <input type="phone" id="phone" value="{{ $helper->getUser($ride->user_id) }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Accepted Bidding Time</label>                                            
                                                    <input type="phone" id="phone" @if($ride->accepted_bitting_time != null) value="{{ date('Y-m-d H:i:s a', strtotime($ride->accepted_bitting_time)) }}" @endif class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Driver Cost Bear</label>                                            
                                                    <input type="phone" id="phone" value="{{ $ride->driver_cost_bear == 0 ? 'No' : 'Yes' }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Review</label>                                            
                                                    <input type="phone" id="phone" value="{{ $ride->review_give }}" class="form-control" readonly>
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
@php 
    function getStatus($status) {
       if ($status == 1) {
        echo 'Waiting for Bid';
       } else if ($status == 2) {
        echo 'Cancel Request';
       } else if ($status == 3) {
        echo 'Start Request';
       } else if ($status == 4) {
        echo 'Bit Accepted';
       } else if ($status == 5) {
        echo 'Completed';
       }
    }
@endphp
@endsection
@section('scripts')
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
