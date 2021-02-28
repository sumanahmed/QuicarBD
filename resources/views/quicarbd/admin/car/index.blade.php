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
                    <div class="panel-body">
                        <div class="table-wrap">
                            <div class="table-responsive">
                                <table id="datable_1" class="table table-hover display pb-30" >
                                    <thead>
                                        <tr>
                                            <th>Registration No</th>
                                            <th>Owner Name</th>
                                            <th>Owner Phone</th>
                                            <th>Current Status</th>
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
                                                    <td>{{ $car->owner_name }}</td>
                                                    <td>{{ $car->owner_phone }}</td>
                                                    <td>{{ $car->status == 0 ? 'Off Ride' : 'On Ride' }}</td>
                                                    <th><img src="http://quicarbd.com/{{ $car->carImage }}" style="width:80px;height:60px;"/></th>
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <a href="#" class="btn btn-xs btn-success" title="Verify"><i class="fa fa-unlock-alt"></i></a>
                                                        <a href="{{ route('car.edit', $car->id) }}" class="btn btn-xs btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                                                        <a href="{{ route('car.details', $car->id) }}" class="bt btn-xs btn-info" title="Details"><i class="fa fa-eye"></i></a>
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
	<script src="{{ asset('quicarbd/admin/js/driver.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
