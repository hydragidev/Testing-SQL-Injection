<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>
  <link rel="shortcut icon" type="image/png" href="{{ url('/assets/images/logos/favicon.png')}}" />
  <link rel="stylesheet" href="{{ url ('/assets/css/styles.min.css')}}" />
  @yield('css')
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="{{ route('dashboard.index')}}" class="text-nowrap logo-img">
            <img src="{{ url('/assets/images/logos/logo.png')}}" width="180" alt="" />
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Dashboard</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('dashboard.index') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>
            <li class="nav-small-cap">
                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                <div class="row">
                    <div class="col">
                        <span class="hide-menu">PROJECT</span>
                    </div>
                    <div class="col">
                        <a class="sidebar-link btn btn-primary btn-sm text-primary float-end" href="{{ route('dashboard.add_project')}}" aria-expanded="false">
                            <span>
                              <i class="ti ti-plus text-white"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </li>
            @php
                 use App\Models\ProjectModel;
                 $projects = ProjectModel::where('is_active', true)->get();

            @endphp
            @foreach ($projects as $item)
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ route('dashboard.project_launch_detail',  $item->id )}}" aria-expanded="false" >
                @if($item->is_active)
                <span>
                  <i class="ti ti-list-details"></i>
                </span>
                <span class="hide-menu">{{ $item->name_project }}</span>
                @else
                <span>
                  <i class="ti ti-list-details" style="color: grey"></i>
                </span>
                <span class="hide-menu" style="color: grey"><del>{{ $item->name_project }}</del></span>
                @endif
              </a>
            </li>
            @endforeach
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
        <!--  Header Start -->
        <header class="app-header">
            <nav class="navbar navbar-expand-lg navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                    <i class="ti ti-bell-ringing"></i>
                    <div class="notification bg-primary rounded-circle"></div>
                </a>
                </li>
            </ul>
            <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                <a href="https://adminmart.com/product/modernize-free-bootstrap-admin-dashboard/" target="_blank" class="btn btn-primary">Download Free</a>
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <img src="../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                    <div class="message-body">
                        <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                        <i class="ti ti-user fs-6"></i>
                        <p class="mb-0 fs-3">My Profile</p>
                        </a>
                        <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                        <i class="ti ti-mail fs-6"></i>
                        <p class="mb-0 fs-3">My Account</p>
                        </a>
                        <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                        <i class="ti ti-list-check fs-6"></i>
                        <p class="mb-0 fs-3">My Task</p>
                        </a>
                        <a href="./authentication-login.html" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                    </div>
                    </div>
                </li>
                </ul>
            </div>
            </nav>
        </header>
        <!--  Header End -->
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/turbolinks@5.2.0/dist/turbolinks.js"></script>
<script src="{{ url('/assets/libs/jquery/dist/jquery.min.js')}}"></script>
<script src="{{ url('/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ url('/assets/js/sidebarmenu.js')}}"></script>
<script src="{{ url('/assets/js/app.min.js')}}"></script>
<script src="{{ url('/assets/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
<script src="{{ url('/assets/libs/simplebar/dist/simplebar.js')}}"></script>
<script src="{{ url('/assets/js/dashboard.js')}}"></script>
@yield('js')
</body>

</html>