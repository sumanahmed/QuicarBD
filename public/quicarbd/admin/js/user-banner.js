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
        url: '/user-banner/destroy',
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
