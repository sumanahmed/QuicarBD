
//create offer
$("#create").click(function (e) {
    e.preventDefault();
    var name = $("#name").val();
    var status = $("#status").val();
    $.ajax({
        type:'POST',
        url: '/admin/property-type/store',
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
                var status = response.data.status == 1 ? 'Enable' : 'Disable';
                $('#createPropertyTypeModal').modal('hide');
                $("#allPropertyType").append('' +
                    '<tr class="property_type-'+ response.data.id +'">\n' +
                        '<td>'+ response.data.name +'</td>\n' +
                        '<td>'+ status +'</td>\n' +
                        '<td style="vertical-align: middle;text-align: center;">\n' +                        
                            '<button class="btn btn-xs btn-warning" data-toggle="modal" id="editPropertyType" data-target="#editPropertyTypeModal" data-id="'+ response.data.id +'" data-name="'+ response.data.name +'" data-status="'+ response.data.status +'" title="Edit"><i class="fa fa-edit"></i></button>\n' +
                            '<button class="btn btn-xs btn-danger" data-toggle="modal" id="deletePropertyType" data-target="#deletePropertyTypeModal" data-id="'+ response.data.id +'" title="Delete"><i class="fa fa-remove"></i></button>\n' +
                        '</td>\n' +
                    '</tr>'+
                '');
                $("#name").val('');
                $("#status").val('');
                toastr.success('PropertyType Created.')
            }
        }
    });
});


//open edit PropertyType modal
$(document).on('click', '#editPropertyType', function () {
    console.log($(this).data('name'), $(this).data('bn_name'));
    $('#editPropertyTypeModal').modal('show');
    $('#edit_id').val($(this).data('id'));
    $('#edit_name').val($(this).data('name'));
    $('#edit_status').val($(this).data('status'));
 });

// update PropertyType
$("#updatePropertyType").click(function (e) {
    e.preventDefault();
    var id      = $("#edit_id").val();
    var name    = $("#edit_name").val();
    var status  = $("#edit_status :selected").val();
    $.ajax({
        type:'POST',
        url: '/admin/property-type/update',
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
                var status = response.data.status == 1 ? 'Enable' : 'Disable';
                $('#editPropertyTypeModal').modal('hide');
                $("tr.property_type-"+ response.data.id).replaceWith('' +
                    '<tr class="property_type-'+ response.data.id +'">\n' +
                        '<td>'+ response.data.name +'</td>\n' +
                        '<td>'+ status +'</td>\n' +
                        '<td style="vertical-align: middle;text-align: center;">\n' +
                            '<button class="btn btn-xs btn-warning" data-toggle="modal" id="editPropertyType" data-target="#editPropertyTypeModal" data-id="'+ response.data.id +'" data-name="'+ response.data.name +'" data-status="'+ response.data.status +'" title="Edit"><i class="fa fa-edit"></i></button>\n' +
                            '<button class="btn btn-xs btn-danger" data-toggle="modal" id="deletePropertyType" data-target="#deletePropertyTypeModal" data-id="'+ response.data.id +'" title="Delete"><i class="fa fa-remove"></i></button>\n' +
                        '</td>\n' +
                    '</tr>'+
                '');
                toastr.success('PropertyType Updated.')
            }
        }
    });
});

//open delete PropertyType modal
$(document).on('click', '#deletePropertyType', function () {
    $('#deletePropertyTypeModal').modal('show');
    $('input[name=del_id]').val($(this).data('id'));
 });

//destroy PropertyType
$("#destroyPropertyType").click(function(){
    $.ajax({
        type: 'POST',
        url: '/admin/property-type/destroy',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id: $('input[name=del_id]').val()
        },
        success: function (data) {
            $('#deletePropertyTypeModal').modal('hide');
            $('.property_type-' + $('input[name=del_id]').val()).remove();
            toastr.success('PropertyType Deleted')
        }
    });
});