
//create offer
$("#createColor").click(function (e) {
    e.preventDefault();
    var name = $("#name").val();
    var car_type_id = $("#car_type_id :selected").val();
    $.ajax({
        type:'POST',
        url: '/admin/colors/store',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            name : name,
            car_type_id : car_type_id,
        },
        success:function(response){
            if((response.errors)){
                if(response.errors.name){
                    $('.nameError').text(response.errors.name);
                }else{
                    $('.nameError').text('');
                }               
            }else{
                $('#createColorModal').modal('hide');
                $("#allColor").append('' +
                    '<tr class="color-'+ response.data.id +'">\n' +
                        '<td>'+ response.data.value +'</td>\n' +
                        '<td>'+ car_type_name +'</td>\n' +
                        '<td style="vertical-align: middle;text-align: center;">\n' +                        
                            '<button class="btn btn-warning" data-toggle="modal" id="editColor" data-target="#editColorModal" data-id="'+ response.data.id +'" data-name="'+ response.data.value +'" data-car_type_id="'+ response.data.car_type_id +'" title="Edit"><i class="fas fa-edit"></i></button>\n' +
                            '<button class="btn btn-danger" data-toggle="modal" id="deleteColor" data-target="#deleteColorModal" data-id="'+ response.data.id +'" title="Delete"><i class="fas fa-trash"></i></button>\n' +
                        '</td>\n' +
                    '</tr>'+
                '');
                $("#name").val('');
                toastr.success('Car Color Created.')
            }
        }
    });
});


//open edit Color modal
$(document).on('click', '#editColor', function () {
    $('#editColorModal').modal('show');
    $('#edit_id').val($(this).data('id'));
    $('#edit_name').val($(this).data('name'));
    $('#edit_car_type_id').val($(this).data('car_type_id'));
 });

// update Color
$("#updateColor").click(function (e) {
    e.preventDefault();
    var id      = $("#edit_id").val();
    var name    = $("#edit_name").val();
    var car_type_id    = $("#edit_car_type_id").val();
    $.ajax({
        type:'POST',
        url: '/admin/colors/update',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id    : id,
            name  : name,
            car_type_id  : car_type_id,
        },
        success:function(response){
            if((response.errors)){
                if(response.errors.name){
                    $('.nameError').text(response.errors.name);
                }else{
                    $('.nameError').text('');
                }  
            }else{
                $('#editColorModal').modal('hide');
                $("tr.color-"+ response.data.id).replaceWith('' +
                    '<tr class="color-'+ response.data.id +'">\n' +
                        '<td>'+ response.data.value +'</td>\n' +
                        '<td>'+ response.data.car_type_name +'</td>\n' +
                        '<td style="vertical-align: middle;text-align: center;">\n' +
                            '<button class="btn btn-warning" data-toggle="modal" id="editColor" data-target="#editColorModal" data-id="'+ response.data.id +'" data-name="'+ response.data.value +'" data-car_type_id="'+ response.data.car_type_id +'" title="Edit"><i class="fas fa-edit"></i></button>\n' +
                            '<button class="btn btn-danger" data-toggle="modal" id="deleteColor" data-target="#deleteColorModal" data-id="'+ response.data.id +'" title="Delete"><i class="fas fa-trash"></i></button>\n' +
                        '</td>\n' +
                    '</tr>'+
                '');
                toastr.success('Color Updated.')
            }
        }
    });
});

//open delete Color modal
$(document).on('click', '#deleteColor', function () {
    $('#deleteColorModal').modal('show');
    $('input[name=del_id]').val($(this).data('id'));
 });

//destroy Color
$("#destroyColor").click(function(){
    $.ajax({
        type: 'POST',
        url: '/admin/colors/destroy',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id: $('input[name=del_id]').val()
        },
        success: function (data) {
            $('#deleteColorModal').modal('hide');
            $('.color-' + $('input[name=del_id]').val()).remove();
            toastr.success('Color Deleted')
        }
    });
});