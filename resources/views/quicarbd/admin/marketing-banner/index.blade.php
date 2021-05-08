@extends('quicarbd.admin.layout.admin')
@section('title','Marketing Banner')
@section('content')
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <a href="{{ route('marketing_banner.create') }}" class="btn btn-success btn-anim"><i class="icon-plus"></i><span class="btn-text">Add New</span></a>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#"><span>Banner</span></a></li>
            <li class="active"><span>{{ $type == 1 ? 'User App' : 'Partner App' }} Marketing Banner</span></li>
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
                        <h6 class="panel-title txt-dark">All {{ $type == 1 ? 'User App' : 'Partner App' }} Marketing Banner</h6>
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
                                        @foreach($banners as $banner)
                                            <tr class="marketing-banner-{{ $banner->id }}">
                                                <td>{{ $banner->title }}</td>
                                                <td>{{ $banner->status == 1 ? 'Visible' : 'Invisible' }}</td>
                                                <td>
                                                    <img src="http://quicarbd.com/{{ $banner->image_url }}" style="width:80px;height:60px;" />
                                                </td>
                                                <td style="vertical-align: middle;text-align: center;">
                                                    <a href="{{ route('marketing_banner.edit', $banner->id) }}" class="btn btn-xs btn-warning" id="editClass" title="Edit"><i class="fa fa-edit"></i></a>
                                                    <a href="#" class="btn btn-xs btn-danger" data-toggle="modal" id="deleteMarketingBanner" data-target="#deleteMarketingBannerModal" data-id="{{ $banner->id }}" title="Delete"><i class="fa fa-remove"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
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
    <div id="deleteMarketingBannerModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title mb-10" id="exampleModalLabel">Are you sure to delete ?</h5>
                    <input type="hidden" name="del_id"/>
                    <button type="button" class="btn btn-xs btn-danger btn-raised mr-2" id="destroyMarketingBanner"><i class="fas fa-trash-alt"></i> Proceed</button>
                    <button type="button" class="btn btn-xs btn-warning btn-raised" data-dismiss="modal" aria-label="Close"><i class="fas fa-backspace"></i> Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        //open delete banner modal
        $(document).on('click', '#deleteMarketingBanner', function () {
            $('#deleteMarketingBannerModal').modal('show');
            $('input[name=del_id]').val($(this).data('id'));
        });

        //destroy Spot
        $("#destroyUserBanner").click(function(){
            $.ajax({
                type: 'POST',
                url: '/admin/marketing-banner/destroy',
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                data: {
                    id: $('input[name=del_id]').val()
                },
                success: function (response) {
                    $('#deleteUserBannerModal').modal('hide');
                    $('.marketing-banner-' + $('input[name=del_id]').val()).remove();
                    toastr.success('Banner Deleted')
                }
            });
        });
    </script>
@endsection
