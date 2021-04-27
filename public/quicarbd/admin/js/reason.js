//open visible time change modal
$(document).on('click', '#changeVisibleTime', function () {
    $('#changeVisibleTimeModal').modal('show');
    $('#ride_id').val($(this).data('ride_id'));
    $('#ride_visiable_time').val($(this).data('ride_visiable_time'));
 });

 //destroy master category
$("#updateRideVisibleTime").click(function(){
    var ride_id = $('#ride_id').val();
    var new_visiable_time  = $('#new_visiable_time').val();
    $.ajax({
        type: 'POST',
        url: '/admin/ride/update-visible-time',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            ride_id : ride_id,
            ride_visiable_time  : new_visiable_time
        },
        success: function (response) {
            if((response.errors)){
                if(response.errors.new_visiable_time){
                    $('.errorNewVisibleTime').text(response.errors.new_visiable_time);
                }
            }else{
                $('#reason').val('');
                toastr.success('Visible Time Update Successfully')
                $('#changeVisibleTimeModal').modal('hide');
                location.reload();
            }
        }
    });
});

//open send notification modal
$(document).on('click', '#cancelModal', function () {
    $('#showCancelModal').modal('show');
    $('#ride_id').val($(this).data('ride_id'));
 });

 //destroy master category
$("#sendReason").click(function(){
    var ride_id = $('#ride_id').val();
    var reason  = $('#reason').val();
    var cancel_from  = $('#cancel_from :selected').val();
    var charge_apply  = $('#charge_apply :selected').val();
    $.ajax({
        type: 'POST',
        url: '/admin/ride/cancel/reason/send',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            ride_id : ride_id,
            reason  : reason,
            cancel_from  : cancel_from,
            charge_apply  : charge_apply,
        },
        success: function (response) {
            if((response.errors)){
                if(response.errors.reason){
                    $('.reasonError').text(response.errors.reason);
                }   
                if(response.errors.cancel_from){
                    $('.cancelFromError').text(response.errors.cancel_from);
                }   
                if(response.errors.charge_apply){
                    $('.chargeApplyError').text(response.errors.charge_apply);
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


//open notification send modal
$(document).on('click', '#rideSendNotification', function () {
    $('#rideSendNotificationModal').modal('show');
    $('#ride_id').val($(this).data('ride_id'));
    $('#user_id').val($(this).data('user_id'));
 });

//notification send
$("#rideNotificationSend").click(function(){
    
    var ride_id = $('#ride_id').val();
    var user_id = $('#user_id').val();
    var title   = $('#title').val();
    var message = $('.sms_message').val();
    var nfor    = $('#for option:selected').val();
    var notification= $('input[name=notification]:checked').val();
    
    $.ajax({
        type: 'POST',
        url: '/admin/ride/notification/send',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            ride_id     : ride_id,
            user_id     : user_id,
            title       : title,
            message     : message,
            for         : nfor,
            notification: notification
        },
        success: function (response) {
            if((response.errors)){
                if(response.errors.title){
                    $('.errorTitle').text(response.errors.title);
                }
                if(response.errors.message){
                    $('.errorMessage').text(response.errors.message);
                }
            }else{
                toastr.success(response.message)
                $('#rideSendNotificationModal').modal('hide');
            }
        }
    });
});