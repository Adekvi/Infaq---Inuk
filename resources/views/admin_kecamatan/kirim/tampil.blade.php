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
                        <!-- Menampilkan alert -->
                        @if (session('alert'))
                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            <script>
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Peringatan',
                                    text: "{{ session('alert') }}",
                                });
                            </script>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
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
                                        <label for="no_hp" class="form-label">No. Hp Admin
                                            Kabupaten</label>
                                        <input type="text" class="form-control mb-2 mt-2" name="no_hp"
                                            id="no_hp" value="{{ $adminKabupaten->no_hp ?? '-' }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="namaPenerima" class="form-label">Nama Admin
                                            Kabupaten</label>
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
                                    <div class="col-md-8 mb-3">
                                        <div class="form-group">
                                            <label for="pesan" class="form-label">Pesan Kustom untuk Admin
                                                (Opsional)</label>
                                            @php
                                                $defaultMessage =
                                                    "Assalamuallaikum Wr, Wb. Admin Kabupaten,\n" .
                                                    "Mohon Maaf mengganggu waktunya,\n" .
                                                    "Sebagai laporan, saya *{$adminKecamatan->username}* dari ranting/kecamatan *{$kecamatan->nama_kecamatan}* melampirkan sebanyak dokumen data dengan rincian sebagai berikut,\n" .
                                                    " -\n" .
                                                    " -\n" .
                                                    " -\n" .
                                                    "Mohon untuk dapat dicek dan ditindaklanjuti.\nTerima kasih. 🙏\n\n" .
                                                    'Wassalamu’alaikum Wr. Wb.';
                                            @endphp
                                            <textarea class="form-control mt-2 mb-2" name="pesan" id="pesan" rows="12"
                                                placeholder="Masukkan pesan kustom atau biarkan default...">{{ old('pesan', $defaultMessage) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
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
        </script>
    @endpush

</x-utama.layout.main>
