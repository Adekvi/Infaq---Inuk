<x-utama.layout.main title="Dashboard Kolektor">

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
                                    @if (session('kolektor'))
                                        <div class="text-success">
                                            <i class="fa-solid fa-temperature-three-quarters"></i> Sedang Aktif
                                        </div>
                                    @endif
                                    <strong>Donasi {{ $jumlahDonatur }} dari donatur {{ $jumlahDonatur }}
                                        ({{ number_format($persentase, 2) }}%)</strong><br>
                                    {{-- <strong>Rp {{ number_format($totalDonasi, 0, ',', '.') }}</strong> --}}
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
                                    <i class="fa-solid fa-clock fa-2x text-primary"></i>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">
                                    <span id="currentDateTime" class="fw-bold text-dark"></span>
                                </span>
                                <h5 class="card-title mb-2"></h5>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>
                                    Hari, Tanggal/Jam</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <i class="fa-solid fa-money-check-dollar fa-2x text-warning"></i>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Total Donasi</span>
                                <h5 class="card-title mb-2">
                                    <strong>
                                        Rp {{ number_format($totalDonasi ?? 0, 0, ',', '.') ?? '-' }}
                                    </strong>
                                </h5>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>Nominal
                                </small>
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
                                    Rekap Donasi per RW</strong>
                                <hr>
                            </h6>
                            <div class="card-body">
                                @forelse ($rekap_per_rw as $data)
                                    <div class="mb-2">
                                        @php
                                            $rw = $data->Rw;

                                            if (is_array($rw)) {
                                                $rw = $rw[0];
                                            } elseif (is_string($rw) && Str::startsWith($rw, '[')) {
                                                // Kalau masih string JSON, decode dulu
                                                $decoded = json_decode($rw, true);
                                                $rw = is_array($decoded) ? $decoded[0] ?? '-' : $rw;
                                            }
                                        @endphp

                                        <strong>RW {{ $rw ?? '-' }}</strong>

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

            <div class="col-12 col-md-6 col-lg-6 order-3 order-md-2">
                <div class="row">
                    <div class="col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <i class="fa-solid fa-user-lock fa-2x text-info"></i>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Total Donatur</span>
                                <h5 class="card-title mb-2">
                                    <strong>
                                        {{ $jumlahDonatur ?? '-' }}
                                    </strong>
                                </h5>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>Donatur
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <i class="fa-solid fa-hand-holding-dollar fa-2x text-success"></i>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Donasi Disetor</span>
                                <h5 class="card-title mb-2">
                                    <strong>
                                        Rp {{ number_format($donasiDisetor ?? 0, 0, ',', '.') ?? '-' }}
                                    </strong>
                                </h5>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>
                                    Total</small>
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
        <script>
            function updateDateTime() {
                const now = new Date();

                // Format: Kamis, 11 Juli 2025 | 10:24:35
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                const date = now.toLocaleDateString('id-ID', options);
                const time = now.toLocaleTimeString('id-ID');

                document.getElementById('currentDateTime').innerText = `${date} ${time}`;
            }

            setInterval(updateDateTime, 1000); // Update setiap 1 detik
            updateDateTime(); // Jalankan pertama kali
        </script>
    @endpush

</x-utama.layout.main>
