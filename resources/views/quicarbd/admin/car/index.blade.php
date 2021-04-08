@extends('quicarbd.admin.layout.admin')
@section('title','Car')
@section('content')
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <a href="{{ route('car.create') }}" class="btn btn-success btn-anim"><i class="icon-plus"></i><span class="btn-text">Add New</span></a>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Car</a></li>
            <li class="active"><span>Add New</span></li>
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
                        <h6 class="panel-title txt-dark">All Car</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-header" style="border-bottom: 2px solid #ddd;margin-top:10px;">
                        <form action="{{ route('car.index') }}" method="get">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="carType" class="control-label mb-10">Car Type</label>                                            
                                        <select id="carType" name="carType" class="form-control selectable">
                                            <option value="0">Select</option>
                                            @foreach($types as $type)
                                                <option value="{{ $type->name }}" @if(isset($_GET['carType']) && $type->name == $_GET['carType']) selected @endif>{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>                                   
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="carBrand" class="control-label mb-10">Car Brand </label>                                            
                                        <select id="carBrand" name="carBrand" class="form-control selectable">
                                        </select>
                                    </div>
                                </div>                                    
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="carModel" class="control-label mb-10">Car Model </label>                                            
                                        <select id="carModel" name="carModel" class="form-control selectable">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="carYear" class="control-label mb-10">Car Year </label>                                            
                                        <select id="carYear" name="carYear" class="form-control selectable">
                                            <option value="0">Select</option>
                                            @foreach($years as $year)
                                                <option value="{{ $year->name }}" @if(isset($_GET['year']) && $year->name == $_GET['year']) selected @endif>{{ $year->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="status" class="control-label mb-10">Status </label>                                            
                                        <select id="status" name="status" class="form-control selectable">
                                            <option value="5">Select</option>
                                            <option value="0" @if(isset($_GET['status']) && $_GET['status'] == 0) selected @endif>Pending</option>
                                            <option value="1" @if(isset($_GET['status']) && $_GET['status'] == 1) selected @endif>Approve</option>
                                        </select>
                                    </div>
                                </div> 
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="owner_id" class="control-label mb-10">Partner </label>                                            
                                        <select id="owner_id" name="owner_id" class="form-control selectable">
                                            <option value="0">Select</option>
                                            @foreach($owners as $owner)
                                                <option value="{{ $owner->id }}" @if(isset($_GET['owner_id']) && $owner->id == $_GET['owner_id']) selected @endif>{{ $owner->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="carRegisterNumber" class="control-label mb-10">Car Registration No </label>                                            
                                        <input type="text" name="carRegisterNumber" @if(isset($_GET['carRegisterNumber'])) value="{{ $_GET['carRegisterNumber'] }}" @endif class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="phone" class="control-label mb-10">Phone </label>                                            
                                        <input type="text" name="phone" @if(isset($_GET['phone'])) value="{{ $_GET['phone'] }}" @endif class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="perPage" class="control-label mb-10">Per Page </label>                                            
                                        <select id="perPage" name="perPage" class="form-control selectable">
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="30">30</option>
                                            <option value="40">40</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
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
                                            <th>Registration No</th>
                                            <th>Owner</th>
                                            <th>Type</th>
                                            <th>Brand</th>
                                            <th>Model</th>
                                            <th>Status</th>
                                            <th>Year</th>
                                            <th>Image</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="carData">
                                        @if(isset($cars) && count($cars) > 0)
                                            @php $i=1; @endphp
                                            @foreach($cars as $car)
                                                <tr class="car-{{ $car->id }}">
                                                    <td>{{ $car->carRegisterNumber }}</td>
                                                    <td><a href="{{ route('partner.details', $car->owner_id) }}" target="_blank">{{ $car->owner_name }}<br/>{{ $car->owner_phone }}</a></td>
                                                    <td>{{ $car->carType }}</td>
                                                    <td>{{ $car->carBrand }}</td>
                                                    <td>{{ $car->carModel }}</td>
                                                    <td>{{ $car->status == 0 ? 'Pending' : 'Approve' }}</td>
                                                    <td>{{ $car->carYear }}</td>
                                                    <th><img src="http://quicarbd.com/{{ $car->carImage }}" style="width:80px;height:60px;"/></th>
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <a href="{{ route('car.show', $car->id) }}" target="_blank" class="btn btn-xs btn-primary" title="Show"><i class="fa fa-eye"></i></a>
                                                        <a href="{{ route('car.edit', $car->id) }}" target="_blank" class="btn btn-xs btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                                                        <button class="btn btn-xs btn-raised btn-danger" data-toggle="modal" id="deleteCar" data-target="#deleteCarModal" data-id="{{ $car->id }}" title="Delete"><i class="fa fa-remove"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="10" class="text-center">No Data Found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                {{ $cars->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>	
        </div>
    </div>
    
    <!-- Delete Class Modal -->
    <div id="deleteCarModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title mb-10" id="exampleModalLabel">Are you sure to delete ?</h5>
                    <input type="hidden" name="del_id"/>
                    <button type="button" class="btn btn-xs btn-danger btn-raised mr-2" id="destroyCar"><i class="fas fa-trash-alt"></i> Proceed</button>
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
