<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
<!-- Brand Logo -->
<a href="index3.html" class="brand-link">
    <img src="/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">AdminLTE 3</span>
</a>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">{{Auth::user()->name}}</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    @if (Auth::user()->role == "user")
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>

            <li class="nav-item {{ request()->is('event/*') ? 'menu-open' : ''}}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-table"></i>
                    <p>
                    Events
                    <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                    <a href="/event/contribute" class="nav-link {{ request()->is('event/contribute') ? 'active' : ''}}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Contribute Event</p>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a href="/event/my" class="nav-link {{ request()->is('event/my') ? 'active' : ''}}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>My Event</p>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a href="/event/list" class="nav-link {{ request()->is('event/list') ? 'active' : ''}}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>All Event</p>
                    </a>
                    </li>
                </ul>
            </li>

            {{-- <li class="nav-item">
                <a href="/calendar" class="nav-link {{ request()->is('calendar') ? 'active' : ''}}">
                    <i class="nav-icon fas fa-calendar-alt"></i>
                    <p>
                    Calendar
                    </p>
                </a>
            </li> --}}

        </ul>
    </nav>
    @else
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>

            <li class="nav-item {{ request()->is('event/*') ? 'menu-open' : ''}}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-table"></i>
                    <p>
                    Events
                    <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                    <a href="/event/booked" class="nav-link {{ request()->is('event/booked') ? 'active' : ''}}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Booked Event</p>
                    </a>
                    </li>
                    <li class="nav-item">
                        {{-- sites/*/edit --}}
                    <a href="/event/list" class="nav-link {{ request()->is('event/list') ? 'active' : ''}}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>All Event</p>
                    </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="/users" class="nav-link {{ request()->is('users') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                    Members
                    </p>
                </a>
            </li>

            {{-- <li class="nav-item">
                <a href="/calendar" class="nav-link {{ request()->is('calendar') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-calendar-alt"></i>
                    <p>
                    Calendar
                    </p>
                </a>
            </li> --}}

        </ul>
    </nav>
    @endif
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>
<!-- /.Sidebar -->