@extends('quicarbd.admin.layout.admin')
@section('title','Patner Banner')
@section('content')
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <a href="{{ route('partner_banner.create') }}" class="btn btn-success btn-anim"><i class="icon-plus"></i><span class="btn-text">Add New</span></a>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#"><span>Banner</span></a></li>
            <li class="active"><span>Patner Banner</span></li>
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
                        <h6 class="panel-title txt-dark">All Patner Banner</h6>
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
                                            <th>Title</th>                                   
                                            <th>Status</th>                                   
                                            <th>Image</th>                                    
                                            <th>Serial</th>                                    
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($partner_banners) && count($partner_banners) > 0)
                                            @foreach($partner_banners as $partner_banner)
                                                <tr class="partner-banner-{{ $partner_banner->id }}">
                                                    <td>{{ $partner_banner->title }}</td>
                                                    <td>{{ $partner_banner->status == 1 ? 'Active' : 'Inactive' }}</td>
                                                    <td><img src="http://quicarbd.com/{{ $partner_banner->image_url }}" style="width: 80px;height:50px;" /></td>
                                                    <td>{{ $partner_banner->serial }}</td>
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <a href="{{ route('partner_banner.up',$partner_banner->id) }}" class="btn btn-xs btn-info" title="Up"><i class="fa fa-angle-up"></i></a>
                                                        <a href="{{ route('partner_banner.down',$partner_banner->id) }}" class="btn btn-xs btn-success" title="Down"><i class="fa fa-angle-down"></i></a>
                                                        <a href="{{ route('partner_banner.edit',$partner_banner->id) }}" class="btn btn-xs btn-warning" title="Edit"><i class="fa fa-edit"></i></a>
                                                        <a href="#" class="btn btn-xs btn-danger" data-toggle="modal" id="deletePartnerBanner" data-target="#deletePartnerBannerModal" data-id="{{ $partner_banner->id }}" title="Delete"><i class="fa fa-remove"></i></a>
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
    <div id="deletePartnerBannerModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title mb-10" id="exampleModalLabel">Are you sure to delete ?</h5>
                    <input type="hidden" name="del_id"/>
                    <button type="button" class="btn btn-xs btn-danger btn-raised mr-2" id="destroyPartnerBanner"><i class="fas fa-trash-alt"></i> Proceed</button>
                    <button type="button" class="btn btn-xs btn-warning btn-raised" data-dismiss="modal" aria-label="Close"><i class="fas fa-backspace"></i> Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
	<script src="{{ asset('quicarbd/admin/js/partner-banner.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
