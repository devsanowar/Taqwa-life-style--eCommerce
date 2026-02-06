<!-- Bootstrap JS -->
	<script src="{{ asset('backend') }}/assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="{{ asset('backend') }}/assets/js/jquery.min.js"></script>
	<script src="{{ asset('backend') }}/assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="{{ asset('backend') }}/assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="{{ asset('backend') }}/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<script src="{{ asset('backend') }}/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="{{ asset('backend') }}/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
	<script src="{{ asset('backend') }}/assets/plugins/chartjs/js/chart.js"></script>
	<script src="{{ asset('backend') }}/assets/plugins/sparkline-charts/jquery.sparkline.min.js"></script>
	<script src="{{ asset('backend') }}/assets/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
	<script src="{{ asset('backend') }}/assets/plugins/jquery-knob/excanvas.js"></script>
	<script src="{{ asset('backend') }}/assets/plugins/jquery-knob/jquery.knob.js"></script>

	<script>
		  $(function() {
			  $(".knob").knob();
		  });
	</script>
	<script src="{{ asset('backend') }}/assets/js/index.js"></script>
	<!--app JS-->
	<script src="{{ asset('backend') }}/assets/js/app.js"></script>
	<script>
		new PerfectScrollbar(".app-container")
	</script>


    <script src="{{ asset('backend') }}/assets/js/toastr.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/colpick.js"></script>


    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if (session('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif

        @if (session('info'))
            toastr.info("{{ session('info') }}");
        @endif
    </script>
    <script>
        	$('#picker').colpick();
    </script>


    @stack('scripts')
