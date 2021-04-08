@extends('quicarbd.admin.layout.admin')
@section('title','Partner')
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
            <li><a href="#">Partner</a></li>
            <li class="active"><span>Verification</span></li>
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
                        <h6 class="panel-title txt-dark">All Partner</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-header" style="border-bottom: 2px solid #ddd;margin-top:10px;">
                        <form action="{{ route('partner.account_type_change_request') }}" method="get">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="name" class="control-label mb-10">Name</label>                                            
                                        <input type="text" name="name" @if(isset($_GET['name'])) value="{{ $_GET['name'] }}" @endif placeholder="Name" class="form-control">
                                    </div>
                                </div> 
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="phone" class="control-label mb-10">Phone</label>                                            
                                        <input type="text" name="phone" @if(isset($_GET['phone'])) value="{{ $_GET['phone'] }}" @endif placeholder="Phone" class="form-control">
                                    </div>
                                </div> 
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="request_for" class="control-label mb-10">Request For</label>                                            
                                        <select name="request_for" class="form-control">
                                            <option value="100">Select</option>
                                            <option value="0" @if(isset($_GET['request_for']) && $_GET['request_for'] == 0) selected @endif>Car</option>    
                                            <option value="1" @if(isset($_GET['request_for']) && $_GET['request_for'] == 1) selected @endif>Hotel</option>    
                                            <option value="2" @if(isset($_GET['request_for']) && $_GET['request_for'] == 2) selected @endif>Travel</option>    
                                        </select>
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
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Current Account Type</th>
                                            <th>Request For</th>
                                            <th>Date & Time</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Current Account Type</th>
                                            <th>Request For</th>
                                            <th>Date & Time</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="partnerData">
                                        @if(isset($partners) && count($partners) > 0)
                                            @foreach($partners as $partner)
                                                @php 
                                                    $db_time = DateTime::createFromFormat('Y-m-d H:i:s', $partner->created_at, new DateTimeZone("UTC"));
                                                    $dateTime = $db_time->setTimeZone(new DateTimeZone("Asia/Dhaka"))->format('j M, Y h:i A');
                                                @endphp
                                                <tr class="partner-{{ $partner->id }}">
                                                    <td>{{ $partner->name }}</td>
                                                    <td>{{ $partner->phone }}</td>
                                                    <td>{{ checkAccountType($partner->account_type) }}</td>
                                                    <td>{{ requestFor($partner->request_for) }}</td>
                                                    <td>{{ $dateTime }}</td>
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <a href="#" class="btn btn-xs btn-raised btn-danger" data-toggle="modal" id="showRequestCancel" data-target="#requestCancelModal" data-id="{{ $partner->id }}" data-owner_id="{{ $partner->owner_id }}" title="Cancel"><i class="fa fa-remove"></i></a>
                                                        <a href="{{ route('partner.account_type_change_approve',['id'=>$partner->id,'which_acount'=>$partner->request_for,'owner_id'=>$partner->owner_id]) }}" 
                                                        class="btn btn-xs btn-success" title="Approve"><i class="fa fa-check"></i></a>
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
                                {{ $partners->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>	
        </div>
    </div>
    
    <!-- Request cancel Modal -->
    <div id="requestCancelModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title mb-10" id="exampleModalLabel">Are you sure to cancel ?</h5>
                    <input type="hidden" name="del_id"/>
                    <input type="hidden" id="owner_id"/>
                    <button type="button" class="btn btn-xs btn-danger btn-raised mr-2" id="requestCancel"><i class="fas fa-trash-alt"></i> Proceed</button>
                    <button type="button" class="btn btn-xs btn-warning btn-raised" data-dismiss="modal" aria-label="Close"><i class="fas fa-backspace"></i> Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
@php 
    function checkAccountType($account_type) {
        if ($account_type == 0) {
            echo "Car";
        } else if ($account_type == 1) {
            echo "Hotel";
        } else if ($account_type == 2) {
            echo "Travel";
        } else if ($account_type == 3) {
            echo "Car & Hotel";
        } else if ($account_type == 4) {
            echo "Car, Hotel & Travel";
        } else if ($account_type == 5) {
            echo "Hotel & Travel";
        } else if ($account_type == 6) {
            echo "Car & Travel";
        }
    }
    function requestFor($request_for) {
        if ($request_for == 0) {
            echo "Car";
        } else if ($request_for == 1) {
            echo "Hotel";
        } else if ($request_for == 2) {
            echo "Travel";
        }
    }
@endphp
@endsection
@section('scripts')
	<script src="{{ asset('quicarbd/admin/js/partner.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
