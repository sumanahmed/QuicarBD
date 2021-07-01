@extends('quicarbd.admin.layout.admin')
@section('title','Car Package Details')
@section('content')
@php 
    $helper = new App\Http\Lib\Helper;
@endphp
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-md-lg-3 col-md-4 col-sm-4 col-xs-12">
        </div>
        <!-- Breadcrumb -->
        <div class="col-md-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Package Ride</a></li>
                <li><a href="#">Car Package</a></li>
                <li class="active"><span>Details</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
    <!-- /Title -->    
    <!-- Row -->
    <div class="row">
        <div class="col-md-sm-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="txt-dark capitalize-font"><i class="fa fa-car mr-10"></i>Car Package Details</h6> 
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-sm-12 col-xs-12">                                
                                <div class="form-wrap">
                                    <div class="form-body">     
                                        <div class="row">
                                            <div class="col-md-4">                                        
                                                <div class="form-group">
                                                    <label for="name" class="control-label mb-10">Package Name</label>
                                                    <input type="text" id="name" name="name" value="{{ $detail->name }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Price</label>                                            
                                                    <input type="phone" id="phone" value="{{  $detail->price }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">                                        
                                                <div class="form-group">
                                                    <label for="name" class="control-label mb-10">Pickup Address</label>
                                                    <input type="text" id="name" name="name" value="{{ $detail->pickUpAddress }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">                                        
                                                <div class="form-group">
                                                    <label for="name" class="control-label mb-10">Extra note</label>
                                                    <input type="text" id="name" name="name" value="{{ $detail->extra_note }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Travel Date</label>                                            
                                                    <input type="phone" id="phone" value="{{ date('Y-m-d', strtotime($detail->travel_date)) }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Status</label>                                            
                                                    <input type="phone" id="phone" value="{{ getStatus($detail->status) }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Payment Status</label>                                            
                                                    <input type="phone" id="phone" value="{{ $detail->payment_status == 0 ? 'Unpaid' : 'Paid' }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">TNX ID</label>                                            
                                                    <input type="phone" id="phone" value="{{ $detail->tnx_id }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Payment Complete Time</label>                                            
                                                    <input type="phone" id="phone" @if($detail->payment_complete_time != null) value="{{ date('Y-m-d H:i:s a', strtotime($detail->payment_complete_time)) }}" @endif class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">User</label>                                            
                                                    <input type="phone" id="phone" value="{{ $detail->user_name }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Ride Start Time</label>                                            
                                                    <input type="phone" id="phone" @if($detail->ride_start_time != null) value="{{ date('Y-m-d H:i:s a', strtotime($detail->ride_start_time)) }}" @endif class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Ride Finished Time</label>                                            
                                                    <input type="phone" id="phone" @if($detail->ride_finished_time != null) value="{{ date('Y-m-d H:i:s a', strtotime($detail->ride_finished_time)) }}" @endif class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label mb-10">Car Registration Number</label>                                            
                                                    <input type="phone" id="phone"value="{{ $detail->carRegisterNumber }}" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($detail->status == 2)
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="txt-dark capitalize-font"><i class="fa fa-car mr-10"></i>Car Package Cancel Details</h6> 
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-sm-12 col-xs-12">                                
                                    <div class="form-wrap">
                                        <div class="form-body">     
                                            <div class="row">
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="name" class="control-label mb-10">Cancel By</label>
                                                        <input type="text" id="name" name="name" value="{{ $detail->cancel_by == 0 ? 'User' : 'Admin' }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                @if($detail->cancel_by == 0)
                                                    <div class="col-md-4">                                        
                                                        <div class="form-group">
                                                            <label for="name" class="control-label mb-10">User Name</label>
                                                            <input type="text" id="name" name="name" value="{{ $detail->user_name }}" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">                                        
                                                        <div class="form-group">
                                                            <label for="name" class="control-label mb-10">User Phone</label>
                                                            <input type="text" id="name" name="name" value="{{ $detail->user_phone }}" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if($detail->cancel_by == 1)
                                                    <div class="col-md-4">                                        
                                                        <div class="form-group">
                                                            <label for="name" class="control-label mb-10">Owner Name</label>
                                                            <input type="text" id="name" name="name" value="{{ $detail->owner_name }}" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">                                        
                                                        <div class="form-group">
                                                            <label for="name" class="control-label mb-10">Owner Phone</label>
                                                            <input type="text" id="name" name="name" value="{{ $detail->owner_phone }}" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="name" class="control-label mb-10">Cancellation Reason</label>
                                                        <input type="text" id="name" name="name" value="{{ $helper->getCancelReason($detail->cancellation_reason) }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="name" class="control-label mb-10">Cancell Time</label>
                                                        <input type="text" id="name" name="name" value="{{ $detail->cancelation_time }}" class="form-control" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="panel panel-default card-view">
            <div class="panel-heading">
                <div class="pull-left">
                    <h6 class="txt-dark capitalize-font"><i class="fa fa-car mr-10"></i>Transaction History</h6> 
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
                                            <td>{{ $transaction->method }}</td>
                                        </tr>
                                    @endforeach
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
@php 
    function getStatus($status) {
       if ($status == 0) {
        echo 'Request send';
       } else if ($status == 1) {
        echo 'Request Accepted';
       } else if ($status == 2) {
        echo 'Request Cancel';
       } else if ($status == 3) {
        echo 'Request Start';
       } else if ($status == 4) {
        echo 'Request Finished';
       }
    }
    
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
@section('scripts')
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
