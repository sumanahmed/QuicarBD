@extends('quicarbd.admin.layout.admin')
@section('title','Bonus')
@section('content')
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"></div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Dashboard</a></li>
                <li class="active"><span>Bonus</span></li>
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
                        <h6 class="panel-title txt-dark">Bonus Capable {{ $type == 0 ? 'User' : 'Partner' }} List</h6>
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
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Required</th>
                                            <th>Completed</th>
                                            <th>Status</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Required</th>
                                            <th>Completed</th>
                                            <th>Status</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="partnerData">
                                        @if(isset($records) && count($records) > 0)
                                            @foreach($records as $record)
                                                <tr class="record-{{ $record->id }}">
                                                    <td>{{ $record->name }}</td>
                                                    <td>{{ $record->phone }}</td>
                                                    <td>{{ $required_completed }}</td>   
                                                    <td>{{ $record->total_completed }}</td>
                                                    <td></td>
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <a href="{{ route('bonus.pay_now',['id'=>$record->id, 'bonus_id'=>$bonus_id, 'name' => $record->name, 'phone'=>$record->phone, 'type'=>$type]) }}" class="btn btn-xs btn-success" title="Pay Now"><i class="fa fa-check"></i></a>
                                                        <a href="#" id="bonusDelete" data-toggle="modal" data-id="{{ $record->id }}" class="btn btn-xs btn-danger" title="Delete"><i class="fa fa-remove"></i></a>
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
</div>
<div class="modal fade" id="bonusDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 class="modal-title mb-10" id="exampleModalLabel">Are you sure to delete ?</h5>
                <input type="hidden" name="del_id"/>
                <button type="button" class="btn btn-xs btn-danger btn-raised mr-2" id="destroyBonus"><i class="fas fa-trash-alt"></i> Proceed</button>
                <button type="button" class="btn btn-xs btn-warning btn-raised" data-dismiss="modal" aria-label="Close"><i class="fas fa-backspace"></i> Cancel</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
    </script>
@endsection
