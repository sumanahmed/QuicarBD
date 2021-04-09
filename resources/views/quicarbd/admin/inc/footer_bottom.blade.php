
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
	<script>
		var image_base_path = "http://quicarbd.com/";		
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
	@yield('scripts')
</body>

</html>
