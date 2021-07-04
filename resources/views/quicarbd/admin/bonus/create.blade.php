@extends('quicarbd.admin.layout.admin')
@section('title','Bonus')
@section('content')
<div class="container-fluid">               
    <!-- Title -->
    <div class="row heading-bg">
        <div class="col-md-md-lg-3 col-md-4 col-sm-4 col-xs-12">
        </div>
        <!-- Breadcrumb -->
        <div class="col-md-md-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Bonus</a></li>
                <li class="active"><span>Add New Bonus</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
    <!-- /Title -->    
    <!-- Row -->
    <div class="row">
        <div class="col-md-md-sm-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="txt-dark capitalize-font"><i class="fa fa-car mr-10"></i>{{ $type == 0 ? 'User' : 'Partner' }} Bonus Info</h6> 
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-md-sm-12 col-xs-12">
                                <div class="form-wrap">
                                    <form action="{{ route('bonus.store') }}" method="post" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="form-body">     
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="completed_ride" class="control-label mb-10">Complete Ride <span class="text-danger" title="Required">*</span></label>
                                                        <input type="number" id="completed_ride" name="completed_ride" value="{{ old('completed_ride') }}" class="form-control" placeholder="Complete Ride" required>
                                                        <input type="hidden" name="type" value="{{ $type }}" />
                                                        @if($errors->has('completed_ride'))
                                                            <span class="text-danger"> {{ $errors->first('completed_ride') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="bonus_amount" class="control-label mb-10">Bonus Amount <span class="text-danger" title="Required">*</span></label>
                                                        <input type="number" id="bonus_amount" name="bonus_amount" value="{{ old('bonus_amount') }}" class="form-control" placeholder="Bonus Amount" required>
                                                        @if($errors->has('bonus_amount'))
                                                            <span class="text-danger"> {{ $errors->first('bonus_amount') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="bonus_for" class="control-label mb-10">Bonus For <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select class="form-control" name="bonus_for" id="bonus_for"> 
                                                            <option value="0">Select</option>
                                                            <option value="1">Ride</option>
                                                            <option value="2">Car Package</option>
                                                            <option value="3">Hotel Package</option>
                                                            <option value="4">Travel Package</option>
                                                        </select>
                                                        @if($errors->has('bonus_for'))
                                                            <span class="text-danger"> {{ $errors->first('bonus_for') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="offer_starting_time" class="control-label mb-10">Offer Starting Date & Time <span class="text-danger" title="Required">*</span></label>                                            
                                                        <input type="datetime-local" name="offer_starting_time" id="offer_starting_time" class="form-control" />
                                                        @if($errors->has('offer_starting_time'))
                                                            <span class="text-danger"> {{ $errors->first('offer_starting_time') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="offer_finishing_time" class="control-label mb-10">Offer Ending Date & Time <span class="text-danger" title="Required">*</span></label>                                            
                                                        <input type="datetime-local" name="offer_finishing_time" id="offer_finishing_time" class="form-control" />
                                                        @if($errors->has('offer_finishing_time'))
                                                            <span class="text-danger"> {{ $errors->first('offer_finishing_time') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
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
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
