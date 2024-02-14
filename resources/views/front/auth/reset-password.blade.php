@extends('front.auth.auth-layout')

@section('content')
<p class="login-box-msg">Sign in to start your session</p>
@if(session()->has('error'))
<div class="alert alert-danger">
	{{ session()->get('error') }}
</div>
@endif
<form id="frontResetPasswordForm"  method="post" >
        {{ csrf_field() }}                                           
        <input type="hidden" class="form-login" name="token" value="{{ collect(request()->segments())->last() }}">
        <div class="form-group">
		<label for="password">Password</label>
		<input class="form-control" name="password" id="password" type="password" value="{{ old('password') }}"">                            
        </div>
        @if ($errors->has('password'))
        <p class="help-block text-danger">
            {{ $errors->first('password') }}
        </p>
        @endif

        <div class="form-group">
		<label for="confirm_password">Confirm Password</label>
		<input class="form-control" name="confirm_password" id="confirm_password" type="password" value="{{ old('confirm_password') }}"">                            
        </div>
        @if ($errors->has('confirm_password'))
        <p class="help-block text-danger">
            {{ $errors->first('confirm_password') }}
        </p>
        @endif
        <div class="row">
            <div class="col-md-12 mb-3">
            <button type="submit" class="btn btn-primary">RESET PASSWORD</button>
            <a href="{{ route('login') }}" class="btn btn-default">Cancel</a>
            </div>
        </div>   
</form>
@endsection
@push('custom-scripts')
<script type="text/javascript">
	$(document).ready(function () {		
		$("#frontResetPasswordForm").validate({
			rules: {
				password: {
					required: true,
                    minlength: 5,
				},
				confirm_password: {
					required: true,
                    minlength: 5,		
					equalTo : "#password"
				}
			},
			messages: {
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
