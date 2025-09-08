<x-utama.layout.main title="Superadmin | Setting Landing Page">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5><strong>Setting Landing Page</strong></h5>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="mb-1" style="display: flex; justify-content: space-between">
                                <h5>Tabel Data</h5>
                                <a href="{{ url('superadmin/landing/halaman-navbar/tambah-data') }}"
                                    class="btn btn-primary rounded-pill" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                    data-bs-placement="top" data-bs-html="true"
                                    data-bs-original-title="<i class='bx bxs-file-plus' ></i> <span>Tambah Data</span>">
                                    <i class="bx bxs-file-plus"></i>
                                </a>
                            </div>
                            <hr>
                        </div>
                        <div class="card-body">
                            <div class="container-fluid mb-3">
                                <div class="row gy-3 align-items-end">
                                    <!-- Kolom Kiri: Tampilkan & Filter -->
                                    <div class="col-12 col-md-8">
                                        <form method="GET" action="{{ route('superadmin.landing.halaman1') }}">
                                            <div class="row gy-2 gx-3 align-items-end">
                                                <!-- Tampilkan -->
                                                <div class="col-auto">
                                                    <label for="entries" class="form-label mb-0">Tampilkan:</label>
                                                    <select name="entries" id="entries"
                                                        class="form-select form-select-sm"
                                                        onchange="this.form.submit()">
                                                        <option value="10"
                                                            {{ request('entries', 10) == 10 ? 'selected' : '' }}>10
                                                        </option>
                                                        <option value="25"
                                                            {{ request('entries') == 25 ? 'selected' : '' }}>25</option>
                                                        <option value="50"
                                                            {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                                                        <option value="100"
                                                            {{ request('entries') == 100 ? 'selected' : '' }}>100
                                                        </option>
                                                    </select>
                                                </div>

                                                <!-- Tombol Aksi -->
                                                <div class="col-auto d-flex gap-2 align-items-end">
                                                    {{-- <button type="submit" class="btn btn-sm btn-primary">
                                                        <i class="bx bxs-filter-alt"></i> Filter
                                                    </button> --}}
                                                    <a href="{{ route('superadmin.landing.halaman1') }}"
                                                        class="btn btn-sm btn-secondary">
                                                        <i class="bx bx-reset"></i> Reset
                                                    </a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Kolom Kanan: Search -->
                                    <div class="col-12 col-md-4">
                                        <form method="GET" action="{{ route('superadmin.landing.halaman1') }}">
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
                            </div>

                            <div class="row">
                                @if ($halaman1->isEmpty())
                                    <div class="col-12">
                                        <div class="alert alert-info text-center">
                                            <i class="fa-solid fa-folder-open"></i> Tidak ada data
                                        </div>
                                    </div>
                                @else
                                    @foreach ($halaman1 as $index => $item)
                                        <div class="col-md-6 col-lg-4 mb-4">
                                            <div class="card shadow-sm border-1 h-100">
                                                <div class="card-body">
                                                    <h6 class="card-title mb-2">
                                                        <div class="d-flex justify-content-between">
                                                            #{{ $halaman1->firstItem() + $index }} - Navbar
                                                            <form method="POST"
                                                                action="{{ url('superadmin/landing/halaman1-status') }}">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $item->id }}">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        role="switch" id="status_{{ $item->id }}"
                                                                        name="status" value="Aktif"
                                                                        onchange="this.form.submit()"
                                                                        {{ $item->status === 'Aktif' ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="status_{{ $item->id }}">
                                                                        {{ $item->status === 'Aktif' ? 'Aktif' : 'Nonaktif' }}
                                                                    </label>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </h6>
                                                    <hr>
                                                    <div class="mb-1 d-flex">
                                                        <div style="width: 100px;">
                                                            <strong>
                                                                <i class="fa-solid fa-pen-to-square"></i> Judul 1
                                                            </strong>
                                                        </div>
                                                        <span class="me-1">:</span>
                                                        <div>
                                                            {{ $item->judul1 ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <div class="mb-1 d-flex">
                                                        <div style="width: 100px;">
                                                            <strong>
                                                                <i class="fa-solid fa-pen-to-square"></i> Judul 2
                                                            </strong>
                                                        </div>
                                                        <span class="me-1">:</span>
                                                        <div>
                                                            {{ $item->judul2 ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="d-flex justify-content-start gap-2 mt-3">
                                                        <div
                                                            class="d-flex justify-content-center gap-2 align-items-center">
                                                            <span data-bs-toggle="tooltip" data-bs-offset="0,11"
                                                                data-bs-placement="top" data-bs-html="true"
                                                                data-bs-original-title="<i class='bx bxs-info-circle' ></i> <span>Detail</span>">
                                                                <button type="button" class="btn btn-sm btn-info"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#detail{{ $item->id }}">
                                                                    <i class="bx bxs-info-circle"></i> Detail
                                                                </button>
                                                            </span>
                                                            <a href="{{ url('superadmin/master-data/halaman-navbar/edit-data/' . $item->id) }}"
                                                                class="btn btn-sm btn-warning" data-bs-toggle="tooltip"
                                                                data-bs-offset="0,4" data-bs-placement="top"
                                                                data-bs-html="true"
                                                                data-bs-original-title="<i class='bx bxs-pencil' ></i> <span>Edit Data</span>">
                                                                <i class="bx bxs-pencil"></i> Edit
                                                            </a>
                                                            <span data-bs-toggle="tooltip" data-bs-offset="0,11"
                                                                data-bs-placement="top" data-bs-html="true"
                                                                data-bs-original-title="<i class='bx bxs-trash' ></i> <span>Hapus Data</span>">
                                                                <button type="button" class="btn btn-sm btn-danger"
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
                                {{ $halaman1->appends(['entries' => $entries])->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('superadmin.landing.navbar.modal.detail')
    @include('superadmin.landing.navbar.hapus')

    @push('css')
    @endpush

    @push('js')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @endpush

</x-utama.layout.main>
