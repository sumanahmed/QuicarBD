
//open send notification modal
$(document).on('click', '#userSendNotification', function () {
    var image = image_base_path + $(this).data('image');
    $('#userSendNotificationModal').modal('show');
    $('#id').val($(this).data('id'));
    $('#n_key').val($(this).data('n_key'));
    $('#phone').val($(this).data('phone'));
 });

 //user notification send
$("#userNotificationSend").click(function(){
    var n_key       = $('#n_key').val();
    var user_id     = $('#id').val();
    var title       = $('#title').val();
    //var message     = $('#message').val();
    var message     = $('.sms_message').val();
    var notification= $('input[name=notification]:checked').val();
    var phone       = $('#phone').val();
    $.ajax({
        type: 'POST',
        url: '/user/notification/send',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            n_key       : n_key,
            user_id     : user_id,
            title       : title,
            message     : message,
            notification: notification,
            phone       : phone,
        },
        success: function (response) {
            if((response.errors)){
                if(response.errors.title){
                    $('.errorTitle').text(response.errors.title);
                }else{
                    $('.errorTitle').text('');
                }  
                if(response.errors.message){
                    $('.errorMessage').text(response.errors.message);
                }else{
                    $('.errorMessage').text('');
                }  
            }else{
                $('#userSendNotificationModal').modal('hide');
                toastr.success(response.message)
            }
        }
    });
});

//open balance add modal
$(document).on('click', '#userBalanceAdd', function () {
    $('#userBalanceAddModal').modal('show');
    $('input[name="id"]').val($(this).data('id'));
    $('input[name="n_key"]').val($(this).data('n_key'));
    $('input[name="balance"]').val($(this).data('balance'));
 });

//user balance add
$("#addBalance").click(function(){
    var id          = $('input[name="id"]').val();
    var n_key       = $('input[name="n_key"]').val();
    var balance     = $('input[name="balance"]').val();
    var add_balance = $('input[name="add_balance"]').val();
    var add_cashback_balance = $('input[name="add_cashback_balance"]').val();
    var deduct_balance  = $('input[name="deduct_balance"]').val();
    var reason_desc     = $('input[name="reason_desc"]').val();
    
    $.ajax({
        type: 'POST',
        url: '/user/balance/add',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id          : id,
            n_key       : n_key,
            balance     : balance,
            add_balance : add_balance,
            add_cashback_balance : add_cashback_balance,
            deduct_balance : deduct_balance,
            reason_desc : reason_desc,
        },
        success: function (response) {
            if((response.errors)){
                if(response.errors.add_balance){
                    $('.errorAddBalance').text(response.errors.add_balance);
                }  
                if(response.errors.add_cashback_balance){
                    $('.errorAddCashbackBalance').text(response.errors.add_cashback_balance);
                }
                if(response.errors.deduct_balance){
                    $('.errorDeductBalance').text(response.errors.deduct_balance);
                } 
                if(response.errors.reason_desc){
                    $('.errorReasonDesc').text(response.errors.reason_desc);
                } 
            }else{
                $('#userBalanceAddModal').modal('hide');
                toastr.success(response.message)
                location.reload();
            }
        }
    });
});