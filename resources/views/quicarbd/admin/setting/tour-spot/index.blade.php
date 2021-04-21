@extends('quicarbd.admin.layout.admin')
@section('title','Tour Spot')
@section('content')
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <button type="button"data-toggle="modal" data-target="#createSpotModal" class="btn btn-success btn-anim"><i class="icon-plus"></i><span class="btn-text">Add New</span></button>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#"><span>Setting</span></a></li>
            <li class="active"><span>Tour Spot</span></li>
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
                        <h6 class="panel-title txt-dark">All Tour Spot</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-header" style="border-bottom: 2px solid #ddd;margin-top:10px;">
                        <form action="{{ route('setting.tour_spot.index') }}" method="get">
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
                                            <th>Address</th>
                                            <th>Image</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="allSpot">
                                        @if(isset($spots) && count($spots) > 0)                                  
                                            @foreach($spots as $spot)
                                                <tr class="spot-{{ $spot->id }}">
                                                    <td>{{ $spot->name }}</td>
                                                    <td>{{ $spot->bn_name }}</td>
                                                    <td>{{ $spot->district_name }}</td>
                                                    <td>{{ $spot->address != null ? $spot->address : '' }}</td>
                                                    <td><img src="http://quicarbd.com/{{ $spot->image }}" style="width:80px;height:60px"/>                                            
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <buttton class="btn btn-xs btn-raised btn-warning" data-toggle="modal" id="editSpot" data-target="#editSpotModal" data-id="{{ $spot->id }}" data-district_id="{{ $spot->district_id }}" data-name="{{ $spot->name }}" data-bn_name="{{ $spot->bn_name }}" data-address="{{ $spot->address }}" data-image="{{ $spot->image }}" title="Edit"><i class="fa fa-edit"></i></buttton>
                                                        <buttton class="btn btn-xs btn-raised btn-danger" data-toggle="modal" id="deleteSpot" data-target="#deleteSpotModal" data-id="{{ $spot->id }}" title="Delete"><i class="fa fa-remove"></i></buttton>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center">No Data Found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                {{ $spots->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>	
        </div>
    </div>

    <div class="modal fade" id="createSpotModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="exampleModalLabel1">Create</h5>
                </div>
                <div class="modal-body">
                    <form id="createSpotForm" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }} {{ method_field('POST') }}
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
                        <div class="form-group">
                            <label for="address" class="control-label mb-10">Address <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <input type="text" name="address" id="address" class="form-control" placeholder="Enter Address">
                            <span class="text-danger addressError"></span>
                        </div>
                        <div class="form-group">
                            <label for="address" class="control-label mb-10">Image <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <input type="file" name="image" id="image" class="form-control" required>
                            <span class="text-danger imageError"></span>
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
    
    <div class="modal fade" id="editSpotModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="exampleModalLabel1">Edit</h5>
                </div>
                <div class="modal-body">
                    <form id="editSpotForm" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }} {{ method_field('POST') }}
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
                        <div class="form-group">
                            <label for="edit_address" class="control-label mb-10">Name(Bn) <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <input type="text" name="address" id="edit_address" class="form-control" placeholder="Enter Address">
                            <span class="text-danger addressError"></span>
                        </div>
                        <div class="form-group">
                            <label for="image" class="control-label mb-10">Previous Image <span class="text-danger text-bold" title="Required Field">*</span></label>                                
                            <img src="" id="previous_image" style="width:80px;height:80px;"/>
                        </div>
                        <div class="form-group">
                            <label for="image" class="control-label mb-10">Update Image <span class="text-danger text-bold" title="Required Field">*</span></label>                                
                            <input type="file" name="image" id="edit_image" class="form-control">
                            <span class="text-danger imageError"></span>
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
    <div id="deleteSpotModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title mb-10" id="exampleModalLabel">Are you sure to delete ?</h5>
                    <input type="hidden" name="del_id"/>
                    <button type="button" class="btn btn-xs btn-danger btn-raised mr-2" id="destroySpot"><i class="fas fa-trash-alt"></i> Proceed</button>
                    <button type="button" class="btn btn-xs btn-warning btn-raised" data-dismiss="modal" aria-label="Close"><i class="fas fa-backspace"></i> Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
	<script src="{{ asset('quicarbd/admin/js/tour-spot.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
