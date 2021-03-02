//create driver
$("#create").click(function (e) {
    e.preventDefault();

    var form_data = new FormData($("#createDriverForm")[0]);
    form_data.append('name', $("#name").val());
    form_data.append('email', $("#email").val());
    form_data.append('phone', $("#phone").val());
    form_data.append('dob', $("#dob").val());
    form_data.append('owner_id', $("#owner_id :selected").val());
    form_data.append('nid', $("#nid").val());
    form_data.append('district_id', $("#district_id :selected").val());
    form_data.append('city_id', $("#city_id :selected").val());
    form_data.append('license', $("#license").val());
    form_data.append('address', $("#address").val());

    $.ajax({
        type:'POST',
        url: '/admin/driver/store',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        data: form_data,
        success:function(response){
            if((response.errors)){
                if(response.errors.name){
                    $('.nameError').text(response.errors.name);
                }else{
                    $('.nameError').text('');
                }               
                if(response.errors.phone){
                    $('.phoneError').text(response.errors.phone);
                }else{
                    $('.phoneError').text('');
                }               
                if(response.errors.dob){
                    $('.dobError').text(response.errors.dob);
                }else{
                    $('.dobError').text('');
                }               
                if(response.errors.owner_id){
                    $('.ownerError').text(response.errors.owner_id);
                }else{
                    $('.ownerError').text('');
                }               
                if(response.errors.nid){
                    $('.nidError').text(response.errors.nid);
                }else{
                    $('.nidError').text('');
                }                       
                if(response.errors.district_id){
                    $('.districtError').text(response.errors.district_id);
                }else{
                    $('.districtError').text('');
                }               
                if(response.errors.city_id){
                    $('.cityError').text(response.errors.city_id);
                }else{
                    $('.cityError').text('');
                }               
                if(response.errors.address){
                    $('.addressError').text(response.errors.address);
                }else{
                    $('.addressError').text('');
                }               
            }else{
                $('#createDriverModal').modal('hide');
                if(response.data.account_status == 1){
                    var status = "Active";
                }else{
                    var status = "Inactive";
                }
                $("#allDriver").append('' +
                    '<tr class="driver-'+ response.data.id +'">\n' +
                        '<td>'+ response.data.name +'</td>\n' +
                        '<td>'+ response.data.email +'</td>\n' +
                        '<td>'+ response.data.phone +'</td>\n' +
                        '<td><img src="http://quicarbd.com/'+ response.data.driver_photo +'" style="width:80px;height:80px;"/></td>\n' +
                        '<td>'+ status +'</td>\n' +
                        '<td style="vertical-align: middle;text-align: center;">\n' +                        
                            '<button class="btn btn-xs btn-warning" data-toggle="modal" id="editDriver" data-id="'+ response.data.id +'" data-name="'+ response.data.name +'"\n' + 
                                'data-email="'+ response.data.email +'" data-phone="'+ response.data.phone +'" data-dob="'+ response.data.dob +'" data-owner_id="'+ response.data.owner_id +'" data-nid="'+ response.data.nid +'"\n' + 
                                'data-district_id="'+ response.data.district_id +'" data-city_id="'+ response.data.city_id +'" data-address="'+ response.data.address +'" data-license="'+ response.data.license +'" data-driver_photo="http://quicarbd.com/'+ response.data.driver_photo +'"\n' + 
                                'data-nid_font_pic="http://quicarbd.com/'+ response.data.nid_font_pic +'"\n' + 'data-nid_back_pic="http://quicarbd.com/'+ response.data.nid_back_pic +'"\n' + 
                                'data-license_font_pic="http://quicarbd.com/'+ response.data.license_font_pic +'"\n' + 'data-license_back_pic="http://quicarbd.com/'+ response.data.license_back_pic +'"\n' + 
                                'title="Edit"><i class="fa fa-edit"></i></button>\n' +                            
                            '<button class="btn btn-xs btn-danger" data-toggle="modal" id="deleteDriver" data-target="#deleteDriverModal" data-id="'+ response.data.id +'" title="Delete"><i class="fa fa-remove"></i></button>\n' +
                        '</td>\n' +
                    '</tr>'+
                '');
                $("#name").val('');
                $("#email").val('');
                $("#phone").val('');
                $("#dob").val('');
                $("#owner_id").val('');
                $("#nid").val('');
                $("#district_id").val('');
                $("#city_id").val('');
                $("#address").val('');
                toastr.success('Driver Created.')
            }
        }
    });
});

//open edit Driver modal
$(document).on('click', '#editDriver', function () {

    $.get('/get-city/'+$(this).data('district_id'), function(data) {
        for( var i = 0; i < data.length; i++){
            //$("#edit_city_id").append('<option value="'+ data[i].id +'"' + (data[i].id == $(this).data('city_id') ? selected : "" )+'>'+ data[i].name +'</option>');
            $("#edit_city_id").append('<option value="'+ data[i].id +'">'+ data[i].name +'</option>');
        }    
    }); 

    // $('body').removeClass('modal-open');
    // $('.modal-backdrop').remove();

    $('#editDriverModal').modal('show');
    $('#edit_id').val($(this).data('id'));
    $('#edit_name').val($(this).data('name'));
    $('#edit_email').val($(this).data('email'));
    $('#edit_phone').val($(this).data('phone'));
    $('#edit_dob').val($(this).data('dob'));
    $('#edit_owner_id').val($(this).data('owner_id'));
    $('#edit_nid').val($(this).data('nid'));
    $('#edit_district_id').val($(this).data('district_id'));
    $('#edit_city_id').val($(this).data('city_id'));
    $('#edit_address').val($(this).data('address'));
    $('#edit_license').val($(this).data('license'));
    $("#previous_driver_photo").attr("src", $(this).data('driver_photo'));
    $("#previous_nid_font_pic").attr("src", $(this).data('nid_font_pic'));
    $("#previous_nid_back_pic").attr("src", $(this).data('nid_back_pic'));
    $("#previous_license_font_pic").attr("src", $(this).data('license_font_pic'));
    $("#previous_license_back_pic").attr("src", $(this).data('license_back_pic'));
});

//update driver
$("#updateDriver").click(function (e) {
    e.preventDefault();

    var form_data = new FormData($("#editDriverForm")[0]);
    form_data.append('id', $("#edit_id").val());
    form_data.append('name', $("#edit_name").val());
    form_data.append('email', $("#edit_email").val());
    form_data.append('phone', $("#edit_phone").val());
    form_data.append('dob', $("#edit_dob").val());
    form_data.append('owner_id', $("#edit_owner_id :selected").val());
    form_data.append('nid', $("#edit_nid").val());
    form_data.append('district_id', $("#edit_district_id :selected").val());
    form_data.append('city_id', $("#edit_city_id :selected").val());
    form_data.append('address', $("#edit_address").val());
    form_data.append('license', $("#edit_license").val());

    $.ajax({
        type:'POST',
        url: '/admin/driver/update',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        data: form_data,
        success:function(response){
            if((response.errors)){
                if(response.errors.name){
                    $('.nameError').text(response.errors.name);
                }else{
                    $('.nameError').text('');
                }               
                if(response.errors.phone){
                    $('.phoneError').text(response.errors.phone);
                }else{
                    $('.phoneError').text('');
                }               
                if(response.errors.dob){
                    $('.dobError').text(response.errors.dob);
                }else{
                    $('.dobError').text('');
                }               
                if(response.errors.owner_id){
                    $('.ownerError').text(response.errors.owner_id);
                }else{
                    $('.ownerError').text('');
                }               
                if(response.errors.nid){
                    $('.nidError').text(response.errors.nid);
                }else{
                    $('.nidError').text('');
                }               
                if(response.errors.division){
                    $('.divisionError').text(response.errors.division);
                }else{
                    $('.divisionError').text('');
                }               
                if(response.errors.district){
                    $('.districtError').text(response.errors.district);
                }else{
                    $('.districtError').text('');
                }               
                if(response.errors.address){
                    $('.addressError').text(response.errors.address);
                }else{
                    $('.addressError').text('');
                }               
            }else{
                $('#editDriverModal').modal('hide');
                if(response.data.account_status == 1){
                    var status = "Active";
                }else{
                    var status = "Inactive";
                }
                $("tr.driver-"+ response.data.id).replaceWith('' +
                    '<tr class="driver-'+ response.data.id +'">\n' +
                        '<td>'+ response.data.name +'</td>\n' +
                        '<td>'+ response.data.email +'</td>\n' +
                        '<td>'+ response.data.phone +'</td>\n' +
                        '<td><img src="http://quicarbd.com/'+ response.data.driver_photo +'" style="width:80px;height:80px;"/></td>\n' +
                        '<td>'+ status +'</td>\n' +
                        '<td style="vertical-align: middle;text-align: center;">\n' +                        
                        '<button class="btn btn-xs btn-warning" data-toggle="modal" id="editDriver" data-id="'+ response.data.id +'" data-name="'+ response.data.name +'"\n' + 
                            'data-email="'+ response.data.email +'" data-phone="'+ response.data.phone +'" data-dob="'+ response.data.dob +'" data-owner_id="'+ response.data.owner_id +'" data-nid="'+ response.data.nid +'"\n' + 
                            'data-district_id="'+ response.data.district_id +'" data-city_id="'+ response.data.city_id +'" data-address="'+ response.data.address +'" data-license="'+ response.data.license +'" data-driver_photo="http://quicarbd.com/'+ response.data.driver_photo +'"\n' + 
                            'data-nid_font_pic="http://quicarbd.com/'+ response.data.nid_font_pic +'"\n' + 'data-nid_back_pic="http://quicarbd.com/'+ response.data.nid_back_pic +'"\n' + 
                            'data-license_font_pic="http://quicarbd.com/'+ response.data.license_font_pic +'"\n' + 'data-license_back_pic="http://quicarbd.com/'+ response.data.license_back_pic +'"\n' + 
                            'title="Edit"><i class="fa fa-edit"></i></button>\n' +                            
                        '<button class="btn btn-xs btn-danger" data-toggle="modal" id="deleteDriver" data-target="#deleteDriverModal" data-id="'+ response.data.id +'" title="Delete"><i class="fa fa-remove"></i></button>\n' +
                        '</td>\n' +
                    '</tr>'+
                '');
                toastr.success('Driver Update.')
            }
        }
    });
});

//open delete driver modal
$(document).on('click', '#deleteDriver', function () {
    $('#deleteDriverModal').modal('show');
    $('input[name=del_id]').val($(this).data('id'));
 });

//destroy driver
$("#destroyDriver").click(function(){
    $.ajax({
        type: 'POST',
        url: '/admin/driver/destroy',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id: $('input[name=del_id]').val()
        },
        success: function (response) {
            $('#deleteDriverModal').modal('hide');
            $('.driver-' + $('input[name=del_id]').val()).remove();
            toastr.success(response.message)
        }
    });
});

$("#district_id").change(function(){
    var district_id = $(this).val();
    $("#city_id").empty();
    $.get("/get-city/"+ district_id, function( data ) {
        for( var i = 0; i < data.length; i++){
            $("#city_id").append('<option value="'+ data[i].id +'">'+ data[i].name +'</option>');
        }            
    });
});






