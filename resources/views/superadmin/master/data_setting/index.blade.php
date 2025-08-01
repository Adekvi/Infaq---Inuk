<x-utama.layout.main title="Superadmin | Master Jabatan">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5><strong>Data Jabatan</strong></h5>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="mb-1" style="display: flex; justify-content: space-between">
                                <h5>Tabel Data</h5>
                                <a href="{{ url('superadmin/master-data/setting/tambah-data') }}"
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
                                <div class="d-flex align-items-center">
                                    <form method="GET" action="{{ route('superadmin.master.setting') }}"
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
                                    </form>
                                </div>

                                {{-- Form kanan: Search --}}
                                <div class="col-12 col-md-4">
                                    <form method="GET" action="{{ route('superadmin.master.setting') }}">
                                        <div class="row g-2 align-items-end">
                                            <div class="col-8 col-sm-9">
                                                <input type="text" name="search" value="{{ $search }}"
                                                    class="form-control form-control-sm" placeholder="Cari...">
                                            </div>
                                            <div class="col-4 col-sm-3">
                                                <button type="submit" class="btn btn-sm btn-primary w-100">
                                                    <i class="bx bx-search-alt-2"></i> Cari
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="row">
                                @if ($setting->isEmpty())
                                    <div class="col-12">
                                        <div class="alert alert-info text-center">Tidak ada data</div>
                                    </div>
                                @else
                                    @foreach ($setting as $index => $item)
                                        <div class="col-md-6 col-lg-4 mb-4">
                                            <div class="card shadow-sm border-1 h-100">
                                                <div class="card-body">
                                                    <h6 class="card-title mb-2">
                                                        #{{ $setting->firstItem() + $index }} - Setting
                                                    </h6>
                                                    <div class="mb-1 d-flex">
                                                        <div style="width: 100px;"><strong>Nama Setting</strong>
                                                        </div>
                                                        <span class="me-1">:</span>
                                                        <div>
                                                            {{ $item->namasetting ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-start gap-2 mt-2">
                                                        <div
                                                            class="d-flex justify-content-center gap-2 align-items-center">
                                                            <a href="{{ url('superadmin/master-data/setting/edit-data/' . $item->id) }}"
                                                                class="btn btn-sm btn-warning" data-bs-toggle="tooltip"
                                                                data-bs-offset="0,4" data-bs-placement="top"
                                                                data-bs-html="true"
                                                                data-bs-original-title="<i class='bx bxs-pencil' ></i> <span>Edit Data</span>">
                                                                <i class="bx bxs-pencil"></i> Edit
                                                            </a>
                                                            <span data-bs-toggle="tooltip" data-bs-offset="0,11"
                                                                data-bs-placement="top" data-bs-html="true"
                                                                data-bs-original-title="<i class='bx bxs-trash' ></i> <span>Hapus Data</span>">
                                                                <button type="button"class="btn btn-sm btn-danger"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#hapus{{ $item->id }}">
                                                                    <i class="bx bxs-trash"></i> Hapus
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <div class="halaman d-flex justify-content-end mt-3 mt-3">
                                {{ $setting->appends(['entries' => $entries])->links() }}
                            </div>

                            {{-- <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered text-center"
                                    style="width:100%">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Setting</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($setting->isEmpty())
                                            <tr>
                                                <td colspan="3" class="text-center">Tidak ada data</td>
                                            </tr>
                                        @else
                                            @foreach ($setting as $index => $item)
                                                <tr>
                                                    <td>{{ $setting->firstItem() + $index }}</td>
                                                    <td>{{ $item->namasetting }}</td>
                                                    <td>
                                                        <div
                                                            class="d-flex justify-content-center gap-2 align-items-center">
                                                            <a href="{{ url('superadmin/master-data/setting/edit-data/' . $item->id) }}"
                                                                class="btn btn-sm btn-warning" data-bs-toggle="tooltip"
                                                                data-bs-offset="0,4" data-bs-placement="top"
                                                                data-bs-html="true"
                                                                data-bs-original-title="<i class='bx bxs-pencil' ></i> <span>Edit Data</span>">
                                                                <i class="bx bxs-pencil"></i> Edit
                                                            </a>
                                                            <span data-bs-toggle="tooltip" data-bs-offset="0,11"
                                                                data-bs-placement="top" data-bs-html="true"
                                                                data-bs-original-title="<i class='bx bxs-trash' ></i> <span>Hapus Data</span>">
                                                                <button type="button"class="btn btn-sm btn-danger"
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
                                    {{ $setting->appends(['entries' => $entries])->links() }}
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('superadmin.master.data_setting.hapus')

    @push('css')
    @endpush

    @push('js')
    @endpush

</x-utama.layout.main>
