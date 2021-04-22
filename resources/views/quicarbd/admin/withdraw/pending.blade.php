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
            <li class="active"><span>Pending</span></li>
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
                        <h6 class="panel-title txt-dark">All Pending</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-header" style="border-bottom: 2px solid #ddd;margin-top:10px;">
                        <form action="{{ route('withdraw.pending') }}" method="get">
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
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Amount</th>
                                            <th>Withdraw Method</th>
                                            <th>Date & Time</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Amount</th>
                                            <th>Withdraw Method</th>
                                            <th>Date & Time</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($withdraws as $withdraw)
                                            @php 
                                                $db_time = DateTime::createFromFormat('Y-m-d H:i:s', $withdraw->created_at, new DateTimeZone("UTC"));
                                                $dateTime = $db_time->setTimeZone(new DateTimeZone("Asia/Dhaka"))->format('j M, Y h:i A');
                                            @endphp
                                            <tr class="withdraw-{{ $withdraw->id }}">
                                                <td>{{ $withdraw->owner_name }}</td>
                                                <td>{{ $withdraw->owner_phone }}</td>
                                                <td>{{ $withdraw->amount }}</td>
                                                <td>{{ $withdraw->withdraw_method }}</td>    
                                                <td>{{ $dateTime }}</td>
                                                <td style="vertical-align: middle;text-align: center;">
                                                    <a href="#" class="btn btn-xs btn-success" title="Approve"><i class="fa fa-check"></i></a>
                                                    <a href="#" class="btn btn-xs btn-danger" title="Cancel"><i class="fa fa-remove"></i></a>
                                                </td>
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
