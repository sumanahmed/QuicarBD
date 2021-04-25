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
            <li class="active"><span>Income</span></li>
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
                        <h6 class="panel-title txt-dark">All Income</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-header" style="border-bottom: 2px solid #ddd;margin-top:10px;">
                        <form action="{{ route('accounts.income') }}" method="get">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Phone</label>                                            
                                        <input type="text" name="phone" @if(isset($_GET['phone'])) value="{{ $_GET['phone'] }}" @endif placeholder="Enter Phone.." class="form-control" />
                                    </div>
                                </div>  
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Start Date</label>                                            
                                        <input type="date" name="start_date" @if(isset($_GET['start_date'])) value="{{ $_GET['start_date'] }}" @endif class="form-control" />
                                    </div>
                                </div>  
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label mb-10">End Date</label>                                            
                                        <input type="date" name="end_date" @if(isset($_GET['end_date'])) value="{{ $_GET['end_date'] }}" @endif  class="form-control" />
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
                                            <th>Adjust CashBack</th>
                                            <th>Discount</th>
                                            <th>Adjust Quicar Balance</th>
                                            <th>Online Payment</th>
                                            <th>Amount</th>
                                            <th>Payment Method</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Booking ID</th>
                                            <th>Trnx ID</th>
                                            <th>Phone</th>
                                            <th>Adjust CashBack</th>
                                            <th>Discount</th>
                                            <th>Adjust Quicar Balance</th>
                                            <th>Online Payment</th>
                                            <th>Amount</th>
                                            <th>Payment Method</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="carData">
                                        @foreach($incomes as $income)
                                            <tr>
                                                <td>{{ date('d M, Y', strtotime($income->created_at)) }}</td>
                                                <td>{{ getPaymentType($income->income_from) }}</td>
                                                <td>{{ $income->booking_id }}</td>
                                                <td>{{ $income->tnx_id }}</td>
                                                <td>{{ $income->phone }}</td>
                                                <td>{{ $income->adjust_cashback }}</td>
                                                <td>{{ $income->discount }}</td>
                                                <td>{{ $income->adjust_quicar_balance }}</td>
                                                <td>{{ $income->online_payment }}</td>
                                                <td>{{ $income->amount }}</td>
                                                <td>payment method</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $incomes->links('pagination::bootstrap-4') }}
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
