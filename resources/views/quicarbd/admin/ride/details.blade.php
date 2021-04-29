@extends('quicarbd.admin.layout.admin')
@section('title','Ride Details')
@section('content')
@php 
    $helper = new App\Http\Lib\Helper;
    if ($ride->status == 4) {
        $ride_detail = \App\Models\RideBiting::join('cars','ride_biting.car_id','cars.id')
                                        ->leftjoin('owners','ride_biting.owner_id','owners.id')
                                        ->select('ride_biting.*','cars.carRegisterNumber',
                                            'owners.name as owner_name','owners.phone as owner_phone'
                                        )
                                        //->where('ride_biting.ride_id', $ride->id)
                                        ->where('ride_biting.id', $ride->accepted_ride_bitting_id)
                                        ->first();
    } elseif ($ride->status == 2 && $ride->accepted_ride_bitting_id != null) {
        $ride_detail = \App\Models\RideBiting::join('cars','ride_biting.car_id','cars.id')
                                        ->leftjoin('owners','ride_biting.owner_id','owners.id')
                                        ->select('ride_biting.*','cars.carRegisterNumber',
                                            'owners.name as owner_name','owners.phone as owner_phone'
                                        )
                                        //->where('ride_biting.ride_id', $ride->id)
                                        ->where('ride_biting.id', $ride->accepted_ride_bitting_id)
                                        ->first();
    } elseif ($ride->status == 2) {
        $ride_detail = \App\Models\RideBiting::select('ride_biting.*','cars.carRegisterNumber','owners.name as owner_name','owners.phone as owner_phone')
                    ->join('cars','ride_biting.car_id','cars.id')
                    ->join('owners','ride_biting.owner_id','owners.id')
                    ->where('ride_biting.ride_id', $ride->id)
                    ->where('ride_biting.id', $ride->cancellation_bit_id)
                    ->first();
    } else {
        $ride_detail = \App\Models\RideBiting::select('ride_biting.*','cars.carRegisterNumber')
                    ->join('cars','ride_biting.car_id','cars.id')
                    ->where('ride_biting.ride_id', $ride->id)
                    ->first();
    }
    
    $current_date_time = \Carbon\Carbon::now()->toDateTimeString();
    
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
                                                    <input type="phone" value="{{ $helper->getCity($ride->starting_city) }}" class="form-control" readonly>
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
                                                    <input type="phone" value="{{ $helper->getCity($ride->destination_city) }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Destination Area</label>                                            
                                                    <input type="phone" value="{{ $ride->destination_area }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Car Type</label>                                            
                                                    <input type="phone" value="{{ $helper->getCarType($ride->car_type) }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Extra Note</label>                                            
                                                    <input type="phone" value="{{$ride->extra_note }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Trip Type</label>                                            
                                                    <input type="phone" value="{{ $ride->rown_way == 0 ? 'One Way' : 'Round Trip' }}" class="form-control" readonly>
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
                                                        <input type="phone" value="{{ $total_day }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Start Time</label>                                            
                                                    <input type="phone" value="{{ date('Y-m-d H:i:s a', strtotime($ride->start_time)) }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Return Time For Round Way</label>                                            
                                                    <input type="phone" @if($ride->return_time_for_round_way != null) value="{{ date('Y-m-d H:i:s a', strtotime($ride->return_time_for_round_way)) }}" @endif class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Status</label>                                            
                                                    <input type="phone" value="{{ getStatus($ride->status) }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Payment Status</label>                                            
                                                    <input type="phone" value="{{ $ride->payment_status == 0 ? 'Unpaid' : 'Paid' }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">TNX ID</label>                                            
                                                    <input type="phone" value="{{ $ride->tnx_id }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Payment Complete Time</label>                                            
                                                    <input type="phone" @if($ride->payment_complete_time != null) value="{{ date('Y-m-d H:i:s a', strtotime($ride->payment_complete_time)) }}" @endif class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">User Name</label>                                            
                                                    <input type="phone" value="{{ $helper->getUser($ride->user_id) }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Accepted Bidding Time</label>                                            
                                                    <input type="phone" @if($ride->accepted_bitting_time != null) value="{{ date('Y-m-d H:i:s a', strtotime($ride->accepted_bitting_time)) }}" @endif class="form-control" readonly>
                                                </div>
                                            </div>
                                            @if($ride->status == 4)
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="phone" class="control-label mb-10">Partner Name</label>                                            
                                                        <input type="phone" value="{{ $ride_detail->owner_name }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="phone" class="control-label mb-10">Partner Phone</label>                                            
                                                        <input type="phone" value="{{ $ride_detail->owner_phone }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="phone" class="control-label mb-10">Accepted Bid Amount</label>                                            
                                                        <input type="phone" value="{{ $ride_detail->bit_amount }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                @if($ride->booking_id != null)
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="phone" class="control-label mb-10">Booking ID</label>                                            
                                                            <input type="phone" value="{{ $ride->booking_id }}" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="phone" class="control-label mb-10">Car Registration Number</label>                                            
                                                        <input type="phone" @if($ride_detail != null) value="{{ $ride_detail->carRegisterNumber }}" @endif class="form-control" readonly>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($ride->rown_way == 1)
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="phone" class="control-label mb-10">Driver Cost Bear</label>                                            
                                                        <input type="phone" value="{{ $ride->driver_cost_bear == 0 ? 'No' : 'Yes' }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="phone" class="control-label mb-10">Car Cost Bear</label>                                            
                                                        <input type="phone" value="{{ $ride->car_all_cost_bear == 0 ? 'Car Body Rent Only' : 'Including All Cost' }}" class="form-control" readonly>
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
            @if($ride->start_time < $current_date_time) 
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
                                                        <input type="phone" value="{{ $ride_detail->quicar_charge }}" class="form-control" readonly>
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
                                                        <input type="phone" value="{{ cancelBy($ride->cancel_by) }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                
                                                @if($ride->cancel_by == 0 && $ride->accepted_ride_bitting_id != null)
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="phone" class="control-label mb-10">Bid Approved Partner Name</label>                                            
                                                            <input type="phone" value="{{ $ride_detail->owner_name }}" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="phone" class="control-label mb-10">Bid Approved Partner Phone</label>                                            
                                                            <input type="phone" value="{{ $ride_detail->owner_phone }}" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if($ride->cancel_by == 1)
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="phone" class="control-label mb-10">Cancel Partner Name</label>                                            
                                                            <input type="phone" value="{{ $ride_detail->owner_name }}" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="phone" class="control-label mb-10">Cancel Partner Phone</label>                                            
                                                            <input type="phone" value="{{ $ride_detail->owner_phone }}" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="phone" class="control-label mb-10">Cancel Reason</label>     
                                                        @if($ride->cancellation_id != null)
                                                            @php 
                                                                $cancel_reason = \App\Models\BidCancelList::find($ride->cancellation_id)->name;
                                                            @endphp
                                                            <input type="phone" value="{{ $cancel_reason }}" class="form-control" readonly>
                                                        @elseif($ride->cancel_reason != null)
                                                            <input type="phone" value="{{ $ride->cancel_reason }}" class="form-control" readonly>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="phone" class="control-label mb-10">Cancel Date & Time</label>                                            
                                                        <input type="phone" value="{{ date('Y-m-d H:i:s a', strtotime($ride->cancellation_time)) }}" class="form-control" readonly>
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
                                                            <input type="phone" value="{{ $ride_detail->quicar_charge }}" class="form-control" readonly>
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
            
            @php 
                $bittings = \App\Models\RideBiting::select('ride_biting.*','cars.carRegisterNumber',
                                                    'owners.name as owner_name','owners.phone as owner_phone',
                                                    'drivers.name as driver_name','drivers.phone as driver_phone'
                                                )
                                                ->leftjoin('owners','ride_biting.owner_id','owners.id')
                                                ->leftjoin('drivers','ride_biting.driver_id','drivers.id')
                                                ->leftjoin('cars','ride_biting.car_id','cars.id')
                                                ->where('ride_biting.ride_id', $ride->id)
                                                ->orderBy('ride_biting.id','DESC')
                                                ->get();
            @endphp
            @if(isset($bittings) && count($bittings) > 0)
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="txt-dark capitalize-font"><i class="fa fa-car mr-10"></i>Ride Bidding </h6> 
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
                                                <th>Partner</th>
                                                <th>Driver</th>
                                                <th>Car Registration No</th>
                                                <th>Bid Amount</th>
                                                <th>Quicar Charge</th>
                                                <th>Partner Get</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Partner</th>
                                                <th>Driver</th>
                                                <th>Car Registration No</th>
                                                <th>Bid Amount</th>
                                                <th>Quicar Charge</th>
                                                <th>Partner Get</th>
                                            </tr>
                                        </tfoot>
                                        <tbody id="userData">
                                            @foreach($bittings as $bitting)
                                                <tr>
                                                    <td><a href="{{ route('partner.details', $bitting->owner_id) }}">{{ $bitting->owner_name }} <br/>{{ $bitting->owner_phone }}</a></td>  
                                                    <td><a href="{{ route('driver.index', ['phone' => $bitting->driver_phone]) }}">{{ $bitting->driver_name }} <br/>{{ $bitting->driver_phone }}</a></td>
                                                    <td>{{ $bitting->carRegisterNumber }}</td>  
                                                    <td>{{ $bitting->bit_amount }}</td>  
                                                    <td>{{ $bitting->quicar_charge }}</td>  
                                                    <td>{{ $bitting->you_get }}</td>  
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
    
    function cancelBy($cancel_by) {
       if ($cancel_by == 0) {
            echo 'User';
       } else if ($cancel_by == 1) {
            echo 'Partner';
       } else if ($cancel_by == 2) {
            echo 'Admin';
       }
    }
@endphp
@endsection
@section('scripts')
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
