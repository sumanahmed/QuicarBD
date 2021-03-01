//create
$("#create").click(function (e) {
    e.preventDefault();
    var name        = $("#name").val();
    var car_type_id = $("#car_type_id :selected").val();
    var car_brand_id= $("#car_brand_id :selected").val();
    $.ajax({
        type:'POST',
        url: '/admin/model/store',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            name        : name,
            car_type_id : car_type_id,
            car_brand_id: car_brand_id,
        },
        success:function(response){
            if((response.errors)){
                if(response.errors.name){
                    $('.nameError').text(response.errors.name);
                }           
                if(response.errors.car_type_id){
                    $('.carTypeError').text(response.errors.car_type_id);
                }           
                if(response.errors.car_brand_id){
                    $('.carBrandError').text(response.errors.car_brand_id);
                }           
            }else{
                $('#createModelModal').modal('hide');
                $("#allModel").append('' +
                    '<tr class="model-'+ response.data.id +'">\n' +
                        '<td>'+ response.data.value +'</td>\n' +
                        '<td>'+ response.data.car_type_name +'</td>\n' +
                        '<td>'+ response.data.car_brand_name +'</td>\n' +
                        '<td style="vertical-align: middle;text-align: center;">\n' +                        
                            '<button class="btn btn-xs btn-warning" data-toggle="modal" id="editModel" data-target="#editModelModal" data-id="'+ response.data.id +'" data-name="'+ response.data.value +'" data-car_type_id="'+ response.data.car_type_id +'" data-car_brand_id="'+ response.data.car_brand_id +'" title="Edit"><i class="fa fa-edit"></i></button>\n' +
                            '<button class="btn btn-xs btn-danger" data-toggle="modal" id="deleteModel" data-target="#deleteModelModal" data-id="'+ response.data.id +'" title="Delete"><i class="fa fa-remove"></i></button>\n' +
                        '</td>\n' +
                    '</tr>'+
                '');
                $("#name").val('');
                toastr.success('Car Model Created.')
            }
        }
    });
});


//open edit Model modal
$(document).on('click', '#editModel', function () {
    $('#editModelModal').modal('show');
    $('#edit_id').val($(this).data('id'));
    $('#edit_name').val($(this).data('name'));
    $('#edit_car_type_id').val($(this).data('car_type_id'));
    $('#edit_car_brand_id').val($(this).data('car_brand_id'));
 });

// update Model
$("#update").click(function (e) {
    e.preventDefault();
    var id          = $("#edit_id").val();
    var name        = $("#edit_name").val();
    var car_type_id = $("#edit_car_type_id :selected").val();
    var car_brand_id= $("#edit_car_brand_id :selected").val();
    
    $.ajax({
        type:'POST',
        url: '/admin/model/update',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id          : id,
            name        : name,
            car_type_id : car_type_id,
            car_brand_id: car_brand_id,
        },
        success:function(response){
            if((response.errors)){
                if(response.errors.name){
                    $('.nameError').text(response.errors.name);
                }
                if(response.errors.car_type_id){
                    $('.carTypeError').text(response.errors.car_type_id);
                }           
                if(response.errors.car_brand_id){
                    $('.carBrandError').text(response.errors.car_brand_id);
                }
            }else{
                $('#editModelModal').modal('hide');
                $("tr.model-"+ response.data.id).replaceWith('' +
                    '<tr class="model-'+ response.data.id +'">\n' +
                        '<td>'+ response.data.value +'</td>\n' +
                        '<td>'+ response.data.car_type_name +'</td>\n' +
                        '<td>'+ response.data.car_brand_name +'</td>\n' +
                        '<td style="vertical-align: middle;text-align: center;">\n' +
                            '<button class="btn btn-xs btn-warning" data-toggle="modal" id="editModel" data-target="#editModelModal" data-id="'+ response.data.id +'" data-name="'+ response.data.value +'" data-car_type_id="'+ response.data.car_type_id +'" data-car_brand_id="'+ response.data.car_brand_id +'" title="Edit"><i class="fa fa-edit"></i></button>\n' +
                            '<button class="btn btn-xs btn-danger" data-toggle="modal" id="deleteModel" data-target="#deleteModelModal" data-id="'+ response.data.id +'" title="Delete"><i class="fa fa-remove"></i></button>\n' +
                        '</td>\n' +
                    '</tr>'+
                '');
                toastr.success('Model Updated.')
            }
        }
    });
});

//open delete Model modal
$(document).on('click', '#deleteModel', function () {
    $('#deleteModelModal').modal('show');
    $('input[name=del_id]').val($(this).data('id'));
 });

//destroy Model
$("#destroyModel").click(function(){
    $.ajax({
        type: 'POST',
        url: '/admin/model/destroy',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id: $('input[name=del_id]').val()
        },
        success: function (data) {
            $('#deleteModelModal').modal('hide');
            $('.model-' + $('input[name=del_id]').val()).remove();
            toastr.success('Model Deleted')
        }
    });
});

//get brand by car_type_id
$("#car_type_id").change(function(){
    var car_type_id = $(this).val();
    $.get('/get-brand/'+ car_type_id, function(response){
        $('#car_brand_id').empty();
        for(var i = 0; i <= response.data.length; i++){
            $('#car_brand_id').append('<option value="'+ response.data[i].id +'">'+ response.data[i].name +'</option');
        }
    });
});

//get brand by car_type_id
$("#filter_car_type_id").change(function(){
    var car_type_id = $(this).val();
    $.get('/get-brand/'+ car_type_id, function(response){
        $('#filter_car_brand_id').empty();
        $('#filter_car_brand_id').append('<option selected disabled>Select</option>');
        for(var i = 0; i <= response.data.length; i++){
            $('#filter_car_brand_id').append('<option value="'+ response.data[i].id +'">'+ response.data[i].name +'</option');
        }
    });
});