@foreach ($keunggulan as $item)
    <div class="modal fade" id="detail{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="kirimLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kirimLabel">Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="kirimForm">
                    <div class="container pb-5">
                        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s"
                            style="max-width: 800px;">
                            <h4 class="text-primary">{{ $item->tag ?? '-' }}</h4>
                            <h1 class="display-5 mb-4">{{ $item->judul ?? '-' }}</h1>
                            <p class="mb-0">{{ $item->deskripsi ?? '-' }}</p>
                        </div>
                        <div class="row g-5 align-items-center">
                            <div class="col-xl-5 wow fadeInLeft" data-wow-delay="0.2s">
                                <div class="nav nav-pills bg-light rounded p-5">
                                    <a class="accordion-link p-4 active mb-4" data-bs-toggle="pill" href="#collapseOne">
                                        <h5 class="mb-0">{{ $item->motto1 ?? '-' }}</h5>
                                    </a>
                                    <a class="accordion-link p-4 mb-4" data-bs-toggle="pill" href="#collapseTwo">
                                        <h5 class="mb-0">{{ $item->motto2 ?? '-' }}</h5>
                                    </a>
                                    <a class="accordion-link p-4 mb-4" data-bs-toggle="pill" href="#collapseThree">
                                        <h5 class="mb-0">{{ $item->motto3 ?? '-' }}</h5>
                                    </a>
                                    <a class="accordion-link p-4 mb-0" data-bs-toggle="pill" href="#collapseFour">
                                        <h5 class="mb-0">{{ $item->motto4 ?? '-' }}</h5>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-7 wow fadeInRight" data-wow-delay="0.4s">
                                <div class="tab-content">
                                    <!-- Tab 1 -->
                                    <div id="collapseOne" class="tab-pane fade show p-0 active">
                                        <div class="row g-4">
                                            <div class="col-md-7">
                                                @if ($item->foto1 == null)
                                                    <div class="col-12">
                                                        <div class="alert alert-info text-center">
                                                            <img src="{{ asset('landing/img/offer/unggul-1.jpg') }}"
                                                                class="img-fluid w-100 rounded"
                                                                alt="Transparansi Infaq">
                                                        </div>
                                                    </div>
                                                @else
                                                    <img src="{{ Storage::url($item->foto1 ?? '-') }}" alt="Foto 1"
                                                        class="img-fluid w-100 rounded">
                                                @endif
                                            </div>
                                            <div class="col-md-5">
                                                <h1 class="display-6 mb-4">{{ $item->kalimat1 ?? '-' }}</h1>
                                                <p class="mb-4">{{ $item->ringkasan1 ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Tab 2 -->
                                    <div id="collapseTwo" class="tab-pane fade show p-0">
                                        <div class="row g-4">
                                            <div class="col-md-7">
                                                @if ($item->foto2 == null)
                                                    <div class="col-12">
                                                        <div class="alert alert-info text-center">
                                                            <img src="{{ asset('landing/img/offer/unggul-2.jpg') }}"
                                                                class="img-fluid w-100 rounded" alt="Cepat dan Tepat">
                                                        </div>
                                                    </div>
                                                @else
                                                    <img src="{{ Storage::url($item->foto2 ?? '-') }}" alt="Foto 1"
                                                        class="img-fluid w-100 rounded">
                                                @endif
                                            </div>
                                            <div class="col-md-5">
                                                <h1 class="display-6 mb-4">{{ $item->kalimat2 ?? '-' }}</h1>
                                                <p class="mb-4">{{ $item->ringkasan2 ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Tab 3 -->
                                    <div id="collapseThree" class="tab-pane fade show p-0">
                                        <div class="row g-4">
                                            <div class="col-md-7">
                                                @if ($item->foto3 == null)
                                                    <div class="col-12">
                                                        <div class="alert alert-info text-center">
                                                            <img src="{{ asset('landing/img/offer/unggul-3.jpg') }}"
                                                                class="img-fluid w-100 rounded" alt="Donasi Digital">
                                                        </div>
                                                    </div>
                                                @else
                                                    <img src="{{ Storage::url($item->foto3 ?? '-') }}" alt="Foto 1"
                                                        class="img-fluid w-100 rounded">
                                                @endif
                                            </div>
                                            <div class="col-md-5">
                                                <h1 class="display-6 mb-4">{{ $item->kalimat3 ?? '-' }}</h1>
                                                <p class="mb-4">{{ $item->ringkasan3 ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Tab 4 -->
                                    <div id="collapseFour" class="tab-pane fade show p-0">
                                        <div class="row g-4">
                                            <div class="col-md-7">
                                                @if ($item->foto4 == null)
                                                    <div class="col-12">
                                                        <div class="alert alert-info text-center">
                                                            <img src="{{ asset('landing/img/offer/unggul-4.jpg') }}"
                                                                class="img-fluid w-100 rounded"
                                                                alt="Laporan dan Dokumentasi">
                                                        </div>
                                                    </div>
                                                @else
                                                    <img src="{{ Storage::url($item->foto4 ?? '-') }}" alt="Foto 1"
                                                        class="img-fluid w-100 rounded">
                                                @endif
                                            </div>
                                            <div class="col-md-5">
                                                <h1 class="display-6 mb-4">{{ $item->kalimat4 ?? '-' }}</h1>
                                                <p class="mb-4">{{ $item->ringkasan4 ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ url('superadmin/master-data/keunggulan-kami/edit-data/' . $item->id) }}"
                        class="btn btn-sm btn-warning">
                        <i class="bx bxs-pencil"></i> Edit
                    </a>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
