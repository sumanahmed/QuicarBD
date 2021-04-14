@extends('quicarbd.admin.layout.admin')
@section('title','Partner')
@section('content')
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <a href="{{ route('partner.create') }}" class="btn btn-success btn-anim"><i class="icon-plus"></i><span class="btn-text">Add New</span></a>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Message</a></li>
            <li class="active"><span>Partner</span></li>
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
                        <h6 class="panel-title txt-dark">Partner Messages</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-header" style="border-bottom: 2px solid #ddd;margin-top:10px;">
                        <form action="{{ route('message.partner') }}" method="get">
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
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Message</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Message</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="partnerData">
                                        @foreach($partners as $partner)
                                            <tr class="partner-{{ $partner->id }}">
                                                <td>{{ $partner->name }}</td>
                                                <td>{{ $partner->phone }}</td>
                                                <td>{{ $partner->message }}</td>
                                                <td style="vertical-align: middle;text-align: center;">
                                                    <a href="#" class="btn btn-xs btn-warning" data-toggle="modal" id="replyMessage" data-target="#replyMessageModal" data-id="{{ $partner->id }}" data-message="{{ $partner->message }}" data-reply_message="{{ $partner->reply_message }}" title="Reply"><i class="fa fa-reply"></i></a>
                                                    <a href="{{ route('partner.details', $partner->id) }}" target="_blank" class="btn btn-xs btn-info" title="Partner Details"><i class="fa fa-eye"></i></a>
                                                    <button href="#" class="btn btn-xs btn-danger" data-toggle="modal" id="deleteFeedback" data-target="#deleteFeedbackModal" data-id="{{ $partner->id }}" title="Delete"><i class="fa fa-remove"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
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
                            <label for="title" class="control-label mb-10">Title <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <input type="text" name="title" id="title" class="form-control"placeholder="Enter Title" required>
                            <input type="hidden" name="n_key" id="n_key" />
                            <input type="hidden" name="owner_id" id="owner_id" />
                            <input type="hidden" name="phone" id="phone" />
                            <span class="errorTitle text-danger text-bold"></span>
                        </div>
                        <div class="form-group">
                            <label for="message" class="control-label mb-10">Message <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <textarea class="form-control" name="message"  id="message" placeholder="Enter your message"></textarea>
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
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="ownerNotificationSend">Send</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
	<script src="{{ asset('quicarbd/admin/js/message.js') }}"></script>
    <script>
        $("#dashboard").addClass('active');
    </script>
@endsection
