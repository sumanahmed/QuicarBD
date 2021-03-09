@extends('quicarbd.admin.layout.admin')
@section('title','Car Brand')
@section('content')
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <button type="button"data-toggle="modal" data-target="#createBrandModal" class="btn btn-success btn-anim"><i class="icon-plus"></i><span class="btn-text">Add New</span></button>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#"><span>Car</span></a></li>
            <li><a href="#"><span>Car Info</span></a></li>
            <li class="active"><span>Car Brand</span></li>
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
                        <h6 class="panel-title txt-dark">All Car Brand</h6>
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
                                            <th>Type</th>                                   
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="allBrand">
                                            @if(isset($brands) && count($brands) > 0)
                                                @foreach($brands as $brand)
                                                    <tr class="brand-{{ $brand->id }}">
                                                        <td>{{ $brand->value }}</td>
                                                        <td>{{ $brand->car_type_name }}</td>
                                                        <td style="vertical-align: middle;text-align: center;">
                                                            <a href="#" class="btn btn-xs btn-warning" data-toggle="modal" id="editBrand" data-target="#editBrandModal" data-id="{{ $brand->id }}" data-name="{{ $brand->value }}" data-car_type_id="{{ $brand->car_type_id }}" title="Edit"><i class="fa fa-edit"></i></a>
                                                            <a href="#" class="btn btn-xs btn-danger" data-toggle="modal" id="deleteBrand" data-target="#deleteBrandModal" data-id="{{ $brand->id }}" title="Delete"><i class="fa fa-remove"></i></a>
                                                            <a href="{{ route('model.index',['car_type_id'=> $brand->car_type_id, 'car_brand_id'=>$brand->id]) }}" class="btn btn-xs btn-primary" title="Show Model">Model</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="3" class="text-center">No Data Found</td>
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

    <div class="modal fade" id="createBrandModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="exampleModalLabel1">Create</h5>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="name" class="control-label mb-10">Name <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <input type="text" name="name" id="name" class="form-control"placeholder="Enter Name" required>
                            <span class="text-danger nameError"></span>
                        </div>
                        <div class="form-group">
                            <label for="car_type_id" class="control-label mb-10">Car Type <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <select id="car_type_id" name="car_type_id" class="form-control">
                                @foreach($car_types as $car_type)
                                    <option value="{{ $car_type->id }}">{{ $car_type->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger seatError"></span>
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
    
    <div class="modal fade" id="editBrandModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="exampleModalLabel1">Edit</h5>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="edit_name" class="control-label mb-10">Name <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <input type="text" name="name" id="edit_name" class="form-control"placeholder="Enter Name" required>
                            <input type="hidden" id="edit_id" />
                            <span class="text-danger nameError"></span>
                        </div>
                        <div class="form-group">
                            <label for="edit_car_type_id" class="control-label mb-10">Seat <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <select id="edit_car_type_id" name="car_type_id" class="form-control">
                                @foreach($car_types as $car_type)
                                    <option value="{{ $car_type->id }}">{{ $car_type->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger nameError"></span>
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
    <div id="deleteBrandModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title mb-10" id="exampleModalLabel">Are you sure to delete ?</h5>
                    <input type="hidden" name="del_id"/>
                    <button type="button" class="btn btn-xs btn-danger btn-raised mr-2" id="destroyBrand"><i class="fas fa-trash-alt"></i> Proceed</button>
                    <button type="button" class="btn btn-xs btn-warning btn-raised" data-dismiss="modal" aria-label="Close"><i class="fas fa-backspace"></i> Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
	<script src="{{ asset('quicarbd/admin/js/brand.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
