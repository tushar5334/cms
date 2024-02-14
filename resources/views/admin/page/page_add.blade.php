@extends('admin.common.layout')
@section('content')
@php
$actionUrl = ((isset($page)) && $page->page_id) ? route('admin.pages.update',
$page->page_id) : route('admin.pages.store');
$method_field =((isset($page)) && $page->page_id) ? method_field('PUT') : method_field('POST');
$pageTitle = ((isset($page)) && $page->page_id) ? "Edit" : "Add";
@endphp
<!-- Content Header (Page header) -->
<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Page Management</h1>
         </div><!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{route('admin.get.dashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{route('admin.pages.index')}}">Pages</a></li>
               <li class="breadcrumb-item active">Page {{$pageTitle}}</li>
            </ol>
         </div><!-- /.col -->
      </div><!-- /.row -->
   </div><!-- /.container-fluid -->
</div>

<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <form id="cmsForm" action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data">
         {{ $method_field }}
         @csrf
         <input type="hidden" id="page_id" name="page_id" value="{{ $page->page_id ?? ''}}">
         <!-- FIRST INFORMATION  - START -->
         <div class="row">
            <!-- left column -->
            <div class="col-md-12">
               <!-- general form elements -->
               <div class="card card-parimary">
                  <div class="card-header">
                     <h3 class="card-title">{{$pageTitle}} Page</h3>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="col-sm">
                           <div class="form-group">
                              <label>Title <span class="text-danger">*</span></label>
                              <input type="text" class="form-control {{$errors->has('title') ? 'is-invalid' : ''}}"
                                 id="title" placeholder="Enter Title" name="title"
                                 value="{{ old('title', $page->title ?? '' ) }}" autocomplete="off">
                              @if ($errors->has('title'))
                              <div class="invalid-feedback">
                                 <i class="fa fa-times-circle-o"></i> {{ $errors->first('title') }}
                              </div>
                              @endif
                           </div>
                        </div>
                        <div class="col-sm">
                           <div class="form-group">
                              <label>Meta Title </label>
                              <input type="text" class="form-control {{$errors->has('meta_title') ? 'is-invalid' : ''}}"
                                 id="meta_title" placeholder="Enter Meta Title" name="meta_title"
                                 value="{{ old('meta_title', $page->meta_title ?? '' ) }}" autocomplete="off"
                                 maxlength="65">
                              @if ($errors->has('meta_title'))
                              <div class="invalid-feedback">
                                 <i class="fa fa-times-circle-o"></i> {{ $errors->first('meta_title') }}
                              </div>
                              @endif
                           </div>
                        </div>
                        <div class="col-sm">
                           <div class="form-group">
                              <label>Name<span class="text-danger">*</span></label>
                              <input type="text" class="form-control  {{$errors->has('name') ? 'is-invalid' : ''}}"
                                 id="name" placeholder="Enter Name" name="name" autocomplete="off"
                                 value="{{ old('name', $page->name ?? '' ) }}">
                              @if ($errors->has('name'))
                              <div class="invalid-feedback">
                                 <i class="fa fa-times-circle-o"></i> {{ $errors->first('name') }}
                              </div>
                              @endif
                           </div>
                        </div>
                        <div class="col-sm">
                           <div class="form-group">
                              <label>Select Page Type</label><br>
                              <div class="icheck-primary d-inline">
                                 <input type="radio" id="static" name="is_static" value="0"
                                    {{ old('status',isset($page->is_static) ? $page->is_static : '') == "0" ? 'checked' : '' }}>
                                 <label for="static">
                                    Static
                                 </label>
                              </div>
                              <div class="icheck-primary d-inline">
                                 <input type="radio" id="dynamic" name="is_static" value="1"
                                    {{ old('status',isset($page->is_static) ? $page->is_static : '') == "1" ? 'checked' : '' }}>
                                 <label for="dynamic">
                                    Dynamic
                                 </label>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class=row>
                        <div class="col-sm">
                           <div class="form-group">
                              <label>Meta Keywords </label>
                              <textarea type="text"
                                 class="form-control  {{$errors->has('meta_keywords') ? 'is-invalid' : ''}}"
                                 id="meta_keywords" placeholder="Enter Meta Keywords" name="meta_keywords"
                                 autocomplete="off"
                                 rows="5">{!! old('meta_keywords', $page->meta_keywords ?? '' ) !!}</textarea>
                              @if ($errors->has('meta_keywords'))
                              <div class="invalid-feedback">
                                 <i class="fa fa-times-circle-o"></i> {{ $errors->first('meta_keywords') }}
                              </div>
                              @endif
                           </div>
                        </div>
                        <div class="col-sm">
                           <div class="form-group">
                              <label>Meta Description </label>
                              <textarea type="text"
                                 class="form-control  {{$errors->has('meta_description') ? 'is-invalid' : ''}}"
                                 id="meta_description" placeholder="Enter Meta Keywords" name="meta_description"
                                 autocomplete="off" maxlength="260"
                                 rows="5">{!! old('meta_description', $page->meta_description ?? '' ) !!}</textarea>
                              @if ($errors->has('meta_description'))
                              <div class="invalid-feedback">
                                 <i class="fa fa-times-circle-o"></i> {{ $errors->first('meta_description') }}
                              </div>
                              @endif
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-12">
                           <div class="form-group">
                              <label>Page Content</label>
                              <textarea name="description" id="editor"
                                 class="ckediter form-control {{$errors->has('description') ? 'is-invalid' : ''}}">{!! old('description', $page->description ?? '' ) !!}</textarea>
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
                              <label for="image">Page Header Image</label>
                              <div class="custom-file">
                                 <input type="file"
                                    class="custom-file-input {{$errors->has('page_header_image') ? 'is-invalid' : ''}}"
                                    id="page_header_image" name="page_header_image">
                                 <label class="custom-file-label" for="page_header_image">Choose file</label>
                                 @if($errors->has('page_header_image'))
                                 <div class="invalid-feedback">
                                    <i class="fa fa-times-circle-o"></i> {{ $errors->first('page_header_image') }}
                                 </div>
                                 @endif
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-3">
                           <div class="company-logo">
                              @if(isset($page) && ($page->display_header_image) != "")
                              <input type="hidden" value="0" name="isImgDel" id="isImgDel">
                              @if(isset($page) && ($page->display_header_image) != "")
                              <div class="del-img" id="delimg">
                                 <img class="img-thumbnail thums-img" id="imageview"
                                    src="{{ $page->display_header_image}}">
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
               <a href="{{ route('admin.pages.index') }}" class="btn btn-danger">Cancel</a>
            </div>
         </div>
      </form>
   </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
<script type="text/javascript">
   $( document ).ready(function() {
      $("#page_header_image").change(function(){
      imagesPreview(this);
      $('#delimg').show();
      });

      CKEDITOR.replace( 'description', {
         toolbarGroups : [
         { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
         { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
         { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
         { name: 'forms', groups: [ 'forms' ] },
         { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
         { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
         { name: 'links', groups: [ 'links' ] },
         { name: 'insert', groups: [ 'insert' ] },
         { name: 'styles', groups: [ 'styles' ] },
         { name: 'colors', groups: [ 'colors' ] },
         { name: 'tools', groups: [ 'tools' ] },
         { name: 'others', groups: [ 'others' ] },
         { name: 'about', groups: [ 'about' ] }
         ],
         removeButtons : 'ExportPdf,Preview,Print,Form,Checkbox,Radio,TextField,Textarea,Select,Button,HiddenField,ImageButton,Flash,Smiley,PageBreak,About,Language,Iframe',
         filebrowserUploadUrl: "{{route('admin.post.ckeditor.upload', ['_token' => csrf_token() ])}}",
         filebrowserUploadMethod: 'form',
         removeDialogTabs:'image:advanced;image:Link;',
         removePlugins :'cloudservices',
      });
      $("#cmsForm").validate({
			rules: {
				title: {
					required: true,
                },
				/* meta_title: {
					required: true,
				},
				meta_keywords: {
					required: true,
				}, */
				name: {
					required: true,
				},
			},
			messages: {
				title: {
					required: 'Title field is required',
				},
				/* meta_title: {
					required: 'Meta Title field is required',
				},
				meta_keywords: {
					required: 'Meta Keywords field is required',
				}, */
				name: {
					required: 'Name field is required',
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