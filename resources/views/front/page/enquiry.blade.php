@extends('front.common.inner_page_layout')
@section('content')
<section class="main-section ">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="sec-title">{{$title}}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <!-- Text -->
                <p class="text-muted mb-6 mb-md-0">
                    {!! $description !!}
                </p>
                <form id="enquiryForm" action="{{ route('front.post.enquiry') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name"
                            value="{{ old('name', '' ) }}">
                        @if ($errors->has('name'))
                        <div>
                            {{ $errors->first('name') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter Phone Number"
                            value="{{ old('phone', '' ) }}">
                        @if ($errors->has('phone'))
                        <div>
                            {{ $errors->first('phone') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="text" class="form-control" name="email" id="email"
                            placeholder="Enter Email Address" value="{{ old('email', '' ) }}">
                        @if ($errors->has('email'))
                        <div>
                            {{ $errors->first('email') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="product_looking_for">Product Looking For</label>
                        <input type="text" class="form-control" name="product_looking_for" id="product_looking_for"
                            placeholder="Enter Product Looking For" value="{{ old('product_looking_for', '' ) }}">
                        @if ($errors->has('product_looking_for'))
                        <div>
                            {{ $errors->first('product_looking_for') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="end_use_application">End Use Application</label>
                        <input type="text" class="form-control" name="end_use_application" id="end_use_application"
                            placeholder="Enter End Use Application" value="{{ old('end_use_application', '' ) }}">
                        @if ($errors->has('end_use_application'))
                        <div>
                            {{ $errors->first('end_use_application') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="company_name">Company Name</label>
                        <input type="text" class="form-control" name="company_name" id="company_name"
                            placeholder="Enter Company Name" value="{{ old('company_name', '' ) }}">
                        @if ($errors->has('company_name'))
                        <div>
                            {{ $errors->first('company_name') }}
                        </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="company_address">Company Address</label>
                        <textarea class="form-control" name="company_address" id="company_address"
                            placeholder="Enter Company Address" rows="3">{{ old('company_address', '' ) }}</textarea>
                        @if ($errors->has('company_address'))
                        <div>
                            {{ $errors->first('company_address') }}
                        </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="additional_remark">Additional Remark</label>
                        <textarea class="form-control" name="additional_remark" id="additional_remark"
                            placeholder="Enter Additional Remark"
                            rows="3">{{ old('additional_remark', '' ) }}</textarea>
                        @if ($errors->has('additional_remark'))
                        <div>
                            {{ $errors->first('additional_remark') }}
                        </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</section>
@stop