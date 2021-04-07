@extends('quicarbd.admin.layout.admin')
@section('title','Notification')
@section('content')
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"></div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Dashboard</a></li>
                <li class="active"><span>SMS & Notification</span></li>
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
                        <h6 class="panel-title txt-dark">SMS & Notification</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <form action="{{ route('sms_notification.send') }}" class="col-md-6" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="for" class="control-label">For <span class="text-danger" title="Required">*</span></label>                                 
                                <select id="for" name="for" class="form-control">
                                    <option value="1">User</option>
                                    <option value="2">Partner</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="status" class="control-label">Status <span class="text-danger" title="Required">*</span></label>                                    
                                <select id="status" name="status" class="form-control">
                                    <option value="1">Approved</option>
                                    <option value="0">Pending</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="title" class="control-label">Title <span class="text-danger" title="Required">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title">
                            </div>
                            
                            <div class="form-group">
                                <label for="message" class="control-label">Message <span class="text-danger" title="Required">*</span></label>
                                <textarea class="form-control summernote" name="message" rows="6" id="message" placeholder="Enter your message"></textarea>
                                <span class="errorMessage text-danger text-bold"></span>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-6">                                
                                    <input type="radio" name="notification" id="notification" value="1" checked>
                                    <label class="col-form-label">Notification</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="radio" name="notification" id="sms_notification" value="2">
                                    <label class="col-form-label">SMS & Notification </label>                                
                                </div>
                                <span class="errorMessage text-danger text-bold"></span>
                            </div>

                            <div class="form-row">
                            <button type="submit" class="btn btn-success tx-13">Send</button>
                            <button type="reset" class="btn btn-danger tx-13">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>	
        </div>
    </div>
</div>
@endsection
@section('scripts')
	<script src="{{ asset('quicarbd/admin/js/city.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
