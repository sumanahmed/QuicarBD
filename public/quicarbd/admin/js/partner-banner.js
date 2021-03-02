//create PartnerBanner
$("#create").click(function (e) { 
    e.preventDefault();
    var form_data = new FormData($("#createPartnerBannerForm")[0]);
    form_data.append('title', $("#title").val());
    form_data.append('details', $("#details").val());

    $.ajax({
        type:'POST',
        url: '/admin/partner-banner/store',
        headers: { 'X-CSRF-TOKEN': $('meta[title="_token"]').attr('content') },
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        data: form_data,
        success:function(response){
            if((response.errors)){
                if(response.errors.title){
                    $('.titleError').text(response.errors.title);
                }             
                if(response.errors.details){
                    $('.detailsError').text(response.errors.details);
                }         
            }else{
                if (response.data.status == 1) {
                    var status = 'Active';
                } else {
                    var status = 'Inactive';
                }
                $('#createPartnerBannerModal').modal('hide');
                $("#allPartnerBanner").append('' +
                    '<tr class="PartnerBanner-'+ response.data.id +'">\n' +
                        '<td>'+ response.data.title +'</td>\n' +
                        '<td>'+ status +'</td>\n' +
                        '<td><img src="http://quicarbd.com/'+ response.data.image_url +'" style="width:80px;height:80px;"/></td>\n' +                        
                        '<td style="vertical-align: middle;text-align: center;">\n' +                        
                            '<button class="btn btn-xs btn-warning" data-toggle="modal" id="editPartnerBanner" data-target="#editPartnerBannerModal" data-id="'+ response.data.id +'" data-title="'+ response.data.value +'" data-bn_title="'+ response.data.bn_title +'" data-district_id="'+ response.data.district_id +'" data-address="'+ response.data.address +'" data-image="'+ response.data.image +'" title="Edit"><i class="fa fa-edit"></i></button>\n' +
                            '<button class="btn btn-xs btn-danger" data-toggle="modal" id="deletePartnerBanner" data-target="#deletePartnerBannerModal" data-id="'+ response.data.id +'" title="Delete"><i class="fa fa-remove"></i></button>\n' +
                        '</td>\n' +
                    '</tr>'+
                '');
                $("#title").val('');
                $("#details").val('');
                toastr.success('Partner Banner Created.')
            }
        }
    });
});

//open edit PartnerBanner modal
$(document).on('click', '#editPartnerBanner', function () {
    $('#editPartnerBannerModal').modal('show');
    var image = image_base_path + $(this).data('image');
    $('#edit_id').val($(this).data('id'));
    $('#edit_title').val($(this).data('title'));
    $('#edit_details').val($(this).data('details'));
    $("#previous_image").attr("src", image);
});

//update PartnerBanner
$("#update").click(function (e) {
    e.preventDefault();
    var form_data = new FormData($("#editPartnerBannerForm")[0]);
    form_data.append('id', $("#edit_id").val());
    form_data.append('title', $("#edit_title").val());
    form_data.append('status', $("#edit_status :selected").val());
    form_data.append('details', $("#edit_details").val());
    $.ajax({
        type:'POST',
        url: '/admin/partner-banner/update',
        headers: { 'X-CSRF-TOKEN': $('meta[title="_token"]').attr('content') },
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        data: form_data,
        success:function(response){
            if((response.errors)){
                if(response.errors.title){
                    $('.titleError').text(response.errors.title);
                }            
                if(response.errors.details){
                    $('.detailsError').text(response.errors.details);
                }                
                if(response.errors.image){
                    $('.imageError').text(response.errors.image);
                }             
            }else{
                if (response.data.status == 1) {
                    var status = 'Active';
                } else {
                    var status = 'Inactive';
                }
                $('#editPartnerBannerModal').modal('hide');
                $("tr.PartnerBanner-"+ response.data.id).replaceWith('' +
                    '<tr class="PartnerBanner-'+ response.data.id +'">\n' +
                        '<td>'+ response.data.title +'</td>\n' +
                        '<td>'+ status +'</td>\n' +
                        '<td><img src="http://quicarbd.com/'+ response.data.image_url +'" style="width:80px;height:80px;"/></td>\n' +                        
                        '<td style="vertical-align: middle;text-align: center;">\n' +                        
                            '<button class="btn btn-xs btn-warning" data-toggle="modal" id="editPartnerBanner" data-target="#editPartnerBannerModal" data-id="'+ response.data.id +'" data-title="'+ response.data.value +'" data-bn_title="'+ response.data.bn_title +'" data-district_id="'+ response.data.district_id +'" data-address="'+ response.data.address +'" data-image="'+ response.data.image +'" title="Edit"><i class="fa fa-edit"></i></button>\n' +
                            '<button class="btn btn-xs btn-danger" data-toggle="modal" id="deletePartnerBanner" data-target="#deletePartnerBannerModal" data-id="'+ response.data.id +'" title="Delete"><i class="fa fa-remove"></i></button>\n' +
                        '</td>\n' +
                    '</tr>'+
                '');
                toastr.success('Partner Banner Update.')
            }
        }
    });
});

//open delete PartnerBanner modal
$(document).on('click', '#deletePartnerBanner', function () {
    $('#deletePartnerBannerModal').modal('show');
    $('input[title=del_id]').val($(this).data('id'));
 });

//destroy PartnerBanner
$("#destroyPartnerBanner").click(function(){
    $.ajax({
        type: 'POST',
        url: '/admin/partner-banner/destroy',
        headers: { 'X-CSRF-TOKEN': $('meta[title="_token"]').attr('content') },
        data: {
            id: $('input[title=del_id]').val()
        },
        success: function (response) {
            $('#deletePartnerBannerModal').modal('hide');
            $('.PartnerBanner-' + $('input[title=del_id]').val()).remove();
            toastr.success('PartnerBanner Deleted')
        }
    });
});






