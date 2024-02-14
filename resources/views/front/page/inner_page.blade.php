@extends('front.common.inner_page_layout')

@section('content')
<section class="main-section ">
    <div class="page-hd">
        <h2 class="sec-title">{{$title}}</h2>
    </div>
    <div class="position-relative">
        <div class="shape shape-bottom shape-fluid-x">
            <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 48h2880V0h-720C1442.5 52 720 0 720 0H0v48z" fill="#f1962a"></path>
            </svg>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Text -->
                <p class="text-muted mb-6 mb-md-0">
                    {!! $description !!}
                </p>
                
                <div class="container test">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- <h1> Bootstrap Tabs!</h1> -->
                            <div class="tabs">
                                
                                <ul class="tabs-nav">
                                    <li><a href="#tab-1"><img src="{{asset('/front/images/pharmaceutical.png')}}" altr="Pharmaceutical">Pharmaceutical</a></li>
                                    <li><a href="#tab-2"><img src="{{asset('/front/images/healthy-food.png')}}" altr="Nutraceutical">Nutraceutical</a></li>
                                    <li><a href="#tab-3"><img src="{{asset('/front/images/cupcake.png')}}" altr="Bakery">Bakery</a></li>
                                    <li><a href="#tab-4"><img src="{{asset('/front/images/beverages.png')}}" altr="Beverage">Beverage</a></li>
                                    <li><a href="#tab-5"><img src="{{asset('/front/images/breakfast.png')}}" altr="Cereals">Cereals</a></li>
                                    <li><a href="#tab-6"><img src="{{asset('/front/images/candy.png')}}" altr="Confectionary">Confectionary</a></li>
                                    <li><a href="#tab-7"><img src="{{asset('/front/images/dairy-products.png')}}" altr="Dairy">Dairy</a></li>
                                    <li><a href="#tab-8"><img src="{{asset('/front/images/pastry.png')}}" altr="Savory">Savory</a></li>
                                </ul>
                                <div class="tabs-stage">
                                    <div id="tab-1">
                                        <h3>Pharmaceutical</h3>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>PRODUCT NAME</th>
                                                    <th>PRINCIPAL</th>
                                                    </th>
                                                    <th>COUNTRY</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Alpha - DL-Methionine Calcium Salts</td>
                                                    <td>Hebei Yipin</td>
                                                    <td>China</td>
                                                </tr>
                                                <tr>
                                                    <td>Alpha Keto Isoleucine Calcium Salts</td>
                                                    <td>Hebei Yipin</td>
                                                    <td>China</td>
                                                </tr>
                                                <tr>
                                                    <td>Alpha - DL-Methionine Calcium Salts</td>
                                                    <td>Hebei Yipin</td>
                                                    <td>China</td>
                                                </tr>
                                                <tr>
                                                    <td>Alpha Keto Isoleucine Calcium Salts</td>
                                                    <td>Hebei Yipin</td>
                                                    <td>China</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="tab-2">
                                        <p>Phasellus pharetra aliquet viverra. Donec scelerisque tincidunt diam, eu fringilla urna auctor at.</p>
                                    </div>
                                    <div id="tab-3">
                                        <p>Phasellus pharetra aliquet viverra. Donec scelerisque tincidunt diam, eu fringilla urna auctor at.</p>
                                    </div>
                                    <div id="tab-4">
                                        <p>Phasellus pharetra aliquet viverra. Donec scelerisque tincidunt diam, eu fringilla urna auctor at.</p>
                                    </div>
                                    <div id="tab-5">
                                        <p>Phasellus pharetra aliquet viverra. Donec scelerisque tincidunt diam, eu fringilla urna auctor at.</p>
                                    </div>
                                    <div id="tab-6">
                                        <p>Phasellus pharetra aliquet viverra. Donec scelerisque tincidunt diam, eu fringilla urna auctor at.</p>
                                    </div>
                                    <div id="tab-7">
                                        <p>Phasellus pharetra aliquet viverra. Donec scelerisque tincidunt diam, eu fringilla urna auctor at.</p>
                                    </div>
                                    <div id="tab-8">
                                        <p>Phasellus pharetra aliquet viverra. Donec scelerisque tincidunt diam, eu fringilla urna auctor at.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</section>
<script>
    
    /**
     * Simulate a click event.
     * @public
     * @param {Element} elem  the element to simulate a click on
     */
    function simulateClick(elem) {
        // Create our event (with options)
        var evt = new MouseEvent('click', {
            bubbles: true,
            cancelable: true,
            view: window
        });
        // If cancelled, don't dispatch our event
        var canceled = !elem.dispatchEvent(evt);
    };

    function prepareTabs(triggerEl) {
        var tabTrigger = new bootstrap.Tab(triggerEl)

        triggerEl.addEventListener('click', function (event) {
            event.preventDefault()
            //alert('test-'+this.parentNode.tagName);
            tabTrigger.show()

            //console.log('>>>' + this.parentNode.tagName);
            //console.log('>>>>' + this.parentNode.parentNode.tagName);
            var sibling = this.parentNode.parentNode.firstChild;
            // Loop through each sibling and push to the array
            while (sibling) {
                if (sibling.tagName !== undefined) 
                {
                    //console.log('>>>' + sibling.tagName);
                    //console.log('--->' + sibling.classList);
                    //console.log('>>' + sibling.firstChild.href);
                    sibling.classList.remove('active');
                }
                sibling = sibling.nextSibling;
            }
            this.parentNode.classList.add('active');
            console.log('href = ' + this.href);
            simulateClick(document.querySelector(this.href));
        })
    }

    var triggerTabListTest = [].slice.call(document.querySelectorAll("#myTab a"));
    triggerTabListTest.forEach(function (triggerEl) {
    prepareTabs(triggerEl);
    });

</script>
@stop