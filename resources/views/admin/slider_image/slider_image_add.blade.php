@extends('admin.common.layout')
@section('content')
@php
$actionUrl = ((isset($slider_image)) && $slider_image->slider_id) ? route('admin.slider-images.update',
$slider_image->slider_id) : route('admin.slider-images.store');
$method_field =((isset($slider_image)) && $slider_image->slider_id) ? method_field('PUT') : method_field('POST');
$pageTitle = ((isset($slider_image)) && $slider_image->slider_id) ? "Edit" : "Add";
@endphp
<!-- Content Header (Page header) -->
<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Slider Image Management</h1>
         </div><!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{route('admin.get.dashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{route('admin.slider-images.index')}}">Slider Images</a></li>
               <li class="breadcrumb-item active">Slider Image {{$pageTitle}}</li>
            </ol>
         </div><!-- /.col -->
      </div><!-- /.row -->
   </div><!-- /.container-fluid -->
</div>

<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <form id="sliderImageForm" action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data">
         {{ $method_field }}
         @csrf
         <input type="hidden" id="slider_id" name="slider_id" value="{{ $slider_image->slider_id ?? ''}}">
         <!-- FIRST INFORMATION  - START -->
         <div class="row">
            <!-- left column -->
            <div class="col-md-12">
               <!-- general form elements -->
               <div class="card card-parimary">
                  <div class="card-header">
                     <h3 class="card-title">{{$pageTitle}} Slider Image</h3>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="col-sm">
                           <div class="form-group">
                              <label>Title <span class="text-danger">*</span></label>
                              <input type="text" class="form-control {{$errors->has('title') ? 'is-invalid' : ''}}"
                                 id="title" placeholder="Enter Title" name="title"
                                 value="{{ old('title', $slider_image->title ?? '' ) }}" autocomplete="off">
                              @if ($errors->has('title'))
                              <div class="invalid-feedback">
                                 <i class="fa fa-times-circle-o"></i> {{ $errors->first('title') }}
                              </div>
                              @endif
                           </div>
                        </div>
                        <div class="col-sm">
                           <div class="form-group">
                              <label>Description </label>
                              <textarea type="text"
                                 class="form-control  {{$errors->has('description') ? 'is-invalid' : ''}}"
                                 id="description" placeholder="Enter Meta Keywords" name="description"
                                 autocomplete="off" maxlength="260"
                                 rows="5">{!! old('description', $slider_image->description ?? '' ) !!}</textarea>
                              @if ($errors->has('description'))
                              <div class="invalid-feedback">
                                 <i class="fa fa-times-circle-o"></i> {{ $errors->first('description') }}
                              </div>
                              @endif
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-3">
                           <div class="form-group">
                              <label for="image">Slider Image</label>
                              <div class="custom-file">
                                 <input type="file"
                                    class="custom-file-input {{$errors->has('slider_image') ? 'is-invalid' : ''}}"
                                    id="slider_image" name="slider_image">
                                 <label class="custom-file-label" for="slider_image">Choose file</label>
                                 @if($errors->has('slider_image'))
                                 <div class="invalid-feedback">
                                    <i class="fa fa-times-circle-o"></i> {{ $errors->first('slider_image') }}
                                 </div>
                                 @endif
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-3">
                           <div class="company-logo">
                              @if(isset($slider_image) && ($slider_image->display_slider_image) != "")
                              <input type="hidden" value="0" name="isImgDel" id="isImgDel">
                              @if(isset($slider_image) && ($slider_image->display_slider_image) != "")
                              <div class="del-img" id="delimg">
                                 <img class="img-thumbnail thums-img" id="imageview"
                                    src="{{ $slider_image->display_slider_image}}">
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
               <a href="{{ route('admin.slider-images.index') }}" class="btn btn-danger">Cancel</a>
            </div>
         </div>
      </form>
   </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
<script type="text/javascript">
   $( document ).ready(function() {
      $("#slider_image").change(function(){
      imagesPreview(this);
      $('#delimg').show();
      });
      $("#sliderImageForm").validate({
			rules: {
				title: {
					required: true,
                },
			},
			messages: {
				title: {
					required: 'Title field is required',
				},
			},
		});	
   });

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