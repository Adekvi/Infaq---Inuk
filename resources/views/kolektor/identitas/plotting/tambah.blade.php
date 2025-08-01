<x-utama.layout.main title="Kolektor | Plotting Tempat">

    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-pills flex-column flex-md-row mb-3">
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);"><i
                                    class="fa-solid fa-location-dot me-1"></i>
                                Plotting Tempat</a>
                        </li>
                    </ul>
                    <div class="card mb-4">
                        <div class="card-body">
                            <form action="{{ route('kolektor.plotting.tambah') }}" method="POST"
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
                                <div class="pilih-wilayah mt-3">
                                    <h5 class="text-dark">
                                        <li>Pilih Wilayah</li>
                                    </h5>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="id_kecamatan">Kecamatan</label>
                                            <select name="id_kecamatan" id="id_kecamatan"
                                                class="form-control mt-2 mb-2 select2" required>
                                                <option value="">-- Pilih Kecamatan --</option>
                                                @foreach ($kecamatans as $kecamatan)
                                                    <option value="{{ $kecamatan->id }}"
                                                        {{ old('id_kecamatan') == $kecamatan->id ? 'selected' : '' }}>
                                                        {{ $kecamatan->nama_kecamatan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_kecamatan')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="id_kelurahan">Kelurahan</label>
                                                <select name="id_kelurahan" id="id_kelurahan"
                                                    class="form-control mt-2 mb-2 select2" required>
                                                    <option value="">-- Pilih Kelurahan --</option>
                                                </select>
                                                @error('id_kelurahan')
                                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div id="rw-rt-container" class="mt-3"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <button type="submit" data-bs-toggle="tooltip" title="Simpan"
                                        class="btn btn-primary mt-3 mr-2">
                                        <i class="fa-solid fa-floppy-disk"></i> Simpan
                                    </button>
                                    <a href="{{ url('kolektor/plotting-index') }}" data-bs-toggle="tooltip"
                                        title="Kembali" class="btn btn-secondary mt-3">
                                        <i class="fa-solid fa-arrows-rotate"></i> Kembali
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('css')
        <!-- CSS bawaan Select2 -->
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
        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                // Inisialisasi Select2 untuk kecamatan dan kelurahan
                $('.select2').select2({
                    placeholder: '-- Pilih --',
                    allowClear: true,
                    width: '100%'
                });

                // Fungsi untuk menghasilkan HTML input RT/RW
                function generateRtRwInput(kelurahanId, kelurahanName, index, oldRw = '', oldRt = '') {
                    return `
                        <div class="rt-rw-item mb-2" data-index="${index}">
                            <div class="row align-items-end">
                                <div class="col-md-5">
                                    <label for="rt_${index}">RT</label>
                                    <input type="text" name="rt[${index}]" id="rt_${index}" 
                                        class="form-control" placeholder="Masukkan RT" value="${oldRt}" 
                                        required pattern="[0-9]{1,3}" title="RT harus berupa angka (1-999)">
                                    @error('rt.${index}')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-5">
                                    <label for="rw_${index}">RW</label>
                                    <input type="text" name="rw[${index}]" id="rw_${index}" 
                                        class="form-control" placeholder="Masukkan RW" value="${oldRw}" 
                                        required pattern="[0-9]{1,3}" title="RW harus berupa angka (1-999)">
                                    @error('rw.${index}')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger btn-sm remove-rt-rw mt-2" data-index="${index}">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                }

                // Event saat kecamatan berubah
                $('#id_kecamatan').on('change', function() {
                    const kecamatanId = $(this).val();
                    const $kelurahanSelect = $('#id_kelurahan');

                    // Kosongkan pilihan kelurahan sebelumnya
                    $kelurahanSelect.empty().append('<option value="">-- Pilih Kelurahan --</option>');

                    // Kosongkan container RT/RW
                    $('#rw-rt-container').empty();

                    if (kecamatanId) {
                        $.ajax({
                            url: '{{ route('kolektor.master.getKelurahan') }}',
                            type: 'POST',
                            data: {
                                id_kecamatan: kecamatanId,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(data) {
                                data.forEach(function(kelurahan) {
                                    $kelurahanSelect.append(
                                        `<option value="${kelurahan.id}">${kelurahan.nama_kelurahan}</option>`
                                    );
                                });
                                // Perbarui input RT/RW berdasarkan pilihan sebelumnya
                                const oldKelurahan = @json(old('id_kelurahan', ''));
                                if (oldKelurahan) {
                                    $kelurahanSelect.val(oldKelurahan).trigger('change');
                                }
                            },
                            error: function(error) {
                                console.error('Error fetching kelurahan:', error);
                                alert('Gagal mengambil data kelurahan.');
                            }
                        });
                    }
                });

                // Event saat kelurahan dipilih
                $('#id_kelurahan').on('change', function() {
                    const kelurahanId = $(this).val();
                    const $container = $('#rw-rt-container');
                    $container.empty();

                    if (kelurahanId) {
                        const kelurahanName = $('#id_kelurahan option[value="' + kelurahanId + '"]').text();
                        const oldRw = @json(old('rw', []))[0] || '';
                        const oldRt = @json(old('rt', []))[0] || '';

                        // Buat grup untuk kelurahan
                        const kelurahanGroup = `
                            <div class="rt-rw-group mb-3" data-kelurahan-id="${kelurahanId}">
                                <h6>RT/RW untuk ${kelurahanName}</h6>
                                <div class="rt-rw-inputs"></div>
                                <button type="button" class="btn btn-primary btn-sm add-rt-rw mt-2" 
                                    data-kelurahan-id="${kelurahanId}" data-kelurahan-name="${kelurahanName}" 
                                    data-index-start="0">
                                    Tambah RT/RW
                                </button>
                            </div>
                        `;
                        $container.append(kelurahanGroup);

                        // Tambahkan input RT/RW awal
                        $(`.rt-rw-group[data-kelurahan-id="${kelurahanId}"] .rt-rw-inputs`)
                            .append(generateRtRwInput(kelurahanId, kelurahanName, 0, oldRw, oldRt));
                    }
                });

                // Event untuk tombol "Tambah RT/RW"
                $('#rw-rt-container').on('click', '.add-rt-rw', function() {
                    console.log('Tombol Tambah RT/RW diklik');
                    const kelurahanId = $(this).data('kelurahan-id');
                    const kelurahanName = $(this).data('kelurahan-name');
                    const $inputsContainer = $(this).siblings('.rt-rw-inputs');
                    const inputIndex = $('.rt-rw-item').length;

                    // Tambahkan input baru dengan indeks baru
                    $inputsContainer.append(generateRtRwInput(kelurahanId, kelurahanName, inputIndex));
                });

                // Event untuk tombol "Hapus RT/RW"
                $('#rw-rt-container').on('click', '.remove-rt-rw', function() {
                    console.log('Tombol Hapus RT/RW diklik');
                    $(this).closest('.rt-rw-item').remove();
                });

                // Trigger change awal untuk memuat data lama
                $('#id_kecamatan').trigger('change');
            });
        </script>
    @endpush
</x-utama.layout.main>
