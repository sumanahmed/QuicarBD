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
            <li><a href="#">Car Package</a></li>
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
                        <h6 class="panel-title txt-dark">Car Package Complete</h6>
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
                                            <th>Travel Date & Time</th>
                                            <th>Package</th>
                                            <th>User</th>
                                            <th>Partner</th>
                                            <th>Price</th>
                                            <th>Quicar Charge</th>
                                            <th>Booking ID</th>
                                            <th>Review</th>
                                            <th>Car</th>
                                            <th>Status</th>
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
                                            <th>Quicar Charge</th>
                                            <th>Booking ID</th>
                                            <th>Review</th>
                                            <th>Car</th>
                                            <th>Status</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="partnerData">
                                        @if(isset($orders) && count($orders) > 0)
                                            @foreach($orders as $order)
                                                <tr class="partner-{{ $order->id }}">                                                
                                                    <td>{{ date('Y-m-d H:i:s a', strtotime($order->travel_date)) }}</td>
                                                    <td>{{ $order->name }}</td>
                                                    <td><a href="{{ route('user.details', $order->user_id) }}">{{ $order->user_name }} <br/>{{ $order->user_phone }}</a></td>  
                                                    <td><a href="{{ route('partner.details', $order->owner_id) }}">{{ $order->owner_name }} <br/>{{ $order->owner_phone }}</a></td>  
                                                    <td>{{ $order->price }}</td>
                                                    <td>{{ $order->quicar_charge }}</td>
                                                    <td>{{ $order->booking_id }}</td>
                                                    <td>{{ $order->review_give }}</td>
                                                    <td>{{ $order->carRegisterNumber }}</td>
                                                    <td>Confirmed</td>
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
