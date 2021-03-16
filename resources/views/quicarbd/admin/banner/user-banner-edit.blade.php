@extends('quicarbd.admin.layout.admin')
@section('title','User Banner')
@section('styles')
    <style>
        input[type=file] {
            display: none;
        }
    </style>
@endsection
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
            <li><a href="#">Banner</a></li>
            <li class="active"><span>Edit User Banner</span></li>
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
                        <h6 class="txt-dark capitalize-font"><i class="fa fa-photo"></i> Banner Info</h6> 
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-wrap">
                                    <form action="{{ route('user_banner.update', $user_banner->id) }}" method="post" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="form-body">     
                                            <div class="row">
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="title" class="control-label mb-10"> Title <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="title" name="title" placeholder="Title" value="{{ $user_banner->title }}" class="form-control" required>
                                                        @if($errors->has('title'))
                                                            <span class="text-danger"> {{ $errors->first('title') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="status" class="control-label mb-10">Status <span class="text-danger" title="Required">*</span></label>
                                                        <select name="status" id="status" class="form-control selectable">
                                                            <option value="1" @if($user_banner->status == 1) selected @endif>Enable</option>
                                                            <option value="0" @if($user_banner->status == 0) selected @endif>Disable</option>
                                                        </select>
                                                        @if($errors->has('status'))
                                                            <span class="text-danger"> {{ $errors->first('status') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="clickable" class="control-label mb-10">Clickable <span class="text-danger" title="Required">*</span></label>
                                                        <select name="clickable" id="clickable" class="form-control selectable">
                                                            <option value="1" @if($user_banner->clickable == 1) selected @endif>True</option>
                                                            <option value="0" @if($user_banner->clickable == 0) selected @endif>False</option>
                                                        </select>
                                                        @if($errors->has('clickable'))
                                                            <span class="text-danger"> {{ $errors->first('clickable') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>                                
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="out_of_app" class="control-label mb-10">Out of App <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select id="out_of_app" name="out_of_app" class="form-control selectable" required>
                                                            <option value="0" @if($user_banner->out_of_app == 0) selected @endif>False</option>
                                                            <option value="1" @if($user_banner->out_of_app == 1) selected @endif>True</option>
                                                        </select>
                                                        @if($errors->has('out_of_app'))
                                                            <span class="text-danger"> {{ $errors->first('out_of_app') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            
                                                <div class="col-md-8" id="clickLinke" @if($user_banner->out_of_app == 0) style="display: none;" @endif>
                                                    <div class="form-group">
                                                        <label for="click_linke" class="control-label mb-10">click_linke </label>                                            
                                                        <input type="text" class="form-control" name="click_linke" value="{{ $user_banner->click_linke }}">
                                                        @if($errors->has('click_linke'))
                                                            <span class="text-danger"> {{ $errors->first('click_linke') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="where_go" class="control-label mb-10">Where Go <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select id="where_go" name="where_go" class="form-control selectable" required>
                                                            <option value="1" @if($user_banner->where_go == 1) selected @endif>Detail Page</option>
                                                            <option value="2" @if($user_banner->where_go == 2) selected @endif>Car Package Home Page</option>
                                                            <option value="3" @if($user_banner->where_go == 3) selected @endif>Hotel Package Home Page</option>
                                                            <option value="4" @if($user_banner->where_go == 4) selected @endif>Travel Package Home Page</option>
                                                            <option value="5" @if($user_banner->where_go == 5) selected @endif>Car Rental Page</option>
                                                            <option value="6" @if($user_banner->where_go == 6) selected @endif>Specific Item</option>
                                                        </select>
                                                        @if($errors->has('where_go'))
                                                            <span class="text-danger"> {{ $errors->first('where_go') }}</span>
                                                        @endif
                                                    </div>
                                                </div>                                    
                                                <div class="col-md-4" id="package" @if($user_banner->package_id == null) style="display: none;" @endif>
                                                    <div class="form-group">
                                                        <label for="package_id" class="control-label mb-10">Select Package <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select id="package_id" name="package_id" class="form-control selectable">
                                                            <option selected disabled>Select</option>
                                                            <option value="1" @if($user_banner->package_id == 1) selected @endif>Car Package</option>
                                                            <option value="2" @if($user_banner->package_id == 2) selected @endif>Hotel Package</option>                                                            
                                                            <option value="3" @if($user_banner->package_id == 3) selected @endif>Travel Package</option>
                                                        </select>
                                                        @if($errors->has('package_id'))
                                                            <span class="text-danger"> {{ $errors->first('package_id') }}</span>
                                                        @endif
                                                    </div>
                                                </div>     
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="img1" class="control-label mb-10">Image <span class="text-danger" title="Required">*</span></label> 
                                                        <div class="avatar-upload">
                                                            <div class="avatar-edit">
                                                                <input type='file' name="image_url" id="img1Upload" accept=".png, .jpg, .jpeg" required/>
                                                                <label for="img1Upload"><i class="fa fa-edit"></i></label>
                                                            </div>
                                                            <div class="avatar-preview" style="width:100%">
                                                                <div id="img1Preview" style="background-image: url(http://quicarbd.com/{{ $user_banner->image_url }});"></div>
                                                            </div>
                                                        </div>
                                                        @if($errors->has('image_url'))
                                                            <span class="text-danger"> {{ $errors->first('image_url') }}</span>
                                                        @endif
                                                    </div>
                                                </div>   
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="description" class="control-label mb-10">Description <span class="text-danger" title="Required">*</span></label>                                            
                                                        <textarea name="description" rows="10" class="form-control" require >{{ $user_banner->description }}</textarea>
                                                        @if($errors->has('description'))
                                                            <span class="text-danger"> {{ $errors->first('description') }}</span>
                                                        @endif
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="row" style="margin-top:10px;">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="submit" class="btn btn-sm btn-success" value="Submit"/>
                                                        <input type="reset" class="btn btn-sm btn-danger" value="Cancel"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
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
	<script src="{{ asset('quicarbd/admin/js/user-banner.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
