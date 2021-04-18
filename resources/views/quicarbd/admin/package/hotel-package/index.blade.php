@extends('quicarbd.admin.layout.admin')
@section('title','Hotel Package')
@section('content')
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <a href="{{ route('hotel_package.create') }}" class="btn btn-success btn-anim"><i class="icon-plus"></i><span class="btn-text">Add New</span></a>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Package</a></li>
                <li class="active"><span>All Hotel Package</span></li>
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
                        <h6 class="panel-title txt-dark">All Hotel Packages</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-header" style="border-bottom: 2px solid #ddd;margin-top:10px;">
                        <form action="{{ route('hotel_package.index') }}" method="get">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="hotel_name" class="control-label mb-10">Hotel Name</label>                                            
                                        <input type="text" name="hotel_name" @if(isset($_GET['hotel_name'])) value="{{ $_GET['hotel_name'] }}" @endif placeholder="Hotel Name" class="form-control">
                                    </div>
                                </div> 
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="price" class="control-label mb-10">Price</label>                                            
                                        <input type="text" name="price" @if(isset($_GET['price'])) value="{{ $_GET['price'] }}" @endif placeholder="Price" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="district_id" class="control-label mb-10">District</label>                                            
                                        <select name="district_id" class="form-control">
                                            <option value="0">Select</option>
                                            @foreach($districts as $district)
                                                <option value="{{ $district->id }}" @if(isset($_GET['district_id']) && $district->id == $_GET['district_id']) selected @endif>{{ $district->name }} </option>
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
                                            <th>Owner</th>
                                            <th>District</th>
                                            <th>City</th>
                                            <th>Price</th>
                                            <th>Package Status</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Owner</th>
                                            <th>District</th>
                                            <th>City</th>
                                            <th>Price</th>
                                            <th>Package Status</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="packageData">
                                        @if(isset($hotel_packages) && count($hotel_packages) > 0)
                                            @php $i=1; @endphp
                                            @foreach($hotel_packages as $hotel_package)
                                                <tr class="hotel-package-{{ $hotel_package->id }}">
                                                    <td>{{ $hotel_package->hotel_name }}</td>
                                                    <td>{{ $hotel_package->owner_name }} <br/>{{ $hotel_package->owner_phone }}</td>
                                                    <td>{{ $hotel_package->district_name }}</td>
                                                    <td>{{ $hotel_package->city_name }}</td>
                                                    <td>{{ $hotel_package->price }}</td>
                                                    <td>{{ $hotel_package->package_status == 0 ? 'Invisible' : 'Visible' }}</td>                          
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <a href="{{ route('package_review.index',['review_to' => 1, 'id' => $hotel_package->id]) }}" target="_blank" class="btn btn-xs btn-primary" title="Review"><i class="fa fa-eye"></i></a>
                                                        <a href="{{ route('hotel_package.details', $hotel_package->id) }}" class="btn btn-xs btn-raised btn-info" title="Details"><i class="fa fa-eye"></i></a>
                                                        <a href="{{ route('hotel_package.edit', $hotel_package->id) }}" class="btn btn-xs btn-raised btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                                                        <a href="{{ route('hotel_package.destroy', $hotel_package->id) }}" class="btn btn-xs btn-raised btn-danger" title="Delete"  data-toggle="modal" id="deleteCarPackage" data-target="#deleteHotelPackageModal" data-id="{{ $hotel_package->id }}"><i class="fa fa-remove"></i></a>
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
                                {{ $hotel_packages->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>	
        </div>
    </div>
        
    <!-- Delete Class Modal -->
    <div id="deleteHotelPackageModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
