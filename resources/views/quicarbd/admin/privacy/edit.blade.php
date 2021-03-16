@extends('quicarbd.admin.layout.admin')
@section('title','Car')
@section('styles')
    <style>
        input[type=file] {
            display: none;
        }
    </style>
@endsection
@section('content')
@php 
    if($privacy->type == 1)
        $privacy_type = 'Terms & Condition';
    elseif($privacy->type == 2)
        $privacy_type = 'Privacy Policy';
    else if($privacy->type == 3)
        $privacy_type = 'Booking Policy';
    else if($privacy->type == 4)
        $privacy_type = 'Payment Policy';
    else if($privacy->type == 5)
        $privacy_type = 'Return Policy';
    else if($privacy->type == 6)
        $privacy_type = 'About Us';
    else if($privacy->type == 7)
        $privacy_type = 'Cashback Policy';
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
            <li><a href="#">Car</a></li>
            <li class="active"><span>Edit {{ $privacy->for == 1 ? 'User' : 'Partner' }} {{ $privacy_type }}</span></li>
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
                        <h6 class="txt-dark capitalize-font"><i class="fa fa-car mr-10"></i>{{ $privacy->for == 1 ? 'User' : 'Partner' }} {{ $privacy_type }}</h6> 
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-wrap">
                                    <form action="{{ route('privacy.update', $privacy->id) }}" method="post" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="form-body">     
                                            <div class="row">
                                                <div class="col-md-12">                                        
                                                    <div class="form-group">
                                                        <label for="description" class="control-label mb-10">Description <span class="text-danger" title="Required">*</span></label>
                                                        <textarea id="description" name="description" placeholder="Enter Description" rows="10" class="form-control" required>{{ $privacy->description }}</textarea>
                                                        <input type="hidden" name="for" value="{{ $privacy->for }}" />
                                                        <input type="hidden" name="type" value="{{ $privacy->type }}" />
                                                        @if($errors->has('description'))
                                                            <span class="text-danger"> {{ $errors->first('description') }}</span>
                                                        @endif
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