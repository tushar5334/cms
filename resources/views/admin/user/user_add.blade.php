@extends('admin.common.layout')
@section('content')
@php
$actionUrl = ((isset($user)) && $user->user_id) ? route('admin.users.update',
$user->user_id) : route('admin.users.store');
$method_field =((isset($user)) && $user->user_id) ? method_field('PUT') : method_field('POST');
$pageTitle = ((isset($user)) && $user->user_id) ? "Edit" : "Add";
@endphp
<!-- Content Header (Page header) -->
<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">User Management</h1>
         </div><!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{route('admin.get.dashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{route('admin.users.index')}}">Users</a></li>
               <li class="breadcrumb-item active">User {{$pageTitle}}</li>
            </ol>
         </div><!-- /.col -->
      </div><!-- /.row -->
   </div><!-- /.container-fluid -->
</div>

<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <form id="adminUserForm" action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data">
         {{ $method_field }}
         @csrf
         <input type="hidden" id="user_id" name="user_id" value="{{ $user->user_id ?? ''}}">
         <!-- FIRST INFORMATION  - START -->
         <div class="row">
            <!-- left column -->
            <div class="col-md-12">
               <!-- general form elements -->
               <div class="card card-parimary">
                  <div class="card-header">
                     <h3 class="card-title">{{$pageTitle}} User</h3>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="col-sm">
                           <div class="form-group">
                              <label>Name <span class="text-danger">*</span></label>
                              <input type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}"
                                 id="name" placeholder="Enter Name" name="name"
                                 value="{{ old('name', $user->name ?? '')}}" autocomplete="off">
                              @if ($errors->has('name'))
                              <div class="invalid-feedback">
                                 <i class="fa fa-times-circle-o"></i> {{ $errors->first('name') }}
                              </div>
                              @endif
                           </div>
                        </div>
                        <div class="col-sm">
                           <div class="form-group">
                              <label>Email <span class="text-danger">*</span></label>
                              <input type="text" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}"
                                 id="email" placeholder="Enter email" name="email"
                                 value="{{old('email', $user->email ?? '')}}" autocomplete="off">
                              @if ($errors->has('email'))
                              <div class="invalid-feedback">
                                 <i class="fa fa-times-circle-o"></i> {{ $errors->first('email') }}
                              </div>
                              @endif
                           </div>
                        </div>
                        <div class="col-sm">
                           <div class="form-group">
                              <label>Password</label>
                              <input type="password"
                                 class="form-control  {{$errors->has('password') ? 'is-invalid' : ''}}" id="password"
                                 placeholder="Enter Password" name="password" autocomplete="off">
                              @if ($errors->has('password'))
                              <div class="invalid-feedback">
                                 <i class="fa fa-times-circle-o"></i> {{ $errors->first('password') }}
                              </div>
                              @endif
                           </div>
                        </div>
                        <div class="col-sm">
                           <div class="form-group">
                              <label>Confirm Password</label>
                              <input type="password"
                                 class="form-control  {{$errors->has('confirm_password') ? 'is-invalid' : ''}}"
                                 id="confirm_password" placeholder="Enter confirm password" name="confirm_password"
                                 autocomplete="off">
                              @if ($errors->has('confirm_password'))
                              <div class="invalid-feedback">
                                 <i class="fa fa-times-circle-o"></i> {{ $errors->first('confirm_password') }}
                              </div>
                              @endif
                           </div>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-3">
                           <div class="form-group">
                              <label for="image">Profile Picture</label>
                              <div class="custom-file">
                                 <input type="file"
                                    class="custom-file-input {{$errors->has('profile_picture') ? 'is-invalid' : ''}}"
                                    id="profile_picture" name="profile_picture">
                                 <label class="custom-file-label" for="profile_picture">Choose file</label>
                                 @if($errors->has('profile_picture'))
                                 <div class="invalid-feedback">
                                    <i class="fa fa-times-circle-o"></i> {{ $errors->first('profile_picture') }}
                                 </div>
                                 @endif
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-3">
                           <div class="company-logo">
                              @if(isset($user) && ($user->display_picture) != "")
                              <input type="hidden" value="0" name="isImgDel" id="isImgDel">
                              @if(isset($user) && ($user->display_picture) != "")
                              <div class="del-img" id="delimg">
                                 <img class="img-thumbnail thums-img" id="imageview" src="{{ $user->display_picture}}">
                                 <a href="javascript:void(0);" onclick="return theImgDelete();" class="remove-icon">
                                    <i class="fas fa-times-circle"></i>
                                 </a>
                              </div>
                              @else
                              <img class="img-thumbnail thums-img" id="imageview"
                                 src="{{ asset('/images/avatar5.png')}}">
                              @endif
                              @else
                              <img id="imageview">
                              @endif
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- /.card -->
            </div>
         </div>

         <!-- /.row -->
         <!-- FIRST INFORMATION  - END -->
         <div class="row">
            <div class="col-md-12 mb-3">
               <button type="submit" class="btn btn-primary">Submit</button>&nbsp;
               <a href="{{ route('admin.users.index') }}" class="btn btn-danger">Cancel</a>
            </div>
         </div>
      </form>
   </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<script type="text/javascript">
   $( document ).ready(function() {
      $("#profile_picture").change(function(){
         imagesPreview(this);
         $('#delimg').show();
      });
      $("#adminUserForm").validate({
			rules: {
				name: {
					required: true,
            },
				email: {
					required: true,
				},
				password: {
					required: isPasswordPresent,		
				},
				confirm_password: {
					required: isPasswordPresent,		
					equalTo : "#password"
				}
			},
			messages: {
				name: {
					required: 'Full name field is required',
				},
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
   function isPasswordPresent() {
      return $('#password').val().length > 0;
   }
   function theImgDelete(){
      $('#delimg').hide();
      $('#isImgDel').val('1');
   }
   function imagesPreview(input) {
      if (input.files && input.files[0]) {
         var reader = new FileReader();
         reader.onload = function (e) {
            $('#imageview').attr('src', e.target.result);
            $('#imageview').addClass("img-thumbnail thums-img");
         }
         reader.readAsDataURL(input.files[0]);
      }
   }
</script>
@stop