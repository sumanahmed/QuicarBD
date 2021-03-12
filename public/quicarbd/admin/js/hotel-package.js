$("#district_id").change(function(){
    var district_id = $(this).val();
    console.log(district_id);
    $("#city_id").empty();
    $.get("/get-city/"+ district_id, function( data ) {
        $("#city_id").append('<option selected disabled>Select</option>');
        for( var i = 0; i < data.length; i++){
            $("#city_id").append('<option value="'+ data[i].id +'">'+ data[i].name +'</option>');
        }            
    });
});

$("#owner_id").change(function(){
    var owner_id = $(this).val();
    $.get("/get-hotel-package-charge/"+ owner_id, function( hotel_package_charge ) {         
        $("#quicar_charge").val(hotel_package_charge);
    });
});

function calculateCharge(){
    var quicar_charge = $("#quicar_charge").val();
    var price         = $("#price").val();
    var owner_get     = parseFloat(price - (price * quicar_charge/100));
    $("#you_will_get").val(owner_get);
}

//hotel image upload
function hotelImgUpload(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#hotelImgPreview').css('background-image', 'url('+e.target.result +')');
            $('#hotelImgPreview').hide();
            $('#hotelImgPreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#hotelImgUpload").change(function() {
    hotelImgUpload(this);
});

//room image upload
function roomImgUpload(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#roomImgPreview').css('background-image', 'url('+e.target.result +')');
            $('#roomImgPreview').hide();
            $('#roomImgPreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#roomImgUpload").change(function() {
    roomImgUpload(this);
});