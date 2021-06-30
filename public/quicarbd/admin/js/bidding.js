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
      url: '/ride/update-bid-amount',
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
      url: '/ride/bid-cancel',
      headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
      data: {
          id: id,
          cancel_reason: cancel_reason
      },
      success: function (data) {
          toastr.success('Bid Cancelled')
          location.reload();
      }
  });
});


//open ride approve modal
$(document).on('click', '#showRideApprove', function () {
  $('#rideApproveModal').modal('show');
  $('#bid_id').val($(this).data('bid_id'));
  $('#ride_id').val($(this).data('ride_id'));
});

//ride approve
$("#rideApprove").click(function(){
  
  var bid_id  = $('#bid_id').val()
  var ride_id = $('#ride_id').val()
  var online_balance  = $('#online_balance').val()
  var user_balance    = $('#user_balance').val()
  var cashback_balance= $('#cashback_balance').val()
  var coupon_used = $('#coupon_used option:selected').val()
  var coupon_code = $('#coupon_code').val()
  var tnx_id = $('#tnx_id').val()
  var method = $('#method').val()
  
  $.ajax({
      type: 'POST',
      url: '/ride/user-approve',
      headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
      data: {
          bid_id : bid_id,
          ride_id: ride_id,
          online_balance  : online_balance,
          user_balance    : user_balance,
          cashback_balance: cashback_balance,
          coupon_used: coupon_used,
          coupon_code: coupon_code,
          tnx_id: tnx_id,
          method: method
      },
      success: function (data) {
          if ((response.errors)) {
              if (response.errors.name) {
                  $('.nameError').text(response.errors.name);
              } else {
                  $('.nameError').text('');
              }               
          }else{
              
          }
          
          toastr.success('Ride Approved')
          //location.reload();
      }
  });
});