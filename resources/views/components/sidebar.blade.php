<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="#">UPINDO BORNEO RAYA</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#">UBR</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('dashboard-general-dashboard') ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ url('dashboard-general-dashboard') }}">General Dashboard</a>
                    </li>
                    <li class="{{ Request::is('dashboard-ecommerce-dashboard') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('dashboard-ecommerce-dashboard') }}">Ecommerce Dashboard</a>
                    </li>
                </ul>
            </li>
            <li class="menu-header">Manajemen Produk</li>
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('app.categories.index') }}"><i class="fas fa-tag"></i>
                    <span>Kategori Produk</span></a>
            </li>
            <li class="menu-header">Manajemen Pengguna</li>
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('app.users.index') }}"><i class="fas fa-user"></i>
                    <span>Pengguna</span></a>
            </li>
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('app.permissions') }}"><i class="fas fa-lock"></i>
                    <span>Izin Akses</span></a>
            </li>
            <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('app.roles.index') }}"><i class="fas fa-key"></i>
                    <span>Hak Akses</span></a>
            </li>


        </ul>
    </aside>
</div>
