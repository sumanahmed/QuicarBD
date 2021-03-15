@extends('quicarbd.admin.layout.admin')
@section('title','Policy')
@section('content')
@php 
    if($type == 1)
       $policy_type = 'Ride';
    else if($type == 2)
        $policy_type = 'Car Package';
    else if($type == 3)
        $policy_type = 'Hotel Package';
    else
        $policy_type = 'Travel Package';
@endphp
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <a href="{{ route('policy.create',['for'=>$for, 'type'=>$type]) }}"  class="btn btn-success btn-anim"><i class="icon-plus"></i><span class="btn-text">Add New</span></a>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Policy</a></li>
            <li class="active"><span>
                All {{ $for == 1 ? 'User' : 'Partner' }} {{ $policy_type }} Cancellation Policy</span></li>
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
                        <h6 class="panel-title txt-dark"> All {{ $for == 1 ? 'User' : 'Partner' }} {{ $policy_type }} Cancellation Policy</h6>
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
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="policyData">
                                        @if(isset($policies) && count($policies) > 0)
                                            @php $i=1; @endphp
                                            @foreach($policies as $policy)
                                                <tr class="policy-{{ $policy->id }}">
                                                    <td>{{ substr($policy->description,0,15)."..."  }}</td>
                                                    <td>{{ $policy->status == 0 ? 'Inactive' : 'Active' }}</td>
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <a href="{{ route('policy.edit',$policy->id) }}" class="btn btn-xs btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                                                        <a href="#" class="btn btn-xs btn-danger" data-toggle="modal" id="deletePolicy" data-target="#deletePolicyModal" data-id="{{ $policy->id }}" title="Delete"><i class="fa fa-remove"></i></a>
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
    <div id="deletePolicyModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title mb-10" id="exampleModalLabel">Are you sure to delete ?</h5>
                    <input type="hidden" name="del_id" id="del_id"/>
                    <button type="button" class="btn btn-xs btn-danger btn-raised mr-2" id="destroyPolicy"><i class="fas fa-trash-alt"></i> Proceed</button>
                    <button type="button" class="btn btn-xs btn-warning btn-raised" data-dismiss="modal" aria-label="Close"><i class="fas fa-backspace"></i> Cancel</button>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('scripts')
	<script src="{{ asset('quicarbd/admin/js/policy.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
