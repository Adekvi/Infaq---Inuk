<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        @if (Auth::check())
            @if (Auth::user()->role == 'superadmin')
                <a href="{{ url('superadmin/dashboard') }}" class="app-brand-link d-flex align-items-center">
                    <span class="app-brand-logo demo">
                        <img src="{{ asset('landing/img/logo.png') }}" alt="Logo INUK" title="INUK"
                            style="height: 60px;" />
                    </span>
                    <span class="app-brand-text demo menu-text fw-bolder ms-2 text-uppercase" style="line-height: 1;">
                        <span style="display: block;">INUK</span>
                        <span style="display: block; font-size: 0.5em; line-height: 0.5;">Kudus</span>
                    </span>
                </a>
            @elseif (Auth::user()->role == 'kolektor')
                <a href="{{ url('kolektor/dashboard') }}" class="app-brand-link d-flex align-items-center">
                    <span class="app-brand-logo demo">
                        <img src="{{ asset('landing/img/logo.png') }}" alt="Logo INUK" title="INUK"
                            style="height: 60px;" />
                    </span>
                    <span class="app-brand-text demo menu-text fw-bolder ms-2 text-uppercase" style="line-height: 1;">
                        <span style="display: block;">INUK</span>
                        <span style="display: block; font-size: 0.5em; line-height: 0.5;">Kudus</span>
                    </span>
                </a>
            @elseif (Auth::user()->role == 'admin_kecamatan')
                <a href="{{ url('admin_kecamatan/dashboard') }}" class="app-brand-link d-flex align-items-center">
                    <span class="app-brand-logo demo">
                        <img src="{{ asset('landing/img/logo.png') }}" alt="Logo INUK" title="INUK"
                            style="height: 60px;" />
                    </span>
                    <span class="app-brand-text demo menu-text fw-bolder ms-2 text-uppercase" style="line-height: 1;">
                        <span style="display: block;">INUK</span>
                        <span style="display: block; font-size: 0.5em; line-height: 0.5;">Kudus</span>
                    </span>
                </a>
            @elseif (Auth::user()->role == 'admin_kabupaten')
                <a href="{{ url('admin_kabupaten/dashboard') }}" class="app-brand-link d-flex align-items-center">
                    <span class="app-brand-logo demo">
                        <img src="{{ asset('landing/img/logo.png') }}" alt="Logo INUK" title="INUK"
                            style="height: 60px;" />
                    </span>
                    <span class="app-brand-text demo menu-text fw-bolder ms-2 text-uppercase" style="line-height: 1;">
                        <span style="display: block;">INUK</span>
                        <span style="display: block; font-size: 0.5em; line-height: 0.5;">Kudus</span>
                    </span>
                </a>
            @endif
        @endif

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @if (Auth::check())
            @if (Auth::user()->role == 'superadmin')
                <!-- Dashboard -->
                <li class="menu-item active">
                    <a href="{{ url('superadmin/dashboard') }}" class="menu-link">
                        <i class="menu-icon tf-icons fa-solid fa-house"></i>
                        <div data-i18n="Analytics">Dashboard</div>
                    </a>
                </li>

                {{-- DATA MASTER --}}
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">DATA MASTER</span>
                </li>
                <li class="menu-item {{ Request::is('superadmin/master-data/wilayah*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons fa-solid fa-location-dot"></i>
                        <div data-i18n="Account Settings">Data Master Wilayah</div>
                    </a>
                    <ul class="menu-sub">
                        <li
                            class="menu-item {{ Request::is('superadmin/master-data/wilayah-kabupaten*') ? 'active' : '' }}">
                            <a href="{{ url('superadmin/master-data/wilayah-kabupaten') }}" class="menu-link">
                                <div data-i18n="Notifications">Data Kabupaten</div>
                            </a>
                        </li>
                        <li
                            class="menu-item {{ Request::is('superadmin/master-data/wilayah-kecamatan*') ? 'active' : '' }}">
                            <a href="{{ url('superadmin/master-data/wilayah-kecamatan') }}" class="menu-link">
                                <div data-i18n="Connections">Data Kecamatan</div>
                            </a>
                        </li>
                        <li
                            class="menu-item {{ Request::is('superadmin/master-data/wilayah-kelurahan*') ? 'active' : '' }}">
                            <a href="{{ url('superadmin/master-data/wilayah-kelurahan') }}" class="menu-link">
                                <div data-i18n="Connections">Data Kelurahan</div>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- DATA MASTER JABATAN --}}
                <li class="menu-item {{ Request::is('superadmin/master-data/setting*') ? 'active open' : '' }}">
                    <a href="{{ url('superadmin/master-data/setting') }}" class="menu-link">
                        <i class="menu-icon tf-icons fa-solid fa-folder-open"></i>
                        <div data-i18n="Analytics">Data Master Jabatan</div>
                    </a>
                </li>

                {{-- DATA MASTER USER --}}
                <li class="menu-item {{ Request::is('superadmin/master-data/user*') ? 'active open' : '' }}">
                    <a href="{{ url('superadmin/master-data/user') }}" class="menu-link">
                        <i class="menu-icon tf-icons fa-solid fa-user"></i>
                        <div data-i18n="Analytics">Data Master User</div>
                    </a>
                </li>

                {{-- DATA MASTER PLOTTING --}}
                <li class="menu-item {{ Request::is('superadmin/master-data/plotting*') ? 'active open' : '' }}">
                    <a href="{{ url('superadmin/master-data/plotting') }}" class="menu-link">
                        <i class="menu-icon tf-icons fa-solid fa-map-location-dot"></i>
                        <div data-i18n="Analytics">Data Master Plotting</div>
                    </a>
                </li>

                {{-- DATA MASTER PESAN --}}
                {{-- <li class="menu-item {{ Request::is('superadmin/master-data/pesan*') ? 'active open' : '' }}">
                    <a href="{{ url('superadmin/master-data/pesan') }}" class="menu-link">
                        <i class="menu-icon tf-icons fa-solid fa-message"></i>
                        <div data-i18n="Analytics">Data Master Template Pesan</div>
                    </a>
                </li> --}}

                {{-- DATA MASTER REPORT --}}
                {{-- <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">REKAPITULASI</span>
                </li>
                <li class="menu-item {{ Request::is('superadmin/master-data/plotting*') ? 'active open' : '' }}">
                    <a href="{{ url('superadmin/master-data/plotting') }}" class="menu-link">
                        <i class="menu-icon tf-icons fa-solid fa-map-location-dot"></i>
                        <div data-i18n="Analytics">Data Master Plotting</div>
                    </a>
                </li> --}}
            @elseif (Auth::user()->role == 'admin_kabupaten')
                <li class="menu-item active">
                    <a href="{{ url('admin_kabupaten/dashboard') }}" class="menu-link">
                        <i class="menu-icon tf-icons fa-solid fa-house"></i>
                        <div data-i18n="Analytics">Dashboard</div>
                    </a>
                </li>

                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Notifikasi</span>
                </li>
                <li class="menu-item {{ Request::is('admin_kabupaten/data-setor*') ? 'active open' : '' }}">
                    <a href="{{ url('admin_kabupaten/data-setor') }}" class="menu-link">
                        <i class="menu-icon tf-icons fa-solid fa-address-book"></i>
                        <div data-i18n="Data Setor Infaq">Data Infaq Setor</div>
                    </a>
                </li>

                {{-- <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Rekapitulasi</span>
                </li>
                <li class="menu-item {{ Request::is('admin_kabupaten/rekap-index*') ? 'active open' : '' }}">
                    <a href="{{ url('admin_kabupaten/rekap-index') }}" class="menu-link">
                        <i class="menu-icon tf-icons fas fa-file-pen"></i>
                        <div data-i18n="Data Setor Infaq">Data Rekap</div>
                    </a>
                </li> --}}
            @elseif (Auth::user()->role == 'admin_kecamatan')
                <li class="menu-item {{ Request::is('admin_kecamatan/dashboard') ? 'active open' : '' }}">
                    <a href="{{ url('admin_kecamatan/dashboard') }}" class="menu-link">
                        <i class="menu-icon tf-icons fa-solid fa-house"></i>
                        <div data-i18n="Dashboard">Dashboard</div>
                    </a>
                </li>

                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Data Rekap</span>
                </li>
                <li class="menu-item {{ Request::is('admin_kecamatan/hasil-setoran*') ? 'active open' : '' }}">
                    <a href="{{ url('admin_kecamatan/hasil-setoran/index') }}" class="menu-link">
                        <i class="menu-icon tf-icons fas fa-file-pen"></i>
                        <div data-i18n="Data Setor Infaq">Data Laporan</div>
                    </a>
                </li>

                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Laporan</span>
                </li>
                <li
                    class="menu-item {{ Request::is('admin_kecamatan/info-kirim/index-tampil*') ? 'active open' : '' }}">
                    <a href="{{ url('admin_kecamatan/info-kirim/index-tampil') }}" class="menu-link">
                        <i class="menu-icon tf-icons fa-solid fa-file-lines"></i>
                        <div data-i18n="Data Setor Infaq">Data Kirim Laporan</div>
                    </a>
                </li>

                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Pengiriman</span>
                </li>
                <li class="menu-item {{ Request::is('admin_kecamatan/info-index*') ? 'active open' : '' }}">
                    <a href="{{ url('admin_kecamatan/info-index') }}" class="menu-link">
                        <i class="menu-icon tf-icons fa-solid fa-bell"></i>
                        <div data-i18n="Data Setor Infaq">Data Pengiriman</div>
                    </a>
                </li>

                {{-- <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Informasi</span>
                </li> --}}
            @elseif (Auth::user()->role == 'kolektor')
                <li class="menu-item active">
                    <a href="{{ url('kolektor/dashboard') }}" class="menu-link">
                        <i class="menu-icon tf-icons fa-solid fa-house"></i>
                        <div data-i18n="Analytics">Dashboard</div>
                    </a>
                </li>

                {{-- PLOTTING TEMPAT --}}
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Plotting Tempat</span>
                </li>
                <li class="menu-item {{ Request::is('kolektor/plotting-index*') ? 'active' : '' }}">
                    <a href="{{ url('kolektor/plotting-index') }}" class="menu-link">
                        <i class="menu-icon tf-icons fa-solid fa-location-dot"></i>
                        <div data-i18n="Analytics">Plotting Wilayah</div>
                    </a>
                </li>

                {{-- DATA MASTER --}}
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Transaksi</span>
                </li>
                <li
                    class="menu-item {{ ((Request::is('kolektor/penerimaan/input*') ? 'active open' : '' || Request::is('kolektor/pengiriman/index*')) ? 'active open' : '' || Request::is('kolektor/setoran*')) ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons fa-solid fa-file"></i>
                        <div data-i18n="Account Settings">Transaksi</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::is('kolektor/penerimaan/input-infaq*') ? 'active' : '' }}">
                            <a href="{{ url('kolektor/penerimaan/input-infaq') }}" class="menu-link">
                                <div data-i18n="Notifications">Data Penerimaan</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::is('kolektor/pengiriman/index*') ? 'active' : '' }}">
                            <a href="{{ url('kolektor/pengiriman/index') }}" class="menu-link">
                                <div data-i18n="Notifications">Data Pengiriman</div>
                            </a>
                        </li>
                        {{-- <li class="menu-item {{ Request::is('kolektor/setoran*') ? 'active' : '' }}">
                            <a href="{{ url('kolektor/setoran') }}" class="menu-link">
                                <div data-i18n="Notifications">Data Setoran</div>
                            </a>
                        </li> --}}
                    </ul>
                </li>

                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">Rekap Data</span>
                </li>
                <li class="menu-item {{ Request::is('kolektor/setor-infaq/index*') ? 'active' : '' }}">
                    <a href="{{ url('kolektor/setor-infaq/index') }}" class="menu-link">
                        <i class="menu-icon tf-icons fa-solid fa-file-export"></i>
                        <div data-i18n="Analytics">Data Laporan</div>
                    </a>
                </li>
            @endif
        @endif

    </ul>
</aside>
