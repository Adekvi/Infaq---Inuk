<x-utama.layout.main title="Kolektor | Tambah Data">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card-title">
                    <h5><strong>Kolektor | Tambah Data</strong></h5>
                    <div class="mb-3" style="display: flex; justify-content: start">
                        <code>Tambah Data</code>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('kolektor/penerimaan/input-infaq/tambah') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="kecamatan" class="form-label">Kecamatan</label>
                                        <input type="text"
                                            value="{{ $terima->kecamatan->nama_kecamatan ?? 'Tidak tersedia' }}"
                                            class="form-control mt-2 mb-2" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="kelurahan" class="form-label">Kelurahan</label>
                                        <input type="text"
                                            value="{{ $terima->kelurahan->first()->nama_kelurahan ?? 'Tidak tersedia' }}"
                                            class="form-control mt-2 mb-2" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h5 class="mt-3 mb-3">
                                    <li>Nominal Infaq</li>
                                </h5>
                                <hr>
                                <div id="formContainer">
                                    <div class="row align-items-end mb-3" data-row-id="0">
                                        <div class="col-md-2">
                                            <label for="Rt_0" class="form-label">RT</label>
                                            <input type="text" name="Rt[]" id="Rt_0" class="form-control"
                                                placeholder="RT" value="{{ json_decode($terima->Rt)[0] ?? '-' }}"
                                                required>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="Rw_0" class="form-label">RW</label>
                                            <input type="text" name="Rw[]" id="Rw_0" class="form-control"
                                                placeholder="RW" value="{{ json_decode($terima->Rw)[0] ?? '-' }}"
                                                required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="nominal_0" class="form-label">Nominal</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light"><b>Rp.</b></span>
                                                <input type="number" name="nominal[]" id="nominal_0"
                                                    class="form-control minggu-input" placeholder="0" min="0"
                                                    oninput="updateSubTotal()">
                                            </div>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-primary w-100" onclick="addFormRow()">
                                                <i class="fas fa-plus me-1"></i> Tambah
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mt-3 mb-3">
                                    <li>Sub Total</li>
                                </h5>
                                <hr>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="jumlah" class="form-label">Jumlah</label>
                                        <div class="input-group mb-2 mt-2">
                                            <span class="input-group-text" style="background: rgb(228, 228, 228);">
                                                <b>Rp.</b>
                                            </span>
                                            <input type="number" name="jumlah" id="jumlah" class="form-control"
                                                placeholder="0" readonly>
                                        </div>
                                        @error('jumlah')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" data-bs-toggle="tooltip" title="Simpan"
                                    class="btn btn-primary me-2">
                                    <i class="fa-solid fa-floppy-disk"></i> Simpan
                                </button>
                                <a href="{{ url('kolektor/penerimaan/input-infaq') }}" data-bs-toggle="tooltip"
                                    title="Kembali" class="btn btn-secondary">
                                    <i class="fa-solid fa-arrows-rotate"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

    @push('js')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            let rowCount = 1;

            // Format angka ke format mata uang Indonesia (Rp. 1.000.000)
            function formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(angka);
            }

            function addFormRow() {
                const formContainer = document.getElementById('formContainer');
                const newRow = document.createElement('div');
                newRow.className = 'row mb-3';
                newRow.setAttribute('data-row-id', rowCount);
                newRow.innerHTML = `
                    <div class="col-md-2">
                        <label for="Rt_${rowCount}" class="form-label">RT</label>
                        <input type="text" name="Rt[]" id="Rt_${rowCount}" class="form-control" placeholder="RT" required>
                    </div>
                    <div class="col-md-2">
                        <label for="Rw_${rowCount}" class="form-label">RW</label>
                        <input type="text" name="Rw[]" id="Rw_${rowCount}" class="form-control" placeholder="RW" required>
                    </div>
                    <div class="col-md-3">
                        <label for="nominal_${rowCount}" class="form-label">Nominal</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><b>Rp.</b></span>
                            <input type="number" name="nominal[]" id="nominal_${rowCount}" class="form-control minggu-input" placeholder="0" min="0" oninput="updateSubTotal()">
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger w-100" onclick="removeFormRow(${rowCount})">
                            <i class="fas fa-trash me-1"></i> Hapus
                        </button>
                    </div>
                `;
                formContainer.appendChild(newRow);
                rowCount++;
                updateSubTotal();
            }

            function removeFormRow(rowId) {
                const row = document.querySelector(`[data-row-id="${rowId}"]`);
                if (row) {
                    row.remove();
                    updateSubTotal();
                }
            }

            function updateSubTotal() {
                const nominalInputs = document.querySelectorAll('input[name="nominal[]"]');
                let total = 0;
                nominalInputs.forEach(input => {
                    const value = parseFloat(input.value) || 0;
                    if (value >= 0) { // Pastikan nilai tidak negatif
                        total += value;
                    }
                });
                document.getElementById('jumlah').value = total;
                document.getElementById('jumlahFormatted').textContent = formatRupiah(total);
            }

            // Inisialisasi total saat halaman dimuat
            document.addEventListener('DOMContentLoaded', function() {
                updateSubTotal();
            });
        </script>
    @endpush
</x-utama.layout.main>
