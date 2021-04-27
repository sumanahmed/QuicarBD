@extends('quicarbd.admin.layout.admin')
@section('title','User App')
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
                <li><a href="#">Setting</a></li>
                <li class="active"><span>User App Information</span></li>
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
                        <h6 class="txt-dark capitalize-font"><i class="fa fa-car mr-10"></i>User App Information</h6> 
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-wrap">
                                    <form action="{{ route('setting.user-app-info.update') }}" method="post" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="form-body">     
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="forceUpdate" class="control-label mb-10">Force Update <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select name="forceUpdate" id="forceUpdate" class="form-control" required>
                                                            <option value="1" @if($setting->forceUpdate == 1) selected @endif>Yes</option>
                                                            <option value="0" @if($setting->forceUpdate == 0) selected @endif>No</option>
                                                        </select>
                                                        @if($errors->has('forceUpdate'))
                                                            <span class="text-danger"> {{ $errors->first('forceUpdate') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-3">                                        
                                                    <div class="form-group">
                                                        <label for="updateDate" class="control-label mb-10"> Update Date <span class="text-danger" title="Required">*</span></label>
                                                        <input type="date" id="updateDate" name="updateDate" value="{{ $setting->updateDate }}" class="form-control" required>
                                                        @if($errors->has('updateDate'))
                                                            <span class="text-danger"> {{ $errors->first('updateDate') }}</span>
                                                        @endif
                                                    </div>
                                                </div>   
                                                <div class="col-md-3">                                        
                                                    <div class="form-group">
                                                        <label for="latestVersionName" class="control-label mb-10"> Latest Version Name <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="latestVersionName" name="latestVersionName" value="{{ $setting->latestVersionName }}" class="form-control" required>
                                                        @if($errors->has('latestVersionName'))
                                                            <span class="text-danger"> {{ $errors->first('latestVersionName') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-3">                                        
                                                    <div class="form-group">
                                                        <label for="latestVersionCode" class="control-label mb-10"> Latest Version Code <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="latestVersionCode" name="latestVersionCode" value="{{ $setting->latestVersionCode }}" class="form-control" required>
                                                        @if($errors->has('latestVersionCode'))
                                                            <span class="text-danger"> {{ $errors->first('latestVersionCode') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="whatsNew" class="control-label mb-10">Whats New  <span class="text-danger" title="Required">*</span></label>                                                        
                                                        <textarea name="whatsNew" id="whatsNew" class="form-control summernote" required/>{{ $setting->whatsNew }}</textarea>
                                                        @if($errors->has('whatsNew'))
                                                            <span class="text-danger"> {{ $errors->first('whatsNew') }}</span>
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
