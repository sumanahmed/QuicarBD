$(document).on('click', '#replyComplain', function () {
    $('#replyComplainModal').modal('show');
    $('#id').val($(this).data('id'));
    $('.complain').val($(this).data('complain'));
    $('.reply_message').val($(this).data('reply_message'));
    $('#sender_id').val($(this).data('sender_id'));
    $('#type').val($(this).data('type'));
 });

// update Color
$("#sendComplainReply").click(function (e) {
    var id          = $("#id").val();
    var sender_id   = $("#sender_id").val();
    var complain    = $(".complain").val();
    var reply       = $(".reply_message").val();
    var type        = $("#type").val();
    $.ajax({
        type:'POST',
        url: '/complain/reply',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id          : id,
            sender_id   : sender_id,
            complain    : complain,
            reply       : reply,
            type        : type
        },
        success:function(response){
            if((response.errors)){
                if(response.errors.reply){
                    $('.errorReply').text(response.errors.reply);
                }
            }else{
                $('#replyComplainModal').modal('hide');
                toastr.success('Complain Replied Successfully.')
                location.reload();
            }
        }
    });
});