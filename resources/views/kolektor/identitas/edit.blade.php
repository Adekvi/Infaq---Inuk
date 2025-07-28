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
                        <form id="formAccountSettings"
                            action="{{ url('kolektor/identitas/edit-data/' . $datadiri->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <h5 class="card-header">Update Profil</h5>
                            <!-- Account -->
                            <div class="card-body">
                                <div class="d-flex align-items-start align-items-sm-center gap-4">
                                    <img src="{{ $datadiri->foto ? asset('storage/' . $datadiri->foto) : asset('admin/img/user.webp') }}"
                                        alt="user-avatar" class="d-block rounded" height="105" width="100"
                                        id="uploadedAvatar" />
                                    <div class="button-wrapper">
                                        <label for="foto" class="btn btn-primary me-2 mb-4" tabindex="0">
                                            <span class="d-none d-sm-block">Upload new photo</span>
                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                            <input type="file" id="foto" name="foto"
                                                class="account-file-input" hidden
                                                accept="image/png,image/jpeg,image/jpg" onchange="previewFoto(event)" />
                                        </label>
                                        <button type="button"
                                            class="btn btn-outline-secondary account-image-reset mb-4"
                                            onclick="resetFoto()">
                                            <i class="bx bx-reset d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Reset</span>
                                        </button>
                                        <p class="text-muted mb-0">Ekstensi JPG, JPEG, atau PNG. Maks. ukuran 2 MB</p>
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
                                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control mt-2 mb-2" id="nama_lengkap"
                                                name="nama_lengkap"
                                                value="{{ old('nama_lengkap', $datadiri->nama_lengkap) }}" required>
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
                                                    {{ old('jenis_kelamin', $datadiri->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                                    Laki-laki</option>
                                                <option value="Perempuan"
                                                    {{ old('jenis_kelamin', $datadiri->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                                                    Perempuan</option>
                                            </select>
                                            @error('jenis_kelamin')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tempat" class="form-label">Tempat Lahir</label>
                                            <input type="text" class="form-control mt-2 mb-2" id="tempat"
                                                name="tempat" value="{{ old('tempat', $datadiri->tempat) }}" required>
                                            @error('tempat')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tgllahir" class="form-label">Tanggal Lahir</label>
                                            <input type="date" class="form-control mt-2 mb-2" id="tgllahir"
                                                name="tgllahir" value="{{ old('tgllahir', $datadiri->tgllahir) }}"
                                                required>
                                            @error('tgllahir')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="id_kecamatan" class="form-label">Kecamatan</label>
                                            <select class="form-control mt-2 mb-2" id="id_kecamatan" name="id_kecamatan"
                                                required>
                                                <option value="">Pilih Kecamatan</option>
                                                @foreach ($kecamatan as $kcmt)
                                                    <option value="{{ $kcmt->id }}"
                                                        {{ old('id_kecamatan', $datadiri->id_kecamatan) == $kcmt->id ? 'selected' : '' }}>
                                                        {{ $kcmt->nama_kecamatan }}
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
                                                @foreach ($kelurahan as $klrh)
                                                    <option value="{{ $klrh->id }}"
                                                        {{ old('id_kelurahan', $datadiri->id_kelurahan) == $klrh->id ? 'selected' : '' }}>
                                                        {{ $klrh->nama_kelurahan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_kelurahan')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="Rt" class="form-label">RT</label>
                                            <input type="text" class="form-control mt-2 mb-2" id="Rt"
                                                name="Rt" value="{{ old('Rt', $datadiri->Rt) }}" required>
                                            @error('Rt')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="Rw" class="form-label">RW</label>
                                            <input type="text" class="form-control mt-2 mb-2" id="Rw"
                                                name="Rw" value="{{ old('Rw', $datadiri->Rw) }}" required>
                                            @error('Rw')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12">
                                            <label for="alamat" class="form-label">Alamat Lengkap</label>
                                            <textarea class="form-control mt-2 mb-2" id="alamat" cols="10" rows="5" name="alamat" required>{{ old('alamat', $datadiri->alamat) }}</textarea>
                                            @error('alamat')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary me-2">Simpan</button>
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
                const reader = new FileReader();
                reader.onload = function() {
                    const output = document.getElementById('uploadedAvatar');
                    output.src = reader.result;
                };
                reader.readAsDataURL(event.target.files[0]);
            }

            function resetFoto() {
                document.getElementById('uploadedAvatar').src =
                    "{{ $datadiri->foto ? asset('storage/' . $datadiri->foto) : asset('admin/img/user.webp') }}";
                document.getElementById('foto').value = '';
            }

            // Pilih Bertugas
            $(document).ready(function() {
                // Inisialisasi Select2 untuk kecamatan
                $('#pil_kecamatan').select2({
                    placeholder: '-- Pilih Kecamatan --',
                    allowClear: true,
                    width: '100%'
                });

                // Inisialisasi Select2 untuk kelurahan
                $('#pil_kelurahan').select2({
                    placeholder: '-- Pilih Kelurahan --',
                    allowClear: true,
                    width: '100%'
                });

                // Event saat kecamatan berubah
                $('#pil_kecamatan').on('change', function() {
                    const selectedKecamatans = $(this).val() || [];
                    const $kelurahanSelect = $('#pil_kelurahan');

                    // Kosongkan pilihan kelurahan sebelumnya
                    $kelurahanSelect.empty().select2({
                        data: [{
                            id: '',
                            text: '-- Pilih Kelurahan --'
                        }],
                        placeholder: '-- Pilih Kelurahan --',
                        allowClear: true,
                        width: '100%'
                    });

                    // Kosongkan container RW/RT
                    $('#rw-rt-container').empty();

                    // Jika ada kecamatan yang dipilih, ambil data kelurahan
                    if (selectedKecamatans.length > 0) {
                        const promises = selectedKecamatans.map(kecamatanId =>
                            $.ajax({
                                url: '{{ route('kolektor.getKelurahan') }}',
                                type: 'POST',
                                data: {
                                    id_kecamatan: kecamatanId,
                                    _token: '{{ csrf_token() }}'
                                }
                            })
                        );
                    }
                });
            });
        </script>
    @endpush

</x-utama.layout.main>
