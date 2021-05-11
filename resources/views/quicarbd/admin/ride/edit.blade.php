@extends('quicarbd.admin.layout.admin')
@section('title','Ride Edit')
@section('content')
@php 
    $helper = new App\Http\Lib\Helper;
@endphp
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-md-lg-3 col-md-4 col-sm-4 col-xs-12">
        </div>
        <!-- Breadcrumb -->
        <div class="col-md-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Ride</a></li>
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
                        <h6 class="txt-dark capitalize-font"><i class="fa fa-car mr-10"></i>Ride Edit</h6> 
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-sm-12 col-xs-12">                                
                                <div class="form-wrap">
                                    <div class="form-body">   
                                        <form action="{{ route('ride.update', $ride->id) }}"  method="POST">
                                            @csrf  
                                            <div class="row">
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="starting_district" class="control-label mb-10">Starting District <span class="text-danger" title="Required">*</span></label>
                                                        <select id="starting_district" name="starting_district" class="form-control" required>
                                                            @foreach($districts as $district)
                                                                <option value="{{ $district->id }}" @if($district->id == $ride->starting_district) selected @endif>{{ $district->name }}</option>  
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('starting_district'))
                                                            <span class="text-danger"> {{ $errors->first('starting_district') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="starting_city" class="control-label mb-10">Starting City <span class="text-danger" title="Required">*</span></label>          
                                                        <select id="starting_city" name="starting_city" class="form-control" required>
                                                            @foreach($starting_cities as $city)
                                                                <option value="{{ $city->id }}" @if($city->id == $ride->starting_city) selected @endif>{{ $city->name }}</option>  
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('starting_city'))
                                                            <span class="text-danger"> {{ $errors->first('starting_city') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="startig_area" class="control-label mb-10">Starting Area <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="startig_area" name="startig_area" value="{{ $ride->startig_area }}" class="form-control">
                                                        @if($errors->has('startig_area'))
                                                            <span class="text-danger"> {{ $errors->first('startig_area') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="destination_district" class="control-label mb-10">Destination District <span class="text-danger" title="Required">*</span></label>
                                                        <select id="destination_district" name="destination_district" class="form-control" required>
                                                            @foreach($districts as $district)
                                                                <option value="{{ $district->id }}" @if($district->id == $ride->destination_district) selected @endif>{{ $district->name }}</option>  
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('destination_district'))
                                                            <span class="text-danger"> {{ $errors->first('destination_district') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="phone" class="control-label mb-10">Destination City <span class="text-danger" title="Required">*</span></label>                 
                                                        <select id="destination_city" name="destination_city" class="form-control" required>
                                                            @foreach($destination_cities as $city)
                                                                <option value="{{ $city->id }}" @if($city->id == $ride->destination_city) selected @endif>{{ $city->name }}</option>  
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('destination_city'))
                                                            <span class="text-danger"> {{ $errors->first('destination_city') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="destination_area" class="control-label mb-10">Destination Area <span class="text-danger" title="Required">*</span></label>                                            
                                                        <input type="text" name="destination_area" id="destination_area" value="{{ $ride->destination_area }}" class="form-control" required>
                                                        @if($errors->has('destination_area'))
                                                            <span class="text-danger"> {{ $errors->first(destination_area) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="car_type" class="control-label mb-10">Car Type <span class="text-danger" title="Required">*</span></label>          
                                                        <select id="car_type" name="car_type" class="form-control" required>
                                                            @foreach($car_types as $type)
                                                                <option value="{{ $type->id }}" @if($type->id == $ride->car_type) selected @endif>{{ $type->name }}</option>  
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('destination_area'))
                                                            <span class="text-danger"> {{ $errors->first(destination_area) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="extra_note" class="control-label mb-10">Extra Note</label>                                            
                                                        <input type="text" name="extra_note" value="{{ $ride->extra_note }}" class="form-control">
                                                        @if($errors->has('extra_note'))
                                                            <span class="text-danger"> {{ $errors->first(extra_note) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="rown_way" class="control-label mb-10">Trip Type <span class="text-danger" title="Required">*</span></label>                                        
                                                        <select id="rown_way" name="rown_way" class="form-control" required>
                                                            <option value="0" @if($ride->rown_way == 0) selected @endif>One Way</option> 
                                                            <option value="1" @if($ride->rown_way == 1) selected @endif>Round Way</option> 
                                                        </select>
                                                        @if($errors->has('rown_way'))
                                                            <span class="text-danger"> {{ $errors->first(rown_way) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="start_time" class="control-label mb-10">Start Time <span class="text-danger" title="Required">*</span></label>                                            
                                                        <input type="datetime-local" name="start_time" id="start_time" value="{{ date('Y-m-d\TH:i:s', strtotime($ride->start_time)) }}" class="form-control">
                                                        @if($errors->has('start_time'))
                                                            <span class="text-danger"> {{ $errors->first(start_time) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="phone" class="control-label mb-10">User Name</label>                                            
                                                        <input type="phone" value="{{ $helper->getUser($ride->user_id) }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="phone" class="control-label mb-10">User Phone</label>                                            
                                                        <input type="phone" value="{{ $helper->getUserPhone($ride->user_id) }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <button type="submit" class="btn btn-sm btn-success tx-13">Send</button>
                                                    <button type="reset" class="btn btn-sm btn-danger tx-13">Cancel</button>
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
</div>
@endsection
@section('scripts')
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
