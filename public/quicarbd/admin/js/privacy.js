$(document).on('click', '#deletePrivacy', function () {
    $('#deletePrivacyModal').modal('show');
    console.log('data id = ', $(this).data('id'))
    $('input[name=del_id]').val($(this).data('id'));
 });

//destroy Year
$("#destroyPrivacy").click(function(){
    $.ajax({
        type: 'POST',
        url: '/admin/privacy/destroy',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id: $('input[name=del_id]').val()
        },
        success: function (data) {
            $('#deletePrivacyModal').modal('hide');
            $('.privacy-' + $('input[name=del_id]').val()).remove();
            toastr.success('Privacy Deleted')
        }
    });
});