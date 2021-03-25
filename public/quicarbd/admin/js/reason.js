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