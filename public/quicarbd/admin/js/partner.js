//open send notification modal
$(document).on('click', '#sendNotification', function () {
    $('#sendNotificationModal').modal('show');
    $('#owner_id').val($(this).data('id'));
    $('#n_key').val($(this).data('n_key'));
    $('#phone').val($(this).data('phone'));
 });

 //destroy master category
$("#ownerNotificationSend").click(function(){
    var n_key       = $('#n_key').val();
    var owner_id    = $('#owner_id').val();
    var title       = $('#title').val();
    var message     = $('.sms_message').val();
    var notification= $('input[name=notification]:checked').val();
    var phone       = $('#phone').val();
    $.ajax({
        type: 'POST',
        url: '/admin/partner/notification/send',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            n_key       : n_key,
            owner_id    : owner_id,
            title       : title,
            message     : message,
            notification: notification,
            phone       : phone,
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
                $('#n_key').val('');
                $('#title').val('');
                $('#message').val('');
                $('#phone').val('');
                toastr.success(response.message)
                $('#sendNotificationModal').modal('hide');
            }
        }
    });
});

//get city
$("#district").change(function(){
    var district_id = $(this).val();
    $.get('/get-city/'+ district_id, function(data){
        $('#city').empty();
        $('#city').append('<option selected disabled>Select</option');
        for(var i = 0; i <= data.length; i++){
            $('#city').append('<option value="'+ data[i].name +'">'+ data[i].name +'</option');
        }
    });
});

//get city
$("#service_location_district").change(function(){
    var district_id = $(this).val();
    $.get('/get-city/'+ district_id, function(data){
        $('#service_location_city').empty();
        $('#service_location_city').append('<option selected disabled>Select</option');
        for(var i = 0; i <= data.length; i++){
            $('#service_location_city').append('<option value="'+ data[i].name +'">'+ data[i].name +'</option');
        }
    });
});

//im1 upload
function img1(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#img1Preview').css('background-image', 'url('+e.target.result +')');
            $('#img1Preview').hide();
            $('#img1Preview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#img1Upload").change(function() {
    img1(this);
});

//img2 upload
function img2(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#img2Preview').css('background-image', 'url('+e.target.result +')');
            $('#img2Preview').hide();
            $('#img2Preview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#img2Upload").change(function() {
    img2(this);
});

//img3 upload
function img3(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#img3Preview').css('background-image', 'url('+e.target.result +')');
            $('#img3Preview').hide();
            $('#img3Preview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#img3Upload").change(function() {
    img3(this);
});



//open delete Brand modal
$(document).on('click', '#deletePartner', function () {
    $('#deletePartnerModal').modal('show');
    $('input[name=del_id]').val($(this).data('id'));
 });

//destroy Brand
$("#destroyPartner").click(function(){
    $.ajax({
        type: 'POST',
        url: '/admin/partner/destroy',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id: $('input[name=del_id]').val()
        },
        success: function (data) {
            $('#deleteBrandModal').modal('hide');
            $('.partner-' + $('input[name=del_id]').val()).remove();
            toastr.success('Partner Deleted')
        }
    });
});

//open request cancel modal
$(document).on('click', '#partnerHold', function () {
    $('#partnerHoldModal').modal('show');
    $('#id').val($(this).data('id'));
    $('#phone').val($(this).data('phone'));
    $('#n_key').val($(this).data('n_key'));
 });

//request cancel
$("#sendReason").click(function(){
    $.ajax({
        type: 'POST',
        url: '/admin/partner/hold',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id: $('#id').val(),
            phone: $('#phone').val(),
            n_key: $('#n_key').val(),
            block_reason: $('#block_reason').val()
        },
        success: function (response) {
            if((response.errors)){
                if(response.errors.block_reason){
                    $('.errorReason').text(response.errors.block_reason);
                } 
            } else {
                $('#partnerHoldModal').modal('hide');
                toastr.success('Partner Hold Successfully')
                //location.reload()
            }
        }
    });
});


//open hold modal
$(document).on('click', '#showRequestCancel', function () {
    $('#requestCancelModal').modal('show');
    $('input[name=del_id]').val($(this).data('id'));
    $('#owner_id').val($(this).data('owner_id'));
 });

//request cancel
$("#requestCancel").click(function(){
    $.ajax({
        type: 'POST',
        url: '/admin/partner/account-type-change-cancel',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id: $('input[name=del_id]').val(),
            owner_id: $('#owner_id').val()
        },
        success: function (data) {
            $('#requestCancelModal').modal('hide');
            $('.partner-' + $('input[name=del_id]').val()).remove();
            toastr.success('Request cancelled')
        }
    });
});



//open balance add modal
$(document).on('click', '#partnerBalanceAdd', function () {
    $('#partnerBalanceAddModal').modal('show');
    $('input[name="id"]').val($(this).data('id'));
    $('input[name="n_key"]').val($(this).data('n_key'));
    $('input[name="balance"]').val($(this).data('current_balance'));
 });

//user balance add
$("#addBalance").click(function(){
    var id          = $('input[name="id"]').val();
    var n_key       = $('input[name="n_key"]').val();
    var balance     = $('input[name="balance"]').val();
    var add_balance = $('input[name="add_balance"]').val();
    
    $.ajax({
        type: 'POST',
        url: '/admin/partner/balance/add',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id          : id,
            n_key       : n_key,
            balance     : balance,
            add_balance : add_balance,
        },
        success: function (response) {
            if((response.errors)){
                if(response.errors.add_balance){
                    $('.errorAddBalance').text(response.errors.add_balance);
                } 
            }else{
                $('#partnerBalanceAddModal').modal('hide');
                toastr.success(response.message)
                location.reload();
            }
        }
    });
});