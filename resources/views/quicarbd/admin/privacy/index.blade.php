@extends('quicarbd.admin.layout.admin')
@section('title','Privacy')
@section('content')
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <a href="{{ route('privacy.create',['for'=>$for,'type'=>$type]) }}"  class="btn btn-success btn-anim"><i class="icon-plus"></i><span class="btn-text">Add New</span></a>
        </div>
        @php 
            if($type == 1)
                $privacy_type = 'Terms & Condition';
            elseif($type == 2)
                $privacy_type = 'Privacy Policy';
            else if($type == 3)
                $privacy_type = 'Booking Policy';
            else if($type == 4)
                $privacy_type = 'Payment Policy';
            else if($type == 5)
                $privacy_type = 'Return Policy';
            else if($type == 6)
                $privacy_type = 'About Us';
        @endphp
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Privacy</a></li>
            <li class="active"><span>
            
                All {{ $for == 1 ? 'User' : 'Partner' }} {{ $privacy_type }}</span></li>
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
                        <h6 class="panel-title txt-dark"> All {{ $for == 1 ? 'User' : 'Partner' }} {{ $privacy_type }}</h6>
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
                                            <th>For</th>
                                            <th>Description</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>For</th>
                                            <th>Description</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="$privacyData">
                                        @if(isset($privacies) && count($privacies) > 0)
                                            @php $i=1; @endphp
                                            @foreach($privacies as $privacy)
                                                <tr class="privacy-{{ $privacy->id }}">
                                                    <td>{{ $privacy->for == 1 ? 'User' : 'Partner' }}</td>
                                                    <td>{{ substr($privacy->description,0,20)."..."  }}</td>
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <a href="{{ route('privacy.edit',$privacy->id) }}" class="btn btn-xs btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                                                        <a href="#" class="btn btn-xs btn-danger" data-toggle="modal" id="deletePrivacy" data-target="#deletePrivacyModal" data-id="{{ $privacy->id }}" title="Delete"><i class="fa fa-remove"></i></a>
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
    <div id="deletePrivacyModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title mb-10" id="exampleModalLabel">Are you sure to delete ?</h5>
                    <input type="hidden" name="del_id" id="del_id"/>
                    <button type="button" class="btn btn-xs btn-danger btn-raised mr-2" id="destroyPrivacy"><i class="fas fa-trash-alt"></i> Proceed</button>
                    <button type="button" class="btn btn-xs btn-warning btn-raised" data-dismiss="modal" aria-label="Close"><i class="fas fa-backspace"></i> Cancel</button>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('scripts')
	<script src="{{ asset('quicarbd/admin/js/privacy.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
