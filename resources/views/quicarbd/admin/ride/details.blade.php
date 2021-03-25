@extends('quicarbd.admin.layout.admin')
@section('title','Ride Details')
@section('content')
@php 
    $helper = new App\Http\Lib\Helper;
    $ride_detail = \App\Models\RideBiting::select('ride_biting.*','cars.carRegisterNumber')->leftjoin('cars','ride_biting.car_id','cars.id')->where('ride_id', $ride->id)->first();
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
                                                    <label for="name" class="control-label mb-10">Starting Area</label>
                                                    <input type="text" id="name" name="name" value="{{ $ride->startig_area }}" class="form-control" readonly>
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
                                                    <label for="phone" class="control-label mb-10">Trip Type</label>                                            
                                                    <input type="phone" id="phone" value="{{ $ride->rown_way == 0 ? 'One Way' : 'Round Trip' }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            @if($ride->rown_way != 0)
                                                @php 
                                                    $start = date_create(date('Y-m-d', strtotime($ride->start_time)));
                                                    $end   = date_create(date('Y-m-d', strtotime($ride->return_time_for_round_way)));
                                                    $total_day = date_diff($end,$start)->format('%a');
                                                @endphp
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="phone" class="control-label mb-10">Total Day</label>                                            
                                                        <input type="phone" id="phone" value="{{ $total_day }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Start Time</label>                                            
                                                    <input type="phone" id="phone" value="{{ date('Y-m-d H:i:s a', strtotime($ride->start_time)) }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Return Time For Round Way</label>                                            
                                                    <input type="phone" id="phone" @if($ride->return_time_for_round_way != null) value="{{ date('Y-m-d H:i:s a', strtotime($ride->return_time_for_round_way)) }}" @endif class="form-control" readonly>
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
                                                    <label for="phone" class="control-label mb-10">Car Registration Number</label>                                            
                                                    <input type="phone" id="phone" @if($ride_detail != null) value="{{ $ride_detail->carRegisterNumber }}" @endif class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Car Cost Bear</label>                                            
                                                    <input type="phone" id="phone" value="{{ $ride->car_all_cost_bear == 0 ? 'Car Body Rent Only' : 'Including All Cost' }}" class="form-control" readonly>
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
            @if($ride->status == 5) 
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
            @if($ride->status == 2) 
                @php 
                    $cancel_reason = \App\Models\BidCancelList::find($ride->cancellation_id)->name;
                @endphp
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="txt-dark capitalize-font"><i class="fa fa-car mr-10"></i>Cancel Ride Details</h6> 
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
                                                        <input type="phone" id="phone" value="{{ $ride->cancel_by == 0 ? 'User' : 'Partner' }}" class="form-control" readonly>
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
                                                        <input type="phone" id="phone" value="{{ date('Y-m-d H:i:s a', strtotime($ride->cancellation_time)) }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                @if($ride_detail != null)
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
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="review_give" class="control-label mb-10">Review</label>                                            
                                                            <input type="phone" id="review_give" @if($ride->review_give != 0) value="{{ $ride->review_give }}" @else value="No Review" @endif class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                @endif
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
