<!-- Modal Kirim -->
<div class="modal fade" id="kirimModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="kirimLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kirimLabel">Konfirmasi Pengiriman Infaq</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 class="text-dark">
                    <li>Formulir Pengiriman</li>
                </h5>
                <hr>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <div class="form-group">
                            <label for="tgl_kirim">Tanggal Kirim</label>
                            <input type="date" name="tgl_kirim" id="tgl_kirim" class="form-control mt-2 mb-2"
                                value="{{ old('tgl_kirim', now()->format('Y-m-d')) }}" required readonly>
                            @error('tgl_kirim')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="form-group">
                            <label for="no_hp">No. HP</label>
                            <input type="text" class="form-control mt-2 mb-2" name="no_hp" id="no_hp"
                                value="{{ old('no_hp') }}" placeholder="Masukkan No. HP (contoh: 081234567890)">
                            @error('no_hp')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="form-group">
                            <label for="bukti_foto">Bukti Transfer</label>
                            <input type="file" class="form-control mt-2 mb-2" name="bukti_foto" id="bukti_foto"
                                accept="image/jpeg,image/png,image/jpg">
                            @error('bukti_foto')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>
                                <li><strong>Detail Setoran Terpilih</strong></li>
                            </label>
                            <ul id="selectedItems"></ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-paper-plane"></i> Kirim
                </button>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
