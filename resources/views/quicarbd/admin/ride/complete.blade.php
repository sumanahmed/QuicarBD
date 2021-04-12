@extends('quicarbd.admin.layout.admin')
@section('title','Complete Ride')
@section('content')
@php 
    $helper = new App\Http\Lib\Helper;
@endphp
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Car Rent</a></li>
            <li class="active"><span>Complete Ride</span></li>
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
                        <h6 class="panel-title txt-dark">All Complete Ride</h6>
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
                                            <th>Booking Date</th>
                                            <th>Travel Date</th>
                                            <th>User</th>
                                            <th>Partner</th>
                                            <th>Review</th>
                                            <th>Driver</th>
                                            <th>Price</th>
                                            <th>Car Type</th>
                                            <th>Trip Type</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Booking Date</th>
                                            <th>Travel Date</th>
                                            <th>User</th>
                                            <th>Partner</th>
                                            <th>Review</th>
                                            <th>Driver</th>
                                            <th>Price</th>
                                            <th>Car Type</th>
                                            <th>Trip Type</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="partnerData">
                                        @if(isset($rides) && count($rides) > 0)
                                            @foreach($rides as $ride)
                                                @php
                                                    $db_time = DateTime::createFromFormat('Y-m-d H:i:s', $ride->created_at, new DateTimeZone("UTC"));
                                                    $bookingDate = $db_time->format('j M, Y h:i A');
                                                    $db_travel = DateTime::createFromFormat('Y-m-d H:i:s', $ride->start_time, new DateTimeZone("UTC"));
                                                    $travelDate = $db_travel->format('j M, Y h:i A');
                                                @endphp
                                                <tr class="partner-{{ $ride->id }}">
                                                    <td>{{ $bookingDate }}</td>                                                  
                                                    <td>{{ $travelDate }}</td>
                                                    <td><a href="{{ route('user.details', $ride->user_id) }}">{{ $ride->user_name }} <br/>{{ $ride->user_phone }}</a></td>  
                                                    <td><a href="{{ route('partner.details', $ride->owner_id) }}">{{ $ride->owner_name }} <br/>{{ $ride->owner_phone }}</a></td>  
                                                    <td>{{ $ride->review_give != 0 ? $ride->review_give != 0 : '' }}</td>
                                                    <td>{{ $ride->driver_name }} <br/>{{ $ride->driver_phone }}</td>  
                                                    <td>{{ $ride->bit_amount }}</td>
                                                    <td>{{ $helper->getCarType($ride->car_type) }}</td>
                                                    <td>{{ $ride->rown_way == 0 ? 'No' : 'Round Way' }}</td>
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <a href="{{ route('ride.details', $ride->id) }}" target="_blank" class="btn btn-xs btn-info" title="Details"><i class="fa fa-eye"></i></a>                                                       
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
