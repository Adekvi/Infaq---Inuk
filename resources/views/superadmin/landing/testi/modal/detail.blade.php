@foreach ($testi as $item)
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
                            <p class="mb-0">{{ $item->ringkasan ?? '-' }}</p>
                        </div>
                        <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.2s">
                            <!-- Testimoni 1 -->
                            <div class="testimonial-item">
                                <div class="testimonial-quote-left">
                                    <i class="fas fa-quote-left fa-2x"></i>
                                </div>
                                <div class="testimonial-img">
                                    @if ($item->foto == null)
                                        <div class="col-12">
                                            <div class="alert alert-info text-center">
                                                <img src="{{ asset('landing/img/user/user-2.png') }}" class="img-fluid"
                                                    alt="Image">
                                            </div>
                                        </div>
                                    @else
                                        <img src="{{ Storage::url($item->foto ?? '-') }}" alt="Foto 1"
                                            class="img-fluid w-100 rounded">
                                    @endif
                                </div>
                                <div class="testimonial-text">
                                    <p class="mb-0">{{ $item->testi ?? '-' }}</p>
                                </div>
                                <div class="testimonial-title">
                                    <div>
                                        <h4 class="mb-0">{{ $item->nama ?? '-' }}</h4>
                                        <p class="mb-0">{{ $item->jenis ?? '-' }}</p>
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
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ url('superadmin/master-data/testi/edit-data/' . $item->id) }}"
                        class="btn btn-sm btn-warning">
                        <i class="bx bxs-pencil"></i> Edit
                    </a>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
