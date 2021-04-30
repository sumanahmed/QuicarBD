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
            <li class="active"><span>Edit Car</span></li>
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
                                                        <label for="owner_id" class="control-label mb-10">Owner Name<span class="text-danger" title="Required">*</span></label>
                                                        <select id="owner_id" name="owner_id" class="form-control selectable" required readonly>
                                                            <option value="{{ $car->owner_id }}" selected>{{ $owner->name }}</option>
                                                        </select>
                                                        @if($errors->has('owner_id'))
                                                            <span class="text-danger"> {{ $errors->first('owner_id') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="owner_id" class="control-label mb-10">Owner Phone</label>                                            
                                                        <input type="text" value="{{ $owner->phone }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                            </div>                                
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="carType" class="control-label mb-10">Car Type <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select id="carType" name="carType" class="form-control selectable" required>
                                                            <option selected disabled>Select</option>
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
                                                                <option value="{{ $year->value }}" @if($year->value == $car->carYear) selected @endif>{{ $year->value }}</option>
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
                                                        <select id="carColor" name="carColor" class="form-control selectable" required>
                                                            <option selected disabled>Select</option>
                                                            @foreach($colors as $color)
                                                                <option value="{{ $color->name }}" @if($color->name == $car->carColor) selected @endif>{{ $color->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('carColor'))
                                                            <span class="text-danger"> {{ $errors->first('carColor') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="carClass" class="control-label mb-10">Car Class </label>                                            
                                                        <select id="carClass" name="carClass" class="form-control selectable">
                                                            <option selected disabled>Select</option>
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
                                                        <label for="img1" class="control-label mb-10">Car Image <span class="text-danger" title="Required">*</span></label>  
                                                        <div class="avatar-upload">
                                                            <div class="avatar-edit">
                                                                <input type='file' name="carImage" id="img1Upload" accept=".png, .jpg, .jpeg" required/>
                                                                <label for="img1Upload"><i class="fa fa-edit"></i></label>
                                                                <label class="img-popup" src="http://quicarbd.com/{{ $car->carImage }}"><i class="fa fa-eye"></i></label>
                                                            </div>
                                                            <div class="avatar-preview" style="width:100%">
                                                                <div id="img1Preview" style="background-image: url(http://quicarbd.com/{{ $car->carImage }});"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="img2" class="control-label mb-10">Smart Card (Front) <span class="text-danger" title="Required">*</span> </label>                                                        
                                                        <div class="avatar-upload">
                                                            <div class="avatar-edit">
                                                                <input type='file' name="carSmartCardFont" id="img2Upload" accept=".png, .jpg, .jpeg"/>
                                                                <label for="img2Upload"><i class="fa fa-edit"></i></label>
                                                                <label class="img-popup" src="http://quicarbd.com/{{ $car->carSmartCardFont }}"><i class="fa fa-eye"></i></label>
                                                            </div>
                                                            <div class="avatar-preview" style="width:100%">
                                                                <div id="img2Preview" style="background-image: url(http://quicarbd.com/{{ $car->carSmartCardFont }});"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="img3" class="control-label mb-10">Smart Card (Back) <span class="text-danger" title="Required">*</span> </label>
                                                        <div class="avatar-upload">
                                                            <div class="avatar-edit">
                                                                <input type='file' name="carSmartCardBack" id="img3Upload" accept=".png, .jpg, .jpeg"/>
                                                                <label for="img3Upload"><i class="fa fa-edit"></i></label>
                                                                <label class="img-popup" src="http://quicarbd.com/{{ $car->carSmartCardBack }}"><i class="fa fa-eye"></i></label>
                                                            </div>
                                                            <div class="avatar-preview" style="width:100%">
                                                                <div id="img3Preview" style="background-image: url(http://quicarbd.com/{{ $car->carSmartCardBack }});"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="img4" class="control-label mb-10">Tax Token <span class="text-danger" title="Required">*</span> </label>
                                                        <div class="avatar-upload">
                                                            <div class="avatar-edit">
                                                                <input type='file' name="taxToken_image" id="img4Upload" accept=".png, .jpg, .jpeg"/>
                                                                <label for="img4Upload"><i class="fa fa-edit"></i></label>
                                                                <label class="img-popup" src="http://quicarbd.com/{{ $car->taxToken_image }}"><i class="fa fa-eye"></i></label>
                                                            </div>
                                                            <div class="avatar-preview" style="width:100%">
                                                                <div id="img4Preview" style="background-image: url(http://quicarbd.com/{{ $car->taxToken_image }});"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="img5" class="control-label mb-10">Fitness Certificate <span class="text-danger" title="Required">*</span> </label>
                                                        <div class="avatar-upload">
                                                            <div class="avatar-edit">
                                                                <input type='file' name="fitnessCertificate" id="img5Upload" accept=".png, .jpg, .jpeg"/>
                                                                <label for="img5Upload"><i class="fa fa-edit"></i></label>
                                                                <label class="img-popup" src="http://quicarbd.com/{{ $car->fitnessCertificate }}"><i class="fa fa-eye"></i></label>
                                                            </div>
                                                            <div class="avatar-preview" style="width:100%">
                                                                <div id="img5Preview" style="background-image: url(http://quicarbd.com/{{ $car->fitnessCertificate }});"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="img6" class="control-label mb-10">Insurance Paper </label>
                                                        <div class="avatar-upload">
                                                            <div class="avatar-edit">
                                                                <input type='file' name="insurancePaper_path" id="img6Upload" accept=".png, .jpg, .jpeg"/>
                                                                <label for="img6Upload"><i class="fa fa-edit"></i></label>
                                                                <label class="img-popup" src="http://quicarbd.com/{{ $car->insurancePaper_path }}"><i class="fa fa-eye"></i></label>
                                                            </div>
                                                            <div class="avatar-preview" style="width:100%">
                                                                <div id="img6Preview" style="background-image: url(http://quicarbd.com/{{ $car->insurancePaper_path }});"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="sit_capacity" class="control-label mb-10">Sit Capacity <span class="text-danger" title="Required">*</span></label>                                                        
                                                        <input type='text' name="sit_capacity" id="sit_capacity" value="{{ $car->sit_capacity }}" class="form-control"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" readonly required/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="status" class="control-label mb-10">Status </label>                                            
                                                        <select id="status" name="status" class="form-control selectable">                                                            
                                                            <option value="0" @if($car->status == 0) selected @endif>Pending</option>                                                            
                                                            <option value="1" @if($car->status == 1) selected @endif>Approve</option>                                                           
                                                        </select>
                                                        @if($errors->has('status'))
                                                            <span class="text-danger"> {{ $errors->first('status') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="verify" class="control-label mb-10">Verify </label>                                            
                                                        <select id="verify" name="verify" class="form-control selectable">                                                            
                                                            <option value="0" @if($car->verify == 0) selected @endif>No</option>                                                            
                                                            <option value="1" @if($car->verify == 1) selected @endif>Yes</option>                                                             
                                                        </select>
                                                        @if($errors->has('verify'))
                                                            <span class="text-danger"> {{ $errors->first('verify') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="row">                                           
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="tax_expired_date" class="control-label mb-10">Tax Expired Date</label>
                                                        <input type="date"  id="tax_expired_date" class="form-control datePicker" name="tax_expired_date" value="{{$car->tax_expired_date }}" />
                                                        @if($errors->has('tax_expired_date'))
                                                            <span class="text-danger"> {{ $errors->first('tax_expired_date') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="fitness_expired_date" class="control-label mb-10">Fitness Expired Date</label>
                                                        <input type="date" id="fitness_expired_date" class="form-control datePicker" name="fitness_expired_date" value="{{ $car->fitness_expired_date }}" />
                                                        @if($errors->has('fitness_expired_date'))
                                                            <span class="text-danger"> {{ $errors->first('fitness_expired_date') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="registration_expired_date" class="control-label mb-10">Registration Expired Date </label>
                                                        <input type="date" id="registration_expired_date" class="form-control datePicker" name="registration_expired_date" value="{{ $car->registration_expired_date }}" />
                                                        @if($errors->has('registration_expired_date'))
                                                            <span class="text-danger"> {{ $errors->first('registration_expired_date') }}</span>
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
@endsection
