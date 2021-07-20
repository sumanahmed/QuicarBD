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
                    <div class="panel-header" style="border-bottom: 2px solid #ddd;margin-top:10px;">
                        <form action="{{ route('ride.complete') }}" method="get">
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
                                                    <td>{{ $ride->review_give }}</td>
                                                    <td>{{ $ride->driver_name }} <br/>{{ $ride->driver_phone }}</td>  
                                                    <td>{{ $ride->bit_amount }}</td>
                                                    <td>{{ $helper->getCarType($ride->car_type) }}</td>
                                                    <td>{{ $ride->rown_way == 0 ? 'One Way' : 'Round Way' }}</td>
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <a href="#" class="btn btn-xs btn-primary" id="upcomingRideSendNotification" data-toggle="modal" title="Notification" data-user_id="{{ $ride->user_id }}"  data-owner_id="{{ $ride->owner_id }}" data-ride_id="{{ $ride->id }}"><i class="fa fa-bell"></i></a> 
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
                                {{ $rides->links('pagination::bootstrap-4') }}
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
                        <label for="cancel_from" class="control-label mb-10">Cancel From <span class="text-danger text-bold" title="Required Field">*</span></label>
                        <select id="cancel_from" class="form-control">
                            <option value="0">User</option>
                            <option value="1">Partner</option>
                            <option value="2">Admin</option>
                        </select>
                        <input type="hidden" id="ride_id" />
                        <span class="text-danger cancelFromError"></span>
                    </div>
                    <div class="form-group">
                        <label for="charge_apply" class="control-label mb-10">Charge Apply <span class="text-danger text-bold" title="Required Field">*</span></label>
                        <select id="charge_apply" class="form-control">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                        <span class="text-danger chargeApplyError"></span>
                    </div>
                    <div class="form-group">
                        <label for="reason" class="control-label mb-10">Reason <span class="text-danger text-bold" title="Required Field">*</span></label>
                        <textarea id="reason" class="form-control" placeholder="Enter cancel reason.."></textarea>
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

<!-- Notification Modal -->
<div id="upcomingRideSendNotificationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <input type="hidden" name="owner_id" id="owner_id" />
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
                <button type="button" class="btn btn-xs btn-primary" id="upcomingRideNotificationSend">Send</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
	<script src="{{ asset('quicarbd/admin/js/reason.js') }}"></script>
@endsection
