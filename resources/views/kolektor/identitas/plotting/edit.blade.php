<x-utama.layout.main title="Kolektor | Plotting Tempat">

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-pills flex-column flex-md-row mb-3">
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);"><i
                                    class="fa-solid fa-location-dot me-1"></i>
                                Edit Plotting Tempat</a>
                        </li>
                    </ul>
                    <div class="card mb-4">
                        <div class="card-body">
                            <form action="{{ url('kolektor/plotting-tempat/edit-data/' . $plotting->id) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
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
                                            <select name="id_kecamatan" id="id_kecamatan" class="form-control mt-2 mb-2"
                                                required>
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
                                                    class="form-control select2" required>
                                                    <option value="">-- Pilih Kelurahan --</option>
                                                    @foreach ($kelurahan as $kel)
                                                        <option value="{{ $kel->id }}"
                                                            {{ $pilihKel == $kel->id ? 'selected' : '' }}>
                                                            {{ $kel->nama_kelurahan }}
                                                        </option>
                                                    @endforeach
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

                // Fungsi untuk menghasilkan input RT/RW
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
                                    <button type="button" class="btn btn-danger btn-sm remove-rt-rw" data-index="${index}">
                                        <i class="fas fa-trash"></i>
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
                            url: '{{ route('kolektor.getKelurahan') }}',
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

                                // Setel kelurahan yang sudah dipilih sebelumnya
                                const kelurahanId = @json($pilihKel);
                                if (kelurahanId) {
                                    $kelurahanSelect.val(kelurahanId).trigger('change');
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
                        const $option = $('#id_kelurahan option[value="' + kelurahanId + '"]');
                        const kelurahanName = $option.text();
                        const rts = @json($rts);
                        const rws = @json($rws);

                        // Buat grup untuk kelurahan
                        const kelurahanGroup = `
                            <div class="rt-rw-group mb-3" data-kelurahan-id="${kelurahanId}">
                                <h6>RT/RW untuk ${kelurahanName}</h6>
                                <div class="rt-rw-inputs"></div>
                                <button type="button" class="btn btn-primary btn-sm add-rt-rw mt-2" 
                                    data-kelurahan-id="${kelurahanId}" data-kelurahan-name="${kelurahanName}" 
                                    data-index-start="0">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        `;
                        $container.append(kelurahanGroup);

                        // Tambahkan input RT/RW awal
                        const oldRw = rws[0] || @json(old('rw', []))[0] || '';
                        const oldRt = rts[0] || @json(old('rt', []))[0] || '';
                        $(`.rt-rw-group[data-kelurahan-id="${kelurahanId}"] .rt-rw-inputs`)
                            .append(generateRtRwInput(kelurahanId, kelurahanName, 0, oldRw, oldRt));
                    }
                });

                // Event untuk tombol "Tambah RT/RW"
                $('#rw-rt-container').on('click', '.add-rt-rw', function() {
                    const kelurahanId = $(this).data('kelurahan-id');
                    const kelurahanName = $(this).data('kelurahan-name');
                    const $inputsContainer = $(this).siblings('.rt-rw-inputs');
                    const inputIndex = $('.rt-rw-item').length;

                    // Tambahkan input baru
                    $inputsContainer.append(generateRtRwInput(kelurahanId, kelurahanName, inputIndex));
                });

                // Event untuk tombol "Hapus RT/RW"
                $('#rw-rt-container').on('click', '.remove-rt-rw', function() {
                    $(this).closest('.rt-rw-item').remove();
                });

                // Setel kecamatan yang sudah dipilih sebelumnya
                const kecamatanId = @json($pilihKec);
                if (kecamatanId) {
                    $('#id_kecamatan').val(kecamatanId).trigger('change');
                }
            });
        </script>
    @endpush
</x-utama.layout.main>
