
//create
$("#create").click(function (e) {
    e.preventDefault();
    var name = $("#name").val();
    var car_type_id = $("#car_type_id :selected").val();
    $.ajax({
        type:'POST',
        url: '/admin/brand/store',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            name : name, car_type_id: car_type_id
        },
        success:function(response){
            if((response.errors)){
                if(response.errors.name){
                    $('.nameError').text(response.errors.name);
                }else{
                    $('.nameError').text('');
                }               
            }else{
                $('#createBrandModal').modal('hide');
                $("#allBrand").append('' +
                    '<tr class="brand-'+ response.data.id +'">\n' +
                        '<td>'+ response.data.value +'</td>\n' +
                        '<td>'+ response.data.car_type_name +'</td>\n' +
                        '<td style="vertical-align: middle;text-align: center;">\n' +                        
                            '<button class="btn btn-xs btn-warning" data-toggle="modal" id="editBrand" data-target="#editBrandModal" data-id="'+ response.data.id +'" data-name="'+ response.data.value +'" data-car_type_id="'+ response.data.car_type_id +'" title="Edit"><i class="fa fa-edit"></i></button>\n' +
                            '<button class="btn btn-xs btn-danger" data-toggle="modal" id="deleteBrand" data-target="#deleteBrandModal" data-id="'+ response.data.id +'" title="Delete"><i class="fa fa-remove"></i></button>\n' +
                        '</td>\n' +
                    '</tr>'+
                '');
                $("#name").val('');
                toastr.success('Car Brand Created.')
            }
        }
    });
});


//open edit Brand modal
$(document).on('click', '#editBrand', function () {
    $('#editBrandModal').modal('show');
    $('#edit_id').val($(this).data('id'));
    $('#edit_name').val($(this).data('name'));
    $('#edit_car_type_id').val($(this).data('car_type_id'));
 });

// update Brand
$("#update").click(function (e) {
    e.preventDefault();
    var id      = $("#edit_id").val();
    var name    = $("#edit_name").val();
    var car_type_id    = $("#edit_car_type_id :selected").val();
    $.ajax({
        type:'POST',
        url: '/admin/brand/update',
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
                $('#editBrandModal').modal('hide');
                $("tr.brand-"+ response.data.id).replaceWith('' +
                    '<tr class="brand-'+ response.data.id +'">\n' +
                        '<td>'+ response.data.value +'</td>\n' +
                        '<td>'+ response.data.car_type_name +'</td>\n' +
                        '<td style="vertical-align: middle;text-align: center;">\n' +
                            '<button class="btn btn-xs btn-warning" data-toggle="modal" id="editBrand" data-target="#editBrandModal" data-id="'+ response.data.id +'" data-name="'+ response.data.value +'" data-car_type_id="'+ response.data.car_type_id +'" title="Edit"><i class="fa fa-edit"></i></button>\n' +
                            '<button class="btn btn-xs btn-danger" data-toggle="modal" id="deleteBrand" data-target="#deleteBrandModal" data-id="'+ response.data.id +'" title="Delete"><i class="fa fa-remove"></i></button>\n' +
                        '</td>\n' +
                    '</tr>'+
                '');
                toastr.success('Brand Updated.')
            }
        }
    });
});

//open delete Brand modal
$(document).on('click', '#deleteBrand', function () {
    $('#deleteBrandModal').modal('show');
    $('input[name=del_id]').val($(this).data('id'));
 });

//destroy Brand
$("#destroyBrand").click(function(){
    $.ajax({
        type: 'POST',
        url: '/admin/brand/destroy',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id: $('input[name=del_id]').val()
        },
        success: function (data) {
            $('#deleteBrandModal').modal('hide');
            $('.brand-' + $('input[name=del_id]').val()).remove();
            toastr.success('Brand Deleted')
        }
    });
});