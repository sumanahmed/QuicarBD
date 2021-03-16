@extends('quicarbd.admin.layout.admin')
@section('title','Package Banner')
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
            <li class="active"><span>Edit {{ $title }} Banner</span></li>
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
                        <h6 class="txt-dark capitalize-font"></i>{{ $title }} Banner</h6> 
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-wrap">
                                    <form action="{{ route('banner.packages.update') }}" method="post" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="img1" class="control-label mb-10">{{ $title }} <span class="text-danger" title="Required">*</span></label>                                                                                                                
                                                        <div class="avatar-upload">
                                                            <div class="avatar-edit">
                                                                <input type='file' name="{{ $name }}" id="img1Upload" accept=".png, .jpg, .jpeg" required/>
                                                                <label for="img1Upload"><i class="fa fa-edit"></i></label>
                                                            </div>
                                                            <div class="avatar-preview" style="width:100%">
                                                                @if($type == 1)
                                                                    <div id="img1Preview" style="background-image: url(http://quicarbd.com/{{ $banner->car_package }});"></div>
                                                                @elseif($type == 2)
                                                                    <div id="img1Preview" style="background-image: url(http://quicarbd.com/{{ $banner->hotel_package }});"></div> 
                                                                @else
                                                                    <div id="img1Preview" style="background-image: url(http://quicarbd.com/{{ $banner->travel_package }});"></div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="type" value="{{ $type }}"/>
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

        $("#dashboard").addClass('active');

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
