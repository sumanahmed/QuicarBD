@extends('quicarbd.admin.layout.admin')
@section('title','Partner Banner')
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
            <li class="active"><span>Edit Parnter Banner</span></li>
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
                                    <form action="{{ route('partner_banner.update', $partner_banner->id) }}" method="post" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="form-body">     
                                            <div class="row">
                                                <div class="col-md-6">                                        
                                                    <div class="form-group">
                                                        <label for="title" class="control-label mb-10"> Title <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="title" name="title" placeholder="Title" value="{{ $partner_banner->title }}" class="form-control" required>
                                                        @if($errors->has('title'))
                                                            <span class="text-danger"> {{ $errors->first('title') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                        
                                                    <div class="form-group">
                                                        <label for="status" class="control-label mb-10">Status <span class="text-danger" title="Required">*</span></label>
                                                        <select name="status" id="status" class="form-control selectable">
                                                            <option value="1" @if($partner_banner->status == 1) selected @endif>Enable</option>
                                                            <option value="0" @if($partner_banner->status == 0) selected @endif>Disable</option>
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
                                                                <input type='file' name="image_url" id="img1Upload" accept=".png, .jpg, .jpeg" required/>
                                                                <label for="img1Upload"><i class="fa fa-edit"></i></label>
                                                            </div>
                                                            <div class="avatar-preview" style="width:100%">
                                                                <div id="img1Preview" style="background-image: url(http://quicarbd.com/{{ $partner_banner->image_url }});"></div>
                                                            </div>
                                                        </div>
                                                        @if($errors->has('image_url'))
                                                            <span class="text-danger"> {{ $errors->first('image_url') }}</span>
                                                        @endif
                                                    </div>
                                                </div>   
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="details" class="control-label mb-10">Details <span class="text-danger" title="Required">*</span></label>                                            
                                                        <textarea name="details" rows="10" class="form-control summernote" require >{{ $partner_banner->details }}</textarea>
                                                        @if($errors->has('details'))
                                                            <span class="text-danger"> {{ $errors->first('details') }}</span>
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
	<script src="{{ asset('quicarbd/admin/js/partner-banner.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
