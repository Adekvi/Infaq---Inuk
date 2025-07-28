<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" class="form-control border-0 shadow-none" placeholder="Search..."
                    aria-label="Search..." />
            </div>
        </div>
        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    @php
                        use App\Models\Profil\DataDiri;

                        $user = Auth::user();
                        $datadiri = DataDiri::where('id_user', $user->id)->first();
                        $fotoPath =
                            $datadiri && $datadiri->foto && Storage::disk('public')->exists($datadiri->foto)
                                ? Storage::url($datadiri->foto)
                                : asset('admin/img/user.webp');
                    @endphp

                    @if ($user && in_array($user->role, ['superadmin', 'admin_kecamatan', 'admin_kabupaten', 'kolektor']))
                        <div class="avatar avatar-online">
                            <img src="{{ $fotoPath }}" alt="Foto" class="w-px-30 h-auto rounded-circle">
                        </div>
                    @endif
                    {{-- <img src="{{ asset('admin/img/user.webp') }}" alt class="w-px-40 h-auto rounded-circle" /> --}}
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        @if ($user && in_array($user->role, ['superadmin', 'admin_kecamatan', 'admin_kabupaten', 'kolektor']))
                                            <div class="avatar avatar-online">
                                                <img src="{{ $fotoPath }}" alt="Foto"
                                                    class="w-px-30 h-auto rounded-circle">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">{{ Auth::user()->username }}</span>
                                    <small class="text-muted">{{ Auth::user()->no_hp }}</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    @if (Auth::check())
                        @if (AUth::user()->role == 'superadmin')
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bx bx-user me-2"></i>
                                    <span class="align-middle">My Profile</span>
                                </a>
                            </li>
                            {{-- <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bx bx-cog me-2"></i>
                                    <span class="align-middle">Settings</span>
                                </a>
                            </li> --}}
                            <li>
                                <div class="dropdown-divider"></div>
                            </li>
                        @elseif (Auth::user()->role == 'admin_kabupaten')
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bx bx-user me-2"></i>
                                    <span class="align-middle">My Profile</span>
                                </a>
                            </li>
                            {{-- <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bx bx-cog me-2"></i>
                                    <span class="align-middle">Settings</span>
                                </a>
                            </li> --}}
                            <li>
                                <div class="dropdown-divider"></div>
                            </li>
                        @elseif (Auth::user()->role == 'admin_kecamatan')
                            <li>
                                <a class="dropdown-item" href="{{ url('admin_kecamatan/identitas/index') }}">
                                    <i class="bx bx-user me-2"></i>
                                    <span class="align-middle">My Profile</span>
                                </a>
                            </li>
                            {{-- <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bx bx-cog me-2"></i>
                                    <span class="align-middle">Settings</span>
                                </a>
                            </li> --}}
                            <li>
                                <div class="dropdown-divider"></div>
                            </li>
                        @elseif (Auth::user()->role == 'kolektor')
                            <li>
                                <a class="dropdown-item" href="{{ url('kolektor/identitas/index') }}">
                                    <i class="bx bx-user me-2"></i>
                                    <span class="align-middle">My Profile</span>
                                </a>
                            </li>
                            {{-- <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bx bx-cog me-2"></i>
                                    <span class="align-middle">Settings</span>
                                </a>
                            </li> --}}
                            <li>
                                <div class="dropdown-divider"></div>
                            </li>
                        @endif
                    @endif
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">Log Out</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>
