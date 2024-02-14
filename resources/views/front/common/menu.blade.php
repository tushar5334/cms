<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-white">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand" href="{{url('/')}}">
            <img width="200" src="{{asset('/front/images/logo.png')}}" class="navbar-brand-img" alt="V K enterprise">
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fe fe-x"></i>
            </button>
            <!-- Navigation -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{(Request::path() == '/') ? 'active' : '' }}"
                        id="navbarLandings" data-bs-toggle="dropdown" href="{{url('/')}}" aria-haspopup="true"
                        aria-expanded="false">
                        Home
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{(Request::path() == 'about') ? 'active' : '' }}"
                        id="navbarPages" data-bs-toggle="dropdown" href="{{url('/about')}}" aria-haspopup="true"
                        aria-expanded="false">
                        About Us
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Mission &amp; Vision</a></li>
                        <li><a class="dropdown-item" href="#">Growth</a></li>
                        <li><a class="dropdown-item" href="#">Values</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{(Request::path() == 'principal') ? 'active' : '' }}"
                        id="navbarAccount" data-bs-toggle="dropdown" href="{{url('/principal')}}" aria-haspopup="true"
                        aria-expanded="false">
                        Principals
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{(Request::path() == 'by-segment') ? 'active' : '' }}"
                        id="navbarDocumentation" data-bs-toggle="dropdown" href="{{url('/by-segment')}}"
                        aria-haspopup="true" aria-expanded="false">
                        Products
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{(Request::path() == 'application-lab') ? 'active' : '' }}"
                        id="navbarDocumentation" data-bs-toggle="dropdown" href="{{url('/application-lab')}}"
                        aria-haspopup="true" aria-expanded="false">
                        Application lab
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{(Request::path() == 'kawman-pharma') ? 'active' : '' }}"
                        id="navbarDocumentation" data-bs-toggle="dropdown" href="{{url('/kawman-pharma')}}"
                        aria-haspopup="true" aria-expanded="false">
                        Kawman pharma
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{(Request::path() == 'contact') ? 'active' : '' }}"
                        id="navbarDocumentation" data-bs-toggle="dropdown" href="{{url('/contact')}}"
                        aria-haspopup="true" aria-expanded="false">
                        Contact
                    </a>
                </li>
            </ul>
            <!-- Button -->
            {{-- <a class="navbar-btn btn btn-sm btn-primary lift ms-auto"
                href="https://themes.getbootstrap.com/product/landkit/" target="_blank">
                Buy now
            </a> --}}
        </div>
    </div>
</nav>