<?php
    $pendingDriver = \App\Models\Driver::where('c_status', 0)->count('id');
?>

<div class="fixed-sidebar-left">
    <ul class="nav navbar-nav side-nav nicescroll-bar">
        <li class="navigation-header">
            <span>Main</span> 
            <i class="zmdi zmdi-more"></i>
        </li>
        <li>
            <a class="active" href="javascript:void(0);" data-toggle="collapse" data-target="#dashboard_dr"><div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Dashboard</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
            <ul id="dashboard_dr" class="collapse collapse-level-1">
                <li>
                    <a href="profile.html">profile</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#ecom_dr"><div class="pull-left"><i class="zmdi zmdi-shopping-basket mr-20"></i><span class="right-nav-text">E-Commerce</span></div><div class="pull-right"><span class="label label-primary">hot</span></div><div class="clearfix"></div></a>
            <ul id="ecom_dr" class="collapse collapse-level-1">
                <li>
                    <a href="e-commerce.html">Dashboard</a>
                </li>
                <li>
                    <a href="product.html">Products</a>
                </li>
                <li>
                    <a href="product-detail.html">Product Detail</a>
                </li>
                <li>
                    <a href="add-products.html">Add Product</a>
                </li>
                <li>
                    <a href="product-orders.html">Orders</a>
                </li>
                <li>
                    <a href="product-cart.html">Cart</a>
                </li>
                <li>
                    <a href="product-checkout.html">Checkout</a>
                </li>
            </ul>
        </li>
        <li><hr class="light-grey-hr mb-10"/></li>
        <li class="navigation-header">
            <span>component</span> 
            <i class="zmdi zmdi-more"></i>
        </li>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#setting"><div class="pull-left"><i class="fa fa-cog mr-20"></i><span class="right-nav-text">Settings</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
            <ul id="setting" class="collapse collapse-level-1 two-col-list">
                <li>
                    <a href="{{ route('setting.district.index') }}">District</a>
                </li>
                <li>
                    <a href="{{ route('setting.city.index') }}">City</a>
                </li>
                <li>
                    <a href="{{ route('setting.tour_spot.index') }}">Tour Spot</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{ route('driver.index') }}" data-toggle="collapse" data-target="#driver"><div class="pull-left"><i class="fa fa-user mr-20"></i><span class="right-nav-text">Driver</span></div><div class="pull-right"></div>
                @if($pendingDriver > 0)
                    <div class="pull-right"><span class="label label-warning">{{ $pendingDriver }}</span></div>
                @endif
            <div class="clearfix"></div></a>
        </li>
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#partners"><div class="pull-left"><i class="fa fa-user mr-20"></i><span class="right-nav-text">Partner</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
            <ul id="partners" class="collapse collapse-level-1 two-col-list">
                <li>
                    <a href="{{ route('partner.create') }}">Add New Partner</a>
                </li>
                <li>
                    <a href="{{ route('partner.index') }}">All Partner</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{ route('user.index') }}" data-toggle="collapse" data-target="#driver"><div class="pull-left"><i class="fa fa-user mr-20"></i><span class="right-nav-text">User</span></div><div class="pull-right"></div>
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
                            <a href="{{ route('car.index') }}">All Car</a>
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
                            <a href="{{ route('car_package.index') }}">All</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#hotelPackage"><div class="pull-left"><span class="right-nav-text">Hotel Package</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
                    <ul id="hotelPackage" class="collapse collapse-level-1 two-col-list">
                        <li>
                            <a href="#">Add New</a>
                        </li>
                        <li>
                            <a href="#">All</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#travelPackage"><div class="pull-left"><span class="right-nav-text">Travel Package</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
                    <ul id="travelPackage" class="collapse collapse-level-1 two-col-list">
                        <li>
                            <a href="#">Add New</a>
                        </li>
                        <li>
                            <a href="#">All</a>
                        </li>
                    </ul>
                </li>
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
    </ul>
</div>