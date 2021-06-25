@extends('quicarbd.admin.layout.admin')
@section('title','Ongoing')
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
                <li class="active"><span>Cancel</span></li>
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
                        <h6 class="panel-title txt-dark">Car Package Cancel</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-header" style="border-bottom: 2px solid #ddd;margin-top:10px;">
                        <form action="{{ route('car_package_order.cancel') }}" method="get">
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
                                <table class="table table-hover display pb-30" >
                                    <thead>
                                        <tr>
                                            <th>Travel Date & Time</th>
                                            <th>Package</th>
                                            <th>User</th>
                                            <th>Partner</th>
                                            <th>Price</th>
                                            <th>Cancel By</th>
                                            <th>Total Cancel</th>
                                            <th>Reason</th>
                                            <th>Booking ID</th>
                                            <th>Car</th>
                                            <th>Payment Status</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Travel Date & Time</th>
                                            <th>Package</th>
                                            <th>User</th>
                                            <th>Partner</th>
                                            <th>Price</th>
                                            <th>Cancel By</th>
                                            <th>Total Cancel</th>
                                            <th>Reason</th>
                                            <th>Booking ID</th>
                                            <th>Car</th>
                                            <th>Payment Status</th>
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
                                                    $cancel_reason = \App\Models\BidCancelList::find($order->cancellation_reason)->name;
                                                @endphp
                                                <tr class="partner-{{ $order->id }}">                                                
                                                    <td>{{ date('Y-m-d H:i:s a', strtotime($order->travel_date)) }}</td>
                                                    <td>{{ $order->name }}</td>
                                                    <td><a href="{{ route('user.details', $order->user_id) }}">{{ $order->user_name }} <br/>{{ $order->user_phone }}</a></td>  
                                                    <td><a href="{{ route('partner.details', $order->owner_id) }}">{{ $order->owner_name }} <br/>{{ $order->owner_phone }}</a></td>  
                                                    <td>{{ $order->price }}</td>
                                                    <td>{{ $order->cancel_by == 0 ? 'User' : 'Partner' }}</td>
                                                    <td>{{ $total_cancel }}</td>
                                                    <td>{{ $cancel_reason }}</td>
                                                    <td>{{ $order->booking_id }}</td>
                                                    <td>{{ $order->carRegisterNumber }}</td>
                                                    <td>{{ $order->payment_status == 1 ? 'Paid' : 'Unpaid' }}</td>
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <a href="{{ route('car_package_order.details', $order->id) }}" target="_blank" class="btn btn-xs btn-info" title="Details"><i class="fa fa-eye"></i></a>                                                        
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
                                {{ $orders->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>	
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
