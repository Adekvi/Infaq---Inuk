<x-utama.layout.main title="Superadmin | Master Petugas">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card-title">
                    <h5 style="margin-bottom: 20px"><strong>Data Petugas</strong></h5>
                    <div class="mb-1" style="display: flex; justify-content: start">
                        <code>Tambah Petugas</code>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('superadmin/master-data/petugas-dataPetugas/tambah') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_kelurahan">Wilayah</label>
                                        <select name="kelurahans[]" id="id_kelurahan" class="form-select mt-2 mb-2"
                                            multiple>
                                            @foreach ($kelurahan as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama_kelurahan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="rw-rt-container" class="mt-3"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama_petugas">Nama Petugas</label>
                                        <input type="text" name="nama_petugas" id="nama_petugas"
                                            class="form-control mt-2 mb-2" placeholder="Nama Petugas" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="latitude">Koordinat Latitude</label>
                                        <input type="text" name="latitude" id="latitude"
                                            class="form-control mb-2 mt-2" placeholder="Koordinat Latitude">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="longitude">Koordinat Longitude</label>
                                        <input type="text" name="longitude" id="longitude"
                                            class="form-control mb-2 mt-2" placeholder="Koordinat Longitude">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3 mr-2">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('css')
        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

    @push('js')
        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function() {
                // Inisialisasi Select2
                $('#id_kelurahan').select2({
                    placeholder: ' -- Pilih Kelurahan -- ',
                    width: '100%',
                    allowClear: true
                }).next('.select2-container').css({
                    'border': '0.5px solid #ced4da',
                    'border-radius': '.375rem',
                    'box-shadow': 'none',
                    'background-color': '#ffffff',
                    'margin-top': '0.5rem',
                    'margin-bottom': '0.5rem'
                });

                $('.select2-container .select2-selection--multiple').css({
                    'padding': '.375rem 1rem',
                    'min-height': 'calc(2.25rem + 2px)',
                    'border': '1px solid #ced4da',
                    'border-radius': '.375rem'
                });

                $('.select2-container .select2-selection--multiple .select2-selection__choice').css({
                    'border-radius': '.375rem',
                    'background-color': '#0d6efd',
                    'color': '#ffffff',
                    'padding': '0.25rem 0.75rem'
                });

                $('#id_kelurahan').on('select2:open', function() {
                    $('.select2-container--open .select2-dropdown').css({
                        'border': '0.5px solid #0d6efd',
                        'border-radius': '.375rem'
                    });
                });

                // Tangani perubahan pada select2
                $('#id_kelurahan').on('change', function() {
                    const selectedKelurahans = $(this).val(); // Array ID kelurahan yang dipilih
                    const container = $('#rw-rt-container');
                    container.empty(); // Kosongkan container sebelum menambah elemen baru

                    if (selectedKelurahans && selectedKelurahans.length > 0) {
                        selectedKelurahans.forEach((id, index) => {
                            // Ambil nama kelurahan dari option yang dipilih
                            const namaKelurahan = $(`#id_kelurahan option[value="${id}"]`).text();
                            // Tambahkan input RW dan RT untuk setiap kelurahan
                            container.append(`
                                <div class="rw-rt-group mb-3">
                                    <label><strong>${namaKelurahan}</strong></label>
                                    <input type="hidden" name="kelurahans[${index}][id_kelurahan]" value="${id}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" name="kelurahans[${index}][RW]" class="form-control mb-2" placeholder="RW">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="kelurahans[${index}][RT]" class="form-control mb-2" placeholder="RT">
                                        </div>
                                    </div>
                                </div>
                            `);
                        });
                    }
                });
            });
        </script>
    @endpush

</x-utama.layout.main>
