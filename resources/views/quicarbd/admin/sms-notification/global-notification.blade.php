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
                <li><a href="#">SMS & Notification</a></li>
                <li class="active"><span>Global Notification</span></li>
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
                        <h6 class="panel-title txt-dark">Global Notification</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <form action="{{ route('sms_notification.global_notification.send') }}" class="col-md-6" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="for" class="control-label mb-10">For <span class="text-danger" title="Required">*</span></label>                                 
                                <select id="for" name="for" class="form-control">
                                    <option value="1">User</option>
                                    <option value="2">Partner</option>
                                </select>
                                @if($errors->has('for'))
                                    <span class="text-danger"> {{ $errors->first('for') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="title" class="control-label mb-10">Title <span class="text-danger" title="Required">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" required>
                            </div>                            
                            <div class="form-group">
                                <label for="message" class="control-label mb-10">Message <span class="text-danger" title="Required">*</span></label>
                                <textarea class="form-control summernote" name="message" rows="6" id="message" placeholder="Enter your message"  required></textarea>
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
