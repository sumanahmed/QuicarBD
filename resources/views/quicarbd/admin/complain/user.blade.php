@extends('quicarbd.admin.layout.admin')
@section('title','User')
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
            <li><a href="#">Complain</a></li>
            <li class="active"><span>User</span></li>
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
                        <h6 class="panel-title txt-dark">User Complain</h6>
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
                                    <div class="form-group">
                                        <label for="phone" class="control-label mb-10">Status</label>  
                                        <select name="status" id="status" class="form-control">
                                            <option value="100">All</option>
                                            <option value="0" @if(isset($_GET['status']) && $_GET['status'] == 0) selected @endif>Unread</option>
                                            <option value="1" @if(isset($_GET['status']) && $_GET['status'] == 1) selected @endif>Read</option>
                                        </select>
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
                                            <th>User</th>
                                            <th>Complain Type</th>
                                            <th>Answer Give</th>
                                            <th>Complain Date & Time</th>
                                            <th>Answer Date & Time</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>User</th>
                                            <th>Complain Type</th>
                                            <th>Answer Give</th>
                                            <th>Complain Date & Time</th>
                                            <th>Answer Date & Time</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="partnerData">
                                        @foreach($complains as $complain)
                                            @php 
                                                $db_time        = DateTime::createFromFormat('Y-m-d H:i:s', $complain->created_at, new DateTimeZone("UTC"));
                                                $complainTime   = $db_time->format('j M, Y h:i A');
                                                if($complain->answer_time != null) {
                                                    $reply_time     = DateTime::createFromFormat('Y-m-d H:i:s', $complain->answer_time, new DateTimeZone("UTC"));
                                                    $answerTime     = $reply_time->format('j M, Y h:i A');
                                                }
                                            @endphp
                                            <tr class="complain-{{ $complain->id }}">
                                                <td>{{ $complain->name }}<br/>{{ $complain->phone }}</td>
                                                <td>{{ getComplainType($complain->report_type) }}</td>
                                                <td>{{ $complain->answer_give == 0 ? 'No' : 'Yes' }}</td>
                                                <td>{{ $complainTime }}</td>
                                                <td>{{ $complain->answer_time != null ? $answerTime : '' }}</td>
                                                <td style="vertical-align: middle;text-align: center;">
                                                    <a href="#" class="btn btn-xs btn-warning" data-toggle="modal" id="replyComplain" data-id="{{ $complain->id }}" data-complain="{{ $complain->message }}" data-reply_message="{{ $complain->reply_message }}" data-sender_id="{{ $complain->sender_id }}" data-type="1" title="Reply"><i class="fa fa-reply"></i></a>
                                                    <button href="#" class="btn btn-xs btn-danger" data-toggle="modal" id="deleteFeedback" data-target="#deleteFeedbackModal" data-id="{{ $complain->id }}" title="Delete"><i class="fa fa-remove"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $complains->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>	
        </div>
    </div>
    
    <!-- Notification Modal -->
    <div id="replyComplainModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title" id="exampleModalLabel1">Reply Complain</h5>
                </div>
                <div class="modal-body">
                    <form>
                        
                        <input type="hidden" id="id" />
                        <input type="hidden" id="sender_id" />
                        <input type="hidden" id="type" />
                        <div class="form-group">
                            <label for="complain" class="control-label mb-10">Complain <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <textarea class="form-control complain" name="complain" id="complain" placeholder="Enter your reply" readonly></textarea>
                            <span class="errorReply text-danger text-bold"></span>
                        </div>
                        <div class="form-group">
                            <label for="reply_message" class="control-label mb-10">Reply <span class="text-danger text-bold" title="Required Field">*</span></label>
                            <textarea class="form-control reply_message" name="reply_message" id="reply_message" placeholder="Enter your reply"></textarea>
                            <span class="errorReply text-danger text-bold"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="sendComplainReply">Send</button>
                </div>
            </div>
        </div>
    </div>
</div>
@php 
    function getComplainType ($complain_type) {
        if ($complain_type == 1) {
            echo "Ride";
        } elseif ($complain_type == 2) {
            echo "Car Package";
        } elseif ($complain_type == 3) {
            echo "Hotel Package";
        } elseif ($complain_type == 4) {
            echo "Travel Package";
        } elseif ($complain_type == 5) {
            echo "Others";
        }
    }
@endphp
@endsection
@section('scripts')
	<script src="{{ asset('quicarbd/admin/js/complain.js') }}"></script>
@endsection
