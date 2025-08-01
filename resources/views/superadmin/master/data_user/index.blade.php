<x-utama.layout.main title="Superadmin | Master User">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5 style="margin-bottom: 20px"><strong>Data User</strong></h5>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="mb-1" style="display: flex; justify-content: space-between">
                                <h5>Tabel Data</h5>
                                <a href="{{ url('superadmin/master-data/user/tambah-data') }}"
                                    class="btn btn-primary rounded-pill" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                    data-bs-placement="top" data-bs-html="true"
                                    data-bs-original-title="<i class='bx bxs-file-plus' ></i> <span>Tambah Data</span>">
                                    <i class="bx bxs-file-plus"></i>
                                </a>
                            </div>
                            <hr>
                        </div>
                        <div class="card-body">
                            <div
                                class="page d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-3 flex-wrap">
                                {{-- Form kiri: Tampilkan & Filter --}}
                                <form method="GET" action="{{ route('superadmin.master.user') }}"
                                    class="d-flex flex-wrap gap-3 align-items-end">
                                    <input type="hidden" name="page" value="1">

                                    {{-- Tampilkan --}}
                                    <div class="d-flex flex-column">
                                        <label for="entries" class="form-label mb-1">Tampilkan:</label>
                                        <select name="entries" id="entries" class="form-select form-select-sm"
                                            style="width: 80px;" onchange="this.form.submit()">
                                            <option value="10" {{ request('entries', 10) == 10 ? 'selected' : '' }}>
                                                10</option>
                                            <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25
                                            </option>
                                            <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50
                                            </option>
                                            <option value="100" {{ request('entries') == 100 ? 'selected' : '' }}>100
                                            </option>
                                        </select>
                                    </div>

                                    {{-- Role --}}
                                    @php
                                        $roleList = ['admin_kabupaten', 'admin_kecamatan', 'kolektor'];
                                    @endphp
                                    <div class="d-flex flex-column">
                                        <label for="roles" class="form-label mb-1">Role:</label>
                                        <select name="roles" id="roles" class="form-select form-select-sm"
                                            style="width: 200px;">
                                            <option value="">-- Semua Role --</option>
                                            @foreach ($roleList as $role)
                                                <option value="{{ $role }}"
                                                    {{ request('roles') == $role ? 'selected' : '' }}>
                                                    {{ ucfirst($role) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Jabatan --}}
                                    <div class="d-flex flex-column">
                                        <label for="jabatan" class="form-label mb-1">Jabatan:</label>
                                        <select name="jabatan" id="jabatan" class="form-select form-select-sm"
                                            style="width: 200px;">
                                            <option value="">-- Pilih Jabatan --</option>
                                            @foreach ($setting as $set)
                                                <option value="{{ $set->namasetting }}"
                                                    {{ $jabatan == $set->namasetting ? 'selected' : '' }}>
                                                    {{ $set->namasetting }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Tombol --}}
                                    <div class="d-flex flex-column">
                                        <label class="form-label mb-1">Aksi</label>
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-sm btn-primary"
                                                data-bs-toggle="tooltip" title="Filter Data">
                                                <i class="bx bxs-filter-alt"></i> Filter
                                            </button>
                                            <a href="{{ route('superadmin.master.user') }}"
                                                class="btn btn-sm btn-secondary" data-bs-toggle="tooltip"
                                                title="Reset Filter">
                                                <i class="bx bx-reset"></i> Reset
                                            </a>
                                        </div>
                                    </div>
                                </form>

                                {{-- Form kanan: Search --}}
                                <form method="GET" action="{{ route('superadmin.master.user') }}"
                                    class="d-flex align-items-end gap-2 flex-wrap">
                                    <div class="d-flex flex-column">
                                        <label for="search" class="form-label mb-1">Cari</label>
                                        <input type="text" name="search" value="{{ $search }}" id="search"
                                            class="form-control form-control-sm" placeholder="Cari........">
                                    </div>

                                    <div class="d-flex flex-column">
                                        <label class="form-label mb-1 invisible">Aksi</label>
                                        <button type="submit" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                                            title="Cari Data">
                                            <i class="bx bx-search-alt-2"></i> Cari
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="row">
                                @if ($user->isEmpty())
                                    <div class="col-12">
                                        <div class="alert alert-secondary text-center">Tidak ada data</div>
                                    </div>
                                @else
                                    @foreach ($user as $index => $item)
                                        <div class="col-md-6 col-lg-4 mb-4">
                                            <div class="card shadow-sm h-100">
                                                <div class="card-body">
                                                    <h6 class="card-title">
                                                        #{{ $user->firstItem() + $index }} -
                                                        <i class="fas fa-user"></i>
                                                        <span>{{ $item->username }}</span>
                                                    </h6>
                                                    <form method="POST"
                                                        action="{{ url('superadmin/master-data/update-status') }}">
                                                        @csrf
                                                        <input type="hidden" name="id"
                                                            value="{{ $item->id }}">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                role="switch" id="status_{{ $item->id }}"
                                                                name="status" value="A"
                                                                onchange="this.form.submit()"
                                                                {{ $item->status === 'A' ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="status_{{ $item->id }}">
                                                                {{ $item->status === 'A' ? 'Aktif' : 'Nonaktif' }}
                                                            </label>
                                                        </div>
                                                    </form>
                                                    <hr>
                                                    <div class="mb-1 d-flex">
                                                        <div style="width: 120px;"><strong>Jabatan</strong>
                                                        </div>
                                                        <span class="me-1">:</span>
                                                        <div>
                                                            {{ $item->setting->namasetting ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="mb-1 d-flex">
                                                        <div style="width: 120px;"><strong>No. Hp</strong>
                                                        </div>
                                                        <span class="me-1">:</span>
                                                        <div>
                                                            {{ $item->no_hp ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="mb-1 d-flex">
                                                        <div style="width: 120px;"><strong>Role</strong>
                                                        </div>
                                                        <span class="me-1">:</span>
                                                        <div>
                                                            {{ $item->formatted_role ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="mb-1 d-flex">
                                                        <div style="width: 120px;"><strong>Email</strong>
                                                        </div>
                                                        <span class="me-1">:</span>
                                                        <div>
                                                            {{ $item->email ?? '-' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="card-footer bg-white border-top-0 d-flex justify-content-end gap-2">
                                                    <a href="{{ url('superadmin/master-data/user/edit-data/' . $item->id) }}"
                                                        class="btn btn-warning btn-sm d-flex align-items-center gap-1">
                                                        <i class="bx bxs-pencil"></i> Edit
                                                    </a>
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm d-flex align-items-center gap-1"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#hapus{{ $item->id }}">
                                                        <i class="bx bxs-trash"></i> Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    {{-- Pagination --}}
                                    <div class="col-12 mt-3 d-flex justify-content-end">
                                        {{ $user->appends(['entries' => $entries])->links() }}
                                    </div>
                                @endif
                            </div>

                            {{-- <div class="table-responsive">
                                <table id="example" class="table table-bordered table-striped text-center">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Jabatan</th>
                                            <th>Username</th>
                                            <th>No. Hp</th>
                                            <th>Role</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($user->isEmpty())
                                            <tr>
                                                <td colspan="8" class="text-center text-muted">Tidak ada data</td>
                                            </tr>
                                        @else
                                            @foreach ($user as $index => $item)
                                                <tr>
                                                    <td>{{ $user->firstItem() + $index }}</td>
                                                    <td>{{ $item->setting->namasetting ?? '-' }}</td>
                                                    <td>{{ $item->username }}</td>
                                                    <td>{{ $item->no_hp }}</td>
                                                    <td>
                                                        {{ $item->formatted_role }}
                                                    </td>
                                                    <td>{{ $item->email ?? '-' }}</td>
                                                    <td>
                                                        @if ($item->status == 'A')
                                                            <span class="badge bg-success"><i
                                                                    class="fas fa-check-circle me-1"></i> Aktif</span>
                                                        @else
                                                            <span class="badge bg-secondary"><i
                                                                    class="fas fa-ban me-1"></i> Non-aktif</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div
                                                            class="d-flex justify-content-center gap-2 align-items-center">
                                                            <a href="{{ url('superadmin/master-data/user/edit-data/' . $item->id) }}"
                                                                class="btn btn-sm btn-warning d-flex align-items-center gap-1"
                                                                data-bs-toggle="tooltip" data-bs-offset="0,11"
                                                                data-bs-placement="top" data-bs-html="true"
                                                                data-bs-original-title="<i class='bx bxs-pencil'></i><span>Edit Data</span>">
                                                                <i class="bx bxs-pencil"></i> <span>Edit</span>
                                                            </a>

                                                            <span data-bs-toggle="tooltip" data-bs-offset="0,11"
                                                                data-bs-placement="top" data-bs-html="true"
                                                                data-bs-original-title="<i class='bx bxs-trash'></i><span>Hapus Data</span>">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-danger d-flex align-items-center gap-1"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#hapus{{ $item->id }}">
                                                                    <i class="bx bxs-trash"></i> <span>Hapus</span>
                                                                </button>
                                                            </span>
                                                        </div>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>

                                <div class="halaman d-flex justify-content-end mt-3 mt-3">
                                    {{ $user->appends(['entries' => $entries])->links() }}
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('superadmin.master.data_user.hapus')

    @push('css')
        <style>
            .status-wrapper {
                display: flex;
                align-items: center;
                gap: 10px;
                font-family: 'Segoe UI', sans-serif;
            }

            /* Hide the default checkbox */
            .status-wrapper input[type="checkbox"] {
                display: none;
            }

            /* Custom switch style */
            .status-button {
                position: relative;
                display: inline-block;
                width: 50px;
                height: 26px;
                background-color: #ccc;
                border-radius: 50px;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            .status-button::after {
                content: "";
                position: absolute;
                top: 3px;
                left: 3px;
                width: 20px;
                height: 20px;
                background-color: white;
                border-radius: 50%;
                transition: transform 0.3s;
            }

            /* Checked state */
            .status-wrapper input[type="checkbox"]:checked+.status-button {
                background-color: #696cff;
            }

            .status-wrapper input[type="checkbox"]:checked+.status-button::after {
                transform: translateX(24px);
            }

            .status-text span {
                font-size: 14px;
                font-weight: 500;
                color: #333;
            }
        </style>
    @endpush

    @push('js')
    @endpush

</x-utama.layout.main>
