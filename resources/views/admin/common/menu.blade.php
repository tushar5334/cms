<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark navbar-primary">

  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
        class="btn btn-danger text-white"><i class="fas fa-power-off"></i></a>
      <form id="logout-form" action="{{ route('admin.post.logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
      </form>
    </li>

  </ul>
</nav>

<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('admin.get.dashboard') }}" class="brand-link">
    <!-- <img src="/images/tx-logo.svg" alt="Icon" class="collapse-logo"> -->
    <!-- <span class="brand-text font-weight-light">PF</span> -->

  </a>
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <a href="{{ route('admin.get.dashboard') }}">
          <!-- <img src="/images/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
          {{-- <img src="{{ $data->display_picture}}" onerror="this.onerror=null;this.src='/images/user2-160x160.jpg';"
          class="img-circle elevation-2" alt="User Image"> --}}
          @if(Auth::user()->display_picture!="")
          <img src="{{ Auth::user()->display_picture}}" class="img-circle elevation-2" alt="User Image">
          @else
          <img src="{{ asset('/images/avatar5.png')}}" class="img-circle elevation-2" alt="User Image">
          @endif
        </a>
      </div>
      <div class="info">
        <a href="{{ route('admin.get.dashboard') }}" class="d-block">{{ Auth::user()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-compact" data-widget="treeview" role="menu"
        data-accordion="false">
        <li class="nav-item">
          <a href="{{ route('admin.get.dashboard') }}"
            class="nav-link {{ (Request::path() == 'admin') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt nav-icon"></i>
            <p>Dashboard</p>
          </a>
        </li>

        @if (Auth::user()->can('isSuperAdmin') || Auth::user()->can('isAdmin'))
        <li class="nav-item has-treeview {{(Request::path() == 'admin/users' || Request::path() == 'admin/users/create' ||
        Request::is('admin/users/*/edit')) ? 'menu-open' : ''}}">
          <a href="{{route('admin.users.index')}}" class="nav-link {{(Request::path() == 'admin/users' || Request::path() == 'admin/users/create' ||
        Request::is('admin/users/*/edit')) ? 'active' : ''}}">
            <i class="nav-icon fas fa-users nav-icon"></i>
            <p>
              User Management
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview" style="padding:0;">
            <li class="nav-item">
              <a href="{{route('admin.users.index')}}"
                class="nav-link {{(Request::path() == 'admin/users' || Request::path() == 'admin/users/create' || Request::is('admin/users/*/edit')) ? 'active' : '' }}">
                <i class="far fa-user nav-icon"></i>
                <p>User List</p>
              </a>
            </li>
          </ul>
        </li>
        @endif
        <li class="nav-item ">
          <a href="{{route('admin.pages.index')}}"
            class="nav-link {{(Request::path() == 'admin/pages' || Request::path() == 'admin/pages/create' || Request::is('admin/pages/*/edit')) ? 'active' : '' }}">
            <i class="fas fa-pager"></i>
            <p> Pages Management</p>
          </a>
        </li>
        <li class="nav-item ">
          <a href="{{route('admin.slider-images.index')}}"
            class="nav-link {{(Request::path() == 'admin/slider-images' || Request::path() == 'admin/slider-images/create' || Request::is('admin/slider-images/*/edit')) ? 'active' : '' }}">
            <i class="fas fa-image"></i>
            <p> Slider Images Management</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('admin.inquiries.index')}}"
            class="nav-link {{ (Request::path() == 'admin/inquiries') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt nav-icon"></i>
            <p>Inquiry Report</p>
          </a>
        </li>
        <li class="nav-item ">
          <a href="{{route('admin.products.index')}}"
            class="nav-link {{(Request::path() == 'admin/products' || Request::path() == 'admin/products/create' || Request::is('admin/products/*/edit')) ? 'active' : '' }}">
            <i class="fas fa-image"></i>
            <p> Product Management</p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>