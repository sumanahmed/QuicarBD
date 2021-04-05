@extends('quicarbd.admin.layout.admin')
@section('title','Patner Banner')
@section('content')
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <a href="#" data-toggle="modal" data-target="#createPartnerBannerModal" class="btn btn-success btn-anim"><i class="icon-plus"></i><span class="btn-text">Add New</span></a>
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
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <a href="#" class="btn btn-xs btn-warning" data-toggle="modal" id="editPartnerBanner" data-target="#editPartnerBannerModal" data-id="{{ $partner_banner->id }}"  data-title="{{ $partner_banner->title }}" data-details="{{ $partner_banner->details }}" data-image_url="{{ $partner_banner->image_url }}" data-status="{{ $partner_banner->status }}" title="Edit"><i class="fa fa-edit"></i></a>
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

    <div class="modal fade" id="createPartnerBannerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="exampleModalLabel1">Create</h5>
                </div>
                <div class="modal-body">
                    <form id="createPartnerBannerForm" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="form-group">
                            <label for="name" class="control-label mb-10">Title <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Enter Title" required>
                            <span class="text-danger titleError"></span>
                        </div>
                        <div class="form-group">
                            <label for="details" class="control-label mb-10">Details <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <textarea name="details" id="details" rows="4" class="form-control summernote" placeholder="Details" required></textarea>
                            <span class="text-danger detailsError"></span>
                        </div>
                        <div class="form-group">
                            <label for="address" class="control-label mb-10">Image <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <input type="file" name="image_url" id="image" class="form-control" required>
                            <span class="text-danger imageError"></span>
                        </div>
                        <div class="form-group">
                            <label for="status" class="control-label mb-10">Status <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <select id="status" class="form-control">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <span class="text-danger statusError"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="create">Save</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="editPartnerBannerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="exampleModalLabel1">Edit</h5>
                </div>
                <div class="modal-body">
                    <form id="editPartnerBannerForm" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="form-group">
                            <label for="edit_title" class="control-label mb-10">Title <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <input type="text" name="name" id="edit_title" class="form-control" placeholder="Enter Title" required>
                            <input type="hidden" id="edit_id" />
                            <span class="text-danger nameError"></span>
                        </div>     
                        <div class="form-group">
                            <label for="edit_details" class="control-label mb-10">Details <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <textarea name="details" id="edit_details" rows="4" class="form-control summernote" placeholder="Details" required></textarea>
                            <span class="text-danger detailsError"></span>
                        </div>
                        <div class="form-group">
                            <label for="image" class="control-label mb-10">Previous Image <span class="text-danger text-bold" title="Required Field">*</span></label>                                
                            <img src="" id="previous_image" class="form-control" style="width:300px;height:200px;"/>
                        </div>
                        <div class="form-group">
                            <label for="image" class="control-label mb-10">Update Image <span class="text-danger text-bold" title="Required Field">*</span></label>                                
                            <input type="file" name="image_url" id="edit_image" class="form-control">
                            <span class="text-danger imageError"></span>
                        </div>                    
                        <div class="form-group">
                            <label for="edit_status" class="control-label mb-10">Status <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <select id="edit_status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <span class="text-danger statusError"></span>
                        </div>   
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="update">Update</button>
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
