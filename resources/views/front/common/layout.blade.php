@include('front.common.header')
<div class="wrapper">
	@include('front.common.menu')
	@yield('content')
	@include('front.common.footer')
</div>
@include('front.include.functions')
@include('front.include.flash_message')