//create Spot
$("#create").click(function (e) { console.log("yesss");
    e.preventDefault();
    var form_data = new FormData($("#createSpotForm")[0]);
    form_data.append('name', $("#name").val());
    form_data.append('bn_name', $("#bn_name").val());
    form_data.append('district_id', $("#district_id :selected").val());
    form_data.append('address', $("#address").val());

    $.ajax({
        type:'POST',
        url: '/setting/tour-spot/store',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        data: form_data,
        success:function(response){
            if((response.errors)){
                if(response.errors.name){
                    $('.nameError').text(response.errors.name);
                }               
                if(response.errors.bn_name){
                    $('.nameBnError').text(response.errors.bn_name);
                }               
                if(response.errors.Spot_id){
                    $('.SpotError').text(response.errors.Spot_id);
                }           
                if(response.errors.address){
                    $('.addressError').text(response.errors.address);
                }             
                if(response.errors.image){
                    $('.imageError').text(response.errors.image);
                }             
            }else{
                $('#createSpotModal').modal('hide');
                $("#allSpot").append('' +
                    '<tr class="spot-'+ response.data.id +'">\n' +
                        '<td>'+ response.data.name +'</td>\n' +
                        '<td>'+ response.data.bn_name +'</td>\n' +
                        '<td>'+ response.data.district_name +'</td>\n' +
                        '<td>'+ response.data.address +'</td>\n' +
                        '<td><img src="http://quicarbd.com/'+ response.data.image +'" style="width:80px;height:80px;"/></td>\n' +                        
                        '<td style="vertical-align: middle;text-align: center;">\n' +                        
                            '<button class="btn btn-xs btn-warning" data-toggle="modal" id="editSpot" data-target="#editSpotModal" data-id="'+ response.data.id +'" data-name="'+ response.data.value +'" data-bn_name="'+ response.data.bn_name +'" data-district_id="'+ response.data.district_id +'" data-address="'+ response.data.address +'" data-image="'+ response.data.image +'" title="Edit"><i class="fa fa-edit"></i></button>\n' +
                            '<button class="btn btn-xs btn-danger" data-toggle="modal" id="deleteSpot" data-target="#deleteSpotModal" data-id="'+ response.data.id +'" title="Delete"><i class="fa fa-remove"></i></button>\n' +
                        '</td>\n' +
                    '</tr>'+
                '');
                $("#name").val('');
                $("#district_id").val('');
                $("#address").val('');
                toastr.success('Spot Created.')
            }
        }
    });
});

//open edit Spot modal
$(document).on('click', '#editSpot', function () {
    $('#editSpotModal').modal('show');
    var image = image_base_path + $(this).data('image');
    $('#edit_id').val($(this).data('id'));
    $('#edit_name').val($(this).data('name'));
    $('#edit_bn_name').val($(this).data('bn_name'));
    $('#edit_district_id').val($(this).data('district_id'));
    $('#edit_address').val($(this).data('address'));
    $("#previous_image").attr("src", image);
});

//update Spot
$("#update").click(function (e) {
    e.preventDefault();
    var form_data = new FormData($("#editSpotForm")[0]);
    form_data.append('id', $("#edit_id").val());
    form_data.append('name', $("#edit_name").val());
    form_data.append('bn_name', $("#edit_bn_name").val());
    form_data.append('district_id', $("#edit_district_id :selected").val());
    form_data.append('address', $("#edit_address").val());
    $.ajax({
        type:'POST',
        url: '/setting/tour-spot/update',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        data: form_data,
        success:function(response){
            if((response.errors)){
                if(response.errors.name){
                    $('.nameError').text(response.errors.name);
                }            
                if(response.errors.bn_name){
                    $('.nameBnError').text(response.errors.bn_name);
                }     
                if(response.errors.Spot_id){
                    $('.SpotError').text(response.errors.Spot_id);
                }           
                if(response.errors.address){
                    $('.addressError').text(response.errors.address);
                }             
                if(response.errors.image){
                    $('.imageError').text(response.errors.image);
                }             
            }else{
                $('#editSpotModal').modal('hide');
                $("tr.spot-"+ response.data.id).replaceWith('' +
                    '<tr class="spot-'+ response.data.id +'">\n' +
                        '<td>'+ response.data.name +'</td>\n' +
                        '<td>'+ response.data.bn_name +'</td>\n' +
                        '<td>'+ response.data.district_name +'</td>\n' +
                        '<td>'+ response.data.address +'</td>\n' +
                        '<td><img src="http://quicarbd.com/'+ response.data.image +'" style="width:80px;height:80px;"/></td>\n' +                        
                        '<td style="vertical-align: middle;text-align: center;">\n' +                        
                            '<button class="btn btn-xs btn-warning" data-toggle="modal" id="editSpot" data-target="#editSpotModal" data-id="'+ response.data.id +'" data-name="'+ response.data.value +'" data-bn_name="'+ response.data.bn_name +'" data-district_id="'+ response.data.district_id +'" data-address="'+ response.data.address +'" data-image="'+ response.data.image +'" title="Edit"><i class="fa fa-edit"></i></button>\n' +
                            '<button class="btn btn-xs btn-danger" data-toggle="modal" id="deleteSpot" data-target="#deleteSpotModal" data-id="'+ response.data.id +'" title="Delete"><i class="fa fa-remove"></i></button>\n' +
                        '</td>\n' +
                    '</tr>'+
                '');
                toastr.success('Spot Update.')
            }
        }
    });
});

//open delete Spot modal
$(document).on('click', '#deleteSpot', function () {
    $('#deleteSpotModal').modal('show');
    $('input[name=del_id]').val($(this).data('id'));
 });

//destroy Spot
$("#destroySpot").click(function(){
    $.ajax({
        type: 'POST',
        url: '/setting/tour-spot/destroy',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id: $('input[name=del_id]').val()
        },
        success: function (response) {
            $('#deleteSpotModal').modal('hide');
            $('.spot-' + $('input[name=del_id]').val()).remove();
            toastr.success('Spot Deleted')
        }
    });
});






