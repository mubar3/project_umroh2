
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

      <!-- Preloader -->
      <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{ asset('img/logo.jpg') }}" alt="AdminLTELogo" height="60" width="60">
      </div>

      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url ('/login_page')}}" class="nav-link">Home</a>
          </li>
          {{-- <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
          </li> --}}
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
              <i class="fas fa-expand-arrows-alt"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="kliklogout" role="button">
                <i class="fas fa-sign-out-alt"></i> LOGOUT
            </a>

          </li>
        </ul>
      </nav>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
          <img src="{{ asset('img/logo.jpg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light" style="font-size:15px">PT ASH SHOFWAH GROUP</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="{{ asset('img/blank.png') }}" class="img" alt="User Image">
            </div>
            <div class="info">
              <a href="#" class="d-block">{{ Auth::user()->email }}</a>
            </div>
          </div>

          <!-- SidebarSearch Form -->
          <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
              <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-sidebar">
                  <i class="fas fa-search fa-fw"></i>
                </button>
              </div>
            </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->
              <li class="nav-item">
                <a href="{{ url('/login_page')}}" class="nav-link">
                  <i class="fas fa-home"></i>
                  <p>
                    HOME
                  </p>
                </a>
              </li>
              @if(Auth::user()->role == 1 || Auth::user()->role == 2)
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                        <i class="fas fa-users"></i>
                        <p>
                            USERS
                            <i class="fas fa-angle-left right"></i>
                            {{-- <span class="badge badge-info right">6</span> --}}
                        </p>
                        </a>
                        <ul class="nav nav-treeview" style="padding-left: 20px;">
                        <li class="nav-item">
                            <a href="{{ url('/tambah_user')}}" class="nav-link">
                            <i class="fas fa-edit"></i>
                            <p>TAMBAH USER</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/daftar_user')}}" class="nav-link">
                            <i class="fas fa-list"></i>
                            <p>DAFTAR USER</p>
                            </a>
                        </li>
                        </ul>
                    </li>
              @endif
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fas fa-users"></i>
                  <p>
                    ANGGOTA
                    <i class="fas fa-angle-left right"></i>
                    {{-- <span class="badge badge-info right">6</span> --}}
                  </p>
                </a>
                <ul class="nav nav-treeview" style="padding-left: 20px;">
                  {{-- @if(Auth::user()->role != 2) --}}
                    <li class="nav-item">
                        <a href="{{ url('/tambah_anggota')}}" class="nav-link">
                        <i class="fas fa-edit"></i>
                        <p>TAMBAH ANGGOTA</p>
                        </a>
                    </li>
                  {{-- @endif --}}
                  <li class="nav-item">
                    <a href="{{ url('/daftar_anggota')}}" class="nav-link">
                      <i class="fas fa-list"></i>
                      <p>DAFTAR ANGGOTA</p>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-item">
                <a href="" class="nav-link">
                  <i class="fas fa-wallet"></i>
                  <p>
                    KEUANGAN
                    <span class="right badge badge-primary">Coming Soon</span>
                    {{-- <i class="fas fa-angle-left right"></i> --}}
                  </p>
                </a>
                <ul class="nav nav-treeview" style="padding-left: 20px;">
                  <li class="nav-item">
                    <a href="{{ url('/tabungan')}}" class="nav-link">
                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                      <p>TABUNGAN</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="" class="nav-link">
                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                      <p>SETORAN JAMAAH HAJI</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="" class="nav-link">
                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                      <p>SETORAN JAMAAH UMROH</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="" class="nav-link">
                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                      <p>HUTANG</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="" class="nav-link">
                      {{-- <i class="far fa-circle nav-icon"></i> --}}
                      <p>DP</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>
