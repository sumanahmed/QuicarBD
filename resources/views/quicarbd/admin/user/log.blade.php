@extends('quicarbd.admin.layout.admin')
@section('title','User')
@section('content')
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">User</a></li>
            <li class="active"><span>All Log of {{ $user_name }}</span></li>
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
                        <h6 class="panel-title txt-dark">User App {{ $user_name }} Log</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="table-wrap">
                            <div class="table-responsive">
                                <table class="table table-hover display pb-30" >
                                    <thead>
                                        <tr>
                                            <th>Brand</th>
                                            <th>Model</th>
                                            <th>Device</th>
                                            <th>Page</th>
                                            <th>Car Rent Page</th>
                                            <th>Product Type</th>
                                            <th>Product</th>
                                            <th>Visit Time</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Brand</th>
                                            <th>Model</th>
                                            <th>Device</th>
                                            <th>Page</th>
                                            <th>Car Rent Page</th>
                                            <th>Product Type</th>
                                            <th>Product</th>
                                            <th>Visit Time</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="userData">
                                        @foreach($logs as $log)
                                            @php 
                                                $db_time = DateTime::createFromFormat('Y-m-d H:i:s', $log->visit_time, new DateTimeZone("UTC"));
                                                $visit_time = $db_time->format('j M, Y h:i A');
                                            @endphp
                                            <tr>
                                                <td>{{ $log->brand }}</td>
                                                <td>{{ $log->model }}</td>
                                                <td>{{ $log->device }}</td>
                                                <td>{{ $log->page }}</td>
                                                <td>{{ $log->car_rental_page == 0 ? 'No' : 'Yes' }}</td>
                                                <td>{{ productType($log->product_type) }}</td>
                                                <td>{{ $log->product_name }}</td>
                                                <td>{{ $visit_time }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $logs->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>	
        </div>
    </div>
</div>
@php 
    function productType($product_type) {
        if ($product_type == 1) {
            echo "Car Package";   
        } elseif ($product_type == 2) {
            echo "Hotel Package";   
        } elseif ($product_type == 3) {
            echo "Travel Package";   
        } else {
            echo "Others";
        }
    }
@endphp
@endsection
