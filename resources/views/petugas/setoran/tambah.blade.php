<x-utama.layout.main title="Petugas | Input Infaq">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card-title">
                    <h5 style="margin-bottom: 20px"><strong>Petugas | Input Infaq</strong></h5>
                    <div class="mb-1" style="display: flex; justify-content: start">
                        <code>Tambah Data</code>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('petugas/setoran/input-infaq/tambah') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                        <label for="id_kecamatan">Kecamatan</label>
                                        <select name="id_kecamatan" id="id_kecamatan" class="form-control select2"
                                            required>
                                            <option value="">-- Pilih Kecamatan --</option>
                                            @foreach ($kecamatans as $kecamatan)
                                                <option value="{{ $kecamatan->id }}">{{ $kecamatan->nama_kecamatan }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_kecamatan')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="form-group">
                                        <label for="id_kelurahan">Kelurahan</label>
                                        <select name="id_kelurahan" id="id_kelurahan" class="form-control select2"
                                            required>
                                            <option value="">-- Pilih Kelurahan --</option>
                                            <!-- Kelurahan akan diisi melalui AJAX -->
                                        </select>
                                        @error('id_kelurahan')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jenis_infaq">Jenis Infaq</label>
                                        <select name="jenis_infaq" id="jenis_infaq" class="form-control mt-2 mb-2">
                                            <option value="">-- Pilih Jenis Infaq --</option>
                                            <option value="Infaq Individu">Infaq Individu</option>
                                            <option value="Infaq Lembaga">Infaq Lembaga</option>
                                            <option value="Kotak Infaq">Kotak Infaq</option>
                                        </select>
                                        @error('jenis_infaq')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <input type="hidden" name="tgl_infaq">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bulan">Bulan</label>
                                        <select name="bulan" id="bulan" class="form-control mt-2 mb-2">
                                            <option value="">-- Pilih Bulan --</option>
                                            @foreach ($months as $key => $monthName)
                                                <option value="{{ $key }}"
                                                    {{ old('bulan') == $key ? 'selected' : '' }}>
                                                    {{ $monthName }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('bulan')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <h5 class="mt-3">
                                    <li>Nominal Infaq</li>
                                </h5>
                                <hr>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="minggu1">Minggu I</label>
                                        <div class="input-group mb-2 mt-2">
                                            <span class="input-group-text" style="background: rgb(228, 228, 228);">
                                                <b>Rp.</b>
                                            </span>
                                            <input type="number" value="{{ old('minggu1') }}" name="minggu1"
                                                id="minggu1" class="form-control minggu-input" placeholder="0"
                                                min="0">
                                            @error('minggu1')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="minggu2">Minggu II</label>
                                        <div class="input-group mb-2 mt-2">
                                            <span class="input-group-text" style="background: rgb(228, 228, 228);">
                                                <b>Rp.</b>
                                            </span>
                                            <input type="number" value="{{ old('minggu2') }}" name="minggu2"
                                                id="minggu2" class="form-control minggu-input" placeholder="0"
                                                min="0">
                                            @error('minggu2')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="minggu3">Minggu III</label>
                                        <div class="input-group mb-2 mt-2">
                                            <span class="input-group-text" style="background: rgb(228, 228, 228);">
                                                <b>Rp.</b>
                                            </span>
                                            <input type="number" value="{{ old('minggu3') }}" name="minggu3"
                                                id="minggu3" class="form-control minggu-input" placeholder="0"
                                                min="0">
                                            @error('minggu3')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="minggu4">Minggu IV</label>
                                        <div class="input-group mb-2 mt-2">
                                            <span class="input-group-text" style="background: rgb(228, 228, 228);">
                                                <b>Rp.</b>
                                            </span>
                                            <input type="number" value="{{ old('minggu4') }}" name="minggu4"
                                                id="minggu4" class="form-control minggu-input" placeholder="0"
                                                min="0">
                                            @error('minggu4')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <h5 class="mt-3">
                                    <li>Sub Total</li>
                                </h5>
                                <hr>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jumlah">Jumlah</label>
                                        <div class="input-group mb-2 mt-2">
                                            <span class="input-group-text" style="background: rgb(228, 228, 228);">
                                                <b>Rp.</b>
                                            </span>
                                            <input type="number" name="jumlah" id="jumlah" class="form-control"
                                                placeholder="0" readonly>
                                            @error('jumlah')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="latitude">Keterangan</label>
                                        <textarea name="keterangan" id="keterangan" cols="10" rows="5" class="form-control mt-2 mb-2">{{ old('keterangan') }}</textarea>
                                        @error('keterangan')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3 mr-2">Simpan</button>
                            <a href="{{ route('petugas.input.infaq') }}" class="btn btn-secondary mt-3">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            /* Alert */
            .swal2-container {
                z-index: 9999 !important;
            }
        </style>
    @endpush

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    placeholder: '-- Pilih --',
                    allowClear: true,
                    width: '100%'
                });

                // Fungsi untuk menghitung total dan memperbarui input jumlah
                function updateTotal() {
                    const minggu1 = parseFloat($('#minggu1').val()) || 0;
                    const minggu2 = parseFloat($('#minggu2').val()) || 0;
                    const minggu3 = parseFloat($('#minggu3').val()) || 0;
                    const minggu4 = parseFloat($('#minggu4').val()) || 0;
                    const total = minggu1 + minggu2 + minggu3 + minggu4;

                    $('#jumlah').val(total);
                    $('#total_formatted').val('Rp ' + total.toLocaleString('id-ID'));
                }

                // Dengarkan perubahan pada input minggu
                $('.minggu-input').on('input', updateTotal);

                // Inisialisasi total saat halaman dimuat
                updateTotal();

                // AJAX untuk memfilter kelurahan berdasarkan kecamatan
                $('#id_kecamatan').on('change', function() {
                    const kecamatanId = $(this).val();
                    const $kelurahanSelect = $('#id_kelurahan');

                    $kelurahanSelect.empty().append('<option value="">-- Pilih Kelurahan --</option>');

                    if (kecamatanId) {
                        $.ajax({
                            url: '{{ route('petugas.getKelurahanByWilayahTugas') }}',
                            type: 'POST',
                            data: {
                                id_kecamatan: kecamatanId,
                                id_petugas: {{ $petugas->id }},
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(data) {
                                data.forEach(function(kelurahan) {
                                    $kelurahanSelect.append(
                                        `<option value="${kelurahan.id}">${kelurahan.nama_kelurahan}</option>`
                                    );
                                });
                                $kelurahanSelect.trigger('change');
                            },
                            error: function(error) {
                                console.error('Error fetching kelurahan:', error);
                                alert('Gagal mengambil data kelurahan.');
                            }
                        });
                    }
                });
            });
        </script>
    @endpush

</x-utama.layout.main>
