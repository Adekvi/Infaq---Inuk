<x-utama.layout.main title="Superadmin | Master Plottig Tempat">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card-title">
                    <h5 style="margin-bottom: 20px"><strong>Data Plottig Tempat</strong></h5>
                    <div class="mb-1" style="display: flex; justify-content: start">
                        <code>Tambah Data Plottig Tempat</code>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('superadmin/master-data/plotting/tambah') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">User</label>
                                        <select name="id_user" id="id_user" class="form-select select2 mt-2 mb-2">
                                            <option value="">-- Pilih User --</option>
                                            @foreach ($user as $item)
                                                <option value="{{ $item->id }}">{{ $item->username }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="id_kecamatan" class="form-label">Kecamatan</label>
                                    <select class="form-control" id="id_kecamatan" name="id_kecamatan" required>
                                        <option value="">Pilih Kecamatan</option>
                                        @foreach ($kecamatan as $kec)
                                            <option value="{{ $kec->id }}"
                                                {{ old('id_kecamatan') == $kec->id ? 'selected' : '' }}>
                                                {{ $kec->nama_kecamatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_kecamatan')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="id_kelurahan" class="form-label">Kelurahan</label>
                                    <select class="form-control mt-2 mb-2 select2" id="id_kelurahan"
                                        name="id_kelurahan[]" multiple required>
                                        <option value="">Pilih Kelurahan</option>
                                        <!-- Kelurahan diisi via AJAX -->
                                    </select>
                                    @error('id_kelurahan')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 mt-3">
                                    <div class="rt-rw-container d-flex flex-wrap gap-3 align-items-end">
                                        <div class="rt-rw-group d-flex gap-2" style="width: 350px;" data-id="1">
                                            <div class="form-group" style="flex: 1;">
                                                <label for="Rt_1">RT</label>
                                                <input type="text" name="Rt[]" id="Rt_1"
                                                    class="form-control mt-2 mb-2" placeholder="RT">
                                            </div>
                                            <div class="form-group" style="flex: 1;">
                                                <label for="Rw_1">RW</label>
                                                <input type="text" name="Rw[]" id="Rw_1"
                                                    class="form-control mt-2 mb-2" placeholder="RW">
                                            </div>
                                        </div>
                                        <button type="button" data-bs-toggle="tooltip" title="Tambah"
                                            class="btn btn-primary mb-2" id="addRtRw">
                                            <i class="fas fa-plus"></i> Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" data-bs-toggle="tooltip" title="Simpan"
                                class="btn btn-primary mt-3 mr-2">
                                <i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                            <a href="{{ route('superadmin.master.plotting') }}" data-bs-toggle="tooltip" title="Kembali"
                                class="btn btn-secondary mt-3">
                                <i class="fa-solid fa-arrows-rotate"></i> Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            .rt-rw-container {
                max-width: 100%;
            }

            .rt-rw-group {
                flex: 0 0 auto;
            }

            .remove-rt-rw {
                padding: 0.375rem 0.75rem;
            }

            .remove-rt-rw:hover {
                background-color: #dc3545;
                opacity: 0.9;
            }

            .select2-container--default .select2-selection--multiple {
                border: 1px solid #ced4da;
                border-radius: 0.25rem;
                min-height: 38px;
            }

            .select2-container--default .select2-selection--multiple .select2-selection__choice {
                background-color: #007bff;
                color: white;
                border-radius: 4px;
            }
        </style>
    @endpush

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function() {
                // Inisialisasi Select2
                $('#id_kelurahan').select2({
                    placeholder: "-- Pilih Kelurahan --",
                    allowClear: true,
                    width: '100%'
                });

                // Counter untuk ID unik
                let rtRwCount = 1;

                // Fungsi untuk memperbarui tombol hapus
                function updateRemoveButtons() {
                    const groups = $('.rt-rw-group');
                    if (groups.length > 1) {
                        groups.find('.remove-rt-rw').show();
                    } else {
                        groups.find('.remove-rt-rw').hide();
                    }
                }

                // Ketika dropdown kecamatan berubah
                $('#id_kecamatan').on('change', function() {
                    var kecamatanId = $(this).val();
                    var kelurahanSelect = $('#id_kelurahan');

                    // Kosongkan dropdown kelurahan
                    kelurahanSelect.html('<option value="">-- Pilih Kelurahan --</option>').trigger('change');

                    if (kecamatanId) {
                        // Kirim permintaan AJAX untuk mendapatkan kelurahan
                        $.ajax({
                            url: '{{ route('superadmin.master.getKelurahan') }}',
                            type: 'GET',
                            data: {
                                id_kecamatan: kecamatanId
                            },
                            success: function(data) {
                                // Isi dropdown kelurahan dengan data yang diterima
                                $.each(data, function(index, kelurahan) {
                                    kelurahanSelect.append(
                                        '<option value="' + kelurahan.id + '">' +
                                        kelurahan.nama_kelurahan + '</option>'
                                    );
                                });

                                // Jika ada kelurahan yang sudah dipilih sebelumnya
                                var selectedKelurahan = '{{ request('kelurahan') }}';
                                if (selectedKelurahan) {
                                    kelurahanSelect.val(selectedKelurahan.split(',')).trigger(
                                        'change');
                                }
                            },
                            error: function() {
                                alert('Gagal memuat data kelurahan.');
                            }
                        });
                    }
                });

                // Tambah kolom RT/RW
                $('#addRtRw').on('click', function() {
                    rtRwCount++;
                    const newRtRw = `
                        <div class="rt-rw-group d-flex gap-2 align-items-end mb-2" style="width: 45%;" data-id="${rtRwCount}">
                            <div class="form-group flex-fill">
                                <label for="Rt_${rtRwCount}">RT</label>
                                <input type="text" name="Rt[]" id="Rt_${rtRwCount}" class="form-control mt-2" placeholder="RT">
                            </div>
                            <div class="form-group flex-fill">
                                <label for="Rw_${rtRwCount}">RW</label>
                                <input type="text" name="Rw[]" id="Rw_${rtRwCount}" class="form-control mt-2" placeholder="RW">
                            </div>
                            <div class="d-flex flex-column justify-content-end">
                                <button type="button" class="btn btn-danger remove-rt-rw d-inline-flex align-items-center justify-content-center" style="height: 38px; white-space: nowrap;" data-bs-toggle="tooltip"
                                            title="Hapus">
                                    <i class="fas fa-trash me-1"></i> Hapus
                                </button>
                            </div>              
                        </div>
                    `;
                    $(this).before(newRtRw); // Tambahkan grup baru sebelum tombol Tambah
                    updateRemoveButtons();
                });

                // Hapus kolom RT/RW
                $(document).on('click', '.remove-rt-rw', function() {
                    $(this).closest('.rt-rw-group').remove();
                    updateRemoveButtons();
                });

                // Trigger change saat halaman dimuat
                if ($('#id_kecamatan').val()) {
                    $('#id_kecamatan').trigger('change');
                }

                // Inisialisasi tombol hapus
                updateRemoveButtons();
            });
        </script>
    @endpush

</x-utama.layout.main>
