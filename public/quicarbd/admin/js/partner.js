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
    var message     = $('#message').val();
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