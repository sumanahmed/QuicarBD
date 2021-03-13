//open send notification modal
$(document).on('click', '#sendNotification', function () {
    $('#sendNotificationModal').modal('show');
    $('#n_key').val($(this).data('n_key'));
    $('#phone').val($(this).data('phone'));
 });

 //destroy master category
$("#ownerNotificationSend").click(function(){
    var n_key       = $('#n_key').val();
    var title       = $('#title').val();
    var message     = $('#message').val();
    var notification= $('input[name=notification]:checked').val();
    var phone       = $('#phone').val();
    $.ajax({
        type: 'POST',
        url: '/admin/partner/notification/send',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            n_key       : n_key,
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