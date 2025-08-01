<!-- Modal Kirim -->
<div class="modal fade" id="kirimModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="kirimLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kirimLabel">Formulir Pengiriman Infaq</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="kirimForm">
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
                                value="{{ old('Rekening') }}" placeholder="Cth: 1234567890">
                            @error('Rekening')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="form-group">
                            <label for="no_hp_admin">No. HP Admin</label>
                            <input type="text" class="form-control mt-2 mb-2" name="no_hp_admin" id="no_hp_admin"
                                value="{{ $noHp ?? '-' }}" placeholder="Masukkan No. HP Admin (contoh: 081234567890)"
                                required>
                            @error('no_hp_admin')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
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
                            <div class="pesan mt-2">
                                <button type="button" id="toggleMessageBtn" class="btn btn-outline-info btn-sm mb-2">
                                    <i class="fa-solid fa-message"></i> Pesan Otomatis
                                </button>
                            </div>
                            <textarea class="form-control" name="customMessage" id="customMessage" rows="12"
                                placeholder="Masukkan pesan kustom jika diperlukan..."></textarea>
                            @error('customMessage')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="submitButton" class="btn btn-primary">
                    <i class="fa-solid fa-paper-plane"></i> Kirim
                </button>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div id="loadingIndicator" style="display:none" class="text-center mt-3">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Mengirim...</span>
    </div>
    <p class="mt-2">Pesan sedang dikirim, mohon tunggu...</p>
</div>

@push('js')
    <script>
        const toggleBtn = document.getElementById('toggleMessageBtn');
        const messageBox = document.getElementById('customMessage');
        const namaBankInput = document.getElementById('namaBank');
        const rekeningInput = document.getElementById('Rekening');
        const tglSetorInput = document.getElementById('tglSetor');
        const checkAll = document.getElementById('checkAll');
        const checkItems = document.querySelectorAll('.checkItem');
        const selectedItems = document.getElementById('selectedItems');
        let isUsingTemplate = false;

        // Fungsi untuk menghitung jumlah checkbox yang dipilih dan total nominal
        function updateSelectedData() {
            const checkedItems = document.querySelectorAll('.checkItem:checked');
            const countData = checkedItems.length;
            let totalNominal = 0;

            checkedItems.forEach(item => {
                totalNominal += parseFloat(item.getAttribute('data-nominal')) || 0;
            });

            // Update elemen selectedItems dengan format Rupiah
            selectedItems.textContent = `Rp ${totalNominal.toLocaleString('id-ID')}`;
            return {
                countData,
                totalNominal
            };
        }

        function updateTemplate() {
            if (isUsingTemplate) {
                const username = @json(isset($user) ? $user->username : 'Unknown User');
                const kelurahan = @json($namaKelurahan ?? '-');
                const Rt = @json($rts ?? '-');
                const Rw = @json($rws ?? '-');
                const {
                    countData,
                    totalNominal
                } = updateSelectedData();

                const rawTanggal = tglSetorInput.value;
                const tanggal = rawTanggal ? formatTanggalIndo(rawTanggal) : '{{ now()->format('d-m-Y') }}';

                const bank = namaBankInput.value.trim() ? namaBankInput.value.trim() : '[Belum diisi]';
                const rekening = rekeningInput.value.trim() ? rekeningInput.value.trim() : '[Belum diisi]';

                const template =
                    `Assalamuallaikum Wr, Wb. Admin Kecamatan,\n\n` +
                    `Setoran infaq dari *${username}* telah dikirim. Berikut adalah detail setoran:\n` +
                    `📍 *Kelurahan:* ${kelurahan}\n` +
                    `📍 *RT:* ${Rt}\n` +
                    `📍 *RW:* ${Rw}\n` +
                    `📄 *Jumlah Data:* ${countData}\n` +
                    `🗓️ *Tanggal Setor:* ${tanggal}\n` +
                    `💰 *Total Setoran:* Rp ${Number(totalNominal).toLocaleString('id-ID')}\n` +
                    `🏦 *Nama Bank:* ${bank}\n` +
                    `🏧 *No. Rekening:* ${rekening}\n\n` +
                    `Mohon verifikasi data setoran. Terima kasih 🙏\n`;

                messageBox.value = template;
            }
        }

        // Fungsi format tanggal ke d-m-Y
        function formatTanggalIndo(tanggal) {
            const [year, month, day] = tanggal.split('-');
            return `${day}-${month}-${year}`;
        }

        // Event listener untuk tombol Pesan Otomatis
        toggleBtn.addEventListener('click', function() {
            isUsingTemplate = !isUsingTemplate;

            if (isUsingTemplate) {
                updateTemplate();
                toggleBtn.innerHTML = '<i class="fa-solid fa-message"></i> Hapus Pesan';
            } else {
                messageBox.value = '';
                toggleBtn.innerHTML = '<i class="fa-solid fa-message"></i> Pesan Otomatis';
            }
        });

        // Event listener untuk checkbox individu
        checkItems.forEach(item => {
            item.addEventListener('change', function() {
                updateSelectedData();
                updateTemplate();
            });
        });

        // Event listener untuk tombol Pilih Semua
        checkAll.addEventListener('change', function() {
            checkItems.forEach(item => {
                item.checked = checkAll.checked;
            });
            updateSelectedData();
            updateTemplate();
        });

        // Event listener untuk input namaBank, Rekening, dan tglSetor
        namaBankInput.addEventListener('input', updateTemplate);
        rekeningInput.addEventListener('input', updateTemplate);
        tglSetorInput.addEventListener('input', updateTemplate);

        // Event listener untuk submit form
        document.getElementById('kirimForm').addEventListener('submit', function() {
            document.getElementById('loadingIndicator').style.display = 'block';
            document.getElementById('submitButton').disabled = true;
            document.getElementById('submitButton').innerHTML =
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengirim...';
        });

        // Inisialisasi total nominal saat modal dibuka
        document.getElementById('kirimModal').addEventListener('shown.bs.modal', function() {
            updateSelectedData();
            updateTemplate();
        });
    </script>
@endpush
