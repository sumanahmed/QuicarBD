$(document).on('click', '#replyMessage', function () {
    $('#replyMessageModal').modal('show');
    $('#id').val($(this).data('id'));
    $('.send_message').val($(this).data('message'));
    $('#sender_id').val($(this).data('sender_id'));
    $('#type').val($(this).data('type'));
 });

// update Color
$("#sendReply").click(function (e) {
    var id          = $("#id").val();
    var sender_id   = $("#sender_id").val();
    var send_message= $(".send_message").val();
    var reply       = $("#reply").val();
    var type        = $("#type").val();
    $.ajax({
        type:'POST',
        url: '/admin/message/reply',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id          : id,
            sender_id   : sender_id,
            send_message: send_message,
            reply       : reply,
            type        : type
        },
        success:function(response){
            if((response.errors)){
                if(response.errors.reply){
                    $('.errorReply').text(response.errors.reply);
                }
            }else{
                $('#replyMessageModal').modal('hide');
                toastr.success('Message Replied Successfully.')
                location.reload();
            }
        }
    });
});