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
    if($type == 1)
       $type = 'Ride';
    else if($type == 2)
        $type = 'Car Package';
    else if($type == 3)
        $type = 'Hotel Package';
    else
        $type = 'Travel Package';
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
            <li class="active"><span>Add New  {{ $policy->for == 1 ? 'User' : 'Partner' }} {{ $type}} Cancellation Policy</span></li>
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
                        <h6 class="txt-dark capitalize-font"><i class="fa fa-car mr-10"></i>{{ $policy->for == 1 ? 'User' : 'Partner' }} {{ $type}} Cancellation Policy</h6> 
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-wrap">
                                    <form action="{{ route('policy.update', $policy->id) }}" method="post" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="form-body">     
                                            <div class="row">
                                                <div class="col-md-12">                                        
                                                    <div class="form-group">
                                                        <label for="description" class="control-label mb-10">Description <span class="text-danger" title="Required">*</span></label>
                                                        <textarea id="description" name="description" placeholder="Enter Description" class="form-control" required>{{ $policy->description }}</textarea>
                                                        <input type="hidden" name="for" value="{{ $policy->for }}" />
                                                        <input type="hidden" name="type" value="{{ $policy->type }}" />
                                                        @if($errors->has('description'))
                                                            <span class="text-danger"> {{ $errors->first('description') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="status" class="control-label mb-10">Status <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select id="status" name="status" class="form-control selectable" required>
                                                            <option value="0" @if($policy->status == 0) selected @endif>Inactive</option>                                                           
                                                            <option value="1" @if($policy->status == 1) selected @endif>Active</option>                                                           
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
