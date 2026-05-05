<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">

        @auth
            @if(Auth::user()->role == 'vendor')

                <!-- ================= VENDOR ================= -->

                <li class="nav-item {{ request()->is('vendor/dashboard') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('vendor.dashboard') }}">
                        <span class="menu-title">Dashboard Vendor</span>
                        <i class="mdi mdi-store menu-icon"></i>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('vendor/menu*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('vendor.menu.index') }}">
                        <span class="menu-title">Daftar Menu</span>
                        <i class="mdi mdi-food menu-icon"></i>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('vendor/pesanan') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('vendor.pesanan') }}">
                        <span class="menu-title">Pesanan Lunas</span>
                        <i class="mdi mdi-receipt menu-icon"></i>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('barangs*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('barangs.index') }}">
                        <span class="menu-title">Barang</span>
                        <i class="mdi mdi-tag menu-icon"></i>
                    </a>
                </li>

                 <!-- 🔥 CUSTOMER (FIX TANPA COLLAPSE) -->
                <li class="nav-item {{ request()->is('customer') ? 'active' : '' }}">
                    <a class="nav-link" href="/customer">
                        <span class="menu-title">Data Customer</span>
                        <i class="mdi mdi-account menu-icon"></i>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('customer/create-blob') ? 'active' : '' }}">
                    <a class="nav-link" href="/customer/create-blob">
                        <span class="menu-title">Tambah Customer (Blob)</span>
                        <i class="mdi mdi-camera menu-icon"></i>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('customer/create-file') ? 'active' : '' }}">
                    <a class="nav-link" href="/customer/create-file">
                        <span class="menu-title">Tambah Customer (File)</span>
                        <i class="mdi mdi-image menu-icon"></i>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('kantin/pos') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('kantin.pos') }}">
                        <span class="menu-title">Pemesanan Customer</span>
                        <i class="mdi mdi-cart menu-icon"></i>
                    </a>
                </li>

            @else

                <!-- ================= ADMIN ================= -->

                <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                    <a class="nav-link" href="/dashboard">
                        <span class="menu-title">Dashboard</span>
                        <i class="mdi mdi-home menu-icon"></i>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('kategori*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('kategori.index') }}">
                        <span class="menu-title">Kategori</span>
                        <i class="mdi mdi-view-list menu-icon"></i>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('buku*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('buku.index') }}">
                        <span class="menu-title">Buku</span>
                        <i class="mdi mdi-book menu-icon"></i>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('barangs*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('barangs.index') }}">
                        <span class="menu-title">Barang</span>
                        <i class="mdi mdi-tag menu-icon"></i>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('modul4') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/modul4') }}">
                        <span class="menu-title">Modul 4</span>
                        <i class="mdi mdi-code-tags menu-icon"></i>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('modul5') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/modul5') }}">
                        <span class="menu-title">Modul 5</span>
                        <i class="mdi mdi-code-tags menu-icon"></i>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('modul5/pos') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('modul5.pos') }}">
                        <span class="menu-title">Modul 5 POS</span>
                        <i class="mdi mdi-code-tags menu-icon"></i>
                    </a>
                </li>

            @endif
        @endauth

    </ul>
</nav>