@include('admin.common.header')

<body class="hold-transition sidebar-mini layout-fixed">

	<div class="wrapper">
		@include('admin.common.menu')
		<div class="content-wrapper">
			@yield('content')
		</div>
		@include('admin.common.footer')
		@include('admin.include.functions')
		@include('admin.include.flash_message')