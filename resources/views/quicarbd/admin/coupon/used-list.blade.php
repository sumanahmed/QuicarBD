@extends('quicarbd.admin.layout.admin')
@section('title','Coupon')
@section('content')
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"></div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Coupon</a></li>
                <li class="active"><span>Used List</span></li>
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
                        <h6 class="panel-title txt-dark">All Coupon Used List</h6>
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
                                            <th>Coupon</th>                                     
                                            <th>User Name</th>                                     
                                            <th>User Phone</th>                                     
                                            <th>Used Date & Time</th>                                     
                                        </tr>
                                    </thead>
                                    <tbody id="allCoupon">
                                        @foreach($coupon_users as $user)
                                            @php 
                                                $db_time = DateTime::createFromFormat('Y-m-d H:i:s', $user->created_at, new DateTimeZone("UTC"));
                                                $dateTime = $db_time->setTimeZone(new DateTimeZone("Asia/Dhaka"))->format('j M, Y h:i A');
                                            @endphp
                                            <tr>
                                                <td>{{ $user->coupon }}</td> 
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->phone }}</td>
                                                <td>{{ $dateTime }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $coupon_users->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>	
        </div>
    </div>
</div>
@endsection
