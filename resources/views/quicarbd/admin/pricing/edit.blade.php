@extends('quicarbd.admin.layout.admin')
@section('title','Pricing')
@section('styles')
    <style>
        input[type=file] {
            display: none;
        }
    </style>
@endsection
@section('content')
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-md-lg-3 col-md-4 col-sm-4 col-xs-12">
        </div>
        <!-- Breadcrumb -->
        <div class="col-md-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">p
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Pricing</a></li>
                <li class="active"><span>Edit</span></li>
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
                        <h6 class="txt-dark capitalize-font"><i class="fa fa-user mr-10"></i>Pricing Info</h6> 
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-sm-12 col-xs-12">
                                <div class="form-wrap">
                                    <form action="{{ route('pricing.update', $pricing->id) }}" method="post" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="form-body">     
                                            <div class="row">
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="starting_district" class="control-label mb-10">Starting District <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select name="starting_district" class="form-control selectable" required>
                                                            <option value="0">Select</option>
                                                            @foreach($districts as $district)
                                                                <option value="{{ $district->id }}" @if($district->id == $pricing->starting_district) selected @endif>{{ $district->value }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('starting_district'))
                                                            <span class="text-danger"> {{ $errors->first('starting_district') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="destination_district" class="control-label mb-10">Destination District <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select name="destination_district" class="form-control selectable" required>
                                                            <option value="0">Select</option>
                                                            @foreach($districts as $district)
                                                                <option value="{{ $district->id }}" @if($district->id == $pricing->destination_district) selected @endif>{{ $district->value }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('destination_district'))
                                                            <span class="text-danger"> {{ $errors->first('destination_district') }}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="car_type" class="control-label mb-10">Car Type <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select name="car_type" class="form-control selectable">
                                                            <option value="0">Select</option>
                                                            @foreach($car_types as $car_type)
                                                                <option value="{{ $car_type->id }}" @if($car_type->id == $pricing->car_type) selected @endif>{{ $car_type->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('car_type'))
                                                            <span class="text-danger"> {{ $errors->first('car_type') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="ride_type" class="control-label mb-10">Ride Type <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select name="ride_type" class="form-control selectable" required>
                                                            <option value="0" @if($pricing->ride_type == 0) selected @endif>One Way</option>
                                                            <option value="1" @if($pricing->ride_type == 1) selected @endif>Round Way</option>
                                                        </select>
                                                        @if($errors->has('ride_type'))
                                                            <span class="text-danger"> {{ $errors->first('ride_type') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                           
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="minimum_price" class="control-label mb-10">Minimum Price <span class="text-danger" title="Required">*</span></label>                                            
                                                        <input type="text" name="minimum_price" value="{{ $pricing->minimum_price }}" placeholder="Mimimum Price" class="form-control" required>
                                                        @if($errors->has('minimum_price'))
                                                            <span class="text-danger"> {{ $errors->first('minimum_price') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="maximum_price" class="control-label mb-10">Maximum Price <span class="text-danger" title="Required">*</span></label>                                            
                                                        <input type="text" name="maximum_price" value="{{ $pricing->maximum_price }}" placeholder="Mimimum Price" class="form-control" required>
                                                        @if($errors->has('maximum_price'))
                                                            <span class="text-danger"> {{ $errors->first('maximum_price') }}</span>
                                                        @endif
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="extra_note" class="control-label mb-10">Extra Note </label>                                            
                                                        <textarea id="extra_note" name="extra_note" placeholder="Enter Address" class="form-control">{{ $pricing->extra_note }}</textarea>
                                                        @if($errors->has('extra_note'))
                                                            <span class="text-danger"> {{ $errors->first('extra_note') }}</span>
                                                        @endif
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="submit" class="btn btn-success" value="Submit"/>
                                                        <input type="reset" class="btn btn-danger" value="Cancel"/>
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
	<script src="{{ asset('quicarbd/admin/js/driver.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
