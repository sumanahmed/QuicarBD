@extends('quicarbd.admin.layout.admin')
@section('title','Coupon')
@section('content')
@php
    $helper = new App\Http\Lib\Helper;
@endphp
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <a href="{{ route('coupon.create',['coupon_for' => $coupon_for]) }}" class="btn btn-success btn-anim"><i class="icon-plus"></i><span class="btn-text">Add New</span></a>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Coupon</a></li>
                <li class="active"><span>{{ $coupon_for == 1 ? 'User' : 'Partner' }}</span></li>
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
                        <h6 class="panel-title txt-dark">All Coupon</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-header" style="border-bottom: 2px solid #ddd;margin-top:10px;">
                        <form action="{{ route('coupon.index') }}" method="get">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Coupon</label>                                            
                                        <input type="text" name="coupon" @if(isset($_GET['coupon'])) value="{{ $_GET['coupon'] }}" @endif placeholder="Enter Coupon.." class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="district_id" class="control-label mb-10">Status</label>                                            
                                        <select name="district_id" class="form-control">
                                            <option value="100">Status</option>
                                            <option value="1">Active</option>
                                            <option value="0">Block</option>
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
                                            <th>Coupon</th>                                     
                                            <th>Type</th>                                     
                                            <th>Percentage</th>                                     
                                            <th>Amount</th>                                     
                                            <th>Upto Amount</th>                                     
                                            <th>Start</th>                                     
                                            <th>End</th>                                     
                                            <th>Total Use</th>                                     
                                            <th>For</th>                                     
                                            <th>Status</th>                                     
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="allCoupon">
                                        @foreach($coupons as $coupon)
                                            @php 
                                                $start_time = DateTime::createFromFormat('Y-m-d H:i:s', $coupon->start, new DateTimeZone("UTC"));
                                                $start = $start_time->format('j M, Y h:i A');
                                                $end_time = DateTime::createFromFormat('Y-m-d H:i:s', $coupon->end, new DateTimeZone("UTC"));
                                                $end = $end_time->format('j M, Y h:i A');
                                            @endphp
                                            <tr class="coupon-{{ $coupon->id }}">
                                                <td>{{ $coupon->coupon }}</td>
                                                <td>{{ $coupon->type == 1 ? 'Percentage' : 'Amount' }}</td>
                                                <td>{{ $coupon->percentage }}</td>
                                                <td>{{ $coupon->amount }}</td>
                                                <td>{{ $coupon->upto_amount }}</td>
                                                <td>{{ $start }}</td>
                                                <td>{{ $end }}</td>
                                                <td>{{ $coupon->total_use }}</td>
                                                <td>{{ $coupon->spacifice_user == 1 ? $helper->getUser($coupon->user_id)." - ".$helper->getUserPhone($coupon->user_id) : 'Global' }}</td>
                                                <td>{{ $coupon->status == 1 ? 'Active' : 'Block' }}</td>
                                                <td style="vertical-align: middle;text-align: center;">
                                                    <a href="{{ route('coupon.edit', $coupon->id) }}" class="btn btn-xs btn-raised btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                                                    @if($coupon->status == 1)
                                                        <a href="{{ route('coupon.block', ['id' => $coupon->id, 'status' => 0]) }}" class="btn btn-xs btn-raised btn-info" title="Block"><i class="fa fa-lock"></i></a>
                                                    @else
                                                        <a href="{{ route('coupon.block', ['id' => $coupon->id, 'status' => 1]) }}" class="btn btn-xs btn-success btn-info" title="Block"><i class="fa fa-check"></i></a>
                                                    @endif
                                                    <a href="#" class="btn btn-xs btn-raised btn-danger" data-toggle="modal" id="deleteCoupon" data-target="#deleteCouponModal" data-id="{{ $coupon->id }}" title="Delete"><i class="fa fa-remove"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $coupons->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>	
        </div>
    </div>
    
    <!-- Delete Class Modal -->
    <div id="deleteCouponModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title mb-10" id="exampleModalLabel">Are you sure to delete ?</h5>
                    <input type="hidden" name="del_id"/>
                    <button type="button" class="btn btn-xs btn-danger btn-raised mr-2" id="destroyCoupon"><i class="fas fa-trash-alt"></i> Proceed</button>
                    <button type="button" class="btn btn-xs btn-warning btn-raised" data-dismiss="modal" aria-label="Close"><i class="fas fa-backspace"></i> Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        //open delete City modal
        $(document).on('click', '#deleteCoupon', function () {
            $('#deleteCouponModal').modal('show');
            $('input[name=del_id]').val($(this).data('id'));
         });
        
        //destroy City
        $("#destroyCoupon").click(function(){
            $.ajax({
                type: 'POST',
                url: '/admin/coupon/destroy',
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                data: {
                    id: $('input[name=del_id]').val()
                },
                success: function (data) {
                    $('#deleteCouponModal').modal('hide');
                    $('.coupon-' + $('input[name=del_id]').val()).remove();
                    toastr.success('Coupon Deleted')
                }
            });
        });
    </script>
@endsection
