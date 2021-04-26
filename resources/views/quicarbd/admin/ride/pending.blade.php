@extends('quicarbd.admin.layout.admin')
@section('title','Pending Request')
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
            <li class="active"><span>Pending Request</span></li>
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
                        <h6 class="panel-title txt-dark">All Pending Request</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-header" style="border-bottom: 2px solid #ddd;margin-top:10px;">
                        <form action="{{ route('ride.bid_request') }}" method="get">
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
                                            <th>Booking Date</th>
                                            <th>Travel Date</th>
                                            <th>User</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Total Bid</th>
                                            <th>Car Type</th>
                                            <th>Trip Type</th>
                                            <th>Visible Time</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Booking Date</th>
                                            <th>Travel Date</th>
                                            <th>User</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Total Bid</th>
                                            <th>Car Type</th>
                                            <th>Trip Type</th>
                                            <th>Visible Time</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="partnerData">
                                        @if(isset($rides) && count($rides) > 0)
                                            @foreach($rides as $ride)
                                                @php
                                                    $total_bid = \App\Models\RideBiting::where('ride_id',$ride->id)->count('id');
                                                    $db_time = DateTime::createFromFormat('Y-m-d H:i:s', $ride->created_at, new DateTimeZone("UTC"));
                                                    $bookingDate = $db_time->format('j M, Y h:i A');
                                                    $db_travel = DateTime::createFromFormat('Y-m-d H:i:s', $ride->start_time, new DateTimeZone("UTC"));
                                                    $travelDate = $db_travel->format('j M, Y h:i A');
                                                    if ($ride->ride_visiable_time != null) {
                                                        $db_ride_visiable_time = DateTime::createFromFormat('Y-m-d H:i:s', $ride->ride_visiable_time, new DateTimeZone("UTC"));
                                                        $ride_visiable_time = $db_ride_visiable_time->format('j M, Y h:i A');
                                                    }
                                                @endphp
                                                <tr class="partner-{{ $ride->id }}">
                                                    <td>{{ $bookingDate }}</td>                                                  
                                                    <td>{{ $travelDate }}</td>
                                                    <td><a href="{{ route('user.details', $ride->user_id) }}">{{ $ride->user_name }} <br/>{{ $ride->user_phone }}</a></td>  
                                                    <td>{{ $helper->getDistrict($ride->starting_district).",".$helper->getCity($ride->starting_city).",".$ride->startig_area }}</td>
                                                    <td>{{ $helper->getDistrict($ride->destination_district).",".$helper->getCity($ride->destination_city).",".$ride->destination_area }}</td>
                                                    <td><a target="_blank" class="btn btn-xs btn-warning" href="{{ route('ride.bidding', $ride->id) }}">{{ $total_bid }}</a></td>
                                                    <td>{{ $helper->getCarType($ride->car_type) }}</td>
                                                    <td>{{ $ride->rown_way == 0 ? 'One Way' : 'Round Way' }}</td>
                                                    <td>{{ $ride->ride_visiable_time != null ? $ride_visiable_time : '' }}</td>
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <!--<a href="#" class="btn btn-xs btn-primary" id="rideSendNotification" data-toggle="modal" title="Notification" data-user_id="{{ $ride->user_id }}" data-ride_id="{{ $ride->id }}"><i class="fa fa-bell"></i></a> -->
                                                        <a href="{{ route('ride.approve', $ride->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-check"></i></a> 
                                                        <a href="{{ route('ride.details', $ride->id) }}" target="_blank" class="btn btn-xs btn-info" title="Details"><i class="fa fa-eye"></i></a>
                                                        <a href="#" id="changeVisibleTime" data-toggle="modal" data-ride_id="{{ $ride->id }}" data-ride_visiable_time="{{ $ride_visiable_time }}" class="btn btn-xs btn-primary" title="Change Visible Time"><i class="fa fa-clock-o"></i></a>
                                                        <a href="#" id="cancelModal" data-toggle="modal" data-ride_id="{{ $ride->id }}" class="btn btn-xs btn-danger" title="Cancel"><i class="fa fa-remove"></i></a>
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
                                {{ $rides->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</div>
<!-- Notification Modal -->
<div id="rideSendNotificationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="exampleModalLabel1">Send Notification</h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="sms" class="control-label mb-10">Select Message </label>
                        <select class="form-control" name="sms" id="sms">
                            <option value="0">Select</option>
                            @foreach($sms as $tmp)
                                <option value="{{ $tmp->id }}">{{ $tmp->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="title" class="control-label mb-10">Title <span class="text-danger text-bold" title="Required Field">*</span></label>
                        <input type="text" name="title" id="title" class="form-control"placeholder="Enter Title" required>
                        <input type="hidden" name="ride_id" id="ride_id" />
                        <input type="hidden" name="user_id" id="user_id" />
                        <span class="errorTitle text-danger text-bold"></span>
                    </div>
                    <div class="form-group">
                        <label for="message" class="control-label mb-10">Message <span class="text-danger text-bold" title="Required Field">*</span></label>
                        <textarea class="form-control sms_message" name="message" id="message" placeholder="Enter your message"></textarea>
                        <span class="errorMessage text-danger text-bold"></span>
                    </div>
                    <div class="form-group">
                        <label for="for" class="control-label mb-10">For <span class="text-danger" title="Required">*</span></label>                                 
                        <select id="for" name="for" class="form-control">
                            <option value="1">User</option>
                            <option value="2">Partner</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="form-group col-md-3">                                
                                <input type="radio" name="notification" id="notification" value="1" checked>
                                <label class="col-form-label" for="notification">Notification</label>
                            </div>
                            <div class="form-group col-md-4">
                                <input type="radio" name="notification" id="sms_notification" value="2">
                                <label class="col-form-label" for="sms_notification">SMS & Notification </label>                                
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-xs btn-danger" id="smsDelete">Delete</button>
                <button type="button" class="btn btn-xs btn-success" id="smsDraftSave">Save as Draft</button>
                <button type="button" class="btn btn-xs btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-xs btn-primary" id="rideNotificationSend">Send</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="changeVisibleTimeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="exampleModalLabel1">Update Visible TIme</h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="reason" class="control-label mb-10">Visible Time <span class="text-danger text-bold" title="Required Field">*</span></label>
                        <input type="text" id="ride_visiable_time" class="form-control" readonly/>
                        <input type="hidden" id="ride_id" />
                    </div>
                    <div class="form-group">
                        <label for="reason" class="control-label mb-10">New Visible Time <span class="text-danger text-bold" title="Required Field">*</span></label>
                        <input type="datetime-local" id="new_visiable_time" class="form-control"/>
                        <span class="text-danger errorNewVisibleTime"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateRideVisibleTime">Update</button>
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
                        <textarea id="reason" class="form-control" placeholder="Enter cancel reason.." required></textarea>
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
