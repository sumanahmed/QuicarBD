@extends('quicarbd.admin.layout.admin')
@section('title','User Banner')
@section('content')
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <a href="{{ route('user_banner.create') }}" class="btn btn-success btn-anim"><i class="icon-plus"></i><span class="btn-text">Add New</span></a>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#"><span>Banner</span></a></li>
            <li class="active"><span>User Banner</span></li>
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
                        <h6 class="panel-title txt-dark">All User Banner</h6>
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
                                            <th>Clickable</th>                                   
                                            <th>Out of App</th>                                   
                                            <th>Where Go</th>                                   
                                            <th>Image</th>                                   
                                        <th style="vertical-align: middle;text-align: center;">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($user_banners) && count($user_banners) > 0)
                                            @foreach($user_banners as $user_banner)
                                                <tr class="user-banner-{{ $user_banner->id }}">
                                                    <td>{{ $user_banner->title }}</td>
                                                    <td>{{ $user_banner->status == 1 ? 'Enable' : 'Disable' }}</td>
                                                    <td>{{ $user_banner->clickable == 1 ? 'True' : 'False' }}</td>
                                                    <td>{{ $user_banner->out_of_app == 1 ? 'True' : 'False' }}</td>
                                                    <td>
                                                        @if($user_banner->where_go == 1)
                                                            Detail Page
                                                        @elseif($user_banner->where_go == 2)
                                                            Car Package Home Page
                                                        @elseif($user_banner->where_go == 3)
                                                            Hotel Package Home Page
                                                        @elseif($user_banner->where_go == 4)
                                                            Travel Package Home Page
                                                        @elseif($user_banner->where_go == 5)
                                                            Car Rental Page
                                                        @elseif($user_banner->where_go == 6)
                                                            Specific Item
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <img src="http://quicarbd.com/{{ $user_banner->image_url }}" style="width:80px;height:60px;" />
                                                    </td>
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <a href="{{ route('user_banner.edit', $user_banner->id) }}" class="btn btn-xs btn-warning" id="editClass" data-id="{{ $user_banner->id }}" title="Edit"><i class="fa fa-edit"></i></a>
                                                        <a href="#" class="btn btn-xs btn-danger" data-toggle="modal" id="deleteUserBanner" data-target="#deleteUserBannerModal" data-id="{{ $user_banner->id }}" title="Delete"><i class="fa fa-remove"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3" class="text-center">No Data Found</td>
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
    <div id="deleteUserBannerModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title mb-10" id="exampleModalLabel">Are you sure to delete ?</h5>
                    <input type="hidden" name="del_id"/>
                    <button type="button" class="btn btn-xs btn-danger btn-raised mr-2" id="destroyUserBanner"><i class="fas fa-trash-alt"></i> Proceed</button>
                    <button type="button" class="btn btn-xs btn-warning btn-raised" data-dismiss="modal" aria-label="Close"><i class="fas fa-backspace"></i> Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
	<script src="{{ asset('quicarbd/admin/js/user-banner.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
