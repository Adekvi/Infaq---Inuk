<x-utama.layout.main title="Admin Kecamatan | Laporan Pengiriman">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="pasien-bpjs">
                    <div class="card-title">
                        <h5><strong>Laporan Pengiriman</strong></h5>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header">
                            <h5>
                                <li><strong>Formulir Pengiriman</strong></li>
                            </h5>
                            <hr>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ url('/admin-kecamatan/send-whatsapp') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="tglKirim" class="form-label">Tanggal Kirim</label>
                                        <input type="date" class="form-control mb-2 mt-2" name="tglKirim"
                                            id="tglKirim" value="{{ old('tglKirim', now()->format('Y-m-d')) }}"
                                            required>
                                        @error('tglKirim')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="namaPengirim" class="form-label">Nama Pengirim</label>
                                        <input type="text" class="form-control mb-2 mt-2" name="namaPengirim"
                                            id="namaPengirim" value="{{ $adminKecamatan->username ?? '-' }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nama_kecamatan" class="form-label">Wilayah/Ranting</label>
                                        <input type="text" name="nama_kecamatan" id="nama_kecamatan"
                                            class="form-control mb-2 mt-2"
                                            value="{{ $kecamatan->nama_kecamatan ?? '-' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="no_hp" class="form-label">No. Hp Admin Kabupaten</label>
                                        <input type="text" class="form-control mb-2 mt-2" name="no_hp"
                                            id="no_hp" value="{{ $adminKabupaten->no_hp ?? '-' }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="namaPenerima" class="form-label">Nama Admin Kabupaten</label>
                                        <input type="text" name="namaPenerima" id="namaPenerima"
                                            class="form-control mb-2 mt-2"
                                            value="{{ $adminKabupaten->username ?? '-' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="file_kirim" class="form-label">Pilih Dokumen</label>
                                            <input type="file" name="file_kirim" id="file_kirim"
                                                class="form-control mb-2 mt-2">
                                            <p class="text-warning" style="font-style: italic">*Hanya file PDF, XLSX,
                                                atau XLS (maks 10MB).</p>
                                            @error('file_kirim')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- Input tersembunyi untuk total donasi -->
                                    <input type="hidden" id="total_donasi" value="{{ $totalDonasi ?? 0 }}">
                                    <div class="col-md-8 mb-3">
                                        <div class="form-group">
                                            <label for="pesan" class="form-label">Pesan Kustom untuk Admin
                                                (Opsional)</label>
                                            <div class="pesan">
                                                <button type="button" class="btn btn-sm btn-outline-info mb-2"
                                                    id="toggleMessageBtn">
                                                    <i class="fa-solid fa-message"></i> Format Pesan Otomatis
                                                </button>
                                            </div>
                                            <textarea class="form-control mt-2 mb-2" name="pesan" id="pesan" rows="12"
                                                placeholder="Masukkan pesan kustom atau biarkan default...">{{ old('pesan', '') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="fa-solid fa-paper-plane"></i> Kirim
                                </button>
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            document.getElementById('file_kirim').addEventListener('change', function(e) {
                const file = e.target.files[0];
                const allowedExtensions = ['pdf', 'xlsx', 'xls'];
                const extension = file.name.split('.').pop().toLowerCase();
                if (!allowedExtensions.includes(extension)) {
                    alert('File harus berupa PDF, XLSX, atau XLS.');
                    e.target.value = ''; // Reset input
                }
                if (file.size > 10 * 1024 * 1024) {
                    alert('Ukuran file maksimum adalah 10MB.');
                    e.target.value = ''; // Reset input
                }
            });

            document.addEventListener('DOMContentLoaded', function() {
                const toggleBtn = document.getElementById('toggleMessageBtn');
                const pesanField = document.getElementById('pesan');
                const fileInput = document.getElementById('file_kirim');
                let isCustomMessageInserted = false;

                // Fungsi untuk menghasilkan pesan otomatis
                function generateMessage() {
                    const namaPengirim = document.getElementById('namaPengirim').value || '-';
                    const namaKecamatan = document.getElementById('nama_kecamatan').value || '-';
                    const tanggal = document.getElementById('tglKirim').value || '-';
                    const filename = fileInput.files.length > 0 ? fileInput.files[0].name :
                        '[Nama File Tidak Terdeteksi]';
                    const totalDonasi = document.getElementById('total_donasi').value || '0';

                    return `Assalamuallaikum Wr. Wb.\nSaya *${namaPengirim}* dari kecamatan *${namaKecamatan}* melampirkan dokumen:\n📅 Tanggal: ${tanggal}\n📎 File: ${filename}\n💰 Total Donasi: Rp ${parseInt(totalDonasi).toLocaleString('id-ID')}\nMohon dicek dan ditindaklanjuti.\nTerima kasih.`;
                }

                // Event listener untuk tombol toggle
                toggleBtn.addEventListener('click', function() {
                    if (!isCustomMessageInserted) {
                        pesanField.value = generateMessage();
                        isCustomMessageInserted = true;
                        toggleBtn.innerHTML = '<i class="fas fa-trash-alt me-1"></i> Hapus Format Pesan';
                        toggleBtn.classList.remove('btn-outline-info');
                        toggleBtn.classList.add('btn-outline-danger');
                    } else {
                        pesanField.value = '';
                        isCustomMessageInserted = false;
                        toggleBtn.innerHTML = '<i class="fa-solid fa-message me-1"></i> Format Pesan Otomatis';
                        toggleBtn.classList.remove('btn-outline-danger');
                        toggleBtn.classList.add('btn-outline-info');
                    }
                });

                // Update pesan otomatis saat file berubah
                fileInput.addEventListener('change', function() {
                    if (isCustomMessageInserted) {
                        pesanField.value = generateMessage();
                    }
                });
            });

            document.querySelector('form').addEventListener('submit', function(e) {
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.disabled = true;
                submitBtn.innerHTML =
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengirim...';
            });
        </script>
    @endpush

</x-utama.layout.main>
