
//create offer
$("#create").click(function (e) {
    e.preventDefault();
    var name = $("#name").val();
    $.ajax({
        type:'POST',
        url: '/admin/year/store',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            name : name,
        },
        success:function(response){
            if((response.errors)){
                if(response.errors.name){
                    $('.nameError').text(response.errors.name);
                }         
            }else{
                $('#createYearModal').modal('hide');
                $("#allYear").append('' +
                    '<tr class="year-'+ response.data.id +'">\n' +
                        '<td>'+ response.data.name +'</td>\n' +
                        '<td style="vertical-align: middle;text-align: center;">\n' +                        
                            '<button class="btn btn-xs btn-warning" data-toggle="modal" id="editYear" data-target="#editYearModal" data-id="'+ response.data.id +'" data-name="'+ response.data.name +'" title="Edit"><i class="fa fa-edit"></i></button>\n' +
                            '<button class="btn btn-xs btn-danger" data-toggle="modal" id="deleteYear" data-target="#deleteYearModal" data-id="'+ response.data.id +'" title="Delete"><i class="fa fa-remove"></i></button>\n' +
                        '</td>\n' +
                    '</tr>'+
                '');
                $("#name").val('');
                toastr.success('Year Created.')
            }
        }
    });
});


//open edit Year modal
$(document).on('click', '#editYear', function () {
    $('#editYearModal').modal('show');
    $('#edit_id').val($(this).data('id'));
    $('#edit_name').val($(this).data('name'));
 });

// update Year
$("#update").click(function (e) {
    e.preventDefault();
    var id          = $("#edit_id").val();
    var name        = $("#edit_name").val();
    $.ajax({
        type:'POST',
        url: '/admin/year/update',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id          : id,
            name        : name,
        },
        success:function(response){
            if((response.errors)){
                if(response.errors.name){
                    $('.nameError').text(response.errors.name);
                } 
            }else{
                $('#editYearModal').modal('hide');
                $("tr.year-"+ response.data.id).replaceWith('' +
                    '<tr class="year-'+ response.data.id +'">\n' +
                        '<td>'+ response.data.name +'</td>\n' +
                        '<td style="vertical-align: middle;text-align: center;">\n' +
                            '<button class="btn btn-xs btn-warning" data-toggle="modal" id="editYear" data-target="#editYearModal" data-id="'+ response.data.id +'" data-name="'+ response.data.name +'" title="Edit"><i class="fa fa-edit"></i></button>\n' +
                            '<button class="btn btn-xs btn-danger" data-toggle="modal" id="deleteYear" data-target="#deleteYearModal" data-id="'+ response.data.id +'" title="Delete"><i class="fa fa-remove"></i></button>\n' +
                        '</td>\n' +
                    '</tr>'+
                '');
                toastr.success('Year Updated.')
            }
        }
    });
});

//open delete Year modal
$(document).on('click', '#deleteYear', function () {
    $('#deleteYearModal').modal('show');
    $('input[name=del_id]').val($(this).data('id'));
 });

//destroy Year
$("#destroyYear").click(function(){
    $.ajax({
        type: 'POST',
        url: '/admin/year/destroy',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id: $('input[name=del_id]').val()
        },
        success: function (data) {
            $('#deleteYearModal').modal('hide');
            $('.year-' + $('input[name=del_id]').val()).remove();
            toastr.success('Year Deleted')
        }
    });
});