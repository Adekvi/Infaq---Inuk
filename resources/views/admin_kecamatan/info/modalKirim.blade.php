<!-- Modal Kirim WhatsApp ke Pengguna Terpilih -->
<div class="modal fade" id="sendWhatsAppModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="sendWhatsAppLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('adminkecamatan.send-whatsapp') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="sendWhatsAppLabel">Kirim Dokumen ke Pengguna Terpilih</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="text-dark text-start">
                        <li>Formulir Pengiriman</li>
                    </h5>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="selectedUsers" class="form-label">Pengguna Terpilih</label>
                                <ul id="selectedUsers" class="list-group">
                                    <!-- Daftar pengguna terpilih akan diisi oleh JavaScript -->
                                </ul>
                                <input type="hidden" name="user_ids[]" id="userIdsInput">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="filename" class="form-label">Pilih Dokumen PDF</label>
                                <select name="filename" id="filename" class="form-select" required>
                                    <option value="">-- Pilih Dokumen --</option>
                                    @foreach ($laporan as $file)
                                        <option value="{{ $file['filename'] }}">{{ $file['filename'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="message" class="form-label">Pesan Kustom</label>
                                <textarea name="message" id="message" class="form-control" rows="5" required
                                    placeholder="Masukkan pesan kustom untuk dikirim melalui WhatsApp"></textarea>
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
            </form>
        </div>
    </div>
</div>
