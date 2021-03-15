@extends('quicarbd.admin.layout.admin')
@section('title','Cancellation Reason')
@section('styles')
    <style>
        input[type=file] {
            display: none;
        }
    </style>
@endsection
@section('content')
@php 
    if($type == 0)
       $reason_type = 'Ride';
    else if($type == 1)
        $reason_type = 'Car Package';
    else if($type == 2)
        $reason_type = 'Hotel Package';
    else if($type == 3)
        $reason_type = 'Travel Package';
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
            <li class="active"><span>Add New  {{ $app_type == 1 ? 'User' : 'Partner' }} {{ $reason_type }} Cancellation Policy</span></li>
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
                        <h6 class="txt-dark capitalize-font"><i class="fa fa-car mr-10"></i>{{ $app_type == 1 ? 'User' : 'Partner' }} {{ $reason_type }} Cancellation Policy</h6> 
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-wrap">
                                    <form action="{{ route('reason.store') }}" method="post" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="form-body">     
                                            <div class="row">
                                                <div class="col-md-6">                                        
                                                    <div class="form-group">
                                                        <label for="name" class="control-label mb-10">Name <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="name" name="name" placeholder="Enter Name in English" class="form-control" required />
                                                        <input type="hidden" name="app_type" value="{{ $app_type }}" />
                                                        <input type="hidden" name="type" value="{{ $type }}" />
                                                        @if($errors->has('name'))
                                                            <span class="text-danger"> {{ $errors->first('name') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                        
                                                    <div class="form-group">
                                                        <label for="bn_name" class="control-label mb-10">Name (Bn)<span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="bn_name" name="bn_name" placeholder="Enter Name in English" class="form-control" required />
                                                        @if($errors->has('bn_name'))
                                                            <span class="text-danger"> {{ $errors->first('bn_name') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="status" class="control-label mb-10">Status <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select id="status" name="status" class="form-control selectable" required>
                                                            <option value="0">Inactive</option>                                                           
                                                            <option value="1">Active</option>                                                           
                                                        </select>
                                                        @if($errors->has('status'))
                                                            <span class="text-danger"> {{ $errors->first('status') }}</span>
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
