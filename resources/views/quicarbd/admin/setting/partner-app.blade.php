@extends('quicarbd.admin.layout.admin')
@section('title','Parnter App')
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
                <li><a href="#">Setting</a></li>
                <li class="active"><span>Partner App Setting</span></li>
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
                        <h6 class="txt-dark capitalize-font"><i class="fa fa-car mr-10"></i>Parnter App Setting</h6> 
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-wrap">
                                    <form action="{{ route('setting.partner-app.update') }}" method="post" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="form-body">     
                                            <div class="row">
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="trip_count" class="control-label mb-10"> Trip Count <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="trip_count" name="trip_count" value="{{ $setting->trip_count }}" class="form-control" required>
                                                        @if($errors->has('trip_count'))
                                                            <span class="text-danger"> {{ $errors->first('trip_count') }}</span>
                                                        @endif
                                                    </div>
                                                </div> 
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="bonous" class="control-label mb-10"> Bonus <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="bonous" name="bonous" value="{{ $setting->bonous }}" class="form-control" required>
                                                        @if($errors->has('bonous'))
                                                            <span class="text-danger"> {{ $errors->first('bonous') }}</span>
                                                        @endif
                                                    </div>
                                                </div> 
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="date" class="control-label mb-10"> Date <span class="text-danger" title="Required">*</span></label>
                                                        <input type="date" id="date" name="date" value="{{ $setting->date }}" class="form-control" required>
                                                        @if($errors->has('date'))
                                                            <span class="text-danger"> {{ $errors->first('date') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="time" class="control-label mb-10"> Time <span class="text-danger" title="Required">*</span></label>
                                                        <input type="time" id="time" name="time" value="{{ $setting->time }}" class="form-control" required>
                                                        @if($errors->has('time'))
                                                            <span class="text-danger"> {{ $errors->first('time') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="api" class="control-label mb-10"> Api </label>
                                                        <input type="text" id="api" name="api" value="{{ $setting->api }}" class="form-control">
                                                        @if($errors->has('api'))
                                                            <span class="text-danger"> {{ $errors->first('api') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="info" class="control-label mb-10"> Information <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="info" name="info" value="{{ $setting->info }}" class="form-control" required>
                                                        @if($errors->has('info'))
                                                            <span class="text-danger"> {{ $errors->first('info') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="app_vertion_code" class="control-label mb-10"> App Version Code <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="app_vertion_code" name="app_vertion_code" value="{{ $setting->app_vertion_code }}" class="form-control" required>
                                                        @if($errors->has('app_vertion_code'))
                                                            <span class="text-danger"> {{ $errors->first('app_vertion_code') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="app_vertion_name" class="control-label mb-10"> App Version Time <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="app_vertion_name" name="app_vertion_name" value="{{ $setting->app_vertion_name }}" class="form-control" required>
                                                        @if($errors->has('app_vertion_name'))
                                                            <span class="text-danger"> {{ $errors->first('app_vertion_name') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="mandatory_update" class="control-label mb-10">Mandatory Update <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select name="mandatory_update" id="mandatory_update" class="form-control" required>
                                                            <option value="1" @if($setting->mandatory_update == 1) selected @endif>Yes</option>
                                                            <option value="0" @if($setting->mandatory_update == 0) selected @endif>No</option>
                                                        </select>
                                                        @if($errors->has('mandatory_update'))
                                                            <span class="text-danger"> {{ $errors->first('mandatory_update') }}</span>
                                                        @endif
                                                    </div>
                                                </div>                                                
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="download_url" class="control-label mb-10"> Download URL </label>
                                                        <input type="text" id="download_url" name="download_url" value="{{ $setting->download_url }}" class="form-control">
                                                        @if($errors->has('download_url'))
                                                            <span class="text-danger"> {{ $errors->first('download_url') }}</span>
                                                        @endif
                                                    </div>
                                                </div>                                              
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="bidding_percent" class="control-label mb-10"> Bidding Percent <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="bidding_percent" name="bidding_percent" value="{{ $setting->bidding_percent }}" class="form-control" required>
                                                        @if($errors->has('bidding_percent'))
                                                            <span class="text-danger"> {{ $errors->first('bidding_percent') }}</span>
                                                        @endif
                                                    </div>
                                                </div>                                         
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="car_package_charge" class="control-label mb-10"> Car Package Charge <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="car_package_charge" name="car_package_charge" value="{{ $setting->car_package_charge }}" class="form-control" required>
                                                        @if($errors->has('car_package_charge'))
                                                            <span class="text-danger"> {{ $errors->first('car_package_charge') }}</span>
                                                        @endif
                                                    </div>
                                                </div>                                       
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="hotel_package_charge" class="control-label mb-10"> Hotel Package Charge <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="hotel_package_charge" name="hotel_package_charge" value="{{ $setting->hotel_package_charge }}" class="form-control" required>
                                                        @if($errors->has('hotel_package_charge'))
                                                            <span class="text-danger"> {{ $errors->first('hotel_package_charge') }}</span>
                                                        @endif
                                                    </div>
                                                </div>                                    
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="travel_package_charge" class="control-label mb-10"> Travel Package Charge <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="travel_package_charge" name="travel_package_charge" value="{{ $setting->travel_package_charge }}" class="form-control" required>
                                                        @if($errors->has('travel_package_charge'))
                                                            <span class="text-danger"> {{ $errors->first('travel_package_charge') }}</span>
                                                        @endif
                                                    </div>
                                                </div>                         
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="direct_contact_number" class="control-label mb-10"> Direct Contact Number <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="direct_contact_number" name="direct_contact_number" value="{{ $setting->direct_contact_number }}" class="form-control" required>
                                                        @if($errors->has('direct_contact_number'))
                                                            <span class="text-danger"> {{ $errors->first('direct_contact_number') }}</span>
                                                        @endif
                                                    </div>
                                                </div>                                                
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="direct_contact_number_for_user" class="control-label mb-10"> Direct Contact Number for User <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="direct_contact_number_for_user" name="direct_contact_number_for_user" value="{{ $setting->direct_contact_number_for_user }}" class="form-control" required>
                                                        @if($errors->has('direct_contact_number_for_user'))
                                                            <span class="text-danger"> {{ $errors->first('direct_contact_number_for_user') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="office_address" class="control-label mb-10"> Office Address <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="office_address" name="office_address" value="{{ $setting->office_address }}" class="form-control" required>
                                                        @if($errors->has('office_address'))
                                                            <span class="text-danger"> {{ $errors->first('office_address') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="facebook_link" class="control-label mb-10"> Facebook Link <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="facebook_link" name="facebook_link" value="{{ $setting->facebook_link }}" class="form-control" required>
                                                        @if($errors->has('facebook_link'))
                                                            <span class="text-danger"> {{ $errors->first('facebook_link') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">                                        
                                                    <div class="form-group">
                                                        <label for="twitter_link" class="control-label mb-10"> Twitter Link <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="twitter_link" name="twitter_link" value="{{ $setting->twitter_link }}" class="form-control" required>
                                                        @if($errors->has('twitter_link'))
                                                            <span class="text-danger"> {{ $errors->first('twitter_link') }}</span>
                                                        @endif
                                                    </div>
                                                </div>       
                                                <div class="col-md-3">                                        
                                                    <div class="form-group">
                                                        <label for="user_app_version_code" class="control-label mb-10"> User App Version Code <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="user_app_version_code" name="user_app_version_code" value="{{ $setting->user_app_version_code }}" class="form-control" required>
                                                        @if($errors->has('user_app_version_code'))
                                                            <span class="text-danger"> {{ $errors->first('user_app_version_code') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-3">                                        
                                                    <div class="form-group">
                                                        <label for="user_app_version_name" class="control-label mb-10"> User App Version Name</label>
                                                        <input type="text" id="user_app_version_name" name="user_app_version_name" value="{{ $setting->user_app_version_name }}" class="form-control">
                                                        @if($errors->has('user_app_version_name'))
                                                            <span class="text-danger"> {{ $errors->first('user_app_version_name') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="user_app_mandatory_audate" class="control-label mb-10">App Mandatory Update <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select name="user_app_mandatory_audate" id="user_app_mandatory_audate" class="form-control" required>
                                                            <option value="1" @if($setting->user_app_mandatory_audate == 1) selected @endif>Yes</option>
                                                            <option value="0" @if($setting->user_app_mandatory_audate == 0) selected @endif>No</option>
                                                        </select>
                                                        @if($errors->has('user_app_mandatory_audate'))
                                                            <span class="text-danger"> {{ $errors->first('user_app_mandatory_audate') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>    
                                            <div class="row">
                                                <div class="col-md-6">                                        
                                                    <div class="form-group">
                                                        <label for="whats_new_in_update" class="control-label mb-10"> Whats New in Update </label>
                                                        <textarea id="whats_new_in_update" name="whats_new_in_update" class="form-control">{{ $setting->whats_new_in_update }}</textarea>
                                                        @if($errors->has('whats_new_in_update'))
                                                            <span class="text-danger"> {{ $errors->first('whats_new_in_update') }}</span>
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
