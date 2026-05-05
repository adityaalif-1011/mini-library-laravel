<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <a class="navbar-brand brand-logo" href="/dashboard">
            <img src="{{ asset('assets/images/logo.svg') }}" alt="logo" />
        </a>
        <a class="navbar-brand brand-logo-mini" href="/dashboard">
            <img src="{{ asset('assets/images/logo-mini.svg') }}" alt="logo" />
        </a>
    </div>

    <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>

        <ul class="navbar-nav navbar-nav-right">
            <!-- MENU DASHBOARD VENDOR (hanya untuk role vendor) -->
            @auth
                @if(Auth::user()->role == 'vendor')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('vendor.dashboard') }}">
                            <i class="mdi mdi-store me-1"></i> Dashboard Vendor
                        </a>
                    </li>
                @endif
            @endauth

            <!-- PROFILE DROPDOWN (untuk semua user yang login) -->
            @auth
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                    <div class="nav-profile-img">
                        <img src="{{ asset('assets/images/faces/face1.jpg') }}">
                    </div>
                    <div class="nav-profile-text">
                        <p class="mb-1 text-black">{{ Auth::user()->name }}</p>
                    </div>
                </a>
                <div class="dropdown-menu navbar-dropdown">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="mdi mdi-logout me-2 text-primary"></i> Logout
                        </button>
                    </form>
                </div>
            </li>
            @endauth
        </ul>
    </div>
</nav>