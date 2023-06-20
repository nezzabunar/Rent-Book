<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

    </ul>
</nav>
<!-- /.navbar -->

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-4 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('/') }}dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user() ? Auth::user()->name : '-' }}</a>
                <a>{{ Auth::user() ? (Auth::user()->role_id === 1 ? 'admin' : 'anggota') : '-' }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
   with font-awesome or any other icon font library -->

                @if (Auth::user()->role_id === 1)
                    <li class="nav-item">
                        <a href="/dashboard" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
                            <i class="fa fa-home nav-icon"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-header">ADMINISTRATOR</li>
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link ">
                            <i class="nav-icon fa fa-folder"></i>
                            <p>
                                Master Data
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="/buku" class="nav-link {{ Request::is('buku') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data Buku</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/users" class="nav-link {{ Request::is('users') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data Users</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/data-peminjaman"
                                    class="nav-link {{ Request::is('data-peminjaman') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data Peminjaman</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif


                <li class="nav-header">MAIN MENU</li>
                <li class="nav-item">
                    <a href="/list-buku" class="nav-link {{ Request::is('list-buku') ? 'active' : '' }}">
                        <i class="fas fa-book nav-icon"></i>
                        <p>List Buku</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/peminjaman" class="nav-link {{ Request::is('peminjaman') ? 'active' : '' }}">
                        <i class="fas fa-undo nav-icon"></i>
                        <p>Peminjaman Buku</p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="/pengembalian" class="nav-link {{ Request::is('pengembalian') ? 'active' : '' }}">
                        <i class="fas fa-undo nav-icon"></i>
                        <p>Pengembalian Buku</p>
                    </a>
                </li> --}}

                <li class="nav-header">LOGOUT</li>
                <li class="nav-item">
                    <a href="/logout" class="nav-link">
                        <i class="fa fa-power-off nav-icon"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->

        <!-- /.sidebar-menu -->

    </div>
    <!-- /.sidebar -->
</aside>
