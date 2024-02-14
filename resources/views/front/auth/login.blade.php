@extends('front.auth.auth-layout')

@section('content')
<p class="login-box-msg">Sign in to start your session</p>
@if(session()->has('error'))
<div class="alert alert-danger">
	{{ session()->get('error') }}
</div>
@endif
@if(session()->has('throttle'))
<div class="alert alert-danger">
	{{ session()->get('throttle') }}
</div>
@endif
<h1>Hello</h1>
<form id="frontLoginForm" name="frontLoginForm" method="post" action="{{ route('login') }}">
	@csrf   
	<div class="form-group">
		<label for="email">Email</label>
		<input class="form-control" name="email" type="text" value="{{ old('email') }}"">                            
	</div>
	@if ($errors->has('email'))
	<p class="help-block text-danger">
		{{ $errors->first('email') }}
	</p>
	@endif
	<div class="form-group">
		<label for="password">Password</label>
		<input class="form-control" name="password" type="password">
	</div>
	@if ($errors->has('email'))
	<p class="help-block text-danger">
		{{ $errors->first('email') }}
	</p>
	@endif
	<div class="form-group">
		<div class="custom-control custom-checkbox">
			<input type="checkbox" class="custom-control-input" id="remember_me" name="remember_me" value="1" {{ old('remember_me') ? 'checked' : '' }}>
			<label class="custom-control-label" for="remember_me">Remember me </label>
		</div>
	</div>
	<div class="form-group  mb-0">
		<button type="submit" class="btn btn-primary">Login</button>
	</div>
	 <a class="forgot-link ml-auto" href="{{route('forgot-password-view')}}">Forgot password?</a>
</form>
@endsection
@push('custom-scripts')
<script type="text/javascript">
	$(document).ready(function () {		
		$("#frontLoginForm").validate({
			rules: {
				email: {
					required: true,
				},
				password: {
					required: true,
					minlength: 5
				}
			},
			messages: {
				email: {
					required: 'Email field is required',
				},
				password: {
					required: 'The password field is required.',
					minlength: 'The password must be at least 5 characters!'
				}
			},
		});	
	});
</script>
@endpush
