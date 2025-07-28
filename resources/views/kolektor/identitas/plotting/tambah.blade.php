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
                                                <select name="kelurahans[]" id="id_kelurahan"
                                                    class="form-control select2" multiple required>
                                                    <option value="">-- Pilih Kelurahan --</option>
                                                </select>
                                                @error('kelurahans.*')
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
                                    <a href="{{ route('kolektor.dashboard') }}" data-bs-toggle="tooltip" title="Kembali"
                                        class="btn btn-secondary mt-3">
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
                                const oldKelurahans = @json(old('kelurahans', []));
                                if (oldKelurahans.length > 0) {
                                    $kelurahanSelect.val(oldKelurahans).trigger('change');
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
                    const selectedKelurahans = $(this).val() || [];
                    const $container = $('#rw-rt-container');
                    $container.empty();

                    // Counter untuk indeks input RT/RW
                    let inputIndex = 0;

                    // Tambahkan input RT/RW untuk setiap kelurahan yang dipilih
                    selectedKelurahans.forEach(function(kelurahanId, index) {
                        const $option = $('#id_kelurahan option[value="' + kelurahanId + '"]');
                        const kelurahanName = $option.text();
                        const oldRw = @json(old('rw', []))[index] || '';
                        const oldRt = @json(old('rt', []))[index] || '';

                        // Buat grup untuk kelurahan
                        const kelurahanGroup = `
                            <div class="rt-rw-group mb-3" data-kelurahan-id="${kelurahanId}">
                                <h6>RT/RW untuk ${kelurahanName}</h6>
                                <div class="rt-rw-inputs"></div>
                                <button type="button" class="btn btn-primary btn-sm add-rt-rw mt-2" 
                                    data-kelurahan-id="${kelurahanId}" data-kelurahan-name="${kelurahanName}" 
                                    data-index-start="${inputIndex}">
                                    Tambah RT/RW
                                </button>
                            </div>
                        `;
                        $container.append(kelurahanGroup);

                        // Tambahkan input RT/RW awal
                        $(`.rt-rw-group[data-kelurahan-id="${kelurahanId}"] .rt-rw-inputs`)
                            .append(generateRtRwInput(kelurahanId, kelurahanName, inputIndex, oldRw,
                                oldRt));
                        inputIndex++;
                    });
                });

                // Event untuk tombol "Tambah RT/RW" (dipindahkan ke luar)
                $('#rw-rt-container').on('click', '.add-rt-rw', function() {
                    console.log('Tombol Tambah RT/RW diklik'); // Debugging
                    const kelurahanId = $(this).data('kelurahan-id');
                    const kelurahanName = $(this).data('kelurahan-name');
                    const $inputsContainer = $(this).siblings('.rt-rw-inputs');
                    const inputIndex = $('.rt-rw-item').length; // Hitung ulang indeks

                    // Tambahkan input baru dengan indeks baru
                    $inputsContainer.append(generateRtRwInput(kelurahanId, kelurahanName, inputIndex));
                });

                // Event untuk tombol "Hapus RT/RW"
                $('#rw-rt-container').on('click', '.remove-rt-rw', function() {
                    console.log('Tombol Hapus RT/RW diklik'); // Debugging
                    $(this).closest('.rt-rw-item').remove();
                });

                // Trigger change awal untuk memuat data lama
                $('#id_kecamatan').trigger('change');
            });
        </script>
    @endpush
</x-utama.layout.main>
