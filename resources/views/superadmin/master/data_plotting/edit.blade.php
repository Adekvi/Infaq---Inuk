<x-utama.layout.main title="Superadmin | Master Plottig Tempat">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card-title">
                    <h5 style="margin-bottom: 20px"><strong>Data Plottig Tempat</strong></h5>
                    <div class="mb-1" style="display: flex; justify-content: start">
                        <code>Edit Data Plottig Tempat</code>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('superadmin/master-data/plotting/edit/' . $plotting->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- USER --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="id_user" class="form-label">User</label>
                                    <input type="text" class="form-control mt-2 mb-2"
                                        value="{{ $user->username ?? '-' }}" readonly>
                                </div>
                            </div>

                            {{-- KECAMATAN & KELURAHAN --}}
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="id_kecamatan" class="form-label">Kecamatan</label>
                                    <select name="id_kecamatan" id="id_kecamatan" class="form-control select2" required>
                                        <option value="">-- Pilih Kecamatan --</option>
                                        @foreach ($kecamatan as $kec)
                                            <option value="{{ $kec->id }}"
                                                {{ $pilihKec == $kec->id ? 'selected' : '' }}>
                                                {{ $kec->nama_kecamatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_kecamatan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="id_kelurahan" class="form-label">Kelurahan</label>
                                    <select name="id_kelurahan" id="id_kelurahan" class="form-control mt-2 select2"
                                        data-selected="{{ $pilihKel }}">
                                        <option value="">-- Pilih Kelurahan --</option>
                                        @foreach ($kelurahan as $kel)
                                            <option value="{{ $kel->id }}"
                                                {{ $pilihKel == $kel->id ? 'selected' : '' }}>
                                                {{ $kel->nama_kelurahan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_kelurahan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- RT / RW --}}
                            @php
                                $rts = json_decode($plotting->Rt, true) ?? [];
                                $rws = json_decode($plotting->Rw, true) ?? [];
                            @endphp

                            <div class="mb-3">
                                <label class="form-label">RT / RW</label>
                                <div class="rt-rw-container d-flex flex-wrap gap-3 align-items-end"
                                    id="rt-rw-container">
                                    @foreach ($rts as $i => $rt)
                                        <div class="rt-rw-group d-flex flex-column flex-md-row gap-2 align-items-md-end mb-2"
                                            data-id="{{ $i + 1 }}">
                                            <div class="form-group flex-fill">
                                                <label>RT</label>
                                                <input type="text" name="Rt[]" class="form-control"
                                                    value="{{ $rt }}">
                                                @error('Rt.' . $i)
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group flex-fill">
                                                <label>RW</label>
                                                <input type="text" name="Rw[]" class="form-control"
                                                    value="{{ $rws[$i] ?? '' }}">
                                                @error('Rw.' . $i)
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="d-flex flex-column justify-content-end">
                                                <button type="button"
                                                    class="btn btn-danger btn-sm remove-rt-rw d-inline-flex align-items-center justify-content-center"
                                                    data-bs-toggle="tooltip" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach

                                    {{-- Tombol Tambah --}}
                                    <div class="d-flex flex-column justify-content-end mb-2">
                                        <button type="button" class="btn btn-primary btn-sm" id="addRtRw"
                                            data-bs-toggle="tooltip" title="Tambah">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                {{-- Submit --}}
                                <div class="d-flex gap-2 mt-3">
                                    <button type="submit" class="btn btn-primary" data-bs-toggle="tooltip"
                                        title="Simpan">
                                        <i class="fa-solid fa-floppy-disk"></i> Simpan
                                    </button>
                                    <a href="{{ route('superadmin.master.plotting') }}" class="btn btn-secondary"
                                        data-bs-toggle="tooltip" title="Kembali">
                                        <i class="fa-solid fa-arrows-rotate"></i> Kembali
                                    </a>
                                </div>
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
            /* Styling untuk Select2 */
            .select2-container .select2-selection--single {
                height: 40px;
                /* Sesuaikan dengan tinggi input Bootstrap */
                border: 1px solid #ced4da;
                /* Warna border seperti Bootstrap */
                border-radius: 4px;
                padding: 0.375rem 0.75rem;
                background-color: #fff;
                transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {
                /* Sesuaikan dengan tinggi input */
                color: #495057;
                /* Warna teks seperti Bootstrap */
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                /* Sesuaikan dengan tinggi input */
                right: 10px;
            }

            .select2-container--default .select2-selection--single:focus {
                border-color: #80bdff;
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
                /* Efek focus seperti Bootstrap */
                outline: none;
            }

            /* Styling dropdown */
            .select2-container--default .select2-results__option--highlighted[aria-selected] {
                background-color: #007bff;
                /* Warna highlight seperti Bootstrap primary */
                color: #fff;
            }

            .select2-container--default .select2-results__option {
                padding: 8px 12px;
                font-size: 14px;
            }

            .select2-dropdown {
                border: 1px solid #ced4da;
                border-radius: 4px;
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                /* Efek bayangan seperti Bootstrap */
            }

            /* Responsif */
            @media (max-width: 576px) {
                .select2-container .select2-selection--single {
                    font-size: 14px;
                }
            }

            /* Rt dan Rw */
            /* Konsistensi tombol hapus dan tambah */
            .remove-rt-rw,
            #addRtRw {
                white-space: nowrap;
                padding: 0.375rem 0.75rem;
                font-weight: 500;
                font-size: 0.875rem;
            }

            /* Responsivitas untuk rt-rw-container */
            .rt-rw-container {
                display: flex;
                flex-wrap: wrap;
                gap: 1rem;
            }

            /* Responsivitas untuk rt-rw-group */
            .rt-rw-group {
                width: 100%;
                max-width: 500px;
            }

            /* Penyesuaian untuk layar sedang dan besar */
            @media (min-width: 768px) {
                .rt-rw-group {
                    width: calc(50% - 0.5rem);
                    /* Dua kolom dengan jarak */
                }

                /* Penyesuaian untuk tombol Tambah agar sejajar */
                #addRtRw {
                    margin-left: auto;
                    /* Geser tombol Tambah ke kanan */
                }
            }

            /* Penyesuaian untuk layar kecil */
            @media (max-width: 767px) {

                .rt-rw-group .d-flex.flex-column,
                .rt-rw-container .d-flex.flex-column {
                    width: 100%;
                    /* Tombol memenuhi lebar pada layar kecil */
                }

                .remove-rt-rw,
                #addRtRw {
                    width: 100%;
                    /* Tombol memenuhi lebar */
                    justify-content: center;
                    /* Pusatkan konten tombol */
                }
            }
        </style>
    @endpush

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function() {
                // Inisialisasi Select2
                $('#id_user').select2({
                    placeholder: '-- Pilih User --',
                    allowClear: true,
                    width: '100%',
                });

                $('#id_kecamatan').select2({
                    placeholder: '-- Pilih Kecamatan --',
                    allowClear: true,
                    width: '100%',
                });

                $('#id_kelurahan').select2({
                    placeholder: '-- Pilih Kelurahan --',
                    allowClear: true,
                    width: '100%',
                });

                // Counter untuk ID unik RT/RW
                let rtRwCount = $('.rt-rw-group').length;

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
                    const kecamatanId = $(this).val();
                    const kelurahanSelect = $('#id_kelurahan');
                    const preselectedKelurahan = kelurahanSelect.data('selected');

                    kelurahanSelect.html('<option value="">-- Pilih Kelurahan --</option>');

                    if (kecamatanId) {
                        $.ajax({
                            url: '{{ route('superadmin.master.getKelurahan') }}',
                            type: 'GET',
                            data: {
                                id_kecamatan: kecamatanId
                            },
                            success: function(data) {
                                $.each(data, function(index, kelurahan) {
                                    const isSelected = preselectedKelurahan == kelurahan
                                        .id ? 'selected' : '';
                                    kelurahanSelect.append(
                                        `<option value="${kelurahan.id}" ${isSelected}>${kelurahan.nama_kelurahan}</option>`
                                    );
                                });
                                kelurahanSelect.trigger('change');
                            },
                            error: function() {
                                alert('Gagal memuat data kelurahan.');
                            }
                        });
                    } else {
                        kelurahanSelect.val(null).trigger('change');
                    }
                });

                // Tambah kolom RT/RW baru
                $('#addRtRw').on('click', function() {
                    rtRwCount++;
                    const newRtRw = `
            <div class="rt-rw-group d-flex flex-column flex-md-row gap-2 align-items-md-end mb-2" data-id="${rtRwCount}">
                <div class="form-group flex-fill">
                    <label for="Rt_${rtRwCount}">RT</label>
                    <input type="text" name="Rt[]" id="Rt_${rtRwCount}" class="form-control" placeholder="RT" required pattern="[0-9]{1,3}" title="RT harus berupa angka (1-999)">
                </div>
                <div class="form-group flex-fill">
                    <label for="Rw_${rtRwCount}">RW</label>
                    <input type="text" name="Rw[]" id="Rw_${rtRwCount}" class="form-control" placeholder="RW" required pattern="[0-9]{1,3}" title="RW harus berupa angka (1-999)">
                </div>
                <div class="d-flex flex-column justify-content-end">
                    <button type="button" class="btn btn-danger btn-sm remove-rt-rw d-inline-flex align-items-center justify-content-center" data-bs-toggle="tooltip" title="Hapus">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
                    $('#rt-rw-container').find('.rt-rw-group').last().after(newRtRw);
                    updateRemoveButtons();
                    $('[data-bs-toggle="tooltip"]').tooltip();
                });

                // Hapus kolom RT/RW
                $(document).on('click', '.remove-rt-rw', function() {
                    $(this).closest('.rt-rw-group').remove();
                    updateRemoveButtons();
                });

                // Inisialisasi saat pertama kali halaman dimuat
                updateRemoveButtons();
                $('[data-bs-toggle="tooltip"]').tooltip();

                // Trigger load kelurahan jika sudah ada kecamatan terpilih
                if ($('#id_kecamatan').val()) {
                    $('#id_kecamatan').trigger('change');
                }
            });
        </script>
    @endpush

</x-utama.layout.main>
