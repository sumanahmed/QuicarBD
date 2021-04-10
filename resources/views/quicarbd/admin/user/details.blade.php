@extends('quicarbd.admin.layout.admin')
@section('title','User')
@section('content')
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-md-lg-3 col-md-4 col-sm-4 col-xs-12">
        </div>
        <!-- Breadcrumb -->
        <div class="col-md-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">User</a></li>
            <li class="active"><span>Details</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
    <!-- /Title -->    
    <!-- Row -->
    <div class="row">
        <div class="col-md-sm-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="txt-dark capitalize-font"><i class="fa fa-user mr-10"></i>Profile Info</h6> 
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-sm-12 col-xs-12">
                                <div class="form-wrap">
                                    <div class="form-body">     
                                        <div class="row">
                                            <div class="col-md-4">                                        
                                                <div class="form-group">
                                                    <label for="name" class="control-label mb-10">Name <span class="text-danger" title="Required">*</span></label>
                                                    <input type="text" id="name" name="name" value="{{ $user->name }}" placeholder="Enter Name" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Phone <span class="text-danger" title="Required">*</span></label>                                            
                                                    <input type="phone" id="phone" value="{{ $user->phone }}" name="phone" placeholder="Enter Phone Number" class="form-control" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="dob" class="control-label mb-10">Date of Birth <span class="text-danger" title="Required">*</span></label>                                            
                                                    <input type="date" id="dob" value="{{ $user->dob }}" name="dob" class="form-control datePicker" readonly>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="nid" class="control-label mb-10">NID No <span class="text-danger" title="Required">*</span></label>                                            
                                                    <input type="nid" id="nid" name="nid" value="{{ $user->nid }}" placeholder="Enter NID Number" class="form-control" readonly>
                                                </div>
                                            </div>                                   
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="district" class="control-label mb-10">Division <span class="text-danger" title="Required">*</span></label>                                            
                                                    <input type="text" id="division" value="{{ $user->division }}" name="district" class="form-control" readonly>
                                                </div>
                                            </div>                                    
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="district" class="control-label mb-10">Disitrict <span class="text-danger" title="Required">*</span></label>                                            
                                                    <input type="text" id="district" value="{{ $user->district }}" name="district" class="form-control" readonly>
                                                </div>
                                            </div>                                    
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="city" class="control-label mb-10">Address <span class="text-danger" title="Required">*</span></label>               
                                                    <input type="text" id="address" value="{{ $user->address }}" name="address" class="form-control" readonly>
                                                </div>
                                            </div>                                   
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="balance" class="control-label mb-10">Balance <span class="text-danger" title="Required">*</span></label>                                            
                                                    <input type="text" id="balance" name="balance" value="{{ $user->balance }}" class="form-control" readonly>
                                                </div>
                                            </div>                                    
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="cash_back_balance" class="control-label mb-10">Cash Back Balance <span class="text-danger" title="Required">*</span></label>                                            
                                                    <input type="text" id="cash_back_balance" name="cash_back_balance" value="{{ $user->cash_back_balance }}" placeholder="Car Package Charge" class="form-control" readonly>
                                                </div>
                                            </div>                                                                                                                               
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="img" class="control-label mb-10">Image </label>                                            
                                                    <img src="{{ asset($user->img) }}" class="form-control" style="width: 80px;height:60px;"/>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>	
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="txt-dark capitalize-font"><i class="fa fa-car mr-10"></i>Ride Info</h6> 
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
                                            <th>Starting Address</th>
                                            <th>Destination Address</th>
                                            <th>Status</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Starting Address</th>
                                            <th>Destination Address</th>
                                            <th>Status</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="userData">
                                        @if(isset($rides) && count($rides) > 0)
                                            @php $i=1; @endphp
                                            @foreach($rides as $ride)
                                                <tr class="ride-{{ $ride->id }}">
                                                    <td>{{ $ride->startig_area.", ".$ride->starting_city.", ".$ride->starting_district }}</td>
                                                    <td>{{ $ride->destination_area.", ".$ride->destination_city.", ".$ride->destination_district }}</td>
                                                    <td>{{ getStatus($ride->status) }}</td>
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <a href="{{ route('ride.details', $ride->id) }}" target="_blank" class="btn btn-xs btn-info" title="Details"><i class="fa fa-eye"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3" class="text-center">No Data Found</td>
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
@php 
    function getStatus($status) {
       if ($status == 1) {
        echo 'Waiting for Bid';
       } else if ($status == 2) {
        echo 'Cancel Request';
       } else if ($status == 3) {
        echo 'Start Request';
       } else if ($status == 4) {
        echo 'Bit Accepted';
       } else if ($status == 5) {
        echo 'Completed';
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
