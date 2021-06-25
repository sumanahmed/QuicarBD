@extends('quicarbd.admin.layout.admin')
@section('title','Car Package Details')
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
                <li><a href="#">Car Package</a></li>
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
                        <h6 class="txt-dark capitalize-font"><i class="fa fa-car mr-10"></i>Car Package Details</h6> 
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
                                                    <label for="name" class="control-label mb-10">Package Name</label>
                                                    <input type="text" id="name" name="name" value="{{ $detail->name }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Price</label>                                            
                                                    <input type="phone" id="phone" value="{{  $detail->price }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">                                        
                                                <div class="form-group">
                                                    <label for="name" class="control-label mb-10">Pickup Address</label>
                                                    <input type="text" id="name" name="name" value="{{ $detail->pickUpAddress }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">                                        
                                                <div class="form-group">
                                                    <label for="name" class="control-label mb-10">Extra note</label>
                                                    <input type="text" id="name" name="name" value="{{ $detail->extra_note }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Travel Date</label>                                            
                                                    <input type="phone" id="phone" value="{{ date('Y-m-d', strtotime($detail->travel_date)) }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Status</label>                                            
                                                    <input type="phone" id="phone" value="{{ getStatus($detail->status) }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Payment Status</label>                                            
                                                    <input type="phone" id="phone" value="{{ $detail->payment_status == 0 ? 'Unpaid' : 'Paid' }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">TNX ID</label>                                            
                                                    <input type="phone" id="phone" value="{{ $detail->tnx_id }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Payment Complete Time</label>                                            
                                                    <input type="phone" id="phone" @if($detail->payment_complete_time != null) value="{{ date('Y-m-d H:i:s a', strtotime($detail->payment_complete_time)) }}" @endif class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">User</label>                                            
                                                    <input type="phone" id="phone" value="{{ $helper->getUser($detail->user_id) }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Ride Start Time</label>                                            
                                                    <input type="phone" id="phone" @if($detail->ride_start_time != null) value="{{ date('Y-m-d H:i:s a', strtotime($detail->ride_start_time)) }}" @endif class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Ride Finished Time</label>                                            
                                                    <input type="phone" id="phone" @if($detail->ride_finished_time != null) value="{{ date('Y-m-d H:i:s a', strtotime($detail->ride_finished_time)) }}" @endif class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Car Registration Number</label>                                            
                                                    <input type="phone" id="phone"value="{{ $detail->carRegisterNumber }}" class="form-control" readonly>
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
