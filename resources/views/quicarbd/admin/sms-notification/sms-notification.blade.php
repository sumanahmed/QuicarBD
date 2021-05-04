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
                                <label for="sms" class="control-label mb-10">Select Message </label>
                                <select class="form-control" name="sms" id="sms">
                                    <option value="0">Select</option>
                                    @foreach($sms as $tmp)
                                        <option value="{{ $tmp->id }}">{{ $tmp->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="for" class="control-label mb-10">For <span class="text-danger" title="Required">*</span></label>                                 
                                <select id="msgFor" name="for" class="form-control">
                                    <option value="1">User</option>
                                    <option value="2">Partner</option>
                                </select>
                                @if($errors->has('for'))
                                    <span class="text-danger"> {{ $errors->first('for') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="status" class="control-label mb-10">Status <span class="text-danger" title="Required">*</span></label>                                    
                                <select id="status" name="status" class="form-control">
                                    <option value="1">Approved</option>
                                    <option value="0">Pending</option>
                                </select>
                                @if($errors->has('status'))
                                    <span class="text-danger"> {{ $errors->first('status') }}</span>
                                @endif
                            </div>
                            <div class="form-group" id="accountType" style="display:none">
                                <label for="account_type" class="control-label mb-10">Account Type </label>                                    
                                <select id="account_type" name="account_type" class="form-control">
                                    <option selected disabled>Select</option>
                                    <option value="0">Car</option>
                                    <option value="1">Hotel</option>
                                    <option value="2">Travel</option>
                                    <option value="3">Car & Hotel</option>
                                    <option value="4">Car, Hotel & Travel</option>
                                    <option value="5">Hotel & Travel</option>
                                    <option value="5">Car & Travel</option>
                                </select>
                                @if($errors->has('account_type'))
                                    <span class="text-danger"> {{ $errors->first('account_type') }}</span>
                                @endif
                            </div>
                            <div class="form-group" id="serviceLocationDistrict" style="display:none">
                                <label for="service_location_district" class="control-label mb-10">Service Location </label>                                    
                                <select id="service_location_district" name="service_location_district" class="form-control">
                                    <option selected disabled>Select</option>
                                    @foreach($districts as $district)
                                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('car_type_id'))
                                    <span class="text-danger"> {{ $errors->first('car_type_id') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="title" class="control-label mb-10">Title <span class="text-danger" title="Required">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" required>
                            </div>                            
                            <div class="form-group">
                                <label for="message" class="control-label mb-10">Message <span class="text-danger" title="Required">*</span></label>
                                <textarea class="form-control sms_message" name="message" rows="6" id="message" placeholder="Enter your message"  required></textarea>
                                <span class="errorMessage text-danger text-bold"></span>
                            </div>                            
                            <div class="form-row">
                                <div class="form-group col-md-4">                                
                                    <input type="radio" name="notification" id="notification" value="0" checked>
                                    <label class="col-form-label">Push Notification</label>
                                </div>
                                <div class="form-group col-md-4">                                
                                    <input type="radio" name="notification" id="notification" value="1" checked>
                                    <label class="col-form-label">Bell Notification</label>
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="radio" name="notification" id="sms_notification" value="2">
                                    <label class="col-form-label">SMS & Notification </label>                                
                                </div>
                                <span class="errorMessage text-danger text-bold"></span>
                            </div>
                            <div class="form-row">
                                <button type="button" class="btn btn-xs btn-danger" id="smsDelete">Delete</button>
                                <button type="button" class="btn btn-xs btn-warning" id="smsDraftSave">Save as Draft</button>
                                <button type="submit" class="btn btn-xs btn-success tx-13">Send</button>
                                <button type="reset" class="btn btn-xs btn-danger tx-13">Cancel</button>
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
    <script>
        $("#msgFor").change(function(){
            
            var msgFor = $("#msgFor :selected").val();
            
            if (msgFor == 2) {
                $("#accountType").show();
                $("#serviceLocationDistrict").show();
            } else {
                $("#accountType").hide();
                $("#serviceLocationDistrict").hide();
            }
        });
    </script>
@endsection
