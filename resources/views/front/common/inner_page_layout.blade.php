@include('front.common.header')
<div class="wrapper">
	@include('front.common.menu')
	@yield('content')
	<div class="position-relative">
		<div class="shape shape-bottom shape-fluid-x">
			<svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M0 48h2880V0h-720C1442.5 52 720 0 720 0H0v48z" fill="#2b2615"></path>
			</svg>
		</div>
	</div>
	@include('front.common.footer')
</div>
@include('front.include.functions')
@include('front.include.flash_message') 