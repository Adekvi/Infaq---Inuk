<x-utama.layout.main title="Superadmin | Master Kelurahan">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5 style="margin-bottom: 20px"><strong>Data Kelurahan</strong></h5>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="mb-1" style="display: flex; justify-content: space-between">
                                <h5>Tabel Data</h5>
                                <a href="{{ url('superadmin/master-data/wilayah-kelurahan/tambah-data') }}"
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
                                <div class="w-80 w-md-auto">
                                    <form method="GET" action="{{ route('superadmin.master.kelurahan') }}"
                                        class="d-flex flex-column flex-md-row flex-wrap align-items-stretch gap-2 w-100">
                                        <input type="hidden" name="page" value="1">

                                        {{-- Tampilkan --}}
                                        <div class="d-flex align-items-center gap-2">
                                            <label for="entries" class="form-label mb-0">Tampilkan:</label>
                                            <select name="entries" id="entries" class="form-select form-select-sm"
                                                style="width: 80px;" onchange="this.form.submit()">
                                                <option value="10"
                                                    {{ request('entries', 10) == 10 ? 'selected' : '' }}>
                                                    10
                                                </option>
                                                <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>
                                                    25
                                                </option>
                                                <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>
                                                    50
                                                </option>
                                                <option value="100"
                                                    {{ request('entries') == 100 ? 'selected' : '' }}>100
                                                </option>
                                            </select>
                                        </div>

                                        {{-- Filter Kecamatan --}}
                                        <div class="d-flex flex-grow-1 align-items-center gap-2">
                                            <select name="filter_kecamatan" class="form-select form-select-sm w-100"
                                                style="min-width: 200px;">
                                                <option value="">-- Semua Kecamatan --</option>
                                                @foreach ($kecamatanList as $kecamatan)
                                                    <option value="{{ $kecamatan->id }}"
                                                        {{ request('filter_kecamatan') == $kecamatan->id ? 'selected' : '' }}>
                                                        {{ $kecamatan->nama_kecamatan }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <button type="submit" class="btn btn-sm btn-primary flex-shrink-0">
                                                <i class="bx bxs-filter-alt"></i> Filter</button>
                                        </div>
                                    </form>
                                </div>

                                {{-- Form kanan: Search --}}
                                <div class="w-80 w-md-auto">
                                    <form method="GET" action="{{ route('superadmin.master.kelurahan') }}"
                                        class="d-flex align-items-center gap-2 flex-wrap flex-md-nowrap">
                                        <input type="hidden" name="entries" value="{{ request('entries', 10) }}">
                                        <input type="hidden" name="filter_kecamatan"
                                            value="{{ request('filter_kecamatan') }}">
                                        <input type="hidden" name="page" value="1">

                                        <input type="text" name="search" value="{{ $search }}"
                                            class="form-control form-control-sm flex-grow-1"
                                            placeholder="Cari Nama Kecamatan / Nama Kelurahan">

                                        <button type="submit" class="btn btn-sm btn-primary flex-shrink-0">
                                            <i class='bx bx-search-alt-2'></i> Cari
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered text-center"
                                    style="width:100%">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kecamatan</th>
                                            <th>Kode Kelurahan</th>
                                            <th>Nama Kelurahan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($kelurahan->isEmpty())
                                            <tr>
                                                <td colspan="4" class="text-center">Tidak ada data</td>
                                            </tr>
                                        @else
                                            @foreach ($kelurahan as $index => $item)
                                                <tr>
                                                    <td>{{ $kelurahan->firstItem() + $index }}</td>
                                                    <td>{{ $item->kecamatan->nama_kecamatan ?? '-' }}</td>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->nama_kelurahan }}</td>
                                                    <td>
                                                        <div
                                                            class="d-flex justify-content-center gap-2 align-items-center">
                                                            <a href="{{ url('superadmin/master-data/wilayah-kelurahan/edit-data/' . $item->id) }}"
                                                                class="btn btn-warning btn-sm" data-bs-toggle="tooltip"
                                                                data-bs-offset="0,4" data-bs-placement="top"
                                                                data-bs-html="true"
                                                                data-bs-original-title="<i class='bx bxs-pencil' ></i> <span>Edit Data</span>">
                                                                <i class="bx bxs-pencil"></i> Edit
                                                            </a>
                                                            <span data-bs-toggle="tooltip" data-bs-offset="0,11"
                                                                data-bs-placement="top" data-bs-html="true"
                                                                data-bs-original-title="<i class='bx bxs-trash' ></i> <span>Hapus Data</span>">
                                                                <button type="button"class="btn btn-danger btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#hapus{{ $item->id }}">
                                                                    <i class="bx bxs-trash"></i> Hapus
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
                                    {{ $kelurahan->appends(['entries' => $entries])->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('superadmin.master.data_wilayah.desa.hapus')

    @push('css')
    @endpush

    @push('js')
    @endpush

</x-utama.layout.main>
