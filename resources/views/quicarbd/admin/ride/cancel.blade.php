@extends('quicarbd.admin.layout.admin')
@section('title','Cancel Ride')
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
            <li class="active"><span>Cancel Ride</span></li>
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
                        <h6 class="panel-title txt-dark">All Cancel Ride</h6>
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
                                            <th>Cancel By</th>
                                            <th>Total Cancel</th>
                                            <th>Reason</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Booking Date</th>
                                            <th>Travel Date</th>
                                            <th>User</th>
                                            <th>Partner</th>
                                            <th>Cancel By</th>
                                            <th>Total Cancel</th>
                                            <th>Reason</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="partnerData">
                                        @if(isset($rides) && count($rides) > 0)
                                            @foreach($rides as $ride)
                                                @php 
                                                    if ($ride->cancel_by == 0) {
                                                        $cancelBy = 'User';
                                                        $total_cancel = \App\Models\RideList::where('status', 2)->where('user_id', $ride->user_id)->count('id');
                                                    } else {
                                                        $cancelBy = 'Partner';
                                                        $total_cancel = \App\Models\RideList::where('status', 2)->where('owner_id', $ride->owner_id)->count('id');
                                                    }
                                                    
                                                    $db_time = DateTime::createFromFormat('Y-m-d H:i:s', $ride->created_at, new DateTimeZone("UTC"));
                                                    $bookingDate = $db_time->format('j M, Y h:i A');
                                                    $db_travel = DateTime::createFromFormat('Y-m-d H:i:s', $ride->start_time, new DateTimeZone("UTC"));
                                                    $travelDate = $db_travel->format('j M, Y h:i A');
                                                @endphp
                                                <tr class="partner-{{ $ride->id }}">
                                                    <td>{{ $bookingDate }}</td>                                                  
                                                    <td>{{ $travelDate }}</td>
                                                    <td>
                                                        @if($ride->user_id != null)
                                                            <a href="{{ route('user.details', $ride->user_id) }}">{{ $ride->user_name }} <br/>{{ $ride->user_phone }}</a>
                                                        @endif
                                                    </td>  
                                                    <td>
                                                        @if($ride->owner_id != null)
                                                            <a href="{{ route('partner.details', $ride->owner_id) }}">{{ $ride->owner_name }} <br/>{{ $ride->owner_phone }}</a>
                                                        @endif
                                                    </td>  
                                                    <td>{{ $cancelBy }}</td>
                                                    <td>{{ $total_cancel }}</td>
                                                    <td>{{ $ride->reason != null ? $ride->reason : '' }}</td>
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
