@extends('quicarbd.admin.layout.admin')
@section('title','Dashboard')
@section('content')
    <div class="container-fluid pt-25">
        <!-- Row -->
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <div class="panel panel-default card-view">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body sm-data-box-1">
                            <span class="uppercase-font weight-500 font-14 block text-center txt-dark">User</span> 
                            <div class="cus-sat-stat weight-500 txt-primary text-center mt-5">
                                <span class="counter-anim">{{ $total_user }}</span>
                            </div>
                            <div class="progress-anim mt-20">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-primary
                                    wow animated progress-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <ul class="flex-stat mt-5">
                                <li>
                                    <span class="block">Total</span>
                                    <span class="block">
                                        <i class=" txt-dark font-20">{{ $total_user }}</i>
                                    </span>
                                </li>
                                <li>
                                    <span class="block">Active</span>
                                    <span class="block weight-500 txt-dark font-15">{{ $total_user_active }}</span>
                                </li>
                                <li>
                                    <span class="block">Pending</span>
                                    <span class="block weight-500 txt-dark font-15">{{ $total_user_inactive }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <div class="panel panel-default card-view">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body sm-data-box-1">
                            <span class="uppercase-font weight-500 font-14 block text-center txt-dark">Partner</span> 
                            <div class="cus-sat-stat weight-500 txt-primary text-center mt-5">
                                <span class="counter-anim">{{ $total_partner }}</span>
                            </div>
                            <div class="progress-anim mt-20">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-primary
                                    wow animated progress-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <ul class="flex-stat cars mt-5">
                                <li>
                                    <span class="block">Total</span>
                                    <span class="block">
                                        <i class=" txt-dark font-20">{{ $total_partner }}</i>
                                    </span>
                                </li>
                                <li>
                                    <span class="block">Active</span>
                                    <span class="block weight-500 txt-dark font-15">{{ $total_partner_active }}</span>
                                </li>
                                <li>
                                    <span class="block">Pending</span>
                                    <span class="block weight-500 txt-dark font-15">{{ $total_partner_inactive }}</span>
                                </li>
                                <li>
                                    <span class="block">Hold</span>
                                    <span class="block weight-500 txt-dark font-15">{{ $total_partner_hold }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <div class="panel panel-default card-view">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body sm-data-box-1">
                            <span class="uppercase-font weight-500 font-14 block text-center txt-dark">Driver</span> 
                            <div class="cus-sat-stat weight-500 txt-primary text-center mt-5">
                                <span class="counter-anim">{{ $total_driver }}</span>
                            </div>
                            <div class="progress-anim mt-20">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-primary
                                    wow animated progress-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <ul class="flex-stat mt-5">
                                <li>
                                    <span class="block">Total</span>
                                    <span class="block">
                                        <i class=" txt-dark font-20">{{ $total_driver }}</i>
                                    </span>
                                </li>
                                <li>
                                    <span class="block">Active</span>
                                    <span class="block weight-500 txt-dark font-15">{{ $total_driver_active }}</span>
                                </li>
                                <li>
                                    <span class="block">Pending</span>
                                    <span class="block weight-500 txt-dark font-15">{{ $total_driver_inactive }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Row -->

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="panel panel-default card-view">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body sm-data-box-1">
                            <span class="uppercase-font weight-500 font-14 block text-center txt-dark">Cars</span> 
                            <div class="cus-sat-stat weight-500 txt-primary text-center mt-5">
                                <span class="counter-anim">{{ $total_car }}</span>
                            </div>
                            <div class="progress-anim mt-20">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-primary
                                    wow animated progress-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <ul class="flex-stat cars mt-5">
                                <li>
                                    <span class="block">Active</span>
                                    <span class="block">
                                        <i class=" txt-dark font-20">{{ $total_car_active }}</i>
                                    </span>
                                </li>
                                <li>
                                    <span class="block">Pending</span>
                                    <span class="block weight-500 txt-dark font-15">{{ $total_car_pending }}</span>
                                </li>
                                <li>
                                    <span class="block">Expired</span>
                                    <span class="block weight-500 txt-dark font-15">{{ $total_car_expired }}</span>
                                </li>
                                <li>
                                    <span class="block">Unverify</span>
                                    <span class="block weight-500 txt-dark font-15">{{ $total_car_unverify }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="panel panel-default card-view">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body sm-data-box-1">
                            <span class="uppercase-font weight-500 font-14 block text-center txt-dark">Car Package</span> 
                            <div class="cus-sat-stat weight-500 txt-primary text-center mt-5">
                                <span class="counter-anim">{{ $car_package }}</span>
                            </div>
                            <div class="progress-anim mt-20">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-primary
                                    wow animated progress-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <ul class="flex-stat cars mt-5">
                                <li>
                                    <span class="block">Total</span>
                                    <span class="block weight-500 txt-dark font-15">{{ $car_package }}</span>
                                </li>
                                <li>
                                    <span class="block">Active</span>
                                    <span class="block weight-500 txt-dark font-15">{{ $car_package_active }}</span>
                                </li>
                                <li>
                                    <span class="block">Pending</span>
                                    <span class="block weight-500 txt-dark font-15">{{ $car_package_pending }}</span>
                                </li>
                                <li>
                                    <span class="block">Unverify</span>
                                    <span class="block weight-500 txt-dark font-15">{{ $car_package_unverify }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="panel panel-default card-view">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body sm-data-box-1">
                            <span class="uppercase-font weight-500 font-14 block text-center txt-dark">Hotel Package</span> 
                            <div class="cus-sat-stat weight-500 txt-primary text-center mt-5">
                                <span class="counter-anim">{{ $hotel_package }}</span>
                            </div>
                            <div class="progress-anim mt-20">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-primary
                                    wow animated progress-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <ul class="flex-stat cars mt-5">
                                <li>
                                    <span class="block">Total</span>
                                    <span class="block weight-500 txt-dark font-15">{{ $hotel_package }}</span>
                                </li>
                                <li>
                                    <span class="block">Active</span>
                                    <span class="block weight-500 txt-dark font-15">{{ $hotel_package_active }}</span>
                                </li>
                                <li>
                                    <span class="block">Pending</span>
                                    <span class="block weight-500 txt-dark font-15">{{ $hotel_package_pending }}</span>
                                </li>
                                <li>
                                    <span class="block">Unverify</span>
                                    <span class="block weight-500 txt-dark font-15">{{ $hotel_package_unverify }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="panel panel-default card-view">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body sm-data-box-1">
                            <span class="uppercase-font weight-500 font-14 block text-center txt-dark">Travel Package</span> 
                            <div class="cus-sat-stat weight-500 txt-primary text-center mt-5">
                                <span class="counter-anim">{{ $travel_package }}</span>
                            </div>
                            <div class="progress-anim mt-20">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-primary
                                    wow animated progress-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <ul class="flex-stat mt-5">
                                <li>
                                    <span class="block">Total</span>
                                    <span class="block">
                                        <i class=" txt-dark font-20">{{ $travel_package }}</i>
                                    </span>
                                </li>
                                <li>
                                    <span class="block">Active</span>
                                    <span class="block weight-500 txt-dark font-15">{{ $travel_package_active }}</span>
                                </li>
                                <li>
                                    <span class="block">Pending</span>
                                    <span class="block weight-500 txt-dark font-15">{{ $travel_package_pending }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="panel panel-default card-view">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body sm-data-box-1">
                            <span class="uppercase-font weight-500 font-14 block text-center txt-dark">Ride Bid</span> 
                            <div class="cus-sat-stat weight-500 txt-primary text-center mt-5">
                                <span class="counter-anim">{{ $total_bid }}</span>
                            </div>
                            <div class="progress-anim mt-20">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-primary
                                    wow animated progress-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <ul class="flex-stat cars mt-5">
                                <li>
                                    <span class="block">Total Bid</span>
                                    <span class="block">
                                        <i class=" txt-dark font-20">{{ $total_bid }}</i>
                                    </span>
                                </li>
                                <li>
                                    <span class="block">Complete Ride</span>
                                    <span class="block weight-500 txt-dark font-15">{{ $total_complete_ride }}</span>
                                </li>
                                <li>
                                    <span class="block">Cancel Ride</span>
                                    <span class="block weight-500 txt-dark font-15">{{ $total_cancelled_ride }}</span>
                                </li>
                                <li>
                                    <span  class="block">Pending Bid</span>
                                    <span class="block weight-500 txt-dark font-15">{{ $total_pending_ride }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Row -->
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                            <span class="txt-dark block counter"><span class="counter-anim">914,001</span></span>
                                            <span class="weight-500 uppercase-font block font-13">visits</span>
                                        </div>
                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                            <i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
                                        </div>
                                    </div>	
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                            <span class="txt-dark block counter"><span class="counter-anim">46.43</span>%</span>
                                            <span class="weight-500 uppercase-font block">growth rate</span>
                                        </div>
                                        <div class="col-xs-6 text-center  pl-0 pr-0 pt-25  data-wrap-right">
                                            <div class="sp-small-chart" id="sparkline_4" ></div>
                                        </div>
                                    </div>	
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                            <span class="txt-dark block counter"><span class="counter-anim">46.41</span>%</span>
                                            <span class="weight-500 uppercase-font block">bounce rate</span>
                                        </div>
                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                            <i class="icon-control-rewind data-right-rep-icon txt-light-grey"></i>
                                        </div>
                                    </div>	
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                            <span class="txt-dark block counter"><span class="counter-anim">4,054,876</span></span>
                                            <span class="weight-500 uppercase-font block">pageviews</span>
                                        </div>
                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                            <i class="icon-layers data-right-rep-icon txt-light-grey"></i>
                                        </div>
                                    </div>	
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Row -->
        
        <!-- Row -->
        <div class="row">
            <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12">
                <div class="panel panel-default card-view panel-refresh">
                    <div class="refresh-container">
                        <div class="la-anim-1"></div>
                    </div>
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">social campaigns</h6>
                        </div>
                        <div class="pull-right">
                            <a href="#" class="pull-left inline-block refresh mr-15">
                                <i class="zmdi zmdi-replay"></i>
                            </a>
                            <a href="#" class="pull-left inline-block full-screen mr-15">
                                <i class="zmdi zmdi-fullscreen"></i>
                            </a>
                            <div class="pull-left inline-block dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
                                <ul class="dropdown-menu bullet dropdown-menu-right"  role="menu">
                                    <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>Edit</a></li>
                                    <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>Delete</a></li>
                                    <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>New</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body row pa-0">
                            <div class="table-wrap">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>Campaign</th>
                                                <th>Client</th>
                                                <th>Changes</th>
                                                <th>Budget</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><span class="txt-dark weight-500">Facebook</span></td>
                                                <td>Beavis</td>
                                                <td><span class="txt-success"><i class="zmdi zmdi-caret-up mr-10 font-20"></i><span>2.43%</span></span></td>
                                                <td>
                                                    <span class="txt-dark weight-500">$1478</span>
                                                </td>
                                                <td>
                                                    <span class="label label-primary">active</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span class="txt-dark weight-500">Youtube</span></td>
                                                <td>Felix</td>
                                                <td><span class="txt-success"><i class="zmdi zmdi-caret-up mr-10 font-20"></i><span>1.43%</span></span></td>
                                                <td>
                                                    <span class="txt-dark weight-500">$951</span>
                                                </td>
                                                <td>
                                                    <span class="label label-danger">Closed</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span class="txt-dark weight-500">Twitter</span></td>
                                                <td>Cannibus</td>
                                                <td><span class="txt-danger"><i class="zmdi zmdi-caret-down mr-10 font-20"></i><span>-8.43%</span></span></td>
                                                <td>
                                                    <span class="txt-dark weight-500">$632</span>
                                                </td>
                                                <td>
                                                    <span class="label label-default">Hold</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span class="txt-dark weight-500">Spotify</span></td>
                                                <td>Neosoft</td>
                                                <td><span class="txt-success"><i class="zmdi zmdi-caret-up mr-10 font-20"></i><span>7.43%</span></span></td>
                                                <td>
                                                    <span class="txt-dark weight-500">$325</span>
                                                </td>
                                                <td>
                                                    <span class="label label-default">Hold</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><span class="txt-dark weight-500">Instagram</span></td>
                                                <td>Hencework</td>
                                                <td><span class="txt-success"><i class="zmdi zmdi-caret-up mr-10 font-20"></i><span>9.43%</span></span></td>
                                                <td>
                                                    <span class="txt-dark weight-500">$258</span>
                                                </td>
                                                <td>
                                                    <span class="label label-primary">Active</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>	
                        </div>	
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
                <div class="panel panel-default card-view panel-refresh">
                    <div class="refresh-container">
                        <div class="la-anim-1"></div>
                    </div>
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Advertising & Promotions</h6>
                        </div>
                        <div class="pull-right">
                            <a href="#" class="pull-left inline-block refresh mr-15">
                                <i class="zmdi zmdi-replay"></i>
                            </a>
                            <div class="pull-left inline-block dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
                                <ul class="dropdown-menu bullet dropdown-menu-right"  role="menu">
                                    <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>option 1</a></li>
                                    <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>option 2</a></li>
                                    <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>option 3</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div id="e_chart_3" class="" style="height:236px;"></div>
                            <div class="label-chatrs text-center mt-30">
                                <div class="inline-block mr-15">
                                    <span class="clabels inline-block bg-blue mr-5"></span>
                                    <span class="clabels-text font-12 inline-block txt-dark capitalize-font">Active</span>
                                </div>
                                <div class="inline-block">
                                    <span class="clabels inline-block bg-light-blue mr-5"></span>
                                    <span class="clabels-text font-12 inline-block txt-dark capitalize-font">Hold</span>
                                </div>											
                            </div>
                        </div>
                    </div>	
                </div>	
            </div>	
        </div>	
        <!-- Row -->
    </div>
@endsection
@section('scripts')
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
