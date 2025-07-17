<!-- Modal Kirim -->
<div class="modal fade" id="kirimModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="kirimLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kirimLabel">Formulir Pengiriman Infaq</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>
                                <li><strong>Total Nominal Infaq</strong></li>
                            </label>
                            <ul id="selectedItems">Rp 0</ul>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="form-group">
                            <label for="tglSetor">Tanggal Kirim</label>
                            <input type="date" name="tglSetor" id="tglSetor" class="form-control mt-2 mb-2"
                                value="{{ old('tglSetor', now()->format('Y-m-d')) }}" required>
                            @error('tglSetor')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="form-group">
                            <label for="namaBank">Nama Bank</label>
                            <input type="text" class="form-control mt-2 mb-2" name="namaBank" id="namaBank"
                                value="{{ old('namaBank') }}" placeholder="Cth: BRI, BNI, BCA, Mandiri, Dana">
                            @error('namaBank')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="form-group">
                            <label for="Rekening">Rekening Bank</label>
                            <input type="text" class="form-control mt-2 mb-2" name="Rekening" id="Rekening"
                                value="{{ old('Rekening') }}" placeholder="Cth: BRI, BNI, BCA, Mandiri, Dana">
                            @error('Rekening')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="form-group">
                            <label for="">No. Hp Admin</label>
                            <input type="number" class="form-control mt-2 mb-2" value="{{ $noHp ?? '-' }}"
                                placeholder="No. Hp Admin">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="bukti_foto">Bukti Foto Transfer</label>
                            <input type="file" class="form-control mt-2 mb-2" name="bukti_foto" id="bukti_foto"
                                accept="image/jpeg,image/png,image/jpg">
                            @error('bukti_foto')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="customMessage">Pesan Kustom untuk Admin (Opsional)</label>
                            @php
                                // Default pesan template (bisa ditaruh di helper juga kalau mau dipakai di banyak tempat)
                                $defaultMessage =
                                    "\n" .
                                    "Assalamuallaikum Wr, Wb. Admin Kecamatan,\n\n" .
                                    "Setoran infaq dari *nama* telah dikirim. Berikut adalah detail setoran:\n" .
                                    "-\n" .
                                    '*Tanggal Setor:* ' .
                                    "\n" .
                                    '*Total Setoran:* Rp ' .
                                    "\n" .
                                    "🏦 *Nama Bank:*-\n" .
                                    "🏧 *No. Rekening:*-\n\n" .
                                    "Mohon verifikasi data setoran. Terima kasih 🙏\n";
                            @endphp

                            <textarea class="form-control mt-2 mb-2" name="customMessage" id="customMessage" rows="12"
                                placeholder="Masukkan pesan kustom atau biarkan default...">
                                                {{ old('customMessage', $defaultMessage) }}
                                            </textarea>
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
