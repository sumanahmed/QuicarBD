
<div class="overlay-dark"></div>
<img class="img-overlay"> 
</div>	
    <!-- jQuery -->
    <script src="{{ asset('quicarbd/admin/vendors/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('quicarbd/admin/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>    
	<!-- Data table JavaScript -->
	<script src="{{ asset('quicarbd/admin/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('quicarbd/admin/dist/js/dataTables-data.js') }}"></script>	
	<script src="{{ asset('quicarbd/admin/vendors/bower_components/jquery.counterup/jquery.counterup.min.js') }}"></script>	
	<!-- Fancy Dropdown JS -->
	<script src="{{ asset('quicarbd/admin/dist/js/dropdown-bootstrap-extended.js') }}"></script>	
	<!-- Sparkline JavaScript -->
	<script src="{{ asset('quicarbd/admin/vendors/jquery.sparkline/dist/jquery.sparkline.min.js') }}"></script>		
	<!-- Switchery JavaScript -->
	<script src="{{ asset('quicarbd/admin/vendors/bower_components/switchery/dist/switchery.min.js') }}"></script>	
	<!-- EChartJS JavaScript -->
	<script src="{{ asset('quicarbd/admin/vendors/bower_components/echarts/dist/echarts-en.min.js') }}"></script>
	<script src="{{ asset('quicarbd/admin/vendors/echarts-liquidfill.min.js') }}"></script>	
	<!-- Toast JavaScript -->
	<script src="{{ asset('quicarbd/admin/vendors/bower_components/summernote/dist/summernote.min.js') }}"></script>
	<script>
		$(function() {
			"use strict";
			$('.summernote').summernote({
				height: 300,
			});
		});
	</script>
	<!-- Init JavaScript -->
	<script src="{{ asset('quicarbd/admin/dist/js/init.js') }}"></script>
	<script src="{{ asset('quicarbd/admin/dist/js/dashboard-data.js') }}"></script>
	<script src="{{ asset('quicarbd/admin/dist/js/toastr.js') }}"></script>
	<script src="{{ asset('quicarbd/admin/js/image-popup.js') }}"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script>
	    $('.selectable').select2();
	</script>
	<script>
		var image_base_path = "https://quicarbd.com/";		
		//var image_base_path = "http://localhost:8000/";		
	</script>
	@if(Session::has('error_message'))
	    <script>
	        toastr.error("{{ Session::get('error_message') }}")
	    </script>
	@endif
	@if(Session::has('message'))
	    <script>
	        toastr.success("{{ Session::get('message') }}")
	    </script>
	@endif
	<script>
	    $("#sms").change(function(){
            var smsId = $("#sms option:selected").val();
            if (smsId == 0) {
                $("#title").val('');
                $(".sms_message").val('');
            } else {
                $.get("/sms/list?id="+ smsId, function( data ) {
                    $("#title").val(data[0].title);
                    $(".sms_message").val(data[0].message);
                });
            }
        });
        
        $("#smsDraftSave").click(function (e) {
            e.preventDefault();
            var smsId   = $("#sms option:selected").val();
            var title   = $("#title").val();
            var message = $(".sms_message").val();
            $.ajax({
                type:'POST',
                url: '/sms/store',
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                data: {
                    id : smsId,
                    title : title,
                    message : message,
                },
                success:function(response){
                    if (response.status == 201) {
                        toastr.success('SMS Added.');
                    } else {
                        toastr.error('Already added');
                    }
                }
            });
        });
        
        $("#smsDelete").click(function (e) {
            e.preventDefault();
            var smsId   = $("#sms option:selected").val();
            $.ajax({
                type:'POST',
                url: '/sms/destroy',
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                data: {
                    id : smsId
                },
                success:function(response){
                    $("#sms").val(0);
                    $("#title").val('');
                    $(".sms_message").val('');
                    toastr.error('SMS Deleted');
                }
            });
        });
	</script>
	@yield('scripts')
</body>

</html>
