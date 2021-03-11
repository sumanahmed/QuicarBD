
//show driver info in modal
$(document).on('click', '#driverDetail', function () {
    
    var current_status = '';    
    if($(this).data('driver_current_status') == "0"){
        current_status = "Off Ride";
    }{
        current_status = "On Ride";       
    }

    var account_status = ''; 
    if($(this).data('account_status') == "0"){
        account_status = "Off";
    }else{
        account_status = "On";       
    }


    $('#driverDetailModal').modal('show');
    $('#driver_name').html($(this).data('driver_name'));
    $('#driver_phone').html($(this).data('driver_phone'));
    $('#current_status').html(current_status);
    $('#nid').html($(this).data('nid'));
    $('#account_status').html(account_status);
    $("#driver_license").attr("src", image_base_path + $(this).data('license'));
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


//img2 upload
function img2(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#img2Preview').css('background-image', 'url('+e.target.result +')');
            $('#img2Preview').hide();
            $('#img2Preview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#img2Upload").change(function() {
    img2(this);
});

//img3 upload
function img3(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#img3Preview').css('background-image', 'url('+e.target.result +')');
            $('#img3Preview').hide();
            $('#img3Preview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#img3Upload").change(function() {
    img3(this);
});

//img4 upload
function img4(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#img4Preview').css('background-image', 'url('+e.target.result +')');
            $('#img4Preview').hide();
            $('#img4Preview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#img4Upload").change(function() {
    img4(this);
});

//img5 upload
function img5(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#img5Preview').css('background-image', 'url('+e.target.result +')');
            $('#img5Preview').hide();
            $('#img5Preview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#img5Upload").change(function() {
    img5(this);
});

//img5 upload
function img6(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#img6Preview').css('background-image', 'url('+e.target.result +')');
            $('#img6Preview').hide();
            $('#img6Preview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#img6Upload").change(function() {
    img6(this);
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

$("#carType").change(function(){
    var carType = $(this).val();
    $("#carBrand").empty();
    $("#carBrand").append('<option selected disabled>Select</option>');
    $.get("/get-car-brand/"+ carType, function( data ) {
        $("#sit_capacity").val(data.sit);
        $("#carBrand").append('<option selected disabled>Select</option>');
        for( var i = 0; i < data.brands.length; i++){
            $("#carBrand").append('<option value="'+ data.brands[i].value +'">'+ data.brands[i].value +'</option>');
        }            
    });
});

$("#carBrand").change(function(){
    var carType = $("#carType option:selected").val();
    var carBrand = $(this).val();
    $("#carModel").empty();
    $("#carModel").append('<option selected disabled>Select</option>');
    $.get("/get-car-model/"+ carType + '/' + carBrand, function( data ) {
        for( var i = 0; i < data.length; i++){
            $("#carModel").append('<option value="'+ data[i].value +'">'+ data[i].value +'</option>');
        }            
    });
});

// $("#carModel").change(function(){
//     var carType = $("#carType option:selected").val();
//     var carModel = $(this).val();
//     $("#carYear").empty();
//     $("#carYear").append('<option selected disabled>Select</option>');
//     $.get("/get-car-year/"+ carType + '/' + carModel, function( data ) {
//         for( var i = 0; i < data.length; i++){
//             $("#carYear").append('<option value="'+ data[i].value +'">'+ data[i].value +'</option>');
//         }            
//     });
// });