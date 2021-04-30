@extends('quicarbd.admin.layout.admin')
@section('title','Pricing')
@section('content')
@php 
    $helper = new App\Http\Lib\Helper;
@endphp
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <a href="{{ route('pricing.create') }}" class="btn btn-success btn-anim"><i class="icon-plus"></i><span class="btn-text">Add New</span></a>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Dashboard</a></li>
                <li class="active"><span>Pricing</span></li>
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
                        <h6 class="panel-title txt-dark">All Pricing</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-header" style="border-bottom: 2px solid #ddd;margin-top:10px;">
                        <form action="{{ route('pricing.index') }}" method="get">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="starting_district" class="control-label mb-10">Starting District</label>                                            
                                        <select name="starting_district" class="form-control selectable">
                                            <option value="0">Select</option>
                                            @foreach($districts as $district)
                                                <option value="{{ $district->id }}" @if(isset($_GET['starting_district']) && $district->id == $_GET['starting_district']) selected @endif>{{ $district->value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> 
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="destination_district" class="control-label mb-10">Destination District</label>                                            
                                        <select name="destination_district" class="form-control selectable">
                                            <option value="0">Select</option>
                                            @foreach($districts as $district)
                                                <option value="{{ $district->id }}" @if(isset($_GET['destination_district']) && $district->id == $_GET['destination_district']) selected @endif>{{ $district->value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="car_type" class="control-label mb-10">Car Type</label>                                            
                                        <select name="car_type" class="form-control selectable">
                                            <option value="0">Select</option>
                                            @foreach($car_types as $car_type)
                                                <option value="{{ $car_type->id }}" @if(isset($_GET['car_type']) && $car_type->id == $_GET['car_type']) selected @endif>{{ $car_type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="ride_type" class="control-label mb-10">Ride Type</label>                                            
                                        <select name="ride_type" class="form-control selectable">
                                            <option value="0" @if(isset($_GET['ride_type']) && $_GET['ride_type'] == 0) selected @endif>One Way</option>
                                            <option value="1" @if(isset($_GET['ride_type']) && $_GET['ride_type'] == 1) selected @endif>Round Way</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="minimum_price" class="control-label mb-10">Minimum Price</label>                                            
                                        <input type="text" name="minimum_price" @if(isset($_GET['minimum_price'])) value="{{ $_GET['minimum_price'] }}" @endif placeholder="Mimimum Price" class="form-control">
                                    </div>
                                </div> 
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="maximum_price" class="control-label mb-10">Maximum Price</label>                                            
                                        <input type="text" name="maximum_price" @if(isset($_GET['maximum_price'])) value="{{ $_GET['maximum_price'] }}" @endif placeholder="Maximum Price" class="form-control">
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
                                            <th>Starting District</th>
                                            <th>Destination District</th>
                                            <th>Car Type</th>
                                            <th>Ride Type</th>
                                            <th>Minimum Price</th>
                                            <th>Maximum Price</th>
                                            <th>Extra Note</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="allPricing">
                                        @foreach($pricings as $pricing)
                                            <tr class="pricing-{{ $pricing->id }}">
                                                <td>{{ $helper->getDistrict($pricing->starting_district) }}</td>
                                                <td>{{ $helper->getDistrict($pricing->destination_district) }}</td>
                                                <td>{{ $pricing->car_type_name }}</td>
                                                <td>{{ $pricing->ride_type == 0 ? 'One Way' : 'Round Way' }}</td>
                                                <td>{{ $pricing->minimum_price }}</td>
                                                <td>{{ $pricing->maximum_price }}</td>
                                                <td>{{ $pricing->extra_note }}</td>
                                                <td style="vertical-align: middle;text-align: center;">
                                                    <a href="{{ route('pricing.edit', $pricing->id) }}" class="btn btn-xs btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                                                    <button class="btn btn-xs btn-danger" data-toggle="modal" id="deletePricing" data-target="#deletePricingModal" data-id="{{ $pricing->id }}" title="Delete"><i class="fa fa-remove"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $pricings->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>	
        </div>
    </div>

    <!-- Delete Class Modal -->
    <div class="modal fade" id="deletePricingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title mb-10" id="exampleModalLabel3">Are you sure to delete ?</h5>
                    <input type="hidden" name="del_id"/>
                    <button type="button" class="btn btn-xs btn-danger btn-raised mr-2" id="destroyPricing"><i class="fas fa-trash-alt"></i> Proceed</button>
                    <button type="button" class="btn btn-xs btn-warning btn-raised" data-dismiss="modal" aria-label="Close"><i class="fas fa-backspace"></i> Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
	<script>
	    //open delete driver modal
        $(document).on('click', '#deletePricing', function () {
            $('#deletePricingModal').modal('show');
            $('input[name=del_id]').val($(this).data('id'));
         });
        
        //destroy driver
        $("#destroyPricing").click(function(){
            $.ajax({
                type: 'POST',
                url: '/admin/pricing/destroy',
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                data: {
                    id: $('input[name=del_id]').val()
                },
                success: function (response) {
                    $('#deletePricingModal').modal('hide');
                    $('.pricing-' + $('input[name=del_id]').val()).remove();
                    toastr.success(response.message)
                }
            });
        });
	</script>
@endsection
