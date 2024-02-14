@extends('admin.common.layout')
@section('content')
@php
$product_segments = old('product_segments', isset($product->product_segments) ?
$product->product_segments->pluck('segment_id')->toArray() : []);

$product_categories = old('product_categories', isset($product->product_categories) ?
$product->product_categories->pluck('category_id')->toArray() :
[]);

$product_companies = old('product_companies', isset($product->product_companies) ?
$product->product_companies->pluck('company_id')->toArray() :
[]);

$actionUrl = ((isset($product)) && $product->product_id) ? route('admin.products.update',
$product->product_id) : route('admin.products.store');
$method_field =((isset($product)) && $product->product_id) ? method_field('PUT') : method_field('POST');
$pageTitle = ((isset($product)) && $product->product_id) ? "Edit" : "Add";
@endphp
<!-- Content Header (Page header) -->
<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <h1 class="m-0 text-dark">Product Management</h1>
         </div><!-- /.col -->
         <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="{{route('admin.get.dashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{route('admin.products.index')}}">Products</a></li>
               <li class="breadcrumb-item active">Product {{$pageTitle}}</li>
            </ol>
         </div><!-- /.col -->
      </div><!-- /.row -->
   </div><!-- /.container-fluid -->
</div>

<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <form id="productForm" action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data">
         {{ $method_field }}
         @csrf
         <input type="hidden" id="product_id" name="product_id" value="{{ $product->product_id ?? ''}}">
         <!-- FIRST INFORMATION  - START -->
         <div class="row">
            <!-- left column -->
            <div class="col-md-12">
               <!-- general form elements -->
               <div class="card card-parimary">
                  <div class="card-header">
                     <h3 class="card-title">{{$pageTitle}} Product</h3>
                  </div>
                  <div class="card-body">
                     <div class="row">
                        <div class="col-sm">
                           <div class="form-group">
                              <label>Product Name <span class="text-danger">*</span></label>
                              <input type="text"
                                 class="form-control {{$errors->has('product_name') ? 'is-invalid' : ''}}"
                                 id="product_name" placeholder="Enter Product Name" name="product_name"
                                 value="{{ old('product_name', $product->product_name ?? '' ) }}" autocomplete="off">
                              @if ($errors->has('product_name'))
                              <div class="invalid-feedback">
                                 <i class="fa fa-times-circle-o"></i> {{ $errors->first('product_name') }}
                              </div>
                              @endif
                           </div>
                        </div>

                        <div class="col-sm">
                           <div class="form-group">
                              <label>Principal <span class="text-danger">*</span></label>
                              <input type="text" class="form-control {{$errors->has('principal') ? 'is-invalid' : ''}}"
                                 id="principal" placeholder="Enter Principal" name="principal"
                                 value="{{ old('principal', $product->principal ?? '' ) }}" autocomplete="off">
                              @if ($errors->has('principal'))
                              <div class="invalid-feedback">
                                 <i class="fa fa-times-circle-o"></i> {{ $errors->first('principal') }}
                              </div>
                              @endif
                           </div>
                        </div>

                        <div class="col-sm">
                           <div class="form-group">
                              <label>Country <span class="text-danger">*</span></label>
                              <select
                                 class="form-control select2-country {{$errors->has('country') ? 'is-invalid' : ''}}"
                                 id="country" name="country">
                                 <option></option>
                                 @foreach ($country_list as $country)
                                 <option value="{{$country}}" @selected(old('country', $product->country ?? ''
                                    )==$country)>{{$country}}</option>
                                 @endforeach
                              </select>
                              @if ($errors->has('country'))
                              <div class="invalid-feedback">
                                 <i class="fa fa-times-circle-o"></i> {{ $errors->first('country') }}
                              </div>
                              @endif
                           </div>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-sm">
                           <div class="form-group">
                              <label>Segment <span class="text-danger">*</span></label>

                              <select
                                 class="form-control select2-product-segments {{$errors->has('product_segments') ? 'is-invalid' : ''}}"
                                 id="product_segments" name="product_segments[]" multiple="multiple">
                                 <option value=""></option>
                                 @foreach ($segment_list as $segment)
                                 {{-- <option value="{{$segment->segment_id}}" @selected(in_array($segment->segment_id,
                                 old('product_segments',$product_segments)))>{{$segment->segment_name}}</option> --}}
                                 <option value="{{$segment->segment_id}}">{{$segment->segment_name}}</option>
                                 @endforeach
                              </select>
                              @if ($errors->has('product_segments'))
                              <div class="invalid-feedback">
                                 <i class="fa fa-times-circle-o"></i> {{ $errors->first('product_segments') }}
                              </div>
                              @endif
                           </div>
                        </div>

                        <div class="col-sm">
                           <div class="form-group">
                              <label>Category <span class="text-danger">*</span></label>
                              <select
                                 class="form-control select2-product-categories {{$errors->has('product_categories') ? 'is-invalid' : ''}}"
                                 id="product_categories" name="product_categories[]" multiple="multiple">
                                 <option value=""></option>
                                 @foreach ($category_list as $category)
                                 {{-- <option value="{{$category->category_id}}"
                                 @selected(in_array($category->category_id,
                                 old('product_categories',$product_categories)))
                                 >{{$category->category_name}}</option> --}}
                                 <option value="{{$category->category_id}}">{{$category->category_name}}</option>
                                 @endforeach
                              </select>
                              @if ($errors->has('product_categories'))
                              <div class="invalid-feedback">
                                 <i class="fa fa-times-circle-o"></i> {{ $errors->first('product_categories') }}
                              </div>
                              @endif
                           </div>
                        </div>

                        <div class="col-sm">
                           <div class="form-group">
                              <label>Company <span class="text-danger">*</span></label>
                              <select
                                 class="form-control select2-product-companies {{$errors->has('product_companies') ? 'is-invalid' : ''}}"
                                 id="product_companies" name="product_companies[]" multiple="multiple">
                                 <option value=""></option>
                                 @foreach ($company_list as $company)
                                 {{-- <option value="{{$company->company_id}}"
                                 @selected(in_array($company->company_id,
                                 old('product_companies',$product_companies)))
                                 >{{$company->category_name}}</option> --}}
                                 <option value="{{$company->company_id}}">{{$company->company_name}}</option>
                                 @endforeach
                              </select>
                              @if ($errors->has('product_companies'))
                              <div class="invalid-feedback">
                                 <i class="fa fa-times-circle-o"></i> {{ $errors->first('product_companies') }}
                              </div>
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
               <a href="{{ route('admin.products.index') }}" class="btn btn-danger">Cancel</a>
            </div>
         </div>
      </form>
   </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
<script type="text/javascript">
   $( document ).ready(function() {
      $("#productForm1").validate({
			rules: {
            "product_name": {
            required: true,
               },
            /*"principal": {
            required: true,
            },
            "country": {
            required: true,
            },
             "product_segments[]": {
            required: true,
            },
            "product_categories[]": {
            required: true,
            }, */
            "product_companies[]": {
            required: true,
            },
			},
			messages: {
				"product_name": {
					required: 'Product name field is required',
				},
            /*"principal": {
            required: 'Principal field is required',
            },
            "country": {
            required: 'Country field is required',
            },
             "product_segments[]": {
            required: 'Segment field is required',
            },
            "product_categories[]": {
            required: 'Categorie field is required',
            }, */
            "product_companies[]": {
            required: 'Company field is required',
            },
			},
		});	

      $('.select2-country').select2({
      placeholder: "Select country",
      //allowClear: true
      })

      // with selected value
      /*$('.select2-country').select2({
      placeholder: "Select country",
      //allowClear: true
      }).val("Algeria").trigger('change'); */


      // without multiple selected value  
      /* $('.select2-product-segments').select2({
      placeholder: "Select segment",
      //allowClear: true
      }) */

      // with multiple selected value
      $('.select2-product-segments').select2({
      placeholder: "Select segment",
     //allowClear: true
      }).val(@json($product_segments)).trigger('change');


      // without multiple selected value
      /*$('.select2-product-categories').select2({
      placeholder: "Select category",
      //allowClear: true
      }) */
      // with multiple selected value

      /* $('.select2-product-categories').select2({
      placeholder: "Select category",
      //allowClear: true
      }).val([1,2]).trigger('change'); */

      $('.select2-product-categories').select2({
      placeholder: "Select category",
      //allowClear: true
      }).val(@json($product_categories)).trigger('change');

      $('.select2-product-companies').select2({
      placeholder: "Select company",
      //allowClear: true
      }).val(@json($product_companies)).trigger('change');
   });
   //jQuery('.table-striped td:nth-child(2)').hide();
   /* select product_name,count(*)
   from lb9_products
   group by product_name
   having count(product_name)>1 */
</script>
@stop