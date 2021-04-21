@extends('quicarbd.admin.layout.admin')
@section('title','Coupon')
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
                <li><a href="#">Coupon</a></li>
                <li class="active"><span>{{ $coupon_for == 1 ? 'User' : 'Partner' }}</span></li>
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
                        <h6 class="txt-dark capitalize-font"><i class="fa fa-car mr-10"></i>Coupon Info</h6> 
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="form-wrap">
                                    <form action="{{ route('coupon.store') }}" method="post" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <div class="form-body">     
                                            <div class="row">
                                                <div class="col-md-4">                                        
                                                    <div class="form-group">
                                                        <label for="coupon" class="control-label mb-10"> Coupon <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="coupon" name="coupon" value="{{ old('coupon') }}" placeholder="Enter Coupon Code" class="form-control" required>
                                                        <input type="hidden" name="coupon_for" value="{{ $coupon_for }}" />
                                                        @if($errors->has('coupon'))
                                                            <span class="text-danger"> {{ $errors->first('coupon') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="status" class="control-label mb-10">Status <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select name="status" id="status" class="form-control">
                                                            <option value="1">Active</option>
                                                            <option value="0">Block</option>
                                                        </select>
                                                        @if($errors->has('status'))
                                                            <span class="text-danger"> {{ $errors->first('status') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="type" class="control-label mb-10">Type <span class="text-danger" title="Required">*</span></label>                                            
                                                        <select name="type" id="type" class="form-control">
                                                            <option value="1">Percentage</option>
                                                            <option value="2">Direct Amount</option>
                                                        </select>
                                                        @if($errors->has('type'))
                                                            <span class="text-danger"> {{ $errors->first('type') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>    
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="percentage" class="control-label mb-10">Percentage </label>                                                        
                                                        <input type='text' name="percentage" id="percentage" value="{{ old('percentage') }}" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                                                        @if($errors->has('percentage'))
                                                            <span class="text-danger"> {{ $errors->first('percentage') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="amount" class="control-label mb-10">Amount </label>                                                        
                                                        <input type='text' name="amount" id="amount" value="{{ old('amount') }}" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                                                        @if($errors->has('amount'))
                                                            <span class="text-danger"> {{ $errors->first('amount') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="spacifice_user" class="control-label mb-10">Specific User </label>                                            
                                                        <select id="spacifice_user" name="spacifice_user" class="form-control selectable">                                                            
                                                            <option value="0">Global</option>                                                            
                                                            <option value="1">Specific User</option>                                                          
                                                        </select>
                                                        @if($errors->has('spacifice_user'))
                                                            <span class="text-danger"> {{ $errors->first('spacifice_user') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4" id="showUser" style="display:none">
                                                    <div class="form-group">
                                                        <label for="user_id" class="control-label mb-10">Users </label>                                            
                                                        <select id="user_id" name="user_id" class="form-control">                                                            
                                                            <option value="0">Select</option>  
                                                            @foreach($users as $user)
                                                                <option value="{{ $user->id }}">{{ $user->name }}</option>                                                             
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('user_id'))
                                                            <span class="text-danger"> {{ $errors->first('user_id') }}</span>
                                                        @endif
                                                    </div>
                                                </div>                                          
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="start" class="control-label mb-10">Start <span class="text-danger" title="Required">*</span></label>
                                                        <input type="datetime-local" id="start" name="start" value="{{ old('start') }}" class="form-control" required/>
                                                        @if($errors->has('start'))
                                                            <span class="text-danger"> {{ $errors->first('start') }}</span>
                                                        @endif
                                                    </div>
                                                </div>                                      
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="end" class="control-label mb-10">End <span class="text-danger" title="Required">*</span></label>
                                                        <input type="datetime-local" id="end" name="end" value="{{ old('end') }}" class="form-control" required/>
                                                        @if($errors->has('end'))
                                                            <span class="text-danger"> {{ $errors->first('end') }}</span>
                                                        @endif
                                                    </div>
                                                </div>                                    
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="upto_amount" class="control-label mb-10">Upto Amount <span class="text-danger" title="Required">*</span></label>
                                                        <input type="text" id="upto_amount" name="upto_amount" value="0" class="form-control" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                                                        @if($errors->has('upto_amount'))
                                                            <span class="text-danger"> {{ $errors->first('upto_amount') }}</span>
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
        $( "#spacifice_user" ).change(function() {
            
            var spacifice_user = $(this).val();
            
            if(spacifice_user == 1) {
                $("#showUser").show();
            } else {
                $("#showUser").hide();
            }
        });
    </script>
@endsection
