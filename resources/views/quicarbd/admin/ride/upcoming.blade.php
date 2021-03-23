@extends('quicarbd.admin.layout.admin')
@section('title','Upcoming Bid')
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
            <li><a href="#">Car Rent</a></li>
            <li class="active"><span>Upcoming Bid</span></li>
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
                        <h6 class="panel-title txt-dark">All Upcoming Ride</h6>
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
                                            <th>Driver</th>
                                            <th>Price</th>
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
                                            <th>Driver</th>
                                            <th>Price</th>
                                            <th>Trip Type</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="partnerData">
                                        @if(isset($rides) && count($rides) > 0)
                                            @foreach($rides as $ride)
                                                <tr class="partner-{{ $ride->id }}">
                                                    <td>{{ date('Y-m-d', strtotime($ride->created_at)) }}</td>                                                  
                                                    <td>{{ date('Y-m-d', strtotime($ride->start_time)) }}</td>
                                                    <td><a href="{{ route('user.details', $ride->user_id) }}">{{ $ride->user_name }} <br/>{{ $ride->user_phone }}</a></td>  
                                                    <td><a href="{{ route('partner.details', $ride->owner_id) }}">{{ $ride->owner_name }} <br/>{{ $ride->owner_phone }}</a></td>  
                                                    <td><a href="{{ route('driver.details', $ride->driver_id) }}">{{ $ride->driver_name }} <br/>{{ $ride->driver_phone }}</a></td>  
                                                    <td>{{ $ride->bit_amount }}</td>
                                                    <td>{{ $ride->rown_way == 0 ? 'No' : 'Round Way' }}</td>
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <a href="{{ route('ride.details', $ride->id) }}" target="_blank" class="btn btn-xs btn-info" title="Details"><i class="fa fa-eye"></i></a>
                                                        <a href="#" id="cancelModal" data-toggle="modal" data-target="#showCancelModal" data-id="{{ $ride->id }}" class="btn btn-xs btn-danger" title="Cancel"><i class="fa fa-remove"></i></a>
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
