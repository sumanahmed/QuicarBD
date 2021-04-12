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
                                                    <td>
                                                        @if($ride->driver_id != null)
                                                            {{ $ride->driver_name }} <br/>{{ $ride->driver_phone }}
                                                        @else
                                                            Not Assigned
                                                        @endif
                                                    </td>  
                                                    <td>{{ $ride->bit_amount }}</td>
                                                    <td>{{ $ride->rown_way == 0 ? 'One Way' : 'Round Way' }}</td>
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <a href="{{ route('ride.details', $ride->id) }}" target="_blank" class="btn btn-xs btn-info" title="Details"><i class="fa fa-eye"></i></a>
                                                        <a href="#" id="cancelModal" data-toggle="modal" data-target="#showCancelModal" data-ride_id="{{ $ride->id }}" class="btn btn-xs btn-danger" title="Cancel"><i class="fa fa-remove"></i></a>
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
<div class="modal fade" id="showCancelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
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
                        <input type="hidden" id="ride_id" />
                        <span class="text-danger reasonError"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="sendReason">Save</button>
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
