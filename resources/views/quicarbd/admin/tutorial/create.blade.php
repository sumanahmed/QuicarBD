@extends('quicarbd.admin.layout.admin')
@section('title','Tutorial')
@section('content')
<div class="container-fluid">               
    <!-- Title -->
    <div class="row heading-bg">
        <div class="col-md-md-lg-3 col-md-4 col-sm-4 col-xs-12">
        </div>
        <!-- Breadcrumb -->
        <div class="col-md-md-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Tutorial</a></li>
                <li class="active"><span>Add New Tutorial</span></li>
            </ol>
        </div>
        <!-- /Breadcrumb -->
    </div>
    <!-- /Title -->    
    <!-- Row -->
    <div class="row">
        <div class="col-md-md-sm-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="txt-dark capitalize-font"><i class="fa fa-car mr-10"></i>{{ $type == 0 ? 'User' : 'Partner' }} Tutorial Info</h6> 
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-md-sm-12 col-xs-12">
                                <div class="form-wrap">
                                    <form action="{{ route('tutorial.store') }}" method="post" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="form-body">     
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="title" class="control-label mb-10">Title <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control" placeholder="Title" required>
                                                        <input type="hidden" name="type" value="{{ $type == 0 ? 'user' : 'partner' }}" />
                                                        <input type="hidden" name="serial" value="{{ $serial }}" />
                                                        @if($errors->has('title'))
                                                            <span class="text-danger"> {{ $errors->first('title') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="video_id" class="control-label mb-10">Video ID <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="video_id" name="video_id" value="{{ old('video_id') }}" class="form-control" placeholder="Video ID" required>
                                                        @if($errors->has('video_id'))
                                                            <span class="text-danger"> {{ $errors->first('video_id') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="status" class="control-label mb-10">Status <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select class="form-control" name="status" id="status"> 
                                                            <option value="1">Show</option>
                                                            <option value="0">Hide</option>
                                                        </select>
                                                        @if($errors->has('status'))
                                                            <span class="text-danger"> {{ $errors->first('status') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="submit" class="btn btn-success" value="Submit"/>
                                                        <input type="reset" class="btn btn-danger" value="Cancel"/>
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
        $("#dashboard").addClass('active');
    </script>
@endsection
