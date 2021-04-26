@extends('quicarbd.admin.layout.admin')
@section('title','Transaction')
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
            <li class="active"><span>Transaction History</span></li>
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
                        <h6 class="panel-title txt-dark">All Transaction History</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-header" style="border-bottom: 2px solid #ddd;margin-top:10px;">
                        <form action="{{ route('accounts.transaction') }}" method="get">
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
                                    <div class="form-group">
                                        <label for="type" class="control-label mb-10">Type</label>                                            
                                        <select name="type" class="form-control">
                                            <option value="100">Select</option>
                                            <option value="0" @if(isset($_GET['type']) && $_GET['type'] == 0) selected @endif>Debit</option>
                                            <option value="1" @if(isset($_GET['type']) && $_GET['type'] == 1) selected @endif>Credit</option>
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
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Reason</th>
                                            <th>Trnx ID</th>
                                            <th>Phone</th>
                                            <th>Tnx Type</th>
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
                                            <th>Reason</th>
                                            <th>Trnx ID</th>
                                            <th>Phone</th>
                                            <th>Tnx Type</th>
                                            <th>Discount</th>
                                            <th>Adjust Quicar Balance</th>
                                            <th>Online Payment</th>
                                            <th>Amount</th>
                                            <th>Payment Method</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="carData">
                                        @foreach($transactions as $transaction)
                                            <tr>
                                                <td>{{ date('d M, Y', strtotime($transaction->created_at)) }}</td>
                                                <td>{{ getPaymentType($transaction->income_from) }}</td>
                                                <td>{{ $transaction->reason }}</td>
                                                <td>{{ $transaction->tnx_id }}</td>
                                                <td>{{ $transaction->phone }}</td>
                                                <td>{{ $transaction->type == 0 ? 'Debit' : 'Credit' }}</td>
                                                <td>{{ $transaction->discount }}</td>
                                                <td>{{ $transaction->adjust_quicar_balance }}</td>
                                                <td>{{ $transaction->online_payment }}</td>
                                                <td>{{ $transaction->amount }}</td>
                                                <td>payment method</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $transactions->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</div>
@php 
    function getPaymentType($transaction_from) {
        if ($transaction_from == 1) {
            echo "Ride";
        } elseif ($transaction_from == 2) {
            echo "Car Package";
        } elseif ($transaction_from == 3) {
            echo "Hotel Package";
        } elseif ($transaction_from == 4) {
            echo "Travel Package";
        } elseif ($transaction_from == 5) {
            echo "Bonus";
        } elseif ($transaction_from == 6) {
            echo "Incentive";
        } elseif ($transaction_from == 7) {
            echo "Cashback";
        }
    }
@endphp
@endsection
