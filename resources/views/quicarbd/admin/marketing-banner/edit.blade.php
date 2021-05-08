@extends('quicarbd.admin.layout.admin')
@section('title','Marketing Banner')
@section('styles')
    <style>
        input[type=file] {
            display: none;
        }
        i.fa-edit {
            color:#000 !important;
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
                <li class="active"><span>Edit Marketing Banner for {{ $banner->type == 1 ? 'User App' : 'Partner App' }}</span></li>
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
                        <h6 class="txt-dark capitalize-font"><i class="fa fa-photo"></i>{{ $banner->type == 1 ? 'User App' : 'Partner App' }} Marketing Banner Info</h6> 
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-wrap">
                                    <form action="{{ route('marketing_banner.update', $banner->id) }}" method="post" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="form-body">     
                                            <div class="row">
                                                <div class="col-md-6">                                        
                                                    <div class="form-group">
                                                        <label for="marketing_dialog_title" class="control-label mb-10"> Title <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="marketing_dialog_title" name="marketing_dialog_title" value="{{ $banner->marketing_dialog_title }}" class="form-control" required>
                                                        <input type="hidden" name="type" value="{{ $banner->type }}" />
                                                        @if($errors->has('marketing_dialog_title'))
                                                            <span class="text-danger"> {{ $errors->first('marketing_dialog_title') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                        
                                                    <div class="form-group">
                                                        <label for="status" class="control-label mb-10">Status <span class="text-danger" title="Required">*</span></label>
                                                        <select name="status" id="status" class="form-control selectable">
                                                            <option value="1" @if($banner->status == 1) selected @endif>Visible</option>
                                                            <option value="0" @if($banner->status == 0) selected @endif>Invisible</option>
                                                        </select>
                                                        @if($errors->has('status'))
                                                            <span class="text-danger"> {{ $errors->first('status') }}</span>
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
                                                                <input type='file' name="marketing_banner_image" id="img1Upload" accept=".png, .jpg, .jpeg" required/>
                                                                <label for="img1Upload"><i class="fa fa-edit"></i></label>
                                                            </div>
                                                            <div class="avatar-preview" style="width:100%">
                                                                <div id="img1Preview" style="background-image: url({{ $banner->marketing_banner_image }});"></div>
                                                            </div>
                                                        </div>
                                                        @if($errors->has('marketing_banner_image'))
                                                            <span class="text-danger"> {{ $errors->first('marketing_banner_image') }}</span>
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
</div>
@endsection
@section('scripts')
    <script>
        //im1 upload
        function img1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#img1Preview').css('background-image', 'url('+e.target.result +')');
                    $('#img1Preview').hide();
                    $('#img1Preview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#img1Upload").change(function() {
            img1(this);
        });
    </script>
@endsection
