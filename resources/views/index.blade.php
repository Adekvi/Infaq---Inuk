<x-sekunder.terminal.home title="Landing Page">

    <!-- Tambahkan di bawah <hr> dan sebelum ringkasan kecamatan -->
    <div class="marquee-container mt-2">
        <span id="timeDisplay" class="time-text">
            <strong>00:00</strong>
        </span>
        <div class="marquee-wrapper">
            <div id="donasiMarquee" class="marquee-text"></div>
        </div>
        <span id="inukText" class="inuk-text">
            <strong>INUK</strong>
        </span>
    </div>

    <div class="container-fluid rekap py-5">
        <div class="container pb-5">
            <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h4 class="text-primary fw-bold">Rekap Donasi</h4>
                <h1 class="display-6 mb-2">Per Wilayah</h1>
                <p class="text-muted">Pilih kecamatan untuk melihat rekap donasi dari masing-masing desa. Gunakan fitur
                    pencarian untuk memfilter desa.</p>
                <!-- Dropdown Kecamatan -->
                <div class="kecamatan mb-3">
                    <label for="kecamatanSelect" class="form-label fw-bold">Pilih Kecamatan</label>
                    <select id="kecamatanSelect" class="form-select rounded-3 shadow-sm" onchange="updateData()">
                        <option value="">Semua Kecamatan</option>
                        @foreach ($kecamatans as $id => $nama)
                            <option value="{{ $id }}">{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Pencarian -->
                <div class="input-group mb-4" style="max-width: 400px; margin: 0 auto;">
                    <input type="text" id="searchInput" class="form-control rounded-3"
                        placeholder="Cari nama desa..." onkeyup="updateData()">
                    <button class="btn btn-primary" onclick="clearSearch()">Clear</button>
                </div>
            </div>
            <hr>
            <!-- Ringkasan Kecamatan -->
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-12 col-md-6">
                    <div class="card shadow-sm rounded-4 mb-4">
                        <div class="card-body">
                            <h6 class="text-primary fw-bold text-center">
                                <i class="fas fa-file"></i> Ringkasan Kecamatan
                            </h6>
                            <div id="kecamatanSummary" class="text-muted">
                                <div class="mb-1 d-flex align-items-center summary-row">
                                    <div class="summary-label">Kecamatan</div>
                                    <span class="summary-colon mx-2">:</span>
                                    <div id="namaKecamatan" class="fw-bold text-primary">-</div>
                                    <!-- Ditambahkan class text-primary untuk highlight -->
                                </div>
                                <div class="mb-1 d-flex align-items-center summary-row">
                                    <div class="summary-label">Total Donasi</div>
                                    <span class="summary-colon mx-2">:</span>
                                    <div id="summaryTotalDonasi" class="fw-bold">Rp. 0</div>
                                </div>
                                <div class="mb-1 d-flex align-items-center summary-row">
                                    <div class="summary-label">Jumlah Donatur</div>
                                    <span class="summary-colon mx-2">:</span>
                                    <div id="summaryJumlahDonatur" class="fw-bold">0</div>
                                </div>
                                <div class="mb-1 d-flex align-items-center summary-row">
                                    <div class="summary-label">Persentase Donatur</div>
                                    <span class="summary-colon mx-2">:</span>
                                    <div id="summaryPersentase" class="fw-bold">0%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-xl-4 col-lg-12 wow fadeInLeft" data-wow-delay="0.2s">
                    <h5 class="text-primary">
                        <i class="fas fa-chart-pie me-2"></i>Grafik Donasi
                    </h5>
                    <div class="card shadow-sm rounded-4">
                        <div class="card-body">
                            <div class="chart-container" style="position: relative; height: 300px; width: 100%;">
                                <canvas id="donasiChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-12">
                    <h5 class="text-primary">
                        <i class="fas fa-table me-2"></i>Tabel Donasi
                    </h5>
                    <div class="card shadow-lg rounded-4">
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped align-middle text-center"
                                    id="donasiTable">
                                    <thead class="table-primary">
                                        <tr>
                                            <th style="width: 60px;">No</th>
                                            <th>Desa</th>
                                            <th>Jumlah Donatur</th>
                                            <th>Total Donasi</th>
                                            <th>Persentase</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody"></tbody>
                                    <tfoot>
                                        <tr class="table-warning fw-bold">
                                            <td colspan="3" class="text-end">Total Keseluruhan</td>
                                            <td><span id="totalDonasi" class="badge bg-danger fs-5"></span></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- About Start -->
    <div class="container-fluid about pb-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                @if (is_null($tentang))
                    <div class="col-xl-7 wow fadeInLeft" data-wow-delay="0.2s">
                        <div>
                            <h4 class="text-primary">Tentang Kami</h4>
                            <h1 class="display-5 mb-4">Bersama LAZISNU, Wujudkan Kepedulian Lewat INUK</h1>
                            <p class="mb-4">
                                INUK (Infaq untuk Umat dan Kesejahteraan) adalah program unggulan dari LAZISNU yang
                                hadir
                                untuk
                                menjembatani kebaikan Anda kepada mereka yang membutuhkan. Dengan semangat gotong royong
                                dan
                                kepedulian,
                                kami mendorong masyarakat untuk berinfaq secara mudah, transparan, dan berdampak nyata.
                            </p>
                            <div class="row g-4">
                                <div class="col-md-6 col-lg-6 col-xl-6">
                                    <div class="d-flex">
                                        <div><i class="fas fa-hand-holding-heart fa-3x text-primary"></i></div>
                                        <div class="ms-4">
                                            <h4>Infaq yang Amanah</h4>
                                            <p>Setiap donasi dikelola secara profesional dan disalurkan tepat sasaran.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-xl-6">
                                    <div class="d-flex">
                                        <div><i class="bi bi-bar-chart-line-fill fa-3x text-primary"></i></div>
                                        <div class="ms-4">
                                            <h4>Transparan dan Terpercaya</h4>
                                            <p>Pelaporan berkala untuk memastikan kepercayaan dan keberlanjutan program.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <a href="{{ url('register') }}"
                                        class="btn btn-primary rounded-pill py-3 px-5 flex-shrink-0">Gabung
                                        Sekarang</a>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex">
                                        <i class="fas fa-phone-alt fa-2x text-primary me-4"></i>
                                        <div>
                                            <h4>Hubungi Kami</h4>
                                            <p class="mb-0 fs-5" style="letter-spacing: 1px;">
                                                {{ env('NOMOR_CS', '+62 812-3456-7890') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-5 wow fadeInRight" data-wow-delay="0.2s">
                        <div class="bg-primary rounded position-relative overflow-hidden">
                            <img src="{{ asset('landing/img/laziznu.jpg') }}" class="img-fluid rounded w-100"
                                alt="LAZISNU - Infaq INUK">
                        </div>
                    </div>
                @else
                    <div class="col-xl-7 wow fadeInLeft" data-wow-delay="0.2s">
                        <div>
                            <h4 class="text-primary">{{ $tentang->judul ?? '-' }}</h4>
                            <h1 class="display-5 mb-4">{{ $tentang->subjudul ?? '-' }}</h1>
                            <p class="mb-4">
                                {{ $tentang->ringkasan ?? '-' }}
                            </p>
                            <div class="row g-4">
                                <div class="col-md-6 col-lg-6 col-xl-6">
                                    <div class="d-flex">
                                        <div><i class="fas fa-hand-holding-heart fa-3x text-primary"></i></div>
                                        <div class="ms-4">
                                            <h4>{{ $tentang->motto1 ?? '-' }}</h4>
                                            <p>{{ $tentang->ringkasan1 ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-xl-6">
                                    <div class="d-flex">
                                        <div><i class="bi bi-bar-chart-line-fill fa-3x text-primary"></i></div>
                                        <div class="ms-4">
                                            <h4>{{ $tentang->motto2 ?? '-' }}</h4>
                                            <p>{{ $tentang->ringkasan2 ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <a href="{{ url('register') }}"
                                        class="btn btn-primary rounded-pill py-3 px-5 flex-shrink-0">Gabung
                                        Sekarang</a>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex">
                                        <i class="fas fa-phone-alt fa-2x text-primary me-4"></i>
                                        <div>
                                            <h4>{{ $tentang->subjudul1 ?? '-' }}</h4>
                                            <p class="mb-0 fs-5" style="letter-spacing: 1px;">
                                                {{ $tentang->no_hp ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-5 wow fadeInRight" data-wow-delay="0.2s">
                        <div class="bg-primary rounded position-relative overflow-hidden">
                            @if ($tentang->foto)
                                <img src="{{ asset('storage/' . $tentang->foto) }}"class="img-fluid rounded w-100"
                                    alt="LAZISNU - Infaq INUK">
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Program Start -->
    <div class="container-fluid service pb-5">
        @if (is_null($program))
            <div class="container pb-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">Program Kami</h4>
                    <h1 class="display-5 mb-4">Program Unggulan INUK - LAZISNU</h1>
                    <p class="mb-0">
                        INUK (Infaq untuk Umat dan Kesejahteraan) adalah program dari LAZISNU yang berkomitmen untuk
                        menyalurkan infaq secara amanah, transparan, dan tepat sasaran guna mendukung kesejahteraan
                        umat.
                    </p>
                </div>
                <div class="row g-4">
                    <div class="col-md-6 col-lg-6 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="service-item">
                            <div class="service-img">
                                <img src="{{ asset('landing/img/carousel/carousel-1.jpg') }}"
                                    class="img-fluid rounded-top w-100" alt="Inuk">
                            </div>
                            <div class="rounded-bottom p-4">
                                <a href="#" class="h4 d-inline-block mb-4">INUK</a>
                                <p class="mb-4">Program donasi infaq yang dikelola oleh NU Kudus untuk mendukung
                                    pendidikan, kesehatan, dan kegiatan sosial keumatan.</p>
                                {{-- <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Lihat Program</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="service-item">
                            <div class="service-img">
                                <img src="{{ asset('landing/img/service/service-7.png') }}"
                                    class="img-fluid rounded-top w-100" alt="MLU">
                            </div>
                            <div class="rounded-bottom p-4">
                                <a href="#" class="h4 d-inline-block mb-4">Mobil Layanan Ummat (MLU)</a>
                                <p class="mb-4">Layanan mobil gratis untuk masyarakat yang membutuhkan, mulai dari
                                    kesehatan, edukasi, hingga bantuan darurat langsung ke lokasi.</p>
                                {{-- <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Lihat Program</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="service-item">
                            <div class="service-img">
                                <img src="{{ asset('landing/img/service/service-8.jpg') }}"
                                    class="img-fluid rounded-top w-100" alt="Infaq Ekonomi">
                            </div>
                            <div class="rounded-bottom p-4">
                                <a href="#" class="h4 d-inline-block mb-4">Qurban</a>
                                <p class="mb-4">Program Qurban terpercaya yang amanah dan profesional, menyebarkan
                                    kebahagiaan hingga pelosok desa yang membutuhkan.</p>
                                {{-- <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Lihat Program</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="service-item">
                            <div class="service-img">
                                <img src="{{ asset('landing/img/service/service-9.jpg') }}"
                                    class="img-fluid rounded-top w-100" alt="Infaq Bencana">
                            </div>
                            <div class="rounded-bottom p-4">
                                <a href="#" class="h4 d-inline-block mb-4">Santunan</a>
                                <p class="mb-4">Santunan untuk anak yatim, kaum dhuafa, dan korban musibah sebagai
                                    bentuk
                                    kepedulian sosial dan solidaritas ummat.</p>
                                {{-- <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Lihat Program</a> --}}
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="service-item">
                        <div class="service-img">
                            <img src="{{ asset('landing/img/service/service-5.jpg') }}"
                                class="img-fluid rounded-top w-100" alt="Infaq Masjid & Musholla">
                        </div>
                        <div class="rounded-bottom p-4">
                            <a href="#" class="h4 d-inline-block mb-4">Infaq Masjid & Musholla</a>
                            <p class="mb-4">Bantuan pembangunan, renovasi, dan pengadaan perlengkapan ibadah di
                                masjid serta musholla pelosok.</p>
                            <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Lihat Program</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.6s">
                    <div class="service-item">
                        <div class="service-img">
                            <img src="{{ asset('landing/img/service/service-6.jpg') }}"
                                class="img-fluid rounded-top w-100" alt="Infaq Sosial & Dakwah">
                        </div>
                        <div class="rounded-bottom p-4">
                            <a href="#" class="h4 d-inline-block mb-4">Infaq Sosial & Dakwah</a>
                            <p class="mb-4">Program pembinaan keagamaan, santunan dhuafa, serta syiar dakwah untuk
                                masyarakat marginal.</p>
                            <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Lihat Program</a>
                        </div>
                    </div>
                </div> --}}
                </div>
            </div>
        @else
            <div class="container pb-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">{{ $item->tag ?? '-' }}</h4>
                    <h1 class="display-5 mb-4">{{ $item->judul ?? '-' }}</h1>
                    <p class="mb-0">
                        {{ $item->ringkasan ?? '-' }}
                    </p>
                </div>
                <div class="row g-4">
                    <div class="col-md-6 col-lg-6 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="service-item">
                            <div class="service-img">
                                @if ($item->foto1 == null)
                                    <div class="col-12">
                                        <div class="alert alert-info text-center">
                                            <i class="fa-solid fa-image"></i> Belum ada foto
                                        </div>
                                    </div>
                                @else
                                    <img src="{{ Storage::url($item->foto1 ?? '-') }}"
                                        class="img-fluid rounded-top w-100" alt="LAZISNU - Infaq INUK">
                                @endif
                            </div>
                            <div class="rounded-bottom p-4">
                                <a href="#" class="h4 d-inline-block mb-4">{{ $item->program1 ?? '-' }}</a>
                                <p class="mb-4">{{ $item->ringkasan1 ?? '-' }}</p>
                                {{-- <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Lihat Program</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="service-item">
                            <div class="service-img">
                                @if ($item->foto2 == null)
                                    <div class="col-12">
                                        <div class="alert alert-info text-center">
                                            <i class="fa-solid fa-image"></i> Belum ada foto
                                        </div>
                                    </div>
                                @else
                                    <img src="{{ Storage::url($item->foto2 ?? '-') }}"
                                        class="img-fluid rounded-top w-100" alt="MLU">
                                @endif
                            </div>
                            <div class="rounded-bottom p-4">
                                <a href="#" class="h4 d-inline-block mb-4">{{ $item->program2 ?? '-' }}</a>
                                <p class="mb-4">{{ $item->ringkasann2 ?? '-' }}</p>
                                {{-- <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Lihat Program</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="service-item">
                            <div class="service-img">
                                @if ($item->foto3 == null)
                                    <div class="col-12">
                                        <div class="alert alert-info text-center">
                                            <i class="fa-solid fa-image"></i> Belum ada icon
                                        </div>
                                    </div>
                                @else
                                    <img src="{{ Storage::url($item->foto3 ?? '-') }}"
                                        class="img-fluid rounded-top w-100" alt="Qurban">
                                @endif
                            </div>
                            <div class="rounded-bottom p-4">
                                <a href="#" class="h4 d-inline-block mb-4">{{ $item->program3 ?? '-' }}</a>
                                <p class="mb-4">{{ $item->ringkasan3 ?? '-' }}</p>
                                {{-- <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Lihat Program</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="service-item">
                            <div class="service-img">
                                @if ($item->foto4 == null)
                                    <div class="col-12">
                                        <div class="alert alert-info text-center">
                                            <i class="fa-solid fa-image"></i> Belum ada icon
                                        </div>
                                    </div>
                                @else
                                    <img src="{{ Storage::url($item->foto4 ?? '-') }}"
                                        class="img-fluid rounded-top w-100" alt="Santunan">
                                @endif
                            </div>
                            <div class="rounded-bottom p-4">
                                <a href="#" class="h4 d-inline-block mb-4">{{ $item->program4 ?? '-' }}</a>
                                <p class="mb-4">{{ $item->ringkasan4 ?? '-' }}</p>
                                {{-- <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Lihat Program</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <!-- Program End -->

    <!-- Layanan Start -->
    <div class="container-fluid service pb-5">
        @if (is_null($layanan))
            <div class="container pb-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">Layanan Kami</h4>
                    <h1 class="display-5 mb-4">Infaq untuk Umat & Kesejahteraan</h1>
                    <p class="mb-0">Melalui INUK dari LAZISNU, kami menghadirkan berbagai layanan sosial dan
                        pemberdayaan untuk menjangkau masyarakat yang membutuhkan secara langsung, transparan, dan penuh
                        keberkahan.</p>
                </div>
                <div class="row g-4">
                    <!-- Program 1 -->
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="service-item">
                            <div class="service-img">
                                <img src="{{ asset('landing/img/program/program-1.jpg') }}"
                                    class="img-fluid rounded-top w-100" alt="Image">
                            </div>
                            <div class="rounded-bottom p-4">
                                <a href="#" class="h4 d-inline-block mb-4">Santunan Kemanusiaan</a>
                                <p class="mb-4">Menyalurkan infaq kepada anak yatim, dhuafa, dan keluarga kurang
                                    mampu
                                    untuk kebutuhan pokok dan kesejahteraan hidup.</p>
                                <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <!-- Program 2 -->
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="service-item">
                            <div class="service-img">
                                <img src="{{ asset('landing/img/program/program-2.jpg') }}"
                                    class="img-fluid rounded-top w-100" alt="Image">
                            </div>
                            <div class="rounded-bottom p-4">
                                <a href="#" class="h4 d-inline-block mb-4">Program Pendidikan</a>
                                <p class="mb-4">Bantuan biaya pendidikan bagi siswa berprestasi namun kurang mampu,
                                    serta
                                    penyediaan alat belajar dan beasiswa.</p>
                                <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <!-- Program 3 -->
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="service-item">
                            <div class="service-img">
                                <img src="{{ asset('landing/img/program/program-3.jpg') }}"
                                    class="img-fluid rounded-top w-100" alt="Image">
                            </div>
                            <div class="rounded-bottom p-4">
                                <a href="#" class="h4 d-inline-block mb-4">Pemberdayaan Ekonomi</a>
                                <p class="mb-4">Mendukung usaha mikro melalui pelatihan, bantuan modal, dan pembinaan
                                    UMKM agar lebih mandiri dan berdaya.</p>
                                <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <!-- Program 4 -->
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="service-item">
                            <div class="service-img">
                                <img src="{{ asset('landing/img/program/program-4.jpg') }}"
                                    class="img-fluid rounded-top w-100" alt="Image">
                            </div>
                            <div class="rounded-bottom p-4">
                                <a href="#" class="h4 d-inline-block mb-4">Tanggap Bencana</a>
                                <p class="mb-4">Respon cepat dan penyaluran bantuan untuk korban bencana alam atau
                                    musibah kemanusiaan di berbagai daerah.</p>
                                <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <!-- Program 5 -->
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="service-item">
                            <div class="service-img">
                                <img src="{{ asset('landing/img/program/program-5.jpg') }}"
                                    class="img-fluid rounded-top w-100" alt="Image">
                            </div>
                            <div class="rounded-bottom p-4">
                                <a href="#" class="h4 d-inline-block mb-4">Layanan Kesehatan</a>
                                <p class="mb-4">Fasilitasi pengobatan, bantuan alat kesehatan, dan penyuluhan
                                    kesehatan
                                    gratis bagi masyarakat kurang mampu.</p>
                                <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <!-- Program 6 -->
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="service-item">
                            <div class="service-img">
                                <img src="{{ asset('landing/img/program/program-6.jpg') }}"
                                    class="img-fluid rounded-top w-100" alt="Image">
                            </div>
                            <div class="rounded-bottom p-4">
                                <a href="#" class="h4 d-inline-block mb-4">Digitalisasi Infaq</a>
                                <p class="mb-4">Kemudahan berdonasi melalui platform digital, transfer bank, dan QRIS
                                    untuk memperluas jangkauan kebaikan Anda.</p>
                                <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="container pb-5">
                @foreach ($layanan as $item)
                    <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s"
                        style="max-width: 800px;">
                        <h4 class="text-primary">{{ $item->tag ?? '-' }}</h4>
                        <h1 class="display-5 mb-4">{{ $item->judul ?? '-' }}</h1>
                        <p class="mb-0">{{ $item->deskripsi ?? '-' }}</p>
                    </div>
                    <div class="row g-4">
                        <!-- Program 1 -->
                        <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.2s">
                            <div class="service-item">
                                <div class="service-img">
                                    @if ($item->foto == null)
                                        <div class="col-12">
                                            <div class="alert alert-info text-center">
                                                <i class="fa-solid fa-image"></i> Belum ada foto
                                            </div>
                                        </div>
                                    @else
                                        <img src="{{ Storage::url($item->foto ?? '-') }}" alt="Image"
                                            class="img-fluid rounded-top w-100">
                                    @endif
                                </div>
                                <div class="rounded-bottom p-4">
                                    <a href="#" class="h4 d-inline-block mb-4">{{ $item->layanan ?? '-' }}</a>
                                    <p class="mb-4">{{ $item->ringkasan ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <!-- Layanan End -->

    <!-- Keunggulan Start -->
    <div class="container-fluid offer-section pb-5">
        @if (is_null($keunggulan))
            <div class="container pb-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">Keunggulan Kami</h4>
                    <h1 class="display-5 mb-4">Manfaat Menunaikan Infaq bersama INUK</h1>
                    <p class="mb-0">INUK hadir sebagai solusi menyalurkan infaq dengan amanah, transparan, dan
                        berdampak.
                        Kami tidak hanya menyalurkan, tetapi juga memastikan setiap rupiah membawa perubahan nyata bagi
                        umat
                        dan masyarakat yang membutuhkan.</p>
                </div>
                <div class="row g-5 align-items-center">
                    <div class="col-xl-5 wow fadeInLeft" data-wow-delay="0.2s">
                        <div class="nav nav-pills bg-light rounded p-5">
                            <a class="accordion-link p-4 active mb-4" data-bs-toggle="pill" href="#collapseOne">
                                <h5 class="mb-0">Amanah dan Transparan</h5>
                            </a>
                            <a class="accordion-link p-4 mb-4" data-bs-toggle="pill" href="#collapseTwo">
                                <h5 class="mb-0">Penyaluran Cepat dan Tepat Sasaran</h5>
                            </a>
                            <a class="accordion-link p-4 mb-4" data-bs-toggle="pill" href="#collapseThree">
                                <h5 class="mb-0">Kemudahan Donasi Digital</h5>
                            </a>
                            <a class="accordion-link p-4 mb-0" data-bs-toggle="pill" href="#collapseFour">
                                <h5 class="mb-0">Laporan dan Dokumentasi Rutin</h5>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-7 wow fadeInRight" data-wow-delay="0.4s">
                        <div class="tab-content">
                            <!-- Tab 1 -->
                            <div id="collapseOne" class="tab-pane fade show p-0 active">
                                <div class="row g-4">
                                    <div class="col-md-7">
                                        <img src="{{ asset('landing/img/offer/unggul-1.jpg') }}"
                                            class="img-fluid w-100 rounded" alt="Transparansi Infaq">
                                    </div>
                                    <div class="col-md-5">
                                        <h1 class="display-6 mb-4">Kami Menjaga Amanah Anda</h1>
                                        <p class="mb-4">Setiap dana infaq dikelola secara profesional dan disalurkan
                                            dengan penuh tanggung jawab melalui sistem pelaporan yang terbuka dan dapat
                                            diakses publik.</p>
                                        <a class="btn btn-primary rounded-pill py-2 px-4"
                                            href="#">Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Tab 2 -->
                            <div id="collapseTwo" class="tab-pane fade show p-0">
                                <div class="row g-4">
                                    <div class="col-md-7">
                                        <img src="{{ asset('landing/img/offer/unggul-2.jpg') }}"
                                            class="img-fluid w-100 rounded" alt="Cepat dan Tepat">
                                    </div>
                                    <div class="col-md-5">
                                        <h1 class="display-6 mb-4">Tepat Sasaran dan Responsif</h1>
                                        <p class="mb-4">INUK memiliki jaringan distribusi langsung ke masyarakat yang
                                            membutuhkan, baik melalui bantuan kemanusiaan, pendidikan, kesehatan, maupun
                                            ekonomi.</p>
                                        <a class="btn btn-primary rounded-pill py-2 px-4"
                                            href="#">Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Tab 3 -->
                            <div id="collapseThree" class="tab-pane fade show p-0">
                                <div class="row g-4">
                                    <div class="col-md-7">
                                        <img src="{{ asset('landing/img/offer/unggul-3.jpg') }}"
                                            class="img-fluid w-100 rounded" alt="Donasi Digital">
                                    </div>
                                    <div class="col-md-5">
                                        <h1 class="display-6 mb-4">Infaq Kini Lebih Mudah</h1>
                                        <p class="mb-4">Melalui QRIS, transfer bank, dan platform online, kini
                                            berdonasi
                                            tak perlu repot. Anda bisa menyalurkan kebaikan hanya dengan beberapa klik
                                            saja.
                                        </p>
                                        <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Donasi
                                            Sekarang</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Tab 4 -->
                            <div id="collapseFour" class="tab-pane fade show p-0">
                                <div class="row g-4">
                                    <div class="col-md-7">
                                        <img src="{{ asset('landing/img/offer/unggul-4.jpg') }}"
                                            class="img-fluid w-100 rounded" alt="Laporan dan Dokumentasi">
                                    </div>
                                    <div class="col-md-5">
                                        <h1 class="display-6 mb-4">Laporan Berkala & Dokumentasi</h1>
                                        <p class="mb-4">Kami menyediakan laporan bulanan, dokumentasi penyaluran,
                                            serta
                                            pelaporan real-time agar para donatur merasa yakin dan puas.</p>
                                        <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Lihat
                                            Laporan</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="container pb-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">{{ $keunggulan->tag ?? '-' }}</h4>
                    <h1 class="display-5 mb-4">{{ $keunggulan->judul ?? '-' }}</h1>
                    <p class="mb-0">{{ $keunggulan->deskripsi ?? '-' }}</p>
                </div>
                <div class="row g-5 align-items-center">
                    <div class="col-xl-5 wow fadeInLeft" data-wow-delay="0.2s">
                        <div class="nav nav-pills bg-light rounded p-5">
                            <a class="accordion-link p-4 active mb-4" data-bs-toggle="pill" href="#collapseOne">
                                <h5 class="mb-0">{{ $keunggulan->motto1 ?? '-' }}</h5>
                            </a>
                            <a class="accordion-link p-4 mb-4" data-bs-toggle="pill" href="#collapseTwo">
                                <h5 class="mb-0">{{ $keunggulan->motto2 ?? '-' }}</h5>
                            </a>
                            <a class="accordion-link p-4 mb-4" data-bs-toggle="pill" href="#collapseThree">
                                <h5 class="mb-0">{{ $keunggulan->motto3 ?? '-' }}</h5>
                            </a>
                            <a class="accordion-link p-4 mb-0" data-bs-toggle="pill" href="#collapseFour">
                                <h5 class="mb-0">{{ $keunggulan->motto4 ?? '-' }}</h5>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-7 wow fadeInRight" data-wow-delay="0.4s">
                        <div class="tab-content">
                            <!-- Tab 1 -->
                            <div id="collapseOne" class="tab-pane fade show p-0 active">
                                <div class="row g-4">
                                    <div class="col-md-7">
                                        @if ($keunggulan->foto1 == null)
                                            <div class="col-12">
                                                <div class="alert alert-info text-center">
                                                    <img src="{{ asset('landing/img/offer/unggul-1.jpg') }}"
                                                        class="img-fluid w-100 rounded" alt="Transparansi Infaq">
                                                </div>
                                            </div>
                                        @else
                                            <img src="{{ Storage::url($keunggulan->foto1 ?? '-') }}" alt="Foto 1"
                                                class="img-fluid w-100 rounded">
                                        @endif
                                    </div>
                                    <div class="col-md-5">
                                        <h1 class="display-6 mb-4">{{ $keunggulan->kalimat1 ?? '-' }}</h1>
                                        <p class="mb-4">{{ $keunggulan->ringkasan1 ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Tab 2 -->
                            <div id="collapseTwo" class="tab-pane fade show p-0">
                                <div class="row g-4">
                                    <div class="col-md-7">
                                        @if ($keunggulan->foto2 == null)
                                            <div class="col-12">
                                                <div class="alert alert-info text-center">
                                                    <img src="{{ asset('landing/img/offer/unggul-2.jpg') }}"
                                                        class="img-fluid w-100 rounded" alt="Cepat dan Tepat">
                                                </div>
                                            </div>
                                        @else
                                            <img src="{{ Storage::url($keunggulan->foto2 ?? '-') }}" alt="Foto 1"
                                                class="img-fluid w-100 rounded">
                                        @endif
                                    </div>
                                    <div class="col-md-5">
                                        <h1 class="display-6 mb-4">{{ $keunggulan->kalimat2 ?? '-' }}</h1>
                                        <p class="mb-4">{{ $keunggulan->ringkasan2 ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Tab 3 -->
                            <div id="collapseThree" class="tab-pane fade show p-0">
                                <div class="row g-4">
                                    <div class="col-md-7">
                                        @if ($keunggulan->foto3 == null)
                                            <div class="col-12">
                                                <div class="alert alert-info text-center">
                                                    <img src="{{ asset('landing/img/offer/unggul-3.jpg') }}"
                                                        class="img-fluid w-100 rounded" alt="Donasi Digital">
                                                </div>
                                            </div>
                                        @else
                                            <img src="{{ Storage::url($keunggulan->foto3 ?? '-') }}" alt="Foto 1"
                                                class="img-fluid w-100 rounded">
                                        @endif
                                    </div>
                                    <div class="col-md-5">
                                        <h1 class="display-6 mb-4">{{ $keunggulan->kalimat3 ?? '-' }}</h1>
                                        <p class="mb-4">{{ $keunggulan->ringkasan3 ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Tab 4 -->
                            <div id="collapseFour" class="tab-pane fade show p-0">
                                <div class="row g-4">
                                    <div class="col-md-7">
                                        @if ($keunggulan->foto4 == null)
                                            <div class="col-12">
                                                <div class="alert alert-info text-center">
                                                    <img src="{{ asset('landing/img/offer/unggul-4.jpg') }}"
                                                        class="img-fluid w-100 rounded" alt="Laporan dan Dokumentasi">
                                                </div>
                                            </div>
                                        @else
                                            <img src="{{ Storage::url($keunggulan->foto4 ?? '-') }}" alt="Foto 1"
                                                class="img-fluid w-100 rounded">
                                        @endif
                                    </div>
                                    <div class="col-md-5">
                                        <h1 class="display-6 mb-4">{{ $keunggulan->kalimat4 ?? '-' }}</h1>
                                        <p class="mb-4">{{ $keunggulan->ringkasan4 ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <!-- Keunggulan End -->

    <!-- Blog Start -->
    <div class="container-fluid blog pb-5">
        @if ($berita->isEmpty())
            <div class="container pb-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">Blog & Berita</h4>
                    <h1 class="display-5 mb-4">Cerita Inspiratif dan Info Terkini Seputar INUK</h1>
                    <p class="mb-0">
                        Dapatkan informasi terbaru mengenai kegiatan sosial, edukasi filantropi, serta kisah
                        nyata dari para
                        penerima manfaat infaq Anda. Bersama INUK, setiap infaq adalah jalan keberkahan.
                    </p>
                </div>

                <div class="owl-carousel blog-carousel wow fadeInUp" data-wow-delay="0.2s">
                    <!-- Blog 1 -->
                    <div class="blog-item p-4">
                        <div class="blog-img mb-4">
                            <img src="{{ asset('landing/img/carousel/carousel-1.jpg') }}"
                                class="img-fluid w-100 rounded" alt="">
                            <div class="blog-title">
                                <a href="#" class="btn">Program Pendidikan</a>
                            </div>
                        </div>
                        <a href="#" class="h4 d-inline-block mb-3">Infaq Anda, Harapan Baru Bagi
                            Generasi Muda</a>
                        <p class="mb-4">
                            Melalui program beasiswa dan perlengkapan sekolah, LAZISNU INUK menyalurkan
                            infaq untuk
                            mendukung pendidikan anak-anak yatim dan dhuafa.
                        </p>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('landing/img/admin.png') }}" class="img-fluid rounded-circle"
                                style="width: 60px; height: 60px;" alt="">
                            <div class="ms-3">
                                <h5>Admin</h5>
                                <p class="mb-0">3 Juli 2025</p>
                            </div>
                        </div>
                    </div>

                    <!-- Blog 2 -->
                    <div class="blog-item p-4">
                        <div class="blog-img mb-4">
                            <img src="{{ asset('landing/img/blog/blog-2.jpg') }}" class="img-fluid w-100 rounded"
                                alt="">
                            <div class="blog-title">
                                <a href="#" class="btn">Kisah Nyata</a>
                            </div>
                        </div>
                        <a href="#" class="h4 d-inline-block mb-3">Dari Infaq ke Harapan: Kisah Ibu
                            Siti</a>
                        <p class="mb-4">
                            Ibu Siti, janda dengan tiga anak, kini memiliki usaha kecil berkat program infaq
                            pemberdayaan
                            ekonomi dari INUK. Kisahnya menjadi inspirasi bagi kita semua.
                        </p>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('landing/img/admin.png') }}" class="img-fluid rounded-circle"
                                style="width: 60px; height: 60px;" alt="">
                            <div class="ms-3">
                                <h5>Admin</h5>
                                <p class="mb-0">26 Juni 2025</p>
                            </div>
                        </div>
                    </div>

                    <!-- Blog 3 -->
                    <div class="blog-item p-4">
                        <div class="blog-img mb-4">
                            <img src="{{ asset('landing/img/blog/blog-3.jpg') }}" class="img-fluid w-100 rounded"
                                alt="">
                            <div class="blog-title">
                                <a href="#" class="btn">Infaq & Kesehatan</a>
                            </div>
                        </div>
                        <a href="#" class="h4 d-inline-block mb-3">Layanan Kesehatan Gratis Lewat
                            Infaq</a>
                        <p class="mb-4">
                            LAZISNU INUK mengadakan pengobatan gratis bagi masyarakat prasejahtera. Infaq
                            Anda menjadi jalan
                            kesembuhan bagi mereka yang membutuhkan.
                        </p>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('landing/img/admin.png') }}" class="img-fluid rounded-circle"
                                style="width: 60px; height: 60px;" alt="">
                            <div class="ms-3">
                                <h5>Admin</h5>
                                <p class="mb-0">19 Juni 2025</p>
                            </div>
                        </div>
                    </div>

                    <!-- Blog 4 -->
                    <div class="blog-item p-4">
                        <div class="blog-img mb-4">
                            <img src="{{ asset('landing/img/blog/blog-4.jpg') }}" class="img-fluid w-100 rounded"
                                alt="">
                            <div class="blog-title">
                                <a href="#" class="btn">Literasi ZIS</a>
                            </div>
                        </div>
                        <a href="#" class="h4 d-inline-block mb-3">Apa Perbedaan Infaq, Zakat, dan
                            Sedekah?</a>
                        <p class="mb-4">
                            Edukasi dasar tentang konsep ZIS (Zakat, Infaq, Sedekah) agar umat lebih paham
                            perannya dalam
                            pembangunan sosial dan ekonomi umat Islam.
                        </p>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('landing/img/admin.png') }}" class="img-fluid rounded-circle"
                                style="width: 60px; height: 60px;" alt="">
                            <div class="ms-3">
                                <h5>Admin</h5>
                                <p class="mb-0">10 Juni 2025</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="container pb-5">
                @foreach ($berita as $ber)
                    <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s"
                        style="max-width: 800px;">
                        <h4 class="text-primary">{{ $ber->tag ?? '-' }}</h4>
                        <h1 class="display-5 mb-4">{{ $ber->judul ?? '-' }}</h1>
                        <p class="mb-0">
                            {{ $ber->ringkasan ?? '-' }}
                        </p>
                    </div>

                    <div class="owl-carousel blog-carousel wow fadeInUp" data-wow-delay="0.2s">
                        <!-- Blog 1 -->
                        <div class="blog-item p-4">
                            <div class="blog-img mb-4">
                                @if ($ber->foto1 == null)
                                    <div class="col-12">
                                        <div class="alert alert-info text-center">
                                            <img src="{{ asset('landing/img/carousel/carousel-1.jpg') }}"
                                                class="img-fluid w-100 rounded" alt="">
                                        </div>
                                    </div>
                                @else
                                    <img src="{{ Storage::url($ber->foto1 ?? '-') }}" alt="Foto 1"
                                        class="img-fluid w-100 rounded">
                                @endif
                                <div class="blog-title">
                                    <a href="#" class="btn">{{ $ber->motto1 ?? '-' }}</a>
                                </div>
                            </div>
                            <a href="#" class="h4 d-inline-block mb-3">{{ $iten->judul1 ?? '-' }}</a>
                            <p class="mb-4">
                                {{ $ber->ringkasan1 ?? '-' }}
                            </p>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('landing/img/admin.png') }}" class="img-fluid rounded-circle"
                                    style="width: 60px; height: 60px;" alt="">
                                <div class="ms-3">
                                    <h5>
                                        @if ($ber->penulis)
                                            {{ $penulis }}
                                        @else
                                            Admin
                                        @endif
                                    </h5>
                                    <p class="mb-0">{{ $ber->tgl_berita ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <!-- Blog End -->

    <!-- FAQs Start -->
    <div class="container-fluid faq-section pb-5">
        @if (is_null($tanya))
            <div class="container pb-5 overflow-hidden">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">FAQs</h4>
                    <h1 class="display-5 mb-4">Pertanyaan yang Sering Diajukan</h1>
                    <p class="mb-0">
                        Temukan jawaban atas pertanyaan umum seputar layanan, transparansi, dan kemudahan berdonasi
                        melalui
                        INUK. Kami hadir untuk memastikan infaq Anda sampai dan berdampak.
                    </p>
                </div>
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                        <div class="accordion accordion-flush bg-light rounded p-5" id="accordionFlushSection">
                            <!-- FAQ 1 -->
                            <div class="accordion-item rounded-top">
                                <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed rounded-top" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                        aria-expanded="false" aria-controls="flush-collapseOne">
                                        Apa itu INUK?
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushSection">
                                    <div class="accordion-body">
                                        INUK (Infaq untuk Umat dan Kesejahteraan) adalah program infaq yang dikelola
                                        oleh
                                        LAZISNU, berfokus pada penyaluran dana infaq secara amanah, transparan, dan
                                        berdampak bagi umat.
                                    </div>
                                </div>
                            </div>
                            <!-- FAQ 2 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingTwo">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo"
                                        aria-expanded="false" aria-controls="flush-collapseTwo">
                                        Ke mana dana infaq saya disalurkan?
                                    </button>
                                </h2>
                                <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushSection">
                                    <div class="accordion-body">
                                        Dana infaq disalurkan untuk program pendidikan, kesehatan, pemberdayaan ekonomi,
                                        bantuan bencana, dan santunan yatim dan dhuafa di berbagai wilayah.
                                    </div>
                                </div>
                            </div>
                            <!-- FAQ 3 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingThree">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseThree"
                                        aria-expanded="false" aria-controls="flush-collapseThree">
                                        Apakah saya akan menerima laporan penggunaan infaq?
                                    </button>
                                </h2>
                                <div id="flush-collapseThree" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushSection">
                                    <div class="accordion-body">
                                        Ya. Setiap donatur akan mendapatkan laporan bulanan dan dokumentasi penyaluran
                                        melalui email, WhatsApp, atau dapat dilihat langsung di situs resmi kami.
                                    </div>
                                </div>
                            </div>
                            <!-- FAQ 4 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingFour">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseFour"
                                        aria-expanded="false" aria-controls="flush-collapseFour">
                                        Bagaimana cara berdonasi melalui INUK?
                                    </button>
                                </h2>
                                <div id="flush-collapseFour" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushSection">
                                    <div class="accordion-body">
                                        Anda dapat berdonasi melalui transfer bank, QRIS, atau menggunakan form donasi
                                        online di website ini. Proses cepat, mudah, dan bisa dilakukan kapan saja.
                                    </div>
                                </div>
                            </div>
                            <!-- FAQ 5 -->
                            <div class="accordion-item rounded-bottom">
                                <h2 class="accordion-header" id="flush-headingFive">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseFive"
                                        aria-expanded="false" aria-controls="flush-collapseFive">
                                        Apakah donasi saya bisa atas nama orang lain?
                                    </button>
                                </h2>
                                <div id="flush-collapseFive" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushSection">
                                    <div class="accordion-body">
                                        Bisa. Anda dapat berdonasi atas nama pribadi, keluarga, almarhum, ataupun
                                        lembaga.
                                        Cukup cantumkan nama dalam keterangan saat pengisian form donasi.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Image Side -->
                    <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
                        <div class="bg-primary rounded">
                            <img src="{{ asset('landing/img/carousel/carousel-2.jpg') }}"
                                class="img-fluid w-100 rounded" alt="Ilustrasi FAQ INUK">
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="container pb-5 overflow-hidden">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">{{ $tanya->tag ?? '-' }}</h4>
                    <h1 class="display-5 mb-4">{{ $tanya->judul ?? '-' }}</h1>
                    <p class="mb-0">{{ $tanya->ringkasan }}</p>
                </div>
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                        <div class="accordion accordion-flush bg-light rounded p-5" id="accordionFlushSection">
                            <!-- FAQ 1 -->
                            <div class="accordion-item rounded-top">
                                <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed rounded-top" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                        aria-expanded="false" aria-controls="flush-collapseOne">
                                        {{ $tanya->pertanyaan1 ?? '-' }}
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushSection">
                                    <div class="accordion-body">
                                        {{ $tanya->jawaban1 ?? '-' }}
                                    </div>
                                </div>
                            </div>
                            <!-- FAQ 2 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingTwo">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo"
                                        aria-expanded="false" aria-controls="flush-collapseTwo">
                                        {{ $tanya->pertanyaan2 ?? '-' }}
                                    </button>
                                </h2>
                                <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushSection">
                                    <div class="accordion-body">
                                        {{ $tanya->jawaban2 ?? '-' }}
                                    </div>
                                </div>
                            </div>
                            <!-- FAQ 3 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingThree">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseThree"
                                        aria-expanded="false" aria-controls="flush-collapseThree">
                                        {{ $tanya->pertanyaan3 ?? '-' }}
                                    </button>
                                </h2>
                                <div id="flush-collapseThree" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushSection">
                                    <div class="accordion-body">
                                        {{ $tanya->jawaban3 ?? '-' }}
                                    </div>
                                </div>
                            </div>
                            <!-- FAQ 4 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingFour">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseFour"
                                        aria-expanded="false" aria-controls="flush-collapseFour">
                                        {{ $tanya->pertanyaan4 ?? '-' }}
                                    </button>
                                </h2>
                                <div id="flush-collapseFour" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushSection">
                                    <div class="accordion-body">
                                        {{ $tanya->jawaban4 ?? '-' }}
                                    </div>
                                </div>
                            </div>
                            <!-- FAQ 5 -->
                            <div class="accordion-item rounded-bottom">
                                <h2 class="accordion-header" id="flush-headingFive">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseFive"
                                        aria-expanded="false" aria-controls="flush-collapseFive">
                                        {{ $tanya->pertanyaan5 ?? '-' }}
                                    </button>
                                </h2>
                                <div id="flush-collapseFive" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushSection">
                                    <div class="accordion-body">
                                        {{ $tanya->jawaban5 ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Image Side -->
                    <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
                        <div class="bg-primary rounded">
                            @if ($tanya->foto == null)
                                <div class="col-12">
                                    <div class="alert alert-info text-center">
                                        <img src="{{ asset('landing/img/carousel/carousel-2.jpg') }}"
                                            class="img-fluid w-100 rounded" alt="Ilustrasi FAQ INUK">
                                    </div>
                                </div>
                            @else
                                <img src="{{ Storage::url($tanya->foto ?? '-') }}" alt="Foto 1"
                                    class="img-fluid w-100 rounded">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <!-- FAQs End -->

    <!-- Struktur Start -->
    <div class="container-fluid team pb-5">
        @if (is_null($struktur))
            <div class="container pb-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">Tim Kami</h4>
                    <h1 class="display-5 mb-4">Kenali Sosok di Balik INUK</h1>
                    <p class="mb-0">
                        Tim INUK terdiri dari pengurus profesional dan relawan yang berkomitmen tinggi dalam mengelola
                        dan
                        menyalurkan infaq secara amanah, transparan, dan tepat sasaran.
                    </p>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 wow fadeInLeft" data-wow-delay="0.2s">
                        <img src="{{ asset('landing/img/logo.png') }}" alt="Logo NU CARE-LAZISNU" width="80%"
                            height="auto">
                    </div>
                    <div class="col-lg-8 wow fadeInRight" data-wow-delay="0.2s">
                        <div class="text-end">
                            <h4>PENGURUS CABANG NAHDLATUL ULAMA KABUPATEN KUDUS</h4>
                            <div class="mb-1">
                                Jl. Pramuka No. 20 Wergu Wetan Kota Kudus
                            </div>
                            <div class="mb-1">
                                0291 430201 - 439448
                            </div>
                            <div class="mb-1">
                                pcnukudusjateng@gmail.com
                            </div>
                            <div class="mb-1">
                                www.nukudus.or.id
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div>
                        <div class="text-start">
                            <h5>Lampiran SK Pengurus Cabang Nahdlatul Ulama Kudus</h5>
                            <div class="mb-1 d-flex">
                                <div style="width: 100px;">Nomor
                                </div>
                                <span class="me-1">:</span>
                                <div>
                                    0102/PC.H.07/SK/III/2025
                                </div>
                            </div>
                            <div class="mb-1 d-flex">
                                <div style="width: 100px;">Tanggal
                                </div>
                                <span class="me-1">:</span>
                                <div>
                                    10 Romadlon 1446 H. / 10 Maret 2025 M
                                </div>
                            </div>
                            <div class="mb-1 d-flex">
                                <div style="width: 100px;">Tentang
                                </div>
                                <span class="me-1">:</span>
                                <div>

                                </div>
                            </div>
                        </div>
                        <div class="text-center pb-4 mt-3">
                            <h4><strong>SUSUNAN PENGURUS</strong></h4>
                            <p class="mb-1">
                                <strong>
                                    LEMBAGA AMIL ZAKAT, INFAQ DAN SHADAQAH NAHDLATUL ULAMA (LAZISNU)
                                </strong>
                            </p>
                            <p class="mb-2"><strong>PCNU KABUPATEN KUDUS</strong></p>
                            <p class="mb-3"><strong>MASA KHIDMAT 2024 - 2029 M.</strong></p>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-12 col-md-10">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item mb-1">
                                        <div class="label">Ketua</div>
                                        <span class="separator">:</span>
                                        <div class="value"><strong>Fiza Akbar, S. STP., M.Si</strong></div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Wakil Ketua</div>
                                        <span class="separator">:</span>
                                        <div class="value">H. Hasan Junaedi, S.Pd</div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Wakil Ketua</div>
                                        <span class="separator">:</span>
                                        <div class="value">Sih Karyadi</div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Wakil Ketua</div>
                                        <span class="separator">:</span>
                                        <div class="value">H. Supamo, SHI., MH</div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Sekretaris</div>
                                        <span class="separator">:</span>
                                        <div class="value"><strong>
                                                Arif Mustaqin, M.Pd.I</strong></div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Wakil Sekretaris</div>
                                        <span class="separator">:</span>
                                        <div class="value">Vera Fitri Apriliani, SE</div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Bendahara</div>
                                        <span class="separator">:</span>
                                        <div class="value"><strong>Ali Bejo, S.Pd.I</strong></div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Wakil Bendahara</div>
                                        <span class="separator">:</span>
                                        <div class="value">Arum Nugroho, SE, MM</div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Bidang-bidang</div>
                                        <span class="separator">:</span>
                                        <div class="value"></div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Divisi Penghimpunan</div>
                                        <span class="separator">:</span>
                                        <div class="value">
                                            Muhlisin, S.Pd.I <br>
                                            Saifuddin Nawawi, S.Pd.I
                                        </div>
                                    </li>

                                    <li class="list-group-item mb-1">
                                        <div class="label">Divisi Pendistribusian</div>
                                        <span class="separator">:</span>
                                        <div class="value">
                                            Jamifuddin, M.Pd <br>
                                            Moh. Arifin, S.Pd.I, M.Pd
                                        </div>
                                    </li>

                                    <li class="list-group-item mb-1">
                                        <div class="label">Divisi Keuangan & Pelaporan</div>
                                        <span class="separator">:</span>
                                        <div class="value">
                                            Zaenal Afifi, SE, M.Si, Akt <br>
                                            Muhammad Ulin Niam, S.Pd
                                        </div>
                                    </li>

                                    <li class="list-group-item mb-1">
                                        <div class="label">Divisi Humas & Publikasi</div>
                                        <span class="separator">:</span>
                                        <div class="value">
                                            Wahyul Huda, M.Pd <br>
                                            Zamris Anwar, M.Pd
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="container pb-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s">
                    <h4 class="text-primary"><strong>{{ $struktur->tag ?? '-' }}</strong></h4>
                    <h1 class="display-5 mb-4">{{ $struktur->judul ?? '-' }}</h1>
                    <p class="mb-0">
                        {{ $struktur->kalimat ?? '-' }}
                    </p>
                </div>

                <div class="row g-4">
                    <div class="col-lg-4 wow fadeInLeft" data-wow-delay="0.2s">
                        <img src="{{ asset('landing/img/logo.png') }}" alt="Logo NU CARE-LAZISNU" width="80%"
                            height="auto">
                    </div>
                    <div class="col-lg-8 wow fadeInRight" data-wow-delay="0.2s">
                        <div class="text-end">
                            <h4>{{ $struktur->subjudul ?? '-' }}</h4>
                            <div class="mb-1">
                                {{ $struktur->alamat ?? '-' }}
                            </div>
                            <div class="mb-1">
                                {{ $struktur->no_telpon ?? '-' }}
                            </div>
                            <div class="mb-1">
                                0291 439448
                            </div>
                            <div class="mb-1">
                                {{ $struktur->email ?? '-' }}
                            </div>
                            <div class="mb-1">
                                {{ $struktur->alamatweb ?? '-' }}
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div>
                        <div class="text-start">
                            <h5><strong>{{ $struktur->judulsk ?? '-' }}</strong></h5>
                            <div class="mb-1 d-flex">
                                <div style="width: 100px;">Nomor
                                </div>
                                <span class="me-1">:</span>
                                <div>
                                    {{ $struktur->nomor ?? '-' }}
                                </div>
                            </div>
                            <div class="mb-1 d-flex">
                                <div style="width: 100px;">Tanggal
                                </div>
                                <span class="me-1">:</span>
                                <div>
                                    @if ($struktur && $struktur->tanggal)
                                        @php
                                            $hijri = \Alkoumi\LaravelHijriDate\Hijri::Date('d F Y', $struktur->tanggal);

                                            $hariArab = [
                                                'الأحد',
                                                'الإثنين',
                                                'الثلاثاء',
                                                'الأربعاء',
                                                'الخميس',
                                                'الجمعة',
                                                'السبت',
                                            ];
                                            $hariIndo = ['Ahad', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

                                            $bulanArab = [
                                                'محرم',
                                                'صفر',
                                                'ربيع الأول',
                                                'ربيع الثاني',
                                                'جمادى الأولى',
                                                'جمادى الآخرة',
                                                'رجب',
                                                'شعبان',
                                                'رمضان',
                                                'شوال',
                                                'ذو القعدة',
                                                'ذو الحجة',
                                            ];
                                            $bulanIndo = [
                                                'Muharram',
                                                'Shafar',
                                                'Rabiul Awal',
                                                'Rabiul Akhir',
                                                'Jumadil Awal',
                                                'Jumadil Akhir',
                                                'Rajab',
                                                'Sya`ban',
                                                'Ramadhan',
                                                'Syawal',
                                                'Dzulqa`dah',
                                                'Dzulhijjah',
                                            ];

                                            foreach ($hariArab as $key => $hari) {
                                                $hijri = str_replace($hari, $hariIndo[$key], $hijri);
                                            }

                                            foreach ($bulanArab as $key => $bulan) {
                                                $hijri = str_replace($bulan, $bulanIndo[$key], $hijri);
                                            }
                                        @endphp

                                        {{ $hijri }} H /
                                        {{ \Carbon\Carbon::parse($struktur->tanggal)->translatedFormat('d F Y') }} M
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                            <div class="mb-1 d-flex">
                                <div style="width: 100px;">Tentang
                                </div>
                                <span class="me-1">:</span>
                                <div>
                                    {{ $struktur->tentang ?? '-' }}
                                </div>
                            </div>
                        </div>
                        <div class="text-center pb-4 mt-3 text-dark">
                            <h5><strong>{{ $struktur->pengurus ?? '-' }}</strong></h5>
                            <p class="mb-1">
                                <strong>
                                    {{ $struktur->judulpengurus ?? '-' }}
                                </strong>
                            </p>
                            <p class="mb-2"><strong>{{ $struktur->kabupaten ?? '-' }}</strong></p>
                            <p class="mb-3"><strong>{{ $struktur->masapengurus ?? '-' }}</strong></p>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-12 col-md-10">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item mb-1">
                                        <div class="label">Ketua</div>
                                        <span class="separator">:</span>
                                        <div class="value"><strong>{{ $struktur->ketua ?? '-' }}</strong></div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Wakil Ketua</div>
                                        <span class="separator">:</span>
                                        <div class="value">{{ $struktur->wakilketua1 ?? '-' }}</div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Wakil Ketua</div>
                                        <span class="separator">:</span>
                                        <div class="value">{{ $struktur->wakilketua2 ?? '-' }}</div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Wakil Ketua</div>
                                        <span class="separator">:</span>
                                        <div class="value">{{ $struktur->wakilketua3 ?? '-' }}</div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Sekretaris</div>
                                        <span class="separator">:</span>
                                        <div class="value"><strong>{{ $struktur->sekretaris ?? '-' }}</strong></div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Wakil Sekretaris</div>
                                        <span class="separator">:</span>
                                        <div class="value">{{ $struktur->wakilsekretaris ?? '-' }}</div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Bendahara</div>
                                        <span class="separator">:</span>
                                        <div class="value"><strong>{{ $struktur->bendahara ?? '-' }}</strong></div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Wakil Bendahara</div>
                                        <span class="separator">:</span>
                                        <div class="value">{{ $struktur->wakilbendahara ?? '-' }}</div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Bidang-bidang</div>
                                        <span class="separator">:</span>
                                        <div class="value"></div>
                                    </li>
                                    <li class="list-group-item mb-1">
                                        <div class="label">Divisi Penghimpunan</div>
                                        <span class="separator">:</span>
                                        <div class="value">
                                            @if ($struktur && $struktur->penghimpunan)
                                                @foreach (explode('|', $struktur->penghimpunan) as $nama)
                                                    {{ trim($nama) }} <br>
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </li>

                                    <li class="list-group-item mb-1">
                                        <div class="label">Divisi Pendistribusian</div>
                                        <span class="separator">:</span>
                                        <div class="value">
                                            @if ($struktur && $struktur->pendistribusian)
                                                @foreach (explode('|', $struktur->pendistribusian) as $nama)
                                                    {{ trim($nama) }} <br>
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </li>

                                    <li class="list-group-item mb-1">
                                        <div class="label">Divisi Keuangan & Pelaporan</div>
                                        <span class="separator">:</span>
                                        <div class="value">
                                            @if ($struktur && $struktur->keuangan)
                                                @foreach (explode('|', $struktur->keuangan) as $nama)
                                                    {{ trim($nama) }} <br>
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </li>

                                    <li class="list-group-item mb-1">
                                        <div class="label">Divisi Humas & Publikasi</div>
                                        <span class="separator">:</span>
                                        <div class="value">
                                            @if ($struktur && $struktur->humas)
                                                @foreach (explode('|', $struktur->humas) as $nama)
                                                    {{ trim($nama) }} <br>
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <!-- Struktur End -->

    <!-- Testimonial Start -->
    <div class="container-fluid testimonial pb-5">
        @if ($testi->isEmpty())
            <div class="container pb-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s"
                    style="max-width: 800px;">
                    <h4 class="text-primary">Testimoni</h4>
                    <h1 class="display-5 mb-4">Cerita dari Para Penerima & Donatur</h1>
                    <p class="mb-0">Berikut adalah kesan dan pesan dari para donatur serta penerima manfaat program
                        INUK.
                        Mereka merasakan langsung dampak nyata dari infaq yang dikelola oleh LAZISNU.</p>
                </div>
                <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.2s">
                    <!-- Testimoni 1 -->
                    <div class="testimonial-item">
                        <div class="testimonial-quote-left">
                            <i class="fas fa-quote-left fa-2x"></i>
                        </div>
                        <div class="testimonial-img">
                            <img src="{{ asset('landing/img/user/user-2.png') }}" class="img-fluid"
                                alt="Image">
                        </div>
                        <div class="testimonial-text">
                            <p class="mb-0">Bantuan biaya pendidikan dari program INUK sangat membantu anak saya
                                melanjutkan sekolah. Terima kasih kepada para donatur yang telah berbagi.</p>
                        </div>
                        <div class="testimonial-title">
                            <div>
                                <h4 class="mb-0">Siti Aisyah</h4>
                                <p class="mb-0">Penerima Manfaat</p>
                            </div>
                            <div class="d-flex text-primary">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                    class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                        </div>
                        <div class="testimonial-quote-right">
                            <i class="fas fa-quote-right fa-2x"></i>
                        </div>
                    </div>
                    <!-- Testimoni 2 -->
                    <div class="testimonial-item">
                        <div class="testimonial-quote-left">
                            <i class="fas fa-quote-left fa-2x"></i>
                        </div>
                        <div class="testimonial-img">
                            <img src="{{ asset('landing/img/user/user-2.png') }}" class="img-fluid"
                                alt="Image">
                        </div>
                        <div class="testimonial-text">
                            <p class="mb-0">Saya merasa tenang dan percaya menyalurkan infaq melalui INUK.
                                Laporannya
                                transparan dan jelas penggunaannya.</p>
                        </div>
                        <div class="testimonial-title">
                            <div>
                                <h4 class="mb-0">Ahmad Fauzi</h4>
                                <p class="mb-0">Donatur Tetap</p>
                            </div>
                            <div class="d-flex text-primary">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                    class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                        </div>
                        <div class="testimonial-quote-right">
                            <i class="fas fa-quote-right fa-2x"></i>
                        </div>
                    </div>
                    <!-- Testimoni 3 -->
                    <div class="testimonial-item">
                        <div class="testimonial-quote-left">
                            <i class="fas fa-quote-left fa-2x"></i>
                        </div>
                        <div class="testimonial-img">
                            <img src="{{ asset('landing/img/user/user-2.png') }}" class="img-fluid"
                                alt="Image">
                        </div>
                        <div class="testimonial-text">
                            <p class="mb-0">Saat usaha saya terpuruk, bantuan modal usaha kecil dari INUK membantu
                                saya
                                bangkit. Alhamdulillah, sekarang mulai stabil kembali.</p>
                        </div>
                        <div class="testimonial-title">
                            <div>
                                <h4 class="mb-0">Pak Rahmat</h4>
                                <p class="mb-0">Penerima Bantuan UMKM</p>
                            </div>
                            <div class="d-flex text-primary">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                    class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                        </div>
                        <div class="testimonial-quote-right">
                            <i class="fas fa-quote-right fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="container pb-5">
                @foreach ($testi as $tes)
                    <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s"
                        style="max-width: 800px;">
                        <h4 class="text-primary">{{ $tes->tag ?? '-' }}</h4>
                        <h1 class="display-5 mb-4">{{ $tes->judul ?? '-' }}</h1>
                        <p class="mb-0">{{ $tes->ringkasan ?? '-' }}</p>
                    </div>
                    <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.2s">
                        <!-- Testimoni 1 -->
                        <div class="testimonial-item">
                            <div class="testimonial-quote-left">
                                <i class="fas fa-quote-left fa-2x"></i>
                            </div>
                            <div class="testimonial-img">
                                @if ($tes->foto == null)
                                    <div class="col-12">
                                        <div class="alert alert-info text-center">
                                            <img src="{{ asset('landing/img/user/user-2.png') }}"
                                                class="img-fluid" alt="Image">
                                        </div>
                                    </div>
                                @else
                                    <img src="{{ Storage::url($tes->foto ?? '-') }}" alt="Foto 1"
                                        class="img-fluid w-100 rounded">
                                @endif
                            </div>
                            <div class="testimonial-text">
                                <p class="mb-0">{{ $tes->testi ?? '-' }}</p>
                            </div>
                            <div class="testimonial-title">
                                <div>
                                    <h4 class="mb-0">{{ $tes->nama ?? '-' }}</h4>
                                    <p class="mb-0">{{ $tes->jenis ?? '-' }}</p>
                                </div>
                                <div class="d-flex text-primary">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                        class="fas fa-star"></i><i class="fas fa-star"></i><i
                                        class="fas fa-star"></i>
                                </div>
                            </div>
                            <div class="testimonial-quote-right">
                                <i class="fas fa-quote-right fa-2x"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <!-- Testimonial End -->

    @push('css')
        <style>
            .table th,
            .table td {
                vertical-align: middle;
                transition: background-color 0.2s;
            }

            .table tr:hover {
                background-color: #f1f3f5;
            }

            .badge {
                padding: 8px 12px;
                font-size: 0.9rem;
            }

            .form-select,
            .form-control {
                max-width: 400px;
                margin: 0 auto;
            }

            #kecamatanSummary p {
                margin: 0.5rem 0;
            }

            /* Gaya untuk Ringkasan Kecamatan */
            #kecamatanSummary .summary-row {
                display: flex;
                align-items: center;
                flex-wrap: nowrap;
                /* Pastikan elemen tidak membungkus ke baris baru */
            }

            /* Label dengan lebar minimum yang menyesuaikan konten terpanjang */
            #kecamatanSummary .summary-label {
                flex: 0 0 auto;
                min-width: 150px;
                /* Lebar minimum untuk label */
                font-weight: 500;
            }

            /* Tanda titik dua dengan lebar tetap untuk keselarasan */
            #kecamatanSummary .summary-colon {
                flex: 0 0 auto;
                width: 20px;
                /* Lebar tetap untuk tanda titik dua */
                text-align: center;
            }

            /* Nilai di sebelah kanan menyesuaikan sisa ruang */
            #kecamatanSummary .fw-bold {
                flex: 1;
                text-align: left;
            }

            /* Responsivitas untuk layar kecil */
            @media (max-width: 768px) {
                #kecamatanSummary .summary-label {
                    min-width: 120px;
                    /* Kurangi lebar minimum di layar kecil */
                    font-size: 0.9rem;
                    /* Kurangi ukuran font */
                }

                #kecamatanSummary .summary-colon {
                    width: 15px;
                    /* Kurangi lebar tanda titik dua */
                }

                #kecamatanSummary .fw-bold {
                    font-size: 0.9rem;
                }

                .card-body {
                    padding: 1rem;
                    /* Kurangi padding di layar kecil */
                }
            }

            @media (max-width: 576px) {
                #kecamatanSummary .summary-label {
                    min-width: 100px;
                    /* Lebar lebih kecil untuk ponsel */
                    font-size: 0.8rem;
                }

                #kecamatanSummary .summary-colon {
                    width: 12px;
                }

                #kecamatanSummary .fw-bold {
                    font-size: 0.8rem;
                }
            }

            .pagination .page-link {
                cursor: pointer;
            }

            /* Pastikan container utama responsif */
            .container-fluid.rekap {
                padding: 2rem 1rem;
                /* Kurangi padding di layar kecil */
            }

            /* Atur chart container agar responsif */
            .chart-container {
                position: relative;
                width: 100%;
                min-height: 300px;
                /* Tinggi minimum untuk grafik */
            }

            /* Atur tabel agar responsif di layar kecil */
            .table-responsive {
                overflow-x: auto;
                /* Scroll horizontal di layar kecil */
            }

            /* Sesuaikan font dan elemen untuk layar kecil */
            @media (max-width: 768px) {
                .display-6 {
                    font-size: 1.5rem;
                    /* Kurangi ukuran font di layar kecil */
                }

                .form-select,
                .form-control {
                    max-width: 100%;
                    /* Pastikan input dan select mengisi lebar penuh */
                }

                .card-body {
                    padding: 1rem;
                    /* Kurangi padding card di layar kecil */
                }

                .chart-container {
                    min-height: 250px;
                    /* Kurangi tinggi chart di layar kecil */
                }

                .table th,
                .table td {
                    font-size: 0.85rem;
                    /* Kurangi ukuran font tabel di layar kecil */
                }
            }

            /* Atur tampilan untuk layar sangat kecil (misalnya, ponsel) */
            @media (max-width: 576px) {
                .chart-container {
                    min-height: 200px;
                    /* Tinggi lebih kecil untuk ponsel */
                }

                .table th,
                .table td {
                    font-size: 0.75rem;
                    /* Ukuran font lebih kecil */
                }

                .badge {
                    font-size: 0.7rem;
                    /* Sesuaikan ukuran badge */
                    padding: 6px 10px;
                }
            }

            /* Reset default margins and paddings */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            /* Container utama */
            .container.team {
                max-width: 1200px;
                /* Lebar maksimum untuk layar besar */
                min-width: 320px;
                /* Lebar minimum untuk layar kecil */
                width: 100%;
                /* Container menyesuaikan lebar layar */
                margin: 0 auto;
                padding: 2rem 1rem;
                /* Padding konsisten */
            }

            /* Styling teks tengah */
            .text-center {
                text-align: center;
            }

            /* Styling logo */
            .team img {
                max-width: 200px;
                /* Ukuran maksimum logo */
                width: 50%;
                /* Proporsi seperti aslinya */
                height: auto;
                /* Jaga rasio aspek */
                margin: 0 auto;
                display: block;
            }

            /* Styling heading dan paragraf (sama seperti aslinya) */
            .team h1.display-5 {
                font-size: 3.5rem;
                /* Ukuran font heading seperti display-5 Bootstrap */
                margin-bottom: 1rem;
            }

            .team h4 {
                font-size: 1.5rem;
                margin-bottom: 0.5rem;
            }

            .team p {
                font-size: 1rem;
                /* Ukuran font normal untuk teks */
                margin-bottom: 1rem;
            }

            /* Styling list group */
            .list-group-item {
                display: flex;
                flex-wrap: nowrap;
                /* Pastikan tidak membungkus ke baris baru */
                align-items: flex-start;
                padding: 0.5rem 1rem;
                border-bottom: 1px solid #e9ecef;
                /* Garis pemisah */
            }

            .list-group-item .label {
                flex: 0 0 40%;
                /* Lebar label tetap 40% */
                font-weight: bold;
                font-size: 0.85rem;
                /* Ukuran font normal */
            }

            .list-group-item .separator {
                flex: 0 0 2%;
                /* Lebar separator tetap 2% */
                text-align: center;
                font-size: 0.85rem;
            }

            .list-group-item .value {
                flex: 0 0 58%;
                /* Lebar nilai tetap 58% */
                font-size: 0.85rem;
                /* Ukuran font normal */
            }

            /* Hover effect untuk list */
            .list-group-item:hover {
                background-color: #f1f3f5;
            }

            /* Media query hanya untuk mengecilkan container */
            @media (max-width: 768px) {
                .container.team {
                    max-width: 90%;
                    /* Container mengecil secara proporsional */
                }
            }

            @media (max-width: 576px) {
                .container.team {
                    max-width: 95%;
                    /* Container lebih kecil di layar sangat kecil */
                }

                .team img {
                    width: 40%;
                    /* Sedikit mengecilkan logo agar proporsional */
                    max-width: 150px;
                    /* Batas maksimum logo di layar kecil */
                }
            }

            /* Tambahkan di file CSS Anda atau dalam <style> di head */
            .marquee-container {
                position: relative;
                overflow: hidden;
                background-color: #f8f9fa;
                border-radius: 8px;
                padding: 10px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                display: flex;
                align-items: center;
                min-height: 40px;
            }

            .time-text {
                background-color: #00D084;
                color: #fff;
                padding: 2px 8px;
                border-radius: 4px;
                font-size: 1.1rem;
                position: absolute;
                left: 10px;
                top: 50%;
                transform: translateY(-50%);
                z-index: 10;
            }

            .inuk-text {
                background-color: #00D084;
                color: #fff;
                padding: 2px 8px;
                border-radius: 4px;
                font-size: 1.1rem;
                position: absolute;
                right: 10px;
                top: 50%;
                transform: translateY(-50%);
                z-index: 10;
            }

            .marquee-wrapper {
                flex-grow: 1;
                overflow: hidden;
                margin: 0 100px;
            }

            .marquee-text {
                white-space: nowrap;
                font-size: 1.1rem;
                color: #333;
                animation: marquee 20s linear infinite;
            }

            @keyframes marquee {
                0% {
                    transform: translateX(-100%);
                }

                100% {
                    transform: translateX(100%);
                }
            }

            @media (max-width: 576px) {
                .marquee-container {
                    padding: 8px;
                    min-height: 35px;
                }

                .time-text,
                .inuk-text {
                    font-size: 0.8rem;
                    padding: 2px 6px;
                }

                .marquee-wrapper {
                    margin: 0 70px;
                }

                .marquee-text {
                    font-size: 0.9rem;
                    animation-duration: 15s;
                }
            }
        </style>
    @endpush

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Script Chart.js -->
        <script>
            let donasiChart;

            // Data awal dari Blade
            const rekapPerDesa = @json($rekap_per_desa);
            const rekapPerKecamatan = @json($rekap_per_kecamatan);
            const kecamatans = @json($kecamatans);
            const colors = ['#0d6efd', '#6f42c1', '#20c997', '#ffc107', '#dc3545', '#198754', '#fd7e14', '#0dcaf0', '#6c757d',
                '#6610f2'
            ];

            // Data dummy
            const dummyData = [{
                    id_kecamatan: 0,
                    id_desa: 1,
                    nama_desa: "Desa Contoh 1",
                    jumlah_donatur_mengirim: 10,
                    total_donasi: 5000000,
                    total_donatur: 20
                },
                {
                    id_kecamatan: 0,
                    id_desa: 2,
                    nama_desa: "Desa Contoh 2",
                    jumlah_donatur_mengirim: 8,
                    total_donasi: 3500000,
                    total_donatur: 15
                },
                {
                    id_kecamatan: 0,
                    id_desa: 3,
                    nama_desa: "Desa Contoh 3",
                    jumlah_donatur_mengirim: 5,
                    total_donasi: 2750000,
                    total_donatur: 12
                },
                {
                    id_kecamatan: 0,
                    id_desa: 4,
                    nama_desa: "Desa Contoh 4",
                    jumlah_donatur_mengirim: 12,
                    total_donasi: 4200000,
                    total_donatur: 18
                },
                {
                    id_kecamatan: 0,
                    id_desa: 5,
                    nama_desa: "Desa Contoh 5",
                    jumlah_donatur_mengirim: 7,
                    total_donasi: 3800000,
                    total_donatur: 16
                }
            ];
            const dummyKecamatanData = {
                id_kecamatan: 0,
                nama_kecamatan: "Kecamatan Contoh",
                jumlah_donatur_mengirim: 42,
                total_donasi: 19250000,
                total_donatur: 83,
                persentase: 50.60
            };

            // Fungsi untuk memperbarui waktu
            function updateTime() {
                const timeDisplay = document.getElementById('timeDisplay');
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                timeDisplay.textContent = `${hours}:${minutes}`;
            }

            // Perbarui waktu setiap detik
            setInterval(updateTime, 1000);

            // Fungsi utama: updateData()
            function updateData() {
                const kecamatanId = document.getElementById('kecamatanSelect').value;
                const searchQuery = document.getElementById('searchInput').value.toLowerCase();
                const tbody = document.getElementById('tableBody');
                const totalDonasiSpan = document.getElementById('totalDonasi');
                const summaryTotalDonasi = document.getElementById('summaryTotalDonasi');
                const summaryJumlahDonatur = document.getElementById('summaryJumlahDonatur');
                const summaryPersentase = document.getElementById('summaryPersentase');
                const namaKecamatan = document.getElementById('namaKecamatan');
                const donasiMarquee = document.getElementById('donasiMarquee');
                tbody.innerHTML = '';

                // Filter data desa berdasarkan kecamatan
                let filteredData = kecamatanId ? rekapPerDesa.filter(item => item.id_kecamatan == kecamatanId) : rekapPerDesa;

                // Filter ringkasan kecamatan
                let kecamatanData = kecamatanId ? rekapPerKecamatan.find(item => item.id_kecamatan == kecamatanId) : null;

                // Tentukan apakah menggunakan data dummy
                const isDummy = filteredData.length === 0 || rekapPerDesa.length === 0;
                let displayNamaKecamatan = '-';

                if (isDummy && !kecamatanId) {
                    // Semua Kecamatan, gunakan dummy data
                    filteredData = dummyData;
                    kecamatanData = dummyKecamatanData;
                    displayNamaKecamatan = 'Semua Kecamatan (Contoh)';
                } else if (isDummy && kecamatanId) {
                    // Kecamatan tertentu tanpa data, gunakan dummy data dengan nama kecamatan yang dipilih
                    filteredData = dummyData.map(item => ({
                        ...item,
                        id_kecamatan: kecamatanId
                    }));
                    kecamatanData = {
                        ...dummyKecamatanData,
                        id_kecamatan: kecamatanId,
                        nama_kecamatan: kecamatans[kecamatanId] || 'Unknown'
                    };
                    displayNamaKecamatan = `${kecamatanData.nama_kecamatan} (Contoh)`;
                } else if (!kecamatanId) {
                    // Semua Kecamatan, data asli
                    displayNamaKecamatan = 'Semua Kecamatan';
                } else if (kecamatanData) {
                    // Kecamatan tertentu, data asli
                    displayNamaKecamatan = kecamatanData.nama_kecamatan;
                } else {
                    // Kecamatan tertentu, tapi tidak ada di rekap, fallback ke kecamatans
                    displayNamaKecamatan = kecamatans[kecamatanId] || 'Unknown';
                }

                // Update nama kecamatan di ringkasan
                namaKecamatan.textContent = displayNamaKecamatan;

                // Filter berdasarkan pencarian desa
                filteredData = filteredData.filter(item => item.nama_desa.toLowerCase().includes(searchQuery));

                // Jika tidak ada data setelah filter pencarian
                if (filteredData.length === 0 && !isDummy) {
                    tbody.innerHTML =
                        '<tr><td colspan="5" class="text-center text-muted">Tidak ada desa yang cocok dengan pencarian.</td></tr>';
                    updateChart([], []);
                    totalDonasiSpan.textContent = 'Rp 0';
                    if (kecamatanData) {
                        summaryTotalDonasi.textContent = `Rp ${kecamatanData.total_donasi.toLocaleString('id-ID')}`;
                        summaryJumlahDonatur.textContent = kecamatanData.jumlah_donatur_mengirim;
                        summaryPersentase.textContent = `${kecamatanData.persentase.toFixed(2)}%`;
                    } else {
                        summaryTotalDonasi.textContent = 'Rp 0';
                        summaryJumlahDonatur.textContent = '0';
                        summaryPersentase.textContent = '0.00%';
                    }
                    if (donasiMarquee) donasiMarquee.textContent = 'Tidak ada desa yang cocok dengan pencarian.';
                    return;
                }

                // Isi tabel
                let totalDonasi = 0;
                filteredData.forEach((item, index) => {
                    totalDonasi += item.total_donasi;
                    const persentase = item.total_donatur > 0 ? ((item.jumlah_donatur_mengirim / item.total_donatur) *
                        100).toFixed(2) : '0.00';
                    const row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td class="text-start">${item.nama_desa}${isDummy ? ' (Contoh)' : ''}</td>
                            <td>${item.jumlah_donatur_mengirim}</td>
                            <td><span class="badge bg-success fs-6">Rp ${item.total_donasi.toLocaleString('id-ID')}</span></td>
                            <td>${persentase}%</td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                });

                // Isi teks marquee (jika elemen ada)
                if (donasiMarquee) {
                    let marqueeText = filteredData.map(item =>
                        `Total donasi Desa <strong>${item.nama_desa}${isDummy ? ' (Contoh)' : ''}</strong> : Rp <strong>${item.total_donasi.toLocaleString('id-ID')}</strong>`
                    ).join(' | ');
                    donasiMarquee.innerHTML = marqueeText || 'Tidak ada data donasi untuk ditampilkan.';
                }

                // Update total donasi di tabel
                totalDonasiSpan.textContent = `Rp ${totalDonasi.toLocaleString('id-ID')}${isDummy ? ' (Contoh)' : ''}`;

                // Update ringkasan kecamatan
                if (kecamatanData) {
                    summaryTotalDonasi.textContent =
                        `Rp ${kecamatanData.total_donasi.toLocaleString('id-ID')}${isDummy ? ' (Contoh)' : ''}`;
                    summaryJumlahDonatur.textContent = kecamatanData.jumlah_donatur_mengirim;
                    summaryPersentase.textContent = `${kecamatanData.persentase.toFixed(2)}%${isDummy ? ' (Contoh)' : ''}`;
                } else if (!kecamatanId) {
                    const totalKecamatan = rekapPerKecamatan.reduce((acc, item) => ({
                        total_donasi: acc.total_donasi + item.total_donasi,
                        jumlah_donatur_mengirim: acc.jumlah_donatur_mengirim + item.jumlah_donatur_mengirim,
                        total_donatur: acc.total_donatur + item.total_donatur
                    }), {
                        total_donasi: 0,
                        jumlah_donatur_mengirim: 0,
                        total_donatur: 0
                    });
                    summaryTotalDonasi.textContent =
                        `Rp ${totalKecamatan.total_donasi.toLocaleString('id-ID')}${isDummy ? ' (Contoh)' : ''}`;
                    summaryJumlahDonatur.textContent = totalKecamatan.jumlah_donatur_mengirim;
                    const persentaseAll = totalKecamatan.total_donatur > 0 ?
                        ((totalKecamatan.jumlah_donatur_mengirim / totalKecamatan.total_donatur) * 100).toFixed(2) : 0;
                    summaryPersentase.textContent = `${persentaseAll}%${isDummy ? ' (Contoh)' : ''}`;
                } else {
                    summaryTotalDonasi.textContent = 'Rp 0';
                    summaryJumlahDonatur.textContent = '0';
                    summaryPersentase.textContent = '0.00%';
                }

                // Update grafik
                const labels = filteredData.map(item => `${item.nama_desa}${isDummy ? ' (Contoh)' : ''}`);
                const data = filteredData.map(item => item.total_donasi);
                updateChart(labels, data);
            }

            function updateChart(labels, data) {
                const ctx = document.getElementById('donasiChart').getContext('2d');

                if (donasiChart) {
                    donasiChart.destroy();
                }

                donasiChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Donasi',
                            data: data,
                            backgroundColor: colors.slice(0, labels.length),
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 20,
                                    font: {
                                        size: window.innerWidth < 576 ? 12 : 14
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const value = context.raw;
                                        return `Rp ${value.toLocaleString('id-ID')}`;
                                    }
                                }
                            }
                        },
                        animation: {
                            duration: 1000,
                            easing: 'easeOutQuart'
                        },
                        layout: {
                            padding: {
                                top: 10,
                                bottom: 10,
                                left: 10,
                                right: 10
                            }
                        }
                    }
                });
            }

            function clearSearch() {
                document.getElementById('searchInput').value = '';
                updateData();
            }

            // Inisialisasi data dan waktu saat halaman dimuat
            document.addEventListener('DOMContentLoaded', () => {
                updateTime();
                updateData();
            });
        </script>
    @endpush

</x-sekunder.terminal.home>
