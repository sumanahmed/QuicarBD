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
                                            <th>Next Booking</th>
                                            <th>Bid Amount</th>
                                            <th>Quicar Charge</th>
                                            <th>Owner Get</th>
                                            <th>Status</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="partnerData">
                                        @if(isset($biddings) && count($biddings) > 0)
                                            @foreach($biddings as $bidding)
                                                @php 
                                                    $next_booking = \App\Models\RideBiting::where('owner_id', $bidding->owner_id)
                                                                        ->where('ride_id', '!=', $bidding->ride_id)
                                                                        ->where('status', 1)
                                                                        ->count('id');
                                                @endphp
                                                <tr class="partner-{{ $bidding->id }}">
                                                    <td>{{ $bidding->owner_name }} <br/>{{ $bidding->owner_phone }}</td>
                                                    <td>{{ $bidding->carRegisterNumber }}</td>
                                                    <td>{{ $next_booking }}</td>
                                                    <td>{{ $bidding->bit_amount }}</td>
                                                    <td>{{ $bidding->quicar_charge }}</td>
                                                    <td>{{ $bidding->you_get }}</td>
                                                    <td>{{ getStatus($bidding->status) }}</td>
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <a href="{{ route('ride.details', $bidding->ride_id) }}" target="_blank" class="btn btn-xs btn-info" title="Details"><i class="fa fa-eye"></i></a>
                                                        <a href="#" id="cancelModal" data-toggle="modal" data-target="#showCancelModal" data-id="{{ $bidding->id }}" class="btn btn-xs btn-danger" title="Cancel"><i class="fa fa-remove"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8" class="text-center">No Data Found</td>
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
                        <label for="district_id" class="control-label mb-10">District <span class="text-danger text-bold" title="Required Field">*</span></label>
                        <select id="district_id" class="form-control" required>
                            <option selected disabled>Reason</option>                                
                            <option value="1">Reason One</option>                                
                            <option value="2">Reason Two</option>                                
                        </select>
                        <span class="text-danger districtError"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="create">Save</button>
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
        echo 'Request Cancel';
       } else if ($status == 3) {
        echo 'Complete';
       }
    }
@endphp
@endsection
@section('scripts')
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
