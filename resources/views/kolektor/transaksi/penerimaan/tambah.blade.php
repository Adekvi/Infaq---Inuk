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
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="kecamatan" class="form-label">Kecamatan</label>
                                    <select name="kecamatan" id="kecamatan" class="form-select select2" required>
                                        <option value="">-- Pilih Kecamatan --</option>
                                        @foreach ($kecamatans as $idKec => $items)
                                            <option value="{{ $idKec }}">
                                                {{ $items->first()->kecamatan->nama_kecamatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="kelurahan" class="form-label">Kelurahan</label>
                                    <select name="kelurahan" id="kelurahan" class="form-select select2">
                                        <option value="">-- Pilih Kelurahan --</option>
                                    </select>
                                </div>
                            </div>

                            <hr>

                            <div id="formContainer"></div>

                            <h5 class="mt-3 mb-2">Sub Total</h5>
                            <hr>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><b>Rp.</b></span>
                                    <input type="number" name="jumlah" id="jumlah" class="form-control" readonly>
                                </div>
                                <small class="text-muted">Total: <span id="jumlahFormatted">Rp 0</span></small>
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
            $(document).ready(function() {
                let rowCount = 0;

                // Format Rupiah
                function formatRupiah(angka) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(angka);
                }

                // Hitung total nominal
                function updateSubTotal() {
                    let total = 0;
                    $('input[name="nominal[]"]').each(function() {
                        let val = parseFloat($(this).val()) || 0;
                        total += val;
                    });
                    $('#jumlah').val(total);
                    $('#jumlahFormatted').text(formatRupiah(total));
                }

                // Tambah baris RT/RW
                function addFormRow(rt = '', rw = '', nominal = '', isFirst = false) {
                    let buttonHTML = isFirst ?
                        `<button type="button" class="btn btn-primary w-100 mt-4" id="addRowBtn">
                                <i class="fas fa-plus"></i> Tambah
                        </button>` :
                        `<button type="button" class="btn btn-danger w-100 mt-4 removeRow">
                                <i class="fas fa-trash"></i> Hapus
                        </button>`;

                    let newRow = `
                        <div class="row align-items-end mb-2" data-row-id="${rowCount}">
                            <div class="col-md-2">
                                <label>RT</label>
                                <input type="text" name="Rt[]" class="form-control" value="${rt}" required>
                            </div>
                            <div class="col-md-2">
                                <label>RW</label>
                                <input type="text" name="Rw[]" class="form-control" value="${rw}" required>
                            </div>
                            <div class="col-md-3">
                                <label>Nominal</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><b>Rp.</b></span>
                                    <input type="number" name="nominal[]" class="form-control" value="${nominal}" min="0" oninput="updateSubTotal()" required>
                                </div>
                            </div>
                            <div class="col-md-2 d-flex">
                                ${buttonHTML}
                            </div>
                        </div>
                    `;

                    $('#formContainer').append(newRow);
                    rowCount++;
                    updateSubTotal();
                }

                // Generate form RT/RW dari array
                function generateForm(rtArr, rwArr) {
                    $('#formContainer').empty();
                    rowCount = 0;

                    if (rtArr.length > 0) {
                        addFormRow(rtArr[0] || '', rwArr[0] || '', '', true);
                        for (let i = 1; i < rtArr.length; i++) {
                            addFormRow(rtArr[i] || '', rwArr[i] || '', '', false);
                        }
                    } else {
                        addFormRow('', '', '', true);
                    }
                }

                // Hapus baris RT/RW
                $(document).on('click', '.removeRow', function() {
                    $(this).closest('.row').remove();
                    updateSubTotal();
                });

                // Tambah baris RT/RW
                $(document).on('click', '#addRowBtn', function() {
                    addFormRow('', '', '', false);
                });

                // Load kelurahan via AJAX
                $('#kecamatan').on('change', function() {
                    let idKecamatan = $(this).val();
                    $('#kelurahan').empty().append('<option value="">-- Pilih Kelurahan --</option>');
                    $('#formContainer').empty();

                    if (idKecamatan) {
                        $.ajax({
                            url: "{{ route('ajax.getKelurahan') }}",
                            type: "POST",
                            data: {
                                id_kecamatan: idKecamatan,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                $('#kelurahan').empty();

                                if (res.length > 1) {
                                    // Jika ada lebih dari 1 kelurahan → tampilkan pilihan
                                    $('#kelurahan').append(
                                        '<option value="">-- Pilih Kelurahan --</option>');
                                    res.forEach(function(kel) {
                                        $('#kelurahan').append(
                                            `<option value="${kel.id}" 
                                    data-rt='${JSON.stringify(kel.rt)}' 
                                    data-rw='${JSON.stringify(kel.rw)}'>
                                    ${kel.nama_kelurahan}
                                </option>`
                                        );
                                    });
                                } else if (res.length === 1) {
                                    // Jika hanya 1 kelurahan → langsung pilih dan generate form
                                    let kel = res[0];
                                    $('#kelurahan').append(
                                        `<option value="${kel.id}" 
                                data-rt='${JSON.stringify(kel.rt)}' 
                                data-rw='${JSON.stringify(kel.rw)}' 
                                selected>
                                ${kel.nama_kelurahan}
                            </option>`
                                    );
                                    generateForm(kel.rt, kel.rw); // langsung generate form
                                }
                            }
                        });
                    }
                });

                // Saat kelurahan dipilih → generate form RT/RW
                $('#kelurahan').on('change', function() {
                    let selected = $(this).find(':selected');
                    let rt = JSON.parse(selected.attr('data-rt') || '[]');
                    let rw = JSON.parse(selected.attr('data-rw') || '[]');
                    generateForm(rt, rw);
                });

                // Hitung total nominal realtime
                $(document).on('input', 'input[name="nominal[]"]', function() {
                    updateSubTotal();
                });

                // Jalankan awal
                updateSubTotal();
            });
        </script>
    @endpush
</x-utama.layout.main>
