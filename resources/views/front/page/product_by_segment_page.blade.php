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
            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</section>
@stop