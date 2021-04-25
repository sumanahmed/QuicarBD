@extends('quicarbd.admin.layout.admin')
@section('title','Summary')
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
            <li><a href="#">Accounts</a></li>
            <li class="active"><span>Summary</span></li>
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
                        <h6 class="panel-title txt-dark">Account Summary</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="panel panel-default card-view">
                                    <div class="panel-wrapper collapse in">
                                        <div class="panel-body sm-data-box-1">
                                            <span class="uppercase-font weight-500 font-14 block text-center txt-dark">User Balance</span> 
                                            <div class="cus-sat-stat weight-500 txt-primary text-center mt-5">
                                                <span class="counter-anim">{{ $user_balance }}</span>
                                            </div>
                                            <div class="progress-anim mt-20">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-primary
                                                    wow animated progress-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="panel panel-default card-view">
                                    <div class="panel-wrapper collapse in">
                                        <div class="panel-body sm-data-box-1">
                                            <span class="uppercase-font weight-500 font-14 block text-center txt-dark">Cashback Balance</span> 
                                            <div class="cus-sat-stat weight-500 txt-primary text-center mt-5">
                                                <span class="counter-anim">{{ $user_cashback }}</span>
                                            </div>
                                            <div class="progress-anim mt-20">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-primary
                                                    wow animated progress-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="panel panel-default card-view">
                                    <div class="panel-wrapper collapse in">
                                        <div class="panel-body sm-data-box-1">
                                            <span class="uppercase-font weight-500 font-14 block text-center txt-dark">Partner Balance</span> 
                                            <div class="cus-sat-stat weight-500 txt-primary text-center mt-5">
                                                <span class="counter-anim">{{ $partner_balance }}</span>
                                            </div>
                                            <div class="progress-anim mt-20">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-primary
                                                    wow animated progress-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                                <div class="panel panel-default card-view">
                                    <div class="panel-wrapper collapse in">
                                        <div class="panel-body sm-data-box-1">
                                            <span class="uppercase-font weight-500 font-14 block text-center txt-dark">Quicar Income</span> 
                                            <div class="cus-sat-stat weight-500 txt-primary text-center mt-5">
                                                <span class="counter-anim">{{ $quicar_income }}</span>
                                            </div>
                                            <div class="progress-anim mt-20">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-primary
                                                    wow animated progress-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
