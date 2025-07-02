<x-utama.layout.main title="Identitas Petugas">

    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4>

            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-pills flex-column flex-md-row mb-3">
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i>
                                Account</a>
                        </li>
                    </ul>
                    <div class="card mb-4">
                        <h5 class="card-header">Profile Details</h5>
                        <!-- Account -->
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src="../assets/img/avatars/1.png" alt="user-avatar" class="d-block rounded"
                                    height="100" width="100" id="uploadedAvatar" />
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Upload new photo</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input type="file" id="upload" class="account-file-input" hidden
                                            accept="image/png, image/jpeg" />
                                    </label>
                                    <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                        <i class="bx bx-reset d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Reset</span>
                                    </button>

                                    <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                                </div>
                            </div>
                        </div>
                        <hr class="my-0" />
                        <div class="card-body">
                            <form id="formAccountSettings" method="POST" onsubmit="return false">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control mt-2 mb-2" id="nama_lengkap"
                                            name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                        <select class="form-control mt-2 mb-2" id="jenis_kelamin" name="jenis_kelamin"
                                            required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki"
                                                {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                            </option>
                                            <option value="Perempuan"
                                                {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="tempat" class="form-label">Tempat Lahir</label>
                                        <input type="text" class="form-control mt-2 mb-2" id="tempat"
                                            name="tempat" value="{{ old('tempat') }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="tgllahir" class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control mt-2 mb-2" id="tgllahir"
                                            name="tgllahir" value="{{ old('tgllahir') }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="id_kecamatan" class="form-label">Kecamatan</label>
                                        <select class="form-control mt-2 mb-2" id="id_kecamatan" name="id_kecamatan"
                                            required>
                                            <option value="">Pilih Kecamatan</option>
                                            @foreach ($kecamatans as $kecamatan)
                                                <option value="{{ $kecamatan->id }}"
                                                    {{ old('id_kecamatan') == $kecamatan->id ? 'selected' : '' }}>
                                                    {{ $kecamatan->nama_kecamatan }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="id_kelurahan" class="form-label">Kelurahan</label>
                                        <select class="form-control mt-2 mb-2" id="id_kelurahan" name="id_kelurahan"
                                            required>
                                            <option value="">Pilih Kelurahan</option>
                                            <!-- Kelurahan diisi via AJAX -->
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="Rw" class="form-label">RW</label>
                                        <input type="text" class="form-control mt-2 mb-2" id="Rw"
                                            name="Rw" value="{{ old('Rw') }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="Rt" class="form-label">RT</label>
                                        <input type="text" class="form-control mt-2 mb-2" id="Rt"
                                            name="Rt" value="{{ old('Rt') }}" required>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="alamat" class="form-label">Alamat Lengkap</label>
                                        <textarea class="form-control mt-2 mb-2" id="alamat" cols="10" rows="5" name="alamat" required>{{ old('alamat') }}</textarea>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                    <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                                </div>
                            </form>
                        </div>
                        <!-- /Account -->
                    </div>
                    <div class="card">
                        <h5 class="card-header">Delete Account</h5>
                        <div class="card-body">
                            <div class="mb-3 col-12 mb-0">
                                <div class="alert alert-warning">
                                    <h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete your
                                        account?</h6>
                                    <p class="mb-0">Once you delete your account, there is no going back. Please be
                                        certain.</p>
                                </div>
                            </div>
                            <form id="formAccountDeactivation" onsubmit="return false">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="accountActivation"
                                        id="accountActivation" />
                                    <label class="form-check-label" for="accountActivation">I confirm my account
                                        deactivation</label>
                                </div>
                                <button type="submit" class="btn btn-danger deactivate-account">Deactivate
                                    Account</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('css')
        <style>
            /* Alert */
            .swal2-container {
                z-index: 9999 !important;
            }
        </style>
    @endpush

    @push('js')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#id_kecamatan').change(function() {
                    var kecamatanId = $(this).val();
                    if (kecamatanId) {
                        $.ajax({
                            url: '{{ route('petugas.getKelurahan') }}',
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
