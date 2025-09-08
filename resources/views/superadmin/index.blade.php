<x-utama.layout.main title="Dashboard Superadmin">

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
                                    @if (session('superadmin'))
                                        <div class="text-success">
                                            <i class="fa-solid fa-temperature-three-quarters"></i> Sedang Aktif
                                        </div>
                                    @endif
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
                                <span class="fw-semibold d-block mb-1">Total Donasi Tahun {{ now()->year }} </span>
                                <h6 class="card-title mb-2">
                                    <strong>
                                        Rp {{ number_format($total_donasi_tahun, 0, ',', '.') }}
                                    </strong>
                                </h6>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>
                                    Nominal
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <i class="fa-solid fa-calendar-check fa-2x text-warning"></i>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Donasi Bulan
                                    {{ now()->translatedFormat('F') }}</span>
                                <h6 class="card-title mb-2">
                                    <strong>Rp
                                        {{ number_format($total_donasi_per_bulan[now()->translatedFormat('F')] ?? 0, 0, ',', '.') }}</strong>
                                </h6>
                                <small class="text-success fw-semibold"><i
                                        class="bx bx-up-arrow-alt"></i>Nominal</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 order-2 order-md-3 order-lg-2 mb-4">
                <div class="card">
                    <div class="row row-bordered g-0">
                        <div class="col-md-12">
                            <h5 class="card-header m-0 me-2 pb-3">Grafik Pembayaran</h5>
                            <div id="totalRevenueChart" class="px-2"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6 order-3 order-md-2">
                <div class="row">
                    <div class="col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <i class="fa-solid fa-chalkboard-user fa-2x text-secondary"></i>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Jumlah Donatur</span>
                                <h6 class="card-title mb-2">
                                    <strong>
                                        {{ $jumlahDonatur ?? '0' }}
                                    </strong>
                                </h6>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>
                                    Donatur
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <i class="fa-solid fa-comments-dollar fa-2x text-danger"></i>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Donasi Diterima</span>
                                <h6 class="card-title mb-2">
                                    <strong>
                                        Rp {{ number_format($donatur_diterima, 0, ',', '.') }}
                                    </strong>
                                </h6>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>
                                    Nominal
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <i class="fa-solid fa-money-bill-transfer fa-2x text-success"></i>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Donasi dikirim</span>
                                <h6 class="card-title mb-2">
                                    <strong>
                                        Rp {{ number_format($donatur_dikirim, 0, ',', '.') }}
                                    </strong>
                                </h6>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>
                                    Nominal
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <i class="fa-solid fa-id-badge fa-2x text-dark"></i>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Jumlah Kolektor</span>
                                <h6 class="card-title mb-2">
                                    <strong>
                                        {{ $total_kolektor ?? '-' }}
                                    </strong>
                                </h6>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>
                                    Orang
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('css')
    @endpush

    @push('js')
    @endpush

</x-utama.layout.main>
