@extends('quicarbd.admin.layout.admin')
@section('title','Partner')
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
            <li><a href="#">Partner</a></li>
            <li class="active"><span>Verification</span></li>
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
                        <h6 class="panel-title txt-dark">All Partner</h6>
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
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Current Account Type</th>
                                            <th>Request For</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Current Account Type</th>
                                            <th>Request For</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="partnerData">
                                        @if(isset($partners) && count($partners) > 0)
                                            @php $i=1; @endphp
                                            @foreach($partners as $partner)
                                                <tr class="partner-{{ $partner->id }}">
                                                    <td>{{ $partner->name }}</td>
                                                    <td>{{ $partner->phone }}</td>
                                                    @if($partner->account_type == 0)
                                                        <td>Car</td>
                                                    @elseif($partner->account_type == 1)
                                                        <td>Hotel</td>
                                                    @elseif($partner->account_type == 2)
                                                        <td>Travel</td>
                                                    @elseif($partner->account_type == 3)
                                                        <td>Car & Hotel</td>
                                                    @elseif($partner->account_type == 4)
                                                        <td>Car, Hotel & Travel</td>
                                                    @elseif($partner->account_type == 5)
                                                        <td>Hotel & Travel</td>
                                                    @elseif($partner->account_type == 6)
                                                        <td>Car & Travel</td>
                                                    @endif
                                                    @if($partner->request_for == 0)
                                                        <td>Car</td>
                                                    @elseif($partner->request_for == 1)
                                                        <td>Hotel</td>
                                                    @else
                                                        <td>Travel</td>
                                                    @endif
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <a href="{{ route('partner.account_type_change_approve',['id'=>$partner->id,'which_acount'=>$partner->request_for,'owner_id'=>$partner->owner_id]) }}" 
                                                        class="btn btn-xs btn-success" title="Approve"><i class="fa fa-check"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center">No Data Found</td>
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
    
    
    <!-- Delete Class Modal -->
    <div id="deleteDriverModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title mb-10" id="exampleModalLabel">Are you sure to delete ?</h5>
                    <input type="hidden" name="del_id"/>
                    <button type="button" class="btn btn-xs btn-danger btn-raised mr-2" id="destroyDriver"><i class="fas fa-trash-alt"></i> Proceed</button>
                    <button type="button" class="btn btn-xs btn-warning btn-raised" data-dismiss="modal" aria-label="Close"><i class="fas fa-backspace"></i> Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
	<script src="{{ asset('quicarbd/admin/js/partner.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
