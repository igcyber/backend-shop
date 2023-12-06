<div class="container-fluid">
    <a class="navbar-brand d-flex justify-content-between align-items-center order-lg-0" href="#">
        <img src="{{ asset('front-end/img/loogoo (3).png') }}" alt="site icon" />
        <span class="text-uppercase ms-2 text-size-custom"
            style="font-size: 1rem !important; font-family: 'Poppins', sans-serif;
        font-family: 'Roboto', sans-serif;">
            PT. Upindo Raya Semesta
            Borneo</span>
    </a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse order-lg-1" id="navMenu">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item px-2">
                <a class="nav-link text-capitalize {{ setActive(['front.home']) }}" style="color:#5A5A5A"
                    href="{{ url('/') }}">
                    <i class="fas fa-home" style="font-size: 15px;"></i> Beranda</a>
            </li>
            <li class="nav-item px-2">
                <a class="nav-link text-capitalize" href="#" style="color:#5A5A5A">
                    <i class="fas fa-box" style="font-size: 15px;"></i> Produk</a>
            </li>

            <li class="nav-item px-2">
                @guest
                    <a class="nav-link text-capitalize {{ setActive(['login']) }}" style="color:#5A5A5A"
                        href="{{ route('login') }}"><i class="fas fa-shopping-cart" style="font-size: 15px;"></i> Keranjang
                    </a>
                @else
                    <a class="nav-link text-capitalize {{ setActive(['app.cart.*']) }}" style="color:#5A5A5A"
                        href="{{ route('app.cart.get', auth()->user()->id) }}"><i class="fas fa-shopping-cart"
                            style="font-size: 15px; "></i> Keranjang
                        <span class="badge bg-primary"
                            id="cart_count">{{ App\Models\Cart::where('outlet_id', auth()->user()->id)->count('detail_id') }}
                        </span>
                    </a>
                @endguest

            </li>
            <li class="nav-item px-2">
                @if (Auth::check())
                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                        @csrf
                        <a class="nav-link text-capitalize" style="cursor: pointer" title="Logout"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
                            <i class="fas fa-sign-out-alt" style="font-size: 15px;"></i> Logout
                        </a>
                    </form>
                @else
                    <a class="nav-link text-capitalize {{ setActive(['login']) }}" href="{{ route('login') }}"><i
                            class="fas fa-sign-in-alt"></i>
                        Login</a>
                @endif
            </li>
        </ul>
    </div>
</div>
