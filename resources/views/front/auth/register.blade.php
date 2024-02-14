@extends('front.auth.auth-layout')
@section('content')
<form name="frontRegisterForm" id="frontRegisterForm" method="post" action="{{ route('register') }}">
	@csrf
	<div class="form-group">
		<label for="first_name">Full Name</label>
		<input class="form-control" name="name" id="name" type="text" value="{{ old('name') }}">                            
	</div>
	@if ($errors->has('name'))
	<p class="help-block text-danger">
		{{ $errors->first('name') }}
	</p>
	@endif

	<!-- <div class="form-group">
		<label for="last_name">Last Name</label>
		<input class="form-control" name="last_name" id="last_name" type="text" value="{{ old('last_name') }}">                            
	</div>
	@if ($errors->has('last_name'))
	<p class="help-block text-danger">
		{{ $errors->first('last_name') }}
	</p>
	@endif -->

	<!-- <div class="form-group">
		<label for="phone">Phone</label>
		<input class="form-control" name="phone" id="phone" type="text" value="{{ old('phone') }}">                            
	</div>
	@if ($errors->has('phone'))
	<p class="help-block text-danger">
		{{ $errors->first('phone') }}
	</p>
	@endif -->

	<div class="form-group">
		<label for="email">Email</label>
		<input class="form-control" name="email" id="email" type="text" value="{{ old('email') }}">                            
	</div>
	@if ($errors->has('email'))
	<p class="help-block text-danger">
		{{ $errors->first('email') }}
	</p>
	@endif

	<div class="form-group">
		<label for="password">Password</label>
		<input class="form-control" name="password" id="password" type="password" value="{{ old('password') }}">
	</div>
	@if ($errors->has('password'))
	<p class="help-block text-danger">
		{{ $errors->first('password') }}
	</p>
	@endif

	<div class="form-group">
		<label for="confirm_password">Confirm Password</label>
		<input class="form-control" name="confirm_password" id="confirm_password" type="password" value="{{ old('confirm_password') }}">
	</div>
	@if ($errors->has('confirm_password'))
	<p class="help-block text-danger">
		{{ $errors->first('confirm_password') }}
	</p>
	@endif

	<div class="text-center">
		<button type="submit" class="btn btn-primary btn-block enter-btn">Register</button>
	</div>

	<p class="sign-up text-center">Already have an Account?<a href="{{ route('login') }}"> Sign In</a></p>
	<p class="terms">By creating an account you are accepting our<a href="#"> Terms & Conditions</a></p>
</form>
@endsection
@push('custom-scripts')
<script type="text/javascript">
	$(document).ready(function () {		
		$("#frontRegisterForm").validate({
			rules: {
				name: {
					required: true,
				},
				/* last_name: {
					required: true,
				},
				phone: {
					required: true,
				}, */
				email: {
					required: true,
				},
				password: {
					required: true,		
				},
				confirm_password: {
					required: true,		
					equalTo : "#password"
				}
			},
			messages: {
				name: {
					required: 'Full name field is required',
				},
			/* 	last_name: {
					required: 'Last name field is required',
				},
				phone: {
					required: 'Phone number field is required',
				}, */
				email: {
					required: 'Email field is required',
				},
				password: {
					required: 'The password field is required.',
					minlength: 'The password must be at least 5 characters.'
				},
				confirm_password: {
					required: 'The confirm password field is required.',
					minlength: 'The confirm password must be at least 5 characters.',
					equalTo: 'Your password and confirmation password do not match.',
				}
			},
		});	
	});
</script>
@endpush