@extends('quicarbd.admin.layout.admin')
@section('title','Car')
@section('content')
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <a href="{{ route('car.create') }}" class="btn btn-success btn-anim"><i class="icon-plus"></i><span class="btn-text">Add New</span></a>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Car</a></li>
            <li class="active"><span>Add Expired Car</span></li>
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
                        <h6 class="panel-title txt-dark">All Expired Car</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="table-wrap">
                            <div class="table-responsive">
                                <table id="datable_1" class="table table-hover display pb-30">
                                    <thead>
                                        <tr>
                                            <th>Car Reg No</th>
                                            <th>Partner </th>
                                            <th>Tax Expired</th>
                                            <th>Fitness Expired</th>
                                            <th>Registration Expired</th>
                                            <th>Insurance Expired</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="carData">
                                        @if(isset($cars) && count($cars) > 0)
                                            @php $i=1; @endphp
                                            @foreach($cars as $car)
                                                <tr class="car-{{ $car->id }}">
                                                    <td>{{ $car->carRegisterNumber }}</td>
                                                    <td>{{ $car->owner_name }} <br/> {{ $car->owner_phone }}</td>
                                                    <td>{{ $car->tax_expired_date }}</td>                                     
                                                    <td>{{ $car->fitness_expired_date }}</td>                                     
                                                    <td>{{ $car->registration_expired_date }}</td>                                     
                                                    <td>{{ $car->insurance_expired_date }}</td>                                     
                                                    <td style="vertical-align: middle;text-align: center;">                                              
                                                        <a href="#" class="btn btn-xs btn-info" data-toggle="modal" id="sendNotification" data-target="#sendNotificationModal" title="Send Notification"
                                                         data-owner_id="{{ $car->owner_id }}" data-car_reg_no="{{ $car->carRegisterNumber }}"><i class="fa fa-bell"></i></a>
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
    
    <div id="sendNotificationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="exampleModalLabel1">Send Notification</h5>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="title" class="control-label mb-10">Title <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <input type="text" name="title" id="title" class="form-control"placeholder="Enter Title" required>                            
                            <input type="hidden" name="owner_id" id="owner_id" />
                            <input type="hidden" name="car_reg_no" id="car_reg_no" />
                            <span class="errorTitle text-danger text-bold"></span>
                        </div>
                        <div class="form-group">
                            <label for="message" class="control-label mb-10">Message <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <textarea class="form-control" name="message"  id="message" placeholder="Enter your message"></textarea>
                            <span class="errorMessage text-danger text-bold"></span>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">                                
                                <input type="radio" name="notification" id="notification" value="1" checked>
                                <label class="col-form-label" for="notification">Notification</label>
                            </div>
                            <div class="form-group col-md-4">
                                <input type="radio" name="notification" id="sms_notification" value="2">
                                <label class="col-form-label" for="sms_notification">SMS & Notification </label>                                
                            </div>
                            <span class="errorMessage text-danger text-bold"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="ownerNotificationSend">Send</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
	<script src="{{ asset('quicarbd/admin/js/car.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
