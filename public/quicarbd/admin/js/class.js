
//create offer
$("#createClass").click(function (e) {
    e.preventDefault();
    var name = $("#name").val();
    var car_type_id = $("#car_type_id :selected").val();
    $.ajax({
        type:'POST',
        url: '/admin/class/store',
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
                $('#createClassModal').modal('hide');
                $("#allClass").append('' +
                    '<tr class="Class-'+ response.data.id +'">\n' +
                        '<td>'+ response.data.value +'</td>\n' +
                        '<td>'+ response.data.car_type_name +'</td>\n' +
                        '<td style="vertical-align: middle;text-align: center;">\n' +                        
                            '<button class="btn btn-warning" data-toggle="modal" id="editClass" data-target="#editClassModal" data-id="'+ response.data.id +'" data-name="'+ response.data.value +'" data-car_type_id="'+ response.data.car_type_id +'" title="Edit"><i class="fas fa-edit"></i></button>\n' +
                            '<button class="btn btn-danger" data-toggle="modal" id="deleteClass" data-target="#deleteClassModal" data-id="'+ response.data.id +'" title="Delete"><i class="fas fa-trash"></i></button>\n' +
                        '</td>\n' +
                    '</tr>'+
                '');
                $("#name").val('');
                toastr.success('Car Class Created.')
            }
        }
    });
});


//open edit Class modal
$(document).on('click', '#editClass', function () {
    $('#editClassModal').modal('show');
    $('#edit_id').val($(this).data('id'));
    $('#edit_name').val($(this).data('name'));
    $('#edit_car_type_id').val($(this).data('car_type_id'));
 });

// update Class
$("#updateClass").click(function (e) {
    e.preventDefault();
    var id      = $("#edit_id").val();
    var name    = $("#edit_name").val();
    var car_type_id    = $("#edit_car_type_id :selected").val();
    $.ajax({
        type:'POST',
        url: '/admin/class/update',
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
                $('#editClassModal').modal('hide');
                $("tr.Class-"+ response.data.id).replaceWith('' +
                    '<tr class="Class-'+ response.data.id +'">\n' +
                        '<td>'+ response.data.value +'</td>\n' +
                        '<td style="vertical-align: middle;text-align: center;">\n' +
                            '<button class="btn btn-warning" data-toggle="modal" id="editClass" data-target="#editClassModal" data-id="'+ response.data.id +'" data-name="'+ response.data.value +'" data-car_type_id="'+ response.data.car_type_id +'" title="Edit"><i class="fas fa-edit"></i></button>\n' +
                            '<button class="btn btn-danger" data-toggle="modal" id="deleteClass" data-target="#deleteClassModal" data-id="'+ response.data.id +'" title="Delete"><i class="fas fa-trash"></i></button>\n' +
                        '</td>\n' +
                    '</tr>'+
                '');
                toastr.success('Class Updated.')
            }
        }
    });
});

//open delete Class modal
$(document).on('click', '#deleteClass', function () {
    $('#deleteClassModal').modal('show');
    $('input[name=del_id]').val($(this).data('id'));
 });

//destroy Class
$("#destroyClass").click(function(){
    $.ajax({
        type: 'POST',
        url: '/admin/class/destroy',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id: $('input[name=del_id]').val()
        },
        success: function (data) {
            $('#deleteClassModal').modal('hide');
            $('.Class-' + $('input[name=del_id]').val()).remove();
            toastr.success('Class Deleted')
        }
    });
});