$(document).on('click', '#deletePolicy', function () {
    $('#deletePolicyModal').modal('show');
    console.log('data id = ', $(this).data('id'))
    $('input[name=del_id]').val($(this).data('id'));
 });

//destroy Year
$("#destroyPolicy").click(function(){
    $.ajax({
        type: 'POST',
        url: '/admin/policy/cancellation/destroy',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id: $('input[name=del_id]').val()
        },
        success: function (data) {
            $('#deletePolicyModal').modal('hide');
            $('.policy-' + $('input[name=del_id]').val()).remove();
            toastr.success('Policy Deleted')
        }
    });
});