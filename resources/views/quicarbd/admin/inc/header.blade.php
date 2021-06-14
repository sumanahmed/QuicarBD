
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="_token" content="{{ csrf_token() }}">
	<title>Quicar - @yield('title')</title>
	<meta name="description" content="Quicarbd is car rental software" />
	<meta name="keywords" content="quicar, quicarbd" />
	<meta name="author" content="hencework"/>	
	<!-- Favicon -->
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="icon" href="favicon.ico" type="image/x-icon">	
	<link href="{{ asset('quicarbd/admin/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('quicarbd/admin/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('quicarbd/admin/vendors/bower_components/summernote/dist/summernote.css') }}" rel="stylesheet" type="text/css">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<link href="{{ asset('quicarbd/admin/dist/css/toastr.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('quicarbd/admin/dist/css/style.css') }}" rel="stylesheet" type="text/css">
	@yield('styles')
</head>

<body>
<?php
	$current_date_time = \Carbon\Carbon::now()->toDateTimeString();
    $pendingDriver = \App\Models\Driver::where('c_status', 0)->count('id');
    $pendingCar = \App\Models\Car::where('status', 0)->count('id');
    $pendingCarPackage = \App\Models\CarPackage::where('status', 0)->count('id');
    $pendingHotelPackage = \App\Models\HotelPackage::where('status', 0)->count('id');
    $pendingPartner = \App\Models\Owner::where('account_status', 0)->count('id');
    $pendingRide = \App\Models\RideList::where('status', 0)->count('id');
    $bookingRide = \App\Models\RideList::where('status', 4)
					->where('accepted_ride_bitting_id', '!=', null)
					->where('start_time', '>', $current_date_time)
					->count('id');
    $cancelRide = \App\Models\RideList::where('status', 2)
                    ->where('accepted_ride_bitting_id','!=',null)
                    ->where('payment_status',1)
                    ->count('id');
?>
    <div class="wrapper theme-1-active pimary-color-blue">
		<!-- Top Menu Items -->
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="mobile-only-brand pull-left">
				<div class="nav-header pull-left">
					<div class="logo-wrap">
						<a href="/">
							<img class="brand-img" src="{{ asset('quicarbd/logo.png') }}" alt="brand"/>
						</a>
					</div>
				</div>	
				<a id="toggle_nav_btn" class="toggle-left-nav-btn inline-block ml-20 pull-left" href="javascript:void(0);"><i class="zmdi zmdi-menu"></i></a>
				<a id="toggle_mobile_search" data-toggle="collapse" data-target="#search_form" class="mobile-only-view" href="javascript:void(0);"><i class="zmdi zmdi-search"></i></a>
				<a id="toggle_mobile_nav" class="mobile-only-view" href="javascript:void(0);"><i class="zmdi zmdi-more"></i></a>
			</div>
			<div id="mobile_only_nav" class="mobile-only-nav pull-right">
				<ul class="nav navbar-right top-nav pull-right">
					<li class="dropdown alert-drp">
						<a href="{{ route('partner.verification') }}" title="Pending Partner">Partner <i class="zmdi zmdi-notifications top-nav-icon"></i>
    						@if($pendingPartner > 0)
    						    <span class="top-nav-icon-badge">{{ $pendingPartner }}</span>
    						@endif
						</a>
					</li>
					<li class="dropdown alert-drp">
						<a href="{{ route('car.index') }}" title="Pending Car">Car <i class="zmdi zmdi-car top-nav-icon"></i>
    						@if($pendingCar > 0)
    						    <span class="top-nav-icon-badge">{{ $pendingCar }}</span>
    						@endif
						</a>
					</li>
					<li class="dropdown alert-drp">
						<a href="{{ route('driver.index') }}" title="Pending Driver">Driver <i class="zmdi zmdi-car top-nav-icon"></i>
    						@if($pendingDriver > 0)
    						    <span class="top-nav-icon-badge">{{ $pendingDriver }}</span>
    						@endif
						</a>
					</li>
					<li class="dropdown alert-drp">
						<a href="{{ route('ride.pending') }}" title="Pending Ride">Pending Ride <i class="zmdi zmdi-notifications top-nav-icon"></i>
    						@if($pendingRide > 0)
    						    <span class="top-nav-icon-badge">{{ $pendingRide }}</span>
    						@endif
						</a>
					</li>
					<li class="dropdown alert-drp">
						<a href="{{ route('ride.upcoming') }}" title="Booking Ride">Booking Ride <i class="zmdi zmdi-notifications top-nav-icon"></i>
    						@if($pendingRide > 0)
    						    <span class="top-nav-icon-badge">{{ $pendingRide }}</span>
    						@endif
						</a>
					</li>
					<li class="dropdown alert-drp">
						<a href="{{ route('ride.cancel') }}" title="Cancel Ride">Booking Cancel Ride <i class="zmdi zmdi-notifications top-nav-icon"></i>
    						@if($cancelRide > 0)
    						    <span class="top-nav-icon-badge">{{ $cancelRide }}</span>
    						@endif
						</a>
					</li>
					<li class="dropdown alert-drp">
						<a href="{{ route('car_package.index') }}" title="Pending Car Package">Car Package <i class="zmdi zmdi-notifications top-nav-icon"></i>
    						@if($pendingCarPackage > 0)
    						    <span class="top-nav-icon-badge">{{ $pendingCarPackage }}</span>
    						@endif
						</a>
					</li>
					<li class="dropdown alert-drp">
						<a href="{{ route('hotel_package.index') }}" title="Pending Hotel Package">Hotel Package <i class="zmdi zmdi-notifications top-nav-icon"></i>
    						@if($pendingHotelPackage > 0)
    						    <span class="top-nav-icon-badge">{{ $pendingHotelPackage }}</span>
    						@endif
						</a>
					</li>
					<li class="dropdown auth-drp">
						<a href="#" class="dropdown-toggle pr-0" data-toggle="dropdown"><img src="{{ asset('quicarbd/admin/img/user1.png') }}" alt="user_auth" class="user-auth-img img-circle"/><span class="user-online-status"></span></a>
						<ul class="dropdown-menu user-auth-dropdown" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
							<li>
								<a href="#"><i class="zmdi zmdi-account"></i><span>Profile</span></a>
							</li>
							<li>
								<a href="#"><i class="zmdi zmdi-settings"></i><span>Settings</span></a>
							</li>
							<li class="divider"></li>
							<li class="sub-menu show-on-hover">
								<a href="#" class="pr-0 level-2-drp"><i class="zmdi zmdi-check text-success"></i> available</a>	
							</li>
							<li class="divider"></li>
							<li>
								<a href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();"><i class="zmdi zmdi-power"></i><span>Log Out</span></a>
								<form id="logoutForm" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
									@csrf
								</form>
							</li>
						</ul>
					</li>
				</ul>
			</div>	
		</nav>