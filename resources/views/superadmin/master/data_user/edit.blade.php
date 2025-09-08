<x-utama.layout.main title="Superadmin | Master User">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card-title">
                    <h5 style="margin-bottom: 20px"><strong>Data User</strong></h5>
                    <div class="mb-1" style="display: flex; justify-content: start">
                        <code>Edit Data User</code>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('superadmin/master-data/user/edit/' . $user->id) }}" method="POST"
                            enctype="multipart/form-data">
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
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_setting">Jabatan</label>
                                        <select name="id_setting" id="id_setting"
                                            class="form-control mt-2 mb-2 @error('id_setting') is-invalid @enderror"
                                            required>
                                            <option value="">-- Pilih --</option>
                                            @foreach ($settings as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('id_setting', $user->id_setting) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->namasetting }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_setting')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('username') is-invalid @enderror"
                                            name="username" id="username"
                                            value="{{ old('username', $user->username) }}" placeholder="Username"
                                            autocomplete="username">
                                        @error('username')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group position-relative">
                                        <label for="password">Password</label>
                                        <input type="password"
                                            class="form-control mt-2 mb-2 @error('password') is-invalid @enderror"
                                            name="password" id="password"
                                            placeholder="Kosongkan jika tidak ingin mengubah"
                                            autocomplete="new-password">
                                        <span id="togglePassword"
                                            style="position:absolute; top:38px; right:20px; cursor:pointer;">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                        @error('password')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email"
                                            class="form-control mt-2 mb-2 @error('email') is-invalid @enderror"
                                            name="email" id="email" value="{{ old('email', $user->email) }}"
                                            placeholder="@gmail.com">
                                        @error('email')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="no_hp">No. Hp</label>
                                        <input type="text"
                                            class="form-control mt-2 mb-2 @error('no_hp') is-invalid @enderror"
                                            name="no_hp" id="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                                            placeholder="Contoh: +6281234567890 atau 081234567890" required>
                                        @error('no_hp')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">Role User</label>
                                        <select name="role" id="role"
                                            class="form-control mt-2 mb-2 @error('role') is-invalid @enderror" required>
                                            <option value="">-- Pilih Role --</option>
                                            <option value="admin_kabupaten"
                                                {{ old('role', $user->role) == 'admin_kabupaten' ? 'selected' : '' }}>
                                                Admin Kabupaten</option>
                                            <option value="admin_kecamatan"
                                                {{ old('role', $user->role) == 'admin_kecamatan' ? 'selected' : '' }}>
                                                Admin Kecamatan</option>
                                            <option value="kolektor"
                                                {{ old('role', $user->role) == 'kolektor' ? 'selected' : '' }}>
                                                Kolektor</option>
                                        </select>
                                        @error('role')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- PLOTTING TEMPAT --}}
                                <div class="pilih-wilayah mt-3" id="plotting-container"
                                    style="display: {{ in_array(old('role', $user->role), ['kolektor', 'admin_kecamatan']) ? 'block' : 'none' }};">
                                    <h5 class="text-dark">
                                        <li>Pilih Wilayah</li>
                                    </h5>
                                    <hr>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="id_kecamatan" class="form-label">Kecamatan</label>
                                            <select name="id_kecamatan" id="id_kecamatan" class="form-control select2"
                                                {{ in_array(old('role', $user->role), ['kolektor', 'admin_kecamatan']) ? 'required' : '' }}>
                                                <option value="">-- Pilih Kecamatan --</option>
                                                @foreach ($kecamatan as $kec)
                                                    <option value="{{ $kec->id }}"
                                                        {{ old('id_kecamatan', $pilihKec) == $kec->id ? 'selected' : '' }}>
                                                        {{ $kec->nama_kecamatan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_kecamatan')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6" id="kelurahan-container"
                                            style="display: {{ old('role', $user->role) == 'kolektor' ? 'block' : 'none' }};">
                                            <label for="id_kelurahan" class="form-label">Kelurahan</label>
                                            <select name="id_kelurahan" id="id_kelurahan" class="form-control select2"
                                                {{ old('role', $user->role) == 'kolektor' ? 'required' : '' }}>
                                                <option value="">-- Pilih Kelurahan --</option>
                                                @if ($kelurahan)
                                                    @foreach ($kelurahan as $kel)
                                                        <option value="{{ $kel->id }}"
                                                            {{ old('id_kelurahan', $pilihKel) == $kel->id ? 'selected' : '' }}>
                                                            {{ $kel->nama_kelurahan }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('id_kelurahan')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-2" id="rw-rt-section"
                                        style="display: {{ old('role', $user->role) == 'kolektor' ? 'block' : 'none' }};">
                                        <div class="col-md-12">
                                            <label class="form-label">RT / RW</label>
                                            <div class="rt-rw-container">
                                                @if ($rts && $rws)
                                                    @foreach ($rts as $i => $rt)
                                                        <div class="d-flex gap-2 align-items-end rt-rw-item"
                                                            data-index="{{ $i }}">
                                                            <div class="flex-fill">
                                                                <label>RT</label>
                                                                <input type="text" name="rt[]"
                                                                    class="form-control"
                                                                    value="{{ old('rt.' . $i, $rt) }}"
                                                                    placeholder="Masukkan RT" pattern="[0-9]{1,3}"
                                                                    {{ old('role', $user->role) == 'kolektor' ? 'required' : '' }}>
                                                            </div>
                                                            <div class="flex-fill">
                                                                <label>RW</label>
                                                                <input type="text" name="rw[]"
                                                                    class="form-control"
                                                                    value="{{ old('rw.' . $i, $rws[$i] ?? '') }}"
                                                                    placeholder="Masukkan RW" pattern="[0-9]{1,3}"
                                                                    {{ old('role', $user->role) == 'kolektor' ? 'required' : '' }}>
                                                            </div>
                                                            <button type="button"
                                                                class="btn btn-danger remove-rt-rw mt-2">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="d-flex gap-2 align-items-end rt-rw-item"
                                                        data-index="0">
                                                        <div class="flex-fill">
                                                            <label>RT</label>
                                                            <input type="text" name="rt[]" class="form-control"
                                                                placeholder="Masukkan RT" pattern="[0-9]{1,3}"
                                                                {{ old('role', $user->role) == 'kolektor' ? 'required' : '' }}>
                                                        </div>
                                                        <div class="flex-fill">
                                                            <label>RW</label>
                                                            <input type="text" name="rw[]" class="form-control"
                                                                placeholder="Masukkan RW" pattern="[0-9]{1,3}"
                                                                {{ old('role', $user->role) == 'kolektor' ? 'required' : '' }}>
                                                        </div>
                                                        <button type="button"
                                                            class="btn btn-danger remove-rt-rw mt-2">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                            <button type="button" class="btn btn-primary mt-2" id="addRtRw">
                                                <i class="fas fa-plus"></i> Tambah RT/RW
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary mr-2">
                                    <i class="fa-solid fa-floppy-disk"></i> Save
                                </button>
                                <a href="{{ route('superadmin.master.user') }}" class="btn btn-secondary mr-2">
                                    <i class="fa-solid fa-backward"></i> Kembali
                                </a>
                            </div>
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

                // Validasi input no_hp
                $('#no_hp').on('input', function() {
                    let value = $(this).val();
                    // Hanya izinkan angka dan tanda + di awal
                    value = value.replace(/[^0-9+]/g, '');
                    // Pastikan tanda + hanya di awal
                    if (value.indexOf('+') > 0) {
                        value = '+' + value.replace(/\+/g, '');
                    }
                    $(this).val(value);
                });

                function togglePlottingByRole() {
                    const role = $('#role').val();
                    console.log('Role selected:', role);
                    if (role === 'admin_kecamatan' || role === 'kolektor') {
                        $('#plotting-container').show();
                        $('#id_kecamatan').prop('required', true);

                        if (role === 'admin_kecamatan') {
                            $('#kelurahan-container').hide();
                            $('#rw-rt-section').hide();
                            $('#id_kelurahan').val('').trigger('change');
                            $('#id_kelurahan').prop('required', false);
                            $('.rt-rw-container').empty();
                        } else if (role === 'kolektor') {
                            $('#kelurahan-container').show();
                            $('#rw-rt-section').show();
                            $('#id_kelurahan').prop('required', true);
                            $('.rt-rw-container input[name="rt[]"]').prop('required', true);
                            $('.rt-rw-container input[name="rw[]"]').prop('required', true);
                        }
                    } else {
                        $('#plotting-container').hide();
                        $('#id_kecamatan').val('').trigger('change');
                        $('#id_kelurahan').val('').trigger('change');
                        $('.rt-rw-container').empty();
                        $('#id_kecamatan').prop('required', false);
                        $('#id_kelurahan').prop('required', false);
                    }

                    if (role === 'kolektor') {
                        $('#id_kecamatan').trigger('change');
                    }
                }

                $('#role').on('change', togglePlottingByRole);
                togglePlottingByRole();

                $('.select2').select2({
                    placeholder: '-- Pilih --',
                    allowClear: true,
                    width: '100%'
                });

                $('#id_kecamatan').on('select2:select', function(e) {
                    console.log('Kecamatan dipilih:', e.params.data.id);
                });

                function generateRtRwInput(index, oldRt = '', oldRw = '') {
                    return `
            <div class="d-flex gap-2 align-items-end rt-rw-item" data-index="${index}">
                <div class="flex-fill">
                    <label>RT</label>
                    <input type="text" name="rt[]" class="form-control mb-2" value="${oldRt}" 
                        placeholder="Masukkan RT" pattern="[0-9]{1,3}" 
                        ${$('#role').val() === 'kolektor' ? 'required' : ''}>
                </div>
                <div class="flex-fill">
                    <label>RW</label>
                    <input type="text" name="rw[]" class="form-control mb-2" value="${oldRw}" 
                        placeholder="Masukkan RW" pattern="[0-9]{1,3}" 
                        ${$('#role').val() === 'kolektor' ? 'required' : ''}>
                </div>
                <button type="button" class="btn btn-danger mb-2 remove-rt-rw mt-2">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
                }

                $(document).on('click', '#addRtRw', function() {
                    const index = $('.rt-rw-item').length;
                    $('.rt-rw-container').append(generateRtRwInput(index));
                });

                $(document).on('click', '.remove-rt-rw', function() {
                    $(this).closest('.rt-rw-item').remove();
                });

                $('#id_kecamatan').on('change', function() {
                    const kecamatanId = $(this).val();
                    const $kelurahanSelect = $('#id_kelurahan');
                    $kelurahanSelect.empty().append('<option value="">-- Pilih Kelurahan --</option>');

                    const role = $('#role').val();
                    console.log('Kecamatan changed:', kecamatanId, 'Role:', role);
                    if (!kecamatanId || role !== 'kolektor') {
                        $kelurahanSelect.val('').trigger('change');
                        $('.rt-rw-container').empty();
                        return;
                    }

                    $.ajax({
                        url: '{{ route('superadmin.master.user.getKelurahan') }}',
                        type: 'POST',
                        data: {
                            id_kecamatan: kecamatanId
                        },
                        success: function(data) {
                            console.log('Kelurahan loaded:', data);
                            data.forEach(function(kelurahan) {
                                const isSelected = '{{ $pilihKel }}' == kelurahan.id ?
                                    'selected' : '';
                                $kelurahanSelect.append(
                                    `<option value="${kelurahan.id}" ${isSelected}>${kelurahan.nama_kelurahan}</option>`
                                );
                            });
                            $kelurahanSelect.trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Error fetching kelurahan:', xhr.responseText);
                            alert('Gagal mengambil data kelurahan: ' + xhr.status + ' ' + xhr
                                .statusText);
                        }
                    });
                });

                $('#id_kelurahan').on('change', function() {
                    const role = $('#role').val();
                    if (role !== 'kolektor') return;

                    const kelurahanId = $(this).val();
                    const $container = $('.rt-rw-container');
                    $container.empty();

                    if (kelurahanId) {
                        const kelName = $('#id_kelurahan option[value="' + kelurahanId + '"]').text();
                        const rts = @json($rts ?? []) || [];
                        const rws = @json($rws ?? []) || [];

                        console.log('RT/RW data:', {
                            rts,
                            rws
                        });

                        let inputs = '';
                        if (rts.length > 0) {
                            rts.forEach((rt, i) => {
                                inputs += generateRtRwInput(i, rt, rws[i] || '');
                            });
                        } else {
                            inputs = generateRtRwInput(0);
                        }

                        $container.append(`
                <h6 class="mt-2">RT / RW untuk ${kelName}</h6>
                ${inputs}
            `);
                    }
                });

                $('form').on('submit', function(e) {
                    const role = $('#role').val();
                    if (role === 'admin_kecamatan') {
                        $('#id_kelurahan').prop('disabled', true);
                        $('.rt-rw-container input[name="rt[]"]').prop('disabled', true);
                        $('.rt-rw-container input[name="rw[]"]').prop('disabled', true);
                        $('#id_kecamatan').prop('disabled', false);
                    }
                    console.log('Form data yang dikirim:', $(this).serialize());
                });

                $('#id_kecamatan').trigger('change');
            });
        </script>
    @endpush

</x-utama.layout.main>
