$(document).on('click', '#deletePolicy', function () {
    $('#deletePolicyModal').modal('show');
    $('input[name=del_id]').val($(this).data('id'));
 });

//destroy Year
$("#destroyPolicy").click(function(){
    $.ajax({
        type: 'POST',
        url: '/reason/cancellation/destroy',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id: $('input[name=del_id]').val()
        },
        success: function (data) {
            $('#deletePolicyModal').modal('hide');
            $('.reason-' + $('input[name=del_id]').val()).remove();
            toastr.success('Cancellation Reason Deleted')
        }
    });
});