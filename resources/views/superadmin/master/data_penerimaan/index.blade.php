<x-utama.layout.main title="Superadmin | Master Data Penerimaan">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5 style="margin-bottom: 20px"><strong>Data Penerimaan</strong></h5>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="mb-1" style="display: flex; justify-content: space-between">
                                <h5>Tabel Data</h5>
                                <a href="{{ url('superadmin/master-data/penerimaan/tambah-data') }}"
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
                                <form method="GET" action="{{ route('superadmin.master.penerimaan') }}"
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

                                    {{-- Tombol --}}
                                    <div class="d-flex flex-column">
                                        <label class="form-label mb-1">Aksi</label>
                                        <div class="d-flex gap-2">
                                            {{-- <button type="submit" class="btn btn-sm btn-primary"
                                                data-bs-toggle="tooltip" title="Filter Data">
                                                <i class="bx bxs-filter-alt"></i> Filter
                                            </button> --}}
                                            <a href="{{ route('superadmin.master.penerimaan') }}"
                                                class="btn btn-sm btn-secondary" data-bs-toggle="tooltip"
                                                title="Reset Filter">
                                                <i class="bx bx-reset"></i> Reset
                                            </a>
                                        </div>
                                    </div>
                                </form>

                                {{-- Form kanan: Search --}}
                                <form method="GET" action="{{ route('superadmin.master.penerimaan') }}"
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
                            <hr>

                            <div class="row">
                                @if ($dataterima->isEmpty())
                                    <div class="col-12">
                                        <div class="alert alert-secondary text-center">Tidak ada data</div>
                                    </div>
                                @else
                                    <?php
                                    if (!function_exists('Rupiah')) {
                                        function Rupiah($angka)
                                        {
                                            return 'Rp ' . number_format((float) $angka, 0, ',', '.');
                                        }
                                    }
                                    ?>
                                    @foreach ($dataterima as $index => $item)
                                        <div class="col-md-6 col-lg-4 mb-4">
                                            <div class="card shadow-sm border-1 h-100">
                                                <div class="card-body">
                                                    <h6 class="card-title">
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                                #{{ $dataterima->firstItem() + $index }} -
                                                                <i class="fas fa-user"></i>
                                                            </div>
                                                            <span
                                                                class="text-primary">{{ Carbon\Carbon::parse($item->tgl ?? '-')->format('d-m-Y') }}</span>
                                                        </div>
                                                        <hr>
                                                    </h6>
                                                    <div class="mb-1 d-flex">
                                                        <div style="width: 100px;"><strong>No. Alat</strong>
                                                        </div>
                                                        <span class="me-1">:</span>
                                                        <div>
                                                            {{ $item->no_alat ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="mb-1 d-flex">
                                                        <div style="width: 100px;"><strong>Nama</strong>
                                                        </div>
                                                        <span class="me-1">:</span>
                                                        <div>
                                                            {{ $item->nama_donatur ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="mb-1 d-flex">
                                                        <div style="width: 100px;"><strong>Jenis</strong>
                                                        </div>
                                                        <span class="me-1">:</span>
                                                        <div>
                                                            {{ $item->jenis ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="mb-1 d-flex">
                                                        <div style="width: 100px;"><strong>Alamat</strong>
                                                        </div>
                                                        <span class="me-1">:</span>
                                                        <div>
                                                            {{ $item->alamat ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="mb-1 d-flex">
                                                        <div style="width: 100px;"><strong>Nominal</strong>
                                                        </div>
                                                        <span class="me-1">:</span>
                                                        <div>
                                                            {{ Rupiah($item->nominal ?? '-') }}
                                                        </div>
                                                    </div>
                                                    <div class="mt-2">
                                                        <a href="{{ url('superadmin/master-data/penerimaan/edit-data/' . $item->id) }}"
                                                            class="btn btn-warning btn-sm">
                                                            <i class="bx bxs-pencil"></i> Edit
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#hapus{{ $item->id }}">
                                                            <i class="bx bxs-trash"></i> Hapus
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    {{-- Pagination --}}
                                    <div class="col-12 mt-3 d-flex justify-content-end">
                                        {{ $dataterima->appends(['entries' => $entries])->links() }}
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

    @include('superadmin.master.data_penerimaan.hapus')

    @push('css')
    @endpush

    @push('js')
    @endpush

</x-utama.layout.main>
