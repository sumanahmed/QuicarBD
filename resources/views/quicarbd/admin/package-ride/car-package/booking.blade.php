@extends('quicarbd.admin.layout.admin')
@section('title','Booking')
@section('content')
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Package Ride</a></li>
                <li><a href="#">Car Package</a></li>
                <li class="active"><span>Booking</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
    <!-- /Title -->    
    <!-- Row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">Car Package Booking</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-header" style="border-bottom: 2px solid #ddd;margin-top:10px;">
                        <form action="{{ route('car_package_order.booking') }}" method="get">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Phone</label>                                            
                                        <input type="text" name="phone" @if(isset($_GET['phone'])) value="{{ $_GET['phone'] }}" @endif placeholder="Enter Phone.." class="form-control" />
                                    </div>
                                </div>  
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Booking Date</label>                                            
                                        <input type="date" name="booking_date" @if(isset($_GET['booking_date'])) value="{{ $_GET['booking_date'] }}" @endif class="form-control" />
                                    </div>
                                </div>  
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Travel Date</label>                                            
                                        <input type="date" name="travel_date" @if(isset($_GET['travel_date'])) value="{{ $_GET['travel_date'] }}" @endif  class="form-control" />
                                    </div>
                                </div>    
                                <div class="col-md-2">
                                    <div class="form-group" style="margin-top:30px;">
                                        <button type="submit" class="btn btn-primary btn-sm">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="panel-body">
                        <div class="table-wrap">
                            <div class="table-responsive">
                                <table id="datable_1" class="table table-hover display pb-30" >
                                    <thead>
                                        <tr>
                                            <th>Request Date & Time</th>
                                            <th>Travel Date & Time</th>
                                            <th>Package</th>
                                            <th>User</th>
                                            <th>Partner</th>
                                            <th>Price</th>
                                            <th>Car</th>
                                            <th>Status</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Request Date & Time</th>
                                            <th>Travel Date & Time</th>
                                            <th>Package</th>
                                            <th>User</th>
                                            <th>Partner</th>
                                            <th>Price</th>
                                            <th>Car</th>
                                            <th>Status</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="partnerData">
                                        @if(isset($bookings) && count($bookings) > 0)
                                            @foreach($bookings as $booking)
                                                <tr class="partner-{{ $booking->id }}">
                                                    <td>{{ date('Y-m-d H:i:s a', strtotime($booking->created_at)) }}</td>                                                  
                                                    <td>{{ date('Y-m-d H:i:s a', strtotime($booking->travel_date)) }}</td>
                                                    <td>{{ $booking->name }}</td>
                                                    <td><a href="{{ route('user.details', $booking->user_id) }}">{{ $booking->user_name }} <br/>{{ $booking->user_phone }}</a></td>  
                                                    <td><a href="{{ route('partner.details', $booking->owner_id) }}">{{ $booking->owner_name }} <br/>{{ $booking->owner_phone }}</a></td>  
                                                    <td>{{ $booking->price }}</td>
                                                    <td>{{ $booking->carRegisterNumber }}</td>
                                                    <td>{{ getStatus($booking->status, $booking->payment_status) }}</td>
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <a href="{{ route('car_package_order.details', $booking->id) }}" target="_blank" class="btn btn-xs btn-info" title="Details"><i class="fa fa-eye"></i></a>
                                                        <a href="#" id="carPackageCancelModal" data-toggle="modal" data-package_order_id="{{ $booking->id }}" class="btn btn-xs btn-danger" title="Cancel"><i class="fa fa-remove"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center">No Data Found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                {{ $bookings->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>	
        </div>
    </div>
</div>
<div class="modal fade" id="showCarPackageCancelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="exampleModalLabel1">Cancel Ride</h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="reason" class="control-label mb-10">Reason <span class="text-danger text-bold" title="Required Field">*</span></label>
                        <textarea id="reason" class="form-control" placeholder="Enter cancel reason.."></textarea>
                        <input type="hidden" id="package_order_id" />
                        <span class="text-danger reasonError"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="carPackageSendReason">Save</button>
            </div>
        </div>
    </div>
</div>
@php 
    function getStatus($status, $paymentStatus)  {
        if ($status == 0) {
            echo 'Waiting for partner accept';
        } else if ($status == 1 && $paymentStatus == 0) {
            echo 'Accepted & waiting for user payment';
        } 
    }
@endphp
@endsection
@section('scripts')
	<script src="{{ asset('quicarbd/admin/js/reason.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
