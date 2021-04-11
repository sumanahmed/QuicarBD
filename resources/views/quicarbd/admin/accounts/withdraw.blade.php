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
            <li><a href="#">Accounts</a></li>
            <li><a href="#">Balance</a></li>
            <li class="active"><span>Withdraw </span></li>
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
                        <h6 class="panel-title txt-dark">All Withdraw</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-header" style="border-bottom: 2px solid #ddd;margin-top:10px;">
                        <form action="{{ route('accounts.withdraw') }}" method="get">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Name</label>                                            
                                        <input type="text" name="name" @if(isset($_GET['name'])) value="{{ $_GET['name'] }}" @endif placeholder="Enter Name.." class="form-control" />
                                    </div>
                                </div>  
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
                                        <label class="control-label mb-10">Status</label>    
                                        <select name="status" class="form-control">
                                            <option value="1000">Select</option>
                                            <option value="0" @if(isset($_GET['status']) && $_GET['status'] == 0) selected @endif>Pending</option>
                                            <option value="1" @if(isset($_GET['status']) && $_GET['status'] == 1) selected @endif>Paid</option>
                                            <option value="2" @if(isset($_GET['status']) && $_GET['status'] == 2) selected @endif>Cancel</option>
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
                                            <th>Date & Time</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Current Balance</th>
                                            <th>Withdraw Amount</th>
                                            <th>Withdraw Method</th>
                                            <th>Account No</th>
                                            <th>Status</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Date & Time</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Current Balance</th>
                                            <th>Withdraw Amount</th>
                                            <th>Withdraw Method</th>
                                            <th>Account No</th>
                                            <th>Status</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="carData">
                                        @foreach($withdraws as $withdraw)                                            
                                            @php 
                                                $db_time = DateTime::createFromFormat('Y-m-d H:i:s', $withdraw->created_at, new DateTimeZone("UTC"));
                                                $dateTime = $db_time->setTimeZone(new DateTimeZone("Asia/Dhaka"))->format('j M, Y h:i A');
                                            @endphp
                                            <tr class="withdraw-{{ $withdraw->id }}">
                                                <td>{{ $dateTime }}</td>
                                                <td>{{ $withdraw->name }}</td>
                                                <td>{{ $withdraw->phone }}</td>
                                                <td>{{ $withdraw->current_balance }}</td>
                                                <td>{{ $withdraw->amount }}</td>
                                                <td>{{ $withdraw->withdraw_method }}</td>
                                                <td>{{ $withdraw->number }}</td>
                                                <td>{{ getStatus($withdraw->status) }}</td>
                                                <td>
                                                    @if($withdraw->status == 0) 
                                                        <a href="#" id="acceptModal" data-target="#showAcceptModal" data-toggle="modal" data-id="{{ $withdraw->id }}" data-phone="{{ $withdraw->phone }}" data-amount="{{ $withdraw->amount }}" data-status="1" data-owner_id="{{ $withdraw->owner_id }}" class="btn btn-xs btn-success" title="Accept"><i class="fa fa-check"></i></a>
                                                        <a href="#" id="cancelModal" data-target="#showCancelModal" data-toggle="modal" data-id="{{ $withdraw->id }}" data-phone="{{ $withdraw->phone }}" data-amount="{{ $withdraw->amount }}" data-status="2" data-owner_id="{{ $withdraw->owner_id }}" class="btn btn-xs btn-danger" title="Cancel"><i class="fa fa-remove"></i></a>
                                                    @endif
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

<div class="modal fade" id="showAcceptModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 class="modal-title mb-10" id="exampleModalLabel">Are you sure to Accept ?</h5>
                <input type="hidden" id="id"/>
                <input type="hidden" id="phone"/>
                <input type="hidden" id="amount"/>
                <input type="hidden" id="status"/>
                <input type="hidden" id="owner_id"/>
                <button type="button" class="btn btn-xs btn-success btn-raised mr-2" id="acceptWithdraw"><i class="fas fa-trash-alt"></i> Accept</button>
                <button type="button" class="btn btn-xs btn-warning btn-raised" data-dismiss="modal" aria-label="Close"><i class="fas fa-backspace"></i> Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="showCancelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 class="modal-title mb-10" id="exampleModalLabel">Are you sure to Cancel ?</h5>
                <input type="hidden" id="id"/>
                <input type="hidden" id="phone"/>
                <input type="hidden" id="amount"/>
                <input type="hidden" id="status"/>
                <input type="hidden" id="owner_id"/>
                <button type="button" class="btn btn-xs btn-danger btn-raised mr-2" id="cancelWithdraw"><i class="fas fa-trash-alt"></i> Proceed</button>
                <button type="button" class="btn btn-xs btn-warning btn-raised" data-dismiss="modal" aria-label="Close"><i class="fas fa-backspace"></i> Cancel</button>
            </div>
        </div>
    </div>
</div>
@php
    function getStatus ($status) {
        if ($status == 0) {
            echo 'Pending';
        } elseif ($status == 1) {
            echo 'Paid';
        } elseif ($status == 2) {
            echo 'Cancel';
        }
    }
@endphp
@endsection
@section('scripts')
    <script>
        // withdraw approved
        $(document).on('click', '#acceptModal', function () {
            $('#showAcceptModal').modal('show');
            $('#id').val($(this).data('id'));
            $('#phone').val($(this).data('phone'));
            $('#amount').val($(this).data('amount'));
            $('#status').val($(this).data('status'));
            $('#owner_id').val($(this).data('owner_id'));
        });

        //destroy Year
        $("#acceptWithdraw").click(function(){

            var id = $('#id').val();
            var phone = $('#phone').val();
            var amount = $('#amount').val();
            var status = $('#status').val();
            var owner_id = $('#owner_id').val();
            
            $.ajax({
                type: 'POST',
                url: '/admin/accounts/withdraw-accept',
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                data: {
                    id: id,
                    phone: phone,
                    amount: amount,
                    status: status,
                    owner_id: owner_id
                },
                success: function (data) {
                    $('#showAcceptModal').modal('hide');
                    toastr.success('Approved successfully')
                    location.reload();
                }
            });
        });

        // withdraw cancel
        $(document).on('click', '#cancelModal', function () {
            $('#showCancelModal').modal('show');
            $('#id').val($(this).data('id'));
            $('#phone').val($(this).data('phone'));
            $('#amount').val($(this).data('amount'));
            $('#status').val($(this).data('status'));
            $('#owner_id').val($(this).data('owner_id'));
        });

        //destroy Year
        $("#cancelWithdraw").click(function(){

            var id = $('#id').val();
            var phone = $('#phone').val();
            var amount = $('#amount').val();
            var status = $('#status').val();
            var owner_id = $('#owner_id').val();
            
            $.ajax({
                type: 'POST',
                url: '/admin/accounts/withdraw-cancel',
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                data: {
                    id: id,
                    phone: phone,
                    amount: amount,
                    status: status,
                    owner_id: owner_id
                },
                success: function (data) {
                    $('#showCancelModal').modal('hide');
                    toastr.success('Cancelled successfully')
                    location.reload();
                }
            });
        });
    </script>
@endsection
