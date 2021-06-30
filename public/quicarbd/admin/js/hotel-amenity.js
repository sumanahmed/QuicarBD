//create 
$("#create").click(function (e) {
    e.preventDefault();
    var name = $("#name").val();
    var status = $("#status").val();
    $.ajax({
        type:'POST',
        url: '/hotel-amenity/store',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            name : name,
            status : status,
        },
        success:function(response){
            if((response.errors)){
                if(response.errors.name){
                    $('.nameError').text(response.errors.name);
                } 
                if(response.errors.status){
                    $('.statusError').text(response.errors.status);
                }          
            }else{
                var status = response.data.status == 1 ? 'True' : 'False';
                $('#createHotelAmenityModal').modal('hide');
                $("#allHotelAmenity").append('' +
                    '<tr class="hotel_amenity-'+ response.data.id +'">\n' +
                        '<td>'+ response.data.name +'</td>\n' +
                        '<td>'+ status +'</td>\n' +
                        '<td style="vertical-align: middle;text-align: center;">\n' +                        
                            '<button class="btn btn-xs btn-warning" data-toggle="modal" id="editHotelAmenity" data-target="#editHotelAmenityModal" data-id="'+ response.data.id +'" data-name="'+ response.data.name +'" data-status="'+ response.data.status +'" title="Edit"><i class="fa fa-edit"></i></button>\n' +
                            '<button class="btn btn-xs btn-danger" data-toggle="modal" id="deleteHotelAmenity" data-target="#deleteHotelAmenityModal" data-id="'+ response.data.id +'" title="Delete"><i class="fa fa-remove"></i></button>\n' +
                        '</td>\n' +
                    '</tr>'+
                '');
                $("#name").val('');
                $("#status").val('');
                toastr.success('Hotel Amenity Created.')
            }
        }
    });
});


//open edit Hotel Amenity modal
$(document).on('click', '#editHotelAmenity', function () {
    $('#editHotelAmenityModal').modal('show');
    $('#edit_id').val($(this).data('id'));
    $('#edit_name').val($(this).data('name'));
    $('#edit_status').val($(this).data('status'));
 });

// update Hotel Amenity
$("#update").click(function (e) {
    e.preventDefault();
    var id      = $("#edit_id").val();
    var name    = $("#edit_name").val();
    var status  = $("#edit_status :selected").val();
    $.ajax({
        type:'POST',
        url: '/hotel-amenity/update',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id    : id,
            name  : name,
            status  : status,
        },
        success:function(response){
            if((response.errors)){
                if(response.errors.name){
                    $('.nameError').text(response.errors.name);
                } 
                if(response.errors.status){
                    $('.statusError').text(response.errors.status);
                }   
            }else{
                var status = response.data.status == 1 ? 'True' : 'False';
                $('#editHotelAmenityModal').modal('hide');
                $("tr.hotel_amenity-"+ response.data.id).replaceWith('' +
                    '<tr class="hotel_amenity-'+ response.data.id +'">\n' +
                        '<td>'+ response.data.name +'</td>\n' +
                        '<td>'+ status +'</td>\n' +
                        '<td style="vertical-align: middle;text-align: center;">\n' +
                            '<button class="btn btn-xs btn-warning" data-toggle="modal" id="editHotelAmenity" data-target="#editHotelAmenityModal" data-id="'+ response.data.id +'" data-name="'+ response.data.name +'" data-status="'+ response.data.status +'" title="Edit"><i class="fa fa-edit"></i></button>\n' +
                            '<button class="btn btn-xs btn-danger" data-toggle="modal" id="deleteHotelAmenity" data-target="#deleteHotelAmenityModal" data-id="'+ response.data.id +'" title="Delete"><i class="fa fa-remove"></i></button>\n' +
                        '</td>\n' +
                    '</tr>'+
                '');
                toastr.success('Hotel Amenity Updated.')
            }
        }
    });
});

//open delete Hotel Amenity modal
$(document).on('click', '#deleteHotelAmenity', function () {
    $('#deleteHotelAmenityModal').modal('show');
    $('input[name=del_id]').val($(this).data('id'));
 });

//destroy Hotel Amenity
$("#destroyHotelAmenity").click(function(){
    $.ajax({
        type: 'POST',
        url: '/hotel-amenity/destroy',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id: $('input[name=del_id]').val()
        },
        success: function (data) {
            $('#deleteHotelAmenityModal').modal('hide');
            $('.hotel_amenity-' + $('input[name=del_id]').val()).remove();
            toastr.success('Hotel Amenity Deleted')
        }
    });
});