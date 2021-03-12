@extends('quicarbd.admin.layout.admin')
@section('title','Driver')
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
            <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Driver</a></li>
            <li class="active"><span>Edit Driver</span></li>
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
                        <h6 class="txt-dark capitalize-font"><i class="fa fa-user mr-10"></i>Driver Info</h6> 
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-sm-12 col-xs-12">
                                <div class="form-wrap">
                                    <form action="{{ route('driver.update', $driver->id) }}" method="post" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="form-body">     
                                            <div class="row">
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="name" class="control-label mb-10">Name <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="name" name="name" value="{{ $driver->name }}" placeholder="Enter Name" class="form-control" required>
                                                        @if($errors->has('name'))
                                                            <span class="text-danger"> {{ $errors->first('name') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="phone" class="control-label mb-10">Phone <span class="text-danger" title="Required">*</span></label>                                            
                                                        <input type="phone" id="phone" name="phone" value="{{ $driver->phone }}" placeholder="Enter Phone Number" class="form-control" required>
                                                        @if($errors->has('phone'))
                                                            <span class="text-danger"> {{ $errors->first('phone') }}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="dob" class="control-label mb-10">Date of Birth <span class="text-danger" title="Required">*</span></label>                                            
                                                        <input type="date" id="dob" name="dob" value="{{ $driver->dob }}" class="form-control datePicker" required>
                                                        @if($errors->has('dob'))
                                                            <span class="text-danger"> {{ $errors->first('dob') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="owner_id" class="control-label mb-10">Partner <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select id="owner_id" class="form-control" name="owner_id" required>
                                                            <option selected disabled>Select</option>
                                                            @foreach($owners as $owner)
                                                                <option value="{{ $owner->id }}" @if($owner->id == $driver->owner_id) selected @endif>{{ $owner->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('owner_id'))
                                                            <span class="text-danger"> {{ $errors->first('owner_id') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="nid" class="control-label mb-10">NID No <span class="text-danger" title="Required">*</span></label>                                            
                                                        <input type="nid" id="nid" name="nid" value="{{ $driver->nid }}" placeholder="Enter NID Number" class="form-control" required>
                                                        @if($errors->has('nid'))
                                                            <span class="text-danger"> {{ $errors->first('nid') }}</span>
                                                        @endif
                                                    </div>
                                                </div>                                     
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="license" class="control-label mb-10"> License <span class="text-danger" title="Required">*</span></label>               
                                                        <input type="text" name="license" value="{{ $driver->license }}" id="license" class="form-control" placeholder="Enter License No" required/>
                                                        @if($errors->has('license'))
                                                            <span class="text-danger"> {{ $errors->first('license') }}</span>
                                                        @endif
                                                    </div>
                                                </div> 
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="district_id" class="control-label mb-10">District <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select name="district_id" id="district_id" class="form-control" required>
                                                            <option selected disabled>select</option>
                                                            @foreach($districts as $district)
                                                                <option value="{{ $district->id }}" @if($district->id == $driver->district_id) selected @endif>{{ $district->value }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('district_id'))
                                                            <span class="text-danger"> {{ $errors->first('district_id') }}</span>
                                                        @endif
                                                    </div>
                                                </div>                                    
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="city_id" class="control-label mb-10">City <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select name="city_id" id="city_id" class="form-control" required>   
                                                            @foreach($cities as $city)
                                                                <option value="{{ $city->id }}" @if($city->id == $driver->city_id) selected @endif>{{ $city->name }}</option>
                                                            @endforeach                                   
                                                        </select>
                                                        @if($errors->has('city_id'))
                                                            <span class="text-danger"> {{ $errors->first('city_id') }}</span>
                                                        @endif
                                                    </div>
                                                </div>                                     
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="address" class="control-label mb-10">Address <span class="text-danger" title="Required">*</span></label>                                            
                                                        <input type="text" id="address" name="address" value="{{ $driver->address }}" placeholder="Enter Address" class="form-control" required>
                                                        @if($errors->has('address'))
                                                            <span class="text-danger"> {{ $errors->first('address') }}</span>
                                                        @endif
                                                    </div>
                                                </div> 
                                                                                  
                                                <div class="col-md-4">
                                                    <div class="form-group">                                        
                                                        <label for="driverPhoto" class="control-label mb-10">Driver Photo <span class="text-danger text-bold" title="Required Field">*</span></label>                                
                                                        <div class="avatar-upload">
                                                            <div class="avatar-edit">
                                                                <input type='file' name="driver_photo" id="dirverPhotoUpload" accept=".png, .jpg, .jpeg" required/>
                                                                <label for="dirverPhotoUpload"><i class="fa fa-edit"></i></label>
                                                            </div>
                                                            <div class="avatar-preview" style="width:100%">
                                                                <div id="dirverPhotoPreview" style="background-image: url();"></div>
                                                            </div>
                                                        </div>
                                                        @if($errors->has('driver_photo'))
                                                            <span class="text-danger"> {{ $errors->first('driver_photo') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="nid_font_pic" class="control-label mb-10">NID Front Image<span class="text-danger text-bold" title="Required Field">*</span></label>                                    
                                                        <div class="avatar-upload">
                                                            <div class="avatar-edit">
                                                                <input type='file' name="nid_font_pic" id="nidFrontUpload" accept=".png, .jpg, .jpeg" required/>
                                                                <label for="nidFrontUpload"><i class="fa fa-edit"></i></label>
                                                            </div>
                                                            <div class="avatar-preview" style="width:100%">
                                                                <div id="nidFrontPreview" style="background-image: url();"></div>
                                                            </div>
                                                        </div>
                                                        @if($errors->has('nid_font_pic'))
                                                            <span class="text-danger"> {{ $errors->first('nid_font_pic') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="nid_back_pic" class="control-label mb-10">NID Back Image<span class="text-danger text-bold" title="Required Field">*</span></label>                                    
                                                        <div class="avatar-upload">
                                                            <div class="avatar-edit">
                                                                <input type='file' name="nid_back_pic" id="nidBackUpload" accept=".png, .jpg, .jpeg" required/>
                                                                <label for="nidBackUpload"><i class="fa fa-edit"></i></label>
                                                            </div>
                                                            <div class="avatar-preview" style="width:100%">
                                                                <div id="nidBackPreview" style="background-image: url();"></div>
                                                            </div>
                                                        </div>
                                                        @if($errors->has('nid_back_pic'))
                                                            <span class="text-danger"> {{ $errors->first('nid_back_pic') }}</span>
                                                        @endif
                                                    </div>
                                                </div>    
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="license_font_pic" class="control-label mb-10">License Front Image<span class="text-danger text-bold" title="Required Field">*</span></label>                                    
                                                        <div class="avatar-upload">
                                                            <div class="avatar-edit">
                                                                <input type='file' name="license_font_pic" id="licenseFrontUpload" accept=".png, .jpg, .jpeg" required/>
                                                                <label for="licenseFrontUpload"><i class="fa fa-edit"></i></label>
                                                            </div>
                                                            <div class="avatar-preview" style="width:100%">
                                                                <div id="licenseFrontPreview" style="background-image: url();"></div>
                                                            </div>
                                                        </div>
                                                        @if($errors->has('license_font_pic'))
                                                            <span class="text-danger"> {{ $errors->first('license_font_pic') }}</span>
                                                        @endif
                                                    </div>
                                                </div>    
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="license_back_pic" class="control-label mb-10">License Back Image<span class="text-danger text-bold" title="Required Field">*</span></label>                                    
                                                        <div class="avatar-upload">
                                                            <div class="avatar-edit">
                                                                <input type='file' name="license_back_pic" id="licenseBackUpload" accept=".png, .jpg, .jpeg" required/>
                                                                <label for="licenseBackUpload"><i class="fa fa-edit"></i></label>
                                                            </div>
                                                            <div class="avatar-preview" style="width:100%">
                                                                <div id="licenseBackPreview" style="background-image: url();"></div>
                                                            </div>
                                                        </div>
                                                        @if($errors->has('nid_back_pic'))
                                                            <span class="text-danger"> {{ $errors->first('nid_back_pic') }}</span>
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
