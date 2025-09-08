@foreach ($program as $item)
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
                                            <img src="{{ Storage::url($item->foto1 ?? '-') }}" width="50px"
                                                height="auto" class="img-fluid rounded-top w-100"
                                                alt="LAZISNU - Infaq INUK">
                                        @endif
                                    </div>
                                    <div class="rounded-bottom p-4">
                                        <a href="#"
                                            class="h4 d-inline-block mb-4">{{ $item->program1 ?? '-' }}</a>
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
                                            <img src="{{ Storage::url($item->foto2 ?? '-') }}" width="50px"
                                                height="auto" class="img-fluid rounded-top w-100" alt="MLU">
                                        @endif
                                    </div>
                                    <div class="rounded-bottom p-4">
                                        <a href="#"
                                            class="h4 d-inline-block mb-4">{{ $item->program2 ?? '-' }}</a>
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
                                            <img src="{{ Storage::url($item->foto3 ?? '-') }}" width="50px"
                                                height="auto" class="img-fluid rounded-top w-100" alt="Qurban">
                                        @endif
                                    </div>
                                    <div class="rounded-bottom p-4">
                                        <a href="#"
                                            class="h4 d-inline-block mb-4">{{ $item->program3 ?? '-' }}</a>
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
                                            <img src="{{ Storage::url($item->foto4 ?? '-') }}" width="50px"
                                                height="auto" class="img-fluid rounded-top w-100" alt="Santunan">
                                        @endif
                                    </div>
                                    <div class="rounded-bottom p-4">
                                        <a href="#"
                                            class="h4 d-inline-block mb-4">{{ $item->program4 ?? '-' }}</a>
                                        <p class="mb-4">{{ $item->ringkasan4 ?? '-' }}</p>
                                        {{-- <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Lihat Program</a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ url('superadmin/master-data/program-kami/edit-data/' . $item->id) }}"
                        class="btn btn-sm btn-warning">
                        <i class="bx bxs-pencil"></i> Edit
                    </a>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
