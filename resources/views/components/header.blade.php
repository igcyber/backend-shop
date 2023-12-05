<div class="navbar-bg" style="background-color: #2bb75b; !important"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <div class="d-inline mr-auto">
        @auth
            @if (auth()->user()->hasRole(['Sales', 'Outlet', 'Admin Gudang']))
                <!-- The user has one of the specified roles, hide the sidebar -->
            @else
                <!-- The user doesn't have the specified roles, show the sidebar -->
                <ul class="navbar-nav mr-3">
                    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>
            @endif
        @endauth
    </div>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                class="nav-link nav-link-lg message-toggle beep" title="Notifikasi"><i class="far fa-envelope"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">Messages
                    <div class="float-right">
                        <a href="#">Mark All As Read</a>
                    </div>
                </div>
                <div class="dropdown-list-content dropdown-list-message">
                    <a href="#" class="dropdown-item dropdown-item-unread">
                        <div class="dropdown-item-avatar">
                            <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle">
                            <div class="is-online"></div>
                        </div>
                        <div class="dropdown-item-desc">
                            <b>Kusnaedi</b>
                            <p>Hello, Bro!</p>
                            <div class="time">10 Hours Ago</div>
                        </div>
                    </a>
                </div>
                <div class="dropdown-footer text-center">
                    <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </li>

        <li class="dropdown dropdown-list-toggle">
            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                @csrf
                <a class="nav-link nav-link-lg" style="cursor: pointer" title="Logout"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </form>
        </li>

        <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">{{ Auth::user()->name }}</div>
            </a>
        </li>
    </ul>
</nav>
