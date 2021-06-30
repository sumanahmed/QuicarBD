//create
$("#create").click(function (e) {
    e.preventDefault();
    var name = $("#name").val();
    var bn_name = $("#bn_name").val();
    var district_id = $("#district_id :selected").val();
    $.ajax({
        type:'POST',
        url: '/setting/city/store',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            name : name,
            bn_name : bn_name,
            district_id : district_id,
        },
        success:function(response){
            if((response.errors)){
                if(response.errors.name){
                    $('.nameError').text(response.errors.name);
                } 
                if(response.errors.bn_name){
                    $('.nameBnError').text(response.errors.bn_name);
                }     
                if(response.errors.district_id){
                    $('.districtError').text(response.errors.district_id);
                }           
            }else{
                $('#createCityModal').modal('hide');
                $("#allCity").append('' +
                    '<tr class="city-'+ response.data.id +'">\n' +
                        '<td>'+ response.data.name +'</td>\n' +
                        '<td>'+ response.data.bn_name +'</td>\n' +
                        '<td>'+ response.data.district_name +'</td>\n' +
                        '<td style="vertical-align: middle;text-align: center;">\n' +                        
                            '<button class="btn btn-xs btn-warning" data-toggle="modal" id="editCity" data-target="#editCityModal" data-id="'+ response.data.id +'" data-name="'+ response.data.name +'" data-bn_name="'+ response.data.bn_name +'" data-district_id="'+ response.data.district_id +'" title="Edit"><i class="fa fa-edit"></i></button>\n' +
                            '<button class="btn btn-xs btn-danger" data-toggle="modal" id="deleteCity" data-target="#deleteCityModal" data-id="'+ response.data.id +'" title="Delete"><i class="fa fa-remove"></i></button>\n' +
                        '</td>\n' +
                    '</tr>'+
                '');
                $("#name").val('');
                $("#bn_name").val('');
                $("#district_id").val('');
                toastr.success('City Created.')
            }
        }
    });
});


//open edit City modal
$(document).on('click', '#editCity', function () {
    console.log($(this).data('name'), $(this).data('bn_name'));
    $('#editCityModal').modal('show');
    $('#edit_id').val($(this).data('id'));
    $('#edit_name').val($(this).data('name'));
    $('#edit_bn_name').val($(this).data('bn_name'));
    $('#edit_district_id').val($(this).data('district_id'));
 });

// update City
$("#update").click(function (e) {
    e.preventDefault();
    var id      = $("#edit_id").val();
    var name    = $("#edit_name").val();
    var bn_name = $("#edit_bn_name").val();
    var district_id = $("#edit_district_id :selected").val();
    $.ajax({
        type:'POST',
        url: '/setting/city/update',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id    : id,
            name  : name,
            bn_name  : bn_name,
            district_id  : district_id,
        },
        success:function(response){
            if((response.errors)){
                if(response.errors.name){
                    $('.nameError').text(response.errors.name);
                } 
                if(response.errors.bn_name){
                    $('.nameBnError').text(response.errors.bn_name);
                } 
                if(response.errors.district_id){
                    $('.districtError').text(response.errors.district_id);
                } 
            }else{
                $('#editCityModal').modal('hide');
                $("tr.city-"+ response.data.id).replaceWith('' +
                    '<tr class="city-'+ response.data.id +'">\n' +
                        '<td>'+ response.data.name +'</td>\n' +
                        '<td>'+ response.data.bn_name +'</td>\n' +
                        '<td>'+ response.data.district_name +'</td>\n' +
                        '<td style="vertical-align: middle;text-align: center;">\n' +
                            '<button class="btn btn-xs btn-warning" data-toggle="modal" id="editCity" data-target="#editCityModal" data-id="'+ response.data.id +'" data-name="'+ response.data.name +'" data-bn_name="'+ response.data.bn_name +'" data-district_id="'+ response.data.district_id +'" title="Edit"><i class="fa fa-edit"></i></button>\n' +
                            '<button class="btn btn-xs btn-danger" data-toggle="modal" id="deleteCity" data-target="#deleteCityModal" data-id="'+ response.data.id +'" title="Delete"><i class="fa fa-remove"></i></button>\n' +
                        '</td>\n' +
                    '</tr>'+
                '');
                toastr.success('City Updated.')
            }
        }
    });
});

//open delete City modal
$(document).on('click', '#deleteCity', function () {
    $('#deleteCityModal').modal('show');
    $('input[name=del_id]').val($(this).data('id'));
 });

//destroy City
$("#destroyCity").click(function(){
    $.ajax({
        type: 'POST',
        url: '/setting/city/destroy',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id: $('input[name=del_id]').val()
        },
        success: function (data) {
            $('#deleteCityModal').modal('hide');
            $('.city-' + $('input[name=del_id]').val()).remove();
            toastr.success('City Deleted')
        }
    });
});