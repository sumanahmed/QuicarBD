//create PartnerBanner
$("#create").click(function (e) { 
    e.preventDefault();
    var form_data = new FormData($("#createPartnerBannerForm")[0]);
    form_data.append('title', $("#title").val());
    form_data.append('details', $("#details").val());
    form_data.append('status', $("#status :selected").val());

    $.ajax({
        type:'POST',
        url: '/partner-banner/store',
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
                if(response.errors.status){
                    $('.statusError').text(response.errors.status);
                }         
            }else{
                if (response.data.status == 1) {
                    var status = 'Active';
                } else {
                    var status = 'Inactive';
                }
                $('#createPartnerBannerModal').modal('hide');
                $("#allPartnerBanner").append('' +
                    '<tr class="partner-banner-'+ response.data.id +'">\n' +
                        '<td>'+ response.data.title +'</td>\n' +
                        '<td>'+ status +'</td>\n' +
                        '<td><img src="http://quicarbd.com/'+ response.data.image_url +'" style="width:80px;height:80px;"/></td>\n' +                        
                        '<td style="vertical-align: middle;text-align: center;">\n' +                        
                            '<button class="btn btn-xs btn-warning" data-toggle="modal" id="editPartnerBanner" data-target="#editPartnerBannerModal" data-id="'+ response.data.id +'" data-title="'+ response.data.title +'" data-details="'+ response.data.details +'" data-image_url="'+ response.data.image_url +'" data-status="'+ response.data.status +'" title="Edit"><i class="fa fa-edit"></i></button>\n' +
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
    var image = image_base_path + $(this).data('image_url');
    $('#edit_id').val($(this).data('id'));
    $('#edit_title').val($(this).data('title'));
    $('#edit_details').val($(this).data('details'));
    $('#edit_status').val($(this).data('status'));
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
        url: '/partner-banner/update',
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
                if(response.errors.image_url){
                    $('.imageError').text(response.errors.image_url);
                }             
            }else{
                if (response.data.status == 1) {
                    var status = 'Active';
                } else {
                    var status = 'Inactive';
                }
                $('#editPartnerBannerModal').modal('hide');
                $("tr.partner-banner-"+ response.data.id).replaceWith('' +
                    '<tr class="partner-banner-'+ response.data.id +'">\n' +
                        '<td>'+ response.data.title +'</td>\n' +
                        '<td>'+ status +'</td>\n' +
                        '<td><img src="http://quicarbd.com/'+ response.data.image_url +'" style="width:80px;height:80px;"/></td>\n' +                        
                        '<td style="vertical-align: middle;text-align: center;">\n' +                        
                            '<button class="btn btn-xs btn-warning" data-toggle="modal" id="editPartnerBanner" data-target="#editPartnerBannerModal" data-id="'+ response.data.id +'" data-title="'+ response.data.title +'" data-details="'+ response.data.details +'" data-image_url="'+ response.data.image_url +'" data-status="'+ response.data.status +'" title="Edit"><i class="fa fa-edit"></i></button>\n' +
                            '<button class="btn btn-xs btn-danger" data-toggle="modal" id="deletePartnerBanner" data-target="#deletePartnerBannerModal" data-id="'+ response.data.id +'" title="Delete"><i class="fa fa-remove"></i></button>\n' +
                        '</td>\n' +
                    '</tr>'+
                '');
                toastr.success('Partner Banner Update.')
            }
        }
    });
});


//im1 upload
function img1(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#img1Preview').css('background-image', 'url('+e.target.result +')');
            $('#img1Preview').hide();
            $('#img1Preview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#img1Upload").change(function() {
    img1(this);
});

//open delete PartnerBanner modal
$(document).on('click', '#deletePartnerBanner', function () {
    $('#deletePartnerBannerModal').modal('show');
    $('input[name=del_id]').val($(this).data('id'));
 });

//destroy PartnerBanner
$("#destroyPartnerBanner").click(function(){
    $.ajax({
        type: 'POST',
        url: '/partner-banner/destroy',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id: $('input[name=del_id]').val()
        },
        success: function (response) {
            $('#deletePartnerBannerModal').modal('hide');
            $('.partner-banner-' + $('input[name=del_id]').val()).remove();
            toastr.success('Partner Banner Deleted')
        }
    });
});






