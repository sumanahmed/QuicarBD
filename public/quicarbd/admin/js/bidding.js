//open bid amount change modal
$(document).on('click', '#bidAmountChange', function () {
    $('#bidAmountChangeModal').modal('show');
    $('#bid_id').val($(this).data('id'));
    $('#bit_amount').val($(this).data('bit_amount'));
    $('#quicar_charge').val($(this).data('quicar_charge'));
    $('#you_get').val($(this).data('you_get'));
 });

//bid amount change
$("#updateBidAmount").click(function(){
    
    var id          = $('#bid_id').val()
    var bit_amount  = $('#bit_amount').val()
    var you_get     = $('#you_get').val()
    var new_bit_amount  = $('#new_bit_amount').val()
    var quicar_charge   = $('#quicar_charge').val()
    
    $.ajax({
        type: 'POST',
        url: '/admin/ride/update-bid-amount',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id: id,
            bit_amount: bit_amount,
            new_bit_amount: new_bit_amount,
            quicar_charge: quicar_charge,
            you_get: you_get
        },
        success: function (data) {
            toastr.success('Bid amount updated')
            location.reload();
        }
    });
});

//open bid cancel modal
$(document).on('click', '#bidCancelModal', function () {
    $('#showCancelModal').modal('show');
    $('#bid_id').val($(this).data('id'));
 });

//bid cancel
$("#sendCancelReason").click(function(){
    
    var id          = $('#bid_id').val()
    var cancel_reason   = $('#cancel_reason').val()
    
    $.ajax({
        type: 'POST',
        url: '/admin/ride/bid-cancel',
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        data: {
            id: id,
            cancel_reason: cancel_reason
        },
        success: function (data) {
            toastr.success('Bid Cancelled')
            //location.reload();
        }
    });
});