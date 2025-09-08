<x-utama.layout.main title="Kolektor | Edit Data">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card-title">
                    <h5><strong>Kolektor | Edit Data</strong></h5>
                    <div class="mb-3" style="display: flex; justify-content: start">
                        <code>Edit Data</code>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('kolektor/penerimaan/input-infaq/edit/' . $penerimaan->id) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="kecamatan" class="form-label">Kecamatan</label>
                                        <input type="text"
                                            value="{{ $penerimaan->plotting->kecamatan->nama_kecamatan ?? '-' }}"
                                            class="form-control mt-2 mb-2" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="kelurahan" class="form-label">Kelurahan</label>
                                        <input type="text"
                                            value="{{ $penerimaan->plotting->kelurahan->first()->nama_kelurahan ?? '-' }}"
                                            class="form-control mt-2 mb-2" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">No. Alat</label>
                                    <select name="no_alat" id="no_alat" class="form-control mt-2 mb-2 select2">
                                        @if ($penerimaan->dataterima)
                                            <option value="{{ $penerimaan->dataterima->no_alat }}" selected>
                                                {{ $penerimaan->dataterima->no_alat }}</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Nama Donatur</label>
                                    <select name="nama_donatur" id="nama_donatur"
                                        class="form-control mt-2 mb-2 select2">
                                        @if ($penerimaan->dataterima)
                                            <option value="{{ $penerimaan->dataterima->nama_donatur }}" selected>
                                                {{ $penerimaan->dataterima->nama_donatur }}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <h5 class="mt-3 mb-3">
                                    <li>Nominal Infaq</li>
                                </h5>
                                <hr>
                                <div id="formContainer">
                                    @foreach ($penerimaans as $index => $item)
                                        <div class="row align-items-end mb-3" data-row-id="{{ $index }}">
                                            <div class="col-md-2">
                                                <label for="Rt_{{ $index }}" class="form-label">RT</label>
                                                <input type="text" name="Rt[]" id="Rt_{{ $index }}"
                                                    class="form-control" placeholder="RT" value="{{ $item->Rt }}"
                                                    required>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="Rw_{{ $index }}" class="form-label">RW</label>
                                                <input type="text" name="Rw[]" id="Rw_{{ $index }}"
                                                    class="form-control" placeholder="RW" value="{{ $item->Rw }}"
                                                    required>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="nominal_{{ $index }}"
                                                    class="form-label">Nominal</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light"><b>Rp.</b></span>
                                                    <input type="number" name="nominal[]"
                                                        id="nominal_{{ $index }}" class="form-control"
                                                        placeholder="0" min="0" value="{{ $item->nominal }}"
                                                        oninput="updateSubTotal()">
                                                </div>
                                            </div>
                                            <div class="col-md-2 d-flex align-items-end mt-2">
                                                @if ($index == 0)
                                                    <button type="button" class="btn btn-primary w-100"
                                                        onclick="addFormRow()">
                                                        <i class="fas fa-plus me-1"></i> Tambah
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-danger w-100"
                                                        onclick="removeFormRow({{ $index }})">
                                                        <i class="fas fa-trash me-1"></i> Hapus
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
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
                                                placeholder="0" value="{{ $penerimaan->jumlah }}" readonly>
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

        <style>
            /* Supaya tinggi Select2 sama seperti form-control Bootstrap */
            .select2-container .select2-selection--single {
                height: 38px !important;
                padding: 4px 12px;
                border: 1px solid #ced4da;
                border-radius: 6px;
            }

            /* Hilangkan border biru besar default */
            .select2-container--default .select2-selection--single:focus,
            .select2-container--default .select2-selection--multiple:focus {
                outline: none;
                border-color: #86b7fe;
                box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, .25);
            }

            /* Supaya placeholder kelihatan abu-abu */
            .select2-selection__placeholder {
                color: #6c757d !important;
            }

            /* Supaya teks Select2 tidak terlalu mepet */
            .select2-selection__rendered {
                line-height: 28px !important;
            }

            /* Dropdown lebih modern */
            .select2-dropdown {
                border-radius: 6px;
                border: 1px solid #dee2e6;
                padding: 5px;
            }

            /* Hover item */
            .select2-results__option--highlighted {
                background-color: #0d6efd !important;
                color: white !important;
            }

            /* Supaya lebar selalu 100% */
            .select2-container {
                width: 100% !important;
            }
        </style>
    @endpush

    @push('js')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            let rowCount = {{ count($penerimaans) }};

            // Format angka ke format mata uang Indonesia
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
                    if (value >= 0) {
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

            $(document).ready(function() {
                $('#no_alat').select2({
                    placeholder: 'Cari No. Alat',
                    ajax: {
                        url: '{{ route('search.noalat') }}',
                        dataType: 'json',
                        delay: 250,
                        data: params => ({
                            q: params.term
                        }),
                        processResults: data => ({
                            results: data
                        })
                    }
                }).on('select2:select', function(e) {
                    let data = e.params.data;
                    $('#nama_donatur').html(
                        `<option value="${data.nama_donatur}" selected>${data.nama_donatur}</option>`
                    ).trigger('change');

                    // Optional: reload RT/RW sesuai id_terima yang dipilih
                    // bisa pakai AJAX untuk fetch data RT/RW baru
                });

                $('#nama_donatur').select2({
                    placeholder: 'Cari Nama Donatur',
                    ajax: {
                        url: '{{ route('search.namadonatur') }}',
                        dataType: 'json',
                        delay: 250,
                        data: params => ({
                            q: params.term
                        }),
                        processResults: data => ({
                            results: data
                        })
                    }
                }).on('select2:select', function(e) {
                    let data = e.params.data;
                    $('#no_alat').html(
                        `<option value="${data.no_alat}" selected>${data.no_alat}</option>`
                    ).trigger('change');

                    // Optional: reload RT/RW sesuai id_terima yang dipilih
                });
            });
        </script>
    @endpush
</x-utama.layout.main>
