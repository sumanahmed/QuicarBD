
//create offer
$("#create").click(function (e) {
    e.preventDefault();
    var name = $("#name").val();
    $.ajax({
        type:'POST',
        url: '/class/store',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            name : name,            
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
                        '<td style="vertical-align: middle;text-align: center;">\n' +                        
                            '<button class="btn btn-xs btn-warning" data-toggle="modal" id="editClass" data-target="#editClassModal" data-id="'+ response.data.id +'" data-name="'+ response.data.value +'" title="Edit"><i class="fa fa-edit"></i></button>\n' +
                            '<button class="btn btn-xs btn-danger" data-toggle="modal" id="deleteClass" data-target="#deleteClassModal" data-id="'+ response.data.id +'" title="Delete"><i class="fa fa-remove"></i></button>\n' +
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
 });

// update Class
$("#update").click(function (e) {
    e.preventDefault();
    var id      = $("#edit_id").val();
    var name    = $("#edit_name").val();
    $.ajax({
        type:'POST',
        url: '/class/update',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id    : id,
            name  : name,
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
                            '<button class="btn btn-xs btn-warning" data-toggle="modal" id="editClass" data-target="#editClassModal" data-id="'+ response.data.id +'" data-name="'+ response.data.value +'" title="Edit"><i class="fa fa-edit"></i></button>\n' +
                            '<button class="btn btn-xs btn-danger" data-toggle="modal" id="deleteClass" data-target="#deleteClassModal" data-id="'+ response.data.id +'" title="Delete"><i class="fa fa-remove"></i></button>\n' +
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
        url: '/class/destroy',
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