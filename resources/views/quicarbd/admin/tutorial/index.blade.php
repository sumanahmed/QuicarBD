@extends('quicarbd.admin.layout.admin')
@section('title','Tutorial')
@section('content')
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <a href="{{ route('tutorial.create',['type' => $type]) }}" class="btn btn-success btn-anim">
             <i class="icon-plus"></i><span class="btn-text">Add New</span>
            </a>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Dashboard</a></li>
                <li class="active"><span>Tutorial</span></li>
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
                        <h6 class="panel-title txt-dark">{{ $type == 0 ? 'User' : 'Partner' }} Tutorial List</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-header" style="border-bottom: 2px solid #ddd;margin-top:10px;">
                        <form action="{{ route('tutorial.index') }}" method="get">
                            <input type="hidden" name="type" value="{{ $type }}" />
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Title</label>                                            
                                        <input type="text" name="title" @if(isset($_GET['title'])) value="{{ $_GET['title'] }}" @endif placeholder="Enter Title.." class="form-control" />
                                    </div>
                                </div>  
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Video ID</label>                                            
                                        <input type="text" name="video_id" @if(isset($_GET['video_id'])) value="{{ $_GET['video_id'] }}" @endif placeholder="Video ID" class="form-control" />
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
                                            <th>Title</th>
                                            <th>Video ID</th>
                                            <th>Status</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Title</th>
                                            <th>Video ID</th>
                                            <th>Status</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="partnerData">
                                        @if(isset($tutorials) && count($tutorials) > 0)
                                            @foreach($tutorials as $tutorial)
                                                <tr class="tutorial-{{ $tutorial->id }}">
                                                    <td>{{ $tutorial->title }}</td>
                                                    <td>{{ $tutorial->video_id }}</td>
                                                    <td>{{ $tutorial->status == 0 ? 'Hide' : 'Show' }}</td>
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <a href="{{ route('tutorial.edit', $tutorial->id) }}" class="btn btn-xs btn-info" title="Edit"><i class="fa fa-pencil"></i></a>
                                                        <a href="#" id="tutorialDelete" data-toggle="modal" data-id="{{ $tutorial->id }}" class="btn btn-xs btn-danger" title="Delete"><i class="fa fa-remove"></i></a>  
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
                                {{ $tutorials->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>	
        </div>
    </div>
</div>
<div class="modal fade" id="tutorialDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 class="modal-title mb-10" id="exampleModalLabel">Are you sure to delete ?</h5>
                <input type="hidden" name="del_id"/>
                <button type="button" class="btn btn-xs btn-danger btn-raised mr-2" id="destroyTutorial"><i class="fas fa-trash-alt"></i> Proceed</button>
                <button type="button" class="btn btn-xs btn-warning btn-raised" data-dismiss="modal" aria-label="Close"><i class="fas fa-backspace"></i> Cancel</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        //open delete tutorial modal
        $(document).on('click', '#tutorialDelete', function () {
            $('#tutorialDeleteModal').modal('show');
            $('input[name=del_id]').val($(this).data('id'));
         });
        
        //destroy tutorial
        $("#destroyTutorial").click(function(){
            $.ajax({
                type: 'POST',
                url: '/tutorial/destroy',
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                data: {
                    id: $('input[name=del_id]').val()
                },
                success: function (response) {
                    if (response.status != 403) {
                        $('#tutorialDeleteModal').modal('hide');
                        $('.tutorial-' + $('input[name=del_id]').val()).remove();
                        toastr.success('Tutorial Deleted')
                    } else {
                        toastr.error(response.message)
                    }                    
                }
            });
        });
    </script>
@endsection
