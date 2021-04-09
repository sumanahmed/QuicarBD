//open delete driver modal
$(document).on('click', '#deleteDriver', function () {
    $('#deleteDriverModal').modal('show');
    $('input[name=del_id]').val($(this).data('id'));
 });

//destroy driver
$("#destroyDriver").click(function(){
    $.ajax({
        type: 'POST',
        url: '/admin/driver/destroy',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id: $('input[name=del_id]').val()
        },
        success: function (response) {
            $('#deleteDriverModal').modal('hide');
            $('.driver-' + $('input[name=del_id]').val()).remove();
            toastr.success(response.message)
        }
    });
});

$("#district_id").change(function(){
    var district_id = $(this).val();
    $("#city_id").empty();
    $.get("/get-city/"+ district_id, function( data ) {
        $("#city_id").append('<option selected disabled>Select</option>');
        for( var i = 0; i < data.length; i++){
            $("#city_id").append('<option value="'+ data[i].id +'">'+ data[i].name +'</option>');
        }            
    });
});


//img5 upload
function driverPhoto(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#dirverPhotoPreview').css('background-image', 'url('+e.target.result +')');
            $('#dirverPhotoPreview').hide();
            $('#dirverPhotoPreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#dirverPhotoUpload").change(function() {
    driverPhoto(this);
});

//img5 upload
function nid_font_pic(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#nidFrontPreview').css('background-image', 'url('+e.target.result +')');
            $('#nidFrontPreview').hide();
            $('#nidFrontPreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#nidFrontUpload").change(function() {
    nid_font_pic(this);
});

//img5 upload
function nid_back_pic(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#nidBackPreview').css('background-image', 'url('+e.target.result +')');
            $('#nidBackPreview').hide();
            $('#nidBackPreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#nidBackUpload").change(function() {
    nid_back_pic(this);
});

//license_font_pic upload
function license_font_pic(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#licenseFrontPreview').css('background-image', 'url('+e.target.result +')');
            $('#licenseFrontPreview').hide();
            $('#licenseFrontPreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#licenseFrontUpload").change(function() {
    license_font_pic(this);
});

//license_font_pic upload
function license_back_pic(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#licenseBackPreview').css('background-image', 'url('+e.target.result +')');
            $('#licenseBackPreview').hide();
            $('#licenseBackPreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#licenseBackUpload").change(function() {
    license_back_pic(this);
});

$('#dob').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    minYear: 1990,
    maxYear: parseInt(moment().format('YYYY'),20),
    autoApply: true,
    autoUpdateInput: false,
    locale: {
        format: 'DD-MM-YYYY'
    }
}, function(chosen_date) {
  $('#dob').val(chosen_date.format('DD-MM-YYYY'));
});


