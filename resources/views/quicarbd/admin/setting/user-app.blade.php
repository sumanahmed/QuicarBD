@extends('quicarbd.admin.layout.admin')
@section('title','User App')
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
                <li class="active"><span>User App Setting</span></li>
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
                        <h6 class="txt-dark capitalize-font"><i class="fa fa-car mr-10"></i>User App Setting</h6> 
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-wrap">
                                    <form action="{{ route('setting.user-app.update') }}" method="post" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="form-body">     
                                            <div class="row">
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="bonus_getting_message" class="control-label mb-10"> Bonus Getting Message <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="bonus_getting_message" name="bonus_getting_message" value="{{ $setting->bonus_getting_message }}" class="form-control" required>
                                                        @if($errors->has('bonus_getting_message'))
                                                            <span class="text-danger"> {{ $errors->first('bonus_getting_message') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="signup_bobus" class="control-label mb-10">Signup Bonus <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select name="signup_bobus" id="signup_bobus" class="form-control" required>
                                                            <option value="1" @if($setting->signup_bobus == 1) selected @endif>Yes</option>
                                                            <option value="0" @if($setting->signup_bobus == 0) selected @endif>No</option>
                                                        </select>
                                                        @if($errors->has('signup_bobus'))
                                                            <span class="text-danger"> {{ $errors->first('signup_bobus') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="amount" class="control-label mb-10">Amount </label>                                                        
                                                        <input type='text' name="amount" id="amount" value="{{ $setting->amount }}" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  required/>
                                                        @if($errors->has('amount'))
                                                            <span class="text-danger"> {{ $errors->first('amount') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>    
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="marketing_dialog_title" class="control-label mb-10">Marketing Dialog Title  <span class="text-danger" title="Required">*</span></label>                                                        
                                                        <input type='text' name="marketing_dialog_title" id="marketing_dialog_title" value="{{ $setting->marketing_dialog_title }}" class="form-control" required/>
                                                        @if($errors->has('marketing_dialog_title'))
                                                            <span class="text-danger"> {{ $errors->first('marketing_dialog_title') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="marketing_dialog_show" class="control-label mb-10">Marketing Dialog Show <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select name="marketing_dialog_show" id="signup_bobus" class="form-control" required>
                                                            <option value="1" @if($setting->marketing_dialog_show == 1) selected @endif>Yes</option>
                                                            <option value="0" @if($setting->marketing_dialog_show == 0) selected @endif>No</option>
                                                        </select>
                                                        @if($errors->has('marketing_dialog_show'))
                                                            <span class="text-danger"> {{ $errors->first('marketing_dialog_show') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="max_adv_booking_ride" class="control-label mb-10">Maximum Advance Booking Ride <span class="text-danger" title="Required">*</span></label>                                                        
                                                        <input type='text' name="max_adv_booking_ride" id="max_adv_booking_ride" value="{{ $setting->max_adv_booking_ride }}" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required/>
                                                        @if($errors->has('max_adv_booking_ride'))
                                                            <span class="text-danger"> {{ $errors->first('max_adv_booking_ride') }}</span>
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
                                                                <div id="img1Preview" style="background-image: url({{ $setting->marketing_banner_image }});"></div>
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
