$("#district_id").change(function(){
    var district_id = $(this).val();
    $("#spot_id").empty();
    $.get("/get-spot/"+ district_id, function( data ) {
        for( var i = 0; i < data.length; i++){
            $("#spot_id").append('<option value="'+ data[i].id +'">'+ data[i].name +'</option>');
        }            
    });
});

$("#owner_id").change(function(){
    var owner_id = $(this).val();
    $("#car_id").empty();
    $.get("/get-car/"+ owner_id, function( response ) {
         $("#car_id").append('<option selected disabled>Select</option>');
        for( var i = 0; i < response.data.length; i++) {
            $("#car_id").append('<option value="'+ response.data[i].id +'">'+ response.data[i].carRegisterNumber +'</option>');
        }            
        $("#quicar_charge_percent").val(response.car_package_charge);
    });
});

$("#car_id").change(function(){
    var car_id = $(this).val();
    $.get("/get-car-sit/"+ car_id, function( response ) {        
        $("#total_person").val(response);
    });
});

function calculateCharge(){
    var quicar_charge_percent = $("#quicar_charge_percent").val();
    var price         = $("#price").val();
    var quicar_charge =(price * quicar_charge_percent/100);
    var owner_get     = parseFloat(price - quicar_charge);
    $("#quicar_charge").val(quicar_charge);
    $("#owner_get").val(owner_get);
}

//open delete City modal
$(document).on('click', '#deleteCarPackage', function () {
    $('#deleteCarPackageModal').modal('show');
    $('input[name=del_id]').val($(this).data('id'));
 });

//destroy City
$("#deleteCarPackageModal").click(function(){
    $.ajax({
        type: 'POST',
        url: '/car-package/destroy',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id: $('input[name=del_id]').val()
        },
        success: function (data) {
            $('#deleteCarPackageModal').modal('hide');
            $('.car-package-' + $('input[name=del_id]').val()).remove();
            toastr.success('Car Package Deleted')
        }
    });
});

$("#starting_location").change(function(){
    var district_id = $(this).val();
    $("#starting_city_id").empty();
    $.get("/get-city/"+ district_id, function( data ) {
        $("#starting_city_id").append('<option selected disabled>Select</option>');
        for( var i = 0; i < data.length; i++){
            $("#starting_city_id").append('<option value="'+ data[i].id +'">'+ data[i].name +'</option>');
        }            
    });
});