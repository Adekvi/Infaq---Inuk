<x-utama.layout.main title="Update Identitas">

    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengaturan Akun /</span> Pengaturan</h4>

            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-pills flex-column flex-md-row mb-3">
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i>
                                Akun</a>
                        </li>
                    </ul>
                    <div class="card mb-4">
                        <form id="formAccountSettings" action="{{ url('admin_kecamatan/identitas/store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <h5 class="card-header">Update Profil</h5>
                            <!-- Account -->
                            <div class="card-body">
                                <div class="d-flex flex-column flex-sm-row align-items-center gap-3">
                                    <div>
                                        <img src="{{ asset('admin/img/user.webp') }}" alt="Foto Profil"
                                            class="rounded shadow-sm" height="100" width="100"
                                            id="uploadedAvatar" />
                                    </div>
                                    <div class="d-flex flex-column">
                                        <label class="btn btn-primary mb-2">
                                            <span>Upload Foto Baru</span>
                                            <input type="file" name="foto" id="foto" class="d-none"
                                                accept="image/png, image/jpeg, image/jpg"
                                                onchange="previewFoto(event)" />
                                        </label>

                                        <button type="button" class="btn btn-outline-secondary mb-2"
                                            onclick="resetFoto()">
                                            Reset
                                        </button>

                                        <small class="text-muted">Format: JPG, JPEG, PNG. Maks. 2 MB</small>
                                        @error('foto')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-0" />
                            <div class="card-body">
                                <div class="identitas">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="">Username</label>
                                            <input type="text" name="username" id="username"
                                                class="form-control mt-2 mb-2" value="{{ $user->username ?? '-' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Jabatan</label>
                                            <select name="id_setting" id="id_setting" class="form-control mt-2 mb-2">
                                                <option value="">-- Pilih --</option>
                                                @foreach ($setting as $set)
                                                    <option value="{{ $set->id }}">{{ $set->namasetting }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control mt-2 mb-2" id="nama_lengkap"
                                                name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                                                placeholder="Nama Lengkap" required>
                                            @error('nama_lengkap')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                            <select class="form-control mt-2 mb-2" id="jenis_kelamin"
                                                name="jenis_kelamin" required>
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="Laki-laki"
                                                    {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                                    Laki-laki</option>
                                                <option value="Perempuan"
                                                    {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                                    Perempuan</option>
                                            </select>
                                            @error('jenis_kelamin')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="tempat" class="form-label">Tempat Lahir</label>
                                            <input type="text" class="form-control mt-2 mb-2" id="tempat"
                                                name="tempat" value="{{ old('tempat') }}" placeholder="Tempat lahir"
                                                required>
                                            @error('tempat')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="tgllahir" class="form-label">Tanggal Lahir</label>
                                            <input type="date" class="form-control mt-2 mb-2" id="tgllahir"
                                                name="tgllahir" value="{{ old('tgllahir') }}" required>
                                            @error('tgllahir')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="id_kecamatan" class="form-label">Kecamatan</label>
                                            <select class="form-control mt-2 mb-2" id="id_kecamatan"
                                                name="id_kecamatan" required>
                                                <option value="">Pilih Kecamatan</option>
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

                                        <div class="col-md-6">
                                            <label for="id_kelurahan" class="form-label">Kelurahan</label>
                                            <select class="form-control mt-2 mb-2" id="id_kelurahan"
                                                name="id_kelurahan" required>
                                                <option value="">Pilih Kelurahan</option>
                                                <!-- Kelurahan diisi via AJAX -->
                                            </select>
                                            @error('id_kelurahan')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="Rt" class="form-label">RT</label>
                                            <input type="text" class="form-control mt-2 mb-2" id="Rt"
                                                name="Rt" value="{{ old('Rt') }}" placeholder="RT"
                                                required>
                                            @error('Rt')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="Rw" class="form-label">RW</label>
                                            <input type="text" class="form-control mt-2 mb-2" id="Rw"
                                                name="Rw" value="{{ old('Rw') }}" placeholder="RW"
                                                required>
                                            @error('Rw')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-12">
                                            <label for="alamat" class="form-label">Alamat Lengkap</label>
                                            <textarea class="form-control mt-2 mb-2" id="alamat" cols="10" rows="5" name="alamat" required>{{ old('alamat') }}</textarea>
                                            @error('alamat')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <button type="submit" data-bs-toggle="tooltip" title="Simpan"
                                        class="btn btn-primary mt-3 mr-2">
                                        <i class="fa-solid fa-floppy-disk"></i> Simpan
                                    </button>
                                    <a href="{{ route('admin_kecamatan.index') }}" data-bs-toggle="tooltip"
                                        title="Kembali" class="btn btn-secondary mt-3">
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
        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            /* Alert */
            .swal2-container {
                z-index: 9999 !important;
            }
        </style>
    @endpush

    @push('js')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            function previewFoto(event) {
                const input = event.target;
                const reader = new FileReader();

                reader.onload = function() {
                    const avatar = document.getElementById('uploadedAvatar');
                    avatar.src = reader.result;
                };

                if (input.files[0]) {
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function resetFoto() {
                const input = document.getElementById('foto');
                const avatar = document.getElementById('uploadedAvatar');

                input.value = '';
                avatar.src = "{{ asset('admin/img/user.webp') }}";
            }

            // Identitas
            $(document).ready(function() {
                $('#id_kecamatan').change(function() {
                    var kecamatanId = $(this).val();
                    if (kecamatanId) {
                        $.ajax({
                            url: '{{ route('admin_kecamatan.getKelurahan') }}',
                            type: 'POST',
                            data: {
                                id_kecamatan: kecamatanId,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(data) {
                                $('#id_kelurahan').empty();
                                $('#id_kelurahan').append(
                                    '<option value="">Pilih Kelurahan</option>');
                                $.each(data, function(key, value) {
                                    $('#id_kelurahan').append('<option value="' + value.id +
                                        '">' + value.nama_kelurahan + '</option>');
                                });
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal memuat kelurahan!',
                                    text: 'Silakan coba lagi.',
                                    showConfirmButton: true,
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    } else {
                        $('#id_kelurahan').empty();
                        $('#id_kelurahan').append('<option value="">Pilih Kelurahan</option>');
                    }
                });
            });
        </script>
    @endpush

</x-utama.layout.main>
