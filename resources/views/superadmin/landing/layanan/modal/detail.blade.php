@foreach ($layanan as $item)
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
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ url('superadmin/master-data/layanan-kami/edit-data/' . $item->id) }}"
                        class="btn btn-sm btn-warning">
                        <i class="bx bxs-pencil"></i> Edit
                    </a>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
