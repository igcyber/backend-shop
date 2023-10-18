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
            @role('Supervisor')
                <li class="menu-header">Manajemen Produk</li>
                <li class="{{ setActive(['app.vendors.*']) }}">
                    <a class="nav-link" href="{{ route('app.vendors.index') }}"><i class="fas fa-industry"></i>
                        <span>Pabrikan Produk</span></a>
                </li>
                <li class="{{ setActive(['app.categories.*']) }}">
                    <a class="nav-link" href="{{ route('app.categories.index') }}"><i class="fas fa-tag"></i>
                        <span>Tipe Produk</span></a>
                </li>
            @endrole

            @role('Admin Gudang')
                <li class="{{ setActive(['app.products.*']) }}">
                    <a class="nav-link" href="{{ route('app.products.index') }}"><i class="fas fa-window-restore"></i>
                        <span>Produk</span></a>
                </li>
            @endrole

            @role('Supervisor')
                <li class="menu-header">Manajemen Customer</li>
                <li class="{{ setActive(['app.customers.*']) }}">
                    <a class="nav-link" href="{{ route('app.customers.index') }}"><i class="fas fa-user-alt"></i>
                        <span>Customer</span></a>
                </li>
                <li class="menu-header">Manajemen Pengguna</li>
                <li class="{{ setActive(['app.users.*']) }}">
                    <a class="nav-link" href="{{ route('app.users.index') }}"><i class="fas fa-user"></i>
                        <span>Pengguna</span></a>
                </li>
                <li class="{{ setActive(['app.permissions']) }}">
                    <a class="nav-link" href="{{ route('app.permissions') }}"><i class="fas fa-lock"></i>
                        <span>Izin Akses</span></a>
                </li>
                <li class="{{ setActive(['app.roles.*']) }}">
                    <a class="nav-link" href="{{ route('app.roles.index') }}"><i class="fas fa-key"></i>
                        <span>Hak Akses</span></a>
                </li>
            @endrole
        </ul>
    </aside>
</div>
