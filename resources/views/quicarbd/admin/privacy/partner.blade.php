@extends('quicarbd.admin.layout.admin')
@section('title','Partner')
@section('styles')
    <style>
        input[type=file] {
            display: none;
        }
    </style>
@endsection
@section('content')
@php 
    if ($type == 1) {
        $policy_type = "About Us";
    } else if ($type == 2) {
        $policy_type = "Terms of Services";
    } else if ($type == 3) {
        $policy_type = "Privacy Policy";
    } else if ($type == 4) {
        $policy_type = "Booking Policy";
    } else if ($type == 5) {
        $policy_type = "Cancellation Policy";
    } else if ($type == 6) {
        $policy_type = "Payment Policy";
    } else if ($type == 7) {
        $policy_type = "Cashback Policy";
    } else if ($type == 8) {
        $policy_type = "Return Policy";
    } else if ($type == 9) {
        $policy_type = "Tips and Trick";
    }
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
                <li><a href="#">Privacy</a></li>
                <li class="active"><span>Edit Partner {{ $policy_type }}</span></li>
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
                        <h6 class="txt-dark capitalize-font"><i class="fa fa-car mr-10"></i>Partner {{ $policy_type }}</h6> 
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-wrap">
                                    <form action="{{ route('privacy.partner.update', $privacy->id) }}" method="post" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="form-body">     
                                            <div class="row">
                                                <div class="col-md-12">                                        
                                                    <div class="form-group">
                                                        <label for="description" class="control-label mb-10">{{ $policy_type }} <span class="text-danger" title="Required">*</span></label>
                                                        @if($type == 1)
                                                            <textarea name="about_us" placeholder="Enter Details" rows="10" class="form-control" required>{{ $privacy->about_us }}</textarea>
                                                        @elseif($type == 2)
                                                            <textarea name="terms_of_services" placeholder="Enter Details" rows="10" class="form-control" required>{{ $privacy->terms_of_services }}</textarea>
                                                        @elseif($type == 3)
                                                            <textarea name="privacy_policy" placeholder="Enter Details" rows="10" class="form-control" required>{{ $privacy->privacy_policy }}</textarea>
                                                        @elseif($type == 4)
                                                            <textarea name="booking_policy" placeholder="Enter Details" rows="10" class="form-control" required>{{ $privacy->booking_policy }}</textarea>
                                                        @elseif($type == 5)
                                                            <textarea name="cancellation_policy" placeholder="Enter Details" rows="10" class="form-control" required>{{ $privacy->cancellation_policy }}</textarea>
                                                        @elseif($type == 6)
                                                            <textarea name="payment_policy" placeholder="Enter Details" rows="10" class="form-control" required>{{ $privacy->payment_policy }}</textarea>
                                                        @elseif($type == 7)
                                                            <textarea name="cashback_policy" placeholder="Enter Details" rows="10" class="form-control" required>{{ $privacy->cashback_policy }}</textarea>
                                                        @elseif($type == 8)
                                                            <textarea name="return_policy" placeholder="Enter Details" rows="10" class="form-control" required>{{ $privacy->return_policy }}</textarea>
                                                        @elseif($type == 9)
                                                            <textarea name="tips_and_trick" placeholder="Enter Details" rows="10" class="form-control" required>{{ $privacy->tips_and_trick }}</textarea>
                                                        @endif
                                                        
                                                        <input type="hidden" name="type" value="{{ $type }}" />
                                                    </div>
                                                </div>
                                            </div>    
                                            <div class="row" style="margin-top:10px;">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="submit" class="btn btn-sm btn-success" value="Submit"/>
                                                        <input type="reset" class="btn btn-sm btn-danger" value="Cancel"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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
