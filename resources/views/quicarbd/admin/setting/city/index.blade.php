@extends('quicarbd.admin.layout.admin')
@section('title','City')
@section('content')
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <button type="button"data-toggle="modal" data-target="#createCityModal" class="btn btn-success btn-anim"><i class="icon-plus"></i><span class="btn-text">Add New</span></button>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#"><span>Setting</span></a></li>
            <li class="active"><span>City</span></li>
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
                        <h6 class="panel-title txt-dark">All City</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-header" style="border-bottom: 2px solid #ddd;margin-top:10px;">
                        <form action="{{ route('setting.city.index') }}" method="get">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Name</label>                                            
                                        <input type="text" name="name" @if(isset($_GET['name'])) value="{{ $_GET['name'] }}" @endif placeholder="Enter Name.." class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="district_id" class="control-label mb-10">District</label>                                            
                                        <select name="district_id" class="form-control">
                                            <option value="0">Select</option>
                                            @foreach($districts as $district)
                                                <option value="{{ $district->id }}" @if(isset($_GET['district_id']) && $district->id == $_GET['district_id']) selected @endif>{{ $district->value }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>  
                                <div class="col-md-2">
                                    <div class="form-group" style="margin-top:30px;">
                                        <button type="submit" class="btn btn-primary btn-sm">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="panel-body">
                        <div class="table-wrap">
                            <div class="table-responsive">
                                <table class="table table-hover display pb-30" >
                                    <thead>
                                        <tr>                                  
                                            <th>Name</th>                                     
                                            <th>Name(Bn)</th>                                     
                                            <th>District</th>                                     
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="allCity">
                                        @if(isset($citys) && count($citys) > 0)
                                            @foreach($citys as $city)
                                                <tr class="city-{{ $city->id }}">
                                                    <td>{{ $city->name }}</td>
                                                    <td>{{ $city->bn_name }}</td>
                                                    <td>{{ $city->district_name }}</td>
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <a href="#" class="btn btn-xs btn-raised btn-warning" data-toggle="modal" id="editCity" data-target="#editCityModal" data-id="{{ $city->id }}" data-name="{{ $city->name }}" data-bn_name="{{ $city->bn_name }}" data-district_id="{{ $city->district_id }}" title="Edit"><i class="fa fa-edit"></i></a>
                                                        <a href="#" class="btn btn-xs btn-raised btn-danger" data-toggle="modal" id="deleteCity" data-target="#deleteCityModal" data-id="{{ $city->id }}" title="Delete"><i class="fa fa-remove"></i></a>
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

    <div class="modal fade" id="createCityModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="exampleModalLabel1">Create</h5>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="name" class="control-label mb-10">Name(En) <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <input type="text" name="name" id="name" class="form-control"placeholder="Enter Name in English" required>
                            <span class="text-danger nameError"></span>
                        </div>
                        <div class="form-group">
                            <label for="bn_name" class="control-label mb-10">Name(Bn) <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <input type="text" name="bn_name" id="bn_name" class="form-control"placeholder="Enter Name in Bangla" required>
                            <span class="text-danger nameBnError"></span>
                        </div>
                        <div class="form-group">
                            <label for="district_id" class="control-label mb-10">District <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <select id="district_id" class="form-control" required>
                                <option selected disabled>Select</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}">{{ $district->value }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger districtError"></span>
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
    
    <div class="modal fade" id="editCityModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="exampleModalLabel1">Edit</h5>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="edit_name" class="control-label mb-10">Name(En) <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <input type="text" name="name" id="edit_name" class="form-control"placeholder="Enter Name in English" required>
                            <input type="hidden" id="edit_id" />
                            <span class="text-danger nameError"></span>
                        </div>
                        <div class="form-group">
                            <label for="edit_bn_name" class="control-label mb-10">Name(Bn) <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <input type="text" name="bn_name" id="edit_bn_name" class="form-control"placeholder="Enter Name in Bangla" required>
                            <span class="text-danger nameBnError"></span>
                        </div>
                        <div class="form-group">
                            <label for="edit_district_id" class="control-label mb-10">District <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <select id="edit_district_id" class="form-control" required>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}">{{ $district->value }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger districtError"></span>
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
    <div id="deleteCityModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title mb-10" id="exampleModalLabel">Are you sure to delete ?</h5>
                    <input type="hidden" name="del_id"/>
                    <button type="button" class="btn btn-xs btn-danger btn-raised mr-2" id="destroyCity"><i class="fas fa-trash-alt"></i> Proceed</button>
                    <button type="button" class="btn btn-xs btn-warning btn-raised" data-dismiss="modal" aria-label="Close"><i class="fas fa-backspace"></i> Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
	<script src="{{ asset('quicarbd/admin/js/city.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
