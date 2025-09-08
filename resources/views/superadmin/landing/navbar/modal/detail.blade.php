@foreach ($halaman1 as $item)
    <div class="modal fade" id="detail{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="kirimLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kirimLabel">Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="kirimForm">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Judul 1</label>
                            <input type="text" name="judul1" id="judul1" class="form-control mt-2 mb-2"
                                value="{{ $item->judul1 ?? '-' }}">
                        </div>
                        <div class="col-md-6">
                            <label for="">Judul 2</label>
                            <input type="text" name="judul2" id="judul2" class="form-control mt-2 mb-2"
                                value="{{ $item->judul2 ?? '-' }}">
                        </div>
                        <div class="col-md-6">
                            <label for="">Kalimat 1</label>
                            <textarea name="kalimat1" id="kalimat1" class="form-control mt-2 mb-2" cols="10" rows="5">{{ $item->kalimat1 }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="">Kalimat 2</label>
                            <textarea name="kalimat2" id="kalimat2" class="form-control mt-2 mb-2" cols="10" rows="5">{{ $item->kalimat2 }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="">Ringkasan 1</label>
                            <textarea name="ringkas1" id="ringkas1" class="form-control mt-2 mb-2" cols="10" rows="5">{{ $item->ringkas1 }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="">Ringkasan 2</label>
                            <textarea name="ringkas2" id="ringkas2" class="form-control mt-2 mb-2" cols="10" rows="5">{{ $item->ringkas2 }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="">Foto 1</label>
                            @if ($item->foto1 == null)
                                <div class="col-12">
                                    <div class="alert alert-info text-center">
                                        <i class="fa-solid fa-image"></i> Belum ada foto
                                    </div>
                                </div>
                            @else
                                <img src="{{ Storage::url($item->foto1 ?? '-') }}" alt="Foto 1">
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="">Foto 2</label>
                            @if ($item->foto2 == null)
                                <div class="col-12">
                                    <div class="alert alert-info text-center">
                                        <i class="fa-solid fa-image"></i> Belum ada foto
                                    </div>
                                </div>
                            @else
                                <img src="{{ Storage::url($item->foto2 ?? '-') }}" alt="Foto 1">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ url('superadmin/master-data/halaman-navbar/edit-data/' . $item->id) }}"
                        class="btn btn-sm btn-warning">
                        <i class="bx bxs-pencil"></i> Edit
                    </a>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
