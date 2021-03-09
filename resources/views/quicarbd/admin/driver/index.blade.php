@extends('quicarbd.admin.layout.admin')
@section('title','Driver')
@section('content')
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <button type="button"data-toggle="modal" data-target="#createDriverModal" class="btn btn-success btn-anim"><i class="icon-plus"></i><span class="btn-text">Add New</span></button>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li class="active"><span>Driver</span></li>
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
                        <h6 class="panel-title txt-dark">All Driver</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="table-wrap">
                            <div class="table-responsive">
                                <table id="datable_1" class="table table-hover display pb-30" >
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="allDriver">
                                        @if(isset($drivers) && count($drivers) > 0)
                                            @php $i=1; @endphp
                                            @foreach($drivers as $driver)
                                                <tr class="driver-{{ $driver->id }}">
                                                    <td>{{ $driver->name }}</td>
                                                    <td>{{ $driver->email }}</td>
                                                    <td>{{ $driver->phone }}</td>
                                                    <td><img src="http://quicarbd.com/{{ $driver->driver_photo }}" style="width:80px;height:60px"/>
                                                    <td>{{ $driver->account_status == 1 ? 'Active' : 'Inactive' }} </td>
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <a href="#" class="btn btn-xs btn-warning" data-toggle="modal" id="editDriver" data-target="#editDriverModal" data-id="{{ $driver->id }}" data-name="{{ $driver->name }}"
                                                            data-email="{{ $driver->email }}" data-phone="{{ $driver->phone }}" data-dob="{{ $driver->dob }}" data-owner_id="{{ $driver->owner_id }}" data-nid="{{ $driver->nid }}"
                                                            data-district_id="{{ $driver->district_id }}" data-city_id="{{ $driver->city_id }}" data-address="{{ $driver->address }}" data-license="{{ $driver->license }}" data-driver_photo="http://quicarbd.com/{{ $driver->driver_photo }}"
                                                            data-nid_font_pic="http://quicarbd.com/{{ $driver->nid_font_pic }}" data-nid_back_pic="http://quicarbd.com/{{ $driver->nid_back_pic }}" 
                                                            data-license_font_pic="http://quicarbd.com/{{ $driver->license_font_pic }}" data-license_back_pic="http://quicarbd.com/{{ $driver->license_back_pic }}"
                                                            ><i class="fa fa-edit"></i>
                                                        </a>
                                                        <button class="btn btn-xs btn-danger" data-toggle="modal" id="deleteDriver" data-target="#deleteDriverModal" data-id="{{ $driver->id }}" title="Delete"><i class="fa fa-remove"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" class="text-center">No Data Found</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>	
        </div>
    </div>

    <div class="modal fade" id="createDriverModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="exampleModalLabel1">Create</h5>
                </div>
                <div class="modal-body">
                    <form id="createDriverForm" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="mg-b-0" style="padding: 2px 15px !important;">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="name" class="control-label mb-10">Name <span class="text-danger text-bold" title="Required Field">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control"placeholder="Enter Name" required>
                                    <span class="text-danger nameError"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="email" class="control-label mb-10">Email </label>
                                    <input type="text" name="email" id="email" class="form-control"placeholder="Enter Email">
                                    <span class="text-danger nameError"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="phone" class="control-label mb-10">Phone <span class="text-danger text-bold" title="Required Field">*</span></label>
                                    <input type="text" name="phone" id="phone" class="form-control"placeholder="Enter Phone" required>
                                    <span class="text-danger phoneError"></span>
                                </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="dob" class="control-label mb-10">Date of Birth <span class="text-danger text-bold" title="Required Field">*</span></label>
                                    <input type="text" name="dob" id="dob" class="form-control datePicker" required>
                                    <span class="text-danger dobError"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="owner_id" class="control-label mb-10">Owner <span class="text-danger text-bold" title="Required Field">*</span></label>                                
                                    <select id="owner_id" class="form-control" name="owner_id">
                                        @foreach($owners as $owner)
                                            <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger ownerError"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="nid" class="control-label mb-10">NID <span class="text-danger text-bold" title="Required Field">*</span></label>
                                    <input type="text" name="nid" id="nid" class="form-control" placeholder="Enter NID Number" required>
                                    <span class="text-danger nidError"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="district_id" class="control-label mb-10">District <span class="text-danger text-bold" title="Required Field">*</span></label>                                
                                    <select name="district_id" id="district_id" class="form-control" required>
                                        <option selected disabled>select</option>
                                        @foreach($districts as $district)
                                            <option value="{{ $district->id }}">{{ $district->value }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger districtError"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="city_id" class="control-label mb-10">City <span class="text-danger text-bold" title="Required Field">*</span></label>
                                    <select name="city_id" id="city_id" class="form-control" required>                                      
                                    </select>
                                    <span class="text-danger cityError"></span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="license" class="control-label mb-10">License <span class="text-danger text-bold" title="Required Field">*</span></label>                                
                                    <input type="text" name="license" id="license" class="form-control" placeholder="License" required>
                                    <span class="text-danger licenseError"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="address" class="control-label mb-10">Address <span class="text-danger text-bold" title="Required Field">*</span></label>                                
                                    <input type="text" name="address" id="address" class="form-control" placeholder="Enter Address" required>
                                    <span class="text-danger addressError"></span>
                                </div>
                            </div>  
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="driver_photo" class="control-label mb-10">Driver Photo <span class="text-danger text-bold" title="Required Field">*</span></label>                                
                                    <input type="file" name="driver_photo" id="driver_photo" class="form-control" required>
                                    <span class="text-danger driverPhotoError"></span>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="nid_font_pic" class="control-label mb-10">NID Front Image<span class="text-danger text-bold" title="Required Field">*</span></label>
                                    <input type="file" name="nid_font_pic" id="nid_font_pic" class="form-control" required>
                                    <span class="text-danger nidFrontPicError"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nid_back_pic" class="control-label mb-10">NID Back Image<span class="text-danger text-bold" title="Required Field">*</span></label>
                                    <input type="file" name="nid_back_pic" id="nid_back_pic" class="form-control" required>
                                    <span class="text-danger nidBackPicError"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="license_font_pic" class="control-label mb-10">License Front Image<span class="text-danger text-bold" title="Required Field">*</span></label>
                                    <input type="file" name="license_font_pic" id="license_font_pic" class="form-control" required>
                                    <span class="text-danger licenceFrontPicError"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="license_back_pic" class="control-label mb-10">License Back Image<span class="text-danger text-bold" title="Required Field">*</span></label>
                                    <input type="file" name="license_back_pic" id="license_back_pic" class="form-control" required>
                                    <span class="text-danger licenseBackPicError"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="create">Save</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="editDriverModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="exampleModalLabel1">Edit</h5>
                </div>
                <div class="modal-body">
                    <form id="editDriverForm" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="mg-b-0" style="padding: 2px 15px !important;">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name" class="control-label mb-10">Name <span class="text-danger text-bold" title="Required Field">*</span></label>
                                    <input type="text" name="name" id="edit_name" class="form-control"placeholder="Enter Name" required>
                                    <input type="hidden" id="edit_id" />
                                    <span class="text-danger nameError"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email" class="control-label mb-10">Email </label>
                                    <input type="text" name="email" id="edit_email" class="form-control"placeholder="Enter Email">
                                    <span class="text-danger nameError"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="phone" class="control-label mb-10">Phone <span class="text-danger text-bold" title="Required Field">*</span></label>
                                    <input type="text" name="phone" id="edit_phone" class="form-control"placeholder="Enter Phone" required>
                                    <span class="text-danger phoneError"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="dob" class="control-label mb-10">Date of Birth <span class="text-danger text-bold" title="Required Field">*</span></label>
                                    <input type="text" name="dob" id="edit_dob" class="form-control datePicker" required>
                                    <span class="text-danger dobError"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="phone" class="control-label mb-10">Owner <span class="text-danger text-bold" title="Required Field">*</span></label>                                
                                    <select id="edit_owner_id" class="form-control" name="owner_id">
                                        @foreach($owners as $owner)
                                            <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger ownerError"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nid" class="control-label mb-10">NID <span class="text-danger text-bold" title="Required Field">*</span></label>
                                    <input type="text" name="nid" id="edit_nid" class="form-control" placeholder="Enter NID Number" required>
                                    <span class="text-danger nidError"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="edit_district_id" class="control-label mb-10">District <span class="text-danger text-bold" title="Required Field">*</span></label>                                
                                    <select name="district_id" id="edit_district_id" class="form-control" required>
                                        @foreach($districts as $district)
                                            <option value="{{ $district->id }}">{{ $district->value }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger districtError"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="edit_city_id" class="control-label mb-10">City <span class="text-danger text-bold" title="Required Field">*</span></label>
                                    <select name="city_id" id="edit_city_id" class="form-control" required>                                      
                                    </select>
                                    <span class="text-danger cityError"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="address" class="control-label mb-10">Address <span class="text-danger text-bold" title="Required Field">*</span></label>                                
                                    <input type="text" name="address" id="edit_address" class="form-control" placeholder="Enter Address" required>
                                    <span class="text-danger addressError"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="license" class="control-label mb-10">License <span class="text-danger text-bold" title="Required Field">*</span></label>                                
                                    <input type="text" name="license" id="edit_license" class="form-control" placeholder="License" required>
                                    <span class="text-danger licenseError"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="image" class="control-label mb-10">Current Driver Photo <span class="text-danger text-bold" title="Required Field">*</span></label>                                
                                    <img src="" id="previous_driver_photo" style="width:80px;height:80px;"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="image">Update Driver Photo <span class="text-danger text-bold" title="Required Field">*</span></label>                                
                                    <input type="file" name="driver_photo" id="edit_driver_photo" class="form-control">
                                    <span class="text-danger imageError"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="license" class="control-label mb-10">Current NID Front Pic <span class="text-danger text-bold" title="Required Field">*</span></label>  
                                    <img src="" id="previous_nid_font_pic" style="width:80px;height:80px;"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="license" class="control-label mb-10">Update NID Front <span class="text-danger text-bold" title="Required Field">*</span></label>
                                    <input type="file" name="nid_font_pic" id="edit_nid_font_pic" class="form-control">
                                    <span class="text-danger nidFrontError"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="license" class="control-label mb-10">Current NID Back Pic <span class="text-danger text-bold" title="Required Field">*</span></label>  
                                    <img src="" id="previous_nid_back_pic" style="width:80px;height:80px;"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="license" class="control-label mb-10">Update NID Back <span class="text-danger text-bold" title="Required Field">*</span></label>
                                    <input type="file" name="nid_back_pic" id="edit_nid_back_pic" class="form-control">
                                    <span class="text-danger nidBackError"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="license" class="control-label mb-10">Current License Front <span class="text-danger text-bold" title="Required Field">*</span></label>  
                                    <img src="" id="previous_license_font_pic" style="width:80px;height:80px;"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="license" class="control-label mb-10">Update License Front <span class="text-danger text-bold" title="Required Field">*</span></label>
                                    <input type="file" name="license_font_pic" id="edit_license_font_pic" class="form-control">
                                    <span class="text-danger licenseFrontError"></span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="license" class="control-label mb-10">Current License Back <span class="text-danger text-bold" title="Required Field">*</span></label>  
                                    <img src="" id="previous_license_back_pic" style="width:80px;height:80px;"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="license" class="control-label mb-10">Update License Back <span class="text-danger text-bold" title="Required Field">*</span></label>
                                    <input type="file" name="license_back_pic" id="edit_license_back_pic" class="form-control">
                                    <span class="text-danger licenseBackError"></span>
                                </div>
                            </div>
                        </div>   
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="update">Update</button>
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
	<script src="{{ asset('quicarbd/admin/js/driver.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
