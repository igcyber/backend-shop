<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <img src="{{ asset('front-end/img/loogoo (3).png') }}" alt="logo" width="80" class="rounded-circle">
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <img src="{{ asset('front-end/img/loogoo (3).png') }}" alt="logo" width="40" class="rounded-circle">
        </div>
        <ul class="sidebar-menu">
            @role('Supervisor')
                <li class="dropdown mt-2">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="#">General Dashboard</a></li>
                        <li><a class="nav-link" href="#">Ecommerce Dashboard</a></li>
                    </ul>
                </li>

                <li class="{{ setActive(['app.flash.*']) }}">
                    <a class="nav-link" href="{{ route('app.flash.sales') }}" title="Flash Sale">
                        <i class="fas fa-percent"></i>
                        <span>Flash Sale</span>
                    </a>
                </li>

                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-industry"></i><span>Manajemen
                            Produk</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ setActive(['app.vendors.*']) }}">
                            <a class="nav-link" href="{{ route('app.vendors.index') }}" title="Pabrikan">
                                <span>Pabrikan Produk</span>
                            </a>
                        </li>
                        <li class="{{ setActive(['app.categories.*']) }}">
                            <a class="nav-link" href="{{ route('app.categories.index') }}">
                                <span>Tipe Produk</span>
                            </a>
                        </li>
                        <li class="{{ setActive(['app.detail-products.*']) }}">
                            <a class="nav-link" href="{{ route('app.detail-products.index') }}">
                                <span>Detail Produk</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-store"></i>
                        <span>Manajemen Outlet</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ setActive(['app.customers.*']) }}">
                            <a class="nav-link" href="{{ route('app.customers.index') }}">
                                <span>Outlet</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-user"></i>
                        <span>Manajemen Pengguna</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ setActive(['app.users.*']) }}">
                            <a class="nav-link" href="{{ route('app.users.index') }}">
                                <span>Pengguna</span></a>
                        </li>
                        <li class="{{ setActive(['app.permissions']) }}">
                            <a class="nav-link" href="{{ route('app.permissions') }}">
                                <span>Izin Akses</span></a>
                        </li>
                        <li class="{{ setActive(['app.roles.*']) }}">
                            <a class="nav-link" href="{{ route('app.roles.index') }}">
                                <span>Hak Akses</span></a>
                        </li>
                    </ul>
                </li>
            @endrole
        </ul>
    </aside>
</div>
