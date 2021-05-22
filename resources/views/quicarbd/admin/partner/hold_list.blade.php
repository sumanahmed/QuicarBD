@extends('quicarbd.admin.layout.admin')
@section('title','Hold Partner')
@section('content')
@php 
    $helper = new App\Http\Lib\Helper;
@endphp
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Partner</a></li>
            <li class="active"><span>All Hold Partner</span></li>
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
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-header" style="border-bottom: 2px solid #ddd;margin-top:10px;">
                        <form action="{{ route('partner.hold_list') }}" method="get">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="name" class="control-label mb-10">Name</label>                                            
                                        <input type="text" name="name" @if(isset($_GET['name'])) value="{{ $_GET['name'] }}" @endif placeholder="Name" class="form-control">
                                    </div>
                                </div> 
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="phone" class="control-label mb-10">Phone</label>                                            
                                        <input type="text" name="phone" @if(isset($_GET['phone'])) value="{{ $_GET['phone'] }}" @endif placeholder="Phone" class="form-control">
                                    </div>
                                </div> 
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="nid" class="control-label mb-10">NID</label>                                            
                                        <input type="text" name="nid" @if(isset($_GET['nid'])) value="{{ $_GET['nid'] }}" @endif placeholder="NID" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group" style="margin-top:30px;">
                                        <button type="submit" class="btn btn-primary btn-sm">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="panel-body">
                        <div class="table-wrap">
                            <div class="table-responsive">
                                <table class="table table-hover display pb-30" >
                                    <thead>
                                        <tr>
                                            <th>Name & Phone</th>
                                            <th>Balance</th>
                                            <th>Percentage</th>
                                            <th>Account Type</th>
                                            <th>Service Location</th>
                                            <th>Date & Time</th>
                                            <th>Hold Reason</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name & Phone</th>
                                            <th>Balance</th>
                                            <th>Percentage</th>
                                            <th>Account Type</th>
                                            <th>Service Location</th>
                                            <th>Date & Time</th>
                                            <th>Hold Reason</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="partnerData">
                                        @if(isset($partners) && count($partners) > 0)
                                            @foreach($partners as $partner)
                                                @php 
                                                    $db_time = DateTime::createFromFormat('Y-m-d H:i:s', $partner->created_at, new DateTimeZone("UTC"));
                                                    $dateTime = $db_time->setTimeZone(new DateTimeZone("Asia/Dhaka"))->format('j M, Y h:i A');
                                                @endphp
                                                <tr class="partner-{{ $partner->id }}">
                                                    <td>{{ $partner->name }}<br/>{{ $partner->phone }}</td>
                                                    <td>{{ $partner->current_balance }}</td>
                                                    <td>{{ "BP-".$partner->bidding_percent.", CP-".$partner->car_package_charge.", HP-".$partner->hotel_package_charge.", TP-".$partner->travel_package_charge }}</td>
                                                    <td>{{ ownerAccountType($partner->account_type) }}</td>
                                                    <td>{{ $partner->service_location_district != null ? $helper->getDistrict($partner->service_location_district) : '' }}</td>    
                                                    <td>{{ $dateTime }}</td>
                                                    <td>{{ $partner->block_reason }}</td>
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <a href="{{ route('partner.unhold', $partner->id) }}" class="btn btn-xs btn-success" title="Approve"><i class="fa fa-check"></i></a>
                                                        <a href="#" class="btn btn-xs btn-primary" id="sendNotification" data-toggle="modal" data-target="#sendNotificationModal" title="Notification" data-id="{{ $partner->id }}" data-phone="{{ $partner->phone }}" data-n_key="{{ $partner->n_key }}"><i class="fa fa-bell"></i></a>
                                                        <a href="{{ route('partner.details', $partner->id) }}" target="_blank" class="btn btn-xs btn-info" title="Details"><i class="fa fa-eye"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center">No Data Found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                {{ $partners->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>	
        </div>
    </div>
    
    <!-- Notification Modal -->
    <div id="sendNotificationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="exampleModalLabel1">Send Notification</h5>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="sms" class="control-label mb-10">Select Message </label>
                            <select class="form-control" name="sms" id="sms">
                                <option value="0">Select</option>
                                @foreach($sms as $tmp)
                                    <option value="{{ $tmp->id }}">{{ $tmp->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title" class="control-label mb-10">Title <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <input type="text" name="title" id="title" class="form-control"placeholder="Enter Title" required>
                            <input type="hidden" name="n_key" id="n_key" />
                            <input type="hidden" name="owner_id" id="owner_id" />
                            <input type="hidden" name="phone" id="phone" />
                            <span class="errorTitle text-danger text-bold"></span>
                        </div>
                        <div class="form-group">
                            <label for="message" class="control-label mb-10">Message <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <textarea class="form-control sms_message" name="message"  id="message" placeholder="Enter your message"></textarea>
                            <span class="errorMessage text-danger text-bold"></span>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">                                
                                <input type="radio" name="notification" id="notification" value="1" checked>
                                <label class="col-form-label" for="notification">Notification</label>
                            </div>
                            <div class="form-group col-md-4">
                                <input type="radio" name="notification" id="sms_notification" value="2">
                                <label class="col-form-label" for="sms_notification">SMS & Notification </label>                                
                            </div>
                            <span class="errorMessage text-danger text-bold"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-xs btn-danger" id="smsDelete">Delete</button>
                    <button type="button" class="btn btn-xs btn-success" id="smsDraftSave">Save as Draft</button>
                    <button type="button" class="btn btn-xs btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-xs btn-primary" id="ownerNotificationSend">Send</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Balance ADD Modal -->
    <div id="partnerBalanceAddModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="exampleModalLabel1">Add Balance</h5>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="title" class="control-label mb-10">Current Balance </label>
                            <input type="text" name="balance" id="balance" class="form-control" readonly>
                            <input type="hidden" name="n_key" id="n_key" />
                            <input type="hidden" name="id" id="id" />
                            <span class="errorTitle text-danger text-bold"></span>
                        </div>
                        <div class="form-group">
                            <label for="title" class="control-label mb-10">Add Balance <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <input type="text" name="add_balance" id="add_balance" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            <span class="errorAddBalance text-danger text-bold"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="addBalance">Send</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Balance ADD Modal -->
    <div id="partnerHoldModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="exampleModalLabel1">Partner Hold</h5>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="title" class="control-label mb-10">Hold Reason <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <input type="hidden" name="id" id="id" />
                            <input type="hidden" name="phone" id="phone" />
                            <input type="hidden" name="n_key" id="n_key" />
                            <input type="text" name="block_reason" id="block_reason" class="form-control">
                            <span class="errorReason text-danger text-bold"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="sendReason">Send</button>
                </div>
            </div>
        </div>
    </div>
</div>
@php 
    function ownerAccountType ($type) {
        if ($type == 0) {
            echo "Car";
        } elseif ($type == 1) {
            echo "Hotel";
        } elseif ($type == 2) {
            echo "Travel";
        } elseif ($type == 3) {
            echo "Car & Hotel";
        } elseif ($type == 4) {
            echo "Car, Hotel & Travel";
        } elseif ($type == 5) {
            echo "Hotel & Travel";
        } elseif ($type == 6) {
            echo "Car & Travel";
        }
    }
@endphp
@endsection
@section('scripts')
	<script src="{{ asset('quicarbd/admin/js/partner.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
