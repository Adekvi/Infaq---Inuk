<div class="container-fluid position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
        <a href="#" class="navbar-brand p-0 d-flex justify-content-between">
            <img src="{{ asset('landing/img/logo.png') }}" alt="Logo">
            <h1 class="text-primary"></i>INUK</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="#" class="nav-item nav-link active">Beranda</a>
                <a href="#" class="nav-item nav-link">Tentang</a>
                <a href="#" class="nav-item nav-link">Program</a>
                <a href="#" class="nav-item nav-link">Berita</a>
                {{-- <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Lainnya</a>
                    <div class="dropdown-menu m-0">
                        <a href="#" class="dropdown-item">Fitur Kami</a>
                        <a href="#" class="dropdown-item">Tim Kami</a>
                        <a href="#" class="dropdown-item">Testimoni</a>
                        <a href="#" class="dropdown-item">Penawaran</a>
                        <a href="#" class="dropdown-item">FAQ</a>
                        <a href="#" class="dropdown-item">404</a>
                    </div>
                </div> --}}
                <a href="#" class="nav-item nav-link">Kontak</a>
                <a href="{{ url('login') }}" class="nav-item nav-link">Login</a>
            </div>
            <a href="https://drive.google.com/file/d/12dNu9BZihV5i-FZSXauUch6ckistM1Qb/view"
                class="btn btn-primary rounded-pill py-2 px-4 my-3 my-lg-0" target="__blank">Donasi
                Sekarang</a>
        </div>
    </nav>

    <!-- Carousel Start -->
    <div class="header-carousel owl-carousel">
        <div class="header-carousel-item">
            <img src="{{ asset('landing/img/carousel/carousel-1.jpg') }}" class="img-fluid w-100" alt="Image">
            <div class="carousel-caption">
                <div class="container">
                    <div class="row gy-0 gx-5 align-items-center">

                        @php
                            $totalDonasi = \App\Models\Role\Transaksi\Penerimaan::sum('nominal');
                            $jumlahDonatur = \App\Models\Role\Transaksi\Penerimaan::count();
                        @endphp

                        {{-- Kolom Statistik di Kiri --}}
                        <div class="col-lg-5 col-xl-5">
                            <div class="row mb-5">
                                <div class="col-6 col-md-6 mb-3">
                                    <div class="stat-card bg-light rounded p-3 shadow-sm text-center">
                                        <i class="fas fa-money-bill-wave fa-3x text-success mb-2"></i>
                                        <h5 class="text-dark mb-0">Rp {{ number_format($totalDonasi, 0, ',', '.') }}
                                        </h5>
                                        <small class="text-muted">Total Donasi</small>
                                    </div>
                                </div>
                                <div class="col-6 col-md-6">
                                    <div class="stat-card bg-light rounded p-3 shadow-sm text-center">
                                        <i class="fas fa-users fa-3x text-info mb-2"></i>
                                        <h5 class="text-dark mb-0">{{ number_format($jumlahDonatur) }}</h5>
                                        <small class="text-muted">Total Donatur</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Konten utama di kanan --}}
                        <div class="col-lg-7 col-xl-7 animated fadeInLeft">
                            <div class="text-sm-center text-md-end">
                                <h4 class="text-primary text-uppercase fw-bold mb-4">Selamat Datang di INUK</h4>
                                <h1 class="display-4 text-uppercase text-white mb-4">Salurkan Infaq untuk Umat &
                                    Kesejahteraan</h1>
                                <p class="mb-5 fs-6">
                                    Bersama LAZISNU, setiap infaq Anda menjadi harapan bagi yang membutuhkan.
                                    INUK hadir untuk menjembatani kebaikan dengan amanah dan transparansi.
                                </p>

                                {{-- Tombol --}}
                                <div class="d-flex justify-content-center justify-content-md-end flex-shrink-0 mb-4">
                                    <a class="btn btn-light rounded-pill py-3 px-4 px-md-5 me-2"
                                        href="https://youtu.be/wBDeLqz_muI?si=tTQwJAF8SlA98zfI" target="__blank">
                                        <i class="fas fa-play-circle me-2"></i> Tonton Video
                                    </a>
                                </div>

                                {{-- Sosial Media --}}
                                <div class="d-flex align-items-center justify-content-center justify-content-md-end">
                                    <h2 class="text-white me-2">Ikuti Kami:</h2>
                                    <div class="d-flex justify-content-end ms-2">
                                        <a class="btn btn-md-square btn-light rounded-circle mx-2"
                                            href="https://www.tiktok.com/@lazisnukudus?_t=ZS-8wL8LERQaGu&_r=1"
                                            target="__blank"><i class="fab fa-tiktok"></i>
                                        </a>
                                        <a class="btn btn-md-square btn-light rounded-circle mx-2"
                                            href="https://www.instagram.com/nucarelazisnukudus?igsh=djF4ZzZ4eGpoeWQ3"
                                            target="__blank"><i class="fab fa-instagram"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <div class="header-carousel-item">
            <img src="{{ asset('landing/img/carousel/carousel-2.jpg') }}" class="img-fluid w-100" alt="Image">
            <div class="carousel-caption">
                <div class="container">
                    <div class="row g-5">
                        <div class="col-12 animated fadeInUp">
                            <div class="text-center">
                                <h4 class="text-primary text-uppercase fw-bold mb-4">Program INUK</h4>
                                <h1 class="display-4 text-uppercase text-white mb-4">Menebar Manfaat Lewat Infaq Anda
                                </h1>
                                <p class="mb-5 fs-5">Melalui program INUK, LAZISNU hadir menjadi solusi penyaluran
                                    infaq
                                    yang tepat guna, penuh keberkahan, dan menyentuh langsung masyarakat yang
                                    membutuhkan.</p>
                                <div class="d-flex justify-content-center justify-content-md-end flex-shrink-0 mb-4">
                                    <a class="btn btn-light rounded-pill py-3 px-4 px-md-5 me-2"
                                        href="https://youtu.be/wBDeLqz_muI?si=tTQwJAF8SlA98zfI" target="__blank"><i
                                            class="fas fa-play-circle me-2"></i> Tonton Video</a>
                                    {{-- <a class="btn btn-primary rounded-pill py-3 px-4 px-md-5 ms-2"
                                        href="#">Pelajari Lebih Lanjut</a> --}}
                                </div>
                                <div class="d-flex align-items-center justify-content-center justify-content-md-end">
                                    <h2 class="text-white me-2">Ikuti Kami:</h2>
                                    <div class="d-flex justify-content-end ms-2">
                                        {{-- <a class="btn btn-md-square btn-light rounded-circle me-2" href="#">
                                                <i class="fab fa-facebook-f"></i>
                                            </a> --}}
                                        <a class="btn btn-md-square btn-light rounded-circle mx-2"
                                            href="https://www.tiktok.com/@lazisnukudus?_t=ZS-8wL8LERQaGu&_r=1"
                                            target="__blank"><i class="fab fa-tiktok"></i>
                                        </a>
                                        <a class="btn btn-md-square btn-light rounded-circle mx-2"
                                            href="https://www.instagram.com/nucarelazisnukudus?igsh=djF4ZzZ4eGpoeWQ3"
                                            target="__blank">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->

</div>

@push('css')
    <style>
        /* Card Statistik seperti tombol */
        .stat-card {
            background-color: #f8f9fa;
            /* warna awal */
            transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }

        .stat-card:hover {
            background-color: #e2e6ea;
            /* warna saat hover */
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        /* Responsif: icon di atas di mobile */
        @media (max-width: 767px) {
            .stat-card {
                flex-direction: column !important;
            }

            .stat-card .me-md-3 {
                margin-right: 0 !important;
                margin-bottom: 0.5rem !important;
            }
        }
    </style>
@endpush
