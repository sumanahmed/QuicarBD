@extends('quicarbd.admin.layout.admin')
@section('title','Withdraw')
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
            <li><a href="#">Withdraw</a></li>
            <li class="active"><span>Complete</span></li>
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
                        <h6 class="panel-title txt-dark">All Complete</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-header" style="border-bottom: 2px solid #ddd;margin-top:10px;">
                        <form action="{{ route('withdraw.complete') }}" method="get">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="name" class="control-label mb-10">Name</label>                                            
                                        <input type="text" name="name" @if(isset($_GET['name'])) value="{{ $_GET['name'] }}" @endif placeholder="Name" class="form-control">
                                    </div>
                                </div> 
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="phone" class="control-label mb-10">Phone</label>                                            
                                        <input type="text" name="phone" @if(isset($_GET['phone'])) value="{{ $_GET['phone'] }}" @endif placeholder="Phone" class="form-control">
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
                                            <th>Partner</th>
                                            <th>Amount</th>
                                            <th>Withdraw Method</th>
                                            <th>Tnx ID</th>
                                            <th>Request Date & Time</th>
                                            <th>Payment Date & Time</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Partner</th>
                                            <th>Amount</th>
                                            <th>Withdraw Method</th>
                                            <th>Tnx ID</th>
                                            <th>Request Date & Time</th>
                                            <th>Payment Date & Time</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($withdraws as $withdraw)
                                            @php 
                                                $db_time = DateTime::createFromFormat('Y-m-d H:i:s', $withdraw->created_at, new DateTimeZone("UTC"));
                                                $dateTime = $db_time->setTimeZone(new DateTimeZone("Asia/Dhaka"))->format('j M, Y h:i A');              
                                                
                                                $send_time = DateTime::createFromFormat('Y-m-d H:i:s', $withdraw->payment_send_time, new DateTimeZone("UTC"));
                                                $paiddateTime = $db_time->setTimeZone(new DateTimeZone("Asia/Dhaka"))->format('j M, Y h:i A');
                                            @endphp
                                            <tr class="withdraw-{{ $withdraw->id }}">
                                                <td>{{ $withdraw->owner_name }}<br/>{{ $withdraw->owner_phone }}</td>
                                                <td>{{ $withdraw->amount }}</td>
                                                <td>{{ $withdraw->withdraw_method }}</td>    
                                                <td>{{ $withdraw->tnxid }}</td>    
                                                <td>{{ $dateTime }}</td>
                                                <td>{{ $paiddateTime }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $withdraws->links('pagination::bootstrap-4') }}
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
	<script src="{{ asset('quicarbd/admin/js/withdraw.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
