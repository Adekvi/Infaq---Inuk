<x-utama.layout.main title="Superadmin | Master User">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card-title">
                    <h5><strong>Data User</strong></h5>
                    <div class="mb-1" style="display: flex; justify-content: start">
                        <code>Tambah Data User</code>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('superadmin/master-data/user/tambah') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Jabatan</label>
                                        <select name="id_setting" id="id_setting" class="form-control mt-2 mb-2"
                                            required>
                                            <option value="">-- Pilih --</option>
                                            @foreach ($setting as $item)
                                                <option value="{{ $item->id }}">{{ $item->namasetting }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Username</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('username') is-invalid @enderror"
                                            name="username" id="username" placeholder="Username">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group position-relative">
                                        <label for="password">Password</label>
                                        <input type="password"
                                            class="form-control mt-2 mb-2 @error('password') is-invalid @enderror"
                                            name="password" id="password" placeholder="12345678">
                                        <!-- Tombol eye -->
                                        <span id="togglePassword"
                                            style="position:absolute; top:38px; right:20px; cursor:pointer;">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="email"
                                            class="form-control mt-2 mb-2 @error('email') is-invalid @enderror"
                                            name="email" id="email" placeholder="@gmail.com">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">No. Hp</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('no_hp') is-invalid @enderror"
                                            name="no_hp" id="no_hp" placeholder="Contoh 08123456789" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Role User</label>
                                        <select name="role" id="role" class="form-control mt-2 mb-2">
                                            <option value="">-- Pilih Role --</option>
                                            <option value="admin_kabupaten">Admin Kabupaten</option>
                                            <option value="admin_kecamatan">Admin Kecamatan</option>
                                            <option value="kolektor" selected>Kolektor</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- PLOTTING TEMPAT --}}
                                <div class="pilih-wilayah mt-3" id="plotting-container" style="display: none;">
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
                                        <div class="col-md-6" id="kelurahan-container" style="display: none;">
                                            <div class="form-group">
                                                <label for="id_kelurahan">Kelurahan</label>
                                                <select name="id_kelurahan" id="id_kelurahan"
                                                    class="form-control mt-2 mb-2 select2">
                                                    <option value="">-- Pilih Kelurahan --</option>
                                                </select>
                                                @error('id_kelurahan')
                                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2" id="rw-rt-section" style="display: none;">
                                        <div class="col-md-6">
                                            <div id="rw-rt-container" class="mt-3"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3 mr-2">
                                <i class="fa-solid fa-floppy-disk"></i> Save
                            </button>
                            <a href="{{ url('superadmin/master-data/user/tambah-data') }}" data-bs-toggle="tooltip"
                                title="Reset" class="btn btn-info mt-3 mr-2">
                                <i class="fa-solid fa-arrows-rotate"></i> Reset
                            </a>
                            <a href="{{ url('superadmin/master-data/user') }}" class="btn btn-secondary mt-3 mr-2">
                                <i class="fa-solid fa-backward"></i> Kembali
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('css')
        <!-- CSS bawaan Select2 -->
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
            // PASSWORD
            document.addEventListener('DOMContentLoaded', function() {
                const password = document.getElementById('password');
                const toggle = document.getElementById('togglePassword');
                const icon = toggle.querySelector('i');

                toggle.addEventListener('click', function() {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);

                    // Ganti icon
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                });
            });

            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                function togglePlottingByRole() {
                    const role = $('#role').val();
                    if (role === 'admin_kecamatan' || role === 'kolektor') {
                        $('#plotting-container').show();
                        $('#id_kecamatan').prop('required', true);

                        if (role === 'admin_kecamatan') {
                            $('#kelurahan-container').hide();
                            $('#rw-rt-section').hide();
                            $('#id_kelurahan').val('').trigger('change');
                            $('#rw-rt-container').empty();
                            $('#id_kelurahan').prop('required', false); // Hapus atribut required
                        } else if (role === 'kolektor') {
                            $('#kelurahan-container').show();
                            $('#rw-rt-section').show();
                            $('#id_kelurahan').prop('required', true); // Tambahkan atribut required
                        }
                    } else {
                        $('#plotting-container').hide();
                        $('#id_kecamatan').val('').trigger('change');
                        $('#id_kelurahan').val('').trigger('change');
                        $('#rw-rt-container').empty();
                        $('#id_kecamatan').prop('required', false);
                        $('#id_kelurahan').prop('required', false); // Hapus atribut required
                    }
                }

                $('#role').on('change', togglePlottingByRole);
                togglePlottingByRole();

                $('.select2').select2({
                    placeholder: '-- Pilih --',
                    allowClear: true,
                    width: '100%'
                });

                function generateRtRwInput(kelurahanId, kelurahanName, index, oldRw = '', oldRt = '') {
                    return `
            <div class="rt-rw-item mb-2" data-index="${index}">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label for="rt_${index}">RT</label>
                        <input type="text" name="rt[${index}]" id="rt_${index}" 
                            class="form-control" placeholder="Masukkan RT" value="${oldRt}" 
                            pattern="[0-9]{1,3}" title="RT harus berupa angka (1-999)" required>
                    </div>
                    <div class="col-md-4">
                        <label for="rw_${index}">RW</label>
                        <input type="text" name="rw[${index}]" id="rw_${index}" 
                            class="form-control" placeholder="Masukkan RW" value="${oldRw}" 
                            pattern="[0-9]{1,3}" title="RW harus berupa angka (1-999)" required>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-danger remove-rt-rw mt-2" data-index="${index}">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
        `;
                }

                $('#id_kecamatan').on('change', function() {
                    const kecamatanId = $(this).val();
                    const $kelurahanSelect = $('#id_kelurahan');
                    $kelurahanSelect.empty().append('<option value="">-- Pilih Kelurahan --</option>');
                    $('#rw-rt-container').empty();

                    const role = $('#role').val();

                    if (kecamatanId && role === 'kolektor') {
                        $.ajax({
                            url: '{{ route('superadmin.master.user.getKelurahan') }}',
                            type: 'POST',
                            data: {
                                id_kecamatan: kecamatanId
                            },
                            success: function(data) {
                                data.forEach(function(kelurahan) {
                                    $kelurahanSelect.append(
                                        `<option value="${kelurahan.id}">${kelurahan.nama_kelurahan}</option>`
                                    );
                                });
                                const oldKelurahan = @json(old('id_kelurahan', ''));
                                if (oldKelurahan) {
                                    $kelurahanSelect.val(oldKelurahan).trigger('change');
                                }
                            },
                            error: function(xhr) {
                                console.error('Error fetching kelurahan:', xhr.responseText);
                                alert('Gagal mengambil data kelurahan: ' + xhr.status + ' ' + xhr
                                    .statusText);
                            }
                        });
                    } else {
                        $kelurahanSelect.val('').trigger('change');
                    }
                });

                $('#id_kelurahan').on('change', function() {
                    const kelurahanId = $(this).val();
                    const $container = $('#rw-rt-container');
                    $container.empty();

                    const role = $('#role').val();
                    if (kelurahanId && role === 'kolektor') {
                        const kelurahanName = $('#id_kelurahan option[value="' + kelurahanId + '"]').text();
                        const oldRw = @json(old('rw', []))[0] || '';
                        const oldRt = @json(old('rt', []))[0] || '';

                        const kelurahanGroup = `
                <div class="rt-rw-group mb-3" data-kelurahan-id="${kelurahanId}">
                    <h6>RT/RW untuk ${kelurahanName}</h6>
                    <div class="rt-rw-inputs"></div>
                    <button type="button" class="btn btn-primary add-rt-rw mt-2" 
                        data-kelurahan-id="${kelurahanId}" data-kelurahan-name="${kelurahanName}" 
                        data-index-start="0">
                        <i class="fas fa-plus"></i> Tambah RT/RW
                    </button>
                </div>
            `;
                        $container.append(kelurahanGroup);

                        $(`.rt-rw-group[data-kelurahan-id="${kelurahanId}"] .rt-rw-inputs`)
                            .append(generateRtRwInput(kelurahanId, kelurahanName, 0, oldRw, oldRt));
                    }
                });

                $('#rw-rt-container').on('click', '.add-rt-rw', function() {
                    const kelurahanId = $(this).data('kelurahan-id');
                    const kelurahanName = $(this).data('kelurahan-name');
                    const $inputsContainer = $(this).siblings('.rt-rw-inputs');
                    const inputIndex = $('.rt-rw-item').length;
                    $inputsContainer.append(generateRtRwInput(kelurahanId, kelurahanName, inputIndex));
                });

                $('#rw-rt-container').on('click', '.remove-rt-rw', function() {
                    $(this).closest('.rt-rw-item').remove();
                });

                $('#id_kecamatan').trigger('change');

                // Handle form submission to bypass hidden required field issues
                $('form').on('submit', function(e) {
                    const role = $('#role').val();
                    if (role === 'admin_kecamatan') {
                        $('#id_kelurahan').prop('disabled',
                            true); // Nonaktifkan id_kelurahan agar tidak divalidasi
                    }
                });
            });
        </script>
    @endpush

</x-utama.layout.main>
