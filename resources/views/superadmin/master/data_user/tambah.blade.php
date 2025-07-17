<x-utama.layout.main title="Superadmin | Master User">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card-title">
                    <h5 style="margin-bottom: 20px"><strong>Data User</strong></h5>
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
                                    <div class="form-group">
                                        <label for="">Password</label>
                                        <input type="password"
                                            class="form-control mt-2 mb-2 @error('password') is-invalid @enderror"
                                            name="password" id="password">
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
                            </div>
                            <button type="submit" class="btn btn-primary mt-3 mr-2">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('css')
    @endpush

    @push('js')
    @endpush

</x-utama.layout.main>
