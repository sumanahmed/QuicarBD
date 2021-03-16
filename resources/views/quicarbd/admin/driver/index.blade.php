@extends('quicarbd.admin.layout.admin')
@section('title','Driver')

@section('content')
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <a href="{{ route('driver.create') }}" class="btn btn-success btn-anim"><i class="icon-plus"></i><span class="btn-text">Add New</span></a>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li class="active"><span>Driver</span></li>
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
                        <h6 class="panel-title txt-dark">All Driver</h6>
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
                                            <th>NID</th>
                                            <th>License No</th>
                                            <th>Phone</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="allDriver">
                                        @if(isset($drivers) && count($drivers) > 0)
                                            @php $i=1; @endphp
                                            @foreach($drivers as $driver)
                                                <tr class="driver-{{ $driver->id }}">
                                                    <td>{{ $driver->name }}</td>
                                                    <td>{{ $driver->nid }}</td>
                                                    <td>{{ $driver->license }}</td>
                                                    <td>{{ $driver->phone }}</td>
                                                    <td><img src="http://quicarbd.com/{{ $driver->driver_photo }}" style="width:80px;height:60px"/>
                                                    <td>{{ $driver->c_status == 1 ? 'Approve' : 'Pending' }} </td>
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        @if($driver->c_status == 0)
                                                            <a href="{{ route('driver.status-update', ['id' => $driver->id, 'owner_id' => $driver->owner_id, 'c_status'=> 1 ]) }}" class="btn btn-xs btn-success" title="Approve"><i class="fa fa-check"></i></a>
                                                        @else
                                                            <a href="{{ route('driver.status-update', ['id' => $driver->id, 'owner_id' => $driver->owner_id, 'c_status'=> 0 ]) }}" class="btn btn-xs btn-success" title="Pending"><i class="fa fa-unlock-alt"></i></a>
                                                        @endif
                                                        <a href="{{ route('driver.edit', $driver->id) }}" class="btn btn-xs btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                                                        <button class="btn btn-xs btn-danger" data-toggle="modal" id="deleteDriver" data-target="#deleteDriverModal" data-id="{{ $driver->id }}" title="Delete"><i class="fa fa-remove"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" class="text-center">No Data Found</td>
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
    <div class="modal fade" id="deleteDriverModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title mb-10" id="exampleModalLabel3">Are you sure to delete ?</h5>
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
	<script src="{{ asset('quicarbd/admin/js/driver.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
