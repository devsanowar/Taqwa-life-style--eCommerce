<!doctype html>
<html lang="en" class="{{ $theme->theme_style ?? ''}}">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<!--favicon-->
	<link rel="icon" href="{{ asset('backend') }}/assets/images/favicon-32x32.png" type="image/png"/>
	<!--plugins-->
	<title>@yield('title')</title>

    @include('admin.layouts.inc.style')
</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
		@include('admin.layouts.inc.sidebar')
		<!--end sidebar wrapper -->
		<!--start header -->
        @include('admin.layouts.inc.header')
		<!--end header -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			@yield('admin_content')
		</div>
		<!--end page wrapper -->
		@include('admin.layouts.inc.footer')
	</div>
	<!--end wrapper-->


	<!-- search modal -->
    @include('admin.layouts.inc.search-modal')
    <!-- end search modal -->




	<!--start switcher-->
	@include('admin.layouts.inc.switcher')
	<!--end switcher-->
	@include('admin.layouts.inc.script')
</body>

</html>
