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
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#setting"><div class="pull-left"><i class="zmdi zmdi-edit mr-20"></i><span class="right-nav-text">Settings</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
            <ul id="setting" class="collapse collapse-level-1 two-col-list">
                <li>
                    <a href="{{ route('setting.district.index') }}">District</a>
                </li>
                <li>
                    <a href="{{ route('setting.city.index') }}">City</a>
                </li>
            </ul>
        </li>
    </ul>
</div>