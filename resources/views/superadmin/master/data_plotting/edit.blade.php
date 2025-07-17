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
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="id_user" class="form-label">User</label>
                                    <select name="id_user" id="id_user" class="form-control select2" required>
                                        <option value="">-- Pilih User --</option>
                                        @foreach ($user as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == $plotting->id_user ? 'selected' : '' }}>
                                                {{ $item->username }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_user')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- KECAMATAN & KELURAHAN --}}
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="id_kecamatan" class="form-label">Kecamatan</label>
                                    <select name="id_kecamatan" id="id_kecamatan" class="form-control select2" required>
                                        @foreach ($kecamatan as $kec)
                                            <option value="{{ $kec->id }}"
                                                {{ $kec->id == $plotting->id_kecamatan ? 'selected' : '' }}>
                                                {{ $kec->nama_kecamatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_kecamatan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                @php
                                    $selectedKelurahanIds = $plotting->kelurahan->pluck('id')->toArray();
                                @endphp
                                <div class="col-md-6">
                                    <label for="id_kelurahan" class="form-label">Kelurahan</label>
                                    <select name="id_kelurahan[]" id="id_kelurahan" class="form-control select2"
                                        multiple required data-selected='@json($selectedKelurahanIds)'>
                                        @foreach ($kelurahan as $kel)
                                            <option value="{{ $kel->id }}"
                                                {{ in_array($kel->id, $selectedKelurahanIds) ? 'selected' : '' }}>
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
                                $rts = json_decode($plotting->Rt, true);
                                $rws = json_decode($plotting->Rw, true);
                            @endphp
                            <div class="mb-3">
                                <label class="form-label">RT / RW</label>
                                <div class="rt-rw-container d-flex flex-wrap gap-3 align-items-end">
                                    @foreach ($rts as $i => $rt)
                                        <div class="rt-rw-group d-flex gap-2 align-items-end mb-2" style="width: 45%;"
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
                                                    class="btn btn-danger remove-rt-rw d-inline-flex align-items-center gap-1"
                                                    data-bs-toggle="tooltip" title="Hapus">
                                                    <i class="fas fa-trash"></i> <span>Hapus</span>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach

                                    {{-- Tombol Tambah --}}
                                    <button type="button" class="btn btn-primary mb-2" id="addRtRw"
                                        data-bs-toggle="tooltip" title="Tambah">
                                        <i class="fas fa-plus"></i> Tambah
                                    </button>
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            /* Styling Select2 agar seragam dengan Bootstrap */
            .select2-container .select2-selection--single,
            .select2-container .select2-selection--multiple {
                font-size: 1rem;
                line-height: 1.5;
                border: 1px solid #ced4da;
                border-radius: 0.375rem;
            }

            /* Focus efek */
            .select2-container--default.select2-container--focus .select2-selection {
                border-color: #86b7fe;
                box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, .25);
                outline: none;
            }

            /* Konsistensi tombol hapus */
            .remove-rt-rw {
                white-space: nowrap;
                padding: 0.375rem 0.75rem;
                font-weight: 500;
                font-size: 0.875rem;
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
                    width: '100%'
                });
                $('#id_kelurahan').select2({
                    placeholder: "-- Pilih Kelurahan --",
                    allowClear: true,
                    width: '100%'
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

                // Data kelurahan yang sebelumnya dipilih
                let preselectedKelurahan = $('#id_kelurahan').data('selected') || [];

                // Ketika dropdown kecamatan berubah
                $('#id_kecamatan').on('change', function() {
                    let kecamatanId = $(this).val();
                    let kelurahanSelect = $('#id_kelurahan');

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
                                    let isSelected = preselectedKelurahan.includes(kelurahan
                                        .id.toString()) ? 'selected' : '';
                                    kelurahanSelect.append(
                                        `<option value="${kelurahan.id}" ${isSelected}>${kelurahan.nama_kelurahan}</option>`
                                    );
                                });

                                // Refresh Select2 untuk memastikan nilai terpilih ditampilkan
                                kelurahanSelect.val(preselectedKelurahan).trigger('change');
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
                    <button type="button" class="btn btn-danger remove-rt-rw d-inline-flex align-items-center justify-content-center"
                            style="height: 38px; white-space: nowrap;" data-bs-toggle="tooltip" title="Hapus">
                        <i class="fas fa-trash me-1"></i> Hapus
                    </button>
                </div>
            </div>
        `;
                    $(this).before(newRtRw);
                    updateRemoveButtons();
                    // Reinisialisasi tooltip untuk elemen baru
                    $('[data-bs-toggle="tooltip"]').tooltip();
                });

                // Hapus kolom RT/RW
                $(document).on('click', '.remove-rt-rw', function() {
                    $(this).closest('.rt-rw-group').remove();
                    updateRemoveButtons();
                });

                // Inisialisasi saat pertama kali halaman dimуют
                updateRemoveButtons();

                // Inisialisasi Bootstrap Tooltip
                $('[data-bs-toggle="tooltip"]').tooltip();

                // Trigger load kelurahan jika sudah ada kecamatan terpilih
                if ($('#id_kecamatan').val()) {
                    $('#id_kecamatan').trigger('change');
                }
            });
        </script>
    @endpush

</x-utama.layout.main>
