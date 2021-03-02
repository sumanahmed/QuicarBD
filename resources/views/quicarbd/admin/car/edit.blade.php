@extends('quicarbd.admin.layout.admin')
@section('title','Car')
@section('content')
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
            <li class="active"><span>Add New Car</span></li>
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
                        <h6 class="txt-dark capitalize-font"><i class="fa fa-car mr-10"></i>Car Info</h6> 
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-wrap">
                                    <form action="{{ route('car.update', $car->id) }}" method="post" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="form-body">     
                                            <div class="row">
                                                <div class="col-md-3">                                        
                                                    <div class="form-group">
                                                        <label for="carRegisterNumber" class="control-label mb-10"> Registration No <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="carRegisterNumber" name="carRegisterNumber" value="{{ $car->carRegisterNumber }}" placeholder="Enter Car Registration No" class="form-control" required>
                                                        @if($errors->has('carRegisterNumber'))
                                                            <span class="text-danger"> {{ $errors->first('carRegisterNumber') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-3">                                        
                                                    <div class="form-group">
                                                        <label for="district_id" class="control-label mb-10">Car Service Location <span class="text-danger" title="Required">*</span></label>
                                                        <select name="district_id" id="district_id" class="form-control selectable">
                                                            @foreach($districts as $district)
                                                                <option value="{{ $district->id }}" @if($district->id == $car->district_id) selected @endif>{{ $district->value }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('district_id'))
                                                            <span class="text-danger"> {{ $errors->first('district_id') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-3">                                        
                                                    <div class="form-group">
                                                        <label for="city_id" class="control-label mb-10">City <span class="text-danger" title="Required">*</span></label>
                                                        <select name="city_id" id="city_id" class="form-control selectable">
                                                            @foreach($citys as $city)
                                                                <option value="{{ $city->id }}" @if($city->id == $car->city_id) selected @endif>{{ $city->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('city_id'))
                                                            <span class="text-danger"> {{ $errors->first('city_id') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="owner_id" class="control-label mb-10">Owner <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select id="owner_id" name="owner_id" class="form-control selectable" required>
                                                            @foreach($owners as $owner)
                                                                <option value="{{ $owner->id }}" @if($owner->id == $car->owner_id) selected @endif>{{ $owner->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('owner_id'))
                                                            <span class="text-danger"> {{ $errors->first('owner_id') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>                                
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="carType" class="control-label mb-10">Car Type <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select id="carType" name="carType" class="form-control selectable" required>
                                                            @foreach($types as $type)
                                                                <option value="{{ $type->name }}" @if($type->name == $car->carType) selected @endif>{{ $type->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('carType'))
                                                            <span class="text-danger"> {{ $errors->first('carType') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="carBrand" class="control-label mb-10">Car Brand <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select id="carBrand" name="carBrand" class="form-control selectable" required>
                                                            @foreach($brands as $brand)
                                                                <option value="{{ $brand->value }}" @if($brand->value == $car->carBrand) selected @endif>{{ $brand->value }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('carBrand'))
                                                            <span class="text-danger"> {{ $errors->first('carBrand') }}</span>
                                                        @endif
                                                    </div>
                                                </div>                                    
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="carModel" class="control-label mb-10">Car Model <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select id="carModel" name="carModel" class="form-control selectable" required>
                                                            @foreach($models as $model)
                                                                <option value="{{ $model->value }}" @if($model->value == $car->carModel) selected @endif>{{ $model->value }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('carModel'))
                                                            <span class="text-danger"> {{ $errors->first('carModel') }}</span>
                                                        @endif
                                                    </div>
                                                </div>                                    
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="carYear" class="control-label mb-10">Car Year <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select id="carYear" name="carYear" class="form-control selectable" required>
                                                            @foreach($years as $year)
                                                                <option value="{{ $year->name }}" @if($year->name == $car->carYear) selected @endif>{{ $year->name }}</option> 
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('carYear'))
                                                            <span class="text-danger"> {{ $errors->first('carYear') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="carColor" class="control-label mb-10">Car Color <span class="text-danger" title="Required">*</span></label> 
                                                        <input type="text" class="form-control" name="carColor" value="{{ $car->carColor }}" placeholder="Enter Color" />
                                                        @if($errors->has('carColor'))
                                                            <span class="text-danger"> {{ $errors->first('carColor') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="carClass" class="control-label mb-10">Car Class <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select id="carClass" name="carClass" class="form-control selectable" required>
                                                            @foreach($classes as $class)
                                                                <option value="{{ $class->value }}" @if($class->value == $car->carClass) selected @endif>{{ $class->value }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('carClass'))
                                                            <span class="text-danger"> {{ $errors->first('carClass') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="sit_capacity" class="control-label mb-10">Sit Capacity <span class="text-danger" title="Required">*</span></label>                                                        
                                                        <input type='text' name="sit_capacity" class="form-control" value="{{ $car->sit_capacity }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="img1" class="control-label mb-10">Car Image <span class="text-danger" title="Required">*</span></label>                                                        
                                                        <input type='file' name="carImage" class="form-control" accept=".png, .jpg, .jpeg" required/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="img2" class="control-label mb-10">Smart Card (Front) <span class="text-danger" title="Required">*</span> </label>                                                        
                                                        <input type='file' name="carSmartCardFont" class="form-control" accept=".png, .jpg, .jpeg" required/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="carSmartCardBack" class="control-label mb-10">Smart Card (Back) <span class="text-danger" title="Required">*</span> </label>
                                                        <input type='file' name="carSmartCardBack" class="form-control" id="carSmartCardBack" accept=".png, .jpg, .jpeg"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="img4" class="control-label mb-10">Tax Token <span class="text-danger" title="Required">*</span> </label>
                                                        <input type='file' name="taxToken_image" class="form-control" id="img4Upload" accept=".png, .jpg, .jpeg"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="img5" class="control-label mb-10">Fitness Certificate <span class="text-danger" title="Required">*</span> </label>
                                                        <input type='file' name="fitnessCertificate" class="form-control" id="img5Upload" accept=".png, .jpg, .jpeg"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="img6" class="control-label mb-10">Insurance Paper <span class="text-danger" title="Required">*</span> </label>
                                                        <input type='file' name="insurancePaper_path" class="form-control" id="img6Upload" accept=".png, .jpg, .jpeg"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="tax_expired_date" class="control-label mb-10">Tax Expired Date <span class="text-danger" title="Required">*</span></label>
                                                        <input type="date" id="tax_expired_date" name="tax_expired_date" value="{{ $car->tax_expired_date }}" class="form-control datePicker" required/>
                                                        @if($errors->has('tax_expired_date'))
                                                            <span class="text-danger"> {{ $errors->first('tax_expired_date') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="fitness_expired_date" class="control-label mb-10">Fitness Expired Date <span class="text-danger" title="Required">*</span></label>
                                                        <input type="date" id="fitness_expired_date" name="fitness_expired_date" value="{{ $car->fitness_expired_date }}" class="form-control datePicker" required/>
                                                        @if($errors->has('fitness_expired_date'))
                                                            <span class="text-danger"> {{ $errors->first('fitness_expired_date') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="registration_expired_date" class="control-label mb-10">Registration Expired Date <span class="text-danger" title="Required">*</span></label>
                                                        <input type="date" id="registration_expired_date" name="registration_expired_date" value="{{ $car->registration_expired_date }}" class="form-control datePicker" required/>
                                                        @if($errors->has('registration_expired_date'))
                                                            <span class="text-danger"> {{ $errors->first('registration_expired_date') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="insurance_expired_date" class="control-label mb-10">Insurance Expired Date <span class="text-danger" title="Required">*</span></label>
                                                        <input type="date" id="insurance_expired_date" name="insurance_expired_date" value="{{ $car->insurance_expired_date }}" class="form-control datePicker" required/>
                                                        @if($errors->has('insurance_expired_date'))
                                                            <span class="text-danger"> {{ $errors->first('insurance_expired_date') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>                                                
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="status_message" class="control-label mb-10">Status Message  <span class="text-danger" title="Required">*</span></label>
                                                    <input type="text" name="status_message" id="status_message" class="form-control" value="{{ $car->status_message }}" placeholder="Enter Status Message" required/>
                                                    @if($errors->has('status_message'))
                                                        <span class="text-danger"> {{ $errors->first('status_message') }}</span>
                                                    @endif
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
    
    <!-- Delete Class Modal -->
    <div id="deleteDriverModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title mb-10" id="exampleModalLabel">Are you sure to delete ?</h5>
                    <input type="hidden" name="del_id"/>
                    <button type="button" class="btn btn-xs btn-danger btn-raised mr-2" id="destroyDriver"><i class="fas fa-trash-alt"></i> Proceed</button>
                    <button type="button" class="btn btn-xs btn-warning btn-raised" data-dismiss="modal" aria-label="Close"><i class="fas fa-backspace"></i> Cancel</button>
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
