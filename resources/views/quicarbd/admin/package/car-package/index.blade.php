@extends('quicarbd.admin.layout.admin')
@section('title','Car Package')
@section('content')
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <a href="{{ route('car_package.create') }}" class="btn btn-success btn-anim"><i class="icon-plus"></i><span class="btn-text">Add New</span></a>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Package</a></li>
                <li class="active"><span>All Car Package</span></li>
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
                        <h6 class="panel-title txt-dark">All Car Packages</h6>
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
                                            <th>Duration(day)</th>
                                            <th>District</th>
                                            <th>Price</th>
                                            <th>Package Status</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Duration(day)</th>
                                            <th>District</th>
                                            <th>Price</th>
                                            <th>Package Status</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="packageData">
                                        @if(isset($car_packages) && count($car_packages) > 0)
                                            @php $i=1; @endphp
                                            @foreach($car_packages as $package)
                                                <tr class="car-package-{{ $package->id }}">
                                                    <td>{{ $package->name }}</td>
                                                    <td>{{ $package->duration }}</td>
                                                    <td>{{ $package->district_name }}</td>
                                                    <td>{{ $package->price }}</td>
                                                    <td>{{ $package->package_status == 0 ? 'Pause' : 'Active' }}</td>
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <a href="{{ route('package_review.index',['review_to' => 0, 'id' => $package->id]) }}" target="_blank" class="btn btn-xs btn-primary" title="Review"><i class="fa fa-eye"></i></a>
                                                        <a href="{{ route('car_package.edit', $package->id) }}" class="btn btn-xs btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                                                        <a href="#" class="btn btn-xs btn-raised btn-danger" data-toggle="modal" id="deleteCarPackage" data-target="#deleteCarPackageModal" data-id="{{ $package->id }}" title="Delete"><i class="fa fa-remove"></i></a>
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
    <div id="deleteCarPackageModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
	<script src="{{ asset('quicarbd/admin/js/car-package.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
