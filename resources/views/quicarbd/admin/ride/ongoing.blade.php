@extends('quicarbd.admin.layout.admin')
@section('title','Ongoing Ride')
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
            <li><a href="#">Car Rent</a></li>
            <li class="active"><span>Ongoing Ride</span></li>
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
                        <h6 class="panel-title txt-dark">All Ongoing Ride</h6>
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
                                            <th>User</th>
                                            <th>Starting Area</th>
                                            <th>Destination Area</th>
                                            <th>Payment Status</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>User</th>
                                            <th>Starting Area</th>
                                            <th>Destination Area</th>
                                            <th>Payment Status</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="partnerData">
                                        @if(isset($rides) && count($rides) > 0)
                                            @foreach($rides as $ride)
                                                <tr class="partner-{{ $ride->id }}">
                                                    <td>{{ $ride->user_name }} <br/>{{ $ride->user_phone }}</td>
                                                    <td>{{ $ride->startig_area }}</td>
                                                    <td>{{ $ride->destination_area }}</td>
                                                    <td>{{ $ride->payment_status == 1 ? 'Unpaid' : 'Paid' }}</td>
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <a href="{{ route('ride.bidding', $ride->id) }}" class="btn btn-xs btn-info" title="Bidding"><i class="fa fa-eye"></i></a>
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
</div>
@endsection
@section('scripts')
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
