@extends('quicarbd.admin.layout.admin')
@section('title','Travel Package')
@section('content')
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <a href="{{ route('travel_package.create') }}" class="btn btn-success btn-anim"><i class="icon-plus"></i><span class="btn-text">Add New</span></a>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Package</a></li>
                <li class="active"><span>All Travel Package</span></li>
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
                        <h6 class="panel-title txt-dark">All Travel Packages</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="table-wrap">
                            <div class="table-responsive">
                                <table id="datable_1" class="table table-hover display pb-30" >
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Tour Name</th>
                                            <th>Organizer</th>
                                            <th>District</th>
                                            <th>Status</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="allCarPackage">
                                        @if(isset($travel_packages) && count($travel_packages) > 0)                                  
                                            @foreach($travel_packages as $travel_package)
                                                <tr class="travel-package-{{ $travel_package->id }}">
                                                    <td>{{ $travel_package->tour_name }}</td>
                                                    <td>{{ $travel_package->organizer_name }}, {{ $travel_package->organizer_phone }}</td>
                                                    <td>{{ $travel_package->district_name }}</td>
                                                    @if($travel_package->status == 0)
                                                        <td>Pending</td>
                                                    @elseif($travel_package->status == 1)
                                                        <td>Success</td>
                                                    @else
                                                        <td>Cancel</td>
                                                    @endif                                          
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <a href="{{ route('package_review.index',['review_to' => 2, 'id' => $travel_package->id]) }}" target="_blank" class="btn btn-xs btn-primary" title="Review"><i class="fa fa-eye"></i></a>
                                                        <a href="{{ route('travel_package.edit', $travel_package->id) }}" class="btn btn-xs btn-raised btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                                                        <a href="#" class="btn btn-xs btn-raised btn-danger" data-toggle="modal" id="deleteTravelPackage" data-target="#deleteTravelPackageModal" data-id="{{ $travel_package->id }}" title="Delete"><i class="fa fa-remove"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center">No Data Found</td>
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
    <div id="deleteTravelPackageModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title mb-10" id="exampleModalLabel">Are you sure to delete ?</h5>
                    <input type="hidden" name="del_id" id="del_id" />
                    <button type="button" class="btn btn-xs btn-danger btn-raised mr-2" id="destroyTravelPackage"><i class="fas fa-trash-alt"></i> Proceed</button>
                    <button type="button" class="btn btn-xs btn-warning btn-raised" data-dismiss="modal" aria-label="Close"><i class="fas fa-backspace"></i> Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
	<script src="{{ asset('quicarbd/admin/js/travel-package.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
