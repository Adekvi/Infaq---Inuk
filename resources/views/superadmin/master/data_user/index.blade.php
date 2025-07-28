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
                            <hr style="height: 2px; border: none">
                        </div>
                        <div class="card-body">
                            <div
                                class="page d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-3">
                                {{-- Form kiri: Tampilkan & Filter Provinsi --}}
                                <div class="d-flex align-items-end">
                                    <form method="GET" action="{{ route('superadmin.master.user') }}"
                                        class="d-flex align-items-end flex-wrap gap-2">

                                        <input type="hidden" name="page" value="1">

                                        {{-- Tampilkan --}}
                                        <div class="d-flex flex-column">
                                            <label for="entries" class="form-label">Tampilkan:</label>
                                            <select name="entries" id="entries" class="form-select form-select-sm"
                                                style="width: 80px;" onchange="this.form.submit()">
                                                <option value="10"
                                                    {{ request('entries', 10) == 10 ? 'selected' : '' }}>10</option>
                                                <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>
                                                    25</option>
                                                <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>
                                                    50</option>
                                                <option value="100"
                                                    {{ request('entries') == 100 ? 'selected' : '' }}>100</option>
                                            </select>
                                        </div>

                                        <!-- Filter Jabatan -->
                                        <div class="d-flex align-items-end gap-2 flex-wrap">

                                            {{-- Dropdown Role --}}
                                            @php
                                                $roleList = ['admin_kabupaten', 'admin_kecamatan', 'kolektor']; // Sesuaikan dengan role yang kamu punya
                                            @endphp
                                            <div class="d-flex flex-column">
                                                <label for="roles" class="form-label">Role:</label>
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

                                            <div class="d-flex flex-column">
                                                <label for="jabatan" class="form-label">Jabatan:</label>
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

                                            {{-- Tombol Filter & Reset --}}
                                            <div class="flex-column">
                                                <label class="form-label invisible">Aksi</label> {{-- Label tersembunyi agar sejajar --}}
                                                <div class="d-flex gap-2">
                                                    <button type="submit" data-bs-toggle="tooltip"
                                                        data-bs-offset="0,11" data-bs-placement="top"
                                                        data-bs-html="true"
                                                        data-bs-original-title="<i class='bx bxs-filter-alt'></i><span>Filter Data</span>"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="bx bxs-filter-alt"></i> Filter
                                                    </button>
                                                    <a href="{{ route('superadmin.master.user') }}"
                                                        class="btn btn-sm btn-secondary" data-bs-toggle="tooltip"
                                                        data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
                                                        title="<i class='bx bx-reset'></i> <span>Reset Filter</span>">
                                                        <i class='bx bx-reset'></i> Reset
                                                    </a>
                                                </div>
                                            </div>

                                        </div>

                                    </form>
                                </div>


                                {{-- Form kanan: Search --}}
                                <div class="w-80 w-md-auto">
                                    <label class="form-label invisible">Aksi</label>
                                    <form method="GET" action="{{ route('superadmin.master.user') }}"
                                        class="d-flex align-items-center gap-2 flex-wrap flex-md-nowrap">

                                        <input type="text" name="search" value="{{ $search }}"
                                            class="form-control form-control-sm flex-grow-1" placeholder="Cari........">

                                        <button type="submit" data-bs-toggle="tooltip" data-bs-offset="0,11"
                                            data-bs-placement="top" data-bs-html="true"
                                            data-bs-original-title="<i class='bx bx-search'></i><span>Cari Data</span>"
                                            class="btn btn-sm btn-primary flex-shrink-0">
                                            <i class='bx bx-search-alt-2'></i> Cari
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('superadmin.master.data_user.hapus')

    @push('css')
    @endpush

    @push('js')
    @endpush

</x-utama.layout.main>
