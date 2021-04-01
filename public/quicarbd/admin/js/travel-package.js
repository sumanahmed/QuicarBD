$("#district_id").change(function(){
    var district_id = $(this).val();
    $("#spot_ids").empty();
    $.get("/get-spot/"+ district_id, function( data ) {
        for( var i = 0; i < data.length; i++){
            $("#spot_ids").append('<option value="'+ data[i].id +'">'+ data[i].name +'</option>');
        }            
    });
});

$("#owner_id").change(function(){
    var owner_id = $(this).val();
    $.get("/get-travel-package-charge/"+ owner_id, function( travel_package_charge ) {         
        $("#quicar_charge_percent").val(travel_package_charge);
    });
});

function calculateCharge(){
    var quicar_charge_percent = $("#quicar_charge_percent").val();
    var cost_per_person = $("#cost_per_person").val();
    var quicar_charge   = (cost_per_person * quicar_charge_percent/100);
    var owner_get       = parseFloat(cost_per_person - quicar_charge);
    $("#quicar_charge").val(quicar_charge);
    $("#owner_get_per_person").val(owner_get);
}


//open delete Travel Package modal
$(document).on('click', '#deleteTravelPackage', function () {
    $('#deleteTravelPackageModal').modal('show');
    $('input[name=del_id]').val($(this).data('id'));
 });

//destroy Travel Package
$("#destroyTravelPackage").click(function(){
    $.ajax({
        type: 'POST',
        url: '/admin/travel-package/destroy',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id: $('input[name=del_id]').val()
        },
        success: function (data) {
            $('#deleteTravelPackageModal').modal('hide');
            $('.travel-package-' + $('input[name=del_id]').val()).remove();
            toastr.success('City Deleted')
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