$( "#out_of_app" ).change(function() {
    var outOfApp = $(this).val();
    if(outOfApp == 1) {
        $("#clickLinke").show();
    } else {
        $("#clickLinke").hide();
    }
});

$( "#where_go" ).change(function() {
    var whereGo = $(this).val();
    if(whereGo == 6) {
        $("#package").show();
    } else {
        $("#package").hide();
    }
});

//open delete Spot modal
$(document).on('click', '#deleteUserBanner', function () {
    console.log('banner id = '+ $(this).data('id'))
    $('#deleteUserBannerModal').modal('show');
    $('input[name=del_id]').val($(this).data('id'));
 });

//destroy Spot
$("#destroyUserBanner").click(function(){
    $.ajax({
        type: 'POST',
        url: '/admin/user-banner/destroy',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id: $('input[name=del_id]').val()
        },
        success: function (response) {
            $('#deleteUserBannerModal').modal('hide');
            $('.user-banner-' + $('input[name=del_id]').val()).remove();
            toastr.success('Banner Deleted')
        }
    });
});
