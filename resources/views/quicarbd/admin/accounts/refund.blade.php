@extends('quicarbd.admin.layout.admin')
@section('title','Income')
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
            <li><a href="#">Accounts</a></li>
            <li class="active"><span>Refund</span></li>
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
                        <h6 class="panel-title txt-dark">All Refund</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-header" style="border-bottom: 2px solid #ddd;margin-top:10px;">
                        <form action="{{ route('accounts.refund') }}" method="get">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Start Date</label>                                            
                                        <input type="date" name="start_date" class="form-control" />
                                    </div>
                                </div>  
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label mb-10">End Date</label>                                            
                                        <input type="date" name="end_date" class="form-control" />
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
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Booking ID</th>
                                            <th>Trnx ID</th>
                                            <th>Phone</th>
                                            <th>Advanced</th>
                                            <th>Refund(%)</th>
                                            <th>Balance</th>
                                            <th>Cashback</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Booking ID</th>
                                            <th>Trnx ID</th>
                                            <th>Phone</th>
                                            <th>Advanced</th>
                                            <th>Refund(%)</th>
                                            <th>Balance</th>
                                            <th>Cashback</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="carData">
                                        @foreach($refunds as $refund)
                                            <tr>
                                                <td>{{ date('d M, Y', strtotime($refund->created_at)) }}</td>
                                                <td>{{ getPaymentType($refund->income_from) }}</td>
                                                <td>{{ $refund->booking_id }}</td>
                                                <td>{{ $refund->tnx_id }}</td>
                                                <td>{{ $refund->phone }}</td>
                                                <td>{{ $refund->refund_percentage != 0 ? $refund->amount * (100 / $refund->refund_percentage) : '' }}</td>
                                                <td>{{ $refund->refund_percentage }}</td>
                                                <td>{{ $refund->amount }}</td>
                                                <td>{{ $refund->cashback }}</td>
                                                <td>action</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $refunds->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</div>
@php 
    function getPaymentType($income_from) {
        if ($income_from == 1) {
            echo "Ride";
        } elseif ($income_from == 2) {
            echo "Car Package";
        } elseif ($income_from == 3) {
            echo "Hotel Package";
        } elseif ($income_from == 4) {
            echo "Travel Package";
        } elseif ($income_from == 5) {
            echo "Bonus";
        } elseif ($income_from == 6) {
            echo "Incentive";
        } elseif ($income_from == 7) {
            echo "Cashback";
        }
    }
@endphp
@endsection
