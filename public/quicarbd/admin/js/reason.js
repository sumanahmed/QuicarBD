//open send notification modal
$(document).on('click', '#cancelModal', function () {
    console.log('ride id =', $(this).data('ride_id'));
    $('#showCancelModal').modal('show');
    $('#ride_id').val($(this).data('ride_id'));
 });

 //destroy master category
$("#sendReason").click(function(){
    var ride_id = $('#ride_id').val();
    var reason  = $('#reason').val();
    $.ajax({
        type: 'POST',
        url: '/admin/ride/cancel/reason/send',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            ride_id : ride_id,
            reason  : reason
        },
        success: function (response) {
            if((response.errors)){
                if(response.errors.reason){
                    $('.reasonError').text(response.errors.reason);
                }
            }else{
                $('#reason').val('');
                toastr.success('Cancel Successfully')
                $('#showCancelModal').modal('hide');
                location.reload();
            }
        }
    });
});

//open send notification modal
$(document).on('click', '#carPackageCancelModal', function () {
    console.log('ride id =', $(this).data('ride_id'));
    $('#showCarPackageCancelModal').modal('show');
    $('#package_order_id').val($(this).data('package_order_id'));
 });

 //destroy master category
$("#carPackageSendReason").click(function(){
    var package_order_id = $('#package_order_id').val();
    var reason  = $('#reason').val();
    $.ajax({
        type: 'POST',
        url: '/admin/ride/cancel/reason/send',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            package_order_id : package_order_id,
            reason  : reason
        },
        success: function (response) {
            if((response.errors)){
                if(response.errors.reason){
                    $('.reasonError').text(response.errors.reason);
                }
            }else{
                $('#reason').val('');
                toastr.success('Cancel Successfully')
                $('#showCarPackageCancelModal').modal('hide');
                location.reload();
            }
        }
    });
});


//open send notification modal
$(document).on('click', '#hotelPackageCancelModal', function () {
    console.log('ride id =', $(this).data('ride_id'));
    $('#showHotelPackageCancelModal').modal('show');
    $('#package_order_id').val($(this).data('package_order_id'));
 });

 //destroy master category
$("#hotelPackageSendReason").click(function(){
    var package_order_id = $('#package_order_id').val();
    var reason  = $('#reason').val();
    $.ajax({
        type: 'POST',
        url: '/admin/hotel-package-order/cancel/reason/send',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            package_order_id : package_order_id,
            reason  : reason
        },
        success: function (response) {
            if((response.errors)){
                if(response.errors.reason){
                    $('.reasonError').text(response.errors.reason);
                }
            }else{
                $('#reason').val('');
                toastr.success('Cancel Successfully')
                $('#showHotelPackageCancelModal').modal('hide');
                location.reload();
            }
        }
    });
});