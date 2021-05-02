@extends('quicarbd.admin.layout.admin')
@section('title','Bidding')
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
            <li class="active"><span>Ride Bidding</span></li>
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
                        <h6 class="panel-title txt-dark">All Bid</h6>
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
                                            <th>Partner</th>
                                            <th>Car</th>
                                            <th>Car Model</th>
                                            <th>Car Year</th>
                                            <th>Next Booking</th>
                                            <th>Bid Amount</th>
                                            <th>Quicar Charge</th>
                                            <th>Owner Get</th>
                                            <th>Status</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Partner</th>
                                            <th>Car</th>
                                            <th>Car Model</th>
                                            <th>Car Year</th>
                                            <th>Next Booking</th>
                                            <th>Bid Amount</th>
                                            <th>Quicar Charge</th>
                                            <th>Owner Get</th>
                                            <th>Status</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($biddings as $bidding)
                                            @php 
                                                $current_date_time = date('Y-m-d H:i:s'); 
                                                $next_booking = \App\Models\RideBiting::join('ride_list','ride_biting.ride_id','ride_list.id')
                                                                    ->where('ride_biting.owner_id', $bidding->owner_id)
                                                                    ->where('ride_biting.status', 1)
                                                                    ->where('ride_list.status', 4)
                                                                    ->where('ride_list.accepted_ride_bitting_id', '!=', null)
                                                                    ->where('ride_list.start_time', '>', $current_date_time)
                                                                    ->count('ride_list.id');
                                            @endphp
                                            <tr class="partner-{{ $bidding->id }}">
                                                <td>
                                                    <a href="{{ route('partner.details', $bidding->owner_id) }}">
                                                        {{ $bidding->owner_name }} <br/>{{ $bidding->owner_phone }}
                                                    </a>
                                                </td>
                                                <td>{{ $bidding->carRegisterNumber }}</td>
                                                <td>{{ $bidding->carModel }}</td>
                                                <td>{{ $bidding->carYear }}</td>
                                                <td>{{ $next_booking }}</td>
                                                <td>{{ $bidding->bit_amount }}</td>
                                                <td>{{ $bidding->quicar_charge }}</td>
                                                <td>{{ $bidding->you_get }}</td>
                                                <td>{{ getStatus($bidding->status) }}</td>
                                                <td style="vertical-align: middle;text-align: center;">
                                                    <a href="{{ route('ride.details', $bidding->ride_id) }}" target="_blank" class="btn btn-xs btn-info" title="Details"><i class="fa fa-eye"></i></a>
                                                    <a href="#" id="bidAmountChange" data-toggle="modal" data-id="{{ $bidding->id }}" data-bit_amount="{{ $bidding->bit_amount }}" data-quicar_charge="{{ $bidding->quicar_charge }}" data-you_get="{{ $bidding->you_get }}" class="btn btn-xs btn-primary" title="Cancel"><i class="fa fa-usd"></i></a>
                                                    <a href="#" id="bidCancelModal" data-toggle="modal" data-id="{{ $bidding->id }}" class="btn btn-xs btn-danger" title="Cancel"><i class="fa fa-remove"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
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
<div class="modal fade" id="bidAmountChangeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="exampleModalLabel1">Update Bid Amount</h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="district_id" class="control-label mb-10">Bid Amount </label>
                        <input type="text" id="bit_amount" class="form-control" readonly>
                        <input type="hidden" id="bid_id" />
                        <input type="hidden" id="quicar_charge" />
                        <input type="hidden" id="you_get" />
                    </div>
                    <div class="form-group">
                        <label for="new_bit_amount" class="control-label mb-10">New Bid Amount <span class="text-danger text-bold" title="Required Field">*</span></label>
                        <input type="text" id="new_bit_amount" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateBidAmount">Update</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showCancelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="exampleModalLabel1">Cancel Bid</h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="cancel_reason" class="control-label mb-10">Reasone <span class="text-danger text-bold" title="Required Field">*</span></label>
                        <textarea id="cancel_reason" name="cancel_reason" class="form-control" required></textarea>
                        <span class="text-danger errorCancelReason"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="sendCancelReason">Send</button>
            </div>
        </div>
    </div>
</div>
@php 
    function getStatus($status) {
       if ($status == 0) {
        echo 'Request Send';
       } else if ($status == 1) {
        echo 'Request Accept';
       } else if ($status == 2) {
        echo 'Bid Cancel';
       } else if ($status == 3) {
        echo 'Complete';
       } else if ($status == 4) {
        echo 'Select Another';
       }
    }
@endphp
@endsection
@section('scripts')
	<script src="{{ asset('quicarbd/admin/js/bidding.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
