@extends('front.auth.auth-layout')

@section('content')
<p class="login-box-msg">Sign in to start your session</p>
@if(session()->has('error'))
<div class="alert alert-danger">
	{{ session()->get('error') }}
</div>
@endif
<form id="frontForgotPasswordForm" name="frontLoginForm" method="post" action="{{ route('forgot-password') }}">
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
	<div class="form-group  mb-0">
		<button type="submit" class="btn btn-primary">Submit</button>
	</div>
</form>
@endsection
@push('custom-scripts')
<script type="text/javascript">
	$(document).ready(function () {		
		$("#frontForgotPasswordForm").validate({
			rules: {
				email: {
					required: true,
				}
			},
			messages: {
				email: {
					required: 'Email field is required',
				}
			},
		});	
	});
</script>
@endpush
