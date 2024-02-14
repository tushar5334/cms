<footer class="py-8 py-md-11">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-4 col-lg-3">
                <!-- Brand -->
                <img src="{{asset('/front/images/logo2.png')}}" width="200" alt="..."
                    class="footer-brand img-fluid mb-2">
                <!-- Text -->
                <p>
                    India's Leading Importer of Global Ingredients & Authorized Distributors of World renowned
                    Principals
                    serving to Pharma, Food, Nutraceuticals, Cosmetics, Paint and other industries since 1959.
                </p>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <!-- Heading -->
                <h6 class="fw-bold text-uppercase text-gray-700">
                    Site Map
                </h6>

                <!-- List -->
                <ul class="list-unstyled text-muted mb-6 mb-md-8 mb-lg-0">
                    <li class="mb-2">
                        <a href="{{url('/')}}">
                            Home
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{url('/about')}}">
                            About Us
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{url('/principal')}}">
                            Principals
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{url('/by-segment')}}">
                            Products
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{url('/application-lab')}}">
                            Application Lab
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <!-- Heading -->
                <h6 class="fw-bold text-uppercase text-gray-700">
                    Site Map
                </h6>

                <!-- List -->
                <ul class="list-unstyled text-muted mb-6 mb-md-8 mb-lg-0">
                    <li class="mb-2">
                        <a href="{{url('/kawman-pharma')}}">
                            Kawman Pharma
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{url('/contact')}}">
                            Contact Us
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{url('/enquiry')}}">
                            Enquiry
                        </a>
                    </li>

                    <li class="mb-2">
                        <a href="{{url('/by-category')}}">
                            By Category
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{url('/by-segment')}}">
                            By Segment
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-6 col-md-4 offset-md-4 col-lg-2 offset-lg-0">
                <!-- Heading -->
                <h6 class="fw-bold text-uppercase text-gray-700">
                    Connect
                </h6>

                <!-- List -->
                <ul class="list-unstyled text-muted mb-0">
                    <li class="mb-3">
                        <a href="javascript:void(0);">
                            Facebook
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="javascript:void(0);">
                            Instagram
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="javascript:void(0);">
                            Linkdin
                        </a>
                    </li>
                    <li class="mb-3">
                        <a href="javascript:void(0);">
                            Whatsaap
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <!-- Heading -->
                <h6 class="fw-bold text-uppercase text-gray-700">
                    Our Head Office
                </h6>
                <p>41, Raghunayakulu Street,
                Chennai - 600003,Indiai
                Ph: +91 44 44212345</p>
                <p><a href="tel:info@kpmanish.com">info@kpmanish.com</a></p>
            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</footer>

<script src="{{asset('/front/js/jquery.min.js')}}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
<script src="{{asset('/front/js/owl.carousel.min.js')}}"></script>
<!-- SweetAlert2 -->
<script src="{{asset('/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{asset('/front/js/jquery.validate.min.js')}}"></script>
<script>
    $('.testimonials').owlCarousel({
			loop:false,
			margin:40,
			center: true,
			nav:false,
			responsive:{
				0:{
					items:1
				},
				600:{
					items:2
				},
				1000:{
					items:4
				}
			}
		});
		$('.banner').owlCarousel({
			loop:true,
			margin:0,
			center: true,
			nav:false,
			dots: true,
			items:1
		});
        $( document ).ready(function() {
        $("#enquiryForm").validate({
        rules: {
            name: {
            required: true,
            },
            phone: {
            required: true,
            },
            email: {
            required: true,
            email: true,
            },
            product_looking_for: {
            required: true,
            },
            end_use_application: {
            required: true,
            },
            company_name: {
            required: true,
            },
            company_address: {
            required: true,
            },
            additional_remark: {
            required: true,
            },

        },
        messages: {
            name: {
            required: 'Name field is required',
            },
            phone: {
            required: 'Phone number field is required',
            },
            email: {
            required: 'Email field is required',
            },
            product_looking_for: {
            required: 'Product looking for field is required',
            },
            end_use_application: {
            required: 'End use application field is required',
            },
            company_name: {
            required: 'Company name field is required',
            },
            company_address: {
            required: 'Company address field is required',
            },
            additional_remark: {
            required: 'Additional remark field is required',
            },
        },
        });
        });

    // Show the first tab by default
    $('.tabs-stage div').hide();
    $('.tabs-stage div:first').show();
    $('.tabs-nav li:first').addClass('tab-active');

    // Change tab class and display content
    $('.tabs-nav a').on('click', function(event){
    event.preventDefault();
    $('.tabs-nav li').removeClass('tab-active');
    $(this).parent().addClass('tab-active');
    $('.tabs-stage div').hide();
    $($(this).attr('href')).show();
    });
</script>