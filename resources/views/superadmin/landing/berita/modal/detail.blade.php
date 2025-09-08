@foreach ($berita as $item)
    <div class="modal fade" id="detail{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="kirimLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kirimLabel">Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="kirimForm">
                    @if (is_null($berita))
                        <div class="container pb-5">
                            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s"
                                style="max-width: 800px;">
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
                                        <img src="{{ asset('landing/img/blog/blog-2.jpg') }}"
                                            class="img-fluid w-100 rounded" alt="">
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
                                        <img src="{{ asset('landing/img/blog/blog-3.jpg') }}"
                                            class="img-fluid w-100 rounded" alt="">
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
                                        <img src="{{ asset('landing/img/blog/blog-4.jpg') }}"
                                            class="img-fluid w-100 rounded" alt="">
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
                            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s"
                                style="max-width: 800px;">
                                <h4 class="text-primary">{{ $item->tag ?? '-' }}</h4>
                                <h1 class="display-5 mb-4">{{ $item->judul ?? '-' }}</h1>
                                <p class="mb-0">
                                    {{ $item->ringkasan ?? '-' }}
                                </p>
                            </div>

                            <div class="owl-carousel blog-carousel wow fadeInUp" data-wow-delay="0.2s">
                                <!-- Blog 1 -->
                                <div class="blog-item p-4">
                                    <div class="blog-img mb-4">
                                        @if ($item->foto1 == null)
                                            <div class="col-12">
                                                <div class="alert alert-info text-center">
                                                    <img src="{{ asset('landing/img/carousel/carousel-1.jpg') }}"
                                                        class="img-fluid w-100 rounded" alt="">
                                                </div>
                                            </div>
                                        @else
                                            <img src="{{ Storage::url($item->foto1 ?? '-') }}" alt="Foto 1"
                                                class="img-fluid w-100 rounded">
                                        @endif
                                        <div class="blog-title">
                                            <a href="#" class="btn">{{ $item->motto1 ?? '-' }}</a>
                                        </div>
                                    </div>
                                    <a href="#" class="h4 d-inline-block mb-3">{{ $iten->judul1 ?? '-' }}</a>
                                    <p class="mb-4">
                                        {{ $item->ringkasan1 ?? '-' }}
                                    </p>
                                    <div class="d-flex align-items-center">
                                        @if ($item->foto2 == null)
                                            <div class="col-12">
                                                <div class="alert alert-info text-center">
                                                    <img src="{{ asset('landing/img/admin.png') }}"
                                                        class="img-fluid rounded-circle"
                                                        style="width: 60px; height: 60px;" alt="">
                                                </div>
                                            </div>
                                        @else
                                            <img src="{{ Storage::url($item->foto2 ?? '-') }}" alt="Foto 1"
                                                class="img-fluid w-100 rounded">
                                        @endif
                                        <div class="ms-3">
                                            <h5>
                                                @if ($item->penulis)
                                                    {{ $penulis }}
                                                @else
                                                    Admin
                                                @endif
                                            </h5>
                                            <p class="mb-0">{{ $item->tgl_berita ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <a href="{{ url('superadmin/master-data/berita/edit-data/' . $item->id) }}"
                        class="btn btn-sm btn-warning">
                        <i class="bx bxs-pencil"></i> Edit
                    </a>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
