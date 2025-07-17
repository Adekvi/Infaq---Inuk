<x-sekunder.terminal.home title="Landing Page">

    <!-- About Start -->
    <div class="container-fluid about py-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-xl-7 wow fadeInLeft" data-wow-delay="0.2s">
                    <div>
                        <h4 class="text-primary">Tentang Kami</h4>
                        <h1 class="display-5 mb-4">Bersama LAZISNU, Wujudkan Kepedulian Lewat INUK</h1>
                        <p class="mb-4">
                            INUK (Infaq untuk Umat dan Kesejahteraan) adalah program unggulan dari LAZISNU yang hadir
                            untuk
                            menjembatani kebaikan Anda kepada mereka yang membutuhkan. Dengan semangat gotong royong dan
                            kepedulian,
                            kami mendorong masyarakat untuk berinfaq secara mudah, transparan, dan berdampak nyata.
                        </p>
                        <div class="row g-4">
                            <div class="col-md-6 col-lg-6 col-xl-6">
                                <div class="d-flex">
                                    <div><i class="fas fa-hand-holding-heart fa-3x text-primary"></i></div>
                                    <div class="ms-4">
                                        <h4>Infaq yang Amanah</h4>
                                        <p>Setiap donasi dikelola secara profesional dan disalurkan tepat sasaran.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-6">
                                <div class="d-flex">
                                    <div><i class="bi bi-bar-chart-line-fill fa-3x text-primary"></i></div>
                                    <div class="ms-4">
                                        <h4>Transparan dan Terpercaya</h4>
                                        <p>Pelaporan berkala untuk memastikan kepercayaan dan keberlanjutan program.</p>
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
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Services Start -->
    <div class="container-fluid service pb-5">
        <div class="container pb-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h4 class="text-primary">Layanan Kami</h4>
                <h1 class="display-5 mb-4">Program Unggulan INUK - LAZISNU</h1>
                <p class="mb-0">
                    INUK (Infaq untuk Umat dan Kesejahteraan) adalah program dari LAZISNU yang berkomitmen untuk
                    menyalurkan infaq secara amanah, transparan, dan tepat sasaran guna mendukung kesejahteraan umat.
                </p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="service-item">
                        <div class="service-img">
                            <img src="{{ asset('landing/img/service/service-1.jpg') }}"
                                class="img-fluid rounded-top w-100" alt="Infaq Pendidikan">
                        </div>
                        <div class="rounded-bottom p-4">
                            <a href="#" class="h4 d-inline-block mb-4">Infaq Pendidikan</a>
                            <p class="mb-4">Dukungan beasiswa dan bantuan operasional bagi siswa kurang
                                mampu.</p>
                            <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Lihat Program</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="service-item">
                        <div class="service-img">
                            <img src="{{ asset('landing/img/service/service-2.jpg') }}"
                                class="img-fluid rounded-top w-100" alt="Infaq Kesehatan">
                        </div>
                        <div class="rounded-bottom p-4">
                            <a href="#" class="h4 d-inline-block mb-4">Infaq Kesehatan</a>
                            <p class="mb-4">Bantuan pengobatan, layanan kesehatan gratis, serta bantuan untuk warga
                                yang sedang dirawat.</p>
                            <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Lihat Program</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.6s">
                    <div class="service-item">
                        <div class="service-img">
                            <img src="{{ asset('landing/img/service/service-3.jpg') }}"
                                class="img-fluid rounded-top w-100" alt="Infaq Ekonomi">
                        </div>
                        <div class="rounded-bottom p-4">
                            <a href="#" class="h4 d-inline-block mb-4">Infaq Ekonomi</a>
                            <p class="mb-4">Program pemberdayaan ekonomi umat seperti bantuan modal UMKM, pelatihan
                                kerja, dan usaha mikro.</p>
                            <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Lihat Program</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="service-item">
                        <div class="service-img">
                            <img src="{{ asset('landing/img/service/service-4.jpg') }}"
                                class="img-fluid rounded-top w-100" alt="Infaq Bencana">
                        </div>
                        <div class="rounded-bottom p-4">
                            <a href="#" class="h4 d-inline-block mb-4">Infaq Tanggap Bencana</a>
                            <p class="mb-4">Respon cepat berupa logistik, sandang, pangan, dan bantuan relokasi bagi
                                korban bencana.</p>
                            <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Lihat Program</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.4s">
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
                </div>
            </div>
        </div>
    </div>
    <!-- Services End -->

    <!-- Features Start -->
    <div class="container-fluid service pb-5">
        <div class="container pb-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h4 class="text-primary">Program Kami</h4>
                <h1 class="display-5 mb-4">Program Infaq untuk Umat & Kesejahteraan</h1>
                <p class="mb-0">Melalui program INUK dari LAZISNU, kami menghadirkan berbagai layanan sosial dan
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
                            <p class="mb-4">Menyalurkan infaq kepada anak yatim, dhuafa, dan keluarga kurang mampu
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
                            <p class="mb-4">Bantuan biaya pendidikan bagi siswa berprestasi namun kurang mampu, serta
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
                            <p class="mb-4">Fasilitasi pengobatan, bantuan alat kesehatan, dan penyuluhan kesehatan
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
    </div>
    <!-- Features End -->

    <!-- Offer Start -->
    <div class="container-fluid offer-section pb-5">
        <div class="container pb-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h4 class="text-primary">Keunggulan Kami</h4>
                <h1 class="display-5 mb-4">Manfaat Menunaikan Infaq bersama INUK</h1>
                <p class="mb-0">INUK hadir sebagai solusi menyalurkan infaq dengan amanah, transparan, dan berdampak.
                    Kami tidak hanya menyalurkan, tetapi juga memastikan setiap rupiah membawa perubahan nyata bagi umat
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
                                    <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Selengkapnya</a>
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
                                    <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Selengkapnya</a>
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
                                    <p class="mb-4">Melalui QRIS, transfer bank, dan platform online, kini berdonasi
                                        tak perlu repot. Anda bisa menyalurkan kebaikan hanya dengan beberapa klik saja.
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
                                    <p class="mb-4">Kami menyediakan laporan bulanan, dokumentasi penyaluran, serta
                                        pelaporan real-time agar para donatur merasa yakin dan puas.</p>
                                    <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Lihat Laporan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Offer End -->

    <!-- Blog Start -->
    <div class="container-fluid blog pb-5">
        <div class="container pb-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h4 class="text-primary">Blog & Berita</h4>
                <h1 class="display-5 mb-4">Cerita Inspiratif dan Info Terkini Seputar INUK</h1>
                <p class="mb-0">
                    Dapatkan informasi terbaru mengenai kegiatan sosial, edukasi filantropi, serta kisah nyata dari para
                    penerima manfaat infaq Anda. Bersama INUK, setiap infaq adalah jalan keberkahan.
                </p>
            </div>

            <div class="owl-carousel blog-carousel wow fadeInUp" data-wow-delay="0.2s">
                <!-- Blog 1 -->
                <div class="blog-item p-4">
                    <div class="blog-img mb-4">
                        <img src="{{ asset('landing/img/carousel/carousel-1.jpg') }}" class="img-fluid w-100 rounded"
                            alt="">
                        <div class="blog-title">
                            <a href="#" class="btn">Program Pendidikan</a>
                        </div>
                    </div>
                    <a href="#" class="h4 d-inline-block mb-3">Infaq Anda, Harapan Baru Bagi Generasi Muda</a>
                    <p class="mb-4">
                        Melalui program beasiswa dan perlengkapan sekolah, LAZISNU INUK menyalurkan infaq untuk
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
                    <a href="#" class="h4 d-inline-block mb-3">Dari Infaq ke Harapan: Kisah Ibu Siti</a>
                    <p class="mb-4">
                        Ibu Siti, janda dengan tiga anak, kini memiliki usaha kecil berkat program infaq pemberdayaan
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
                    <a href="#" class="h4 d-inline-block mb-3">Layanan Kesehatan Gratis Lewat Infaq</a>
                    <p class="mb-4">
                        LAZISNU INUK mengadakan pengobatan gratis bagi masyarakat prasejahtera. Infaq Anda menjadi jalan
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
                    <a href="#" class="h4 d-inline-block mb-3">Apa Perbedaan Infaq, Zakat, dan Sedekah?</a>
                    <p class="mb-4">
                        Edukasi dasar tentang konsep ZIS (Zakat, Infaq, Sedekah) agar umat lebih paham perannya dalam
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
    </div>
    <!-- Blog End -->

    <!-- FAQs Start -->
    <div class="container-fluid faq-section pb-5">
        <div class="container pb-5 overflow-hidden">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h4 class="text-primary">FAQs</h4>
                <h1 class="display-5 mb-4">Pertanyaan yang Sering Diajukan</h1>
                <p class="mb-0">
                    Temukan jawaban atas pertanyaan umum seputar layanan, transparansi, dan kemudahan berdonasi melalui
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
                                    INUK (Infaq untuk Umat dan Kesejahteraan) adalah program infaq yang dikelola oleh
                                    LAZISNU, berfokus pada penyaluran dana infaq secara amanah, transparan, dan
                                    berdampak bagi umat.
                                </div>
                            </div>
                        </div>
                        <!-- FAQ 2 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                    aria-controls="flush-collapseTwo">
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
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseThree" aria-expanded="false"
                                    aria-controls="flush-collapseThree">
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
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseFour" aria-expanded="false"
                                    aria-controls="flush-collapseFour">
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
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseFive" aria-expanded="false"
                                    aria-controls="flush-collapseFive">
                                    Apakah donasi saya bisa atas nama orang lain?
                                </button>
                            </h2>
                            <div id="flush-collapseFive" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushSection">
                                <div class="accordion-body">
                                    Bisa. Anda dapat berdonasi atas nama pribadi, keluarga, almarhum, ataupun lembaga.
                                    Cukup cantumkan nama dalam keterangan saat pengisian form donasi.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Image Side -->
                <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
                    <div class="bg-primary rounded">
                        <img src="{{ asset('landing/img/carousel/carousel-2.jpg') }}" class="img-fluid w-100 rounded"
                            alt="Ilustrasi FAQ INUK">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FAQs End -->

    <!-- Team Start -->
    <div class="container-fluid team pb-5">
        <div class="container pb-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h4 class="text-primary">Tim Kami</h4>
                <h1 class="display-5 mb-4">Kenali Sosok di Balik INUK</h1>
                <p class="mb-0">
                    Tim INUK terdiri dari pengurus profesional dan relawan yang berkomitmen tinggi dalam mengelola dan
                    menyalurkan infaq secara amanah, transparan, dan tepat sasaran.
                </p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="team-item">
                        <div class="team-img">
                            <img src="{{ asset('landing/img/user/user-1.webp') }}" class="img-fluid"
                                alt="Ketua LAZISNU">
                        </div>
                        <div class="team-title">
                            <h4 class="mb-0">Ust. Ahmad Faqih</h4>
                            <p class="mb-0">Ketua LAZISNU</p>
                        </div>
                        <div class="team-icon">
                            <a class="btn btn-primary btn-sm-square rounded-circle me-3" href="#"><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-primary btn-sm-square rounded-circle me-3" href="#"><i
                                    class="fab fa-twitter"></i></a>
                            <a class="btn btn-primary btn-sm-square rounded-circle me-0" href="#"><i
                                    class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="team-item">
                        <div class="team-img">
                            <img src="{{ asset('landing/img/user/user-1.webp') }}" class="img-fluid"
                                alt="Koordinator Program">
                        </div>
                        <div class="team-title">
                            <h4 class="mb-0">Nur Aini, S.Sos</h4>
                            <p class="mb-0">Koordinator Program Sosial</p>
                        </div>
                        <div class="team-icon">
                            <a class="btn btn-primary btn-sm-square rounded-circle me-3" href="#"><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-primary btn-sm-square rounded-circle me-3" href="#"><i
                                    class="fab fa-linkedin-in"></i></a>
                            <a class="btn btn-primary btn-sm-square rounded-circle me-0" href="#"><i
                                    class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.6s">
                    <div class="team-item">
                        <div class="team-img">
                            <img src="{{ asset('landing/img/user/user-1.webp') }}" class="img-fluid"
                                alt="Bendahara">
                        </div>
                        <div class="team-title">
                            <h4 class="mb-0">H. Zainul Arifin</h4>
                            <p class="mb-0">Bendahara Umum</p>
                        </div>
                        <div class="team-icon">
                            <a class="btn btn-primary btn-sm-square rounded-circle me-3" href="#"><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-primary btn-sm-square rounded-circle me-3" href="#"><i
                                    class="fab fa-whatsapp"></i></a>
                            <a class="btn btn-primary btn-sm-square rounded-circle me-0" href="#"><i
                                    class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.8s">
                    <div class="team-item">
                        <div class="team-img">
                            <img src="{{ asset('landing/img/user/user-1.webp') }}" class="img-fluid"
                                alt="Tim Media">
                        </div>
                        <div class="team-title">
                            <h4 class="mb-0">Rizki Fadhilah</h4>
                            <p class="mb-0">Media & Dokumentasi</p>
                        </div>
                        <div class="team-icon">
                            <a class="btn btn-primary btn-sm-square rounded-circle me-3" href="#"><i
                                    class="fab fa-youtube"></i></a>
                            <a class="btn btn-primary btn-sm-square rounded-circle me-3" href="#"><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-primary btn-sm-square rounded-circle me-0" href="#"><i
                                    class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->

    <!-- Testimonial Start -->
    <div class="container-fluid testimonial pb-5">
        <div class="container pb-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h4 class="text-primary">Testimoni</h4>
                <h1 class="display-5 mb-4">Cerita dari Para Penerima & Donatur</h1>
                <p class="mb-0">Berikut adalah kesan dan pesan dari para donatur serta penerima manfaat program INUK.
                    Mereka merasakan langsung dampak nyata dari infaq yang dikelola oleh LAZISNU.</p>
            </div>
            <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.2s">
                <!-- Testimoni 1 -->
                <div class="testimonial-item">
                    <div class="testimonial-quote-left">
                        <i class="fas fa-quote-left fa-2x"></i>
                    </div>
                    <div class="testimonial-img">
                        <img src="{{ asset('landing/img/user/user-2.png') }}" class="img-fluid" alt="Image">
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
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                class="fas fa-star"></i><i class="fas fa-star"></i>
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
                        <img src="{{ asset('landing/img/user/user-2.png') }}" class="img-fluid" alt="Image">
                    </div>
                    <div class="testimonial-text">
                        <p class="mb-0">Saya merasa tenang dan percaya menyalurkan infaq melalui INUK. Laporannya
                            transparan dan jelas penggunaannya.</p>
                    </div>
                    <div class="testimonial-title">
                        <div>
                            <h4 class="mb-0">Ahmad Fauzi</h4>
                            <p class="mb-0">Donatur Tetap</p>
                        </div>
                        <div class="d-flex text-primary">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                class="fas fa-star"></i><i class="fas fa-star"></i>
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
                        <img src="{{ asset('landing/img/user/user-2.png') }}" class="img-fluid" alt="Image">
                    </div>
                    <div class="testimonial-text">
                        <p class="mb-0">Saat usaha saya terpuruk, bantuan modal usaha kecil dari INUK membantu saya
                            bangkit. Alhamdulillah, sekarang mulai stabil kembali.</p>
                    </div>
                    <div class="testimonial-title">
                        <div>
                            <h4 class="mb-0">Pak Rahmat</h4>
                            <p class="mb-0">Penerima Bantuan UMKM</p>
                        </div>
                        <div class="d-flex text-primary">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                    </div>
                    <div class="testimonial-quote-right">
                        <i class="fas fa-quote-right fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->

</x-sekunder.terminal.home>
