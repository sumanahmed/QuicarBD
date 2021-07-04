@extends('quicarbd.admin.layout.admin')
@section('title','Bonus')
@section('content')
<div class="container-fluid">				
	<!-- Title -->
    <div class="row heading-bg">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <a href="{{ route('bonus.create',['type' => $type]) }}" class="btn btn-success btn-anim">
             <i class="icon-plus"></i><span class="btn-text">Add New</span>
            </a>
        </div>
        <!-- Breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Dashboard</a></li>
                <li class="active"><span>Bonus</span></li>
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
                        <h6 class="panel-title txt-dark">{{ $type == 0 ? 'User' : 'Partner' }} Bonus List</h6>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-header" style="border-bottom: 2px solid #ddd;margin-top:10px;">
                        <form action="{{ route('bonus.index') }}" method="get">
                            <input type="hidden" name="type" value="{{ $type }}" />
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Complete Ride</label>                                            
                                        <input type="number" name="completed_ride" @if(isset($_GET['completed_ride'])) value="{{ $_GET['completed_ride'] }}" @endif placeholder="Complete Ride" class="form-control" />
                                    </div>
                                </div>  
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Bonus Amount</label>                                            
                                        <input type="number" name="bonus_amount" @if(isset($_GET['bonus_amount'])) value="{{ $_GET['bonus_amount'] }}" @endif placeholder="Bonus Amount" class="form-control" />
                                    </div>
                                </div>  
                                <!--<div class="col-md-2">-->
                                <!--    <div class="form-group">-->
                                <!--        <label class="control-label mb-10">Travel Date</label>                                            -->
                                <!--        <input type="date" name="travel_date" @if(isset($_GET['travel_date'])) value="{{ $_GET['travel_date'] }}" @endif  class="form-control" />-->
                                <!--    </div>-->
                                <!--</div>            -->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label mb-10">Bonus For</label>                                            
                                        <select name="bonus_for" id="bonus_for" class="form-control">
                                            <option value="0">Select</option>
                                            <option value="1">Ride</option>
                                            <option value="2">Car Package</option>
                                            <option value="3">Hotel Package</option>
                                            <option value="4">Travel Package</option>
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
                                            <th>Complete Ride</th>
                                            <th>Bonus Amount</th>
                                            <th>Starting Date & Time</th>
                                            <th>Ending Date & Time</th>
                                            <th>Bonus For</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Complete Ride</th>
                                            <th>Bonus Amount</th>
                                            <th>Starting Date & Time</th>
                                            <th>Ending Date & Time</th>
                                            <th>Bonus For</th>
                                            <th style="vertical-align: middle;text-align: center;">Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="partnerData">
                                        @if(isset($bonuses) && count($bonuses) > 0)
                                            @foreach($bonuses as $bonus)
                                                <tr class="bonus-{{ $bonus->id }}">
                                                    <td>{{ $bonus->completed_ride }}</td>
                                                    <td>{{ $bonus->bonus_amount }}</td>
                                                    <td>{{ date('Y-m-d H:i:s a', strtotime($bonus->offer_starting_time)) }}</td>                                                  
                                                    <td>{{ date('Y-m-d H:i:s a', strtotime($bonus->offer_finishing_time)) }}</td>
                                                    <td>{{ bonusFor($bonus->bonus_for) }}</td>
                                                    <td style="vertical-align: middle;text-align: center;">
                                                        <a href="{{ route('bonus.edit', $bonus->id) }}" class="btn btn-xs btn-info" title="Edit"><i class="fa fa-pencil"></i></a>
                                                        <a href="#" id="bonusDelete" data-toggle="modal" data-id="{{ $bonus->id }}" class="btn btn-xs btn-danger" title="Delete"><i class="fa fa-remove"></i></a>
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
                                {{ $bonuses->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>	
        </div>
    </div>
</div>
<div class="modal fade" id="bonusDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 class="modal-title mb-10" id="exampleModalLabel">Are you sure to delete ?</h5>
                <input type="hidden" name="del_id"/>
                <button type="button" class="btn btn-xs btn-danger btn-raised mr-2" id="destroyBonus"><i class="fas fa-trash-alt"></i> Proceed</button>
                <button type="button" class="btn btn-xs btn-warning btn-raised" data-dismiss="modal" aria-label="Close"><i class="fas fa-backspace"></i> Cancel</button>
            </div>
        </div>
    </div>
</div>
<?php
    function bonusFor ($bonus_for) {
        if ($bonus_for == 1) {
            echo "Ride";
        } else if ($bonus_for == 2) {
            echo "Car Package";
        } else if ($bonus_for == 3) {
            echo "Hotel Pakcage";
        } else {
            echo "Travel Pakcage";
        }
    }
?>
@endsection
@section('scripts')
    <script>
        //open delete bonus modal
        $(document).on('click', '#bonusDelete', function () {
            $('#bonusDeleteModal').modal('show');
            $('input[name=del_id]').val($(this).data('id'));
         });
        
        //destroy bonus
        $("#destroyBonus").click(function(){
            $.ajax({
                type: 'POST',
                url: '/bonus/destroy',
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                data: {
                    id: $('input[name=del_id]').val()
                },
                success: function (response) {
                    if (response.status != 403) {
                        $('#bonusDeleteModal').modal('hide');
                        $('.bonus-' + $('input[name=del_id]').val()).remove();
                        toastr.success('Bonus Deleted')
                    } else {
                        toastr.error(response.message)
                    }
                    
                }
            });
        });
    </script>
@endsection
