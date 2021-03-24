//open send notification modal
$(document).on('click', '#sendNotification', function () {
    $('#showCancelModal').modal('show');
    $('#ride_id').val($(this).data('ride_id'));
 });

 //destroy master category
$("#sendReason").click(function(){
    var ride_id = $('#ride_id').val();
    var reason  = $('#reason:selected').val();
    $.ajax({
        type: 'POST',
        url: '/admin/partner/notification/send',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            ride_id : ride_id,
            reason  : reason
        },
        success: function (response) {
            if((response.errors)){
                if(response.errors.title){
                    $('.reasonError').text(response.errors.title);
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
                $('#showCancelModal').modal('hide');
            }
        }
    });
});