@extends('quicarbd.admin.layout.admin')
@section('title','Review')
@section('content')
@php
    if ($review_to == 0) {
        $review_of = "Car Package";
    } else if ($review_to == 1) {
        $review_of = "Hotel Package";
    } else if ($review_to == 2) {
        $review_of = "Travel Package";
    } else if ($review_to == 4) {
        $review_of = "Ride";
    }
@endphp 
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Review</a></li>
                <li class="active"><span>Reiview of {{ $review_of }}</span></li>
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
                        <h6 class="panel-title txt-dark">{{ $review_of }} Reviews</h6>
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
                                            <th>Package</th>
                                            <th>Review</th>
                                            <th>User</th>
                                            <th>Partner</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Package</th>
                                            <th>Review</th>
                                            <th>User</th>
                                            <th>Partner</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="packageData">
                                        @if(isset($reviews) && count($reviews) > 0)
                                            @foreach($reviews as $review)
                                                <tr class="review-{{ $review->id }}">
                                                    <td>{{ $review->name }}</td>
                                                    <td>{{ $review->review }}</td>
                                                    <td>{{ $review->owner_name }} <br/>{{ $review->owner_phone }}</td>
                                                    <td>{{ $review->user_name }} <br/>{{ $review->user_phone }}</td>                                                    
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3" class="text-center">No Data Found</td>
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
