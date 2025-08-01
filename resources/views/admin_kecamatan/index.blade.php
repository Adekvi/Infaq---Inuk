<x-utama.layout.main title="Dashboard Admin Kecamatan">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-6 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h4 class="card-title text-primary">Selamat Datang, <span
                                        class="text-info">{{ Auth::user()->username ?? '-' }}!</span></h4>
                                <p class="mb-4">
                                    @if (session('admin_kecamatan'))
                                        <div class="text-success">
                                            <i class="fa-solid fa-temperature-three-quarters"></i> Sedang Aktif
                                        </div>
                                    @endif
                                    <strong>
                                        Donasi {{ $kolektor_mengirim_bulan_ini }} dari donatur
                                        {{ $total_kolektor }}
                                        ({{ number_format($persentase_mengirim, 2) }}%)
                                    </strong>
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="{{ asset('admin/img/illustrations/man-with-laptop-light.png') }}"
                                    height="140" alt="View Badge User"
                                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-4 order-1">
                <div class="row">
                    <!-- Total Donasi Tahunan -->
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <i class="fa-solid fa-sack-dollar fa-2x text-primary"></i>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Total Donasi Tahun {{ now()->year }}</span>
                                <small class="text-success fw-semibold"><i
                                        class="bx bx-up-arrow-alt"></i>Nominal</small>
                                <h6 class="card-title mb-2">
                                    <strong>Rp {{ number_format($total_donasi_tahun, 0, ',', '.') }}</strong>
                                </h6>
                            </div>
                        </div>
                    </div>

                    <!-- Total Donasi Bulanan -->
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <i class="fa-solid fa-comments-dollar fa-2x text-warning"></i>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Total Donasi Bulan
                                    {{ now()->translatedFormat('F') }}</span>
                                <small class="text-success fw-semibold"><i
                                        class="bx bx-up-arrow-alt"></i>Nominal</small>
                                <h6 class="card-title mb-2">
                                    <strong>Rp
                                        {{ number_format($total_donasi_per_bulan[now()->translatedFormat('F')] ?? 0, 0, ',', '.') }}</strong>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 order-2 order-md-3 order-lg-2 mb-4">
                <div class="card">
                    <div class="row row-bordered g-0">
                        <div class="col-md-12">
                            <h6 class="card-header m-0 me-2 pb-3">
                                <strong>Rekap Donasi per RW</strong>
                                <hr>
                            </h6>
                            <div class="card-body">
                                @forelse ($rekap_per_rw as $data)
                                    <div class="mb-2">
                                        <strong>RW {{ $data->Rw ?? '-' }}</strong>
                                        <div class="d-flex flex-column flex-md-row justify-content-between">
                                            <div>
                                                <span>
                                                    {{ number_format($data->jumlah_donatur_mengirim, 0, ',', '.') }}
                                                    dari {{ number_format($data->total_donatur, 0, ',', '.') }} donatur
                                                    ({{ number_format($data->persentase, 2) }}%)
                                                </span>
                                            </div>
                                            <div class="text-md-end">
                                                <span>
                                                    Rp {{ number_format($data->total_donasi, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="mb-0 text-center">Tidak ada data untuk bulan ini</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 order-2 order-md-3 order-lg-2 mb-4">
                <div class="card">
                    <div class="row row-bordered g-0">
                        <div class="col-md-12">
                            <h6 class="card-header m-0 me-2 pb-3">
                                <strong>
                                    <i class="fa-solid fa-location-dot"></i>
                                    Rekap Donasi per Kelurahan</strong>
                                <hr>
                            </h6>
                            <div class="card-body">
                                @forelse ($rekap_per_kelurahan as $data)
                                    <div class="mb-2">
                                        <strong>Kelurahan
                                            {{ $data->nama_kelurahan ?? ($data->id_kelurahan ?? '-') }}</strong>
                                        <div class="d-flex flex-column flex-md-row justify-content-between">
                                            <div>
                                                <span>
                                                    {{ number_format($data->jumlah_donatur_mengirim, 0, ',', '.') }}
                                                    dari {{ number_format($data->total_donatur, 0, ',', '.') }} donatur
                                                    ({{ number_format($data->persentase, 2) }}%)
                                                </span>
                                            </div>
                                            <div class="text-md-end">
                                                <span>
                                                    Rp {{ number_format($data->total_donasi, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="mb-0 text-center">Tidak ada data untuk bulan ini</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-12 col-md-6 col-lg-6 order-3 order-md-2">
                <div class="row">
                    <div class="col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <i class="fa-solid fa-solid fa-stethoscope fa-2x text-success"></i>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Transaksi</span>
                                <h6 class="card-title mb-2"></h6>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>
                                    +100%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <i class="fa-solid fa-notes-medical fa-2x text-info"></i>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Tagihan</span>
                                <h6 class="card-title mb-2"></h6>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>
                                    +100%</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>

    @push('css')
    @endpush

    @push('js')
    @endpush

</x-utama.layout.main>
