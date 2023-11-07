<div class="container-fluid">
    <a class="navbar-brand d-flex justify-content-between align-items-center order-lg-0" href="#">
        <img src="{{ asset('front-end/img/loogoo (3).png') }}" alt="site icon" />
        <span class="text-uppercase ms-2 text-size-custom" style="font-size: 1rem !important"> PT. Upindo Raya Semesta
            Borneo</span>
    </a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse order-lg-1" id="navMenu">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item px-2">
                <a class="nav-link active text-capitalize text-dark" href="{{ url('/') }}">
                    <i class="fas fa-home" style="font-size: 20px;"></i> Beranda</a>
            </li>
            <li class="nav-item px-2">
                <a class="nav-link text-capitalize text-dark" href="#">
                    <i class="fas fa-box" style="font-size: 20px; "></i> Produk</a>
            </li>

            <li class="nav-item px-2">
                <a class="nav-link text-capitalize text-dark" href="{{ route('cartDetail') }}"><i
                        class="fas fa-shopping-cart" style="font-size: 20px;"></i> Keranjang
                    <span class="badge bg-primary" id="cart_count">{{ Cart::content()->count() }}</span>
                </a>
            </li>
            <li class="nav-item px-2 py-1">
                @if (Auth::check())
                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                        @csrf
                        <a class="nav-link text-capitalize text-dark" style="cursor: pointer" title="Logout"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
                            <i class="fas fa-sign-out-alt" style="font-size: 20px;"></i> Logout
                        </a>
                    </form>
                @else
                    <a class="nav-link text-capitalize text-dark" href="{{ route('login') }}" target="_blank"><i
                            class="fas fa-sign-in-alt" style="font-size: 22px;"></i>
                        Login</a>
                @endif
            </li>
        </ul>
    </div>
</div>
