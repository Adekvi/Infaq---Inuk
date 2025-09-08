@foreach ($tentang as $item)
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
                            <label for="">Judul</label>
                            <input type="text" name="judul" id="judul" class="form-control mt-2 mb-2"
                                value="{{ $item->judul ?? '-' }}">
                        </div>
                        <div class="col-md-12">
                            <label for="">Sub Judul</label>
                            <input type="text" name="subjudul" id="subjudul" class="form-control mt-2 mb-2"
                                value="{{ $item->subjudul ?? '-' }}">
                        </div>
                        <div class="col-md-12">
                            <label for="">Ringkasan</label>
                            <textarea name="ringkasan" id="ringkasan" class="form-control mt-2 mb-2" cols="5" rows="5">{{ $item->ringkasan }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="">Motto 1</label>
                            <input type="text" value="{{ $item->motto1 ?? '-' }}" class="form-control mt-2 mb-2">
                        </div>
                        <div class="col-md-6">
                            <label for="">Motto 2</label>
                            <input type="text" value="{{ $item->motto2 ?? '-' }}" class="form-control mt-2 mb-2">
                        </div>
                        <div class="col-md-6">
                            <label for="">Icon 1</label>
                            @if ($item->icon1 == null)
                                <div class="col-12">
                                    <div class="alert alert-info text-center">
                                        <i class="fa-solid fa-image"></i> Belum ada icon
                                    </div>
                                </div>
                            @else
                                <img src="{{ Storage::url($item->icon1 ?? '-') }}" alt="Icon 1" width="50px"
                                    height="auto">
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="">Icon 2</label>
                            @if ($item->icon2 == null)
                                <div class="col-12">
                                    <div class="alert alert-info text-center">
                                        <i class="fa-solid fa-image"></i> Belum ada icon
                                    </div>
                                </div>
                            @else
                                <img src="{{ Storage::url($item->icon2 ?? '-') }}" alt="Icon 1" width="50px"
                                    height="auto">
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="">Ringkasan 1</label>
                            <textarea name="ringkasan1" id="ringkasan1" class="form-control mt-2 mb-2" cols="10" rows="5">{{ $item->ringkasan1 }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="">Ringkasan 2</label>
                            <textarea name="ringkasan2" id="ringkasan2" class="form-control mt-2 mb-2" cols="10" rows="5">{{ $item->ringkasan2 }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="">Foto</label>
                            @if ($item->foto == null)
                                <div class="col-12">
                                    <div class="alert alert-info text-center">
                                        <i class="fa-solid fa-image"></i> Belum ada foto
                                    </div>
                                </div>
                            @else
                                <div class="bg-primary rounded position-relative overflow-hidden">
                                    <img src="{{ Storage::url($item->foto ?? '-') }}" class="img-fluid rounded w-100"
                                        alt="LAZISNU - Infaq INUK">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ url('superadmin/master-data/tentang-kami/edit-data/' . $item->id) }}"
                        class="btn btn-sm btn-warning">
                        <i class="bx bxs-pencil"></i> Edit
                    </a>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
