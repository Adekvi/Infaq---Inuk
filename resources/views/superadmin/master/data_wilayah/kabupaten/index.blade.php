<x-utama.layout.main title="Superadmin | Master Kabupaten">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5><strong>Data Kabupaten</strong></h5>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="mb-1" style="display: flex; justify-content: space-between">
                                <h5>Tabel Data</h5>
                                <a href="{{ url('superadmin/master-data/wilayah-kabupaten/tambah-data') }}"
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
                                class="page d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
                                {{-- Form kiri: Tampilkan & Filter Provinsi --}}
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <form method="GET" action="{{ route('superadmin.master.kabupaten') }}"
                                        class="d-flex flex-wrap align-items-center gap-2">
                                        <input type="hidden" name="page" value="1">

                                        {{-- Tampilkan --}}
                                        <label for="entries" class="me-2">Tampilkan:</label>
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

                                        {{-- (Opsional) Filter Provinsi --}}
                                        {{-- 
                                        <select name="filter_provinsi" class="form-select form-select-sm">
                                            <option value="">-- Semua Provinsi --</option>
                                            @foreach ($provinsiList as $provinsi)
                                                <option value="{{ $provinsi->id }}" {{ request('filter_provinsi') == $provinsi->id ? 'selected' : '' }}>
                                                    {{ $provinsi->namaProvinsi }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="bx bxs-filter-alt"></i> Filter
                                        </button>
                                        --}}
                                    </form>
                                </div>

                                {{-- Form kanan: Search --}}
                                <div class="d-flex flex-wrap align-items-center gap-2 mt-2 mt-md-0">
                                    <form method="GET" action="{{ route('superadmin.master.kabupaten') }}"
                                        class="d-flex flex-wrap align-items-center gap-2">
                                        <input type="hidden" name="entries" value="{{ request('entries', 10) }}">
                                        {{-- <input type="hidden" name="filter_provinsi" value="{{ request('filter_provinsi') }}"> --}}
                                        <input type="hidden" name="page" value="1">

                                        <input type="text" name="search" value="{{ $search }}"
                                            class="form-control form-control-sm" style="width: 200px;"
                                            placeholder="Cari Nama Kabupaten">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class='bx bx-search-alt-2'></i> Cari
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="row">
                                @if ($kabupaten->isEmpty())
                                    <div class="col-12">
                                        <div class="alert alert-info text-center">Tidak ada data</div>
                                    </div>
                                @else
                                    @foreach ($kabupaten as $index => $item)
                                        <div class="col-md-6 col-lg-4 mb-4">
                                            <div class="card shadow-sm border-1 h-100">
                                                <div class="card-body">
                                                    <h6 class="card-title mb-2">
                                                        #{{ $kabupaten->firstItem() + $index }}</h6>
                                                    <div class="mb-1 d-flex">
                                                        <div style="width: 80px;"><strong>Kode</strong>
                                                        </div>
                                                        <span class="me-1">:</span>
                                                        <div>
                                                            {{ $item->id ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="mb-1 d-flex">
                                                        <div style="width: 80px;"><strong>Nama</strong>
                                                        </div>
                                                        <span class="me-1">:</span>
                                                        <div>
                                                            {{ $item->nama_kabupaten ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-start gap-2 mt-2">
                                                        <a href="{{ url('superadmin/master-data/wilayah-kabupaten/edit-data/' . $item->id) }}"
                                                            class="btn btn-warning btn-sm" data-bs-toggle="tooltip"
                                                            title="Edit Data">
                                                            <i class="bx bxs-pencil"></i> Edit
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#hapus{{ $item->id }}"
                                                            title="Hapus Data">
                                                            <i class="bx bxs-trash"></i> Hapus
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <div class="halaman d-flex justify-content-end mt-3">
                                {{ $kabupaten->appends(['entries' => $entries])->links() }}
                            </div>

                            {{-- <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered text-center"
                                    style="width:100%">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Kabupaten</th>
                                            <th>Nama Kabupaten</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($kabupaten->isEmpty())
                                            <tr>
                                                <td colspan="4" class="text-center">Tidak ada data</td>
                                            </tr>
                                        @else
                                            @foreach ($kabupaten as $index => $item)
                                                <tr>
                                                    <td>{{ $kabupaten->firstItem() + $index }}</td>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->nama_kabupaten }}</td>
                                                    <td>
                                                        <a href="{{ url('superadmin/master-data/wilayah-kabupaten/edit-data/' . $item->id) }}"
                                                            class="btn btn-warning rounded-pill"
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

                                <div class="halaman d-flex justify-content-end mt-3">
                                    {{ $kabupaten->appends(['entries' => $entries])->links() }}
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('superadmin.master.data_wilayah.kabupaten.hapus')

    @push('css')
    @endpush

    @push('js')
    @endpush

</x-utama.layout.main>
