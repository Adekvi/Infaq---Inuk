<x-utama.layout.main title="Superadmin | Master Data Admin">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5 style="margin-bottom: 20px"><strong>Master Data Admin</strong></h5>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="mb-1" style="display: flex; justify-content: space-between">
                                <h5>Tabel Data</h5>
                                {{-- <a href="{{ url('superadmin/master-data/petugas-dataPetugas/tambah-data') }}"
                                    class="btn btn-primary rounded-pill" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                    data-bs-placement="top" data-bs-html="true"
                                    data-bs-original-title="<i class='bx bxs-file-plus' ></i> <span>Tambah Data</span>">
                                    <i class="bx bxs-file-plus"></i>
                                </a> --}}
                            </div>
                            <hr style="height: 2px; border: none">
                        </div>
                        <div class="card-body">
                            <div class="page d-flex justify-content-between align-items-center mb-3">
                                {{-- Form kiri: Tampilkan & Filter Provinsi --}}
                                <div class="d-flex align-items-center">
                                    <form method="GET" action="{{ route('superadmin.master.dataAdmin') }}"
                                        class="d-flex align-items-center">
                                        <input type="hidden" name="page" value="1">

                                        {{-- Tampilkan --}}
                                        <label for="entries" class="me-2">Tampilkan:</label>
                                        <select name="entries" id="entries" class="form-select form-select-sm me-3"
                                            style="width: 80px;" onchange="this.form.submit()">
                                            <option value="10" {{ request('entries', 10) == 10 ? 'selected' : '' }}>
                                                10
                                            </option>
                                            <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25
                                            </option>
                                            <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50
                                            </option>
                                            <option value="100" {{ request('entries') == 100 ? 'selected' : '' }}>100
                                            </option>
                                        </select>

                                        {{-- Filter Provinsi --}}
                                        {{-- <select name="filter_wilayah" class="form-select form-select-sm me-2">
                                            <option value="">-- Semua Wilayah --</option>
                                            @foreach ($wilayahList as $wil)
                                                <option value="{{ $wil->id }}"
                                                    {{ request('filter_wilayah') == $wil->id ? 'selected' : '' }}>
                                                    {{ $wil->namaWilayah }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <button type="submit" class="btn btn-sm btn-primary" style="width: 150px;">
                                            <i class="bx bxs-filter-alt"></i> Filter</button> --}}
                                    </form>
                                </div>

                                {{-- Form kanan: Search --}}
                                <div>
                                    <form method="GET" action="{{ route('superadmin.master.dataAdmin') }}"
                                        class="d-flex align-items-center">
                                        <input type="hidden" name="entries" value="{{ request('entries', 10) }}">
                                        {{-- <input type="hidden" name="filter_wilayah"
                                            value="{{ request('filter_wilayah') }}"> --}}
                                        <input type="hidden" name="page" value="1">

                                        <input type="text" name="search" value="{{ $search }}"
                                            class="form-control form-control-sm me-2" style="width: 200px;"
                                            placeholder="Cari Username">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class='bx bx-search-alt-2'></i> Cari
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered text-center"
                                    style="width:100%; white-space: nowrap">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Username</th>
                                            <th>No. Hp</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($useradmin->isEmpty())
                                            <tr>
                                                <td colspan="4" class="text-center">Tidak ada data</td>
                                            </tr>
                                        @else
                                            @foreach ($useradmin as $index => $item)
                                                <tr>
                                                    <td>{{ $useradmin->firstItem() + $index }}</td>
                                                    <td>
                                                        {{ $item->username }}
                                                    </td>
                                                    <td>{{ $item->no_hp }}</td>
                                                    <td>
                                                        <form method="POST"
                                                            action="{{ route('admin-master.data.status') }}">
                                                            @csrf
                                                            <input type="hidden" name="id"
                                                                value="{{ $item->id }}">
                                                            <div class="status-wrapper">
                                                                <input type="checkbox" name="status"
                                                                    id="status_{{ $item->id }}" value="A"
                                                                    onchange="this.form.submit()"
                                                                    {{ $item->status === 'A' ? 'checked' : '' }}>
                                                                <label for="status_{{ $item->id }}"
                                                                    class="status-button"></label>
                                                                <div class="status-text">
                                                                    <span>{{ $item->status === 'A' ? 'Aktif' : 'Nonaktif' }}</span>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <a href="#" class="btn btn-warning rounded-pill"
                                                            data-bs-toggle="tooltip" data-bs-offset="0,4"
                                                            data-bs-placement="top" data-bs-html="true"
                                                            data-bs-original-title="<i class='bx bxs-pencil' ></i> <span>Edit Data</span>">
                                                            <i class="bx bxs-pencil"></i> Edit
                                                        </a>
                                                        <span data-bs-toggle="tooltip" data-bs-offset="0,11"
                                                            data-bs-placement="top" data-bs-html="true"
                                                            data-bs-original-title="<i class='bx bxs-trash' ></i> <span>Hapus Data</span>">
                                                            <button type="button"class="btn btn-danger rounded-pill"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#hapus{{ $item->id }}">
                                                                <i class="bx bxs-trash"></i> Hapus
                                                            </button>
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>

                                <div class="halaman d-flex justify-content-end">
                                    {{ $useradmin->appends(['entries' => $entries])->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @include('superadmin.master.data_petugas.hapus') --}}

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

</x-utama.layout.main>
