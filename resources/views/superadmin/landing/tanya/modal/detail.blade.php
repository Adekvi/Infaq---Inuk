@foreach ($tanya as $item)
    <div class="modal fade" id="detail{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="kirimLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kirimLabel">Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="kirimForm">
                    <div class="container pb-5 overflow-hidden">
                        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s"
                            style="max-width: 800px;">
                            <h4 class="text-primary">{{ $item->tag ?? '-' }}</h4>
                            <h1 class="display-5 mb-4">{{ $item->judul ?? '-' }}</h1>
                            <p class="mb-0">{{ $item->ringkasan }}</p>
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
                                                {{ $item->pertanyaan1 ?? '-' }}
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne" class="accordion-collapse collapse"
                                            aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushSection">
                                            <div class="accordion-body">
                                                {{ $item->jawaban1 ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- FAQ 2 -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingTwo">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo"
                                                aria-expanded="false" aria-controls="flush-collapseTwo">
                                                {{ $item->pertanyaan2 ?? '-' }}
                                            </button>
                                        </h2>
                                        <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                            aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushSection">
                                            <div class="accordion-body">
                                                {{ $item->jawaban2 ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- FAQ 3 -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingThree">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#flush-collapseThree"
                                                aria-expanded="false" aria-controls="flush-collapseThree">
                                                {{ $item->pertanyaan3 ?? '-' }}
                                            </button>
                                        </h2>
                                        <div id="flush-collapseThree" class="accordion-collapse collapse"
                                            aria-labelledby="flush-headingThree"
                                            data-bs-parent="#accordionFlushSection">
                                            <div class="accordion-body">
                                                {{ $item->jawaban3 ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- FAQ 4 -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingFour">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#flush-collapseFour"
                                                aria-expanded="false" aria-controls="flush-collapseFour">
                                                {{ $item->pertanyaan4 ?? '-' }}
                                            </button>
                                        </h2>
                                        <div id="flush-collapseFour" class="accordion-collapse collapse"
                                            aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushSection">
                                            <div class="accordion-body">
                                                {{ $item->jawaban4 ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- FAQ 5 -->
                                    <div class="accordion-item rounded-bottom">
                                        <h2 class="accordion-header" id="flush-headingFive">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#flush-collapseFive"
                                                aria-expanded="false" aria-controls="flush-collapseFive">
                                                {{ $item->pertanyaan5 ?? '-' }}
                                            </button>
                                        </h2>
                                        <div id="flush-collapseFive" class="accordion-collapse collapse"
                                            aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushSection">
                                            <div class="accordion-body">
                                                {{ $item->jawaban5 ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Image Side -->
                            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
                                <div class="bg-primary rounded">
                                    @if ($item->foto == null)
                                        <div class="col-12">
                                            <div class="alert alert-info text-center">
                                                <img src="{{ asset('landing/img/carousel/carousel-2.jpg') }}"
                                                    class="img-fluid w-100 rounded" alt="Ilustrasi FAQ INUK">
                                            </div>
                                        </div>
                                    @else
                                        <img src="{{ Storage::url($item->foto ?? '-') }}" alt="Foto 1"
                                            class="img-fluid w-100 rounded">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ url('superadmin/master-data/tanya/edit-data/' . $item->id) }}"
                        class="btn btn-sm btn-warning">
                        <i class="bx bxs-pencil"></i> Edit
                    </a>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
