<?php
    $pendingDriver = \App\Models\Driver::where('c_status', 0)->count('id');
    $pendingCar = \App\Models\Car::where('status', 0)->count('id');
    $pendingCarPackage = \App\Models\CarPackage::where('status', 0)->count('id');
    $pendingHotelPackage = \App\Models\HotelPackage::where('status', 0)->count('id');
    $pendingPartner = \App\Models\Owner::where('account_status', 0)->count('id');
?>

<div class="fixed-sidebar-left">
    <ul class="nav navbar-nav side-nav nicescroll-bar">
        <li class="navigation-header">
            <span>Main</span> 
            <i class="zmdi zmdi-more"></i>
        </li>
        
        <li>
            <a href="{{ route('dashboard') }}"><div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Dashboard</span></div><div class="pull-right"></div><div class="clearfix"></div></a>
        </li>
        <li><hr class="light-grey-hr mb-10"/></li>
        <li class="navigation-header">
            <span>component</span> 
            <i class="zmdi zmdi-more"></i>
        </li>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#setting"><div class="pull-left"><i class="fa fa-cog mr-20"></i><span class="right-nav-text">Settings</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>            <ul id="setting" class="collapse collapse-level-1 two-col-list">
                <li>
                    <a href="{{ route('setting.district.index') }}">District</a>
                </li>
                <li>
                    <a href="{{ route('setting.city.index') }}">City</a>
                </li>
                <li>
                    <a href="{{ route('setting.tour_spot.index') }}">Tour Spot</a>
                </li>
                <li>
                    <a href="{{ route('setting.user-app.edit') }}">User App</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{ route('user.index') }}"><div class="pull-left"><i class="fa fa-user mr-20"></i><span class="right-nav-text">User</span></div><div class="pull-right"></div><div class="clearfix"></div></a>
        </li>
        <li>
            <a href="{{ route('user.user_log_list') }}"><div class="pull-left"><i class="fa fa-history mr-20"></i><span class="right-nav-text">User Log</span></div><div class="pull-right"></div><div class="clearfix"></div></a>
        </li>
        <li>
            <a href="{{ route('driver.index') }}"><div class="pull-left"><i class="fa fa-user mr-20"></i><span class="right-nav-text">Driver</span></div><div class="pull-right"></div>
                @if($pendingDriver > 0)
                    <div class="pull-right"><span class="label label-warning">{{ $pendingDriver }}</span></div>
                @endif
                <div class="clearfix"></div>
            </a>
        </li>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#partners"><div class="pull-left"><i class="fa fa-user mr-20"></i><span class="right-nav-text">Partner</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
            <ul id="partners" class="collapse collapse-level-1 two-col-list">
                <li>
                    <a href="{{ route('partner.create') }}">Add New</a>
                </li>
                <li>
                    <a href="{{ route('partner.index') }}">All Partner </a>
                </li>
                <li>
                    <a href="{{ route('partner.verification') }}">Partner Verification
                        @if($pendingPartner > 0)
                            <div class="pull-right"><span class="label label-warning">{{ $pendingPartner }}</span></div>
                        @endif
                    </a>
                </li>
                <li>
                    <a href="{{ route('partner.account_type_change_request') }}">Account Type Change Request</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#smsNotification"><div class="pull-left"><i class="fa fa-bell mr-20"></i><span class="right-nav-text">SMS Notification</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
            <ul id="smsNotification" class="collapse collapse-level-1 two-col-list">
                <li>
                    <a href="{{ route('sms_notification.push_notification') }}">Push Notification</a>
                </li>
                <li>
                    <a href="{{ route('sms_notification.index') }}">SMS & Notification</a>
                </li>
                <li>
                    <a href="{{ route('sms_notification.global_notification') }}">Global Notification</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#message"><div class="pull-left"><i class="fa fa-envelope mr-20"></i><span class="right-nav-text">Message</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
            <ul id="message" class="collapse collapse-level-1 two-col-list">
                <li>
                    <a href="{{ route('message.partner') }}">Partner</a>
                </li>
                <li>
                    <a href="{{ route('message.user') }}">User</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#complain"><div class="pull-left"><i class="fa fa-envelope mr-20"></i><span class="right-nav-text">Complain</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
            <ul id="complain" class="collapse collapse-level-1 two-col-list">
                <li>
                    <a href="{{ route('complain.partner') }}">Partner</a>
                </li>
                <li>
                    <a href="{{ route('complain.user') }}">User</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#cars"><div class="pull-left"><i class="fa fa-car mr-20"></i><span class="right-nav-text">Cars</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
            <ul id="cars" class="collapse collapse-level-1 two-col-list">
                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#carInfo"><div class="pull-left"><span class="right-nav-text">All Car</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
                    <ul id="carInfo" class="collapse collapse-level-1 two-col-list">
                        <li>
                            <a href="{{ route('car.create') }}">Add New Car</a>
                        </li>
                        <li>
                            <a href="{{ route('car.index') }}">All Car 
                            @if($pendingCar > 0)
                                <div class="pull-right"><span class="label label-warning">{{ $pendingCar }}</span></div>
                            @endif
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('car.expired') }}">Expired Car</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#carinfo"><div class="pull-left"><span class="right-nav-text">Car Info</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
                    <ul id="carinfo" class="collapse collapse-level-1 two-col-list">
                        <li>
                            <a href="{{ route('car_type.index') }}">Types</a>
                        </li>
                        <li>
                            <a href="{{ route('brand.index') }}">Brand</a>
                        </li>
                        <li>
                            <a href="{{ route('model.index') }}">Model</a>
                        </li>
                        <li>
                            <a href="{{ route('year.index') }}">Year</a>
                        </li>
                        <li>
                            <a href="{{ route('class.index') }}">Class</a>
                        </li>
                        <li>
                            <a href="{{ route('color.index') }}">Color</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#coupons"><div class="pull-left"><i class="fa fa-car mr-20"></i><span class="right-nav-text">Coupon</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
            <ul id="coupons" class="collapse collapse-level-1 two-col-list">
                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#userCoupon"><div class="pull-left"><span class="right-nav-text">User</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
                    <ul id="userCoupon" class="collapse collapse-level-1 two-col-list">
                        <li>
                            <a href="{{ route('coupon.index', ['coupon_for' => 1]) }}">Coupon List</a>
                        </li>
                        <li>
                            <a href="{{ route('coupon.usedList', ['coupon_for' => 1]) }}">Used List</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#partnerCoupon"><div class="pull-left"><span class="right-nav-text">Partner</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
                    <ul id="partnerCoupon" class="collapse collapse-level-1 two-col-list">
                        <li>
                            <a href="{{ route('coupon.index', ['coupon_for' => 2]) }}">Coupon List</a>
                        </li>
                        <li>
                            <a href="{{ route('coupon.usedList', ['coupon_for' => 2]) }}">Used List</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#packages"><div class="pull-left"><i class="fa fa-cube mr-20"></i><span class="right-nav-text">Packages</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
            <ul id="packages" class="collapse collapse-level-1 two-col-list">
                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#carPackage"><div class="pull-left"><span class="right-nav-text">Car Package</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
                    <ul id="carPackage" class="collapse collapse-level-1 two-col-list">
                        <li>
                            <a href="{{ route('car_package.create') }}">Add New</a>
                        </li>
                        <li>
                            <a href="{{ route('car_package.index') }}">All 
                                @if($pendingCarPackage > 0)
                                    <div class="pull-right"><span class="label label-warning">{{ $pendingCarPackage }}</span></div>
                                @endif
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#hotelPackage"><div class="pull-left"><span class="right-nav-text">Hotel Package</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
                    <ul id="hotelPackage" class="collapse collapse-level-1 two-col-list">
                        <li>
                            <a href="{{ route('hotel_package.create') }}">Add New</a>
                        </li>
                        <li>
                            <a href="{{ route('hotel_package.index') }}">All 
                                @if($pendingHotelPackage > 0)
                                    <div class="pull-right"><span class="label label-warning">{{ $pendingHotelPackage }}</span></div>
                                @endif
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#travelPackage"><div class="pull-left"><span class="right-nav-text">Travel Package</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
                    <ul id="travelPackage" class="collapse collapse-level-1 two-col-list">
                        <li>
                            <a href="{{ route('travel_package.create') }}">Add New</a>
                        </li>
                        <li>
                            <a href="{{ route('travel_package.index') }}">All <div class="pull-right"><span class="label label-warning">11</span></div></a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#packageRide"><div class="pull-left"><i class="fa fa-cube mr-20"></i><span class="right-nav-text">Package Rides</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
            <ul id="packageRide" class="collapse collapse-level-1 two-col-list">
                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#rideCarPackage"><div class="pull-left"><span class="right-nav-text">Car Package</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
                    <ul id="rideCarPackage" class="collapse collapse-level-1 two-col-list">
                        <li><a href="{{ route('car_package_order.booking') }}">Booking Request</a></li>
                        <li><a href="{{ route('car_package_order.upcoming') }}">Upcoming Trip</a></li>
                        <li><a href="{{ route('car_package_order.ongoing') }}">Ongoing Trip</a></li>
                        <li><a href="{{ route('car_package_order.complete') }}">Complete Trip</a></li>
                        <li><a href="{{ route('car_package_order.cancel') }}">Cancelled Trip</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#rideHotelPackage"><div class="pull-left"><span class="right-nav-text">Hotel Package</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
                    <ul id="rideHotelPackage" class="collapse collapse-level-1 two-col-list">
                        <li><a href="{{ route('hotel_package_order.booking') }}">Booking Request</a></li>
                        <li><a href="{{ route('hotel_package_order.upcoming') }}">Upcoming Trip</a></li>                        
                        <li><a href="{{ route('hotel_package_order.complete') }}">Complete Trip</a></li>
                        <li><a href="{{ route('hotel_package_order.cancel') }}">Cancelled Trip</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#carRent"><div class="pull-left"><i class="fa fa-car mr-20"></i><span class="right-nav-text">Car Rent</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
            <ul id="carRent" class="collapse collapse-level-1 two-col-list">
                <li><a href="{{ route('ride.bid_expired_ride') }}">Expired Request</a></li>
                <li><a href="{{ route('ride.bid_request') }}">Bid Request</a></li>
                <li><a href="{{ route('ride.upcoming') }}">Upcoming Ride</a></li>
                <li><a href="{{ route('ride.complete') }}">Completed Trip</a></li>
                <li><a href="{{ route('ride.cancel') }}">Cancelled Trip</a></li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#hotelInfo"><div class="pull-left"><i class="fa fa-hotel mr-20"></i><span class="right-nav-text">Hotel Info</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
            <ul id="hotelInfo" class="collapse collapse-level-1 two-col-list">
                <li>
                    <a href="{{ route('property_type.index') }}">Property Type</a>
                </li>
                <li>
                    <a href="{{ route('hotel_amenity.index') }}">Hotel Amenity</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#notice"><div class="pull-left"><i class="fa fa-exclamation-triangle mr-20"></i><span class="right-nav-text">Notice</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
            <ul id="notice" class="collapse collapse-level-1 two-col-list">
                <li>
                    <a href="{{ route('notice.packages', ['type' => 0]) }}">Home Page</a>
                </li>
                <li>
                    <a href="{{ route('notice.packages', ['type' => 1]) }}">Car Package</a>
                </li>
                <li>
                    <a href="{{ route('notice.packages', ['type' => 2]) }}">Hotel Package</a>
                </li>
                <li>
                    <a href="{{ route('notice.packages', ['type' => 3]) }}">Travel Package</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#banner"><div class="pull-left"><i class="fa fa-image mr-20"></i><span class="right-nav-text">Banner</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
            <ul id="banner" class="collapse collapse-level-1 two-col-list">
                <li>
                    <a href="{{ route('user_banner.index') }}">User</a>
                </li>
                <li>
                    <a href="{{ route('partner_banner.index') }}">Partner</a>
                </li>
                <li>
                    <a href="{{ route('banner.packages', ['type' => 1]) }}">Car Package</a>
                </li>
                <li>
                    <a href="{{ route('banner.packages', ['type' => 2]) }}">Hotel Package</a>
                </li>
                <li>
                    <a href="{{ route('banner.packages', ['type' => 3]) }}">Travel Package</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#privacy"><div class="pull-left"><i class="fa fa-car mr-20"></i><span class="right-nav-text">Privacy</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
            <ul id="privacy" class="collapse collapse-level-1 two-col-list">
                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#userPrivacy"><div class="pull-left"><span class="right-nav-text">User</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
                    <ul id="userPrivacy" class="collapse collapse-level-1 two-col-list">
                        <li><a href="{{ route('privacy.user.edit',['for'=>1, 'type'=>1]) }}">About Us</a></li>
                        <li><a href="{{ route('privacy.user.edit',['for'=>1, 'type'=>2]) }}">Terms of Services</a></li>
                        <li><a href="{{ route('privacy.user.edit',['for'=>1, 'type'=>3]) }}">Privacy Policy</a></li>
                        <li><a href="{{ route('privacy.user.edit',['for'=>1, 'type'=>4]) }}">Booking Policy</a></li>
                        <li><a href="{{ route('privacy.user.edit',['for'=>1, 'type'=>5]) }}">Cancellation Policy</a></li>
                        <li><a href="{{ route('privacy.user.edit',['for'=>1, 'type'=>6]) }}">Payment Policy</a></li>
                        <li><a href="{{ route('privacy.user.edit',['for'=>1, 'type'=>7]) }}">Refund Policy</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#partnerPrivacy"><div class="pull-left"><span class="right-nav-text">Partner</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
                    <ul id="partnerPrivacy" class="collapse collapse-level-1 two-col-list">
                        <li><a href="{{ route('privacy.partner.edit',['for'=>0, 'type'=>1]) }}">About Us</a></li>
                        <li><a href="{{ route('privacy.partner.edit',['for'=>0, 'type'=>2]) }}">Terms of Services</a></li>
                        <li><a href="{{ route('privacy.partner.edit',['for'=>0, 'type'=>3]) }}">Privacy Policy</a></li>
                        <li><a href="{{ route('privacy.partner.edit',['for'=>0, 'type'=>4]) }}">Booking Policy</a></li>
                        <li><a href="{{ route('privacy.partner.edit',['for'=>0, 'type'=>5]) }}">Cancellation Policy</a></li>
                        <li><a href="{{ route('privacy.partner.edit',['for'=>0, 'type'=>6]) }}">Payment Policy</a></li>
                        <li><a href="{{ route('privacy.partner.edit',['for'=>0, 'type'=>7]) }}">Cashback Policy</a></li>
                        <li><a href="{{ route('privacy.partner.edit',['for'=>0, 'type'=>8]) }}">Return Policy</a></li>
                        <li><a href="{{ route('privacy.partner.edit',['for'=>0, 'type'=>9]) }}">Tips and Trick</a></li>
                    </ul>
                </li>                
            </ul>
        </li>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#policy"><div class="pull-left"><i class="fa fa-car mr-20"></i><span class="right-nav-text">Cancellation Reason</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
            <ul id="policy" class="collapse collapse-level-1 two-col-list">
                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#userCancellation"><div class="pull-left"><span class="right-nav-text">User Cancellation</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
                    <ul id="userCancellation" class="collapse collapse-level-1 two-col-list">
                        <li><a href="{{ route('reason.index',['app_type'=>1, 'type'=>0]) }}">Ride</a></li>
                        <li><a href="{{ route('reason.index',['app_type'=>1, 'type'=>1]) }}">Car Package</a></li>
                        <li><a href="{{ route('reason.index',['app_type'=>1, 'type'=>2]) }}">Hotel Package</a></li>
                        <li><a href="{{ route('reason.index',['app_type'=>1, 'type'=>3]) }}">Travel Package</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#partnerCancellation"><div class="pull-left"><span class="right-nav-text">Partner Cancellation</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
                    <ul id="partnerCancellation" class="collapse collapse-level-1 two-col-list">
                        <li><a href="{{ route('reason.index',['app_type'=>2, 'type'=>0]) }}">Ride</a></li>
                        <li><a href="{{ route('reason.index',['app_type'=>2, 'type'=>1]) }}">Car Package</a></li>
                        <li><a href="{{ route('reason.index',['app_type'=>2, 'type'=>2]) }}">Hotel Package</a></li>
                        <li><a href="{{ route('reason.index',['app_type'=>2, 'type'=>3]) }}">Travel Package</a></li>
                    </ul>
                </li>
            </ul>
        </li> 
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#withdraw"><div class="pull-left"><i class="fa fa-exclamation-triangle mr-20"></i><span class="right-nav-text">Withdraw</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
            <ul id="withdraw" class="collapse collapse-level-1 two-col-list">
                <li>
                    <a href="{{ route('withdraw.pending') }}">Pending</a>
                </li>
                <li>
                    <a href="{{ route('withdraw.complete') }}">Complete</a>
                </li>
                <li>
                    <a href="{{ route('withdraw.cancel') }}">Cancel</a>
                </li>
            </ul>
        </li>       
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#accounts"><div class="pull-left"><i class="fa fa-usd mr-20"></i><span class="right-nav-text">Accounts</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
            <ul id="accounts" class="collapse collapse-level-1 two-col-list">  
                <li>
                    <a href="{{ route('accounts.income') }}">Income</a>
                </li>
                <li>
                    <a href="{{ route('accounts.refund') }}">Refund</a>
                </li>
                <li>
                    <a href="#">Expense</a>
                </li>
                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#balance"><div class="pull-left"><span class="right-nav-text">Balance</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
                    <ul id="balance" class="collapse collapse-level-1 two-col-list">
                        <li>
                            <a href="{{ route('accounts.user-balance') }}">User</a>
                        </li>
                        <li>
                            <a href="{{ route('accounts.partner-balance') }}">Partner</a>
                        </li>
                        <li>
                            <a href="{{ route('accounts.withdraw') }}">Withdraw</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#report"><div class="pull-left"><span class="right-nav-text">Report</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
                    <ul id="report" class="collapse collapse-level-1 two-col-list">
                        <li>
                            <a href="#">Summary</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</div>