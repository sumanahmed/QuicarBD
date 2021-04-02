@extends('quicarbd.admin.layout.admin')
@section('title','Complete')
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
            <li><a href="#">Hotel Package</a></li>
            <li class="active"><span>Complete</span></li>
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
                        <h6 class="panel-title txt-dark">Hotel Package Complete</h6>
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
                                            <th>Check In/Out Time</th>
                                            <th>Hotel Name</th>
                                            <th>User</th>
                                            <th>Price</th>
                                            <th>Cancel By</th>
                                            <th>Total Cancel</th>
                                            <th>Reason</th>
                                            <th>Booking ID</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Check In/Out Time</th>
                                            <th>Hotel Name</th>
                                            <th>User</th>
                                            <th>Price</th>
                                            <th>Cancel By</th>
                                            <th>Total Cancel</th>
                                            <th>Reason</th>
                                            <th>Booking ID</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="partnerData">
                                        @if(isset($orders) && count($orders) > 0)
                                            @foreach($orders as $order)
                                                @php 
                                                    if ($order->cancel_by == 0) {
                                                        $cancelBy = 'User';
                                                        $total_cancel = \App\Models\CarPackageOrder::where('status', 2)->where('id', $order->id)->where('user_id', $order->user_id)->count('id');
                                                    } else {
                                                        $cancelBy = 'Partner';
                                                        $total_cancel = \App\Models\CarPackageOrder::where('status', 2)->where('id', $order->id)->where('owner_id', $order->owner_id)->count('id');
                                                    }
                                                @endphp
                                                <tr class="partner-{{ $order->id }}">
                                                    <td>{{ date('H:i:s a', strtotime($order->hotel_check_in_time)) }}<br/>{ date('H:i:s a', strtotime($order->hotel_check_out_time)) }}</td>
                                                    <td>{{ $order->hotel_name }}</td>
                                                    <td><a href="{{ route('user.details', $order->user_id) }}">{{ $order->user_name }} <br/>{{ $order->user_phone }}</a></td>  /td>  
                                                    <td>{{ $order->price }}</td>
                                                    <td>{{ $order->cancel_by == 0 ? 'User' : 'Partner' }}</td>
                                                    <td>{{ $total_cancel }}</td>
                                                    <td>{{ $order->cancellation_reason }}</td>
                                                    <td>{{ $order->booking_id }}</td>
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <a href="{{ route('hotel_package_order.details', $order->id) }}" target="_blank" class="btn btn-xs btn-info" title="Details"><i class="fa fa-eye"></i></a>"fa fa-remove"></i></a>
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
@endsection
@section('scripts')
	<script src="{{ asset('quicarbd/admin/js/reason.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
